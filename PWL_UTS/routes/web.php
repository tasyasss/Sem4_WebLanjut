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
//     Route::get('/create', [PetugasController::class, 'create']);   // menampilkan halaman form tambah user
//     Route::post('/', [PetugasController::class, 'store']);         // menampilkan data user baru
//     Route::get('/create_ajax', [PetugasController::class, 'create_ajax']);   // menampilkan halaman form tambah user AJAX
//     Route::post('/ajax', [PetugasController::class, 'store_ajax']);         // menampilkan data user baru AJAX
//     Route::get('/{id}', [PetugasController::class, 'show']);       // menampilkan detail user
//     Route::get('/{id}/edit', [PetugasController::class, 'edit']);  // menampilkan halaman form ubah user
//     Route::put('/{id}', [PetugasController::class, 'update']);     // menyimpan perubahan data user
//     Route::get('/{id}/edit_ajax', [PetugasController::class, 'edit_ajax']);     // menampilkan form perubahan data user AJAX
//     Route::put('/{id}/update_ajax', [PetugasController::class, 'update_ajax']);     // menyimpan perubahan data user AJAX
//     Route::delete('/{id}', [PetugasController::class, 'destroy']); // menghapus data user
//     Route::get('/{id}/delete_ajax', [PetugasController::class, 'confirm_ajax']); // menampilkan form confirm delete AJAX
//     Route::delete('/{id}/delete_ajax', [PetugasController::class, 'delete_ajax']); // menghapus data user AJAX
});

Route::group(['prefix' => 'anggota'], function () {
    Route::get('/', [AnggotaController::class, 'index']);          // menampilkan halaman awal user
    Route::post('/list', [AnggotaController::class, 'list']);      // menampilkan data user dlm json utk datatables
//     Route::get('/create', [AnggotaController::class, 'create']);   // menampilkan halaman form tambah user
//     Route::post('/', [AnggotaController::class, 'store']);         // menampilkan data user baru
//     Route::get('/create_ajax', [AnggotaController::class, 'create_ajax']);   // menampilkan halaman form tambah user AJAX
//     Route::post('/ajax', [AnggotaController::class, 'store_ajax']);         // menampilkan data user baru AJAX
//     Route::get('/{id}', [AnggotaController::class, 'show']);       // menampilkan detail user
//     Route::get('/{id}/edit', [AnggotaController::class, 'edit']);  // menampilkan halaman form ubah user
//     Route::put('/{id}', [AnggotaController::class, 'update']);     // menyimpan perubahan data user
//     Route::get('/{id}/edit_ajax', [AnggotaController::class, 'edit_ajax']);     // menampilkan form perubahan data user AJAX
//     Route::put('/{id}/update_ajax', [AnggotaController::class, 'update_ajax']);     // menyimpan perubahan data user AJAX
//     Route::delete('/{id}', [AnggotaController::class, 'destroy']); // menghapus data user
//     Route::get('/{id}/delete_ajax', [AnggotaController::class, 'confirm_ajax']); // menampilkan form confirm delete AJAX
//     Route::delete('/{id}/delete_ajax', [AnggotaController::class, 'delete_ajax']); // menghapus data user AJAX
});

Route::group(['prefix' => 'kategori'], function () {
    Route::get('/',[KategoriController::class, 'index']);
    Route::post('/list',[KategoriController::class, 'list']);
//     Route::get('/create',[KategoriController::class, 'create']);
//     Route::post('/',[KategoriController::class, 'store']);
//     Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);
//     Route::post('/ajax', [KategoriController::class, 'store_ajax']); 
//     Route::get('/{id}',[KategoriController::class, 'show']);
//     Route::get('/{id}/edit',[KategoriController::class, 'edit']);
//     Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);     
//     Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']); 
//     Route::put('/{id}',[KategoriController::class, 'update']);
//     Route::delete('/{id}',[KategoriController::class, 'destroy']);
//     Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);
//     Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);
});

Route::group(['prefix' => 'rak'], function () {
    Route::get('/',[RakController::class, 'index']);
    Route::post('/list',[RakController::class, 'list']);
//     Route::get('/create',[RakController::class, 'create']);
//     Route::post('/',[RakController::class, 'store']);
//     Route::get('/create_ajax', [RakController::class, 'create_ajax']);
//     Route::post('/ajax', [RakController::class, 'store_ajax']); 
//     Route::get('/{id}',[RakController::class, 'show']);
//     Route::get('/{id}/edit',[RakController::class, 'edit']);
//     Route::put('/{id}',[RakController::class, 'update']);
//     Route::get('/{id}/edit_ajax', [RakController::class, 'edit_ajax']);     
//     Route::put('/{id}/update_ajax', [RakController::class, 'update_ajax']); 
//     Route::delete('/{id}',[RakController::class, 'destroy']);
//     Route::get('/{id}/delete_ajax', [RakController::class, 'confirm_ajax']);
//     Route::delete('/{id}/delete_ajax', [RakController::class, 'delete_ajax']);
});

Route::group(['prefix' => 'buku'], function () {
    Route::get('/',[BukuController::class, 'index']);
    Route::post('/list',[BukuController::class, 'list']);
//     Route::get('/create',[BukuController::class, 'create']);
//     Route::post('/',[BukuController::class, 'store']);
//     Route::get('/create_ajax', [BukuController::class, 'create_ajax']);
//     Route::post('/ajax', [BukuController::class, 'store_ajax']); 
//     Route::get('/{id}',[BukuController::class, 'show']);
//     Route::get('/{id}/edit',[BukuController::class, 'edit']);
//     Route::get('/{id}/edit_ajax', [BukuController::class, 'edit_ajax']);     
//     Route::put('/{id}/update_ajax', [BukuController::class, 'update_ajax']); 
//     Route::put('/{id}',[BukuController::class, 'update']);
//     Route::delete('/{id}',[BukuController::class, 'destroy']);
//     Route::get('/{id}/delete_ajax', [BukuController::class, 'confirm_ajax']);
    // Route::delete('/{id}/delete_ajax', [BukuController::class, 'delete_ajax']);
});
