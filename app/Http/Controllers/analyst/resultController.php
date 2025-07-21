<?php

namespace App\Http\Controllers\analyst;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\HasilPemeriksaan;
use App\Models\historyPasien;
use App\Models\pasien;
use App\Models\pemeriksaan_pasien;
use App\Models\Report;
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
            ->paginate(20);

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

        // 🔥 Buat mapping nama_pemeriksaan => nilai_rujukan
        $nilai_rujukan_map = [];

        foreach ($data_pasien->dpp as $dpp) {
            foreach ($dpp->pasiens as $pasien) {
                $pemeriksaan = $pasien->data_pemeriksaan;
                if ($pemeriksaan && !empty($pemeriksaan->nama_pemeriksaan)) {
                    $nilai_rujukan_map[$pemeriksaan->nama_pemeriksaan] = $pemeriksaan->nilai_rujukan ?? '';
                }
            }
        }

        return view('print-view.print-pasien', compact('data_pasien', 'note', 'hasil_pemeriksaans', 'nilai_rujukan_map'));
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
        return view('print-view.report');
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

            $query = Report::with([
                'detailDepartment',
                'departments' => function ($q) {
                    $q->select('id', 'nama_department');
                }
            ])
                ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);

            if (!empty($departments) && !in_array('All', $departments)) {
                $query->whereIn('department', $departments);
            }

            if (!empty($paymentMethods) && !in_array('all', $paymentMethods)) {
                $query->whereIn(DB::raw('LOWER(payment_method)'), $paymentMethods);
            }

            $results = $query->get();

            // Proses pivot data
            $pivoted = [];

            foreach ($results as $item) {
                $deptId = $item->departments->id ?? $item->department;
                $deptName = $item->departments->nama_department ?? 'Unknown';

                // Ganti nama_parameter 'All' menjadi 'Hematologi' jika department = 1
                $paramName = ($deptId == 1 && strtolower($item->nama_parameter) === 'all')
                    ? 'Hematologi'
                    : $item->nama_parameter;

                $harga = $item->detailDepartment->harga ?? 0;
                $key = $deptId . '||' . $paramName;

                if (!isset($pivoted[$key])) {
                    $pivoted[$key] = [
                        'test_name' => $paramName,
                        'department' => $deptName,
                        'department_id' => $deptId,
                        'is_department_header' => false,
                        'is_subheader' => false,
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

                switch (strtolower($item->payment_method)) {
                    case 'bpjs':
                        $pivoted[$key]['bpjs_qty'] += $item->quantity;
                        $pivoted[$key]['bpjs_price'] = $harga;
                        $pivoted[$key]['bpjs_total'] += $item->quantity * $harga;
                        break;
                    case 'asuransi':
                        $pivoted[$key]['asuransi_qty'] += $item->quantity;
                        $pivoted[$key]['asuransi_price'] = $harga;
                        $pivoted[$key]['asuransi_total'] += $item->quantity * $harga;
                        break;
                    case 'umum':
                        $pivoted[$key]['umum_qty'] += $item->quantity;
                        $pivoted[$key]['umum_price'] = $harga;
                        $pivoted[$key]['umum_total'] += $item->quantity * $harga;
                        break;
                }
            }

            $grouped = collect($pivoted)->groupBy('department_id');
            $final = [];

            foreach ($grouped as $deptId => $items) {
                // Hematologi → langsung tampilkan data (nama_parameter = 'Hematologi')
                if ($deptId == 1) {
                    foreach ($items as $item) {
                        $item['is_department_header'] = false;
                        $item['is_subheader'] = false;
                        $final[] = $item;
                    }
                    continue;
                }

                // Kimia Klinik → tampilkan header dan subheader
                if ($deptId == 2) {
                    $deptName = $items->first()['department'];

                    // Header untuk Kimia Klinik
                    $final[] = [
                        'test_name' => $deptName,
                        'department' => $deptName,
                        'department_id' => $deptId,
                        'is_department_header' => true
                    ];

                    // Group by parameter dan saring parameter dengan qty > 0
                    $groupByParam = collect($items)->groupBy('test_name');
                    foreach ($groupByParam as $paramName => $subItems) {
                        // Hitung total quantity dari semua metode pembayaran
                        $totalQty = $subItems->sum(function ($item) {
                            return $item['bpjs_qty'] + $item['asuransi_qty'] + $item['umum_qty'];
                        });

                        // Jika tidak ada hasil sama sekali, skip
                        if ($totalQty === 0) continue;

                        // Subheader untuk parameter
                        // $final[] = [
                        //     'test_name' => $paramName,
                        //     'department' => $deptName,
                        //     'department_id' => $deptId,
                        //     'is_subheader' => true
                        // ];

                        // Tambahkan data detailnya
                        foreach ($subItems as $item) {
                            $item['is_department_header'] = false;
                            $item['is_subheader'] = true;
                            $final[] = $item;
                        }
                    }

                    continue;
                }

                // Department lain (tidak hematologi & tidak kimia klinik) → tampilkan langsung
                foreach ($items as $item) {
                    // Hanya tampilkan baris yang memiliki quantity lebih dari 0 di semua metode pembayaran
                    $totalQty = $item['bpjs_qty'] + $item['asuransi_qty'] + $item['umum_qty'];
                    if ($totalQty > 0) {
                        $item['is_department_header'] = false;
                        $item['is_subheader'] = false;
                        $final[] = $item;
                    }
                }
            }

            // Tambahkan baris TOTAL
            $totalRow = [
                'test_name' => 'TOTAL',
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

            foreach ($pivoted as $row) {
                $totalRow['bpjs_qty'] += $row['bpjs_qty'];
                $totalRow['bpjs_total'] += $row['bpjs_total'];
                $totalRow['asuransi_qty'] += $row['asuransi_qty'];
                $totalRow['asuransi_total'] += $row['asuransi_total'];
                $totalRow['umum_qty'] += $row['umum_qty'];
                $totalRow['umum_total'] += $row['umum_total'];
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
