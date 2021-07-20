<?php

use App\Http\Controllers\BonController;
use App\Http\Controllers\KeteranganController;
use App\Http\Controllers\LaporankeuanganController;
use App\Http\Controllers\LaporanpemasukanController;
use App\Http\Controllers\LiburController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::group(["middleware" => ['auth:sanctum', 'verified']], function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/user', [UserController::class, 'index_view'])->name('user');
    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai');
    Route::get('/keterangan', [KeteranganController::class, 'index'])->name('keterangan');
    Route::get('/pemasukan', [PemasukanController::class, 'index'])->name('pemasukan');
    Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran');
    Route::get('/libur', [LiburController::class, 'index'])->name('libur');
    Route::get('/bon', [BonController::class, 'index'])->name('bon');
    Route::get('/laporanpemasukan', [LaporanpemasukanController::class, 'index'])->name('laporanpemasukan');
    Route::get('/laporanharian', [LaporanpemasukanController::class, 'harian'])->name('laporanharian');
    Route::get('/laporankeuangan', [LaporankeuanganController::class, 'index'])->name('laporankeuangan');
    Route::view('/user/new', 'pages.user.user-new')->name('user.new');
    Route::view('/user/edit/{userId}', 'pages.user.user-edit')->name('user.edit');
});
