<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Data Petugas</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td>{{ $petugas->petugas_id }}</td>
                </tr>
                <tr>
                    <th>Nomor Petugas</th>
                    <td>{{ $petugas->petugas_nomor }}</td>
                </tr>
                <tr>
                    <th>Nama Petugas</th>
                    <td>{{ $petugas->petugas_nama }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $petugas->email }}</td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td>{{ $petugas->username }}</td>
                </tr>
                <tr>
                    <th>Password</th>
                    <td>********</td>
                </tr>
            </table>
        </div>
    </div>
</div>
