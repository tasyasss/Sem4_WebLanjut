<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Data Buku</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td>{{ $buku->buku_id }}</td>
                </tr>
                <tr>
                    <th>Kategori Buku</th>
                    <td>{{ $buku->kategori->kategori_nama }}</td>
                </tr>
                <tr>
                    <th>Rak Buku</th>
                    <td>{{ $buku->rak->rak_nama }}</td>
                </tr>
                <tr>
                    <th>Kode Buku</th>
                    <td>{{ $buku->buku_kode }}</td>
                </tr>
                <tr>
                    <th>Judul Buku</th>
                    <td>{{ $buku->buku_judul }}</td>
                </tr>
                <tr>
                    <th>Penulis</th>
                    <td>{{ $buku->buku_penulis }}</td>
                </tr>
                <tr>
                    <th>Penerbit</th>
                    <td>{{ $buku->buku_penerbit }}</td>
                </tr>
                <tr>
                    <th>Tahun Terbit</th>
                    <td>{{ $buku->tahun_terbit }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
