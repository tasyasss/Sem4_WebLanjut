<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\LevelModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
                $btn =  '<button onclick="modalAction(\''.url('/user/' . $user->user_id .'/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';

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

    public function edit_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();
        return view('user.edit_ajax',['user' => $user, 'level' => $level]);
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

    public function update_ajax(Request $request, $id){
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|max:20|unique:m_user,username,'.$id.',user_id',
                'nama' => 'required|max:100',
                'password' => 'nullable|min:6|max:20'
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }
            $check = UserModel::find($id);
            if ($check) {
                if(!$request->filled('password') ){ // jika password tidak diisi, maka hapus dari req
                    $request->request->remove('password');
                }
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else{
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
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

    public function confirm_ajax(string $id)    
    {
        $user = UserModel::find($id);
        return view('user.confirm_ajax', ['user' => $user]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModel::find($id);
            if ($user) {
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function import()
    {
        return view('user.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_user' => ['required', 'mimes:xlsx,xls', 'max:1024'],
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            try {
                $file = $request->file('file_user');
                $spreadsheet = IOFactory::load($file->getRealPath());
                $sheet = $spreadsheet->getActiveSheet();
                $rows = $sheet->toArray();

                $insert = [];
                $header = array_shift($rows); // Ambil header

                foreach ($rows as $row) {
                    if (!empty($row[0])) {
                        $insert[] = [
                            'level_id' => $row[0],
                            'username' => $row[1],
                            'nama' => $row[2],
                            'password' => bcrypt($row[3]),
                            'created_at' => now(),
                        ];
                    }
                }

                if (!empty($insert)) {
                    userModel::insertOrIgnore($insert);
                    return response()->json([
                        'status' => true,
                        'message' => 'Data user berhasil diimport: ' . count($insert) . ' record'
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Tidak ada data yang diimport'
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        }
        
        return response()->json([
            'status' => false,
            'message' => 'Request tidak valid'
        ]);
    }
}
