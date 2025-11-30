<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SimpleReportController extends Controller
{
    /**
     * Menampilkan halaman laporan sederhana
     */
    public function index()
    {
        $departments = Department::all();

        return view('print-view.pure-report', compact('departments'));
    }

    /**
     * Mengambil data laporan sederhana (hanya pemeriksaan tanpa dokter/analis)
     */
    public function getSimpleReportData(Request $request)
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

            // Query dasar
            $query = Report::with([
                'detailDepartment',
                'departments:id,nama_department',
                'mcuPackage',
                'mcuPackage.mcuDetails.detailDepartment',
            ])->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);

            // Filter departemen
            if (!empty($departments) && !in_array('All', $departments)) {
                $query->whereIn('department', $departments);
            }

            // Filter metode pembayaran
            if (!empty($paymentMethods) && !in_array('all', $paymentMethods)) {
                $query->whereIn(DB::raw('LOWER(payment_method)'), $paymentMethods);
            }

            $results = $query->get();

            $pivoted = [];
            $mcuParameters = [];
            $processedMcuLabs = [];

            foreach ($results as $item) {
                $deptId = $item->departments->id ?? $item->department;
                $deptName = $item->departments->nama_department ?? 'Unknown';

                // MCU Package
                if ($item->mcu_package_id && $item->mcuPackage) {
                    $packageName = $item->mcuPackage->nama_paket;
                    $packageId = $item->mcu_package_id;
                    $packageKey = 'MCU_PACKAGE_' . $packageId;

                    // Cek apakah pasien ini sudah diproses
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
                            'is_department_header' => false,
                            'is_subheader' => false,
                            'is_mcu_package' => true,
                            'is_mcu_parameter' => false,
                            'bpjs_qty' => 0,
                            'bpjs_price' => 0,
                            'bpjs_total' => 0,
                            'asuransi_qty' => 0,
                            'asuransi_price' => 0,
                            'asuransi_total' => 0,
                            'umum_qty' => 0,
                            'umum_price' => 0,
                            'umum_total' => 0,
                        ];
                    }

                    $hargaPackage = $item->mcuPackage->harga_final ?? 0;

                    // Hitung berdasarkan payment method
                    switch (strtolower($item->payment_method)) {
                        case 'bpjs':
                            $pivoted[$packageKey]['bpjs_qty'] += 1;
                            $pivoted[$packageKey]['bpjs_price'] = $hargaPackage;
                            $pivoted[$packageKey]['bpjs_total'] += $hargaPackage;
                            break;
                        case 'asuransi':
                            $pivoted[$packageKey]['asuransi_qty'] += 1;
                            $pivoted[$packageKey]['asuransi_price'] = $hargaPackage;
                            $pivoted[$packageKey]['asuransi_total'] += $hargaPackage;
                            break;
                        case 'umum':
                            $pivoted[$packageKey]['umum_qty'] += 1;
                            $pivoted[$packageKey]['umum_price'] = $hargaPackage;
                            $pivoted[$packageKey]['umum_total'] += $hargaPackage;
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
                                    'is_department_header' => false,
                                    'is_subheader' => false,
                                    'is_mcu_package' => false,
                                    'is_mcu_parameter' => true,
                                    'bpjs_qty' => 0,
                                    'bpjs_price' => 0,
                                    'bpjs_total' => 0,
                                    'asuransi_qty' => 0,
                                    'asuransi_price' => 0,
                                    'asuransi_total' => 0,
                                    'umum_qty' => 0,
                                    'umum_price' => 0,
                                    'umum_total' => 0,
                                ];
                            }
                        }
                    }
                }
                // Non-MCU
                else {
                    $displayName = $item->nama_parameter;
                    $harga = $item->detailDepartment->harga ?? 0;

                    // Jika parameter "all", gunakan nama pemeriksaan
                    if (strtolower($item->nama_parameter) === 'all') {
                        $displayName = $item->detailDepartment->nama_pemeriksaan ?? 'Hematologi';
                    }

                    $key = $deptId . '||' . $displayName;

                    if (!isset($pivoted[$key])) {
                        $pivoted[$key] = [
                            'test_name' => $displayName,
                            'department' => $deptName,
                            'department_id' => $deptId,
                            'mcu_package_id' => null,
                            'package_name' => null,
                            'is_department_header' => false,
                            'is_subheader' => false,
                            'is_mcu_package' => false,
                            'is_mcu_parameter' => false,
                            'bpjs_qty' => 0,
                            'bpjs_price' => 0,
                            'bpjs_total' => 0,
                            'asuransi_qty' => 0,
                            'asuransi_price' => 0,
                            'asuransi_total' => 0,
                            'umum_qty' => 0,
                            'umum_price' => 0,
                            'umum_total' => 0,
                        ];
                    }

                    $totalValue = $item->quantity * $harga;

                    // Hitung berdasarkan payment method
                    switch (strtolower($item->payment_method)) {
                        case 'bpjs':
                            $pivoted[$key]['bpjs_qty'] += $item->quantity;
                            $pivoted[$key]['bpjs_price'] = $harga;
                            $pivoted[$key]['bpjs_total'] += $totalValue;
                            break;
                        case 'asuransi':
                            $pivoted[$key]['asuransi_qty'] += $item->quantity;
                            $pivoted[$key]['asuransi_price'] = $harga;
                            $pivoted[$key]['asuransi_total'] += $totalValue;
                            break;
                        case 'umum':
                            $pivoted[$key]['umum_qty'] += $item->quantity;
                            $pivoted[$key]['umum_price'] = $harga;
                            $pivoted[$key]['umum_total'] += $totalValue;
                            break;
                    }
                }
            }

            // Gabungkan MCU parameters
            $pivoted = array_merge($pivoted, $mcuParameters);

            // Grouping berdasarkan departemen
            $grouped = collect($pivoted)->groupBy(function ($row) {
                if ($row['is_mcu_package'] || $row['is_mcu_parameter']) {
                    return 'MCU-' . $row['mcu_package_id'];
                }
                return $row['department_id'];
            });

            $final = [];

            foreach ($grouped as $groupKey => $items) {
                $firstItem = $items->first();

                // MCU Group
                if (str_starts_with($groupKey, 'MCU-')) {
                    $mcuPackages = $items->where('is_mcu_package', true);
                    $mcuParams = $items->where('is_mcu_parameter', true);

                    // Header MCU
                    $final[] = [
                        'test_name' => 'MCU',
                        'department' => 'MCU',
                        'department_id' => 999,
                        'is_department_header' => true,
                        'is_subheader' => false,
                        'is_mcu_package' => false,
                        'is_mcu_parameter' => false,
                        'bpjs_qty' => 0,
                        'bpjs_price' => 0,
                        'bpjs_total' => 0,
                        'asuransi_qty' => 0,
                        'asuransi_price' => 0,
                        'asuransi_total' => 0,
                        'umum_qty' => 0,
                        'umum_price' => 0,
                        'umum_total' => 0,
                    ];

                    // Package
                    foreach ($mcuPackages as $package) {
                        $final[] = $package;
                    }

                    // Parameters
                    foreach ($mcuParams as $param) {
                        $final[] = $param;
                    }

                    continue;
                }

                // Hematologi (department_id = 1) - tanpa header
                if ($firstItem['department_id'] == 1) {
                    foreach ($items as $item) {
                        $final[] = $item;
                    }
                    continue;
                }

                // Departemen lain - dengan header
                $deptName = $firstItem['department'];
                $final[] = [
                    'test_name' => strtoupper($deptName),
                    'department' => $deptName,
                    'department_id' => $firstItem['department_id'],
                    'is_department_header' => true,
                    'is_subheader' => false,
                    'is_mcu_package' => false,
                    'is_mcu_parameter' => false,
                    'bpjs_qty' => 0,
                    'bpjs_price' => 0,
                    'bpjs_total' => 0,
                    'asuransi_qty' => 0,
                    'asuransi_price' => 0,
                    'asuransi_total' => 0,
                    'umum_qty' => 0,
                    'umum_price' => 0,
                    'umum_total' => 0,
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
                'is_department_header' => false,
                'is_subheader' => false,
                'is_mcu_package' => false,
                'is_mcu_parameter' => false,
                'bpjs_qty' => 0,
                'bpjs_total' => 0,
                'asuransi_qty' => 0,
                'asuransi_total' => 0,
                'umum_qty' => 0,
                'umum_total' => 0,
            ];

            // Hitung total
            foreach ($pivoted as $row) {
                if (!$row['is_mcu_parameter'] && !$row['is_department_header']) {
                    $totalRow['bpjs_total'] += $row['bpjs_total'];
                    $totalRow['asuransi_total'] += $row['asuransi_total'];
                    $totalRow['umum_total'] += $row['umum_total'];
                }
            }

            $final[] = $totalRow;

            return response()->json([
                'success' => true,
                'data' => $final
            ]);
        } catch (\Exception $e) {
            Log::error('Simple Report Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server: ' . $e->getMessage()
            ], 500);
        }
    }
}
