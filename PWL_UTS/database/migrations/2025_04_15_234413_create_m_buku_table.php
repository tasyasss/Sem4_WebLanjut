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
        Schema::create('m_buku', function (Blueprint $table) {
            $table->id('buku_id');
            $table->unsignedBigInteger('kategori_id')->index(); // index untuk foreign key
            $table->unsignedBigInteger('rak_id')->index(); // index untuk foreign key
            $table->string('buku_kode', 10)->unique();
            $table->string('buku_judul', 50);
            $table->string('buku_penulis', 50);
            $table->string('buku_penerbit', 50);
            $table->year('tahun_terbit');
            $table->timestamps();

            // mendefinisikan foreign key
            $table->foreign('kategori_id')->references('kategori_id')->on('m_kategori');
            $table->foreign('rak_id')->references('rak_id')->on('m_rak');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_buku');
    }
};
