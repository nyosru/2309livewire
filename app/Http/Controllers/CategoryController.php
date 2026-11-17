<?php

namespace App\Http\Controllers;

use App\Models\BuCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $tree = BuCategory::with('children.children')->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort')
            ->get();

        return view('bu.cabinet.categories', compact('tree'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'parent_id'     => ['nullable', 'exists:bu_categories,id'],
            'title'         => ['required', 'string', 'max:128'],
            'slug'          => ['required', 'string', 'max:192', 'unique:bu_categories,slug'],
            'description'   => ['nullable', 'string'],
            'icon'          => ['nullable', 'string', 'max:32'],
            'sort'          => ['nullable', 'integer'],
        ]);

        $parent = $data['parent_id'] ?? null;
        $level = $parent ? 2 : 1;

        BuCategory::create(array_merge($data, [
            'level' => $level,
        ]));

        return back()->with('success', 'Категория добавлена.');
    }

    public function update(BuCategory $category, Request $request)
    {
        $data = $request->validate([
            'parent_id'     => ['nullable', 'exists:bu_categories,id'],
            'title'         => ['required', 'string', 'max:128'],
            'slug'          => ['required', 'string', 'max:192', "unique:bu_categories,slug,{$category->id}"],
            'description'   => ['nullable', 'string'],
            'icon'          => ['nullable', 'string', 'max:32'],
            'sort'          => ['nullable', 'integer'],
        ]);

        $parent = $data['parent_id'] ?? $category->parent_id;
        $data['level'] = $parent ? 2 : 1;

        $category->update($data);

        return back()->with('success', 'Категория обновлена.');
    }

    public function destroy(BuCategory $category)
    {
        $category->delete();
        return back()->with('success', 'Категория удалена.');
    }
}
