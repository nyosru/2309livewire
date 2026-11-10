<?php

namespace Tests\Feature\Phpcat;

use App\Livewire\Phpcat\RentalSitesList;
use App\Models\PhpcatRentalSite;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class RentalRequestTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:',
            'services.vk.token_order' => 'test-token', 'services.vk.vk_admin_id' => '123']);
        (require database_path('migrations/2026_10_31_000001_create_phpcat_rental_sites_table.php'))->up();
        (require database_path('migrations/2026_10_31_000002_rename_phpcat_rental_sites_working_flag.php'))->up();
        Http::fake(['api.vk.com/*' => Http::response(['response' => 1])]);
    }

    private function form()
    {
        return Livewire::test(RentalSitesList::class)
            ->call('openRental', PhpcatRentalSite::where('is_rented', false)->firstOrFail()->id)
            ->set('phone', '+7 (999) 123-45-67')
            ->set('message', 'Хочу арендовать сайт');
    }

    public function test_request_contains_selected_site_and_is_sent_only_once(): void
    {
        $site = PhpcatRentalSite::where('is_rented', false)->firstOrFail();
        $this->form()->call('submit')->assertHasNoErrors()->assertSet('sent', true)->call('submit');
        Http::assertSentCount(1);
        Http::assertSent(fn ($request) => $request['user_id'] === '123'
            && str_contains($request['message'], $site->url())
            && str_contains($request['message'], '+7 (999) 123-45-67')
            && str_contains($request['message'], 'Хочу арендовать сайт'));
    }

    public function test_invalid_phone_and_empty_message_are_rejected(): void
    {
        $this->form()->set('phone', '----------')->set('message', '')->call('submit')
            ->assertHasErrors(['phone', 'message'])->assertSet('sent', false);
        Http::assertNothingSent();
    }

    public function test_site_rented_after_opening_cannot_receive_request(): void
    {
        $form = $this->form();
        PhpcatRentalSite::where('is_rented', false)->update(['is_rented' => true]);
        $form->call('submit')->assertHasErrors('form')->assertSet('sent', false);
        Http::assertNothingSent();
    }

    public function test_hidden_site_cannot_receive_request(): void
    {
        $form = $this->form();
        PhpcatRentalSite::query()->update(['is_visible' => false]);
        $form->call('submit')->assertHasErrors('form');
        Http::assertNothingSent();
    }

    public function test_vk_failure_preserves_input_for_retry(): void
    {
        Http::swap(new \Illuminate\Http\Client\Factory);
        Http::fake(['api.vk.com/*' => Http::response(['error' => ['error_msg' => 'Unavailable']])]);
        $this->form()->call('submit')->assertHasErrors('form')->assertSet('sent', false)
            ->assertSet('phone', '+7 (999) 123-45-67')->assertSet('message', 'Хочу арендовать сайт');
    }

    public function test_buttons_are_only_rendered_for_available_sites(): void
    {
        $component = Livewire::test(RentalSitesList::class);
        foreach (PhpcatRentalSite::all() as $site) {
            $button = 'wire:click="openRental('.$site->id.')"';
            if ($site->is_rented) {
                $component->assertDontSeeHtml($button);
            } else {
                $component->assertSeeHtml($button);
            }
        }
    }
}
