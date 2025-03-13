<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;

    protected $table = 'm_user'; // definisikan nama tabel pada model ini
    protected $primaryKey = 'user_id'; // definisikan pk dari tabel yg digunakan
}
