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
    // Menampilkan halaman awal daftar buku
    public function index() 
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

    // Mengambil data buku dan mengembalikannya dalam format DataTables
    public function list(Request $request)
    {
        // Mengambil data buku yang dibutuhkan
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

        // Mengembalikan data buku dalam format DataTables
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

    // Menampilkan form untuk menambah buku via AJAX
    public function create_ajax()
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get(); 
        $rak = RakModel::select('rak_id', 'rak_nama')->get();
        return view('buku.create_ajax')->with('kategori', $kategori)->with('rak', $rak);
    }

    // Menyimpan data buku baru melalui AJAX setelah validasi
    public function store_ajax(Request $request)
    {
        if($request->ajax() || $request->wantsJson()) {
            // Definisi aturan validasi
            $rules = [
                 'kategori_id'   => 'required|integer',
                 'rak_id'        => 'required|integer',
                 'buku_kode'     => 'required|string|min:5|unique:m_buku,buku_kode',
                 'buku_judul'    => 'required|string|max:50',
                 'buku_penulis'  => 'required|string|max:50',
                 'buku_penerbit' => 'required|string|max:50',
                 'tahun_terbit'  => 'required|digits:4|integer'
            ];
 
            // Melakukan validasi terhadap input
            $validator = Validator::make($request->all(), $rules);
 
            if ($validator->fails()) {
                // Mengembalikan response jika validasi gagal
                return response()->json([
                    'status' => false, //response status
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), //pesan error validasi
                ]);
            }
 
            // Menyimpan data buku baru ke database
            BukuModel::create([
                'kategori_id'    => $request->kategori_id,
                'rak_id'         => $request->rak_id,
                'buku_kode'      => $request->buku_kode,
                'buku_judul'     => $request->buku_judul,
                'buku_penulis'   => $request->buku_penulis,
                'buku_penerbit'  => $request->buku_penerbit,
                'tahun_terbit'   => $request->tahun_terbit, // pastikan integer
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Data Buku berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    // Menampilkan detail buku berdasarkan ID
    public function show_ajax(string $id)
    {
        $buku = BukuModel::with('kategori', 'rak')->find($id);
        return view('buku.show_ajax', [
            'buku' => $buku
        ]);
    }

    // Menampilkan form edit buku berdasarkan ID
    public function edit_ajax(string $id)
    {
        $buku = BukuModel::find($id);
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();
        $rak = RakModel::select('rak_id', 'rak_nama')->get();
        return view('buku.edit_ajax',['buku' => $buku, 'kategori' => $kategori, 'rak' => $rak]);
    }

    // Menyimpan perubahan data buku melalui AJAX
    public function update_ajax(Request $request, $id){
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id'   => 'required|integer',
                'rak_id'        => 'required|integer',
                'buku_kode'     => 'required|string|min:5|unique:m_buku,buku_kode,'.$id.',buku_id',
                'buku_judul'    => 'required|string|max:50',
                'buku_penulis'  => 'required|string|max:50',
                'buku_penerbit' => 'required|string|max:50',
                'tahun_terbit'  => 'required|digits:4|integer'
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
            // Mencari buku berdasarkan ID dan memperbarui datanya
            $check = BukuModel::find($id);
            if ($check) {
                $check->update([
                    'kategori_id'   => $request->kategori_id,
                    'rak_id'        => $request->rak_id,
                    'buku_kode'     => $request->buku_kode,
                    'buku_judul'    => $request->buku_judul,
                    'buku_penulis'  => $request->buku_penulis,
                    'buku_penerbit' => $request->buku_penerbit,
                    'tahun_terbit'  => (int) $request->tahun_terbit,
                ]);
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

    // Menampilkan konfirmasi penghapusan buku berdasarkan ID
    public function confirm_ajax(string $id)    
    {
        $buku = BukuModel::find($id);
        return view('buku.confirm_ajax', ['buku' => $buku]);
    }

    // Menghapus anggota berdasarkan ID
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $buku = BukuModel::find($id);
            if ($buku) {
                $buku->delete();
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
