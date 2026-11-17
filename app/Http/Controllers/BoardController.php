<?php

namespace App\Http\Controllers;

use App\Models\BuAd;
use App\Models\BuAdType;
use App\Models\BuCategory;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function index(Request $request)
    {
        $query = BuAd::where('is_approved', true)->orderBy('id', 'desc');

        if ($request->has('type') && in_array($request->input('type'), ['buy', 'sell'])) {
            $query->where('type_id', BuAdType::where('slug', $request->input('type'))->value('id'));
        }

        if ($request->has('category') && $request->input('category')) {
            $category = BuCategory::where('slug', $request->input('category'))->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        if ($request->has('q') && trim($request->input('q'))) {
            $q = trim($request->input('q'));
            $query->where(function ($w) use ($q) {
                $w->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $ads = $query->with(['type', 'category', 'user', 'mainImage'])->paginate(24);
        $types = BuAdType::where('is_visible', true)->orderBy('sort')->get();
        $categories = BuCategory::where('level', 1)
            ->where('is_active', true)
            ->orderBy('sort')
            ->get();

        return view('bu.index', compact('ads', 'types', 'categories'));
    }

    public function category(BuCategory $category)
    {
        return $this->index(request()->merge(['category' => $category->slug]));
    }

    public function show(BuAd $ad)
    {
        $ad->load('type', 'category');
        if (!$ad->is_approved) {
            abort(404);
        }
        return view('bu.show', compact('ad'));
    }
}
