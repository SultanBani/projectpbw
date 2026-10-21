<?php

use App\Http\Controllers\PublikasiController;
use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Route;

Route::middleware('bps.auth')->group(function () {
    Route::get('/', fn () => view('home'))->name('home');
    Route::get('/publikasi', [PublikasiController::class, 'index'])->name('publikasi.index');
    Route::get('/publikasi/data', [PublikasiController::class, 'data'])->name('publikasi.data');
    Route::get('/publikasi/tambah', [PublikasiController::class, 'create'])->name('publikasi.create');
    Route::post('/publikasi', [PublikasiController::class, 'store'])->name('publikasi.store');
    Route::get('/publikasi/{publikasi}/edit', [PublikasiController::class, 'edit'])->name('publikasi.edit');
    Route::put('/publikasi/{publikasi}', [PublikasiController::class, 'update'])->name('publikasi.update');
    Route::delete('/publikasi/{publikasi}', [PublikasiController::class, 'destroy'])->name('publikasi.destroy');
    Route::get('/galeri', fn () => view('galeri'))->name('galeri');
    Route::post('/logout', [SesiController::class, 'destroy'])->name('logout');
});

Route::get('/login', [SesiController::class, 'create'])->name('login');
Route::post('/login', [SesiController::class, 'store'])->name('login.store');
