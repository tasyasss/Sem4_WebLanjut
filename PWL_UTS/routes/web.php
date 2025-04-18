<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\BukuController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'petugas'], function () {
    Route::get('/', [PetugasController::class, 'index']);          // menampilkan halaman awal user
    Route::post('/list', [PetugasController::class, 'list']);      // menampilkan data user dlm json utk datatables
    Route::get('/create_ajax', [PetugasController::class, 'create_ajax']);   // menampilkan halaman form tambah user AJAX
    Route::post('/ajax', [PetugasController::class, 'store_ajax']);         // menampilkan data user baru AJAX
    Route::get('/{id}/show_ajax', [PetugasController::class, 'show_ajax']);       // menampilkan detail user AJAX
    Route::get('/{id}/edit_ajax', [PetugasController::class, 'edit_ajax']);     // menampilkan form perubahan data user AJAX
    Route::put('/{id}/update_ajax', [PetugasController::class, 'update_ajax']);     // menyimpan perubahan data user AJAX
    Route::get('/{id}/delete_ajax', [PetugasController::class, 'confirm_ajax']); // menampilkan form confirm delete AJAX
    Route::delete('/{id}/delete_ajax', [PetugasController::class, 'delete_ajax']); // menghapus data user AJAX
});

Route::group(['prefix' => 'anggota'], function () {
    Route::get('/', [AnggotaController::class, 'index']);          // menampilkan halaman awal user
    Route::post('/list', [AnggotaController::class, 'list']);      // menampilkan data user dlm json utk datatables
    Route::get('/create_ajax', [AnggotaController::class, 'create_ajax']);   // menampilkan halaman form tambah user AJAX
    Route::post('/ajax', [AnggotaController::class, 'store_ajax']);         // menampilkan data user baru AJAX
    Route::get('/{id}/show_ajax', [AnggotaController::class, 'show_ajax']);       // menampilkan detail user AJAX
    Route::get('/{id}/edit_ajax', [AnggotaController::class, 'edit_ajax']);     // menampilkan form perubahan data user AJAX
    Route::put('/{id}/update_ajax', [AnggotaController::class, 'update_ajax']);     // menyimpan perubahan data user AJAX
    Route::get('/{id}/delete_ajax', [AnggotaController::class, 'confirm_ajax']); // menampilkan form confirm delete AJAX
    Route::delete('/{id}/delete_ajax', [AnggotaController::class, 'delete_ajax']); // menghapus data user AJAX
});

Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index']);          // menampilkan halaman awal kategori
    Route::post('/list', [KategoriController::class, 'list']);      // menampilkan data kategori dlm json utk datatables
    Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);   // menampilkan halaman form tambah kategori AJAX
    Route::post('/ajax', [KategoriController::class, 'store_ajax']);         // menampilkan data kategori baru AJAX
    Route::get('/{id}/show_ajax', [KategoriController::class, 'show_ajax']);       // menampilkan detail kategori AJAX
    Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);     // menampilkan form perubahan data kategori AJAX
    Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);     // menyimpan perubahan data kategori AJAX
    Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); // menampilkan form confirm delete AJAX
    Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); // menghapus data kategori AJAX
});

Route::group(['prefix' => 'rak'], function () {
    Route::get('/', [RakController::class, 'index']);          // menampilkan halaman awal rak
    Route::post('/list', [RakController::class, 'list']);      // menampilkan data rak dlm json utk datatables
    Route::get('/create_ajax', [RakController::class, 'create_ajax']);   // menampilkan halaman form tambah rak AJAX
    Route::post('/ajax', [RakController::class, 'store_ajax']);         // menampilkan data rak baru AJAX
    Route::get('/{id}/show_ajax', [RakController::class, 'show_ajax']);       // menampilkan detail rak AJAX
    Route::get('/{id}/edit_ajax', [RakController::class, 'edit_ajax']);     // menampilkan form perubahan data rak AJAX
    Route::put('/{id}/update_ajax', [RakController::class, 'update_ajax']);     // menyimpan perubahan data rak AJAX
    Route::get('/{id}/delete_ajax', [RakController::class, 'confirm_ajax']); // menampilkan form confirm delete AJAX
    Route::delete('/{id}/delete_ajax', [RakController::class, 'delete_ajax']); // menghapus data rak AJAX
});

Route::group(['prefix' => 'buku'], function () {
    Route::get('/', [BukuController::class, 'index']);          // menampilkan halaman awal buku
    Route::post('/list', [BukuController::class, 'list']);      // menampilkan data buku dlm json utk datatables
    Route::get('/create_ajax', [BukuController::class, 'create_ajax']);   // menampilkan halaman form tambah buku AJAX
    Route::post('/ajax', [BukuController::class, 'store_ajax']);         // menampilkan data buku baru AJAX
    Route::get('/{id}/show_ajax', [BukuController::class, 'show_ajax']);       // menampilkan detail buku AJAX
    Route::get('/{id}/edit_ajax', [BukuController::class, 'edit_ajax']);     // menampilkan form perubahan data buku AJAX
    Route::put('/{id}/update_ajax', [BukuController::class, 'update_ajax']);     // menyimpan perubahan data buku AJAX
    Route::get('/{id}/delete_ajax', [BukuController::class, 'confirm_ajax']); // menampilkan form confirm delete AJAX
    Route::delete('/{id}/delete_ajax', [BukuController::class, 'delete_ajax']); // menghapus data buku AJAX
});
