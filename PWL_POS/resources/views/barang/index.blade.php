@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/barang/import') }}')" class="btn btn-sm btn-info mt-1">
                    Import Barang
                </button>
                <a href="{{ url('/barang/export_excel') }}" class="btn btn-sm btn-primary mt-1">
                    <i class="fa fa-fileexcel"></i> 
                    Export Barang
                </a>
                <button onclick="modalAction('{{ url('barang/create_ajax') }}')" class="btn btn-sm btn-success mt-1">
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
                        <label for="kategori_id" class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select name="kategori_id" id="kategori_id" class="form-control" required>
                                <option value="">- Semua -</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->kategori_id }}">{{ $item->kategori_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Kategori Barang</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-hover table-sm" id="table_barang">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode Barang</th>
                        <th>Kategori Barang</th>
                        <th>Nama Barang</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
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
    <!-- Tambahkan custom CSS di sini jika diperlukan -->
@endpush

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
        var dataBarang;
        $(document).ready(function() {
            dataBarang = $('#table_barang').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('barang/list') }}",
                    dataType: "json",
                    type: "POST",
                    "data": function(d) {
                        d.kategori_id = $('#kategori_id').val();
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "barang_kode",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "kategori.kategori_nama",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "barang_nama",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "harga_beli",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "harga_jual",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "aksi",
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            $('#kategori_id').on('change', function() {
                dataBarang.ajax.reload();
            });
        });
    </script>
@endpush
