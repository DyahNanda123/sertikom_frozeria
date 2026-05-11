<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;

// Halaman utama
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('barang/export-excel', [BarangController::class, 'exportExcel'])->name('barang.exportExcel');
Route::get('barang/export-pdf', [BarangController::class, 'exportPdf'])->name('barang.exportPdf');
Route::post('barang/import-excel', [BarangController::class, 'importExcel'])->name('barang.importExcel');

Route::get('kategori/export-excel', [KategoriController::class, 'exportExcel'])->name('kategori.exportExcel');
Route::get('kategori/export-pdf', [KategoriController::class, 'exportPdf'])->name('kategori.exportPdf');
Route::post('kategori/import-excel', [KategoriController::class, 'importExcel'])->name('kategori.importExcel');

// Route otomatis CRUD
Route::resource('kategori', KategoriController::class);
Route::resource('barang', BarangController::class);

// Halaman bantuan
Route::get('/bantuan', function () {
    return view('bantuan');
})->name('bantuan');