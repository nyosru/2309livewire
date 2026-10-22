<?php

namespace App\Http\Controllers\Vkusno;

use App\Http\Controllers\Controller;
use App\Models\Vkusno\MenuCategory;
use App\Models\Vkusno\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductAdminController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate(['q' => ['nullable', 'string', 'max:100'], 'category' => ['nullable', 'integer']]);
        $products = Product::with('menuCategory.section')
            ->when($filters['q'] ?? null, fn ($query, $search) => $query->where('name', 'like', '%'.$search.'%'))
            ->when($filters['category'] ?? null, fn ($query, $category) => $query->where('menu_category_id', $category))
            ->orderBy('sort_order')->orderBy('name')->paginate(20)->withQueryString();

        return view('vkusno.admin.products', ['products' => $products, 'categories' => $this->categories()]);
    }

    public function create()
    {
        return view('vkusno.admin.product-form', ['product' => new Product(['is_active' => true, 'sort_order' => 0]), 'categories' => $this->categories()]);
    }

    public function store(Request $request)
    {
        return $this->save($request, new Product);
    }

    public function edit(Product $product)
    {
        return view('vkusno.admin.product-form', ['product' => $product, 'categories' => $this->categories()]);
    }

    public function update(Request $request, Product $product)
    {
        return $this->save($request, $product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect('/admin/products')->with('status', 'Товар удалён. Полученные заказы сохранены.');
    }

    private function categories()
    {
        return MenuCategory::with('section')->orderBy('section_id')->orderBy('sort_order')->orderBy('name')->get();
    }

    private function save(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'menu_category_id' => ['required', 'integer', Rule::exists('vkusno_menu_categories', 'id')],
            'description' => ['required', 'string', 'max:5000'],
            'weight' => ['required', 'string', 'max:100'],
            'price' => ['required', 'integer', 'min:0', 'max:10000000'],
            'badge' => ['nullable', 'string', 'max:100'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:1000000'],
            'is_active' => ['required', 'boolean'],
            'price_is_estimate' => ['required', 'boolean'],
            'photo' => [$product->exists ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120', 'dimensions:max_width=6000,max_height=6000'],
        ]);
        $category = MenuCategory::findOrFail($data['menu_category_id']);
        unset($data['photo']);
        $data['section'] = $category->section_id;
        $data['category'] = $category->slug;
        $data['label'] = $category->name;
        if (! $product->exists) {
            $data['id'] = 'product-'.Str::uuid();
            $data['inferred_fields'] = [];
        }

        $uploaded = null;
        try {
            if ($request->hasFile('photo')) {
                $uploaded = $request->file('photo')->store('', 'vkusno');
                $data['image'] = 'menu/uploads/'.$uploaded;
                $data['source_photo'] = null;
            }
            $product->fill($data)->save();
        } catch (\Throwable $exception) {
            if ($uploaded) {
                Storage::disk('vkusno')->delete($uploaded);
            }
            throw $exception;
        }

        return redirect('/admin/products')->with('status', 'Товар сохранён.');
    }
}
