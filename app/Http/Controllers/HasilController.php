<?php

namespace App\Http\Controllers;

use App\Jobs\SendHasilToLis;
use App\Models\HasilPemeriksaan;
use App\Models\historyPasien;
use App\Models\pasien;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

    public function kirimHasil($lab)
    {
        try {
            // 1. Ambil data hasil dari API local (domain A)
            $response = Http::get(url("/api/get-hasil/{$lab}"));

            if (!$response->successful()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mengambil data dari API lokal'
                ], 500);
            }

            $dataHasil = $response->json();

            // 2. Kirim semua data ke server tujuan (domain B)
            $targetUrl = "https://lis.erecord.id/api/store-hasil"; // sesuaikan endpoint
            $send = Http::post($targetUrl, [
                'lab' => $lab,
                'data' => $dataHasil
            ]);

            if ($send->successful()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data hasil berhasil dikirim',
                    'response' => $send->json()
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengirim data ke server tujuan',
                'response' => $send->body()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function storeHasil(Request $request)
    {
        $data = $request->all();

        // 1. Simpan data pasien
        $pasien = Pasien::updateOrCreate(
            ['no_lab' => $data['no_lab']], // key unik
            [
                'no_rm'          => $data['no_rm'] ?? null,
                'cito'           => $data['cito'] ?? 0,
                'nik'            => $data['nik'] ?? null,
                'jenis_pelayanan' => $data['jenis_pelayanan'] ?? null,
                'nama'           => $data['nama'],
                'lahir'          => $data['lahir'],
                'jenis_kelamin'  => $data['jenis_kelamin'],
                'no_telp'        => $data['no_telp'],
                'diagnosa'       => $data['diagnosa'] ?? null,
                'alamat'         => $data['alamat'] ?? null,
                'kode_dokter'    => $data['kode_dokter'] ?? null,
                'dokter_external' => $data['dokter_external'] ?? null,
                'asal_ruangan'   => $data['asal_ruangan'] ?? null,
                'status'         => $data['status'] ?? 'Belum Dilayani',
                'tanggal_masuk'  => $data['tanggal_masuk'] ?? now(),
                'tanggal'        => $data['tanggal'] ?? null,
            ]
        );

        // 2. Simpan history pasien
        if (!empty($data['history'])) {
            foreach ($data['history'] as $h) {
                historyPasien::updateOrCreate(
                    [
                        'id'    => $h['id'] ?? null, // kalau ada id unik
                        'no_lab' => $data['no_lab']
                    ],
                    [
                        'proses'       => $h['proses'],
                        'tempat'       => $h['tempat'],
                        'waktu_proses' => $h['waktu_proses'],
                        'note'         => $h['note'] ?? null,
                    ]
                );
            }
        }

        // 3. Simpan hasil pemeriksaan
        if (!empty($data['hasil_pemeriksaan'])) {
            foreach ($data['hasil_pemeriksaan'] as $hasil) {
                HasilPemeriksaan::updateOrCreate(
                    [
                        'id'     => $hasil['id'] ?? null, // kalau ada id unik
                        'no_lab' => $data['no_lab'],
                        'nama_pemeriksaan' => $hasil['nama_pemeriksaan'],
                    ],
                    [
                        'no_rm'        => $data['no_rm'] ?? null,
                        'nama'         => $data['nama'],
                        'ruangan'      => $data['asal_ruangan'] ?? null,
                        'nama_dokter'  => $data['dokter_external'] ?? null,
                        'department'   => $hasil['department'] ?? null,
                        'judul'        => $hasil['judul'] ?? null,
                        'hasil'        => $hasil['hasil'] ?? null,
                        'note'         => $hasil['note'] ?? null,
                        'kesimpulan'   => $hasil['kesimpulan'] ?? null,
                        'saran'        => $hasil['saran'] ?? null,
                        'duplo_dx'     => $hasil['duplo_dx'] ?? null,
                        'duplo_d1'     => $hasil['duplo_d1'] ?? null,
                        'duplo_d2'     => $hasil['duplo_d2'] ?? null,
                        'duplo_d3'     => $hasil['duplo_d3'] ?? null,
                        'flag'         => $hasil['flag'] ?? null,
                        'satuan'       => $hasil['satuan'] ?? null,
                        'range'        => $hasil['range'] ?? null,
                    ]
                );
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Data pasien, history, dan hasil berhasil disimpan'
        ]);
    }
}
