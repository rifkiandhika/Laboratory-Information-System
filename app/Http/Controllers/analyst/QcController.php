<?php

namespace App\Http\Controllers\analyst;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\DetailLot;
use App\Models\obr;
use App\Models\obx;
use App\Models\pasien;
use App\Models\Qc;
use App\Models\QcResult;
use App\Models\quality_control;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class QcController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::paginate(20);
        $qcs = Qc::with('department')->get();

        return view('analyst.quality-control', compact('departments', 'qcs'));
    }

    public function getDataQc(Request $request, $id)
    {
        try {
            // Ambil data QC berdasarkan id yang diberikan, beserta relasi yang mungkin diperlukan
            $data_qc = Qc::where('id', $id)
                ->with([
                    'department',  // Jika ada relasi ke departemen
                ])
                ->first();

            // Cek apakah data QC ditemukan
            if (!$data_qc) {
                return response()->json([
                    'status' => 'fail',
                    'msg' => 'Data QC tidak ditemukan'
                ], 404);
            }

            // Jika data ditemukan, kembalikan dalam bentuk JSON
            return response()->json([
                'status' => 'success',
                'msg' => 'Data QC ditemukan',
                'data' => $data_qc
            ], 200);
        } catch (Exception $e) {
            // Jika terjadi error, kembalikan status fail
            return response()->json([
                'status' => 'fail',
                'msg' => 'Terjadi kesalahan saat mengambil data QC'
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $department = Department::paginate(10);
        return view('analyst.qc.lot', compact('department'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function storeComplete(Request $request)
    // {
    //     // Log data yang diterima untuk debugging
    //     Log::info('Data yang diterima:', $request->all());

    //     try {
    //         // Validasi data
    //         $validated = $request->validate([
    //             'lot.no_lot' => 'required|string|unique:quality_controls,no_lot',
    //             'lot.name_control' => 'required|string',
    //             'lot.level' => 'required|in:Low,Normal,High',
    //             'lot.exp_date' => 'required|date',
    //             'lot.use_qc' => 'nullable|date',
    //             'lot.last_qc' => 'nullable|date',
    //             'parameters' => 'required|array',
    //             'department_id' => 'required|exists:departments,id',
    //         ]);
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         Log::error('Validation errors:', $e->errors());
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Data tidak valid',
    //             'errors' => $e->errors()
    //         ], 422);
    //     }

    //     try {
    //         DB::beginTransaction();

    //         // Simpan ke tabel quality_controls
    //         $qc = Qc::create([
    //             'no_lot' => $validated['lot']['no_lot'],
    //             'name_control' => $validated['lot']['name_control'],
    //             'level' => strtolower($validated['lot']['level']),
    //             'exp_date' => $validated['lot']['exp_date'],
    //             'use_qc' => $validated['lot']['use_qc'] ?? null,
    //             'last_qc' => $validated['lot']['last_qc'] ?? null,
    //             'department_id' => $validated['department_id'],
    //         ]);

    //         Log::info('QC created with ID:', ['id' => $qc->id]);

    //         // Simpan ke tabel detail_lots
    //         foreach ($validated['parameters'] as $paramName => $fields) {
    //             DetailLot::create([
    //                 'quality_control_id' => $qc->id,
    //                 'parameter' => $paramName,
    //                 'mean' => $fields['mean'] ?? 0,
    //                 'range' => $fields['range'] ?? 0,
    //                 'bts_atas' => $fields['bts_ats'] ?? 0,
    //                 'bts_bawah' => $fields['bts_bwh'] ?? 0,
    //                 'standart' => $fields['standart'] ?? 0,
    //             ]);
    //         }

    //         DB::commit();

    //         Log::info('Data berhasil disimpan');

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Data Quality Control berhasil disimpan',
    //             'data' => $qc->load('detailLots')
    //         ]);
    //     } catch (\Throwable $e) {
    //         DB::rollBack();
    //         Log::error('Error saat menyimpan data:', [
    //             'message' => $e->getMessage(),
    //             'file' => $e->getFile(),
    //             'line' => $e->getLine(),
    //             'trace' => $e->getTraceAsString()
    //         ]);

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
    //             'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
    //         ], 500);
    //     }
    // }


    public function saveQcResults(Request $request)
    {
        try {
            // Validasi - PERBAIKAN DI SINI
            $validator = Validator::make($request->all(), [
                'results' => 'required|array',
                'results.*.qc_id' => 'required|exists:quality_controls,id',
                'results.*.parameter' => 'required|string',
                'results.*.test_date' => 'required|date',
                'results.*.result' => 'required|numeric',
                'results.*.flag' => 'required|string',
                'results.*.d1' => 'nullable|numeric',
                'results.*.d2' => 'nullable|numeric',
                'results.*.d3' => 'nullable|numeric',
                'results.*.d4' => 'nullable|numeric',
                'results.*.d5' => 'nullable|numeric',
                'results.*.notes' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $savedCount = 0;
            $savedResults = [];

            DB::beginTransaction();

            foreach ($request->results as $resultData) {
                $existingResult = QCResult::where('qc_id', $resultData['qc_id'])
                    ->where('parameter', $resultData['parameter'])
                    ->where('test_date', $resultData['test_date'])
                    ->first();

                if ($existingResult) {
                    // Update existing
                    $existingResult->update([
                        'd1' => $resultData['d1'] ?? null,
                        'd2' => $resultData['d2'] ?? null,
                        'd3' => $resultData['d3'] ?? null,
                        'd4' => $resultData['d4'] ?? null,
                        'd5' => $resultData['d5'] ?? null,
                        'result' => $resultData['result'],
                        'flag' => $resultData['flag'],
                        'notes' => $resultData['notes'] ?? null
                    ]);
                    $result = $existingResult;
                } else {
                    // Create new
                    $result = QCResult::create([
                        'qc_id' => $resultData['qc_id'],
                        'parameter' => $resultData['parameter'],
                        'test_date' => $resultData['test_date'],
                        'd1' => $resultData['d1'] ?? null,
                        'd2' => $resultData['d2'] ?? null,
                        'd3' => $resultData['d3'] ?? null,
                        'd4' => $resultData['d4'] ?? null,
                        'd5' => $resultData['d5'] ?? null,
                        'result' => $resultData['result'],
                        'flag' => $resultData['flag'],
                        'notes' => $resultData['notes'] ?? null
                    ]);
                }

                $savedResults[] = [
                    'parameter' => $result->parameter,
                    'result' => $result->result,
                    'duplo' => array_filter([
                        $result->d1,
                        $result->d2,
                        $result->d3,
                        $result->d4,
                        $result->d5
                    ], function ($value) {
                        return !is_null($value);
                    })
                ];

                $savedCount++;
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Successfully saved {$savedCount} QC results",
                'saved_count' => $savedCount,
                'results' => $savedResults
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error saving QC results: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ambil department sesuai id
        $departments = Department::findOrFail($id);

        // Filter QC berdasarkan department yang dipilih
        $qcs = QC::with('department')
            ->where('department_id', $id)
            ->get();

        // Ambil parameter untuk department ini jika ada
        // $parameters = Parameter::where('department_id', $id)->get();

        return view('analyst.qc-edit', compact('departments', 'qcs'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
        ]);

        $qc = Qc::findOrFail($id);
        $qc->update([
            'department_id' => $request->department_id,
        ]);

        toast('QC berhasil diupdate!', 'success');
        return redirect()->route('Qc.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // Di AnalystController atau QCController
    public function getQCLevels(Request $request)
    {
        $departmentId = $request->get('department_id');

        $levels = QC::where('department_id', $departmentId)
            ->distinct()
            ->pluck('level')
            ->filter()
            ->values();

        return response()->json([
            'success' => true,
            'levels' => $levels
        ]);
    }

    public function getQCByLevel($level, Request $request)
    {
        $departmentId = $request->get('department_id');

        $qcs = QC::where('level', $level)
            ->where('department_id', $departmentId)
            ->select('id', 'no_lot', 'name_control', 'level')
            ->get();

        return response()->json([
            'success' => true,
            'qcs' => $qcs
        ]);
    }

    // API untuk mendapatkan detail QC beserta parameter dan hasil
    public function getQcDetails($qcId)
    {
        try {
            $qc = Qc::findOrFail($qcId);

            $parameters = DetailLot::where('quality_control_id', $qcId)
                ->select('parameter', 'mean', 'range', 'bts_atas', 'bts_bawah', 'standart')
                ->get();

            $results = QcResult::where('qc_id', $qcId)
                ->select('parameter', 'result', 'd1', 'd2', 'd3', 'd4', 'd5', 'flag', 'test_date')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'qc' => $qc,
                'parameters' => $parameters,
                'results' => $results
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching QC details: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getDetailQc(Request $request, $qcId)
    {
        try {
            // Ambil QC beserta department
            $qc = Qc::with('department')->findOrFail($qcId);

            // Cari order di obrs yang cocok dengan name_control
            $order = obr::where('order_number', $qc->name_control)->first();

            if (!$order) {
                return response()->json([
                    'status' => 'fail',
                    'msg' => 'Order number tidak ditemukan untuk QC ini',
                    'data' => null
                ]);
            }

            // Ambil semua obx berdasarkan message_control_id
            $obxes = obx::where('message_control_id', $order->message_control_id)->get();

            // Susun response
            $response = [
                'qc' => $qc,
                'order' => $order,
                'results' => $obxes
            ];

            return response()->json([
                'status' => 'success',
                'msg' => 'Data QC ditemukan',
                'data' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'msg' => 'Failed to fetch QC Data',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function getQcUnified($qcId)
    {
        try {
            // Ambil QC beserta department
            $qc = Qc::with('department')->findOrFail($qcId);

            // Cek apakah ada order dari alat (pakai obrs)
            $order = obr::where('order_number', $qc->name_control)->first();

            if ($order) {
                // 🔹 Data dari alat (obx)
                $obxes = obx::where('message_control_id', $order->message_control_id)->get();

                return response()->json([
                    'status' => 'success',
                    'msg'    => 'Data QC dari alat ditemukan',
                    'data'   => [
                        'qc'      => $qc,
                        'order'   => $order,
                        'results' => $obxes,
                        'source'  => 'alat'
                    ]
                ]);
            } else {
                // 🔹 Data manual
                $parameters = DetailLot::where('quality_control_id', $qcId)
                    ->select('parameter', 'mean', 'range', 'bts_atas', 'bts_bawah', 'standart')
                    ->get();

                $results = QcResult::where('qc_id', $qcId)
                    ->select('parameter', 'result', 'test_date', 'flag')
                    ->orderBy('test_date', 'desc')
                    ->get()
                    ->map(function ($result) {
                        // Konversi ke format tanggal saja tanpa timezone
                        if ($result->test_date) {
                            $result->test_date_original = $result->test_date;
                            // Ambil tanggal saja, abaikan waktu dan timezone
                            $result->test_date = \Carbon\Carbon::parse($result->test_date)->format('Y-m-d');
                        }
                        return $result;
                    });

                return response()->json([
                    'status'     => 'success',
                    'msg'        => 'Data QC manual ditemukan',
                    'data'       => [
                        'qc'         => $qc,
                        'parameters' => $parameters,
                        'results'    => $results,
                        'source'     => 'manual'
                    ]
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'msg'    => 'Failed to fetch QC Data',
                'error'  => $e->getMessage()
            ]);
        }
    }

    public function getParameters($qcId)
    {
        try {
            $parameters = DetailLot::where('quality_control_id', $qcId)
                ->select('parameter', 'mean', 'range', 'bts_atas', 'bts_bawah', 'standart')
                ->get();

            return response()->json([
                'status' => 'success',
                'data'   => $parameters
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'msg'    => 'Gagal mengambil parameter',
                'error'  => $e->getMessage()
            ], 500);
        }
    }





    // API untuk menyimpan hasil QC
    // public function saveQcResult(Request $request)
    // {
    //     $validated = $request->validate([
    //         'qc_id' => 'required|exists:quality_controls,id',
    //         'parameter' => 'required|string',
    //         'test_date' => 'required|date',
    //         'd1' => 'nullable|numeric',
    //         'd2' => 'nullable|numeric',
    //         'd3' => 'nullable|numeric',
    //         'd4' => 'nullable|numeric',
    //         'd5' => 'nullable|numeric',
    //         'result' => 'required|numeric',
    //         'flag' => 'required|string'
    //     ]);

    //     try {
    //         DB::beginTransaction();

    //         // Update atau create hasil QC
    //         QcResult::updateOrCreate(
    //             [
    //                 'qc_id' => $validated['qc_id'],
    //                 'parameter' => $validated['parameter'],
    //                 'test_date' => $validated['test_date']
    //             ],
    //             [
    //                 'd1' => $validated['d1'],
    //                 'd2' => $validated['d2'],
    //                 'd3' => $validated['d3'],
    //                 'd4' => $validated['d4'],
    //                 'd5' => $validated['d5'],
    //                 'result' => $validated['result'],
    //                 'flag' => $validated['flag'],
    //                 'user_id' => auth()->id()
    //             ]
    //         );

    //         DB::commit();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'QC result saved successfully'
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error saving QC result: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    // API untuk mendapatkan data chart
    public function getChartData($qcId, $parameter)
    {
        try {
            $results = QcResult::where('qc_id', $qcId)
                ->where('parameter', $parameter)
                ->orderBy('test_date', 'asc')
                ->select('result', 'test_date', 'flag')
                ->get();

            $labels = $results->map(function ($result) {
                return Carbon::parse($result->test_date)->format('M d');
            });

            $values = $results->pluck('result');

            return response()->json([
                'success' => true,
                'labels' => $labels,
                'values' => $values,
                'flags' => $results->pluck('flag')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching chart data: ' . $e->getMessage()
            ], 500);
        }
    }

    // API untuk mendapatkan history QC
    public function getQcHistory(Request $request)
    {
        try {
            $query = QcResult::with('qc')
                ->select('qc_id', 'parameter', 'result', 'flag', 'test_date', 'created_at');

            // Filter berdasarkan tanggal jika ada
            if ($request->has('start_date') && $request->has('end_date')) {
                $query->whereBetween('test_date', [$request->start_date, $request->end_date]);
            }

            // Filter berdasarkan parameter jika ada
            if ($request->has('parameter')) {
                $query->where('parameter', $request->parameter);
            }

            // Filter berdasarkan QC ID jika ada
            if ($request->has('qc_id')) {
                $query->where('qc_id', $request->qc_id);
            }

            $results = $query->orderBy('test_date', 'desc')
                ->paginate(50);

            return response()->json([
                'success' => true,
                'data' => $results
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching QC history: ' . $e->getMessage()
            ], 500);
        }
    }

    // API untuk export data QC
    public function exportQcData(Request $request)
    {
        try {
            $qcId = $request->qc_id;
            $parameter = $request->parameter;

            $qc = Qc::findOrFail($qcId);

            $query = QcResult::where('qc_id', $qcId);

            if ($parameter) {
                $query->where('parameter', $parameter);
            }

            $results = $query->orderBy('test_date', 'asc')->get();

            return response()->json([
                'success' => true,
                'qc_info' => $qc,
                'results' => $results
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error exporting QC data: ' . $e->getMessage()
            ], 500);
        }
    }

    // In your QC Controller, add this method:
    public function getControlLimits($qcId, $parameter)
    {
        try {
            // Debug: Log the incoming parameters
            Log::info("Getting control limits for QC ID: {$qcId}, Parameter: {$parameter}");

            // First, check if the QC record exists
            $qc = Qc::find($qcId);
            if (!$qc) {
                Log::error("QC record not found for ID: {$qcId}");
                return response()->json(['success' => false, 'message' => 'QC record not found']);
            }

            // Try to find control limits in detail_lots table
            $controlLimit = DB::table('detail_lots')
                ->where('quality_control_id', $qcId)
                ->where('parameter', $parameter)
                ->first();

            Log::info("Control limit query result:", ['result' => $controlLimit]);

            if ($controlLimit) {
                // Check if all required fields exist and are not null
                $limits = [
                    'mean' => $controlLimit->mean ?? 0,
                    'range' => $controlLimit->range ?? 1,
                    'standard' => $controlLimit->standart ?? $controlLimit->standard ?? 0, // Handle both column names
                    'bts_atas' => $controlLimit->bts_atas ?? ($controlLimit->mean ?? 0) + (($controlLimit->range ?? 1) * 3),
                    'bts_bawah' => $controlLimit->bts_bawah ?? ($controlLimit->mean ?? 0) - (($controlLimit->range ?? 1) * 3)
                ];

                Log::info("Processed limits:", $limits);

                return response()->json([
                    'success' => true,
                    'limits' => $limits
                ]);
            }

            // If no control limits found, return default values based on data
            Log::warning("No control limits found, generating defaults");

            // Try to calculate from existing test results
            $testResults = DB::table('test_results')
                ->where('quality_control_id', $qcId)
                ->where('parameter', $parameter)
                ->whereNotNull('hasil')
                ->pluck('hasil');

            if ($testResults->count() > 0) {
                $values = $testResults->map(function ($value) {
                    return is_numeric($value) ? floatval($value) : 0;
                })->filter();

                if ($values->count() > 0) {
                    $mean = $values->avg();
                    $std = $values->count() > 1 ? sqrt($values->map(function ($x) use ($mean) {
                        return pow($x - $mean, 2);
                    })->avg()) : 1;

                    $limits = [
                        'mean' => $mean,
                        'range' => $std,
                        'standard' => $mean,
                        'bts_atas' => $mean + ($std * 3),
                        'bts_bawah' => $mean - ($std * 3)
                    ];

                    Log::info("Calculated limits from data:", $limits);

                    return response()->json([
                        'success' => true,
                        'limits' => $limits
                    ]);
                }
            }

            // Last resort: return sensible defaults
            $defaultLimits = [
                'mean' => 5.0,
                'range' => 1.0,
                'standard' => 5.0,
                'bts_atas' => 8.0,
                'bts_bawah' => 2.0
            ];

            Log::info("Using default limits:", $defaultLimits);

            return response()->json([
                'success' => true,
                'limits' => $defaultLimits
            ]);
        } catch (Exception $e) {
            Log::error("Error in getControlLimits: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'debug_info' => [
                    'qc_id' => $qcId,
                    'parameter' => $parameter,
                    'line' => $e->getLine(),
                    'file' => $e->getFile()
                ]
            ]);
        }
    }
}
