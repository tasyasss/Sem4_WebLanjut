<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_kategori')->insert([
            ['kategori_kode' => 'KT001', 'kategori_nama' => 'Fiksi'],
            ['kategori_kode' => 'KT002', 'kategori_nama' => 'Teknologi'],
            ['kategori_kode' => 'KT003', 'kategori_nama' => 'Sejarah'],
            ['kategori_kode' => 'KT004', 'kategori_nama' => 'Pendidikan'],
            ['kategori_kode' => 'KT005', 'kategori_nama' => 'Sains'],
        ]);
    }
}
