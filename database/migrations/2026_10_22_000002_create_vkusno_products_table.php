<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vkusno_products', function (Blueprint $table) {
            // Keep identifiers used by browser carts and existing order snapshots.
            $table->string('id', 100)->primary();
            $table->string('section', 30)->index();
            $table->string('category', 50)->index();
            $table->string('name');
            $table->string('label');
            $table->text('description');
            $table->string('weight', 100);
            $table->unsignedInteger('price');
            $table->string('image');
            $table->string('badge')->nullable();
            $table->string('source_photo')->nullable();
            $table->json('inferred_fields')->nullable();
            $table->boolean('price_is_estimate')->default(false);
            $table->boolean('is_active')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Import once; subsequent catalog edits belong in the database.
        $now = now();
        foreach (config('vkusno.products', []) as $position => $product) {
            DB::table('vkusno_products')->insert([
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
                'sort_order' => $position,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('vkusno_products');
    }
};
