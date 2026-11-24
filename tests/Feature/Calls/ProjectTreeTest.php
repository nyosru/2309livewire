<?php

namespace Tests\Feature\Calls;

use App\Models\Calls\Branch;
use App\Models\Calls\RecordingBranch;
use App\Services\Calls\RecordingLibrary;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ProjectTreeTest extends TestCase
{
    private string $directory;

    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        (require database_path('migrations/2026_11_16_000001_create_calls_tags_tables.php'))->up();
        (require database_path('migrations/2026_11_19_000001_create_calls_branches_tables.php'))->up();
        $this->directory = sys_get_temp_dir().'/calls-tree-'.bin2hex(random_bytes(8));
        File::makeDirectory($this->directory.'/calls/2026-11-01', 0755, true);
        File::makeDirectory($this->directory.'/calls/2026-11-18', 0755, true);
        File::makeDirectory($this->directory.'/recorder', 0755, true);
        file_put_contents($this->directory.'/calls/2026-11-01/Одинаковое имя .mp3', 'old audio');
        file_put_contents($this->directory.'/calls/2026-11-18/Одинаковое имя .mp3', 'new audio');
        file_put_contents($this->directory.'/calls/2026-11-18/Одинаковое имя -summary.md', 'Описание');
        file_put_contents($this->directory.'/recorder/AC690000.MP3', 'recorder audio');
        file_put_contents($this->directory.'/secret.txt', 'outside');
        config(['calls.sources' => ['call' => $this->directory.'/calls', 'recorder' => $this->directory.'/recorder']]);
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->directory);
        parent::tearDown();
    }

    public function test_catalog_distinguishes_repeated_filenames_and_orders_by_recording_date(): void
    {
        $items = app(RecordingLibrary::class)->scan()['items'];
        $this->assertCount(3, $items);
        $calls = array_values(array_filter($items, fn ($item) => $item['source'] === 'call'));
        $this->assertStringStartsWith('2026-11-18/', $calls[0]['path']);
        $this->assertStringStartsWith('2026-11-01/', $calls[1]['path']);
        $this->assertNotSame($calls[0]['key'], $calls[1]['key']);
        $this->assertNotNull($calls[0]['summary_path']);
        $this->get('https://calls.local/')->assertOk()->assertSee('Базовая')->assertSee('Диктофон');
    }

    public function test_nested_branches_and_assignment_move_and_detachment_persist(): void
    {
        $root = Branch::firstOrFail();
        $this->post('https://calls.local/branches', [
            'parent_id' => $root->id, 'name' => 'Сайт', 'type' => 'Разработка', 'project' => 'Клиент',
        ])->assertRedirect();
        $child = Branch::where('name', 'Сайт')->firstOrFail();
        $this->post('https://calls.local/branches', [
            'parent_id' => $child->id, 'name' => 'Дизайн', 'type' => 'Задача', 'project' => 'Клиент',
        ])->assertRedirect();
        $leaf = Branch::where('name', 'Дизайн')->firstOrFail();
        $this->assertEquals($child->id, $leaf->parent_id);
        $items = app(RecordingLibrary::class)->scan()['items'];
        $keys = array_keys($items);
        foreach ($keys as $key) {
            $this->put('https://calls.local/recordings/'.$key.'/branch', ['branch_id' => $child->id])->assertRedirect();
        }
        $this->get('https://calls.local/')->assertOk()
            ->assertViewHas('items', fn ($items) => $items->total() === 0)
            ->assertViewHas('byBranch', fn ($groups) => count($groups[$child->id]) === 3);
        $this->put('https://calls.local/recordings/'.$keys[0].'/branch', ['branch_id' => $leaf->id])->assertRedirect();
        $this->assertEquals($leaf->id, RecordingBranch::where('recording_key', $keys[0])->value('branch_id'));
        $this->assertSame(3, RecordingBranch::count());
        $this->put('https://calls.local/recordings/'.$keys[0].'/branch', ['branch_id' => ''])->assertRedirect();
        $this->get('https://calls.local/')->assertViewHas('items', fn ($items) => $items->total() === 1);
        $this->put('https://calls.local/branches/'.$child->id, ['name' => 'Обновлено', 'type' => 'Проект', 'project' => 'Клиент'])->assertRedirect();
        $this->assertSame('Обновлено', $child->fresh()->name);
    }

    public function test_invalid_branches_and_unknown_recordings_are_rejected(): void
    {
        $this->postJson('https://calls.local/branches', ['name' => ' ', 'type' => 'Тип', 'project' => 'Проект', 'parent_id' => 999])
            ->assertUnprocessable();
        $key = array_key_first(app(RecordingLibrary::class)->scan()['items']);
        $this->putJson('https://calls.local/recordings/'.$key.'/branch', ['branch_id' => 999])->assertUnprocessable();
        $this->put('https://calls.local/recordings/'.str_repeat('a', 64).'/branch', ['branch_id' => Branch::first()->id])->assertNotFound();
        $this->assertSame(0, RecordingBranch::count());
    }

    public function test_files_support_cyrillic_paths_ranges_and_block_directory_escape(): void
    {
        $url = 'https://calls.local/audio/call/2026-11-18/'.rawurlencode('Одинаковое имя .mp3');
        $this->get($url)->assertOk()->assertHeader('Content-Type', 'audio/mpeg');
        $this->get($url, ['Range' => 'bytes=0-2'])->assertStatus(206);
        $this->get('https://calls.local/audio/call/../secret.txt')->assertNotFound();
        symlink($this->directory.'/secret.txt', $this->directory.'/calls/link.txt');
        $this->get('https://calls.local/audio/call/link.txt')->assertNotFound();
        $this->get('https://calls.local/audio/unknown/anything.mp3')->assertNotFound();
    }

    public function test_existing_recorder_tags_and_call_tags_are_independent(): void
    {
        $this->post('https://calls.local/tags', ['name' => 'Важное'])->assertRedirect();
        $tag = \App\Models\Calls\Tag::firstOrFail();
        $this->post('https://calls.local/recordings/AC690000/tags', ['tag_id' => $tag->id])->assertRedirect();
        $items = app(RecordingLibrary::class)->scan()['items'];
        $call = collect($items)->firstWhere('source', 'call');
        $this->post('https://calls.local/recordings/'.$call['key'].'/tags', ['tag_id' => $tag->id])->assertRedirect();
        $this->get('https://calls.local/')->assertOk()->assertViewHas('items', function ($items) {
            $tagged = collect($items->items())->filter(fn ($item) => $item['tags']->count() === 1);

            return $tagged->count() === 2;
        });
        $this->delete('https://calls.local/recordings/'.$call['key'].'/tags/'.$tag->id)->assertRedirect();
        $this->assertSame(1, \App\Models\Calls\RecordingTag::count());
    }

    public function test_source_filters_and_unavailable_directory_leave_other_source_working(): void
    {
        $this->get('https://calls.local/?source=call&q=2026-11-18')->assertOk()
            ->assertViewHas('items', fn ($items) => $items->total() === 1);
        config(['calls.sources.call' => $this->directory.'/missing']);
        $this->get('https://calls.local/')->assertOk()->assertSee('Папка звонков недоступна')
            ->assertViewHas('total', 1);
    }
}
