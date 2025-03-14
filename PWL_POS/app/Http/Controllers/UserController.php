<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // tambah data user dengan eloquent model
        $data = [
            'username' => 'Manager_tiga',
            'nama' => 'Manager 3',
            'password' => Hash::make('12345'),
            'level_id' => 2
        ];
        UserModel::create($data); 
        // UserModel::insert($data); //menambahkan data ke m_user

        // coba akses model UserModel
        $user = UserModel::all(); //ambil semua data m_user
        return view('user', ['data' => $user]);
    }
}

