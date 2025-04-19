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
        Schema::create('t_pinjam', function (Blueprint $table) {
            $table->id('pinjam_id');
            $table->unsignedBigInteger('petugas_id')->index(); // index untuk foreign key
            $table->unsignedBigInteger('anggota_id')->index(); // index untuk foreign key
            $table->unsignedBigInteger('buku_id')->index(); // index untuk foreign key
            $table->timestamps();

            // mendefinisikan foreign key
            $table->foreign('petugas_id')->references('petugas_id')->on('m_petugas');
            $table->foreign('anggota_id')->references('anggota_id')->on('m_anggota');
            $table->foreign('buku_id')->references('buku_id')->on('m_buku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_pinjam');
    }
};
