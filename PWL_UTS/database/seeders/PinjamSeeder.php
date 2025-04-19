<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PinjamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_pinjam')->insert([
            [
                'petugas_id' => 1,
                'anggota_id' => 1,
                'buku_id'    => 1
            ],
            [
                'petugas_id' => 2,
                'anggota_id' => 2,
                'buku_id'    => 2
            ],
            [
                'petugas_id' => 1,
                'anggota_id' => 3,
                'buku_id'    => 3
            ],
        ]);
    }
}
