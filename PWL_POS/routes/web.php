<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProfileController;
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

Route::pattern('id', '[0-9]+'); // jika ada parameter id harus berupa angka
 
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');    
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'postRegister']);

Route::middleware('auth')->group(function () { // route di bawah ini hanya bisa diakses ketika sudah login
    Route::get('/', [WelcomeController::class, 'index']);
    
    Route::middleware('authorize:ADM')->group(function () { // dpt diakses oleh role admin
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [UserController::class, 'index']);          // menampilkan halaman awal user
            Route::post('/list', [UserController::class, 'list']);      // menampilkan data user dlm json utk datatables
            Route::get('/create', [UserController::class, 'create']);   // menampilkan halaman form tambah user
            Route::post('/', [UserController::class, 'store']);         // menampilkan data user baru
            Route::get('/create_ajax', [UserController::class, 'create_ajax']);   // menampilkan halaman form tambah user AJAX
            Route::post('/ajax', [UserController::class, 'store_ajax']);         // menampilkan data user baru AJAX
            Route::get('/{id}', [UserController::class, 'show']);       // menampilkan detail user
            Route::get('/{id}/edit', [UserController::class, 'edit']);  // menampilkan halaman form ubah user
            Route::put('/{id}', [UserController::class, 'update']);     // menyimpan perubahan data user
            Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);     // menampilkan form perubahan data user AJAX
            Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);     // menyimpan perubahan data user AJAX
            Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
            Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // menampilkan form confirm delete AJAX
            Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // menghapus data user AJAX
            Route::get('/import',[UserController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [UserController::class, 'import_ajax']); //ajax import excel
            Route::get('/export_excel',[UserController::class, 'export_excel']); // export excel
            Route::get('/export_pdf',[UserController::class, 'export_pdf']); // export pdf
        });
    });    
    
    Route::middleware('authorize:ADM')->group(function () { // dpt diakses oleh role admin
        Route::group(['prefix' => 'level'], function () {
            Route::get('/',[LevelController::class, 'index']);
            Route::post('/list',[LevelController::class, 'list']);
            Route::get('/create',[LevelController::class, 'create']);
            Route::post('/',[LevelController::class, 'store']);
            Route::get('/create_ajax', [LevelController::class, 'create_ajax']);
            Route::post('/ajax', [LevelController::class, 'store_ajax']); 
            Route::get('/{id}',[LevelController::class, 'show']);
            Route::get('/{id}/edit',[LevelController::class, 'edit']);
            Route::put('/{id}',[LevelController::class, 'update']);
            Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);     
            Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']); 
            Route::delete('/{id}',[LevelController::class, 'destroy']);
            Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
            Route::get('/import',[LevelController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [LevelController::class, 'import_ajax']); //ajax import excel
            Route::get('/export_excel',[LevelController::class, 'export_excel']); // export excel
            Route::get('/export_pdf',[LevelController::class, 'export_pdf']); // export pdf
        });
    });
    
    Route::middleware('authorize:ADM,MNG')->group(function () { // dpt diakses oleh role admin & manager
        Route::group(['prefix' => 'kategori'], function () {
            Route::get('/',[KategoriController::class, 'index']);
            Route::post('/list',[KategoriController::class, 'list']);
            Route::get('/create',[KategoriController::class, 'create']);
            Route::post('/',[KategoriController::class, 'store']);
            Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);
            Route::post('/ajax', [KategoriController::class, 'store_ajax']); 
            Route::get('/{id}',[KategoriController::class, 'show']);
            Route::get('/{id}/edit',[KategoriController::class, 'edit']);
            Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);     
            Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']); 
            Route::put('/{id}',[KategoriController::class, 'update']);
            Route::delete('/{id}',[KategoriController::class, 'destroy']);
            Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);
            Route::get('/import',[KategoriController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [KategoriController::class, 'import_ajax']); //ajax import excel
            Route::get('/export_excel',[KategoriController::class, 'export_excel']); // export excel
            Route::get('/export_pdf',[KategoriController::class, 'export_pdf']); // export pdf
        });
    });
    
    Route::middleware('authorize:ADM,MNG')->group(function () { // dpt diakses oleh role admin & manager
        Route::group(['prefix' => 'barang'], function () {
            Route::get('/',[BarangController::class, 'index']);
            Route::post('/list',[BarangController::class, 'list']);
            Route::get('/create',[BarangController::class, 'create']);
            Route::post('/',[BarangController::class, 'store']);
            Route::get('/create_ajax', [BarangController::class, 'create_ajax']);
            Route::post('/ajax', [BarangController::class, 'store_ajax']); 
            Route::get('/{id}',[BarangController::class, 'show']);
            Route::get('/{id}/edit',[BarangController::class, 'edit']);
            Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);     
            Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']); 
            Route::put('/{id}',[BarangController::class, 'update']);
            Route::delete('/{id}',[BarangController::class, 'destroy']);
            Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);
            Route::get('/import',[BarangController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [BarangController::class, 'import_ajax']); //ajax import excel
            Route::get('/export_excel',[BarangController::class, 'export_excel']); // export excel
            Route::get('/export_pdf',[BarangController::class, 'export_pdf']); // export pdf
        });
    });
    
    Route::middleware('authorize:ADM,MNG')->group(function () { // dpt diakses oleh role admin & manager
        Route::group(['prefix' => 'supplier'], function () {
            Route::get('/',[SupplierController::class, 'index']);
            Route::post('/list',[SupplierController::class, 'list']);
            Route::get('/create',[SupplierController::class, 'create']);
            Route::post('/',[SupplierController::class, 'store']);
            Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);
            Route::post('/ajax', [SupplierController::class, 'store_ajax']); 
            Route::get('/{id}',[SupplierController::class, 'show']);
            Route::get('/{id}/edit',[SupplierController::class, 'edit']);
            Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);     
            Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']); 
            Route::put('/{id}',[SupplierController::class, 'update']);
            Route::delete('/{id}',[SupplierController::class, 'destroy']);
            Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']);
            Route::get('/import',[SupplierController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [SupplierController::class, 'import_ajax']); //ajax import excel
            Route::get('/export_excel',[SupplierController::class, 'export_excel']); // export excel
            Route::get('/export_pdf',[SupplierController::class, 'export_pdf']); // export pdf
        });
    });

    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::group(['prefix' => 'profile'], function () {
            Route::get('/', [ProfileController::class, 'index']);
            Route::post('/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
        });
    });
});
    
