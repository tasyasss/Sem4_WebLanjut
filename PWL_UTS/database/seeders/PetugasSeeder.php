<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_petugas')->insert([
            [
                'petugas_nomor' => 'PT001',
                'petugas_nama' => 'jer',
                'username' => 'jer123',
                'password' => Hash::make('12345'),
                'email' => 'jer@example.com'
            ],
            [
                'petugas_nomor' => 'PT002',
                'petugas_nama' => 'Budi',
                'username' => 'budi02',
                'password' => Hash::make('12345'),
                'email' => 'budi@example.com'
            ],
            [
                'petugas_nomor' => 'PT003',
                'petugas_nama' => 'Sari',
                'username' => 'sari03',
                'password' => Hash::make('12345'),
                'email' => 'sari@example.com'
            ],
            [
                'petugas_nomor' => 'PT004',
                'petugas_nama' => 'Dedi',
                'username' => 'dedi04',
                'password' => Hash::make('12345'),
                'email' => 'dedi@example.com'
            ],
            [
                'petugas_nomor' => 'PT005',
                'petugas_nama' => 'Wati',
                'username' => 'wati05',
                'password' => Hash::make('12345'),
                'email' => 'wati@example.com'
            ],
        ]);
    }
}
