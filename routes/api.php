<?php

use App\Http\Controllers\analyst\QcController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loket\pasienController;
use App\Http\Controllers\analyst\spesimentHendlingController;
use App\Http\Controllers\analyst\worklistController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\department\DepartmentController;
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

Route::get('/previewpasien/{lab}', [pasienController::class, 'getDataPasien']);
Route::get('/get-data-pasien/{lab}', [pasienController::class, 'getDataPasien']);
Route::get('/get-data-diagnosa', [pasienController::class, 'getDataDiagnosa']);
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

route::get('/collection/post', [spesimentHendlingController::class, 'postCollection']);

Route::get('/qc/{id}', [QcController::class, 'getDetailQc']);
