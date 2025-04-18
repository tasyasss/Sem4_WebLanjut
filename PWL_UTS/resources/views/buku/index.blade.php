@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                {{-- <a class="btn btn-sm btn-primary mt-1" href="{{ url('buku/create') }}">Tambah</a> --}}
                <button onclick="modalAction('{{ url('buku/create_ajax') }}')" class="btn btn-sm btn-success mt-1">
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
                            <select class="form-control" name="kategori_id" id="kategori_id" required>
                                <option value="">- Semua -</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->kategori_id }}">{{ $item->kategori_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Kategori Buku</small>
                        </div>
                        <div class="col-3">
                            <select class="form-control" name="rak_id" id="rak_id" required>
                                <option value="">- Semua -</option>
                                @foreach ($rak as $item)
                                    <option value="{{ $item->rak_id }}">{{ $item->rak_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Rak Buku</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_buku">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kategori Buku</th>
                        <th>Kode Rak Buku</th>
                        <th>Kode Buku</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tahun Terbit</th>
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
        var dataBuku;
        $(document).ready(function() {
            dataBuku = $('#table_buku').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                serverSide: true,
                ajax: {
                    "url": "{{ url('buku/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.kategori_id = $('#kategori_id').val();
                        d.rak_id = $('#rak_id').val();
                    }
                },
                columns: [{
                    // nomor urut dari laravel datatable addIndexColumn()
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    // mengambil data kategori hasil dari ORM berelasi
                    data: "kategori.kategori_nama",
                    className: "",
                    orderable: true,
                    searchable: false
                }, {
                    // mengambil data rak hasil dari ORM berelasi
                    data: "rak.rak_nama",
                    className: "",
                    orderable: true,
                    searchable: false
                }, {
                    data: "buku_kode",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "buku_judul",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "buku_penulis",
                    className: "",
                    orderable: false,
                    searchable: true
                },{
                    data: "buku_penerbit",
                    className: "",
                    orderable: false,
                    searchable: true
                },{
                    data: "tahun_terbit",
                    className: "",
                    orderable: false,
                    searchable: true
                },{
                    data: "aksi",
                    className: "",
                    orderable: false,
                    searchable: false
                }]
            });

            $('#kategori_id').on('change', function() {
                dataBuku.ajax.reload();
            });

            $('#rak_id').on('change', function() {
                dataBuku.ajax.reload();
            });
        });
    </script>
@endpush
