<?php

namespace App\Http\Controllers;

use App\Models\msh;
use App\Models\obr;
use App\Models\obx;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function qc(Request $request)
    {
        $data = $request->validate([
            'sender' => 'required|string',
            'sender_facility' => 'required|string',
            'sender_timestamp' => 'required|string',
            'message_type' => 'required|string',
            'message_control_id' => 'required|string|unique:qc,message_control_id',
            'processing_id' => 'required|string',
        ]);

        $qc = msh::create([
            'sender' => $data['sender'],
            'sender_facility' => $data['sender_facility'],
            'sender_timestamp' => $data['sender_timestamp'],
            'message_type' => $data['message_type'],
            'message_control_id' => $data['message_control_id'],
            'processing_id' => $data['processing_id'],
        ]);

        return response()->json(['message' => 'MSH berhasil disimpan', 'data' => $qc], 201);
    }


    public function kunjunganPemeriksaan(Request $request)
    {
        $dataList = $request->all();

        if (array_keys($dataList) !== range(0, count($dataList) - 1)) {
            // Single OBR entry (not array)
            $dataList = [$dataList];
        }

        $saved = [];

        foreach ($dataList as $data) {
            $validated = Validator::make($data, [
                'message_control_id' => 'required|exists:qc,message_control_id',
                'order_number' => 'required|string',
                'requested_time' => 'nullable|string',
                'examination_time' => 'nullable|string',
                'collector' => 'nullable|string',
                'result_time' => 'nullable|string',
                'service_segment' => 'nullable|string',
                'examiner' => 'nullable|string'
            ])->validate();

            $saved[] = obr::create($validated);
        }

        return response()->json(['message' => 'Data OBR berhasil disimpan', 'data' => $saved], 201);
    }


    public function kunjunganPemeriksaanHasil(Request $request)
    {
        $dataList = $request->all();

        if (array_keys($dataList) !== range(0, count($dataList) - 1)) {
            // Single OBX entry (not array)
            $dataList = [$dataList];
        }

        $saved = [];

        foreach ($dataList as $data) {
            $validated = Validator::make($data, [
                'message_control_id' => 'required|exists:qc,message_control_id',
                'identifier_id' => 'required|string',
                'identifier_name' => 'nullable|string',
                'identifier_encode' => 'nullable|string',
                'identifier_value' => 'required|string',
                'identifier_unit' => 'nullable|string',
                'identifier_range' => 'nullable|string',
                'identifier_flags' => 'nullable|string',
            ])->validate();

            $saved[] = obx::create($validated);
        }

        return response()->json(['message' => 'Data OBX berhasil disimpan', 'data' => $saved], 201);
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
