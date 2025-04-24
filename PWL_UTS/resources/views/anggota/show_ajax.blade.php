<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <!-- Judul modal yang menjelaskan bahwa ini adalah detail anggota -->
            <h5 class="modal-title">Detail Data Anggota</h5>
            <!-- Tombol untuk menutup modal -->
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <!-- Tabel untuk menampilkan detail anggota -->
            <table class="table table-bordered">
                <!-- Menampilkan ID anggota -->
                <tr>
                    <th>ID</th>
                    <td>{{ $anggota->anggota_id }}</td>
                </tr>
                <!-- Menampilkan Nomor Anggota -->
                <tr>
                    <th>Nomor Anggota</th>
                    <td>{{ $anggota->anggota_nomor }}</td>
                </tr>
                <!-- Menampilkan Nama Anggota -->
                <tr>
                    <th>Nama Anggota</th>
                    <td>{{ $anggota->anggota_nama }}</td>
                </tr>
                <!-- Menampilkan Alamat Anggota -->
                <tr>
                    <th>Alamat</th>
                    <td>{{ $anggota->alamat }}</td>
                </tr>
                <!-- Menampilkan Nomor HP Anggota -->
                <tr>
                    <th>No. HP</th>
                    <td>{{ $anggota->no_hp }}</td>
                </tr>
                <!-- Menampilkan Email Anggota -->
                <tr>
                    <th>Email</th>
                    <td>{{ $anggota->email }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
