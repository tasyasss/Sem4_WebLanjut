<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Data User</title>
</head>
<body>
    <h1>Form Ubah Data User</h1>
    <a href="/user">Kembali</a>
    <br><br>
    <form action="/user/ubah_simpan/{{ $data->user_id }}" method="post">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <label for="username">Username</label>
        <input type="text" name="username" placeholder="Masukkan Username" value="{{ $data->username }}">
        <br><br>
        <label for="nama">Nama</label>
        <input type="text" name="nama" placeholder="Masukkan Nama" value="{{ $data->nama }}">
        <br><br>
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Masukkan Password" value="{{ $data->password }}">
        <br><br>
        <label for="level_id">Level ID</label>
        <input type="number" name="level_id" placeholder="Masukkan ID Level" value="{{ $data->level_id }}">
        <br><br>
        <input type="submit" class="btn btn-success" value="Simpan Perubahan">
    </form>
</body>
</html>

