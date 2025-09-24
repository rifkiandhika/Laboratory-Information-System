<?php

use App\Http\Controllers\analyst\QcController;
use App\Http\Controllers\analyst\resultController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loket\pasienController;
use App\Http\Controllers\analyst\spesimentHendlingController;
use App\Http\Controllers\analyst\worklistController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\department\DepartmentController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\mcu\McuPackageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/previewpasien/{lab}', [PasienController::class, 'getDataPasien']);

Route::get('/get-data-pasien/{lab}', [PasienController::class, 'getDataPasien']);
Route::get('/get-data-diagnosa', [PasienController::class, 'getDataDiagnosa']);
Route::get('/get-data-qc/{lab}', [QcController::class, 'getDataQc']);

// Endpoint untuk Check data apakah masuk atau belum
Route::get('/check-data', [ApiController::class, 'checkData']);

// Endpoint untuk Quality Control (QC)
Route::post('/qc', [ApiController::class, 'qc']);

// Endpoint untuk Kunjungan Pemeriksaan
Route::post('/kunjunganpemeriksaan', [ApiController::class, 'kunjunganPemeriksaan']);

// Endpoint untuk Hasil Kunjungan Pemeriksaan
Route::post('/kunjunganpemeriksaanhasil', [ApiController::class, 'kunjunganPemeriksaanHasil']);

// API Edit Setting
Route::get('/departments', [DepartmentController::class, 'data']);

Route::get('/collection/post', [SpesimentHendlingController::class, 'postCollection']);

Route::get('/qc/{id}', [QcController::class, 'getQcUnified']);
Route::get('/get-parameters/{qcId}', [QcController::class, 'getParameters']);

Route::middleware('verify.api.token')->group(function () {
    Route::post('/pasien/sync', [PasienController::class, 'syncFromExternal']);
    Route::post('/hasil/sync', [HasilController::class, 'syncFromExternal']);

    Route::get('/get-hasil/{lab}', [HasilController::class, 'getDataHasil']);
    Route::post('/store-hasil', [HasilController::class, 'storeHasil']);
});
