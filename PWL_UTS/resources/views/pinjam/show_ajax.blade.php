<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Peminjaman Buku</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID Peminjaman</th>
                    <td>{{ $pinjam->pinjam_id }}</td>
                </tr>
                <tr>
                    <th>No. Petugas</th>
                    <td>{{ $pinjam->petugas->petugas_nomor }}</td>
                </tr>
                <tr>
                    <th>Nama Petugas</th>
                    <td>{{ $pinjam->petugas->petugas_nama }}</td>
                </tr>
                <tr>
                    <th>No. Anggota</th>
                    <td>{{ $pinjam->anggota->anggota_nomor }}</td>
                </tr>
                <tr>
                    <th>Nama Anggota</th>
                    <td>{{ $pinjam->anggota->anggota_nama }}</td>
                </tr>
                <tr>
                    <th>Kode Buku</th>
                    <td>{{ $pinjam->buku->buku_kode }}</td>
                </tr>
                <tr>
                    <th>Judul Buku</th>
                    <td>{{ $pinjam->buku->buku_judul }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
