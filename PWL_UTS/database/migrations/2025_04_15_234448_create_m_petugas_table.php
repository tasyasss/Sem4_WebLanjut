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
        Schema::create('m_petugas', function (Blueprint $table) {
            $table->id('petugas_id');
            $table->string('petugas_nomor', 10)->unique();
            $table->string('petugas_nama', 50);
            $table->string('username', 20)->unique();
            $table->string('password');
            $table->string('email', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_petugas');
    }
};
