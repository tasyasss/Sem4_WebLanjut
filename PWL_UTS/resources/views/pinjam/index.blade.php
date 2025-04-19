@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                {{-- <a class="btn btn-sm btn-primary mt-1" href="{{ url('pinjam/create') }}">Tambah</a> --}}
                <button onclick="modalAction('{{ url('pinjam/create_ajax') }}')" class="btn btn-sm btn-success mt-1">
                    Tambah Ajax</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select class="form-control" name="petugas_id" id="petugas_id" required>
                                <option value="">- Semua -</option>
                                @foreach ($petugas as $item)
                                    <option value="{{ $item->petugas_id }}">{{ $item->petugas_nomor }} - {{ $item->petugas_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Petugas</small>
                        </div>
                        <div class="col-3">
                            <select class="form-control" name="anggota_id" id="anggota_id" required>
                                <option value="">- Semua -</option>
                                @foreach ($anggota as $item)
                                    <option value="{{ $item->anggota_id }}">{{ $item->anggota_nomor }} - {{ $item->anggota_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Anggota</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_pinjam">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>No. Petugas</th>
                        <th>Nama Petugas</th>
                        <th>No. Anggota</th>
                        <th>Nama Anggota</th>
                        <th>Kode Buku</th>
                        <th>Judul Buku</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" databackdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
        var dataPinjam;
        $(document).ready(function() {
            dataPinjam = $('#table_pinjam').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                serverSide: true,
                ajax: {
                    "url": "{{ url('pinjam/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.petugas_id = $('#petugas_id').val();
                        d.anggota_id = $('#anggota_id').val();
                        d.buku_id = $('#buku_id').val();
                    }
                },
                columns: [{
                    // nomor urut dari laravel datatable addIndexColumn()
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    // mengambil data petugas hasil dari ORM berelasi
                    data: "petugas.petugas_nomor",
                    className: "",
                    orderable: false,
                    searchable: true
                }, {
                    // mengambil data petugas hasil dari ORM berelasi
                    data: "petugas.petugas_nama",
                    className: "",
                    orderable: false,
                    searchable: true
                }, {
                    // mengambil data anggota hasil dari ORM berelasi
                    data: "anggota.anggota_nomor",
                    className: "",
                    orderable: false,
                    searchable: true
                }, {
                    // mengambil data anggota hasil dari ORM berelasi
                    data: "anggota.anggota_nama",
                    className: "",
                    orderable: false,
                    searchable: true
                }, {
                    // mengambil data buku hasil dari ORM berelasi
                    data: "buku.buku_kode",
                    className: "",
                    orderable: false,
                    searchable: true
                }, {
                    // mengambil data buku hasil dari ORM berelasi
                    data: "buku.buku_judul",
                    className: "",
                    orderable: false,
                    searchable: true
                }, {
                    data: "aksi",
                    className: "",
                    orderable: false,
                    searchable: false
                }]
            });

            $('#petugas_id').on('change', function() {
                dataPinjam.ajax.reload();
            });

            $('#anggota_id').on('change', function() {
                dataPinjam.ajax.reload();
            });
        });
    </script>
@endpush
