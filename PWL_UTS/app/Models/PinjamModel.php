<?php

namespace App\Models;

use App\Models\PetugasModel;
use App\Models\AnggotaModel;
use App\Models\BukuModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PinjamModel extends Model
{
    protected $table = 't_pinjam'; // definisikan nama tabel pada model ini
    protected $primaryKey = 'pinjam_id'; // definisikan pk dari tabel yg digunakan

    protected $fillable = [
        'petugas_id',
        'anggota_id',
        'buku_id'
    ];

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(PetugasModel::class, 'petugas_id', 'petugas_id');
    }

    public function anggota(): BelongsTo
    {
        return $this->belongsTo(AnggotaModel::class, 'anggota_id', 'anggota_id');
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(BukuModel::class, 'buku_id', 'buku_id');
    }
}
