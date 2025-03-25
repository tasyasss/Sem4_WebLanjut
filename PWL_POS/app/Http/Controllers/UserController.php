<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\LevelModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

use function Symfony\Component\String\b;

class UserController extends Controller
{
    public function index() // menampilkan halaman awal user
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar User yang terdaftar',
        ];

        $activeMenu = 'user'; // set menu yg sedang aktif

        $level = LevelModel::all(); //ambil data level utk filter level

        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 
        'level' => $level, 'activeMenu' => $activeMenu]);
    }

    // menampilkan data user dlm json utk datatables
    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')->with('level');
        
        // filter data berdasarkan level_id
        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
            // menambahkan kolom index
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                $btn = '<a href="' . url('/user/' . $user->user_id) . 
                        '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . 
                        '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" 
                        action="' . url('/user/' . $user->user_id) . '">'
                        . csrf_field() . method_field('DELETE') .
                        '<button type="submit" class="btn btn-danger btn-sm" 
                        onclick="return confirm(\'Apakah Anda yakin hapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah User']
        ];

        $page = (object) [
            'title' => 'Tambah User Baru',
        ];

        $activeMenu = 'user'; // set menu yg sedang aktif
        $level = LevelModel::all();

        return view('user.create', ['breadcrumb' => $breadcrumb, 
        'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function create_ajax()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();
        return view('user.create_ajax')->with('level', $level);
    }

    public function store(Request $request)
    {
        $request->validate([
            //uname hrs diisi, berupa string min 3 karakter & unik utk uname pada tabel m_user 
            'username' => 'required|string|min:3|unique:m_user,username',
            //nama hrs diisi string max 100 karakter
            'nama' => 'required|string|max:100',
            //pw hrs diisi min 5 karakter
            'password' => 'required|min:5',
            //level hrs diisi angka
            'level_id' => 'required|integer',
        ]);

        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id,
        ]);

        return redirect('/user')->with('success', 'User baru berhasil ditambahkan');
    }

    public function store_ajax(Request $request)
    {
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                 'level_id' => 'required|integer',
                 'username' => 'required|string|min:3|unique:m_user,username',
                 'nama'     => 'required|string|max:100',
                 'password' => 'required|min:5'
            ];
 
            $validator = Validator::make($request->all(), $rules);
 
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, //response status
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), //pesan error validasi
                ]);
            }
 
            UserModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    public function show(string $id)
    {
        $user = UserModel::with('level')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail User']
        ];

        $page = (object) [
            'title' => 'Detail User',
        ];

        $activeMenu = 'user'; // set menu yg sedang aktif

        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 
        'activeMenu' => $activeMenu, 'user' => $user]);
    }

    public function edit(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit User']
        ];

        $page = (object) [
            'title' => 'Edit User',
        ];

        $activeMenu = 'user'; // set menu yg sedang aktif

        return view('user.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 
        'activeMenu' => $activeMenu, 'user' => $user, 'level' => $level]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            //uname hrs diisi, berupa string min 3 karakter & unik utk uname pada tabel m_user 
            //untuk user yg sedang diedit
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            //nama hrs diisi string max 100 karakter
            'nama' => 'required|string|max:100',
            //pw hrs diisi min 5 karakter
            'password' => 'required|min:5',
            //level hrs diisi angka
            'level_id' => 'required|integer'
        ]);

        UserModel::find($id)->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data User berhasil diubah');
    }

    public function destroy(string $id)
    {
        $check = UserModel::find($id);
        
        //utk cek apa data user dg id yg diambil ada atau tidak
        if (!$check) {
            return redirect('/user')->with('error', 'Data User tidak ditemukan');
        }

        try {
            UserModel::destroy($id); // hps data level
            return redirect('/user')->with('success', 'Data User berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            //jika gagal hps data, tampilkan pesan error
            return redirect('/user')->with('error', 'Data User tidak dapat dihapus');
        }
    }
}
