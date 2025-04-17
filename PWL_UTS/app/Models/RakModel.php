<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RakModel extends Model
{
    protected $table = 'm_rak'; // definisikan nama tabel pada model ini
    protected $primaryKey = 'rak_id'; // definisikan pk dari tabel yg digunakan

    protected $fillable = [
        'rak_kode',
        'rak_nama'
    ];
}
