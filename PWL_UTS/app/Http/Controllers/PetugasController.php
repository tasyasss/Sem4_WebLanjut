<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\PetugasModel;

class PetugasController extends Controller
{
    public function index() // menampilkan halaman awal petugas
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Petugas',
            'list' => ['Home', 'Petugas']
        ];

        $page = (object) [
            'title' => 'Daftar Petugas yang terdaftar',
        ];

        $activeMenu = 'petugas'; // set menu yg sedang aktif

        return view('petugas.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $petugas1 = PetugasModel::select('petugas_id', 'petugas_nomor', 'petugas_nama', 'email', 'username');

        return DataTables::of($petugas1)
            ->addIndexColumn()
            ->addColumn('aksi', function ($petugas) {
                $btn =  '<button onclick="modalAction(\'' . url('/petugas/' . $petugas->petugas_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/petugas/' . $petugas->petugas_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/petugas/' . $petugas->petugas_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        return view('petugas.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'petugas_nomor' => 'required|string|min:5|unique:m_petugas,petugas_nomor',
                'petugas_nama'  => 'required|string|max:50',
                'email'         => 'required|string|max:50',
                'username'      => 'required|string|max:20',
                'password'      => 'required|min:5'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, //response status
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), //pesan error validasi
                ]);
            }

            PetugasModel::create([
                'petugas_nomor' => $request->petugas_nomor,
                'petugas_nama'  => $request->petugas_nama,
                'email'         => $request->email,
                'username'      => $request->username,
                'password'      => Hash::make($request->password),
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Data petugas berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    public function show_ajax(string $id)
    {
        $petugas = PetugasModel::find($id);
        return view('petugas.show_ajax', [
            'petugas' => $petugas
        ]);
    }


    public function edit_ajax(string $id)
    {
        $petugas = PetugasModel::find($id);
        return view('petugas.edit_ajax', ['petugas' => $petugas]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'petugas_nomor' => 'required|string|min:5|unique:m_petugas,petugas_nomor',
                'petugas_nama'  => 'required|string|max:50',
                'email'         => 'required|string|max:50',
                'username'      => 'required|string|max:20|unique:m_petugas,username,' . $id . ',petugas_id',
                'password'      => 'nullable|min:5'
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
            $check = PetugasModel::find($id);
            if ($check) {
                if (!$request->filled('password')) { // jika password tidak diisi, maka hapus dari req
                    $request->request->remove('password');
                }
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
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

    public function confirm_ajax(string $id)
    {
        $petugas = PetugasModel::find($id);
        return view('petugas.confirm_ajax', ['petugas' => $petugas]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $petugas = PetugasModel::find($id);
            if ($petugas) {
                $petugas->delete();
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
}
