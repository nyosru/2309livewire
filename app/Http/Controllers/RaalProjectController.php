<?php

namespace App\Http\Controllers;

use App\Models\RaalProject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RaalProjectController extends Controller
{
    public function index(): View
    {
        return view('raal.admin.index', [
            'projects' => RaalProject::query()->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function create(): View
    {
        return view('raal.admin.form', ['project' => new RaalProject]);
    }

    public function store(Request $request): RedirectResponse
    {
        $project = RaalProject::create($this->validatedData($request));

        return redirect()->route('raal.admin.projects.edit', $project)->with('success', 'Проект добавлен.');
    }

    public function edit(RaalProject $project): View
    {
        return view('raal.admin.form', compact('project'));
    }

    public function update(Request $request, RaalProject $project): RedirectResponse
    {
        $previousImages = collect($project->images);
        $data = $this->validatedData($request);

        $project->update($data);
        $this->deleteRemovedManagedImages($previousImages, collect($data['images']));

        return back()->with('success', 'Изменения сохранены.');
    }

    public function toggleVisibility(RaalProject $project): RedirectResponse
    {
        $project->update(['is_active' => ! $project->is_active]);

        $message = $project->is_active
            ? 'Проект включён и показывается на витрине.'
            : 'Проект скрыт с витрины.';

        return back()->with('success', $message);
    }

    public function destroy(RaalProject $project): RedirectResponse
    {
        $this->deleteRemovedManagedImages(collect($project->images), collect());
        $project->delete();

        return redirect()->route('raal.admin.projects.index')->with('success', 'Проект удалён.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'category' => ['nullable', 'string', 'max:120'],
            'location' => ['nullable', 'string', 'max:160'],
            'status' => ['required', 'string', 'max:80'],
            'status_color' => ['required', Rule::in(['lime', 'orange', 'blue'])],
            'description' => ['required', 'string', 'max:3000'],
            'investment_offer' => ['required', 'string', 'max:3000'],
            'existing_images' => ['nullable', 'array', 'max:12'],
            'existing_images.*' => ['required', 'string', 'max:2048'],
            'images_upload' => ['nullable', 'array', 'max:12'],
            'images_upload.*' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:6144', 'dimensions:max_width=8000,max_height=8000'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:100000'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $images = collect($data['existing_images'] ?? [])
            ->map(fn (string $path) => trim($path))
            ->filter()
            ->values();

        $uploads = $request->file('images_upload', []);

        if ($images->count() + count($uploads) > 12) {
            throw ValidationException::withMessages([
                'images_upload' => 'В одном проекте может быть не более 12 фотографий.',
            ]);
        }

        foreach ($uploads as $image) {
            $images->push($this->storeAsJpeg($image));
        }

        unset($data['existing_images'], $data['images_upload']);
        $data['images'] = $images->all();
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function storeAsJpeg(UploadedFile $file): string
    {
        $contents = file_get_contents($file->getRealPath());
        $source = $contents === false ? false : @imagecreatefromstring($contents);

        if ($source === false) {
            throw ValidationException::withMessages([
                'images_upload' => 'Не удалось обработать одну из фотографий.',
            ]);
        }

        $sourceWidth = imagesx($source);
        $sourceHeight = imagesy($source);
        $targetWidth = min(700, $sourceWidth);
        $targetHeight = max(1, (int) round($sourceHeight * ($targetWidth / $sourceWidth)));
        $target = imagecreatetruecolor($targetWidth, $targetHeight);

        $white = imagecolorallocate($target, 255, 255, 255);
        imagefill($target, 0, 0, $white);
        imagecopyresampled(
            $target,
            $source,
            0,
            0,
            0,
            0,
            $targetWidth,
            $targetHeight,
            $sourceWidth,
            $sourceHeight
        );

        ob_start();
        $encoded = imagejpeg($target, null, 86);
        $jpeg = ob_get_clean();
        imagedestroy($target);
        imagedestroy($source);

        if (! $encoded || $jpeg === false) {
            throw ValidationException::withMessages([
                'images_upload' => 'Не удалось сохранить одну из фотографий.',
            ]);
        }

        $path = 'raal/projects/'.Str::uuid().'.jpg';
        Storage::disk('public')->put($path, $jpeg);

        return Storage::disk('public')->url($path);
    }

    private function deleteRemovedManagedImages($previousImages, $currentImages): void
    {
        $previousImages->diff($currentImages)->each(function (string $image): void {
            $path = parse_url($image, PHP_URL_PATH) ?: $image;

            if (! str_starts_with($path, '/storage/raal/projects/')) {
                return;
            }

            Storage::disk('public')->delete(Str::after($path, '/storage/'));
        });
    }
}
