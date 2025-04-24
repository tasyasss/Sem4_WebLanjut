@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                {{-- Tombol untuk membuka modal dengan AJAX untuk menambah data anggota --}}
                <button onclick="modalAction('{{ url('anggota/create_ajax') }}')" class="btn btn-sm btn-success mt-1">
                    Tambah Ajax</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <!-- Menampilkan pesan sukses jika ada -->
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <!-- Menampilkan pesan error jika ada -->
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <!-- Tabel anggota yang menampilkan data dari server -->
            <table class="table table-bordered table-hover table-sm" id="table_anggota">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nomor Anggota</th>
                        <th>Nama Anggota</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- Modal untuk form tambah/edit anggota -->
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" databackdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
    <!-- Tambahkan custom CSS di sini jika diperlukan -->
@endpush

@push('js')
    <script>
        // Fungsi untuk memuat modal dengan URL yang diberikan
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var dataAnggota;
        $(document).ready(function() {
            // Inisialisasi DataTable dengan pengaturan server-side
            dataAnggota = $('#table_anggota').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('anggota/list') }}", // URL untuk mengambil data anggota
                    dataType: "json", // Tipe data yang diharapkan
                    type: "POST" // Metode HTTP yang digunakan
                },
                columns: [
                    {
                        data: "DT_RowIndex", // Menampilkan nomor urut
                        className: "text-center", // Menyentralkan teks di kolom
                        orderable: false, // Tidak bisa diurutkan
                        searchable: false // Tidak bisa dicari
                    },
                    {
                        data: "anggota_nomor", // Menampilkan nomor anggota
                        orderable: true, // Bisa diurutkan
                        searchable: true // Bisa dicari
                    },
                    {
                        data: "anggota_nama", // Menampilkan nama anggota
                        orderable: true, // Bisa diurutkan
                        searchable: true // Bisa dicari
                    },
                    {
                        data: "alamat", // Menampilkan alamat anggota
                        orderable: false, // Tidak bisa diurutkan
                        searchable: false // Tidak bisa dicari
                    },
                    {
                        data: "no_hp", // Menampilkan nomor HP anggota
                        orderable: false, // Tidak bisa diurutkan
                        searchable: false // Tidak bisa dicari
                    },
                    {
                        data: "email", // Menampilkan email anggota
                        orderable: false, // Tidak bisa diurutkan
                        searchable: false // Tidak bisa dicari
                    },
                    {
                        data: "aksi", // Menampilkan tombol aksi (edit, hapus, dll.)
                        orderable: false, // Tidak bisa diurutkan
                        searchable: false // Tidak bisa dicari
                    }
                ]
            });
        });
    </script>
@endpush
