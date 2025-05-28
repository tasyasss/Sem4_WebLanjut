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

    protected $fillable = ['username', 'password', 'nama', 'level_id', 'foto_profil', 'created_at', 'updated_at'];  

    protected $hidden = ['password']; // jgn di tampilkan saat select
    protected $casts = ['password' => 'hashed']; // casting pass agar otomatis di hash

    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    // mendapatkan nama role
    public function getRoleName(): string
    {
        return $this->level->level_nama;
    }

    // cek apakah user memiliki role tertentu
    public function hasRole($role): bool
    {
        return $this->level->level_kode == $role;
    }

    // mendapatkan kode role
    public function getRole(): string
    {
        return $this->level->level_kode;
    }

    public function getAvatarAttribute($value)
    {
        return $value ? asset($value) : asset('avatars/default.jpg');
    }
}
