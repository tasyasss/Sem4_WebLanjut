<?php

namespace App\Models;

use App\Models\LevelModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable; //implementasi class authenticatable

class UserModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_user'; // definisikan nama tabel pada model ini
    protected $primaryKey = 'user_id'; // definisikan pk dari tabel yg digunakan

    protected $fillable = [
        'level_id',
        'username',
        'nama',
        'password'
    ];

    protected $hidden = ['password']; // jgn di tampilkan saat select
    protected $casts = ['password' => 'hashed']; // casting pass agar otomatis di hash

    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
}
