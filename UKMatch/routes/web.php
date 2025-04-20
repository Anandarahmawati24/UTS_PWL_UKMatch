<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriUkmController;
use App\Http\Controllers\UkmController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

Route::get('/', fn () => redirect()->route('login'));

// Batasan id harus angka
Route::pattern('id', '[0-9]+');

// AUTH
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome');

    // Profil untuk semua user
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    // UKM (lihat saja) untuk Mahasiswa
    Route::middleware(['auth', 'authorize:MHS'])->group(function () {
      Route::get('/ukm/mahasiswa', [UkmController::class, 'indexMahasiswa'])->name('ukm.indexMahasiswa');
      Route::post('ukm/list_mahasiswa', [UkmController::class, 'listUkmMahasiswa']);
      Route::get('/ukm/{id}/show_ajax', [UkmController::class, 'show_ajax']);
  });
  

    // Semua fitur lengkap untuk Admin
    Route::middleware(['authorize:ADM'])->group(function () {

        // LEVEL
        Route::prefix('level')->group(function () {
            Route::get('/', [LevelController::class, 'index']);
            Route::post('/list', [LevelController::class, 'list']);
            Route::get('/create', [LevelController::class, 'create']);
            Route::post('/', [LevelController::class, 'store']);
            Route::get('/create_ajax', [LevelController::class, 'create_ajax']);
            Route::post('/ajax', [LevelController::class, 'store_ajax']);
            Route::get('/{id}', [LevelController::class, 'show']);
            Route::get('/{id}/show_ajax', [LevelController::class, 'show_ajax']);
            Route::get('/{id}/edit', [LevelController::class, 'edit']);
            Route::put('/{id}', [LevelController::class, 'update']);
            Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);
            Route::delete('/{id}', [LevelController::class, 'destroy']);
            Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
        });

        // KATEGORI UKM
        Route::prefix('kategori_ukm')->group(function () {
            Route::get('/', [KategoriUkmController::class, 'index']);
            Route::post('/list', [KategoriUkmController::class, 'list']);
            Route::get('/create', [KategoriUkmController::class, 'create']);
            Route::post('/', [KategoriUkmController::class, 'store']);
            Route::get('/create_ajax', [KategoriUkmController::class, 'create_ajax']);
            Route::post('/ajax', [KategoriUkmController::class, 'store_ajax']);
            Route::get('/{id}', [KategoriUkmController::class, 'show']);
            Route::get('/{id}/show_ajax', [KategoriUkmController::class, 'show_ajax']);
            Route::get('/{id}/edit', [KategoriUkmController::class, 'edit']);
            Route::put('/{id}', [KategoriUkmController::class, 'update']);
            Route::get('/{id}/edit_ajax', [KategoriUkmController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [KategoriUkmController::class, 'update_ajax']);
            Route::delete('/{id}', [KategoriUkmController::class, 'destroy']);
            Route::get('/{id}/delete_ajax', [KategoriUkmController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [KategoriUkmController::class, 'delete_ajax']);
        });

        // UKM (CRUD)
        Route::prefix('ukm')->group(function () {
            Route::get('/', [UkmController::class, 'index']);
            Route::post('/list', [UkmController::class, 'list']);
            Route::get('/create', [UkmController::class, 'create']);
            Route::post('/', [UkmController::class, 'store']);
            Route::get('/create_ajax', [UkmController::class, 'create_ajax']);
            Route::post('/ajax', [UkmController::class, 'store_ajax']);
            Route::get('/{id}', [UkmController::class, 'show']);
            Route::get('/{id}/show_ajax', [UkmController::class, 'show_ajax']);
            Route::get('/{id}/edit', [UkmController::class, 'edit']);
            Route::put('/{id}', [UkmController::class, 'update']);
            Route::get('/{id}/edit_ajax', [UkmController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [UkmController::class, 'update_ajax']);
            Route::delete('/{id}', [UkmController::class, 'destroy']);
            Route::get('/{id}/delete_ajax', [UkmController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [UkmController::class, 'delete_ajax']);
        });

        // USER
        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'index']);
            Route::post('/list', [UserController::class, 'list']);
            Route::get('/create', [UserController::class, 'create']);
            Route::post('/', [UserController::class, 'store']);
            Route::get('/create_ajax', [UserController::class, 'create_ajax']);
            Route::post('/store_ajax', [UserController::class, 'store_ajax'])->name('user.store_ajax');
            Route::get('/{id}', [UserController::class, 'show']);
            Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']);
            Route::get('/{id}/edit', [UserController::class, 'edit']);
            Route::put('/{id}', [UserController::class, 'update']);
            Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);
            Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);
            Route::delete('/{id}', [UserController::class, 'destroy']);
        });
    });
});