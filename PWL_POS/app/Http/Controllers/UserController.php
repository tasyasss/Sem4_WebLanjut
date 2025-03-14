<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // js 4 prak 2.3 Retreiving Aggregrates
        $user = UserModel::where('level_id', 2)->count();
        // dd($user);
        return view('user', ['data' => $user]);

        // // js 4 prak 2.2 Not Found Exceptions
        // $user = UserModel::findOrFail(1);
        // $user = UserModel::where('username', 'manager-9')->firstOrFail();
        // return view('use r', ['data' => $user]);

        // // js 4 prak 2.1 Retrieving Single Models
        // $user = UserModel::find(1);
        // $user = UserModel::where('level_id', 1)->first();
        // $user = UserModel::firstWhere('level_id', 1);
        // $user = UserModel::findOr(20, ['username', 'nama'], function(){
        //     abort(404);
        // });
        // return view('user', ['data' => $user]);


        // // tambah data user dengan eloquent model
        // $data = [
        //     'username' => 'Manager_tiga',
        //     'nama' => 'Manager 3',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2
        // ];
        // UserModel::create($data); 
        // // UserModel::insert($data); //menambahkan data ke m_user

        // // coba akses model UserModel
        // $user = UserModel::all(); //ambil semua data m_user
        // return view('user', ['data' => $user]);
    }
}

