<form action="{{ url('/buku/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Kategori Buku</label>
                    <select name="kategori_id" id="kategori_id" class="form-control" required>
                        <option value="">- Pilih Kategori Buku -</option>
                        @foreach ($kategori as $k)
                            <option value="{{ $k->kategori_id }}">{{ $k->kategori_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-kategori_id" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Rak Buku</label>
                    <select name="rak_id" id="rak_id" class="form-control" required>
                        <option value="">- Pilih Rak Buku -</option>
                        @foreach ($rak as $r)
                            <option value="{{ $r->rak_id }}">{{ $r->rak_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-rak_id" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Kode Buku</label>
                    <input value="" type="text" name="buku_kode" id="buku_kode" class="form-control"
                        required>
                    <small id="error-buku_kode" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Judul Buku</label>
                    <input value="" type="text" name="buku_judul" id="buku_judul" class="form-control"
                        required>
                    <small id="error-buku_judul" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Penulis</label>
                    <input value="" type="text" name="buku_penulis" id="buku_penulis" class="form-control" required>
                    <small id="error-buku_penulis" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Penerbit</label>
                    <input value="" type="text" name="buku_penerbit" id="buku_penerbit" class="form-control" required>
                    <small id="error-buku_penerbit" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Tahun Terbit</label>
                    <input value="" type="number" name="tahun_terbit" id="tahun_terbit" class="form-control" required>
                    <small id="error-tahun_terbit" class="error-text form-text text-danger"></small>
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
        $("#form-tambah").validate({
            rules: {
                kategori_id: {
                    required: true,
                    number: true
                },
                rak_id: {
                    required: true,
                    number: true
                },
                buku_kode: {
                    required: true,
                    minlength: 5
                },
                buku_judul: {
                    required: true,
                    maxlength: 50
                },
                buku_penulis: {
                    required: true,
                    maxlength: 50
                },
                buku_penerbit: {
                    required: true,
                    maxlength: 50
                },
                tahun_terbit: {
                    required: true,
                    minlength: 4
                }
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
                            dataBuku.ajax.reload();
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
