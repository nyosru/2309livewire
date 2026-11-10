<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->prepareTables();

        if (! is_file(config('database.connections.newsstorage.database'))) {
            return;
        }

        $source = DB::connection('newsstorage');
        $target = DB::connection();

        $source->transaction(function () use ($source, $target) {
            $target->transaction(function () use ($source, $target) {
                foreach (['newsstorage_sources', 'newsstorage_news', 'newsstorage_media'] as $table) {
                    $missing = array_diff(
                        $source->getSchemaBuilder()->getColumnListing($table),
                        $target->getSchemaBuilder()->getColumnListing($table),
                    );

                    if ($missing !== []) {
                        throw new RuntimeException("Missing columns in {$table}: ".implode(', ', $missing));
                    }

                    $source->table($table)->chunkById(100, function ($rows) use ($target, $table) {
                        $existing = $target->table($table)->whereIn('id', $rows->pluck('id'))->get()->keyBy('id');

                        foreach ($rows as $row) {
                            $record = $existing->get($row->id);

                            if ($record === null) {
                                $target->table($table)->insert((array) $row);
                                continue;
                            }

                            foreach ((array) $row as $column => $value) {
                                $stored = $record->{$column};
                                if (($stored === null) !== ($value === null) || (string) $stored !== (string) $value) {
                                    throw new RuntimeException("Conflicting data in {$table}, ID {$row->id}, column {$column}.");
                                }
                            }
                        }
                    });
                }
            });
        });
    }

    private function prepareTables(): void
    {
        if (! Schema::hasTable('newsstorage_sources')) {
            Schema::create('newsstorage_sources', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('url', 2048);
                $table->text('parsing_instructions')->nullable();
                $table->dateTime('last_catalog_scan')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('newsstorage_news')) {
            Schema::create('newsstorage_news', function (Blueprint $table) {
                $table->id();
                $table->foreignId('source_id')->constrained('newsstorage_sources')->cascadeOnDelete();
                $table->string('url', 2048);
                $table->string('title');
                $table->longText('summary')->nullable();
                $table->longText('content')->nullable();
                $table->string('status')->default('new')->index();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (! Schema::hasColumn('newsstorage_news', 'is_featured')) {
            Schema::table('newsstorage_news', fn (Blueprint $table) => $table->boolean('is_featured')->default(false));
        }

        if (! Schema::hasColumn('newsstorage_news', 'featured_at')) {
            Schema::table('newsstorage_news', fn (Blueprint $table) => $table->dateTime('featured_at')->nullable());
        }

        if (! Schema::hasColumn('newsstorage_news', 'status_show')) {
            Schema::table('newsstorage_news', fn (Blueprint $table) => $table->string('status_show')->nullable());
        }

        if (! Schema::hasColumn('newsstorage_news', 'published_at')) {
            Schema::table('newsstorage_news', fn (Blueprint $table) => $table->dateTime('published_at')->nullable());
        }

        if (! Schema::hasTable('newsstorage_media')) {
            Schema::create('newsstorage_media', function (Blueprint $table) {
                $table->id();
                $table->foreignId('news_id')->constrained('newsstorage_news')->cascadeOnDelete();
                $table->string('url', 2048);
                $table->string('type');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        throw new RuntimeException('News Storage is using MySQL. Rolling back would discard writes made after the transfer.');
    }
};
