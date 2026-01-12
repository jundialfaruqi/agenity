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
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agenda_session_id')->constrained('agenda_sessions')->onDelete('cascade');
            $table->string('name');
            $table->string('nip_nik')->nullable();
            $table->string('handphone');
            $table->enum('asal_daerah', ['dalam_kota', 'luar_kota'])->default('dalam_kota');
            $table->foreignId('master_opd_id')->nullable()->constrained('opd_masters')->onDelete('set null');
            $table->string('asal_instansi');
            $table->string('jabatan_pekerjaan');
            $table->text('ttd_path'); // Base64 or path to image
            $table->dateTime('checkin_time');
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
