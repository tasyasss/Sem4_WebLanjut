<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_rak')->insert([
            ['rak_kode' => 'RAK01', 'rak_nama' => 'Rak A'],
            ['rak_kode' => 'RAK02', 'rak_nama' => 'Rak B'],
            ['rak_kode' => 'RAK03', 'rak_nama' => 'Rak C'],
            ['rak_kode' => 'RAK04', 'rak_nama' => 'Rak D'],
            ['rak_kode' => 'RAK05', 'rak_nama' => 'Rak E'],
        ]);
    }
}
