<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ManajemenKotaController;
use App\Http\Controllers\Api\ManajemenProduk;
use App\Http\Controllers\Api\ManajemenUserController;
use App\Http\Controllers\Api\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('/v1')->group(function () {
    
    Route::prefix('/auth')->group(function () {
        Route::post('/login',[AuthController::class, 'login']);
        Route::post('/logout',[AuthController::class, 'logout'])->middleware('auth:sanctum');
    });

    Route::prefix('/manajemen-user')->middleware(['auth:sanctum'])->group(function () {
        Route::get('/',[ManajemenUserController::class, 'index']);
        Route::get('/detail/{id}',[ManajemenUserController::class, 'detailUser']);
        Route::post('/tambah',[ManajemenUserController::class, 'tambahUser']);
        Route::get('/edit/{id}',[ManajemenUserController::class, 'editUser']);
        Route::post('/update/{id}',[ManajemenUserController::class, 'updateUser']);
        Route::delete('/hapus/{id}',[ManajemenUserController::class, 'hapusUser']);
    });

    Route::prefix('/manajemen-kota')->middleware(['auth:sanctum'])->group(function () {
        Route::get('/',[ManajemenKotaController::class, 'index']);
        Route::post('/tambah',[ManajemenKotaController::class, 'tambahKota']);
        Route::get('/edit/{id}',[ManajemenKotaController::class, 'editKota']);
        Route::post('/update/{id}',[ManajemenKotaController::class, 'updateKota']);
        Route::delete('/hapus/{id}',[ManajemenKotaController::class, 'hapusKota']);
    });

    Route::prefix('/manajemen-produk')->middleware(['auth:sanctum'])->group(function () {
        Route::get('/',[ManajemenProduk::class, 'index']);
        Route::post('/tambah-produk',[ManajemenProduk::class, 'tambahProduk']);
        Route::get('/edit/{id}',[ManajemenProduk::class, 'editProduk']);
        Route::post('/update/{id}',[ManajemenProduk::class, 'updateProduk']);
        Route::delete('/hapus/{id}',[ManajemenProduk::class, 'hapusProduk']);

        Route::get('/history',[ManajemenProduk::class, 'historyProduks']);
        Route::post('/tambah-stok',[ManajemenProduk::class, 'tambahStok']);
    });

    Route::prefix('/role')->middleware(['auth:sanctum'])->group(function () {
        Route::get('/',[RoleController::class, 'index']);
    });
    
});