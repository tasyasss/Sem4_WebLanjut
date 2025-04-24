<?php

namespace App\Models;

use App\Models\KategoriModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BukuModel extends Model
{
    protected $table = 'm_buku'; // definisikan nama tabel pada model ini
    protected $primaryKey = 'buku_id'; // definisikan pk dari tabel yg digunakan

    protected $fillable = [
        'kategori_id',
        'rak_id',
        'buku_kode',
        'buku_judul',
        'buku_penulis',
        'buku_penerbit',
        'tahun_terbit',
    ];

     // Relasi ke tabel kategori
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id', 'kategori_id');
    }

     // Relasi ke tabel rak
    public function rak(): BelongsTo
    {
        return $this->belongsTo(RakModel::class, 'rak_id', 'rak_id');
    }
}
