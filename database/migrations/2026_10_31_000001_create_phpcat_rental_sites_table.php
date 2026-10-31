<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phpcat_rental_sites', function (Blueprint $table) {
            $table->id();
            $table->string('domain')->unique();
            $table->string('category', 80)->nullable();
            $table->text('description');
            $table->boolean('is_working')->default(false);
            $table->boolean('is_visible')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        DB::table('phpcat_rental_sites')->insert([
            [
                'domain' => 'сноукайтинг.рф',
                'category' => 'СПОРТ',
                'description' => 'Сайт о зимнем спорте, обучении и активном отдыхе на снегу.',
                'is_working' => false,
                'is_visible' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'domain' => 'ttt72.ru',
                'category' => 'КЛУБЫ',
                'description' => 'Площадка для клубов и любителей настольного тенниса в Тюмени.',
                'is_working' => true,
                'is_visible' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'domain' => 'ЦентрДзюдо.рф',
                'category' => 'ДЕТЯМ',
                'description' => 'Сайт детского спортивного центра: занятия, тренировки и запись.',
                'is_working' => false,
                'is_visible' => true,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'domain' => 'земельныйкадастр.рф',
                'category' => 'УСЛУГИ',
                'description' => 'Кадастровые и юридические услуги по земельным вопросам.',
                'is_working' => true,
                'is_visible' => true,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'domain' => 'хлебничная.рф',
                'category' => 'ЕДА',
                'description' => 'Сайт пекарни с информацией о продукции и возможностях франшизы.',
                'is_working' => false,
                'is_visible' => true,
                'sort_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('phpcat_rental_sites');
    }
};
