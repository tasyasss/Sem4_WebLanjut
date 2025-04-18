<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\RakModel;

class RakController extends Controller
{
    public function index() // menampilkan halaman awal rak
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Rak',
            'list' => ['Home', 'Rak']
        ];

        $page = (object) [
            'title' => 'Daftar Rak yang terdaftar',
        ];

        $activeMenu = 'rak'; // set menu yg sedang aktif

        return view('rak.index', ['breadcrumb' => $breadcrumb, 
        'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $rak1 = RakModel::select('rak_id', 'rak_kode', 'rak_nama');

        return DataTables::of($rak1)
            ->addIndexColumn()
            ->addColumn('aksi', function ($rak) { 
                $btn =  '<button onclick="modalAction(\''.url('/rak/' . $rak->rak_id .'/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/rak/' . $rak->rak_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/rak/' . $rak->rak_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) 
            ->make(true);
    }

    public function create_ajax()
    {
        return view('rak.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'rak_kode' => 'required|string|min:5|unique:m_rak,rak_kode',
                'rak_nama'  => 'required|string|max:20'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, //response status
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), //pesan error validasi
                ]);
            }

            RakModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data Rak berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    public function show_ajax(string $id)
    {
        $rak = RakModel::find($id);
        return view('rak.show_ajax', [
            'rak' => $rak
        ]);
    }


    public function edit_ajax(string $id)
    {
        $rak = RakModel::find($id);
        return view('rak.edit_ajax', ['rak' => $rak]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'rak_kode' => 'required|string|min:5|unique:m_rak,rak_kode',
                'rak_nama'  => 'required|string|max:20'
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
            $check = RakModel::find($id);
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
        $rak = RakModel::find($id);
        return view('rak.confirm_ajax', ['rak' => $rak]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rak = RakModel::find($id);
            if ($rak) {
                $rak->delete();
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
