<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_opd_id')->constrained('opd_masters')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('jenis_event'); // rapat, seminar, dll
            $table->enum('mode', ['online', 'offline', 'hybrid'])->default('offline');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('location')->nullable();
            $table->string('link_streaming_youtube')->nullable();
            $table->string('link_lainnya')->nullable();
            $table->string('ket_link_lainnya')->nullable();
            $table->longText('content')->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status', ['draft', 'active', 'finished'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
