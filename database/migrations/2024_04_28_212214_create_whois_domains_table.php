<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * The database connection that should be used by the migration.
     *
     * @var string
     */
    protected $connection = 'sqlite_domains'; // Замените 'mysql' на имя вашего подключения


    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('whois_domains', function (Blueprint $table) {
            $table->id();

            $table->string('domain');
            $table->text('data')->nullable();
            $table->json('data_json')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whois_domains');
    }
};
