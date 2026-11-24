<?php

namespace App\Http\Controllers\Calls;

use App\Http\Controllers\Controller;
use App\Models\Calls\Branch;
use App\Models\Calls\Contact;
use App\Models\Calls\RecordingBranch;
use App\Models\Calls\RecordingTag;
use App\Models\Calls\RecordingStatus;
use App\Models\Calls\Tag;
use App\Services\Calls\RecordingLibrary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RecorderController extends Controller
{
    public function storeContact(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'phone' => ['required', 'string', 'max:64'],
            'name' => ['required', 'string', 'max:255'],
            'comments' => ['nullable', 'array', 'max:20'],
            'comments.*' => ['nullable', 'string', 'max:10000'],
        ]);
        $normalized = $this->normalizePhone($data['phone']);
        abort_if($normalized === null, 422, 'Неверный номер телефона.');
        if (Contact::query()->where('phone_normalized', $normalized)->exists()) {
            return redirect()->route('calls.index')->withErrors(['phone' => 'Для этого телефона уже указан владелец.']);
        }

        DB::transaction(function () use ($data, $normalized) {
            $contact = Contact::query()->create([
                'phone' => trim($data['phone']),
                'phone_normalized' => $normalized,
                'name' => trim($data['name']),
            ]);
            foreach ($data['comments'] ?? [] as $comment) {
                if (trim($comment) !== '') {
                    $contact->comments()->create(['body' => trim($comment)]);
                }
            }
        });

        return redirect()->route('calls.index')->with('status', 'Контакт добавлен в телефонную книгу.');
    }

    private function normalizePhone(string $phone): ?string
    {
        $digits = preg_replace('/\D+/', '', $phone);
        if (strlen($digits) === 10) {
            return '7'.$digits;
        }
        if (strlen($digits) === 11 && $digits[0] === '8') {
            return '7'.substr($digits, 1);
        }

        return strlen($digits) >= 10 ? $digits : null;
    }

    public function index(Request $request, RecordingLibrary $library): View
    {
        $catalog = $library->scan();
        $allTags = Tag::query()->orderBy('name')->get();
        $tags = RecordingTag::query()->with('tag')->get()->groupBy('recording_basename');
        $assignments = RecordingBranch::query()->pluck('branch_id', 'recording_key');
        $recordingStatuses = RecordingStatus::query()->pluck('status', 'recording_key');
        $branches = Branch::query()->orderBy('id')->get();
        $branchesById = $branches->keyBy('id');
        $recentBranchIds = RecordingBranch::query()->orderByDesc('updated_at')->pluck('branch_id')->unique()->take(5)->values();
        $recentBranches = Branch::query()->whereIn('id', $recentBranchIds)->get()
            ->sortBy(fn ($branch) => $recentBranchIds->search($branch->id))->values();
        $recentTags = RecordingTag::query()->with('tag')->orderByDesc('updated_at')->get()
            ->pluck('tag')->filter()->unique('id')->take(5)->values();
        $knownContacts = Contact::query()->get()->keyBy('phone_normalized');
        $byBranch = [];
        $unassigned = [];
        $statusItems = [];
        $visibleTotal = 0;
        $listMode = in_array($request->query('list'), ['hidden', 'spam'], true) ? $request->query('list') : 'ordinary';
        $search = mb_substr(trim((string) $request->query('q', '')), 0, 150);
        $source = in_array($request->query('source'), ['call', 'recorder'], true) ? $request->query('source') : '';
        foreach ($catalog['items'] as $key => $item) {
            $phoneSuffix = substr($item['basename'], -11);
            $item['phone'] = preg_match('/\A7\d{10}\z/', $phoneSuffix)
                ? '8-'.substr($phoneSuffix, 1, 3).'-'.substr($phoneSuffix, 4, 3).'-'.substr($phoneSuffix, 7, 2).'-'.substr($phoneSuffix, 9, 2)
                : null;
            $normalizedPhone = $item['phone'] ? $this->normalizePhone($item['phone']) : null;
            $item['contact'] = $normalizedPhone ? $knownContacts->get($normalizedPhone) : null;
            $item['tags'] = $tags->get($item['tag_key'], collect())->pluck('tag')->filter()->values();
            $item['branch_id'] = $assignments->get($key);
            $item['branch'] = $branchesById->get($item['branch_id']);
            $item['status'] = $recordingStatuses->get($key);
            if ($item['status']) {
                if ($item['status'] === $listMode
                    && ($source === '' || $item['source'] === $source)
                    && ($search === '' || mb_stripos($item['path'], $search) !== false)) {
                    $statusItems[] = $item;
                }
                continue;
            }
            $visibleTotal++;
            if ($item['branch_id']) {
                $byBranch[$item['branch_id']][] = $item;
            } elseif (($source === '' || $item['source'] === $source)
                && ($search === '' || mb_stripos($item['path'], $search) !== false)) {
                $unassigned[] = $item;
            }
        }
        $page = max(1, (int) $request->query('page', 1));
        $listRecords = $listMode === 'ordinary' ? $unassigned : $statusItems;
        $items = new LengthAwarePaginator(array_slice($listRecords, ($page - 1) * 20, 20), count($listRecords), 20, $page, [
            'path' => route('calls.index'), 'query' => array_merge($request->query(), ['list' => $listMode]),
        ]);

        return view('calls.index', [
            'items' => $items, 'errorsList' => $catalog['errors'],
            'total' => $visibleTotal, 'assignedCount' => array_sum(array_map('count', $byBranch)),
            'allTags' => $allTags, 'branches' => $branches,
            'recentBranches' => $recentBranches, 'recentTags' => $recentTags,
            'children' => $branches->groupBy(fn ($branch) => $branch->parent_id ?? 'root'),
            'byBranch' => $byBranch, 'search' => $search, 'source' => $source,
            'listMode' => $listMode,
        ]);
    }

    public function updateRecordingStatus(Request $request, string $key, RecordingLibrary $library): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        abort_unless(preg_match('/\A[a-f0-9]{64}\z/', $key), 404);
        abort_unless(isset($library->scan()['items'][$key]), 404);
        $data = $request->validate(['status' => ['nullable', 'in:hidden,spam']]);
        if ($data['status'] ?? null) {
            RecordingStatus::query()->updateOrCreate(['recording_key' => $key], ['status' => $data['status']]);
        } else {
            RecordingStatus::query()->where('recording_key', $key)->delete();
        }
        if ($request->expectsJson()) {
            return response()->json(['recording_key' => $key, 'status' => $data['status'] ?? null]);
        }

        return redirect()->route('calls.index', ['list' => $request->input('return_list', 'ordinary')]);
    }

    public function file(string $filename, RecordingLibrary $library)
    {
        return $this->audioFile('recorder', $filename, $library);
    }

    public function audioFile(string $source, string $filename, RecordingLibrary $library)
    {
        $real = $library->resolve($source, $filename);
        abort_if($real === null, 404);
        $ext = strtolower(pathinfo($real, PATHINFO_EXTENSION));
        abort_unless(in_array($ext, ['mp3', 'txt', 'md'], true), 404);

        return response()->file($real, [
            'Content-Type' => match ($ext) {
                'mp3' => 'audio/mpeg',
                'txt' => 'text/plain; charset=UTF-8',
                'md' => 'text/markdown; charset=UTF-8',
            },
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function storeBranch(Request $request): RedirectResponse
    {
        $data = $this->branchData($request);
        $request->validate(['parent_id' => ['required', 'integer', 'exists:calls_branches,id']]);
        $branch = Branch::query()->create($data + ['parent_id' => $request->integer('parent_id')]);

        return redirect()->to(route('calls.index').'#branch-'.$branch->id)->with('status', 'Ветка создана.');
    }

    public function updateBranch(Request $request, Branch $branch): RedirectResponse
    {
        $branch->update($this->branchData($request));

        return redirect()->to(route('calls.index').'#branch-'.$branch->id)->with('status', 'Ветка сохранена.');
    }

    private function branchData(Request $request): array
    {
        $request->merge(array_map(fn ($value) => is_string($value) ? trim($value) : $value, $request->only('name', 'type', 'project')));

        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'type' => ['required', 'string', 'max:100'],
            'project' => ['required', 'string', 'max:150'],
        ]);
    }

    public function assignBranch(Request $request, string $key, RecordingLibrary $library): RedirectResponse
    {
        abort_unless(preg_match('/\A[a-f0-9]{64}\z/', $key), 404);
        $data = $request->validate(['branch_id' => ['nullable', 'integer', 'exists:calls_branches,id']]);
        abort_unless(isset($library->scan()['items'][$key]), 404);
        if (! empty($data['branch_id'])) {
            RecordingBranch::query()->updateOrCreate(['recording_key' => $key], ['branch_id' => $data['branch_id']]);
        } else {
            RecordingBranch::query()->where('recording_key', $key)->delete();
        }

        return redirect()->to(route('calls.index').(! empty($data['branch_id']) ? '#branch-'.$data['branch_id'] : '#inbox'))
            ->with('status', empty($data['branch_id']) ? 'Запись возвращена в общий список.' : 'Запись прикреплена к ветке.');
    }

    public function storeTag(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ]);

        $name = trim($data['name']);
        if ($name !== '' && ! Tag::query()->where('name', $name)->exists()) {
            Tag::query()->create(['name' => $name]);
        }

        return redirect()->route('calls.index');
    }

    public function updateTag(Request $request, Tag $tag): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ]);

        $name = trim($data['name']);
        if ($name !== '') {
            $exists = Tag::query()->where('name', $name)->where('id', '!=', $tag->id)->exists();
            if (! $exists) {
                $tag->update(['name' => $name]);
            }
        }

        return redirect()->route('calls.index');
    }

    public function destroyTag(Tag $tag): RedirectResponse
    {
        $tag->delete();

        return redirect()->route('calls.index');
    }

    public function attachTag(Request $request, string $basename): RedirectResponse
    {
        $basename = $this->sanitizeBasename($basename);
        $data = $request->validate([
            'tag_id' => ['required', 'integer', 'exists:calls_tags,id'],
        ]);

        if ($basename !== '') {
            RecordingTag::query()->updateOrCreate([
                'recording_basename' => $basename,
                'tag_id' => $data['tag_id'],
            ], []);
        }

        return redirect()->to(route('calls.index').'#rec-'.$basename);
    }

    public function detachTag(string $basename, Tag $tag): RedirectResponse
    {
        $basename = $this->sanitizeBasename($basename);
        if ($basename !== '') {
            RecordingTag::query()
                ->where('recording_basename', $basename)
                ->where('tag_id', $tag->id)
                ->delete();
        }

        return redirect()->to(route('calls.index').'#rec-'.$basename);
    }

    private function sanitizeBasename(string $basename): string
    {
        $basename = basename($basename);
        if (! preg_match('/\A[A-Za-z0-9._-]+\z/', $basename)) {
            return '';
        }

        return $basename;
    }
}
