<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_anggota')->insert([
            [
                'anggota_nomor' => 'AG001',
                'anggota_nama' => 'Odin',
                'alamat' => 'Jl. Mawar No.1',
                'no_hp' => '081234567890',
                'email' => 'odin@example.com'
            ],
            [
                'anggota_nomor' => 'AG002',
                'anggota_nama' => 'Brian',
                'alamat' => 'Jl. Melati No.2',
                'no_hp' => '081234567891',
                'email' => 'brian@example.com'
            ],
            [
                'anggota_nomor' => 'AG003',
                'anggota_nama' => 'Bobby',
                'alamat' => 'Jl. Kenanga No.3',
                'no_hp' => '081234567892',
                'email' => 'bobby@example.com'
            ],
            [
                'anggota_nomor' => 'AG004',
                'anggota_nama' => 'Dewi',
                'alamat' => 'Jl. Dahlia No.4',
                'no_hp' => '081234567893',
                'email' => 'dewi@example.com'
            ],
            [
                'anggota_nomor' => 'AG005',
                'anggota_nama' => 'Raka',
                'alamat' => 'Jl. Anggrek No.5',
                'no_hp' => '081234567894',
                'email' => 'raka@example.com'
            ],
        ]);
    }
}
