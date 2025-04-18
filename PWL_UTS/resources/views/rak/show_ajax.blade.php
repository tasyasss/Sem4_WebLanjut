<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Rak Buku</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td>{{ $rak->rak_id }}</td>
                </tr>
                <tr>
                    <th>Kode Rak</th>
                    <td>{{ $rak->rak_kode }}</td>
                </tr>
                <tr>
                    <th>Nama Rak</th>
                    <td>{{ $rak->rak_nama }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
