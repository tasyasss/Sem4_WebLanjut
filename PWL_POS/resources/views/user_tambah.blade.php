<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tambah Data User</title>
</head>
<body>
    <h1>Form Tambah Data User</h1>
    <form action="/user/tambah_simpan" method="post">
        {{ csrf_field() }}
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="Masukkan Username">
        <br><br>
        <label for="nama">Nama</label>
        <input type="text" name="nama" placeholder="Masukkan Nama">
        <br><br>
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Masukkan Password">
        <br><br>
        <label for="level_id">Level ID</label>
        <input type="number" name="level_id" placeholder="Masukkan ID Level">
        <br><br>
        <input type="submit" class="btn btn-success" value="Simpan">
    </form>
</body>
</html>

