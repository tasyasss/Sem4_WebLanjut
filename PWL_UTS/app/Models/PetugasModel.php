<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetugasModel extends Model
{
    use HasFactory;

    protected $table = 'm_petugas'; // definisikan nama tabel pada model ini
    protected $primaryKey = 'petugas_id'; // definisikan pk dari tabel yg digunakan

    protected $fillable = [
        'petugas_nomor',
        'petugas_nama',
        'email',
        'username',
        'password'
    ];
}
