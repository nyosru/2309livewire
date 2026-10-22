<?php

namespace App\Http\Controllers\Vkusno;

use App\Http\Controllers\Controller;
use App\Models\Vkusno\MenuCategory;
use App\Models\Vkusno\MenuSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CatalogAdminController extends Controller
{
    public function sections()
    {
        return view('vkusno.admin.sections', ['sections' => MenuSection::withCount('categories')->orderBy('sort_order')->orderBy('title')->get()]);
    }

    public function saveSection(Request $request, ?MenuSection $section = null)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'eyebrow' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:3000'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:1000000'],
            'is_active' => ['required', 'boolean'],
        ]);
        if (! $section) {
            $id = Str::limit(Str::slug($data['title']) ?: 'section', 23, '').'-'.Str::lower(Str::random(6));
            $section = new MenuSection(['id' => $id, 'anchor' => 'menu-'.$id]);
        }
        $section->fill($data)->save();

        return redirect('/admin/sections')->with('status', 'Раздел сохранён.');
    }

    public function destroySection(MenuSection $section)
    {
        if ($section->categories()->exists()) {
            throw ValidationException::withMessages(['section' => 'Сначала перенесите или удалите категории этого раздела. Можно также просто скрыть раздел.']);
        }
        $section->delete();

        return redirect('/admin/sections')->with('status', 'Раздел удалён.');
    }

    public function categories()
    {
        return view('vkusno.admin.categories', [
            'categories' => MenuCategory::with('section')->withCount('products')->orderBy('section_id')->orderBy('sort_order')->orderBy('name')->get(),
            'sections' => MenuSection::orderBy('sort_order')->orderBy('title')->get(),
        ]);
    }

    public function saveCategory(Request $request, ?MenuCategory $category = null)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'section_id' => ['required', 'string', Rule::exists('vkusno_menu_sections', 'id')],
            'sort_order' => ['required', 'integer', 'min:0', 'max:1000000'],
            'is_active' => ['required', 'boolean'],
        ]);
        if ($category && MenuCategory::where('section_id', $data['section_id'])->where('slug', $category->slug)->whereKeyNot($category->id)->exists()) {
            throw ValidationException::withMessages(['section_id' => 'В выбранном разделе уже есть такая категория. Перенесите товары по отдельности.']);
        }
        DB::transaction(function () use ($category, $data) {
            $category ??= new MenuCategory(['slug' => Str::limit(Str::slug($data['name']) ?: 'category', 43, '').'-'.Str::lower(Str::random(6))]);
            $category->fill($data)->save();
            $category->products()->update(['section' => $category->section_id, 'category' => $category->slug, 'label' => $category->name]);
        });

        return redirect('/admin/categories')->with('status', 'Категория сохранена.');
    }

    public function destroyCategory(MenuCategory $category)
    {
        if ($category->products()->exists()) {
            throw ValidationException::withMessages(['category' => 'Сначала перенесите или удалите товары этой категории. Можно также просто скрыть категорию.']);
        }
        $category->delete();

        return redirect('/admin/categories')->with('status', 'Категория удалена.');
    }
}
