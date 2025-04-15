<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_buku')->insert([
            [
                'kategori_id' => 1,
                'rak_id' => 1,
                'buku_kode' => 'BK001',
                'buku_judul' => 'Laskar Pelangi',
                'buku_penulis' => 'Andrea Hirata',
                'buku_penerbit' => 'Bentang',
                'tahun_terbit' => 2005
            ],
            [
                'kategori_id' => 2,
                'rak_id' => 2,
                'buku_kode' => 'BK002',
                'buku_judul' => 'Clean Code',
                'buku_penulis' => 'Robert C. Martin',
                'buku_penerbit' => 'Prentice Hall',
                'tahun_terbit' => 2008
            ],
            [
                'kategori_id' => 3,
                'rak_id' => 3,
                'buku_kode' => 'BK003',
                'buku_judul' => 'Sejarah Dunia',
                'buku_penulis' => 'E.H. Carr',
                'buku_penerbit' => 'Gramedia',
                'tahun_terbit' => 1990
            ],
            [
                'kategori_id' => 4,
                'rak_id' => 4,
                'buku_kode' => 'BK004',
                'buku_judul' => 'Belajar Matematika',
                'buku_penulis' => 'D. Roeslan',
                'buku_penerbit' => 'Erlangga',
                'tahun_terbit' => 2012
            ],
            [
                'kategori_id' => 5,
                'rak_id' => 5,
                'buku_kode' => 'BK005',
                'buku_judul' => 'Fisika Dasar',
                'buku_penulis' => 'Halliday',
                'buku_penerbit' => 'Wiley',
                'tahun_terbit' => 2010
            ],
        ]);
    }
}
