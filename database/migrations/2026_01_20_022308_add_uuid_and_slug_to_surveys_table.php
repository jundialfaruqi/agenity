<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('surveys', function (Blueprint $table) {
            if (!Schema::hasColumn('surveys', 'uuid')) {
                $table->uuid('uuid')->nullable()->after('id');
            }
            if (!Schema::hasColumn('surveys', 'slug')) {
                $table->string('slug')->nullable()->after('title');
            }
        });

        // Generate UUIDs and Slugs for existing records
        $surveys = DB::table('surveys')->get();
        foreach ($surveys as $survey) {
            DB::table('surveys')
                ->where('id', $survey->id)
                ->update([
                    'uuid' => (string) Str::uuid(),
                    'slug' => Str::slug($survey->title) . '-' . Str::lower(Str::random(5))
                ]);
        }

        Schema::table('surveys', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->unique()->change();
            $table->string('slug')->nullable(false)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surveys', function (Blueprint $table) {
            $table->dropColumn(['uuid', 'slug']);
        });
    }
};
