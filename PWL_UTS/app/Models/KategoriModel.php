<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriModel extends Model
{
    protected $table = 'm_kategori'; // definisikan nama tabel pada model ini
    protected $primaryKey = 'kategori_id'; // definisikan pk dari tabel yg digunakan

    protected $fillable = [
        'kategori_kode',
        'kategori_nama'
    ];
}
