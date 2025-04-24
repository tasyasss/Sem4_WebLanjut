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
    // menampilkan halaman awal peminjaman
    public function index()
    {
        // Mengatur breadcrumb dan judul halaman
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

        // Mengirim data ke view index
        return view('pinjam.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'petugas' => $petugas,
            'anggota' => $anggota,
            'activeMenu' => $activeMenu
        ]);
    }

    // menampilkan data transaksi pinjam dlm json utk datatables
    public function list(Request $request)
    {
        // Ambil data transaksi pinjam beserta relasi
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

        // Kembalikan hasil dalam format DataTables
        return DataTables::of($pinjam1)
            // menambahkan kolom index
            ->addIndexColumn()
            // Menambahkan tombol aksi untuk modal (detail, edit, hapus)
            ->addColumn('aksi', function ($pinjam) {
                $btn =  '<button onclick="modalAction(\'' . url('/pinjam/' . $pinjam->pinjam_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/pinjam/' . $pinjam->pinjam_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/pinjam/' . $pinjam->pinjam_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        // Ambil data relasi untuk dropdown pilihan
        $petugas = PetugasModel::select('petugas_id', 'petugas_nomor', 'petugas_nama')->get();
        $anggota = AnggotaModel::select('anggota_id', 'anggota_nomor', 'anggota_nama')->get();
        $buku    = BukuModel::select('buku_id', 'buku_kode', 'buku_judul')->get();

        // Kembalikan view form create modal
        return view('pinjam.create_ajax')->with('petugas', $petugas)->with('anggota', $anggota)->with('buku', $buku);
    }

    public function store_ajax(Request $request)
    {
        // Validasi dan simpan data baru via AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'petugas_id'   => 'required|integer',
                'anggota_id'   => 'required|integer',
                'buku_id'      => 'required|integer|unique:t_pinjam,buku_id', // buku hanya boleh dipinjam satu kali
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                // Jika validasi gagal, kirim response JSON berisi pesan error
                return response()->json([
                    'status' => false, //response status
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), //pesan error validasi
                ]);
            }

            // Simpan data baru ke database
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

        // Redirect jika bukan AJAX
        redirect('/');
    }

    public function show_ajax(string $id)
    {
        // Tampilkan detail data peminjaman berdasarkan ID
        $pinjam = PinjamModel::with('petugas', 'anggota', 'buku')->find($id);
        return view('pinjam.show_ajax', [
            'pinjam' => $pinjam
        ]);
    }

    public function edit_ajax(string $id)
    {
        // Ambil data yang akan diedit dan relasi untuk dropdown
        $pinjam = PinjamModel::find($id);
        $petugas = PetugasModel::select('petugas_id', 'petugas_nomor', 'petugas_nama')->get();
        $anggota = AnggotaModel::select('anggota_id', 'anggota_nomor', 'anggota_nama')->get();
        $buku    = BukuModel::select('buku_id', 'buku_kode', 'buku_judul')->get();

        return view('pinjam.edit_ajax', ['pinjam' => $pinjam, 'petugas' => $petugas, 'anggota' => $anggota, 'buku' => $buku]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'petugas_id'   => 'required|integer',
                'anggota_id'   => 'required|integer',
                'buku_id'      => 'required|integer|unique:t_pinjam,buku_id,' . $id . ',pinjam_id', // unik kecuali untuk ID yang sedang diupdate
            ];

            // validasi data
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
                // update data
                $check->update([
                    'petugas_id'    => $request->petugas_id,
                    'anggota_id'    => $request->anggota_id,
                    'buku_id'       => $request->buku_id
                ]);
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
        // Menampilkan form konfirmasi penghapusan
        $pinjam = PinjamModel::find($id);
        return view('pinjam.confirm_ajax', ['pinjam' => $pinjam]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $pinjam = PinjamModel::find($id);
            if ($pinjam) {
                // hapus data dari database
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
