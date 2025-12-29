<?php

use App\Http\Controllers\admin\AdminDeviceController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\IpRangeController;
use App\Http\Controllers\admin\LoginLogController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\icd10\icd10Controller;
use App\Http\Controllers\loket\pasienController;
use App\Http\Controllers\analyst\analystDasboard;
use App\Http\Controllers\analyst\DqcController;
use App\Http\Controllers\analyst\DSpesimentController;
use App\Http\Controllers\analyst\LotController;
use App\Http\Controllers\analyst\QcController;
use App\Http\Controllers\analyst\QcHistoryController;
use App\Http\Controllers\analyst\resultController;
use App\Http\Controllers\analyst\RolePermissionController;
use App\Http\Controllers\analyst\SpesimentController;
use App\Http\Controllers\analyst\worklistController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\analyst\spesimentHendlingController;
use App\Http\Controllers\analyst\vDokterController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\auth\LocationController;
use App\Http\Controllers\department\DepartmentController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\HasilImageController;
use App\Http\Controllers\loket\DataPasienController;
use App\Http\Controllers\mcu\McuPackageController as McuMcuPackageController;
use App\Http\Controllers\McuPackageController;
use App\Http\Controllers\PatientReportController;
use App\Http\Controllers\pemeriksaan\PemeriksaanController;
use App\Http\Controllers\poli\PoliController;
use App\Http\Controllers\report\ReportController;
use App\Http\Controllers\rolepermission\PermissionController;
use App\Http\Controllers\rolepermission\RoleController;
use App\Http\Controllers\SimpleReportController;
use App\Http\Controllers\user\UserController;
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






route::resource('login', AuthController::class);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return redirect()->route('login.index');
});

Route::get('/login', [AuthController::class, 'index'])->name('login.index');
Route::post('/login', [AuthController::class, 'proses'])->name('login.proses');

// Location verification routes (accessible before login)
Route::post('/check-device', [LocationController::class, 'checkDevice'])->name('check.device');
Route::get('/check-device-status', [AuthController::class, 'checkDeviceStatus'])->name('check.device.status');
Route::post('/register-device', [LocationController::class, 'registerDevice'])->name('register.device');
Route::post('/verify-location', [LocationController::class, 'verifyLocation'])->name('verifylocation');


// Location verification routes (accessible before login)
Route::post('/check-device', [LocationController::class, 'checkDevice'])->name('check.device');
Route::post('/register-device', [LocationController::class, 'registerDevice'])->name('register.device');
Route::post('/verify-location', [LocationController::class, 'verifyLocation'])->name('verifylocation');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboardmon', [DashboardController::class, 'index'])->name('dashboard.index');

    // Device Management
    Route::prefix('devices')->name('devices.')->group(function () {
        Route::get('/', [AdminDeviceController::class, 'index'])->name('index');
        Route::post('/{id}/approve', [AdminDeviceController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [AdminDeviceController::class, 'reject'])->name('reject');
        Route::post('/{id}/revoke', [AdminDeviceController::class, 'revoke'])->name('revoke');
        Route::delete('/{id}', [AdminDeviceController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-approve', [AdminDeviceController::class, 'bulkApprove'])->name('bulk-approve');
    });

    // IP Range Management
    Route::prefix('ip-ranges')->name('ip-ranges.')->group(function () {
        Route::get('/', [IpRangeController::class, 'index'])->name('index');
        Route::post('/', [IpRangeController::class, 'store'])->name('store');
        Route::post('/{id}/toggle', [IpRangeController::class, 'toggle'])->name('toggle');
        Route::delete('/{id}', [IpRangeController::class, 'destroy'])->name('destroy');
    });

    // Login Logs
    Route::get('/login-logs', [LoginLogController::class, 'index'])->name('login-logs');
});

//admin
route::middleware('auth')->group(function () {
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
    Route::resource('role-permissions', RolePermissionController::class);
    Route::resource('users', UserController::class);
    Route::get('/package-details/{id}', [McuMcuPackageController::class, 'getPackageDetails'])->name('package-details');
});


Route::get('signature/{filename}', function ($filename) {
    $path = storage_path('app/public/signatures/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    return response($file, 200)->header("Content-Type", $type);
});


route::group(['prefix' => 'loket', 'middleware' => ['auth']], function () {

    route::resource('pasien', pasienController::class);
    route::get('loket', [pasienController::class, 'index']);
    route::post('/pasien/kirimlab', [pasienController::class, 'kirimLab'])->name('pasien.kirimlab');
    Route::get('/result', function () {
        return view('analyst.result-review');
    });
    Route::resource('report', ReportController::class);
    Route::resource('data-pasien', DataPasienController::class);
    Route::put('/data_pasien/{id}', [DataPasienController::class, 'updated'])->name('data_pasien.updated');
    Route::get('get-icd10', [icd10Controller::class, 'geticd10'])->name('geticd10');
    Route::get('print/barcode/{no_lab}', [pasienController::class, 'previewPrint'])->name('print.barcode');
    Route::get('/pasien/edit/{no_lab}', [pasienController::class, 'edit'])->name('pasien.viewedit');
    Route::put('/pasien/{id}', [pasienController::class, 'update'])->name('pasien.updatedata');
    Route::post('pasien/checkin', [pasienController::class, 'checkin'])->name('pasien.checkin');
    // Route::post('pasien.update', [pasienController::class, 'update'])->name('pasien.update');
});

Route::group(['prefix' => 'analyst', 'middleware' => ['auth']], function () {
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
    Route::post('/worklist/update-hasil/{no_lab}', [WorklistController::class, 'updateHasil'])
        ->name('worklist.update-hasil');
    Route::post('/worklist/simpan-sementara', [WorklistController::class, 'simpanSementara'])
        ->name('worklist.simpanSementara');
    Route::post('worklist/upload-images', [HasilImageController::class, 'uploadImages']);
    Route::delete('worklist/delete-image/{id}', [HasilImageController::class, 'deleteImage']);
    Route::post('/hasil/kirim/{no_lab}', [HasilController::class, 'kirimHasil'])->name('hasil.kirim');
    // Route Dokter
    Route::resource('vdokter', vDokterController::class);
    Route::post('/dokter/back/{id}', [vDokterController::class, 'back'])->name('dokter.back');
    Route::post('/dokter/send/{id}', [vDokterController::class, 'sentToReview'])->name('dokter.send');
    // Route Result Review
    Route::resource('result', resultController::class);
    Route::get('/departments/list', [resultController::class, 'getDepartments'])->name('departments.list');
    Route::get('/doctors/list', [resultController::class, 'getDoctors'])->name('doctors.list');
    // Route::post('/result/data', [resultController::class, 'getReportData'])->name('result.data');
    Route::get('/debug-uid/{no_lab}', [WorklistController::class, 'debugUID']);




    Route::get('print/pasien/{no_lab}', [resultController::class, 'print'])->name('print.pasien');
    Route::post('result/done/{id}', [resultController::class, 'updateStatus'])->name('update.status');
    Route::get('report', [resultController::class, 'report'])->name('result.report');
    Route::post('report/data', [resultController::class, 'getReportData'])->name('result.data');
    Route::post('/hasil-pemeriksaans/kesimpulan-saran', [resultController::class, 'simpanKesimpulanSaran'])
        ->name('hasil_pemeriksaans.simpanKesimpulanSaran');


    Route::get('/laporan-pemeriksaan', [SimpleReportController::class, 'index'])->name('report.simple');
    Route::post('/laporan-pemeriksaan/data', [SimpleReportController::class, 'getSimpleReportData'])->name('result.data.simple');
    // Route untuk laporan data pasien
    Route::get('/laporan-pasien', [PatientReportController::class, 'index'])->name('patient.report');
    Route::post('/laporan-pasien/data', [PatientReportController::class, 'getPatientReportData'])->name('patient.report.data');
    Route::get('/patient-report/dokter-list', [PatientReportController::class, 'getDokterList'])
        ->name('patient.report.dokter.list');



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
