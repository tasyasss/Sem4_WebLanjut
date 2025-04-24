<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\PetugasModel;

class PetugasController extends Controller
{
    /**
     * Menampilkan halaman utama daftar petugas.
     */
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Petugas',
            'list' => ['Home', 'Petugas']
        ];

        $page = (object) [
            'title' => 'Daftar Petugas yang terdaftar',
        ];

        return view('petugas.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => 'petugas'
        ]);
    }

    /**
     * Mengembalikan data petugas dalam format DataTables.
     */
    public function list(Request $request)
    {
        $petugas = PetugasModel::select('petugas_id', 'petugas_nomor', 'petugas_nama', 'email', 'username');

        return DataTables::of($petugas)
            ->addIndexColumn()
            ->addColumn('aksi', function ($petugas) {
                $urlBase = url('/petugas/' . $petugas->petugas_id);
                return '
                    <button onclick="modalAction(\'' . $urlBase . '/show_ajax\')" class="btn btn-info btn-sm">Detail</button>
                    <button onclick="modalAction(\'' . $urlBase . '/edit_ajax\')" class="btn btn-warning btn-sm">Edit</button>
                    <button onclick="modalAction(\'' . $urlBase . '/delete_ajax\')" class="btn btn-danger btn-sm">Hapus</button>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        return view('petugas.create_ajax');
    }

    /**
     * Menyimpan data petugas baru dari request AJAX.
     */
    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $validator = Validator::make($request->all(), [
                'petugas_nomor' => 'required|string|min:5|unique:m_petugas,petugas_nomor',
                'petugas_nama'  => 'required|string|max:50',
                'email'         => 'required|string|max:50',
                'username'      => 'required|string|max:20',
                'password'      => 'required|min:5'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            PetugasModel::create([
                'petugas_nomor' => $request->petugas_nomor,
                'petugas_nama'  => $request->petugas_nama,
                'email'         => $request->email,
                'username'      => $request->username,
                'password'      => Hash::make($request->password),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data petugas berhasil disimpan'
            ]);
        }

        return redirect('/');
    }

    public function show_ajax(string $id)
    {
        $petugas = PetugasModel::find($id);

        return view('petugas.show_ajax', [
            'petugas' => $petugas
        ]);
    }

    public function edit_ajax(string $id)
    {
        $petugas = PetugasModel::find($id);

        return view('petugas.edit_ajax', ['petugas' => $petugas]);
    }

    /**
     * Memperbarui data petugas berdasarkan request AJAX.
     */
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $validator = Validator::make($request->all(), [
                'petugas_nomor' => 'required|string|min:5|unique:m_petugas,petugas_nomor,' . $id . ',petugas_id',
                'petugas_nama'  => 'required|string|max:50',
                'email'         => 'required|string|max:50',
                'username'      => 'required|string|max:20|unique:m_petugas,username,' . $id . ',petugas_id',
                'password'      => 'nullable|min:5'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $petugas = PetugasModel::find($id);

            if ($petugas) {
                $data = $request->except(['password']);
                if ($request->filled('password')) {
                    $data['password'] = Hash::make($request->password);
                }
                $petugas->update($data);

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $petugas = PetugasModel::find($id);

        return view('petugas.confirm_ajax', ['petugas' => $petugas]);
    }

    /**
     * Menghapus data petugas berdasarkan request AJAX.
     */
    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $petugas = PetugasModel::find($id);

            if ($petugas) {
                $petugas->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        return redirect('/');
    }
}
