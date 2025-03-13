<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // coba akses model UserModel
        $user = UserModel::all(); //ambil semua data m_user
        return view('user', ['data' => $user]);
    }
}

// tambah data user dengan eloquent model
$data = [
    'username' => 'customer-1',
    'nama' => 'Pelanggan',
    'password' => Hash::make('12345'),
    'level_id' => 5
];

UserModel::insert($data); //menambahkan data ke m_user
