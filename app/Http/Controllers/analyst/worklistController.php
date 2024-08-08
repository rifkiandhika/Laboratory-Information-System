<?php

namespace App\Http\Controllers\analyst;

use App\Models\obx;
use App\Models\pasien;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HasilPemeriksaan;
use App\Models\historyPasien;
use App\Models\msh;
use App\Models\obr;
use App\Models\pembayaran;
use App\Models\pemeriksaan_pasien;
use App\Models\spesimentCollection;
use App\Models\spesimentHandling;
use App\Models\Worklist;
use Illuminate\Support\Facades\Log;

class worklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataPasien = pasien::where(function ($query) {
            $query->where('status', 'Check in spesiment');
        })
            ->where('cito', 0)
            ->get();

        $dataPasienCito = pasien::where(function ($query) {
            $query->where('status', 'Check in spesiment');
        })
            ->where('cito', 1)
            ->get();

        return view('analyst.worklist', compact('dataPasien', 'dataPasienCito'));
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
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'no_lab' => 'required',
            'no_rm' => 'required',
            'nama' => 'required',
            'ruangan' => 'required',
            'nama_dokter' => 'required',
            'nama_pemeriksaan.*' => 'required',
            'hasil.*' => 'required',
            'range.*' => 'nullable',
            'satuan.*' => 'nullable',
        ]);

        $no_lab = $request->input('no_lab');
        $no_rm = $request->input('no_rm');
        $nama = $request->input('nama');
        $ruangan = $request->input('ruangan');
        $nama_dokter = $request->input('nama_dokter');
        $nama_pemeriksaan = $request->input('nama_pemeriksaan');
        $hasils = $request->input('hasil');
        $ranges = $request->input('range', []);
        $satuans = $request->input('satuan', []);

        if (count($nama_pemeriksaan) !== count($hasils)) {
            return redirect()->back()->withErrors(['message' => 'Data tidak valid']);
        }

        foreach ($nama_pemeriksaan as $x => $pemeriksaan) {
            HasilPemeriksaan::create([
                'no_lab' => $no_lab,
                'no_rm' => $no_rm,
                'nama' => $nama,
                'ruangan' => $ruangan,
                'nama_dokter' => $nama_dokter,
                'nama_pemeriksaan' => $pemeriksaan,
                'hasil' => $hasils[$x],
                'range' => $ranges[$x] ?? null,
                'satuan' => $satuans[$x] ?? null,
            ]);
        }
        toast('Data berhasil di verifikasi', 'success');
        return redirect()->route('worklist.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function checkin($id)
    {
        // Validasi dan pembaruan status
        $pasien = pasien::find($id);

        // Update status pasien
        $pasien->update(['status' => 'Verifikasi Dokter']);

        historyPasien::create([
            'no_lab' => $pasien->no_lab,
            'proses' => 'Verifikasi Dokter',
            'tempat' => 'Laboratorium',
            'waktu_proses' => now(),
            'created_at' => now(),
        ]);

        toast('Data telah dikirim untuk diverifikasi', 'success');
        return redirect()->route('worklist.index');
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
        $worklist = pasien::findOrFail($id);
        $no_lab = $worklist->no_lab;
        pemeriksaan_pasien::where('no_lab', $no_lab)->delete();
        historyPasien::where('no_lab', $no_lab)->delete();
        spesimentCollection::where('no_lab', $no_lab)->delete();
        spesimentHandling::where('no_lab', $no_lab)->delete();
        pembayaran::where('no_lab', $no_lab)->delete();
        $worklist->delete();

        toast('Data berhasi di Hapus!', 'success');
        return redirect()->route('worklist.index');
    }



    public function tampilPemeriksaan($lab)
    {
        $nolab = null;
        $nolab = $lab;
        $data = pasien::all();
        return response()->json($nolab);
    }

    public function storemsh(Request $request)
    {
        $message_type = '';
        for ($i = 0; $i < count($request->message_type); $i++) {
            if ($i > 0) {
                $message_type .= ',';
            }
            $message_type .= $request->message_type[$i][0];
        }

        $msh = msh::create([
            'sender' => $request->sender,
            'sender_facility' => $request->sender_facility,
            'sender_timestamp' => $request->sender_timestamp,
            'message_type' => $message_type,
            'message_control_id' => $request->message_control_id,
            'processing_id' => $request->processing_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'LIS created',
            'data' => $msh
        ], 201);
    }

    public function storeobr(Request $request)
    {
        $data = $request->all();
        $obr = obr::create($data);

        return response()->json([
            'success' => true,
            'message' => 'OBR created',
            'data' => $obr
        ], 201);
    }

    public function storeobx(Request $request)
    {
        if (is_array($request->identifier_unit)) {
            $identifier_unit = '';
            for ($i = 0; $i < count($request->identifier_unit); $i++) {
                if ($i > 0) {
                    $identifier_unit .= ',';
                }
                $identifier_unit .= $request->identifier_unit[$i][0];
            }
            $data = [
                'message_control_id' => $request->message_control_id,
                'identifier_id' => $request->identifier_id,
                'identifier_name' => $request->identifier_name,
                'identifier_encode' => $request->identifier_encode,
                'identifier_value' => $request->identifier_value,
                'identifier_unit' => $identifier_unit,
                'identifier_range' => $request->identifier_range,
                'identifier_flags' => $request->identifier_flags,
            ];
        } else {
            $data = $request->all();
        }
        $obx = obx::create($data);

        return response()->json([
            'success' => true,
            'message' => 'OBX created',
            'data' => $obx
        ], 201);
    }
}
