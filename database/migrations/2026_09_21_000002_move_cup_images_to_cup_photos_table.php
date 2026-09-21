<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        foreach (DB::table('cups')->get() as $cup) {
            for ($i = 1; $i <= 10; $i++) {
                $column = 'img'.$i;
                if (! empty($cup->{$column})) {
                    DB::table('cup_photos')->insert([
                        'cup_id' => $cup->id,
                        'image' => $cup->{$column},
                        'link' => null,
                        'sort' => $i,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        Schema::table('cups', function (Blueprint $table) {
            $table->dropColumn([
                'img1',
                'img2',
                'img3',
                'img4',
                'img5',
                'img6',
                'img7',
                'img8',
                'img9',
                'img10',
            ]);
        });
    }

    public function down()
    {
        Schema::table('cups', function (Blueprint $table) {
            for ($i = 1; $i <= 10; $i++) {
                $table->string('img'.$i)->nullable()->after('opis');
            }
        });

        foreach (DB::table('cup_photos')->orderBy('sort')->get() as $photo) {
            DB::table('cups')->where('id', $photo->cup_id)->update([
                'img'.$photo->sort => $photo->image,
            ]);
        }
    }
};
