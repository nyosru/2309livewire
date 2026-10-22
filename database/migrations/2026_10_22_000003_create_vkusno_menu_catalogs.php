<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vkusno_menu_sections', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->string('anchor', 100)->unique();
            $table->string('title');
            $table->string('eyebrow')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
        Schema::create('vkusno_menu_categories', function (Blueprint $table) {
            $table->id();
            $table->string('section_id', 100);
            $table->foreign('section_id')->references('id')->on('vkusno_menu_sections')->restrictOnDelete();
            $table->string('slug', 100);
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->unique(['section_id', 'slug']);
        });
        Schema::table('vkusno_products', function (Blueprint $table) {
            $table->foreignId('menu_category_id')->nullable()->constrained('vkusno_menu_categories')->restrictOnDelete();
        });

        $now = now();
        foreach (config('vkusno.menu_sections', []) as $id => $section) {
            DB::table('vkusno_menu_sections')->insert([
                'id' => $id, 'anchor' => $section['anchor'], 'title' => $section['title'],
                'eyebrow' => $section['eyebrow'], 'description' => $section['description'],
                'sort_order' => DB::table('vkusno_menu_sections')->count(),
                'created_at' => $now, 'updated_at' => $now,
            ]);
            foreach ($section['categories'] as $slug => $name) {
                DB::table('vkusno_menu_categories')->insert([
                    'section_id' => $id, 'slug' => $slug, 'name' => $name,
                    'sort_order' => DB::table('vkusno_menu_categories')->where('section_id', $id)->count(),
                    'created_at' => $now, 'updated_at' => $now,
                ]);
            }
        }

        // Preserve products added directly to the database, including custom categories.
        foreach (DB::table('vkusno_products')->get() as $product) {
            DB::table('vkusno_menu_sections')->insertOrIgnore([
                'id' => $product->section, 'anchor' => 'menu-'.$product->section,
                'title' => $product->section, 'created_at' => $now, 'updated_at' => $now,
            ]);
            DB::table('vkusno_menu_categories')->insertOrIgnore([
                'section_id' => $product->section, 'slug' => $product->category,
                'name' => $product->label, 'created_at' => $now, 'updated_at' => $now,
            ]);
            $categoryId = DB::table('vkusno_menu_categories')->where('section_id', $product->section)->where('slug', $product->category)->value('id');
            DB::table('vkusno_products')->where('id', $product->id)->update(['menu_category_id' => $categoryId]);
        }
    }

    public function down(): void
    {
        Schema::table('vkusno_products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('menu_category_id');
        });
        Schema::dropIfExists('vkusno_menu_categories');
        Schema::dropIfExists('vkusno_menu_sections');
    }
};
