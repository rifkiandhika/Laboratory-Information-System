<?php

namespace App\Http\Controllers\analyst;

use App\Http\Controllers\Controller;
use App\Jobs\SendHasilToLis;
use App\Models\Department;
use App\Models\dokter;
use App\Models\HasilPemeriksaan;
use App\Models\historyPasien;
use App\Models\pasien;
use App\Models\pemeriksaan_pasien;
use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class resultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $dataPasien = pasien::where('status', 'Result Review')->orWhere('status', 'Spesiment')->where('cito', 0)->paginate(20);
        $dataPasien = pasien::whereIn('status', ['Result Review', 'diselesaikan'])
            ->orderBy('updated_at', 'desc')
            ->get();

        $dataHistory = historyPasien::where('proses', '=', 'order')->get();
        return view('analyst.result-review', compact('dataPasien', 'dataHistory'));
    }

    public function updateStatus($id)
    {
        // Temukan data pasien berdasarkan ID
        $pasien = pasien::findOrFail($id);

        // Update status pasien menjadi "diselesaikan"
        $pasien->status = 'diselesaikan';
        $pasien->save();

        // Kembalikan respon (misalnya redirect ke halaman sebelumnya)
        toast('Pasien telah diselesaikan', 'success');
        return redirect()->route('result.index');
    }

    public function updateTimeById(Request $request, $id)
    {
        try {
            $request->validate([
                'tanggal_masuk' => 'nullable|date',
                'created_at' => 'nullable|date',
                'updated_at' => 'nullable|date',
            ]);

            $pasien = pasien::find($id);

            if (!$pasien) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            // Update data
            $pasien->tanggal_masuk = $request->tanggal_masuk;
            $pasien->created_at = $request->created_at;
            $pasien->updated_at = $request->updated_at;
            $pasien->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Waktu berhasil diperbarui',
                'data' => $pasien
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    public function print($no_lab, Request $request)
    {
        $note = $request->input('note', '');

        $data_pasien = pasien::where('no_lab', $no_lab)->with([
            'dpp.pasiens' => function ($query) use ($no_lab) {
                $query->where('no_lab', $no_lab);
                $query->with('data_pemeriksaan');
            },
            'dpp.data_departement',
            'dokter',
            'hasil_pemeriksaan'
        ])->first();

        $hasil_pemeriksaans = HasilPemeriksaan::where('no_lab', $no_lab)->get();

        $nilai_rujukan_map = [];
        foreach ($data_pasien->dpp as $dpp) {
            foreach ($dpp->pasiens as $pasien) {
                $pemeriksaan = $pasien->data_pemeriksaan;
                if ($pemeriksaan && !empty($pemeriksaan->nama_pemeriksaan)) {
                    $nilai_rujukan_map[$pemeriksaan->nama_pemeriksaan] = $pemeriksaan->nilai_rujukan ?? '';
                }
            }
        }

        // Ambil dokter internal
        $userDokter = null;
        $dokterName = null;

        if ($data_pasien->dokter) {
            $dokterName = $data_pasien->dokter->nama_dokter;
            $userDokter = User::whereRaw('LOWER(TRIM(name)) = ?', [strtolower(trim($dokterName))])->first();
        }

        // Ambil analyst dari tabel pasien, bukan dari auth()->user()
        $userAnalyst = null;
        if ($data_pasien->analyst) {
            $userAnalyst = User::whereRaw('LOWER(TRIM(name)) = ?', [strtolower(trim($data_pasien->analyst))])->first();
        }

        return view('print-view.print-pasien', compact(
            'data_pasien',
            'note',
            'hasil_pemeriksaans',
            'nilai_rujukan_map',
            'userDokter',
            'dokterName',
            'userAnalyst'
        ));
    }

    public function simpanKesimpulanSaran(Request $request)
    {
        $request->validate([
            'no_lab' => 'required',
            'kesimpulan' => 'nullable|string',
            'saran' => 'nullable|string',
        ]);

        $hasil = HasilPemeriksaan::where('no_lab', $request->no_lab)->firstOrFail();
        $hasil->kesimpulan = $request->kesimpulan;
        $hasil->saran = $request->saran;
        $hasil->save();

        toast('Data Saved', 'success');
        return redirect()->route('result.index');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        return view('print-view.print-pasien', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function report()
    {
        $departments = Department::all();
        $dokters_internal = Dokter::where('status', 'internal')->get();
        $dokters_external = Dokter::where('status', 'external')->get();
        $reports = Report::select('analyst')->distinct()->get();


        $asal_ruangan = Report::select('asal_ruangan')
            ->distinct()
            ->whereNotNull('asal_ruangan')
            ->orderBy('asal_ruangan')
            ->pluck('asal_ruangan');

        return view('print-view.report', compact('departments', 'dokters_internal', 'dokters_external', 'reports', 'asal_ruangan'));
    }

    public function getReportData(Request $request)
    {
        try {
            $request->validate([
                'tanggal_awal' => 'required|date',
                'tanggal_akhir' => 'required|date',
            ]);

            $tanggalAwal = $request->input('tanggal_awal') . ' 00:00:00';
            $tanggalAkhir = $request->input('tanggal_akhir') . ' 23:59:59';
            $departments = $request->input('department', []);
            $paymentMethods = array_map('strtolower', $request->input('payment_method', []));
            $mcuFilter = $request->input('mcu', []);

            $doktersInternal = $request->input('dokter_internal', []);
            $doktersExternal = $request->input('dokter_external', []);
            $analystFilter = $request->input('analyst', []);
            $asalRuanganFilter = $request->input('asal_ruangan', []);

            $query = Report::with([
                'detailDepartment',
                'departments:id,nama_department',
                'mcuPackage',
                'mcuPackage.mcuDetails.detailDepartment',
            ])->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);

            if (!empty($departments) && !in_array('All', $departments)) {
                $query->whereIn('department', $departments);
            }

            if (!empty($paymentMethods) && !in_array('all', $paymentMethods)) {
                $query->whereIn(DB::raw('LOWER(payment_method)'), $paymentMethods);
            }


            if (!empty($doktersInternal) || !empty($doktersExternal)) {
                $query->where(function ($q) use ($doktersInternal, $doktersExternal) {
                    // Filter Dokter Internal
                    if (!empty($doktersInternal) && !in_array('All', $doktersInternal)) {
                        $q->orWhereIn('nama_dokter', $doktersInternal);
                    } elseif (!empty($doktersInternal) && in_array('All', $doktersInternal)) {
                        $internalDoctors = dokter::where('status', 'internal')
                            ->pluck('nama_dokter')
                            ->toArray();
                        if (!empty($internalDoctors)) {
                            $q->orWhereIn('nama_dokter', $internalDoctors);
                        }
                    }

                    // Filter Dokter External - GUNAKAN KOLOM dokter_external
                    if (!empty($doktersExternal) && !in_array('All', $doktersExternal)) {
                        $q->orWhereIn('dokter_external', $doktersExternal);
                    } elseif (!empty($doktersExternal) && in_array('All', $doktersExternal)) {
                        $externalDoctors = dokter::where('status', 'external')
                            ->pluck('nama_dokter')
                            ->toArray();
                        if (!empty($externalDoctors)) {
                            $q->orWhereIn('dokter_external', $externalDoctors);
                        }
                    }
                });
            }

            if (!empty($mcuFilter) && !in_array('All', $mcuFilter)) {
                if (in_array('1', $mcuFilter) && in_array('0', $mcuFilter)) {
                    // Semua
                } elseif (in_array('1', $mcuFilter)) {
                    $query->whereNotNull('mcu_package_id');
                } elseif (in_array('0', $mcuFilter)) {
                    $query->whereNull('mcu_package_id');
                }
            }

            if (!empty($analystFilter) && !in_array('All', $analystFilter)) {
                $query->whereIn('analyst', $analystFilter);
            }

            if (!empty($asalRuanganFilter) && !in_array('All', $asalRuanganFilter)) {
                $query->whereIn('asal_ruangan', $asalRuanganFilter);
            }

            $results = $query->get();

            $pivoted = [];
            $mcuParameters = [];
            $processedMcuLabs = [];

            $users = User::select('id', 'name', 'fee', 'feemcu')->get()->keyBy('name');

            foreach ($results as $item) {
                $deptId = $item->departments->id ?? $item->department;
                $deptName = $item->departments->nama_department ?? 'Unknown';


                $namaDokter = $item->nama_dokter ?? $item->dokter_external ?? '-';
                $asalRuangan = $item->asal_ruangan ?? '-';

                $analystName = $item->analyst ?? '-';
                $analystData = $users->get($analystName);
                $analystFee = $analystData->fee ?? 0;
                $analystMcuFee = $analystData->feemcu ?? 0;

                // MCU Package
                if ($item->mcu_package_id && $item->mcuPackage) {
                    $packageName = $item->mcuPackage->nama_paket;
                    $packageId = $item->mcu_package_id;
                    $packageKey = 'MCU_PACKAGE_' . $packageId . '||' . $namaDokter . '||' . $asalRuangan . '||' . $analystName;

                    $uniquePatientKey = $packageKey . '||' . $item->no_lab;
                    if (in_array($uniquePatientKey, $processedMcuLabs)) {
                        continue;
                    }
                    $processedMcuLabs[] = $uniquePatientKey;

                    if (!isset($pivoted[$packageKey])) {
                        $pivoted[$packageKey] = [
                            'test_name' => $packageName,
                            'department' => 'MCU',
                            'department_id' => 999,
                            'mcu_package_id' => $packageId,
                            'package_name' => $packageName,
                            'dokter' => $namaDokter,
                            'dokter_external' => $item->dokter_external ?? null,
                            'asal_ruangan' => $asalRuangan,
                            'jasa_dokter' => 0,
                            'jasa_bidan' => 0,
                            'jasa_perawat' => 0,
                            'analyst' => $analystName,
                            'analyst_fee_percent' => $analystMcuFee,
                            'is_department_header' => false,
                            'is_subheader' => false,
                            'is_mcu_package' => true,
                            'is_mcu_parameter' => false,
                            'bpjs_qty' => 0,
                            'bpjs_price' => 0,
                            'bpjs_total' => 0,
                            'bpjs_analyst_fee' => 0,
                            'asuransi_qty' => 0,
                            'asuransi_price' => 0,
                            'asuransi_total' => 0,
                            'asuransi_analyst_fee' => 0,
                            'umum_qty' => 0,
                            'umum_price' => 0,
                            'umum_total' => 0,
                            'umum_analyst_fee' => 0,
                        ];
                    }

                    if ($item->jabatan == 'dokter') {
                        $pivoted[$packageKey]['jasa_dokter'] = $item->mcuPackage->jasa_dokter ?? 0;
                    } elseif ($item->jabatan == 'bidan') {
                        $pivoted[$packageKey]['jasa_bidan'] = $item->mcuPackage->jasa_bidan ?? 0;
                    } elseif ($item->jabatan == 'perawat') {
                        $pivoted[$packageKey]['jasa_perawat'] = $item->mcuPackage->jasa_perawat ?? 0;
                    }

                    $hargaPackage = $item->mcuPackage->harga_final ?? 0;

                    switch (strtolower($item->payment_method)) {
                        case 'bpjs':
                            $pivoted[$packageKey]['bpjs_qty'] += 1;
                            $pivoted[$packageKey]['bpjs_price'] = $hargaPackage;
                            $pivoted[$packageKey]['bpjs_total'] += $hargaPackage;
                            $pivoted[$packageKey]['bpjs_analyst_fee'] += $hargaPackage * ($analystMcuFee / 100);
                            break;
                        case 'asuransi':
                            $pivoted[$packageKey]['asuransi_qty'] += 1;
                            $pivoted[$packageKey]['asuransi_price'] = $hargaPackage;
                            $pivoted[$packageKey]['asuransi_total'] += $hargaPackage;
                            $pivoted[$packageKey]['asuransi_analyst_fee'] += $hargaPackage * ($analystMcuFee / 100);
                            break;
                        case 'umum':
                            $pivoted[$packageKey]['umum_qty'] += 1;
                            $pivoted[$packageKey]['umum_price'] = $hargaPackage;
                            $pivoted[$packageKey]['umum_total'] += $hargaPackage;
                            $pivoted[$packageKey]['umum_analyst_fee'] += $hargaPackage * ($analystMcuFee / 100);
                            break;
                    }

                    // MCU Parameters
                    if ($item->mcuPackage->mcuDetails) {
                        foreach ($item->mcuPackage->mcuDetails as $detail) {
                            $parameterKey = 'MCU_PARAM_' . $packageId . '_' . $detail->id;
                            if (!isset($mcuParameters[$parameterKey])) {
                                $mcuParameters[$parameterKey] = [
                                    'test_name' => $packageName,
                                    'parameter_name' => $detail->detailDepartment->nama_pemeriksaan ?? 'Unknown Parameter',
                                    'department' => 'MCU',
                                    'department_id' => 999,
                                    'mcu_package_id' => $packageId,
                                    'package_name' => $packageName,
                                    'dokter' => '-',
                                    'dokter_external' => null,
                                    'asal_ruangan' => '-',
                                    'jasa_dokter' => 0,
                                    'analyst' => '-',
                                    'analyst_fee_percent' => 0,
                                    'is_department_header' => false,
                                    'is_subheader' => false,
                                    'is_mcu_package' => false,
                                    'is_mcu_parameter' => true,
                                    'bpjs_qty' => 0,
                                    'bpjs_price' => 0,
                                    'bpjs_total' => 0,
                                    'bpjs_analyst_fee' => 0,
                                    'asuransi_qty' => 0,
                                    'asuransi_price' => 0,
                                    'asuransi_total' => 0,
                                    'asuransi_analyst_fee' => 0,
                                    'umum_qty' => 0,
                                    'umum_price' => 0,
                                    'umum_total' => 0,
                                    'umum_analyst_fee' => 0,
                                ];
                            }
                        }
                    }
                }
                // Non-MCU
                else {
                    $displayName = $item->nama_parameter;
                    $harga = $item->detailDepartment->harga ?? 0;

                    $dokter = dokter::where('nama_dokter', $item->nama_dokter)
                        ->orWhere('nama_dokter', $item->dokter_external)
                        ->first();
                    $jabatan = strtolower($dokter->jabatan ?? 'dokter');

                    if ($jabatan === 'bidan') {
                        $jasa = $item->detailDepartment->jasa_bidan ?? 0;
                    } elseif ($jabatan === 'perawat') {
                        $jasa = $item->detailDepartment->jasa_perawat ?? 0;
                    } else {
                        $jasa = $item->detailDepartment->jasa_dokter ?? 0;
                    }

                    if (strtolower($item->nama_parameter) === 'all') {
                        $displayName = $item->detailDepartment->nama_pemeriksaan ?? 'Hematologi';
                    }

                    $key = $deptId . '||' . $displayName . '||' . $namaDokter . '||' . $asalRuangan . '||' . $analystName;

                    if (!isset($pivoted[$key])) {
                        $pivoted[$key] = [
                            'test_name' => $displayName,
                            'department' => $deptName,
                            'department_id' => $deptId,
                            'mcu_package_id' => null,
                            'package_name' => null,
                            'dokter' => $namaDokter,
                            'dokter_external' => $item->dokter_external ?? null, // ✅ Kirim data external
                            'asal_ruangan' => $asalRuangan,
                            'jasa_dokter' => $jasa,
                            'analyst' => $analystName,
                            'analyst_fee_percent' => $analystFee,
                            'is_department_header' => false,
                            'is_subheader' => false,
                            'is_mcu_package' => false,
                            'is_mcu_parameter' => false,
                            'bpjs_qty' => 0,
                            'bpjs_price' => 0,
                            'bpjs_total' => 0,
                            'bpjs_analyst_fee' => 0,
                            'asuransi_qty' => 0,
                            'asuransi_price' => 0,
                            'asuransi_total' => 0,
                            'asuransi_analyst_fee' => 0,
                            'umum_qty' => 0,
                            'umum_price' => 0,
                            'umum_total' => 0,
                            'umum_analyst_fee' => 0,
                        ];
                    }

                    $totalValue = $item->quantity * $harga;

                    switch (strtolower($item->payment_method)) {
                        case 'bpjs':
                            $pivoted[$key]['bpjs_qty'] += $item->quantity;
                            $pivoted[$key]['bpjs_price'] = $harga;
                            $pivoted[$key]['bpjs_total'] += $totalValue;
                            $pivoted[$key]['bpjs_analyst_fee'] += $totalValue * ($analystFee / 100);
                            break;
                        case 'asuransi':
                            $pivoted[$key]['asuransi_qty'] += $item->quantity;
                            $pivoted[$key]['asuransi_price'] = $harga;
                            $pivoted[$key]['asuransi_total'] += $totalValue;
                            $pivoted[$key]['asuransi_analyst_fee'] += $totalValue * ($analystFee / 100);
                            break;
                        case 'umum':
                            $pivoted[$key]['umum_qty'] += $item->quantity;
                            $pivoted[$key]['umum_price'] = $harga;
                            $pivoted[$key]['umum_total'] += $totalValue;
                            $pivoted[$key]['umum_analyst_fee'] += $totalValue * ($analystFee / 100);
                            break;
                    }
                }
            }

            $pivoted = array_merge($pivoted, $mcuParameters);

            // Grouping
            $grouped = collect($pivoted)->groupBy(function ($row) {
                if ($row['is_mcu_package'] || $row['is_mcu_parameter']) {
                    return 'MCU-' . $row['mcu_package_id'];
                }
                return $row['department_id'];
            });

            $final = [];

            foreach ($grouped as $groupKey => $items) {
                $firstItem = $items->first();

                if (str_starts_with($groupKey, 'MCU-')) {
                    $mcuPackages = $items->where('is_mcu_package', true);
                    $mcuParams = $items->where('is_mcu_parameter', true);

                    $final[] = [
                        'test_name' => 'MCU',
                        'department' => 'MCU',
                        'department_id' => 999,
                        'dokter' => '-',
                        'dokter_external' => null,
                        'asal_ruangan' => '-',
                        'jasa_dokter' => 0,
                        'analyst' => '-',
                        'analyst_fee_percent' => 0,
                        'is_department_header' => true,
                        'is_subheader' => false,
                        'is_mcu_package' => false,
                        'is_mcu_parameter' => false,
                        'bpjs_qty' => 0,
                        'bpjs_price' => 0,
                        'bpjs_total' => 0,
                        'bpjs_analyst_fee' => 0,
                        'asuransi_qty' => 0,
                        'asuransi_price' => 0,
                        'asuransi_total' => 0,
                        'asuransi_analyst_fee' => 0,
                        'umum_qty' => 0,
                        'umum_price' => 0,
                        'umum_total' => 0,
                        'umum_analyst_fee' => 0,
                    ];

                    foreach ($mcuPackages as $package) {
                        $final[] = $package;
                    }

                    foreach ($mcuParams as $param) {
                        $final[] = $param;
                    }

                    continue;
                }

                if ($firstItem['department_id'] == 1) {
                    foreach ($items as $item) {
                        $final[] = $item;
                    }
                    continue;
                }

                $deptName = $firstItem['department'];
                $final[] = [
                    'test_name' => strtoupper($deptName),
                    'department' => $deptName,
                    'department_id' => $firstItem['department_id'],
                    'dokter' => '-',
                    'dokter_external' => null,
                    'asal_ruangan' => '-',
                    'jasa_dokter' => 0,
                    'analyst' => '-',
                    'analyst_fee_percent' => 0,
                    'is_department_header' => true,
                    'is_subheader' => false,
                    'is_mcu_package' => false,
                    'is_mcu_parameter' => false,
                    'bpjs_qty' => 0,
                    'bpjs_price' => 0,
                    'bpjs_total' => 0,
                    'bpjs_analyst_fee' => 0,
                    'asuransi_qty' => 0,
                    'asuransi_price' => 0,
                    'asuransi_total' => 0,
                    'asuransi_analyst_fee' => 0,
                    'umum_qty' => 0,
                    'umum_price' => 0,
                    'umum_total' => 0,
                    'umum_analyst_fee' => 0,
                ];

                foreach ($items as $item) {
                    $item['is_subheader'] = true;
                    $final[] = $item;
                }
            }

            // Total Row
            $totalRow = [
                'test_name' => 'TOTAL',
                'department' => '',
                'department_id' => null,
                'dokter' => '-',
                'dokter_external' => null,
                'asal_ruangan' => '-',
                'jasa_dokter' => 0,
                'analyst' => '-',
                'analyst_fee_percent' => 0,
                'is_department_header' => false,
                'is_subheader' => false,
                'is_mcu_package' => false,
                'is_mcu_parameter' => false,
                'bpjs_qty' => 0,
                'bpjs_total' => 0,
                'bpjs_analyst_fee' => 0,
                'asuransi_qty' => 0,
                'asuransi_total' => 0,
                'asuransi_analyst_fee' => 0,
                'umum_qty' => 0,
                'umum_total' => 0,
                'umum_analyst_fee' => 0,
            ];

            foreach ($pivoted as $row) {
                if (!$row['is_mcu_parameter'] && !$row['is_department_header']) {
                    $totalRow['bpjs_total'] += $row['bpjs_total'];
                    $totalRow['bpjs_analyst_fee'] += $row['bpjs_analyst_fee'];
                    $totalRow['asuransi_total'] += $row['asuransi_total'];
                    $totalRow['asuransi_analyst_fee'] += $row['asuransi_analyst_fee'];
                    $totalRow['umum_total'] += $row['umum_total'];
                    $totalRow['umum_analyst_fee'] += $row['umum_analyst_fee'];
                }
            }

            $final[] = $totalRow;

            return response()->json([
                'success' => true,
                'data' => $final
            ]);
        } catch (\Exception $e) {
            Log::error('Report Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server: ' . $e->getMessage()
            ], 500);
        }
    }
}
