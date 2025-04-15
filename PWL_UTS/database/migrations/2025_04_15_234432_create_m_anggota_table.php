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
        Schema::create('m_anggota', function (Blueprint $table) {
            $table->id('anggota_id');
            $table->string('anggota_nomor', 10)->unique();
            $table->string('anggota_nama', 50);
            $table->string('alamat', 100);
            $table->string('no_hp', 20);
            $table->string('email', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_anggota');
    }
};
