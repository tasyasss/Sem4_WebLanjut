<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\AnggotaModel;

class AnggotaController extends Controller
{
    public function index() // menampilkan halaman awal anggota
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Anggota',
            'list' => ['Home', 'Anggota']
        ];

        $page = (object) [
            'title' => 'Daftar Anggota yang terdaftar',
        ];

        $activeMenu = 'anggota'; // set menu yg sedang aktif

        return view('anggota.index', ['breadcrumb' => $breadcrumb, 
        'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $anggota1 = AnggotaModel::select('anggota_id', 'anggota_nomor', 'anggota_nama', 'alamat', 'no_hp', 'email');

        return DataTables::of($anggota1)
            ->addIndexColumn()
            ->addColumn('aksi', function ($anggota) { 
                $btn =  '<button onclick="modalAction(\''.url('/anggota/' . $anggota->anggota_id .'/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/anggota/' . $anggota->anggota_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/anggota/' . $anggota->anggota_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) 
            ->make(true);
    }

    public function create_ajax()
    {
        return view('anggota.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'anggota_nomor' => 'required|string|min:5|unique:m_anggota,anggota_nomor',
                'anggota_nama'  => 'required|string|max:50',
                'alamat'        => 'required|string|max:50',
                'no_hp'         => 'required|string|min:5',
                'email'         => 'required|string|max:50'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, //response status
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), //pesan error validasi
                ]);
            }

            AnggotaModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data Anggota berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    public function show_ajax(string $id)
    {
        $anggota = AnggotaModel::find($id);
        return view('anggota.show_ajax', [
            'anggota' => $anggota
        ]);
    }


    public function edit_ajax(string $id)
    {
        $anggota = AnggotaModel::find($id);
        return view('anggota.edit_ajax', ['anggota' => $anggota]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'anggota_nomor' => 'required|string|min:5|unique:m_anggota,anggota_nomor',
                'anggota_nama'  => 'required|string|max:50',
                'alamat'        => 'required|string|max:50',
                'no_hp'         => 'required|string|min:5',
                'email'         => 'required|string|max:50'
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
            $check = AnggotaModel::find($id);
            if ($check) {
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
        $anggota = AnggotaModel::find($id);
        return view('anggota.confirm_ajax', ['anggota' => $anggota]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $anggota = AnggotaModel::find($id);
            if ($anggota) {
                $anggota->delete();
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
