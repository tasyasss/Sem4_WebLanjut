<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [WelcomeController::class, 'index']);

Route::get('/level', [LevelController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/user', [UserController::class, 'index']);

// tambah data user
Route::get('/user/tambah', [UserController::class, 'tambah']);
// simpan tambah data user
Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
// ubah data user
Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
// simpan ubah data user
Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
// hapus data user
Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);