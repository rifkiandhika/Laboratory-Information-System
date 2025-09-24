<?php

namespace App\Http\Controllers;

use App\Jobs\SendHasilToLis;
use App\Models\HasilPemeriksaan;
use App\Models\pasien;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HasilController extends Controller
{
    public function syncFromExternal(Request $request)
    {
        $validated = $request->validate([
            'pasien' => 'required|array',
            'hasil'  => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            // ===== 1. Simpan / update pasien =====
            $data_pasien = $validated['pasien'];

            $pasien = pasien::updateOrCreate(
                ['no_lab' => $data_pasien['no_lab']],
                [
                    'no_rm'           => $data_pasien['no_rm'] ?? null,
                    'nama'            => $data_pasien['nama'],
                    'nik'             => $data_pasien['nik'] ?? null,
                    'lahir'           => $data_pasien['lahir'],
                    'jenis_kelamin'   => $data_pasien['jenis_kelamin'],
                    'alamat'          => $data_pasien['alamat'] ?? null,
                    'no_telp'         => $data_pasien['no_telp'] ?? null,
                    'asal_ruangan'    => $data_pasien['asal_ruangan'] ?? null,
                    'jenis_pelayanan' => $data_pasien['jenis_pelayanan'] ?? null,
                    'kode_dokter' => $data_pasien['kode_dokter'] ?? null,
                    'dokter_external' => $data_pasien['dokter_external'] ?? null,
                    'tanggal_masuk'   => $data_pasien['tanggal_masuk'] ?? now(),
                    'status'          => $data_pasien['status'] ?? 'Result Review',
                ]
            );

            // ===== 2. Simpan hasil pemeriksaan =====
            foreach ($validated['hasil'] as $h) {
                HasilPemeriksaan::updateOrCreate(
                    [
                        'no_lab'           => $h['no_lab'],
                        'nama_pemeriksaan' => $h['nama_pemeriksaan'],
                    ],
                    [
                        'no_rm'        => $h['no_rm'] ?? null,
                        'nama'         => $h['nama'] ?? null,
                        'ruangan'      => $h['ruangan'] ?? null,
                        'nama_dokter'  => $h['nama_dokter'] ?? null,
                        'department'   => $h['department'] ?? null,
                        'judul'        => $h['judul'] ?? null,
                        'hasil'        => $h['hasil'] ?? null,
                        'note'         => $h['note'] ?? null,
                        'kesimpulan'   => $h['kesimpulan'] ?? null,
                        'saran'        => $h['saran'] ?? null,
                        'duplo_dx'     => $h['duplo_dx'] ?? null,
                        'duplo_d1'     => $h['duplo_d1'] ?? null,
                        'duplo_d2'     => $h['duplo_d2'] ?? null,
                        'duplo_d3'     => $h['duplo_d3'] ?? null,
                        'flag'         => $h['flag'] ?? null,
                        'satuan'       => $h['satuan'] ?? null,
                        'range'        => $h['range'] ?? null,
                        'tanggal_selesai' => $h['tanggal_selesai'] ?? now(),
                    ]
                );
            }


            DB::commit();

            return response()->json([
                'success' => true,
                'message' => '✅ Data pasien & hasil berhasil diterima dan disimpan.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => '❌ Terjadi kesalahan saat menyimpan data.',
                'error'   => $e->getMessage(),
            ], 500);
        }
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
        $pasien = pasien::with(['hasil_pemeriksaan', 'dokter'])
            ->where('no_lab', $no_lab)
            ->firstOrFail();

        // === Data pasien ===
        $data_pasien = [
            'no_lab'          => $pasien->no_lab,
            'no_rm'           => $pasien->no_rm,
            'nama'            => $pasien->nama,
            'nik'             => $pasien->nik,
            'lahir'           => $pasien->lahir,
            'umur'            => \Carbon\Carbon::parse($pasien->lahir)->age,
            'jenis_kelamin'   => $pasien->jenis_kelamin,
            'alamat'          => $pasien->alamat,
            'no_telp'         => $pasien->no_telp,
            'asal_ruangan'    => $pasien->asal_ruangan,
            'jenis_pelayanan' => $pasien->jenis_pelayanan,
            'kode_dokter'     => $pasien->kode_dokter,
            'dokter_external' => $pasien->dokter_external,
            'tanggal_masuk'   => $pasien->tanggal_masuk,
            'status'          => $pasien->status,
        ];

        // === Data hasil pemeriksaan ===
        $data_hasil = $pasien->hasil_pemeriksaan->map(function ($h) {
            return [
                'no_lab'          => $h->no_lab,
                'no_rm'           => $h->no_rm,
                'nama'            => $h->nama,
                'ruangan'         => $h->ruangan,
                'nama_dokter'     => $h->nama_dokter,
                'department'      => $h->department,
                'judul'           => $h->judul,
                'nama_pemeriksaan' => $h->nama_pemeriksaan,
                'hasil'           => $h->hasil,
                'note'            => $h->note,
                'kesimpulan'      => $h->kesimpulan,
                'saran'           => $h->saran,
                'duplo_dx'        => $h->duplo_dx,
                'duplo_d1'        => $h->duplo_d1,
                'duplo_d2'        => $h->duplo_d2,
                'duplo_d3'        => $h->duplo_d3,
                'flag'            => $h->flag,
                'satuan'          => $h->satuan,
                'range'           => $h->range,
                'tanggal_selesai' => $h->tanggal_selesai,
            ];
        })->toArray();

        // === Gabungkan payload ===
        $payload = [
            'pasien' => $data_pasien,
            'hasil'  => $data_hasil,
        ];

        // Kirim via queue
        // SendHasilToLis::dispatch($payload);

        return back()->with('success', '✅ Data pasien & semua hasil berhasil dikirim ke LIS.');
    }
}
