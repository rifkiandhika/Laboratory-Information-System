<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\userController;
use App\Http\Controllers\icd10\icd10Controller;
use App\Http\Controllers\loket\pasienController;
use App\Http\Controllers\analyst\analystDasboard;
use App\Http\Controllers\analyst\DqcController;
use App\Http\Controllers\analyst\DSpesimentController;
use App\Http\Controllers\analyst\LotController;
use App\Http\Controllers\analyst\QcController;
use App\Http\Controllers\analyst\QcHistoryController;
use App\Http\Controllers\analyst\resultController;
use App\Http\Controllers\analyst\SpesimentController;
use App\Http\Controllers\analyst\worklistController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\analyst\spesimentHendlingController;
use App\Http\Controllers\analyst\vDokterController;
use App\Http\Controllers\department\DepartmentController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\loket\DataPasienController;
use App\Http\Controllers\mcu\McuPackageController as McuMcuPackageController;
use App\Http\Controllers\McuPackageController;
use App\Http\Controllers\pemeriksaan\PemeriksaanController;
use App\Http\Controllers\poli\PoliController;
use App\Http\Controllers\report\ReportController;
use App\Http\Controllers\rolepermission\PermissionController;
use App\Http\Controllers\rolepermission\RoleController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

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





Route::get('/test', function () {
    return view('Note/test');
});

// Route::get('/print-view/print-pasien', function () {
//     return view('print-view.print-pasien');
// });
Route::get('/', function () {
    return redirect('/login');
});

route::resource('login', userController::class);
route::post('login-proses', [userController::class, 'proses'])->name('login.proses');
Route::post('/logout', [userController::class, 'logout'])->name('logout');

//admin
route::middleware('auth', 'role:admin')->group(function () {
    route::get('/dashboard', [AdminController::class, "index"])->name('admin.dashboard');
    // route::get('/dokter', [AdminController::class, "dokter"])->name('dokter');
    // route::post('tambah-dokter', [AdminController::class, "tambahdokter"]);
    Route::resource('dokter', DokterController::class);
    Route::resource('poli', PoliController::class);
    Route::resource('department', DepartmentController::class);
    Route::resource('pemeriksaan', PemeriksaanController::class);
    Route::resource('role', RoleController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('spesiments', SpesimentController::class);
    Route::resource('mcu', McuMcuPackageController::class);
    Route::get('/package-details/{id}', [McuMcuPackageController::class, 'getPackageDetails'])->name('package-details');
});

// route::group(['prefix' => 'demo', 'middleware' => ['auth']], function () {

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

//     route::get('/dashboard', [AdminController::class, "index"])->name('admin.dashboard');
//     // route::get('/dokter', [AdminController::class, "dokter"])->name('dokter');
//     // route::post('tambah-dokter', [AdminController::class, "tambahdokter"]);
//     Route::resource('dokter', DokterController::class);
//     Route::resource('poli', PoliController::class);
//     Route::resource('department', DepartmentController::class);
//     Route::resource('pemeriksaan', PemeriksaanController::class);
//     Route::resource('role', RoleController::class);
//     Route::resource('permission', PermissionController::class);
//     Route::resource('spesiments', SpesimentController::class);

//     route::resource('pasien', pasienController::class);
//     route::get('loket', [pasienController::class, 'index']);
//     route::post('/pasien/kirimlab', [pasienController::class, 'kirimLab'])->name('pasien.kirimlab');
//     Route::get('/result', function () {
//         return view('analyst.result-review');
//     });
//     Route::resource('report', ReportController::class);
//     Route::resource('data-pasien', DataPasienController::class);
//     Route::get('get-icd10', [icd10Controller::class, 'geticd10'])->name('geticd10');
//     Route::get('print/barcode/{no_lab}', [pasienController::class, 'previewPrint'])->name('print.barcode');
//     Route::get('/pasien/edit/{no_lab}', [pasienController::class, 'edit'])->name('pasien.viewedit');
//     Route::put('/pasien/{id}', [pasienController::class, 'update'])->name('pasien.updatedata');
//     Route::post('pasien/checkin', [pasienController::class, 'checkin'])->name('pasien.checkin');

//     Route::resource('analyst', analystDasboard::class);
//     // route::post('/setuju', [analystDasboard::class, 'approve'])->name('analyst.approve');
//     Route::post('/approve/{id}', [analystDasboard::class, 'approve'])->name('analyst.approve');
//     Route::post('/checkinall', [analystDasboard::class, 'checkinall'])->name('analyst.checkinall');
//     // Route Spesiment
//     Route::resource('spesiment', spesimentHendlingController::class);
//     Route::post('spesiment/post', [spesimentHendlingController::class, 'postSpesiment'])->name('spesiment.post');
//     Route::post('spesiment/checkin', [spesimentHendlingController::class, 'checkin'])->name('spesiment.checkin');
//     Route::post('/spesiment/back/{id}', [spesimentHendlingController::class, 'back'])->name('spesiment.back');
//     // Route Worklist
//     Route::resource('worklist', worklistController::class);
//     Route::delete('analyst/worklist/{worklist}', [worklistController::class, 'destroy']);
//     Route::post('/worklist/checkin/{id}', [worklistController::class, 'checkin'])->name('worklist.checkin');
//     Route::post('/worklist/end/{id}', [worklistController::class, 'end'])->name('worklist.end');
//     // Route Dokter
//     Route::resource('vdokter', vDokterController::class);
//     Route::post('/dokter/back/{id}', [vDokterController::class, 'back'])->name('dokter.back');
//     // Route Result Review
//     Route::resource('result', resultController::class);

//     Route::get('print/pasien/{no_lab}', [resultController::class, 'print'])->name('print.pasien');
// });

route::group(['prefix' => 'loket', 'middleware' => ['auth', 'role:loket,admin']], function () {

    route::resource('pasien', pasienController::class);
    route::get('loket', [pasienController::class, 'index']);
    route::post('/pasien/kirimlab', [pasienController::class, 'kirimLab'])->name('pasien.kirimlab');
    Route::get('/result', function () {
        return view('analyst.result-review');
    });
    Route::resource('report', ReportController::class);
    Route::resource('data-pasien', DataPasienController::class);
    Route::get('get-icd10', [icd10Controller::class, 'geticd10'])->name('geticd10');
    Route::get('print/barcode/{no_lab}', [pasienController::class, 'previewPrint'])->name('print.barcode');
    Route::get('/pasien/edit/{no_lab}', [pasienController::class, 'edit'])->name('pasien.viewedit');
    Route::put('/pasien/{id}', [pasienController::class, 'update'])->name('pasien.updatedata');
    Route::post('pasien/checkin', [pasienController::class, 'checkin'])->name('pasien.checkin');
    // Route::post('pasien.update', [pasienController::class, 'update'])->name('pasien.update');
});

Route::group(['prefix' => 'analyst', 'middleware' => ['auth', 'role:analyst,admin']], function () {
    // Route Dashboard
    Route::resource('analyst', analystDasboard::class);
    // route::post('/setuju', [analystDasboard::class, 'approve'])->name('analyst.approve');
    Route::post('/approve/{id}', [analystDasboard::class, 'approve'])->name('analyst.approve');
    Route::post('/checkinall', [analystDasboard::class, 'checkinall'])->name('analyst.checkinall');
    Route::post('/analyst/back/{id}', [analystDasboard::class, 'back'])->name('analyst.back');
    // Route::post('/back', [analystDasboard::class, 'back'])->name('analyst.back');
    // Route Spesiment
    Route::resource('spesiment', spesimentHendlingController::class);
    // Route::post('/spesiment', [SpesimentController::class, 'store'])->name('spesiment.store');
    Route::post('spesiment/post', [spesimentHendlingController::class, 'postSpesiment'])->name('spesiment.post');
    Route::post('spesiment/checkin', [spesimentHendlingController::class, 'checkin'])->name('spesiment.checkin');
    Route::post('/spesiment/back/{id}', [spesimentHendlingController::class, 'back'])->name('spesiment.back');
    Route::post('/spesiment/backdashboard/{id}', [spesimentHendlingController::class, 'backdashboard'])->name('spesiment.backdashboard');
    // Route Worklist
    Route::resource('worklist', worklistController::class);
    // Route::post('/worklist/done/{id}', [worklistController::class, 'store'])->name('worklist.store');
    Route::delete('analyst/worklist/{worklist}', [worklistController::class, 'destroy']);
    Route::post('/worklist/checkin/{id}', [worklistController::class, 'checkin'])->name('worklist.checkin');
    Route::post('/worklist/end/{id}', [worklistController::class, 'end'])->name('worklist.end');
    // Route Dokter
    Route::resource('vdokter', vDokterController::class);
    Route::post('/dokter/back/{id}', [vDokterController::class, 'back'])->name('dokter.back');
    Route::post('/dokter/send/{id}', [vDokterController::class, 'sentToReview'])->name('dokter.send');
    // Route Result Review
    Route::resource('result', resultController::class);
    Route::get('/departments/list', [resultController::class, 'getDepartments'])->name('departments.list');
    Route::get('/doctors/list', [resultController::class, 'getDoctors'])->name('doctors.list');
    Route::post('/result/data', [resultController::class, 'getReportData'])->name('result.data');


    Route::get('print/pasien/{no_lab}', [resultController::class, 'print'])->name('print.pasien');
    Route::post('result/done/{id}', [resultController::class, 'updateStatus'])->name('update.status');
    Route::get('report', [resultController::class, 'report'])->name('result.report');
    Route::post('report/data', [resultController::class, 'getReportData'])->name('result.data');
    Route::post('/hasil-pemeriksaans/kesimpulan-saran', [resultController::class, 'simpanKesimpulanSaran'])
        ->name('hasil_pemeriksaans.simpanKesimpulanSaran');


    // Route::get('/print', [resultController::class, 'print']);
    // Route::get('/analyst/result/{result}', [ResultController::class, 'show'])->name('result.show');
    Route::post('/insert_qc', [QcController::class, 'store'])->name('insert_qc');
    Route::resource('Qc', QcController::class);
    // Route::get('/get-qc-data', [QcController::class, 'getQcData'])->name('get-qc-data');
    Route::resource('Dqc', DqcController::class);
    Route::get('/qc/lot/create', [QcController::class, 'create'])->name('qc.lot.create');
    Route::post('/Qc/store-lot', [QcController::class, 'storeLot']);
    Route::post('/store-complete-qc', [LotController::class, 'storeComplete'])->name('analyst.lots.store-complete');
    Route::put('/update-complete-qc/{id}', [LotController::class, 'updateComplete'])->name('analyst.lots.update-complete');
    Route::get('/get-lots-by-department/{departmentId}', [LotController::class, 'getLotsByDepartment'])->name('analyst.lots.by-department');
    Route::get('/get-lot-detail/{id}', [LotController::class, 'getLotDetail'])->name('analyst.lots.detail');
    Route::delete('/delete-lot/{id}', [LotController::class, 'deleteLot'])->name('analyst.lots.delete');
    Route::get('/get-all-lots', [LotController::class, 'getAllLots'])->name('analyst.lots.all');
    Route::get('/export-lot/{id}/{format?}', [LotController::class, 'exportLot'])->name('analyst.lots.export');



    Route::get('api/get-qc-levels', [QcController::class, 'getQcLevels']);
    Route::get('api/get-qc-by-level/{level}', [QcController::class, 'getQcByLevel']);
    Route::get('api/get-qc-details/{qcId}', [QcController::class, 'getQcDetails']);
    Route::post('/api/save-qc-results', [QcController::class, 'saveQcResults']);
    Route::get('api/get-chart-data/{qcId}/{parameter}', [QcController::class, 'getChartData']);
    Route::get('api/get-control-limits/{qcId}/{parameter}', [QcController::class, 'getControlLimits']);
    Route::get('api/get-qc-history', [QcController::class, 'getQcHistory']);
    Route::get('api/export-qc-data', [QcController::class, 'exportQcData']);

    Route::resource('qh', QcHistoryController::class);
    Route::get('api/get-departments', [QcHistoryController::class, 'getDepartments']);
    Route::get('api/get-department/{id}', [QcHistoryController::class, 'getDepartment']);
    Route::get('api/get-qc-history/{lotId}', [QcHistoryController::class, 'getQcHistory']);
    Route::get('api/get-chart-data-history/{qcId}/{parameter}', [QcHistoryController::class, 'getChartDataHistory']);
    Route::get('api/get-available-dates/{lotId}', [QcHistoryController::class, 'getAvailableDates']);
    Route::get('api/get-history-statistics/{lotId}/{parameter}', [QcHistoryController::class, 'getHistoryStatistics']);

    // Route::get('/quality-control', function () {
    //     return view('analyst.quality-control');
    // });
    Route::get('/daftar-qc', function () {
        return view('analyst.daftar-qc');
    });
    Route::get('/history-qc', function () {
        return view('analyst.history-qc');
    });
});

// route::get('/worklist/pemeriksaan', [worklistController::class, 'tampilPemeriksaan']);
// route::get('/worklist/tampildarahlengkap/{nolab}', [worklistController::class, 'tampilPemeriksaan'])->name('worklist.tampildarahlengkap');

Route::get('/print/barcode/{lab}', [pasienController::class, 'previewPrint']);

route::get('/previewpasien/{lab}', [pasienController::class, 'getDataPasien']);

Route::get('/gambar/{filename}', function ($filename) {
    $path = storage_path('app/public/gambar/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
