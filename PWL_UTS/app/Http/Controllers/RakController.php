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
}
