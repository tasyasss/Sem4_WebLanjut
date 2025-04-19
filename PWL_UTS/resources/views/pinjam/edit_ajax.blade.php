@empty($pinjam)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>

                <button type="button" class="close" data-dismiss="modal" aria- label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/pinjam') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/pinjam/' . $pinjam->pinjam_id . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Transaksi Peminjaman</h5>
                    <button type="button" class="close" data-dismiss="modal" aria- label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Nomor Petugas</label>
                        <select name="petugas_id" id="petugas_id" class="form-control" required>
                            <option value="">- Pilih Petugas yang Melayani -</option>
                            @foreach ($petugas as $p)
                                <option {{ $p->petugas_id == $pinjam->petugas_id ? 'selected' : '' }} value="{{ $p->petugas_id }}">
                                    {{ $p->petugas_nomor }} - {{ $p->petugas_nama }}</option>
                            @endforeach
                        </select>
                        <small id="error-petugas_id" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Anggota</label>
                        <select name="anggota_id" id="anggota_id" class="form-control" required>
                            <option value="">- Pilih Anggota yang Meminjam -</option>
                            @foreach ($anggota as $a)
                                <option {{ $a->anggota_id == $pinjam->anggota_id ? 'selected' : '' }} value="{{ $a->anggota_id }}">
                                    {{ $a->anggota_nomor }} - {{ $a->anggota_nama }}</option>
                            @endforeach
                        </select>
                        <small id="error-anggota_id" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Buku</label>
                        <select name="buku_id" id="buku_id" class="form-control" required>
                            <option value="">- Pilih Buku yang Dipinjam -</option>
                            @foreach ($buku as $b)
                                <option {{ $b->buku_id == $pinjam->buku_id ? 'selected' : '' }} value="{{ $b->buku_id }}">
                                    {{ $b->buku_kode }} - {{ $b->buku_judul }}</option>
                            @endforeach
                        </select>
                        <small id="error-buku_id" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#form-edit").validate({
                rules: {
                    petugas_id: {
                        required: true,
                        number: true
                    },
                    anggota_id: {
                        required: true,
                        number: true
                    },
                    buku_id: {
                        required: true,
                        number: true
                    },
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataPinjam.ajax.reload();
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endempty
