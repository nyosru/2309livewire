<?php

namespace App\Http\Controllers\Calls;

use App\Http\Controllers\Controller;
use App\Models\Calls\RecordingTag;
use App\Models\Calls\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecorderController extends Controller
{
    private function baseDir(): string
    {
        return '/Volumes/sam1kk/00 запись диктофон';
    }

    public function index(Request $request): View
    {
        $dir = $this->baseDir();
        $items = [];
        $error = null;

        $allTags = Tag::query()->orderBy('name')->get();
        $recordingTags = RecordingTag::query()->with('tag')->get()->groupBy('recording_basename');

        if (! is_dir($dir) || ! is_readable($dir)) {
            $error = 'Папка с записями недоступна: '.$dir;
        } else {
            $files = @scandir($dir) ?: [];
            foreach ($files as $file) {
                if ($file === '.' || $file === '..') {
                    continue;
                }
                $path = $dir.DIRECTORY_SEPARATOR.$file;
                if (! is_file($path)) {
                    continue;
                }
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                if ($ext !== 'mp3') {
                    continue;
                }

                $basename = pathinfo($file, PATHINFO_FILENAME);
                $txtPath = $dir.DIRECTORY_SEPARATOR.$basename.'.txt';
                $summaryPath = $dir.DIRECTORY_SEPARATOR.$basename.'_summary.md';

                $items[] = [
                    'name' => $file,
                    'basename' => $basename,
                    'size' => @filesize($path) ?: 0,
                    'mtime' => @filemtime($path) ?: 0,
                    'has_txt' => is_file($txtPath),
                    'has_summary' => is_file($summaryPath),
                    'text' => is_file($txtPath) ? $this->readText($txtPath) : null,
                    'summary' => is_file($summaryPath) ? $this->readText($summaryPath) : null,
                    'tags' => $recordingTags->get($basename, collect())->pluck('tag')->filter()->values(),
                ];
            }

            usort($items, fn ($a, $b) => strcmp($b['name'], $a['name']));
        }

        return view('calls.index', [
            'items' => $items,
            'error' => $error,
            'dir' => $dir,
            'total' => count($items),
            'allTags' => $allTags,
        ]);
    }

    public function file(string $filename)
    {
        $dir = realpath($this->baseDir());
        if ($dir === false) {
            abort(404);
        }

        $filename = basename($filename);
        $path = $dir.DIRECTORY_SEPARATOR.$filename;
        $real = realpath($path);

        if ($real === false || ! str_starts_with($real, $dir.DIRECTORY_SEPARATOR)) {
            abort(404);
        }
        if (! is_file($real) || ! is_readable($real)) {
            abort(404);
        }

        $ext = strtolower(pathinfo($real, PATHINFO_EXTENSION));
        $allowed = ['mp3', 'txt', 'md'];
        if (! in_array($ext, $allowed, true)) {
            abort(404);
        }

        $mime = match ($ext) {
            'mp3' => 'audio/mpeg',
            'txt' => 'text/plain; charset=UTF-8',
            'md' => 'text/markdown; charset=UTF-8',
            default => 'application/octet-stream',
        };

        return response()->file($real, [
            'Content-Type' => $mime,
        ]);
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
            RecordingTag::query()->firstOrCreate([
                'recording_basename' => $basename,
                'tag_id' => $data['tag_id'],
            ]);
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

    private function readText(string $path, int $maxBytes = 200000): ?string
    {
        $content = @file_get_contents($path, false, null, 0, $maxBytes);
        if ($content === false) {
            return null;
        }
        $content = trim($content);
        if ($content === '') {
            return null;
        }

        return $content;
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
