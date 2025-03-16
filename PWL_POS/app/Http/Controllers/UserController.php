<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = UserModel::all();
        return view('user', ['data' => $user]);
    }
    public function tambah()
    {
        return view('user_tambah');   
    }

    public function tambah_simpan(Request $request)
    {
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'level_id' => $request->level_id
        ]);
        return redirect('/user');
    }

    public function ubah($id)
    {
        $user = UserModel::find($id);
        return view('user_ubah', ['data' => $user]);
    }

    public function ubah_simpan(Request $request, $id)
    {
        $user = UserModel::find($id);
        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make($request->password);
        $user->level_id = $request->level_id;
        $user->save();
        return redirect('/user');
    }

    public function hapus($id)
    {
        $user = UserModel::find($id);
        $user->delete();
        return redirect('/user');
    }
}

// public function index(){
    // // js 2.5 Attribute Changes
    // $user = UserModel::create([
    //     'username' => 'manager11',
    //     'nama' => 'Manager11',
    //     'password' => Hash::make('12345'),
    //     'level_id' => 2
    // ]);
    // $user->username = 'manager12';
    // $user->save();
    
    // $user->wasChanged();
    // $user->wasChanged('username');
    // $user->wasChanged(['username', ' level_id']);
    // $user->wasChanged('nama');
    // dd($user->wasChanged(['nama', 'username']));
    
    // $user->isDirty();
    // $user->isDirty('username');
    // $user->isDirty('nama');
    // $user->isDirty(['username', 'nama']);
    
    // $user->isClean();
    // $user->isClean('username');
    // $user->isClean('nama');
    // $user->isClean(['username', 'nama']);
    // $user->save();
    // $user->isDirty();
    // $user->isClean();
    // dd($user->isDirty());
    
    // // js 4 prak 2.4 Retreiving or Creating Models
    // $user = UserModel::firstOrNew([
    //     'username' => 'manager33',
    //     'nama' => 'Manager Tiga Tiga',
    //     'password' => Hash::make('12345'),
    //     'level_id' => 2
    // ]);
    // $user->save();
    // return view('user', ['data' => $user]);
    
    // $user = UserModel::firstOrCreate([
    //     'username' => 'manager22',
    //     'nama' => 'Manager Dua Dua',
    //     'password' => Hash::make('12345'),
    //     'level_id' => 2
    // ]);
    
    // // js 4 prak 2.3 Retreiving Aggregrates
    // $user = UserModel::where('level_id', 2)->count();
    // // dd($user);
    // return view('user', ['data' => $user]);
    
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
// }