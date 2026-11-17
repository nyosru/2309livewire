<?php

namespace App\Http\Controllers;

use App\Models\BuAd;
use App\Models\BuAdImage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function index()
    {
        $ads = auth()->user()
            ->ads()
            ->orderBy('id', 'desc')
            ->get();

        return view('bu.cabinet.ads', compact('ads'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type_id'       => ['required', 'exists:bu_ad_types,id'],
            'category_id'   => ['required', 'exists:bu_categories,id'],
            'title'         => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string'],
            'price'         => ['nullable', 'numeric', 'min:0'],
            'contact_kind'  => ['nullable', 'string', 'max:32'],
            'contact_value' => ['nullable', 'string', 'max:255'],
            'images.*'      => ['nullable', 'image', 'max:2048'],
        ]);

        $slugBase = Str::slug($data['title']) ?: 'ad';
        $slug = $slugBase;
        for ($suffix = 2; BuAd::where('slug', $slug)->exists(); $suffix++) {
            $slug = $slugBase.'-'.$suffix;
        }

        $ad = auth()->user()->ads()->create([
            'type_id'       => $data['type_id'],
            'category_id'   => $data['category_id'],
            'title'         => $data['title'],
            'description'   => $data['description'],
            'price'         => $data['price'] ?? 0,
            'contact_kind'  => $data['contact_kind'] ?? null,
            'contact_value' => $data['contact_value'] ?? null,
            'status'        => 'published',
            'is_approved'   => true,
            'published_at'  => now(),
            'slug'          => $slug,
        ]);

        $files = $request->file('images', []);
        foreach ($files as $i => $file) {
            if (!$file->isValid()) {
                continue;
            }
            $path = $file->store("ads/{$ad->id}", 'public');
            BuAdImage::create([
                'ad_id'   => $ad->id,
                'url'     => \Illuminate\Support\Str::replaceFirst('public/', '', $path),
                'is_main' => ($i === 0),
                'sort'    => $i,
            ]);
        }

        return redirect()->route('cabinet.ads.index')
            ->with('success', 'Объявление опубликовано.');
    }

    public function destroy(BuAd $ad)
    {
        if ($ad->user_id !== auth()->id()) {
            abort(403);
        }
        $ad->delete();
        return back();
    }
}
