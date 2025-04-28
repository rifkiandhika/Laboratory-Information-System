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
        try {
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
        } catch (\Exception $e) {
            Log::error('QC API Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data QC',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function kunjunganPemeriksaan(Request $request)
    {
        try {
            if ($request->has('message_control_id') && $request->has('order_number')) {
                return $this->handleObrData($request);
            } else {
                return $this->handleMshData($request);
            }
        } catch (\Exception $e) {
            Log::error('Kunjungan Pemeriksaan API Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data kunjungan pemeriksaan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function handleObrData(Request $request)
    {
        $validated = $request->validate([
            'message_control_id' => 'required|string',
            'order_number' => 'required|string',
            'requested_time' => 'nullable|string',
            'examination_time' => 'nullable|string',
            'collector' => 'nullable|string',
            'result_time' => 'nullable|string',
            'service_segment' => 'nullable|string',
            'examiner' => 'nullable|string',
            'device' => 'nullable|string',
        ]);

        $kunjungan = DB::table('obrs')
            ->where('message_control_id', $validated['message_control_id'])
            ->first();

        if (!$kunjungan) {
            $kunjunganId = DB::table('obrs')->insertGetId([
                'message_control_id' => $validated['message_control_id'],
                'order_number' => $validated['order_number'],
                'requested_time' => $validated['requested_time'],
                'examination_time' => $validated['examination_time'],
                'collector' => $validated['collector'],
                'result_time' => $validated['result_time'],
                'service_segment' => $validated['service_segment'],
                'examiner' => $validated['examiner'],
                // 'device' => $validated['device'],
                // 'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data OBR berhasil disimpan',
                'data' => [
                    'id' => $kunjunganId,
                    'message_control_id' => $validated['message_control_id']
                ]
            ], 201);
        } else {
            DB::table('obrs')
                ->where('id', $kunjungan->id)
                ->update([
                    'order_number' => $validated['order_number'],
                    'requested_time' => $validated['requested_time'] ?? $kunjungan->requested_time,
                    'examination_time' => $validated['examination_time'] ?? $kunjungan->examination_time,
                    'collector' => $validated['collector'] ?? $kunjungan->collector,
                    'result_time' => $validated['result_time'] ?? $kunjungan->result_time,
                    'service_segment' => $validated['service_segment'] ?? $kunjungan->service_segment,
                    'examiner' => $validated['examiner'] ?? $kunjungan->examiner,
                    // 'device' => $validated['device'] ?? $kunjungan->device,
                    'updated_at' => now(),
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Data OBR berhasil diupdate',
                'data' => [
                    'id' => $kunjungan->id,
                    'message_control_id' => $validated['message_control_id']
                ]
            ], 200);
        }
    }

    private function handleMshData(Request $request)
    {
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
            'type' => 'PEMERIKSAAN',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $kunjunganId = DB::table('obrs')->insertGetId([
            'message_control_id' => $validated['message_control_id'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data MSH Pemeriksaan berhasil disimpan',
            'data' => [
                'msh_id' => $mshId,
                'id' => $kunjunganId,
                'message_control_id' => $validated['message_control_id']
            ]
        ], 201);
    }

    public function kunjunganPemeriksaanHasil(Request $request)
    {
        try {
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

            $obr = DB::table('obrs')
                ->where('message_control_id', $validated['message_control_id'])
                ->first();

            if (!$obr) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kunjungan pemeriksaan tidak ditemukan'
                ], 404);
            }

            $existing = DB::table('obxes')
                ->where('id', $obr->id)
                ->where('identifier_id', $validated['identifier_id'])
                ->first();

            if (!$existing) {
                $hasilId = DB::table('obxes')->insertGetId([
                    'id' => $obr->id,
                    'message_control_id' => $validated['message_control_id'],
                    'identifier_id' => $validated['identifier_id'],
                    'identifier_name' => $validated['identifier_name'],
                    'identifier_encode' => $validated['identifier_encode'],
                    'identifier_value' => $validated['identifier_value'],
                    'identifier_unit' => $validated['identifier_unit'],
                    'identifier_range' => $validated['identifier_range'],
                    'identifier_flags' => $validated['identifier_flags'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('obxes')
                    ->where('id', $existing->id)
                    ->update([
                        'identifier_value' => $validated['identifier_value'],
                        'identifier_unit' => $validated['identifier_unit'],
                        'identifier_range' => $validated['identifier_range'],
                        'identifier_flags' => $validated['identifier_flags'],
                        'updated_at' => now(),
                    ]);
            }

            DB::table('obrs')
                ->where('id', $obr->id)
                ->update([
                    'status' => 'has_result',
                    'updated_at' => now(),
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Data hasil kunjungan pemeriksaan berhasil disimpan atau diperbarui'
            ], 201);
        } catch (\Exception $e) {
            Log::error('OBX API Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data hasil pemeriksaan',
                'error' => $e->getMessage()
            ], 500);
        }
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
