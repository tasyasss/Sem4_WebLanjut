<!-- Form tambah anggota dengan AJAX -->
<form action="{{ url('/anggota/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <!-- Modal dialog -->
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Header modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Anggota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Body modal -->
            <div class="modal-body">
                <!-- Input: Nomor Anggota -->
                <div class="form-group">
                    <label>Nomor Anggota</label>
                    <input type="text" name="anggota_nomor" id="anggota_nomor" class="form-control" required>
                    <small id="error-anggota_nomor" class="error-text form-text text-danger"></small>
                </div>

                <!-- Input: Nama Anggota -->
                <div class="form-group">
                    <label>Nama Anggota</label>
                    <input type="text" name="anggota_nama" id="anggota_nama" class="form-control" required>
                    <small id="error-anggota_nama" class="error-text form-text text-danger"></small>
                </div>

                <!-- Input: Alamat -->
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" required>
                    <small id="error-alamat" class="error-text form-text text-danger"></small>
                </div>

                <!-- Input: No. HP -->
                <div class="form-group">
                    <label>No. HP</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control" required>
                    <small id="error-no_hp" class="error-text form-text text-danger"></small>
                </div>

                <!-- Input: Email -->
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" id="email" class="form-control" required>
                    <small id="error-email" class="error-text form-text text-danger"></small>
                </div>
            </div>

            <!-- Footer modal -->
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<!-- Validasi dan AJAX request -->
<script>
    $(document).ready(function() {
        $("#form-tambah").validate({
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
            // Ketika form valid, kirim via AJAX
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            // Jika sukses, tutup modal, tampilkan pesan, dan reload datatable
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataAnggota.ajax.reload();
                        } else {
                            // Jika error, tampilkan pesan error di bawah input
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
            // Setup error placement
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            // Tambahkan class is-invalid saat error
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            // Hapus class is-invalid jika sudah valid
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
