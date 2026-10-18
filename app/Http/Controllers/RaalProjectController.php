<?php

namespace App\Http\Controllers;

use App\Models\RaalProject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
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
        $project->update($this->validatedData($request));

        return back()->with('success', 'Изменения сохранены.');
    }

    public function destroy(RaalProject $project): RedirectResponse
    {
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
            'image_urls' => ['nullable', 'string', 'max:10000'],
            'images_upload' => ['nullable', 'array', 'max:12'],
            'images_upload.*' => ['nullable', 'image', 'max:6144'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:100000'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $images = collect(preg_split('/\R/', (string) ($data['image_urls'] ?? '')))
            ->map(fn (string $path) => trim($path))
            ->filter()
            ->values();

        foreach ($request->file('images_upload', []) as $image) {
            $images->push(Storage::disk('public')->url($image->store('raal/projects', 'public')));
        }

        unset($data['image_urls'], $data['images_upload']);
        $data['images'] = $images->take(12)->all();
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
