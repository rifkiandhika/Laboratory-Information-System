<?php

namespace App\Http\Controllers\analyst;

use App\Http\Controllers\Controller;
use App\Models\DetailLot;
use App\Models\Qc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LotController extends Controller
{
    public function storeComplete(Request $request)
    {
        // Log data yang diterima untuk debugging
        Log::info('Data yang diterima:', $request->all());

        try {
            // Validasi data
            $validated = $request->validate([
                'lot.no_lot' => 'required|string|unique:quality_controls,no_lot',
                'lot.name_control' => 'required|string',
                'lot.level' => 'required|in:Low,Normal,High',
                'lot.exp_date' => 'required|date',
                'lot.use_qc' => 'nullable|date',
                'lot.last_qc' => 'nullable|date',
                'parameters' => 'required|array',
                'department_id' => 'required|exists:departments,id',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation errors:', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Simpan ke tabel quality_controls
            $qc = Qc::create([
                'no_lot' => $validated['lot']['no_lot'],
                'name_control' => $validated['lot']['name_control'],
                'level' => strtolower($validated['lot']['level']),
                'exp_date' => $validated['lot']['exp_date'],
                'use_qc' => $validated['lot']['use_qc'] ?? null,
                'last_qc' => $validated['lot']['last_qc'] ?? null,
                'department_id' => $validated['department_id'],
            ]);

            Log::info('QC created with ID:', ['id' => $qc->id]);

            // Simpan ke tabel detail_lots
            foreach ($validated['parameters'] as $paramName => $fields) {
                DetailLot::create([
                    'quality_control_id' => $qc->id,
                    'parameter' => $paramName,
                    'mean' => $fields['mean'] ?? 0,
                    'range' => $fields['range'] ?? 0,
                    'bts_atas' => $fields['bts_ats'] ?? 0,
                    'bts_bawah' => $fields['bts_bwh'] ?? 0,
                    'standart' => $fields['standart'] ?? 0,
                ]);
            }

            DB::commit();

            Log::info('Data berhasil disimpan');

            return response()->json([
                'success' => true,
                'message' => 'Data Quality Control berhasil disimpan',
                'data' => $qc->load('detailLots')
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error saat menyimpan data:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Update existing complete LOT data (LOT + Parameters)
     */
    public function updateComplete(Request $request, $id)
    {
        // Log data yang diterima untuk debugging
        Log::info('Update data yang diterima:', $request->all());

        try {
            // Find existing LOT
            $qc = Qc::findOrFail($id);

            // Validasi data (tanpa unique constraint untuk no_lot jika sama)
            $validated = $request->validate([
                'lot.no_lot' => 'required|string|unique:quality_controls,no_lot,' . $id,
                'lot.name_control' => 'required|string',
                'lot.level' => 'required|in:Low,Normal,High',
                'lot.exp_date' => 'required|date',
                'lot.use_qc' => 'nullable|date',
                'lot.last_qc' => 'nullable|date',
                'parameters' => 'required|array',
                'department_id' => 'required|exists:departments,id',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation errors:', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Update data LOT
            $qc->update([
                'no_lot' => $validated['lot']['no_lot'],
                'name_control' => $validated['lot']['name_control'],
                'level' => strtolower($validated['lot']['level']),
                'exp_date' => $validated['lot']['exp_date'],
                'use_qc' => $validated['lot']['use_qc'] ?? null,
                'last_qc' => $validated['lot']['last_qc'] ?? null,
                'department_id' => $validated['department_id'],
            ]);

            Log::info('QC updated with ID:', ['id' => $qc->id]);

            // Hapus parameter lama
            DetailLot::where('quality_control_id', $qc->id)->delete();

            // Simpan parameter baru
            foreach ($validated['parameters'] as $paramName => $fields) {
                DetailLot::create([
                    'quality_control_id' => $qc->id,
                    'parameter' => $paramName,
                    'mean' => $fields['mean'] ?? 0,
                    'range' => $fields['range'] ?? 0,
                    'bts_atas' => $fields['bts_ats'] ?? 0,
                    'bts_bawah' => $fields['bts_bwh'] ?? 0,
                    'standart' => $fields['standart'] ?? 0,
                ]);
            }

            DB::commit();

            Log::info('Data berhasil diupdate');

            return response()->json([
                'success' => true,
                'message' => 'Data Quality Control berhasil diupdate',
                'data' => $qc->load('detailLots')
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error saat update data:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal update data: ' . $e->getMessage(),
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get LOTs by department for dropdown
     */
    public function getLotsByDepartment($departmentId)
    {
        try {
            $lots = Qc::where('department_id', $departmentId)
                ->select('id', 'no_lot', 'name_control', 'level')
                ->orderBy('no_lot')
                ->get();

            // Format level untuk display
            $lots = $lots->map(function ($lot) {
                return [
                    'id' => $lot->id,
                    'no_lot' => $lot->no_lot,
                    'name_control' => $lot->name_control,
                    'level' => ucfirst($lot->level) // Kapitalisasi level
                ];
            });

            return response()->json($lots);
        } catch (\Throwable $e) {
            Log::error('Error getting lots by department:', [
                'message' => $e->getMessage(),
                'department_id' => $departmentId
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data LOT'
            ], 500);
        }
    }

    /**
     * Get LOT detail with parameters for editing
     */
    public function getLotDetail($id)
    {
        try {
            $qc = Qc::with(['detailLots', 'department'])
                ->findOrFail($id);

            // Format data untuk frontend
            $lotData = [
                'id' => $qc->id,
                'no_lot' => $qc->no_lot,
                'name_control' => $qc->name_control,
                'level' => ucfirst($qc->level),
                'exp_date' => $qc->exp_date,
                'use_qc' => $qc->use_qc,
                'last_qc' => $qc->last_qc,
                'department_id' => $qc->department_id,
                'department_name' => $qc->department->nama_department ?? 'Unknown'
            ];

            $parameters = $qc->detailLots->map(function ($detail) {
                return [
                    'parameter' => $detail->parameter,
                    'mean' => $detail->mean,
                    'range' => $detail->range,
                    'bts_atas' => $detail->bts_atas,
                    'bts_bawah' => $detail->bts_bawah,
                    'standart' => $detail->standart
                ];
            })->toArray();

            return response()->json([
                'success' => true,
                'lot' => $lotData,
                'parameters' => $parameters
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'LOT tidak ditemukan'
            ], 404);
        } catch (\Throwable $e) {
            Log::error('Error getting lot detail:', [
                'message' => $e->getMessage(),
                'lot_id' => $id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat detail LOT'
            ], 500);
        }
    }

    /**
     * Delete LOT and its parameters
     */
    public function deleteLot($id)
    {
        try {
            DB::beginTransaction();

            $qc = Qc::findOrFail($id);

            // Hapus semua parameter terkait
            DetailLot::where('quality_control_id', $qc->id)->delete();

            // Hapus LOT
            $qc->delete();

            DB::commit();

            Log::info('LOT deleted successfully:', ['id' => $id]);

            return response()->json([
                'success' => true,
                'message' => 'LOT berhasil dihapus'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'LOT tidak ditemukan'
            ], 404);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error deleting LOT:', [
                'message' => $e->getMessage(),
                'lot_id' => $id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus LOT'
            ], 500);
        }
    }

    /**
     * Get all LOTs with pagination for listing
     */
    public function getAllLots(Request $request)
    {
        try {
            $query = Qc::with(['department', 'detailLots']);

            // Filter by department if provided
            if ($request->has('department_id') && $request->department_id != '') {
                $query->where('department_id', $request->department_id);
            }

            // Search by no_lot or name_control
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('no_lot', 'like', "%{$search}%")
                        ->orWhere('name_control', 'like', "%{$search}%");
                });
            }

            $lots = $query->orderBy('created_at', 'desc')
                ->paginate(10);

            return response()->json([
                'success' => true,
                'data' => $lots
            ]);
        } catch (\Throwable $e) {
            Log::error('Error getting all lots:', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data LOT'
            ], 500);
        }
    }

    /**
     * Export LOT data to Excel/PDF (optional feature)
     */
    public function exportLot($id, $format = 'excel')
    {
        try {
            $qc = Qc::with(['detailLots', 'department'])
                ->findOrFail($id);

            // Here you can implement export logic using libraries like:
            // - PhpSpreadsheet for Excel
            // - DomPDF or TCPDF for PDF
            // - Or any other export library

            return response()->json([
                'success' => true,
                'message' => 'Export feature will be implemented here',
                'data' => $qc
            ]);
        } catch (\Throwable $e) {
            Log::error('Error exporting LOT:', [
                'message' => $e->getMessage(),
                'lot_id' => $id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal export data LOT'
            ], 500);
        }
    }
}
