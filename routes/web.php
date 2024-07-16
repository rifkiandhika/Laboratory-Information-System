<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\userController;
use App\Http\Controllers\icd10\icd10Controller;
use App\Http\Controllers\loket\pasienController;
use App\Http\Controllers\analyst\analystDasboard;
use App\Http\Controllers\analyst\worklistController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\analyst\spesimentHendlingController;
use App\Http\Controllers\department\DepartmentController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\pemeriksaan\PemeriksaanController;
use App\Http\Controllers\poli\PoliController;
use App\Http\Controllers\report\ReportController;
use App\Http\Controllers\rolepermission\PermissionController;
use App\Http\Controllers\rolepermission\RoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/





Route::get('/demo', function () {
    return view('demo');
});

route::resource('login', userController::class);
route::post('login-proses', [userController::class, 'proses'])->name('login.proses');
route::get('/logout', [userController::class, 'logout'])->name('logout');


route::middleware('auth')->group(function(){
    route::get('/dashboard', [AdminController::class, "index"])->name('admin.dashboard');
    // route::get('/dokter', [AdminController::class, "dokter"])->name('dokter');
    // route::post('tambah-dokter', [AdminController::class, "tambahdokter"]);
    Route::resource('dokter', DokterController::class);
    Route::resource('poli', PoliController::class);
    Route::resource('department', DepartmentController::class);
    Route::resource('pemeriksaan', PemeriksaanController::class);
    Route::resource('role', RoleController::class);
    Route::resource('permission', PermissionController::class);
    
});

// route::group(['prefix' => 'demo', 'middleware' => ['auth']], function() {

//     Route::get('/admin', function () {
//         return view('admin.dashboard');
//     });
//     Route::get('/adminlist', function () {
//         return view('admin.data-user');
//     });
//     Route::get('/edit-user', function () {
//         return view('admin.edit-user');
//     });
//     Route::get('/tambah', function () {
//         return view('admin.tambah');
//     });
//     Route::get('/parameterlist', function () {
//         return view('admin.data-parameter');
//     });

//     route::resource('pasien', pasienController::class);
//     route::get('loket', [pasienController::class, 'index']);
//     route::post('/pasien/kirimlab', [pasienController::class, 'kirimLab'])->name('pasien.kirimlab');
//     route::get('/data-pasien', [pasienController::class, 'dataPasien'])->name('pasien.data');

//     route::resource('analyst', analystDasboard::class);
//     route::post('analyst/setuju', [analystDasboard::class, 'approve'])->name('analyst.approve');
//     route::post('analyst/checkin', [analystDasboard::class, 'checkin'])->name('analyst.checkin');

//     route::resource('spesiment', spesimentHendlingController::class);
//     route::post('spesiment/post', [spesimentHendlingController::class, 'postSpesiment'])->name('spesiment.post');
//     route::post('spesiment/checkin', [spesimentHendlingController::class, 'checkin'])->name('spesiment.checkin');

//     route::resource('worklist', worklistController::class);

//     Route::get('/report-loket', function () {
//         return view ('loket.report');
//     });

//     Route::get('/result', function () {
//         return view ('analyst.result-review');
//     });

//     Route::get('/dashboard-dok', function () {
//         return view ('analyst.main-dokter');
//     });

//     Route::get('/quality-control', function () {
//         return view ('analyst.quality-control');
//     });
//     Route::get('/daftar-qc', function () {
//         return view ('analyst.daftar-qc');
//     });
//     Route::get('/history-qc', function () {
//         return view ('analyst.history-qc');
//     });
// });

route::group(['prefix' => 'loket', 'middleware' => ['auth']], function() {

    route::resource('pasien', pasienController::class);
    route::get('loket', [pasienController::class, 'index']);
    route::post('/pasien/kirimlab', [pasienController::class, 'kirimLab'])->name('pasien.kirimlab');
    route::get('/data-pasien', [pasienController::class, 'dataPasien'])->name('pasien.data');
    Route::get('/result', function () {
        return view ('analyst.result-review');
    });
    Route::resource('report', ReportController::class);
});

route::group(['prefix' => 'analyst', 'middleware' => ['auth']], function() {
    route::resource('analyst', analystDasboard::class);
    route::post('analyst/setuju', [analystDasboard::class, 'approve'])->name('analyst.approve');
    route::post('analyst/checkin', [analystDasboard::class, 'checkin'])->name('analyst.checkin');

    route::resource('spesiment', spesimentHendlingController::class);
    route::post('spesiment/post', [spesimentHendlingController::class, 'postSpesiment'])->name('spesiment.post');
    route::post('spesiment/checkin', [spesimentHendlingController::class, 'checkin'])->name('spesiment.checkin');

    route::resource('worklist', worklistController::class);

    Route::get('/result', function () {
        return view ('analyst.result-review');
    });

    Route::get('/dashboard-dok', function () {
        return view ('analyst.main-dokter');
    });

    Route::get('/quality-control', function () {
        return view ('analyst.quality-control');
    });
    Route::get('/daftar-qc', function () {
        return view ('analyst.daftar-qc');
    });
    Route::get('/history-qc', function () {
        return view ('analyst.history-qc');
    });
});

route::get('/worklist/pemeriksaan', [worklistController::class, 'tampilPemeriksaan']);
route::get('/worklist/tampildarahlengkap/{nolab}', [worklistController::class, 'tampilPemeriksaan'])->name('worklist.tampildarahlengkap');

Route::get('/print/barcode/{lab}', [pasienController::class, 'previewPrint'])->name('print.barcode');
route::get('/autocomplete-icd10', [icd10Controller::class, 'geticd10'])->name('geticd10');
route::get('/previewpasien/{lab}', [pasienController::class, 'getDataPasien']);




