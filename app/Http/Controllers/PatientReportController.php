<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Pasien;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PatientReportController extends Controller
{
    /**
     * Menampilkan halaman laporan data pasien
     */
    public function index()
    {
        $departments = Department::all();

        return view('print-view.report-pasien', compact('departments'));
    }

    /**
     * Mengambil data laporan pasien
     */
    public function getPatientReportData(Request $request)
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
            $namaPasien = $request->input('nama_pasien');
            $noLab = $request->input('no_lab');
            $dokter = $request->input('dokter', []); // ✅ TAMBAHAN BARU

            // Query Reports dengan join ke Pasien
            $query = Report::with([
                'detailDepartment',
                'departments:id,nama_department',
                'mcuPackage',
            ])
                ->join('pasiens', 'reports.nolab', '=', 'pasiens.no_lab')
                ->whereBetween('reports.tanggal', [$tanggalAwal, $tanggalAkhir])
                ->select('reports.*', 'pasiens.nama', 'pasiens.jenis_kelamin', 'pasiens.lahir');

            // Filter departemen
            if (!empty($departments) && !in_array('All', $departments)) {
                $query->whereIn('reports.department', $departments);
            }

            // Filter metode pembayaran
            if (!empty($paymentMethods) && !in_array('all', $paymentMethods)) {
                $query->whereIn(DB::raw('LOWER(reports.payment_method)'), $paymentMethods);
            }

            // Filter nama pasien
            if (!empty($namaPasien)) {
                $query->where('pasiens.nama', 'LIKE', '%' . $namaPasien . '%');
            }

            // Filter no lab
            if (!empty($noLab)) {
                $query->where('reports.nolab', 'LIKE', '%' . $noLab . '%');
            }

            // ✅ TAMBAHAN BARU: Filter Dokter (Internal + External)
            if (!empty($dokter) && !in_array('all', $dokter)) {
                $query->where(function ($q) use ($dokter) {
                    $q->whereIn('reports.nama_dokter', $dokter)
                        ->orWhereIn('reports.dokter_external', $dokter);
                });
            }

            // Order by no_lab dan tanggal
            $query->orderBy('reports.nolab', 'asc')
                ->orderBy('reports.tanggal', 'asc')
                ->orderBy('reports.id', 'asc');

            $results = $query->get();

            // Group by pasien
            $groupedByPatient = [];

            foreach ($results as $item) {
                $noLab = $item->nolab;

                if (!isset($groupedByPatient[$noLab])) {
                    $groupedByPatient[$noLab] = [
                        'patient_info' => [
                            'no_lab' => $item->nolab,
                            'nama_pasien' => $item->nama,
                            'jenis_kelamin' => $item->jenis_kelamin,
                            'tanggal_lahir' => $item->lahir,
                            'umur' => Carbon::parse($item->lahir)->age,
                            'tanggal' => $item->tanggal,
                        ],
                        'tests' => []
                    ];
                }

                // Hitung harga dan total
                $harga = 0;
                $namaPemeriksaan = '';

                if ($item->mcu_package_id && $item->mcuPackage) {
                    $namaPemeriksaan = $item->mcuPackage->nama_paket;
                    $harga = $item->mcuPackage->harga_final ?? 0;
                } else {
                    $namaPemeriksaan = $item->nama_parameter;
                    $harga = $item->detailDepartment->harga ?? 0;

                    if (strtolower($item->nama_parameter) === 'all') {
                        $namaPemeriksaan = $item->detailDepartment->nama_pemeriksaan ?? 'Hematologi';
                    }
                }

                $total = $item->quantity * $harga;

                // ✅ TAMBAHAN BARU: Tentukan nama dokter dan tipe
                $namaDokter = '-';
                $tipeDokter = '';

                if (!empty($item->nama_dokter)) {
                    $namaDokter = $item->nama_dokter;
                    $tipeDokter = 'Internal';
                } elseif (!empty($item->dokter_external)) {
                    $namaDokter = $item->dokter_external;
                    $tipeDokter = 'External';
                }

                $groupedByPatient[$noLab]['tests'][] = [
                    'nama_pemeriksaan' => $namaPemeriksaan,
                    'department' => $item->departments->nama_department ?? 'Unknown',
                    'payment_method' => $item->payment_method,
                    'nama_dokter' => $namaDokter,
                    'tipe_dokter' => $tipeDokter,
                    'quantity' => $item->quantity,
                    'harga' => $harga,
                    'total' => $total,
                    'tanggal' => $item->tanggal,
                ];
            }

            // Format data untuk tampilan
            $final = [];
            $grandTotal = 0;

            foreach ($groupedByPatient as $noLab => $patientData) {
                $info = $patientData['patient_info'];
                $tests = $patientData['tests'];

                $totalPasien = 0;

                foreach ($tests as $test) {
                    $final[] = [
                        'no_lab' => $info['no_lab'],
                        'nama_pasien' => $info['nama_pasien'],
                        'jenis_kelamin' => $info['jenis_kelamin'],
                        'umur' => $info['umur'],
                        'tanggal_formatted' => Carbon::parse($test['tanggal'])->format('d/m/Y H:i'),
                        'nama_pemeriksaan' => $test['nama_pemeriksaan'],
                        'department' => $test['department'],
                        'payment_method' => $test['payment_method'],
                        'nama_dokter' => $test['nama_dokter'],
                        'tipe_dokter' => $test['tipe_dokter'],
                        'quantity' => $test['quantity'],
                        'harga' => $test['harga'],
                        'total' => $test['total'],
                        'is_patient_header' => false,
                        'is_total_patient' => false,
                        'is_grand_total' => false,
                    ];

                    $totalPasien += $test['total'];
                }

                $final[] = [
                    'total_pasien' => $totalPasien,
                    'is_patient_header' => false,
                    'is_total_patient' => true,
                    'is_grand_total' => false,
                ];

                $grandTotal += $totalPasien;
            }

            if (!empty($final)) {
                $final[] = [
                    'grand_total' => $grandTotal,
                    'is_patient_header' => false,
                    'is_total_patient' => false,
                    'is_grand_total' => true,
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $final
            ]);
        } catch (\Exception $e) {
            Log::error('Patient Report Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server: ' . $e->getMessage()
            ], 500);
        }
    }
    public function getDokterList()
    {
        try {
            // Get dokter internal
            $dokterInternal = Report::whereNotNull('nama_dokter')
                ->where('nama_dokter', '!=', '')
                ->distinct()
                ->pluck('nama_dokter')
                ->map(function ($nama) {
                    return [
                        'nama' => $nama,
                        'tipe' => 'Internal'
                    ];
                });

            // Get dokter external
            $dokterExternal = Report::whereNotNull('dokter_external')
                ->where('dokter_external', '!=', '')
                ->distinct()
                ->pluck('dokter_external')
                ->map(function ($nama) {
                    return [
                        'nama' => $nama,
                        'tipe' => 'External'
                    ];
                });

            // Gabungkan dan sort
            $allDokter = $dokterInternal->concat($dokterExternal)
                ->sortBy('nama')
                ->values();

            return response()->json([
                'success' => true,
                'data' => $allDokter
            ]);
        } catch (\Exception $e) {
            Log::error('Get Dokter List Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
