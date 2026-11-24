<?php

namespace App\Livewire\Bu\Ad;

use App\Models\BuAd;
use App\Models\BuAdImage;
use App\Models\BuCategory;
use App\Models\BuAdType;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class Post extends Component
{
    use WithFileUploads;

    public $type_id = '';
    public $category_id = '';
    public $title = '';
    public $description = '';
    public $price = '';
    public $address = '';
    public $city = '';
    public $contact_kind = '';
    public $contact_value = '';
    public $images = [];

    protected $rules = [
        'type_id' => 'required|exists:bu_ad_types,id',
        'category_id' => 'required|exists:bu_categories,id',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'nullable|numeric|min:0',
        'address' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:128',
        'contact_kind' => 'nullable|string|max:32',
        'contact_value' => 'nullable|string|max:255',
        'images.*' => 'nullable|image|max:2048',
    ];

    public function render()
    {
        return view('livewire.bu.ad.post', [
            'types' => BuAdType::where('is_visible', true)->orderBy('sort')->get(),
            'categories' => $this->getCategories(),
            'category_path' => $this->getCategoryPath(),
        ]);
    }

    private function getCategories()
    {
        if (!$this->category_id) {
            return BuCategory::whereNull('parent_id')
                ->where('is_active', true)
                ->orderBy('sort')
                ->get();
        }

        $parent = BuCategory::find($this->category_id);
        if (!$parent) {
            return BuCategory::whereNull('parent_id')
                ->where('is_active', true)
                ->orderBy('sort')
                ->get();
        }

        return $parent->children()
            ->where('is_active', true)
            ->orderBy('sort')
            ->get();
    }

    public function getCategoryPath()
    {
        $parts = [];
        $id = $this->category_id;
        while ($id) {
            $cat = BuCategory::find($id);
            if (!$cat) break;
            array_unshift($parts, $cat->title);
            $id = $cat->parent ? $cat->parent->id : null;
        }

        return implode(' / ', $parts);
    }

    public function save()
    {
        $this->validate();

        $slugBase = Str::slug($this->title) ?: 'ad';
        $slug = $slugBase;
        for ($suffix = 2; BuAd::where('slug', $slug)->exists(); $suffix++) {
            $slug = $slugBase.'-'.$suffix;
        }

        $ad = auth()->user()->ads()->create([
            'type_id' => $this->type_id,
            'category_id' => $this->category_id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price ? (float) $this->price : 0,
            'address' => $this->address ?: null,
            'city' => $this->city ?: null,
            'contact_kind' => $this->contact_kind ?: null,
            'contact_value' => $this->contact_value ?: null,
            'status' => 'published',
            'is_approved' => true,
            'published_at' => now(),
            'slug' => $slug,
        ]);

        foreach ($this->images as $i => $file) {
            if (!$file->isValid()) {
                continue;
            }
            $path = $file->store("ads/{$ad->id}", 'public');
            BuAdImage::create([
                'ad_id' => $ad->id,
                'url' => Str::replaceFirst('public/', '', $path),
                'is_main' => ($i === 0),
                'sort' => $i,
            ]);
        }

        $this->reset();
        $this->redirect(route('cabinet.ads.index'), navigate: true);
    }
}
