<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ApiController extends Controller
{
    /**
     * Handle Quality Control (QC) request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function qc(Request $request)
    {
        try {
            // Validasi data MSH yang masuk
            $validated = $request->validate([
                'sender' => 'required|string',
                'sender_facility' => 'required|string',
                'sender_timestamp' => 'required|string',
                'message_type' => 'required|string',
                'message_control_id' => 'required|string',
                'processing_id' => 'required|string',
            ]);

            // Simpan data MSH ke database
            $mshId = DB::table('mshes')->insertGetId([
                'sender' => $validated['sender'],
                'sender_facility' => $validated['sender_facility'],
                'sender_timestamp' => $validated['sender_timestamp'],
                'message_type' => $validated['message_type'],
                'message_control_id' => $validated['message_control_id'],
                'processing_id' => $validated['processing_id'],
                'type' => 'QC',
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

    /**
     * Handle Kunjungan Pemeriksaan request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function kunjunganPemeriksaan(Request $request)
    {
        try {
            // Cek tipe data yang masuk (MSH atau OBR)
            if ($request->has('message_control_id') && $request->has('order_number')) {
                // Ini adalah data OBR
                return $this->handleObrData($request);
            } else {
                // Ini adalah data MSH
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

    /**
     * Handle OBR data
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

        // Cari kunjungan berdasarkan message_control_id
        $kunjungan = DB::table('obrs')
            ->where('message_control_id', $validated['message_control_id'])
            ->first();

        if (!$kunjungan) {
            // Jika belum ada, buat baru
            $kunjunganId = DB::table('obrs')->insertGetId([
                'message_control_id' => $validated['message_control_id'],
                'order_number' => $validated['order_number'],
                'requested_time' => $validated['requested_time'] ?? null,
                'examination_time' => $validated['examination_time'] ?? null,
                'collector' => $validated['collector'] ?? null,
                'result_time' => $validated['result_time'] ?? null,
                'service_segment' => $validated['service_segment'] ?? null,
                'examiner' => $validated['examiner'] ?? null,
                'device' => $validated['device'] ?? null,
                'status' => 'pending',
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
            // Jika sudah ada, update
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
                    'device' => $validated['device'] ?? $kunjungan->device,
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

    /**
     * Handle MSH data
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

        // Simpan data MSH ke database
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

        // Buat entri kunjungan_pemeriksaan dengan status awal
        $kunjunganId = DB::table('obrs')->insertGetId([
            'message_control_id' => $validated['message_control_id'],
            // 'status' => 'received',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data MSH Pemeriksaan berhasil disimpan',
            'data' => [
                'msh_id' => $mshId,
                'kunjungan_id' => $kunjunganId,
                'message_control_id' => $validated['message_control_id']
            ]
        ], 201);
    }

    /**
     * Handle Kunjungan Pemeriksaan Hasil request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function kunjunganPemeriksaanHasil(Request $request)
    {
        try {
            // Validasi data OBX yang masuk
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

            // Cek apakah kunjungan tersebut ada
            $kunjungan = DB::table('obxes')
                ->where('message_control_id', $validated['message_control_id'])
                ->first();

            if (!$kunjungan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kunjungan pemeriksaan tidak ditemukan'
                ], 404);
            }

            // Cek apakah hasil sudah ada
            $hasil = DB::table('obxes')
                ->where('kunjungan_id', $kunjungan->id)
                ->where('identifier_id', $validated['identifier_id'])
                ->first();

            if (!$hasil) {
                // Jika belum ada, buat baru
                $hasilId = DB::table('obxes')->insertGetId([
                    'kunjungan_id' => $kunjungan->id,
                    'message_control_id' => $validated['message_control_id'],
                    'identifier_id' => $validated['identifier_id'],
                    'identifier_name' => $validated['identifier_name'],
                    'identifier_encode' => $validated['identifier_encode'],
                    'identifier_value' => $validated['identifier_value'] ?? null,
                    'identifier_unit' => $validated['identifier_unit'] ?? null,
                    'identifier_range' => $validated['identifier_range'] ?? null,
                    'identifier_flags' => $validated['identifier_flags'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Update status kunjungan menjadi 'has_result'
                DB::table('obrs')
                    ->where('id', $kunjungan->id)
                    ->update([
                        'status' => 'has_result',
                        'updated_at' => now(),
                    ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Data hasil pemeriksaan berhasil disimpan',
                    'data' => [
                        'id' => $hasilId,
                        'kunjungan_id' => $kunjungan->id,
                        'message_control_id' => $validated['message_control_id']
                    ]
                ], 201);
            } else {
                // Jika sudah ada, update
                DB::table('obxes')
                    ->where('id', $hasil->id)
                    ->update([
                        'identifier_name' => $validated['identifier_name'],
                        'identifier_encode' => $validated['identifier_encode'],
                        'identifier_value' => $validated['identifier_value'] ?? $hasil->identifier_value,
                        'identifier_unit' => $validated['identifier_unit'] ?? $hasil->identifier_unit,
                        'identifier_range' => $validated['identifier_range'] ?? $hasil->identifier_range,
                        'identifier_flags' => $validated['identifier_flags'] ?? $hasil->identifier_flags,
                        'updated_at' => now(),
                    ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Data hasil pemeriksaan berhasil diupdate',
                    'data' => [
                        'id' => $hasil->id,
                        'kunjungan_id' => $kunjungan->id,
                        'message_control_id' => $validated['message_control_id']
                    ]
                ], 200);
            }
        } catch (\Exception $e) {
            Log::error('Kunjungan Pemeriksaan Hasil API Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data hasil kunjungan pemeriksaan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function checkData(Request $request)
    {
        // Ambil message_control_id dari query parameter jika ada
        $messageControlId = $request->query('message_control_id');

        $data = [];

        if ($messageControlId) {
            // Jika ada message_control_id, ambil data spesifik
            $data['message_header'] = DB::table('mshes')
                ->where('message_control_id', $messageControlId)
                ->first();

            $data['kunjungan'] = DB::table('obrs')
                ->where('message_control_id', $messageControlId)
                ->first();

            if ($data['kunjungan']) {
                $data['hasil'] = DB::table('obxes')
                    ->where('kunjungan_id', $data['kunjungan']->id)
                    ->get();
            }
        } else {
            // Jika tidak ada message_control_id, ambil data terbaru
            $data['recent_headers'] = DB::table('mshes')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            $data['recent_kunjungan'] = DB::table('obrs')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            $data['recent_hasil'] = DB::table('obxes')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
