<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\PetugasModel;
use App\Models\AnggotaModel;
use App\Models\BukuModel;
use App\Models\PinjamModel;

class PinjamController extends Controller
{
    public function index() // menampilkan halaman awal peminjaman
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Peminjaman',
            'list' => ['Home', 'Peminjaman']
        ];

        $page = (object) [
            'title' => 'Transaksi Peminjaman yang terdaftar',
        ];

        $activeMenu = 'pinjam'; // set menu yg sedang aktif

        $petugas = PetugasModel::all(); //ambil data petugas utk filter petugas
        $anggota = AnggotaModel::all(); //ambil data anggota utk filter anggota

        return view('pinjam.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 
        'petugas' => $petugas, 'anggota' => $anggota, 'activeMenu' => $activeMenu]);
    }

    // menampilkan data transaksi pinjam dlm json utk datatables
    public function list(Request $request)
    {
        $pinjam1 = PinjamModel::select('pinjam_id', 'petugas_id', 'anggota_id', 'buku_id')
        ->with('petugas', 'anggota', 'buku');
        
        // filter data berdasarkan petugas_id
        if ($request->petugas_id) {
            $pinjam1->where('petugas_id', $request->petugas_id);
        }

        // filter data berdasarkan anggota_id
        if ($request->anggota_id) {
            $pinjam1->where('anggota_id', $request->anggota_id);
        }

        return DataTables::of($pinjam1)
            // menambahkan kolom index
            ->addIndexColumn()
            ->addColumn('aksi', function ($pinjam) {
                $btn =  '<button onclick="modalAction(\''.url('/pinjam/' . $pinjam->pinjam_id .'/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/pinjam/' . $pinjam->pinjam_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/pinjam/' . $pinjam->pinjam_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        $petugas = PetugasModel::select('petugas_id', 'petugas_nomor', 'petugas_nama')->get(); 
        $anggota = AnggotaModel::select('anggota_id', 'anggota_nomor', 'anggota_nama')->get();
        $buku    = BukuModel::select('buku_id', 'buku_kode', 'buku_judul')->get();
        return view('pinjam.create_ajax')->with('petugas', $petugas)->with('anggota', $anggota)->with('buku', $buku);
    }

    public function store_ajax(Request $request)
    {
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                 'petugas_id'   => 'required|integer',
                 'anggota_id'   => 'required|integer',
                 'buku_id'      => 'required|integer|unique:t_pinjam,buku_id',
            ];
 
            $validator = Validator::make($request->all(), $rules);
 
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, //response status
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), //pesan error validasi
                ]);
            }
 
            PinjamModel::create([
                'petugas_id'    => $request->petugas_id,
                'anggota_id'    => $request->anggota_id,
                'buku_id'       => $request->buku_id,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Transaksi Peminjaman berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    public function show_ajax(string $id)
    {
        $pinjam = PinjamModel::with('petugas', 'anggota', 'buku')->find($id);
        return view('pinjam.show_ajax', [
            'pinjam' => $pinjam
        ]);
    }


    public function edit_ajax(string $id)
    {
        $pinjam = PinjamModel::find($id);
        $petugas = PetugasModel::select('petugas_id', 'petugas_nomor', 'petugas_nama')->get();
        $anggota = AnggotaModel::select('anggota_id', 'anggota_nomor', 'anggota_nama')->get();
        $buku    = BukuModel::select('buku_id', 'buku_kode', 'buku_judul')->get();
        return view('pinjam.edit_ajax',['pinjam' => $pinjam, 'petugas' => $petugas, 'anggota' => $anggota, 'buku' => $buku]);
    }

    public function update_ajax(Request $request, $id){
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'petugas_id'   => 'required|integer',
                'anggota_id'   => 'required|integer',
                'buku_id'      => 'required|integer|unique:t_pinjam,buku_id,'.$id.',pinjam_id',
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
            $check = PinjamModel::find($id);
            if ($check) {
                $check->update([
                    'petugas_id'    => $request->petugas_id,
                    'anggota_id'    => $request->anggota_id,
                    'buku_id'       => $request->buku_id
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

    public function confirm_ajax(string $id)    
    {
        $pinjam = PinjamModel::find($id);
        return view('pinjam.confirm_ajax', ['pinjam' => $pinjam]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $pinjam = PinjamModel::find($id);
            if ($pinjam) {
                $pinjam->delete();
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
