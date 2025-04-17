<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\KategoriModel;
use App\Models\RakModel;
use App\Models\BukuModel;

class BukuController extends Controller
{
    public function index() // menampilkan halaman awal buku
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Buku',
            'list' => ['Home', 'Buku']
        ];

        $page = (object) [
            'title' => 'Daftar Buku yang terdaftar',
        ];

        $activeMenu = 'buku'; // set menu yg sedang aktif

        $kategori = KategoriModel::all(); //ambil data kategori utk filter kategori
        $rak = RakModel::all(); //ambil data rak utk filter rak

        return view('buku.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 
        'kategori' => $kategori, 'rak' => $rak, 'activeMenu' => $activeMenu]);
    }

    // menampilkan data buku dlm json utk datatables
    public function list(Request $request)
    {
        $buku1 = BukuModel::select('buku_id', 'buku_kode', 'buku_judul', 'buku_penulis', 
        'buku_penerbit', 'tahun_terbit', 'kategori_id', 'rak_id')->with('kategori', 'rak');
        
        // filter data berdasarkan kategori_id
        if ($request->kategori_id) {
            $buku1->where('kategori_id', $request->kategori_id);
        }

        // filter data berdasarkan rak_id
        if ($request->rak_id) {
            $buku1->where('rak_id', $request->rak_id);
        }

        return DataTables::of($buku1)
            // menambahkan kolom index
            ->addIndexColumn()
            ->addColumn('aksi', function ($buku) {
                $btn =  '<button onclick="modalAction(\''.url('/buku/' . $buku->buku_id .'/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/buku/' . $buku->buku_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/buku/' . $buku->buku_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}
