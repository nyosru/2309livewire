<?php

namespace Database\Seeders;

use App\Models\BuAdType;
use App\Models\BuCategory;
use Illuminate\Database\Seeder;

class CategoryAndTypeSeeder extends Seeder
{
    /**
     * Добавляет типы объявлений и дерево категорий (3 уровня).
     * Идемпотентно: пропускает уже созданные записи.
     */
    public function run(): void
    {
        BuAdType::buy();
        BuAdType::sell();

        $roots = [
            ['title' => 'Одежда и обувь', 'slug' => 'clothing', 'icon' => 'bi-tshirt'],
            ['title' => 'Техника и электроника', 'slug' => 'electronics', 'icon' => 'bi-laptop'],
            ['title' => 'Дом и интерьер', 'slug' => 'home', 'icon' => 'bi-house'],
            ['title' => 'Автомобили', 'slug' => 'cars', 'icon' => 'bi-car-front'],
            ['title' => 'Недвижимость', 'slug' => 'real-estate', 'icon' => 'bi-house'],
            ['title' => 'Работа и услуги', 'slug' => 'work', 'icon' => 'bi-briefcase'],
            ['title' => 'Аудитория и книги', 'slug' => 'audience', 'icon' => 'bi-book'],
            ['title' => 'Другое', 'slug' => 'other', 'icon' => 'bi-graph-up'],
        ];

        foreach ($roots as $root) {
            $this->makeTree($root, null, 1);
        }

        $this->command->info('Категории и типы объявлений заполнены.');
    }

    private function makeTree(array $data, ?int $parentId, int $level, string $parentSlug = ''): void
    {
        $title = $data['title'];
        $slug = $data['slug'];
        $icon = $data['icon'] ?? 'bi-list';

        dump('TRACE ' . ($parentId ?? 'null') . ' | lvl=' . $level . ' | slug=' . $slug);

        if (BuCategory::where('slug', $slug)->exists()) {
            dump('SKIP ' . $slug);
            return;
        }

        $category = BuCategory::create([
            'parent_id' => $parentId,
            'level' => $level,
            'title' => $title,
            'slug' => $slug,
            'icon' => $icon,
            'is_active' => true,
            'sort' => 0,
        ]);
        dump('CREATED ' . $slug . ' id=' . $category->id . ' parent=' . ($parentId ?? 'null') . ' level=' . $level);

        $children = $this->getChildren($level, $parentSlug ?: $slug);
        dump('getChildren(' . $level . ') count=' . count($children));
        foreach ($children as $child) {
            $this->makeTree($child, $category->id, $level + 1, $child['slug']);
        }
    }

    private function getChildren(int $level, string $parentSlug = ''): array
    {
        $lvl2 = [
            ['title' => 'Покупки', 'slug' => 'purchases', 'icon' => 'bi-cart-plus'],
            ['title' => 'Продажи', 'slug' => 'sales', 'icon' => 'bi-cart-dash'],
            ['title' => 'Обмен', 'slug' => 'swap', 'icon' => 'bi-arrows-exchange'],
        ];

        if ($level === 1) {
            return [
                ['title' => 'Мужская', 'slug' => 'men', 'icon' => 'bi-male'],
                ['title' => 'Женская', 'slug' => 'women', 'icon' => 'bi-female'],
                ['title' => 'Детская', 'slug' => 'children', 'icon' => 'bi-child'],
            ];
        }

        if ($level === 2 && $parentSlug) {
            return array_map(function ($item) use ($parentSlug) {
                return [
                    'title' => $item['title'],
                    'slug' => $parentSlug . '_' . $item['slug'],
                    'icon' => $item['icon'],
                ];
            }, $lvl2);
        }

        return [];
    }
}
