<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loket\pasienController;
use App\Http\Controllers\analyst\spesimentHendlingController;
use App\Http\Controllers\department\DepartmentController;

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

// API Edit Setting
Route::get('/departments', [DepartmentController::class, 'data']);

route::get('/collection/post', [spesimentHendlingController::class, 'postCollection']);
