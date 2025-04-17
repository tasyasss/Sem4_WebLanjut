@empty($petugas)
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
                <a href="{{ url('/petugas') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/petugas/' . $petugas->petugas_id . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Petugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria- label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Nomor Petugas</label>
                        <input value="{{ $petugas->petugas_nomor }}" type="text" name="petugas_nomor" id="petugas_nomor"
                            class="form-control" required>
                        <small id="error-petugas_nomor" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Nama Petugas</label>
                        <input value="{{ $petugas->petugas_nama }}" type="text" name="petugas_nama" id="petugas_nama"
                            class="form-control" required>
                        <small id="error-petugas_nama" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input value="{{ $petugas->email }}" type="text" name="email" id="email"
                            class="form-control" required>
                        <small id="error-email" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input value="{{ $petugas->username }}" type="text" name="username" id="username"
                            class="form-control" required>
                        <small id="error-username" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input value="" type="password" name="password" id="password" class="form-control">
                        <small class="form-text text-muted">Abaikan jika tidak ingin ubah password</small>
                        <small id="error-password" class="error-text form-text text-danger"></small>
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
                    petugas_nomor: {
                        required: true,
                        minlength: 5,
                        maxlength: 10
                    },
                    petugas_nama: {
                        required: true,
                        maxlength: 50
                    },
                    email: {
                        required: true,
                        maxlength: 50
                    },
                    username: {
                        required: true,
                        minlength: 5,
                        maxlength: 20
                    },
                    password: {
                        minlength: 5
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
                                dataPetugas.ajax.reload();
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
