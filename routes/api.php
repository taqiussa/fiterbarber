<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BonController;
use App\Http\Controllers\HargaController;
use App\Http\Controllers\LiburController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\KeteranganController;
use App\Http\Controllers\LaporankeuanganController;
use App\Http\Controllers\PengeluaranController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/loginapi', [LoginController::class, 'index'])->name('loginapi');
Route::get('/logoutapi', [LogoutController::class, 'index'])->name('logoutapi');
// Route::middleware(['auth:api'])->group(function () {
    Route::get('/pegawais', [PegawaiController::class, 'indexapi']);
    Route::get('/pegawais/{id}', [PegawaiController::class, 'showapi']);
    Route::post('/pegawais', [PegawaiController::class, 'storeapi']);
    Route::post('/pegawais/{id}', [PegawaiController::class, 'updateapi']);
    Route::delete('/pegawais/{id}', [PegawaiController::class, 'destroyapi']);

    Route::get('/pemasukans', [PemasukanController::class, 'indexapi']);
    Route::get('/pemasukans/graph', [PemasukanController::class, 'pemasukangraph']);
    Route::get('/pemasukans/{id}', [PemasukanController::class, 'showapi']);
    Route::get('/pemasukans/{pegawai}/{bulan}/{tahun}/{keterangan}', [PemasukanController::class, 'lappemasukan']);
    Route::get('/print/{pegawai}/{bulan}/{tahun}', [PemasukanController::class, 'print']);
    // Route::post('/print', [PemasukanController::class, 'print']);
    Route::post('/pemasukans', [PemasukanController::class, 'storeapi']);
    Route::post('/pemasukans/{id}', [PemasukanController::class, 'updateapi']);
    Route::delete('/pemasukans/{id}', [PemasukanController::class, 'destroyapi']);
    
    Route::get('/pengeluarans', [PengeluaranController::class, 'indexapi']);
    Route::get('/pengeluarans/{id}', [PengeluaranController::class, 'showapi']);
    Route::post('/pengeluarans', [PengeluaranController::class, 'storeapi']);
    Route::post('/pengeluarans/{id}', [PengeluaranController::class, 'updateapi']);
    Route::delete('/pengeluarans/{id}', [PengeluaranController::class, 'destroyapi']);

    Route::get('/keuangans/{bulan}/{tahun}', [LaporankeuanganController::class, 'indexapi']);
    Route::get('/keuangans', [LaporankeuanganController::class, 'dashboardapi']);

    Route::get('/keterangans', [KeteranganController::class, 'indexapi']);
    Route::get('/keterangans/{id}', [KeteranganController::class, 'showapi']);

    Route::get('/harga/{pegawai}/{keterangan}', [HargaController::class, 'showapi']);

    Route::get('/liburs', [LiburController::class, 'indexapi']);
    Route::get('/liburs/{id}', [LiburController::class, 'showapi']);
    Route::post('/liburs', [LiburController::class, 'storeapi']);
    Route::post('/liburs/{id}', [LiburController::class, 'updateapi']);
    Route::delete('/liburs/{id}', [LiburController::class, 'destroyapi']);

    Route::get('/bons', [BonController::class, 'indexapi']);
    Route::get('/bons/{id}', [BonController::class, 'showapi']);
    Route::post('/bons', [BonController::class, 'storeapi']);
    Route::post('/bons/{id}', [BonController::class, 'updateapi']);
    Route::delete('/bons/{id}', [BonController::class, 'destroyapi']);
// });
