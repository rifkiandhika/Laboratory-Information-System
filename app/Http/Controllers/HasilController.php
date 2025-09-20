<?php

namespace App\Http\Controllers;

use App\Jobs\SendHasilToLis;
use App\Models\HasilPemeriksaan;
use App\Models\pasien;
use Exception;
use Illuminate\Http\Request;

class HasilController extends Controller
{
    public function syncFromExternal(Request $request)
    {
        $validated = $request->validate([
            'no_lab' => 'required|string',
            'hasil' => 'required|array',
            'hasil.*.nama_pemeriksaan' => 'required|string',
            'hasil.*.hasil' => 'nullable|string',
            'hasil.*.flag' => 'nullable|string',
            'hasil.*.satuan' => 'nullable|string',
            'hasil.*.nilai_rujukan' => 'nullable|string',
            'hasil.*.tanggal_selesai' => 'nullable|date',
            'hasil.*.catatan' => 'nullable|string',
        ]);

        foreach ($validated['hasil'] as $h) {
            HasilPemeriksaan::updateOrCreate(
                [
                    'no_lab' => $validated['no_lab'],
                    'nama_pemeriksaan' => $h['nama_pemeriksaan'],
                ],
                [
                    'hasil' => $h['hasil'] ?? null,
                    'flag' => $h['flag'] ?? null,
                    'satuan' => $h['satuan'] ?? null,
                    'range' => $h['nilai_rujukan'] ?? null,
                    'tanggal_selesai' => $h['tanggal_selesai'] ?? null,
                    'note' => $h['catatan'] ?? null,
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Hasil pemeriksaan berhasil diterima dan disimpan'
        ]);
    }

    public function getDataHasil(Request $request, $lab)
    {
        try {
            // $data_pasien = pasien::with('dokter')->findOrFail($id);
            // $no_lab = pasien::where('id', $lab)->value('no_lab');
            // $data_pasien = pasien::where('id', $lab)->with(['data_pemeriksaan_pasien.data_departement', 'data_pemeriksaan_pasien.data_pemeriksaan', 'dokter'])->first();
            $no_lab = pasien::where('no_lab', $lab)->value('no_lab');
            $data_pasien = pasien::where('no_lab', $lab)->with([
                'dpp.pasiens' => function ($query) use ($no_lab) {
                    $query->where('no_lab', $no_lab);
                    $query->with('data_pemeriksaan');
                },
                'dpp',
                'history',
                'spesiment.details',
                'spesimentcollection',
                'spesimenthandling.details',
                'hasil_pemeriksaan',
                // 'obx'
            ])->first();

            $data_pasien->obrs = $data_pasien->obrs;

            if ($data_pasien && $data_pasien->spesimentcollection) {
                foreach ($data_pasien->spesimentcollection as $spesimen) {
                    // Ambil details berdasarkan kapasitas atau serumh
                    $spesimen->details = $spesimen->getDetailsByCriteria();
                }
            }

            return response()->json(['status' => 'success', 'msg' => 'ok', 'data' => $data_pasien]);
        } catch (Exception $e) {

            return response()->json(['status' => 'fail', 'msg' => 'Failed to fetch Data']);
        }
    }

    public function kirimHasil($no_lab)
    {
        $pasien = Pasien::with(['hasil_pemeriksaan', 'dokter'])->where('no_lab', $no_lab)->firstOrFail();

        // Buat data pasien
        $data_pasien = [
            'no_lab'        => $pasien->no_lab,
            'no_rm'         => $pasien->no_rm,
            'nama'          => $pasien->nama,
            'nik'           => $pasien->nik,
            'lahir'         => $pasien->lahir,
            'umur'          => \Carbon\Carbon::parse($pasien->lahir)->age,
            'jenis_kelamin' => $pasien->jenis_kelamin,
            'alamat'        => $pasien->alamat,
            'no_telp'       => $pasien->no_telp,
            'asal_ruangan'  => $pasien->asal_ruangan,
            'jenis_pelayanan' => $pasien->jenis_pelayanan,
            'dokter_internal' => $pasien->dokter?->nama_dokter,
            'dokter_external' => $pasien->dokter_external,
            'tanggal_masuk' => $pasien->tanggal_masuk,
            'status'        => $pasien->status,
        ];

        // Buat data hasil pemeriksaan
        $data_hasil = $pasien->hasil_pemeriksaan->map(function ($h) {
            return [
                'id_parameter'   => $h->id_parameter,
                'nama_pemeriksaan' => $h->nama_pemeriksaan,
                'hasil'          => $h->hasil,
                'flag'           => $h->flag,
                'satuan'         => $h->satuan,
                'nilai_rujukan'  => $h->range,
                'tanggal_selesai' => $h->tanggal_selesai,
                'catatan'        => $h->note,
            ];
        })->toArray();

        // Gabungkan jadi payload
        $payload = [
            'pasien' => $data_pasien,
            'hasil'  => $data_hasil,
        ];

        // Dispatch job ke LIS
        SendHasilToLis::dispatch($payload);

        // Update status pasien di Muslimat
        $pasien->update(['status' => 'Result Review']);

        return back()->with('success', 'Data pasien & hasil berhasil dikirim ke LIS.');
    }
}
