<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\AnggotaModel;

class AnggotaController extends Controller
{
    // Menampilkan halaman awal daftar anggota
    public function index() 
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Anggota',
            'list' => ['Home', 'Anggota']
        ];

        $page = (object) [
            'title' => 'Daftar Anggota yang terdaftar',
        ];

        $activeMenu = 'anggota'; // Set menu yang sedang aktif

        return view('anggota.index', ['breadcrumb' => $breadcrumb, 
            'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Mengambil data anggota dan mengembalikannya dalam format DataTables
    public function list(Request $request)
    {
        // Mengambil data anggota yang dibutuhkan
        $anggota1 = AnggotaModel::select('anggota_id', 'anggota_nomor', 'anggota_nama', 'alamat', 'no_hp', 'email');

        // Mengembalikan data anggota dalam format DataTables
        return DataTables::of($anggota1)
            ->addIndexColumn()
            // Menambahkan kolom aksi (Detail, Edit, Hapus)
            ->addColumn('aksi', function ($anggota) { 
                $btn =  '<button onclick="modalAction(\''.url('/anggota/' . $anggota->anggota_id .'/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/anggota/' . $anggota->anggota_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/anggota/' . $anggota->anggota_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // Membuat kolom aksi tidak terformat otomatis
            ->make(true); // Mengembalikan response DataTables dalam format JSON
    }

    // Menampilkan form untuk menambah anggota via AJAX
    public function create_ajax()
    {
        return view('anggota.create_ajax');
    }

    // Menyimpan data anggota baru melalui AJAX setelah validasi
    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Definisi aturan validasi
            $rules = [
                'anggota_nomor' => 'required|string|min:5|unique:m_anggota,anggota_nomor',
                'anggota_nama'  => 'required|string|max:50',
                'alamat'        => 'required|string|max:50',
                'no_hp'         => 'required|string|min:5',
                'email'         => 'required|string|max:50'
            ];

            // Melakukan validasi terhadap input
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                // Mengembalikan response jika validasi gagal
                return response()->json([
                    'status' => false, // Status respon
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), // Pesan error validasi
                ]);
            }

            // Menyimpan data anggota baru ke database
            AnggotaModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data Anggota berhasil disimpan'
            ]);
        }
        return redirect('/'); // Redirect ke halaman utama jika bukan request AJAX
    }

    // Menampilkan detail anggota berdasarkan ID
    public function show_ajax(string $id)
    {
        $anggota = AnggotaModel::find($id);
        return view('anggota.show_ajax', [
            'anggota' => $anggota
        ]);
    }

    // Menampilkan form edit anggota berdasarkan ID
    public function edit_ajax(string $id)
    {
        $anggota = AnggotaModel::find($id);
        return view('anggota.edit_ajax', ['anggota' => $anggota]);
    }

    // Memperbarui data anggota berdasarkan ID
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Aturan validasi
            $rules = [
                'anggota_nomor' => 'required|string|min:5|unique:m_anggota,anggota_nomor',
                'anggota_nama'  => 'required|string|max:50',
                'alamat'        => 'required|string|max:50',
                'no_hp'         => 'required|string|min:5',
                'email'         => 'required|string|max:50'
            ];

            // Validasi input
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                // Mengembalikan respon error jika validasi gagal
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            // Mencari anggota berdasarkan ID dan memperbarui datanya
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
        return redirect('/'); // Redirect jika bukan request AJAX
    }

    // Menampilkan konfirmasi penghapusan anggota berdasarkan ID
    public function confirm_ajax(string $id)
    {
        $anggota = AnggotaModel::find($id);
        return view('anggota.confirm_ajax', ['anggota' => $anggota]);
    }

    // Menghapus anggota berdasarkan ID
    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $anggota = AnggotaModel::find($id);
            if ($anggota) {
                $anggota->delete(); // Menghapus data anggota
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
        return redirect('/'); // Redirect jika bukan request AJAX
    }
}
