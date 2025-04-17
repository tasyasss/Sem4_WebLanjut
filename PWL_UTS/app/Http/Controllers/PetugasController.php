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

        return view('petugas.index', ['breadcrumb' => $breadcrumb, 
        'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $petugas1 = PetugasModel::select('petugas_id', 'petugas_nomor', 'petugas_nama');

        return DataTables::of($petugas1)
            ->addIndexColumn()
            ->addColumn('aksi', function ($petugas) { 
                $btn =  '<button onclick="modalAction(\''.url('/petugas/' . $petugas->petugas_id .'/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/petugas/' . $petugas->petugas_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/petugas/' . $petugas->petugas_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) 
            ->make(true);
    }
}
