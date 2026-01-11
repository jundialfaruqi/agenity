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
        Schema::create('opd_masters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('singkatan');
            $table->text('address_opd')->nullable();
            $table->text('catatan')->nullable();
            $table->string('logo_opd')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opd_masters');
    }
};
