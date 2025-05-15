<?php

namespace App\Http\Controllers;

use App\Models\msh;
use App\Models\obr;
use App\Models\obx;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ApiController extends Controller
{
    public function qc(Request $request)
    {
        $x_data_type = $request->header('X_DATA_TYPE');

        if ($x_data_type == 'MSH') {
            $validated = $request->validate([
                'sender' => 'required|string',
                'sender_facility' => 'required|string',
                'sender_timestamp' => 'required|string',
                'message_type' => 'required|string',
                'message_control_id' => 'required|string',
                'processing_id' => 'required|string',
            ]);

            $mshId = DB::table('mshes')->insertGetId([
                'sender' => $validated['sender'],
                'sender_facility' => $validated['sender_facility'],
                'sender_timestamp' => $validated['sender_timestamp'],
                'message_type' => $validated['message_type'],
                'message_control_id' => $validated['message_control_id'],
                'processing_id' => $validated['processing_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data QC berhasil disimpan',
                'data' => [
                    'id' => $mshId,
                    'message_control_id' => $validated['message_control_id']
                ]
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Header X_DATA_TYPE tidak dikenali'
        ], 400);
    }

    public function kunjunganPemeriksaan(Request $request)
    {
        $x_data_type = $request->header('X_DATA_TYPE');

        if ($x_data_type == 'OBR') {
            $validated = $request->validate([
                'message_control_id' => 'required|string',
                'order_number' => 'required|string',
                'requested_time' => 'nullable|string',
                'examination_time' => 'nullable|string',
                'collector' => 'nullable|string',
                'result_time' => 'nullable|string',
                'service_segment' => 'nullable|string',
                'examiner' => 'nullable|string'
            ]);

            $obrId = DB::table('obrs')->insertGetId([
                'message_control_id' => $validated['message_control_id'],
                'order_number' => $validated['order_number'],
                'requested_time' => $validated['requested_time'],
                'examination_time' => $validated['examination_time'],
                'collector' => $validated['collector'],
                'result_time' => $validated['result_time'],
                'service_segment' => $validated['service_segment'],
                'examiner' => $validated['examiner'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data kunjungan pemeriksaan berhasil disimpan',
                'data' => ['id' => $obrId]
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Header X_DATA_TYPE tidak dikenali'
        ], 400);
    }

    public function kunjunganPemeriksaanHasil(Request $request)
    {
        $x_data_type = $request->header('X_DATA_TYPE');

        if ($x_data_type == 'OBX') {
            $validated = $request->validate([
                'message_control_id' => 'required|string',
                'identifier_id' => 'required|string',
                'identifier_name' => 'required|string',
                'identifier_encode' => 'required|string',
                'identifier_value' => 'nullable|string',
                'identifier_unit' => 'nullable|string',
                'identifier_range' => 'nullable|string',
                'identifier_flags' => 'nullable|string',
            ]);

            // Cek apakah message_control_id ini sudah pernah masuk
            $existing = DB::table('obxes')
                ->where('message_control_id', $validated['message_control_id'])
                ->exists();

            // Jika belum pernah, anggap sebagai batch baru
            if (!$existing) {
                $totalBatch = DB::table('obxes')
                    ->select('message_control_id')
                    ->distinct()
                    ->count();

                $status = match ($totalBatch % 3) {
                    0 => 'rendah',
                    1 => 'normal',
                    2 => 'tinggi',
                };
            } else {
                // Jika sudah ada, ambil status dari salah satu entri yang sudah tersimpan
                $status = DB::table('obxes')
                    ->where('message_control_id', $validated['message_control_id'])
                    ->value('status');
            }

            $obxId = DB::table('obxes')->insertGetId([
                'message_control_id' => $validated['message_control_id'],
                'identifier_id' => $validated['identifier_id'],
                'identifier_name' => $validated['identifier_name'],
                'identifier_encode' => $validated['identifier_encode'],
                'identifier_value' => $validated['identifier_value'],
                'identifier_unit' => $validated['identifier_unit'],
                'identifier_range' => $validated['identifier_range'],
                'identifier_flags' => $validated['identifier_flags'],
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data hasil pemeriksaan berhasil disimpan',
                'data' => ['id' => $obxId, 'status' => $status]
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Header X_DATA_TYPE tidak dikenali'
        ], 400);
    }



    public function checkData()
    {
        try {
            $qcData = msh::latest()->take(10)->get();
            $kunjunganData = obr::latest()->take(10)->get();
            $hasilData = obx::latest()->take(10)->get();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengambil data terakhir',
                'qc' => $qcData,
                'kunjungan_pemeriksaan' => $kunjunganData,
                'hasil_kunjungan_pemeriksaan' => $hasilData,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil data: ' . $e->getMessage()
            ], 500);
        }
    }
}
