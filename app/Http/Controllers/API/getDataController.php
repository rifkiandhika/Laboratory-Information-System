<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\pasien;
use Exception;
use Illuminate\Http\Request;

class getDataController extends Controller
{
    public function getData($lab)
    {
        try {
            // $data_pasien = pasien::with('dokter')->findOrFail($id);
            $no_lab = pasien::where('id', $lab)->value('no_lab');
            // $data_pasien = pasien::where('id', $lab)->with(['data_pemeriksaan_pasien.data_departement', 'data_pemeriksaan_pasien.data_pemeriksaan', 'dokter'])->first();
            $no_lab = pasien::where('id', $lab)->value('no_lab');
            $data_pasien = pasien::where('id', $lab)->with(['dpp.pasiens' => function ($query) use ($no_lab) {
                $query->where('no_lab', $no_lab);
                $query->with('pemeriksaan');
            }, 'department', 'dokter', 'poli', 'spesiment'])->first();
            return $data_pasien;
            return response()->json(['status' => 'success', 'msg' => 'ok', 'data' => $data_pasien]);
        } catch (Exception $e) {

            return response()->json(['status' => 'fail', 'msg' => 'Failed to fetch Data']);
        }
    }
}
