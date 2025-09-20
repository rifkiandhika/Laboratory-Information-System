<?php

namespace App\Http\Controllers;

use App\Jobs\SendHasilToLis;
use App\Models\HasilPemeriksaan;
use App\Models\pasien;
use Illuminate\Http\Request;

class HasilController extends Controller
{
    public function syncFromExternal(Request $request)
    {
        $validated = $request->validate([
            'no_lab' => 'required|string',
            'hasil' => 'required|array',
            'hasil.*.nama_pemeriksaan' => 'required|string', // ganti id_parameter jadi nama_pemeriksaan
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
                    'nama_pemeriksaan' => $h['nama_pemeriksaan'], // pakai nama pemeriksaan
                ],
                [
                    'hasil' => $h['hasil'] ?? null,
                    'flag' => $h['flag'] ?? null,
                    'satuan' => $h['satuan'] ?? null,
                    'range' => $h['nilai_rujukan'] ?? null, // mapping ke kolom "range"
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

    public function kirimHasil($no_lab)
    {
        $pasien = pasien::with('hasil_pemeriksaan')->where('no_lab', $no_lab)->firstOrFail();

        $payload = [
            'no_lab' => $pasien->no_lab,
            'hasil' => $pasien->hasil_pemeriksaan->map(function ($h) {
                return [
                    'nama_pemeriksaan' => $h->nama_pemeriksaan,
                    'hasil' => $h->hasil,
                    'flag' => $h->flag,
                    'satuan' => $h->satuan,
                    'nilai_rujukan' => $h->range,
                    'tanggal_selesai' => $h->tanggal_selesai,
                    'catatan' => $h->note,
                ];
            })->toArray()
        ];

        SendHasilToLis::dispatch($payload);

        return back()->with('success', 'Hasil berhasil dikirim ke LIS.');
    }
}
