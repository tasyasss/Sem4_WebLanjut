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
}
