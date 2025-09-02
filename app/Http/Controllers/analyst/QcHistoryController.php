<?php

namespace App\Http\Controllers\analyst;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\QC;
use App\Models\QcResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QcHistoryController extends Controller
{
    public function index()
    {
        return view('analyst.qc.history');
    }

    // API untuk mendapatkan daftar departments
    public function getDepartments()
    {
        try {
            $departments = Department::select('id', 'nama_department')->get();

            return response()->json([
                'success' => true,
                'departments' => $departments
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading departments: ' . $e->getMessage()
            ], 500);
        }
    }

    // API untuk mendapatkan info department tertentu
    public function getDepartment($id)
    {
        try {
            $department = Department::findOrFail($id);

            return response()->json([
                'success' => true,
                'department' => $department
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Department not found'
            ], 404);
        }
    }

    // API untuk mendapatkan QC history berdasarkan lot dan tanggal
    public function getQcHistory($lotId, Request $request)
    {
        try {
            $testDate = $request->get('test_date');

            if (!$testDate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Test date is required'
                ], 400);
            }

            // Ambil data QC results berdasarkan lot dan tanggal
            $results = QcResult::where('qc_id', $lotId)
                ->whereDate('test_date', $testDate)
                ->orderBy('parameter')
                ->orderBy('created_at', 'desc')
                ->get();

            // Group by parameter dan ambil yang terbaru untuk setiap parameter
            $groupedResults = $results->groupBy('parameter')->map(function ($parameterResults) {
                return $parameterResults->first(); // Ambil yang terbaru
            });

            return response()->json([
                'success' => true,
                'results' => $groupedResults->values(),
                'total' => $groupedResults->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading history data: ' . $e->getMessage()
            ], 500);
        }
    }

    // API untuk mendapatkan chart data history (untuk trend sepanjang waktu)
    public function getChartDataHistory($qcId, $parameter)
    {
        try {
            // Ambil data QC results untuk parameter tertentu dalam 30 hari terakhir
            $results = QcResult::where('qc_id', $qcId)
                ->where('parameter', $parameter)
                ->where('test_date', '>=', now()->subDays(30))
                ->whereNotNull('result')
                ->orderBy('test_date')
                ->get();

            $labels = [];
            $values = [];

            foreach ($results as $result) {
                $labels[] = $result->test_date->format('d/m/Y');
                $values[] = floatval($result->result);
            }

            return response()->json([
                'success' => true,
                'labels' => $labels,
                'values' => $values,
                'parameter' => $parameter
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading chart data: ' . $e->getMessage()
            ], 500);
        }
    }

    // API untuk mendapatkan semua tanggal yang tersedia untuk lot tertentu
    public function getAvailableDates($lotId)
    {
        try {
            $dates = QcResult::where('qc_id', $lotId)
                ->select(DB::raw('DATE(test_date) as date'))
                ->distinct()
                ->orderBy('date', 'desc')
                ->pluck('date');

            return response()->json([
                'success' => true,
                'dates' => $dates
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading available dates: ' . $e->getMessage()
            ], 500);
        }
    }

    // API untuk mendapatkan statistik history
    public function getHistoryStatistics($lotId, $parameter)
    {
        try {
            $stats = QcResult::where('qc_id', $lotId)
                ->where('parameter', $parameter)
                ->whereNotNull('result')
                ->select([
                    DB::raw('COUNT(*) as total_tests'),
                    DB::raw('AVG(result) as average'),
                    DB::raw('MIN(result) as minimum'),
                    DB::raw('MAX(result) as maximum'),
                    DB::raw('STDDEV(result) as std_deviation')
                ])
                ->first();

            return response()->json([
                'success' => true,
                'statistics' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading statistics: ' . $e->getMessage()
            ], 500);
        }
    }
}
