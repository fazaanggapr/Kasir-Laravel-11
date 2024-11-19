<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Beranda;
use App\Livewire\User;
use App\Livewire\Produk;
use App\Livewire\Laporan;
use App\Livewire\Transaksi;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', Beranda::class)->middleware(['auth'])->name('home');
Route::get('/user', User::class)->middleware(['auth'])->name('user');
Route::get('/produk', Produk::class)->middleware(['auth'])->name('produk');
Route::get('/laporan', Laporan::class)->middleware(['auth'])->name('laporan');
Route::get('/transaksi', Transaksi::class)->name('transaksi');
Route::get('/cetak', ['App\Http\Controllers\HomeController', 'cetak']);