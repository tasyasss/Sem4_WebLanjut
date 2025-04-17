@empty($anggota)
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
                <a href="{{ url('/anggota') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/anggota/' . $anggota->anggota_id . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Anggota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria- label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Nomor Anggota</label>
                        <input value="{{ $anggota->anggota_nomor }}" type="text" name="anggota_nomor" id="anggota_nomor"
                            class="form-control" required>
                        <small id="error-anggota_nomor" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Nama Anggota</label>
                        <input value="{{ $anggota->anggota_nama }}" type="text" name="anggota_nama" id="anggota_nama"
                            class="form-control" required>
                        <small id="error-anggota_nama" class="error-text form-text text-danger"></small>
                    </div>
                    
                    <div class="form-group">
                        <label>Alamat</label>
                        <input value="{{ $anggota->alamat }}" type="text" name="alamat" id="alamat"
                        class="form-control" required>
                        <small id="error-alamat" class="error-text form-text text-danger"></small>
                    </div>
                    
                    <div class="form-group">
                        <label>No. HP</label>
                        <input value="{{ $anggota->no_hp }}" type="text" name="no_hp" id="no_hp"
                        class="form-control" required>
                        <small id="error-no_hp" class="error-text form-text text-danger"></small>
                    </div>
                    
                    <div class="form-group">
                        <label>Email</label>
                        <input value="{{ $anggota->email }}" type="text" name="email" id="email"
                            class="form-control" required>
                        <small id="error-email" class="error-text form-text text-danger"></small>
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
                    anggota_nomor: {
                        required: true,
                        minlength: 5,
                        maxlength: 10
                    },
                    anggota_nama: {
                        required: true,
                        maxlength: 50
                    },
                    alamat: {
                        required: true,
                        maxlength: 50
                    },
                    no_hp: {
                        required: true,
                        minlength: 5
                    },
                    email: {
                        required: true,
                        maxlength: 50
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
                                dataAnggota.ajax.reload();
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
