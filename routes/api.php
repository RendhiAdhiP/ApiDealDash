<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ManajemenKotaController;
use App\Http\Controllers\Api\ManajemenUserController;
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
    
});