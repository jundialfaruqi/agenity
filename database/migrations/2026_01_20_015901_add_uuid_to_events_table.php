<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add uuid column as nullable first
        Schema::table('events', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id');
        });

        // 2. Generate UUIDs for existing records
        $events = DB::table('events')->whereNull('uuid')->get();
        foreach ($events as $event) {
            DB::table('events')
                ->where('id', $event->id)
                ->update(['uuid' => (string) \Illuminate\Support\Str::uuid()]);
        }

        // 3. Add unique constraint and make it not null
        // Using multiple steps for better compatibility with PostgreSQL
        Schema::table('events', function (Blueprint $table) {
            $table->unique('uuid');
        });

        // Use raw SQL for making it NOT NULL to avoid potential 'change()' issues in some PG versions/configs
        if (config('database.default') === 'pgsql') {
            DB::statement('ALTER TABLE events ALTER COLUMN uuid SET NOT NULL');
        } else {
            Schema::table('events', function (Blueprint $table) {
                $table->uuid('uuid')->nullable(false)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
