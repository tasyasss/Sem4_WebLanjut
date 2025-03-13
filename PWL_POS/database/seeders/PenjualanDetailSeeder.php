<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_penjualan_detail')->insert([
            // Transaksi 1
            ['penjualan_id' => 1, 'barang_id' => 1, 'harga' => 4500000, 'jumlah' => 1, 'created_at' => NOW()],
            ['penjualan_id' => 1, 'barang_id' => 2, 'harga' => 2500000, 'jumlah' => 1, 'created_at' => NOW()],
            ['penjualan_id' => 1, 'barang_id' => 3, 'harga' => 2200000, 'jumlah' => 1, 'created_at' => NOW()],
        
            // Transaksi 2
            ['penjualan_id' => 2, 'barang_id' => 4, 'harga' => 750000, 'jumlah' => 1, 'created_at' => NOW()],
            ['penjualan_id' => 2, 'barang_id' => 5, 'harga' => 300000, 'jumlah' => 1, 'created_at' => NOW()],
            ['penjualan_id' => 2, 'barang_id' => 6, 'harga' => 200000, 'jumlah' => 1, 'created_at' => NOW()],
        
            // Transaksi 3
            ['penjualan_id' => 3, 'barang_id' => 7, 'harga' => 200000, 'jumlah' => 1, 'created_at' => NOW()],
            ['penjualan_id' => 3, 'barang_id' => 8, 'harga' => 500000, 'jumlah' => 1, 'created_at' => NOW()],
            ['penjualan_id' => 3, 'barang_id' => 9, 'harga' => 100000, 'jumlah' => 1, 'created_at' => NOW()],
        
            // Transaksi 4
            ['penjualan_id' => 4, 'barang_id' => 10, 'harga' => 5000, 'jumlah' => 3, 'created_at' => NOW()],
            ['penjualan_id' => 4, 'barang_id' => 11, 'harga' => 10000, 'jumlah' => 2, 'created_at' => NOW()],
            ['penjualan_id' => 4, 'barang_id' => 12, 'harga' => 7500, 'jumlah' => 3, 'created_at' => NOW()],
        
            // Transaksi 5
            ['penjualan_id' => 5, 'barang_id' => 13, 'harga' => 250000, 'jumlah' => 1, 'created_at' => NOW()],
            ['penjualan_id' => 5, 'barang_id' => 14, 'harga' => 100000, 'jumlah' => 1, 'created_at' => NOW()],
            ['penjualan_id' => 5, 'barang_id' => 15, 'harga' => 5000, 'jumlah' => 1, 'created_at' => NOW()],
        
            // Transaksi 6
            ['penjualan_id' => 6, 'barang_id' => 1, 'harga' => 75000, 'jumlah' => 2, 'created_at' => NOW()],
            ['penjualan_id' => 6, 'barang_id' => 2, 'harga' => 5000, 'jumlah' => 3, 'created_at' => NOW()],
            ['penjualan_id' => 6, 'barang_id' => 3, 'harga' => 10000, 'jumlah' => 1, 'created_at' => NOW()],
        
            // Transaksi 7
            ['penjualan_id' => 7, 'barang_id' => 4, 'harga' => 7000, 'jumlah' => 1, 'created_at' => now()],
            ['penjualan_id' => 7, 'barang_id' => 5, 'harga' => 30000, 'jumlah' => 1, 'created_at' => now()],
            ['penjualan_id' => 7, 'barang_id' => 6, 'harga' => 7500, 'jumlah' => 1, 'created_at' => now()],
        
            // Transaksi 8
            ['penjualan_id' => 8, 'barang_id' => 7, 'harga' => 50000, 'jumlah' => 2, 'created_at' => now()],
            ['penjualan_id' => 8, 'barang_id' => 8, 'harga' => 100000, 'jumlah' => 2, 'created_at' => now()],
            ['penjualan_id' => 8, 'barang_id' => 9, 'harga' => 15000, 'jumlah' => 2, 'created_at' => now()],
        
            // Transaksi 9
            ['penjualan_id' => 9, 'barang_id' => 10, 'harga' => 5000, 'jumlah' => 4, 'created_at' => now()],
            ['penjualan_id' => 9, 'barang_id' => 11, 'harga' => 10000, 'jumlah' => 5, 'created_at' => now()],
            ['penjualan_id' => 9, 'barang_id' => 12, 'harga' => 7500, 'jumlah' => 6, 'created_at' => now()],
        
            // Transaksi 10
            ['penjualan_id' => 10, 'barang_id' => 13, 'harga' => 75000, 'jumlah' => 2, 'created_at' => now()],
            ['penjualan_id' => 10, 'barang_id' => 14, 'harga' => 200000, 'jumlah' => 1, 'created_at' => now()],
            ['penjualan_id' => 10, 'barang_id' => 15, 'harga' => 10000, 'jumlah' => 1, 'created_at' => now()],
        ]);              
    }
}
