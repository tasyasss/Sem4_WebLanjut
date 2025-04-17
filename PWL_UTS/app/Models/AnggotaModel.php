<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaModel extends Model
{
    protected $table = 'm_anggota'; // definisikan nama tabel pada model ini
    protected $primaryKey = 'anggota_id'; // definisikan pk dari tabel yg digunakan

    protected $fillable = [
        'anggota_nomor',
        'anggota_nama',
        'alamat',
        'no_hp',
        'email'
    ];
}
