<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Отдельный раздел «Полуфабрикаты»: замороженные пельмени, вареники, хинкали, манты и сырники.
 * Состав товаров — в config/vkusno.php, раздел semi-finished.
 */
return new class extends Migration
{
    private const SECTION = [
        'id' => 'semi-finished',
        'anchor' => 'polufabrikaty',
        'title' => 'Полуфабрикаты',
        'eyebrow' => 'ЗАМОРОЖЕННЫЕ ПОЛУФАБРИКАТЫ К ВАШЕМУ СТОЛУ',
        'description' => 'Пельмени, вареники, хинкали, манты и сырники. Продукт замороженный, требует приготовления. Цена за 1 кг, кроме сырников. Наличие уточняется при подтверждении.',
    ];

    private const CATEGORIES = [
        'pelmeni-vareniki' => 'Пельмени и вареники',
        'hinkali-manty' => 'Хинкали и манты',
        'syrniki' => 'Сырники',
    ];

    // Категория столовой, оставшаяся пустой после переезда заморозки.
    private const OLD_FROZEN = ['section' => 'canteen', 'slug' => 'frozen'];

    public function up(): void
    {
        $now = now();

        DB::table('vkusno_menu_sections')->insertOrIgnore([
            'id' => self::SECTION['id'],
            'anchor' => self::SECTION['anchor'],
            'title' => self::SECTION['title'],
            'eyebrow' => self::SECTION['eyebrow'],
            'description' => self::SECTION['description'],
            'sort_order' => DB::table('vkusno_menu_sections')->max('sort_order') + 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $sectionId = DB::table('vkusno_menu_sections')->where('id', self::SECTION['id'])->value('id');

        foreach (self::CATEGORIES as $slug => $name) {
            DB::table('vkusno_menu_categories')->insertOrIgnore([
                'section_id' => $sectionId,
                'slug' => $slug,
                'name' => $name,
                'sort_order' => DB::table('vkusno_menu_categories')->where('section_id', $sectionId)->count(),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $products = [];
        foreach (array_values(config('vkusno.products', [])) as $position => $product) {
            if (($product['section'] ?? null) !== self::SECTION['id']) {
                continue;
            }
            $categoryId = DB::table('vkusno_menu_categories')
                ->where('section_id', $sectionId)->where('slug', $product['category'])->value('id');
            $products[$product['id']] = [
                'id' => $product['id'],
                'section' => $product['section'],
                'category' => $product['category'],
                'name' => $product['name'],
                'label' => $product['label'],
                'description' => $product['description'],
                'weight' => $product['weight'],
                'price' => $product['price'],
                'image' => $product['image'],
                'badge' => $product['badge'] ?? null,
                'source_photo' => $product['source_photo'] ?? null,
                'inferred_fields' => json_encode($product['inferred_fields'] ?? [], JSON_THROW_ON_ERROR),
                'price_is_estimate' => $product['price_is_estimate'] ?? false,
                'is_active' => true,
                'menu_category_id' => $categoryId,
                'sort_order' => $position,
            ];
        }

        // Новые позиции добавляются, прежние замороженные — обновляются целиком из конфигурации.
        foreach ($products as $product) {
            $exists = DB::table('vkusno_products')->where('id', $product['id'])->exists();
            if ($exists) {
                DB::table('vkusno_products')->where('id', $product['id'])->update(array_merge(
                    collect($product)->except('id')->all(),
                    ['updated_at' => $now],
                ));

                continue;
            }
            DB::table('vkusno_products')->insert(array_merge($product, [
                'created_at' => $now, 'updated_at' => $now,
            ]));
        }

        // Пустая категория «Замороженные» в столовой больше не нужна.
        DB::table('vkusno_menu_categories')
            ->where('section_id', self::OLD_FROZEN['section'])
            ->where('slug', self::OLD_FROZEN['slug'])
            ->whereNotExists(fn ($query) => $query->select(DB::raw(1))->from('vkusno_products')
                ->whereColumn('vkusno_products.menu_category_id', 'vkusno_menu_categories.id'))
            ->delete();
    }

    public function down(): void
    {
        $sectionId = self::SECTION['id'];

        // Вернуть прежние позиции в столовую нельзя автоматически: их содержимое уже заменено.
        // Поэтому товары раздела удаляются вместе с разделом.
        DB::table('vkusno_products')->where('section', $sectionId)->delete();
        DB::table('vkusno_menu_categories')->where('section_id', $sectionId)->delete();
        DB::table('vkusno_menu_sections')->where('id', $sectionId)->delete();
    }
};
