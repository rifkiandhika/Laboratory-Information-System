<?php

namespace App\Http\Controllers\analyst;

use App\Http\Controllers\Controller;
use App\Models\HasilPemeriksaan;
use App\Models\historyPasien;
use App\Models\pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class vDokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $dataPasien = pasien::where(function ($query) {
        //     $query->where('status', 'Verifikasi Dokter');
        // })->get();

        $dataPasien = pasien::where('status', 'Verifikasi Dokter')->orderBy('cito', 'desc')->paginate(20);

        $verifikasi = pasien::where('status', 'Diverifikasi Ulang')->orderBy('cito', 'desc')->paginate(20);

        return view('analyst.main-dokter', compact('dataPasien', 'verifikasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function back(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|string|max:255',
        ]);

        $pasien = pasien::find($id);

        // Update status pasien
        $pasien->update(['status' => 'Dikembalikan']);

        historyPasien::create([
            'no_lab' => $pasien->no_lab,
            'proses' => 'Dikembalikan oleh dokter',
            'tempat' => 'Laboratorium',
            'note' => $request->input('note'),
            'waktu_proses' => now(),
            'created_at' => now(),
        ]);

        toast('Data telah dikembalikan untuk dicek kembali', 'success');
        return redirect()->route('vdokter.index');
    }

    public function sentToReview(Request $request, $id)
    {
        // Validasi basic
        // dd($request->all());
        $request->validate([
            'no_lab' => 'required',
            'parameter_name.*' => 'nullable',
            'nama_pemeriksaan.*' => 'nullable',
            'hasil.*' => 'nullable',
            'note' => 'nullable',
        ]);

        $no_lab = $request->input('no_lab');
        $parameter_names = $request->input('parameter_name', []);
        $nama_pemeriksaan = $request->input('nama_pemeriksaan', []);

        // DEBUG - Uncomment untuk cek data
        // dd([
        //     'parameter_names' => $parameter_names,
        //     'nama_pemeriksaan' => $nama_pemeriksaan,
        //     'hasil' => $request->input('hasil'),
        // ]);

        // Cek apakah ada data Hapusan Darah
        $hasHapusanDarah = false;
        if (!empty($nama_pemeriksaan)) {
            foreach ($nama_pemeriksaan as $pemeriksaan) {
                if (stripos($pemeriksaan, 'hapusan darah') !== false) {
                    $hasHapusanDarah = true;
                    break;
                }
            }
        }

        // Jika ada Hapusan Darah, simpan datanya
        if ($hasHapusanDarah && !empty($parameter_names)) {
            $request->validate([
                'no_rm' => 'required',
                'nama' => 'required',
                'ruangan' => 'required',
                'nama_dokter' => 'required',
                'parameter_name.*' => 'required',
                'nama_pemeriksaan.*' => 'required',
                'hasil.*' => 'required|string',
                'satuan.*' => 'nullable',
                'metode.*' => 'nullable',
                'department.*' => 'required',
                'judul.*' => 'nullable',
            ]);

            $no_rm = $request->input('no_rm');
            $nama = $request->input('nama');
            $ruangan = $request->input('ruangan');
            $nama_dokter = $request->input('nama_dokter');
            $hasils = $request->input('hasil', []);
            $nilai_rujukan = $request->input('nilai_rujukan', []);
            $satuans = $request->input('satuan', []);
            $metodes = $request->input('metode', []);
            $judul = $request->input('judul', []);
            $departments = $request->input('department', []);
            $note = $request->input('note');

            $savedCount = 0;
            $errorCount = 0;

            // Simpan/Update data Hapusan Darah
            // Karena sekarang hanya Hapusan Darah yang dikirim, index sudah match
            foreach ($parameter_names as $index => $parameter_name) {
                if (empty($parameter_name)) continue;

                try {
                    // Cari existing data
                    $existingHasil = HasilPemeriksaan::where('no_lab', $no_lab)
                        ->where('nama_pemeriksaan', $parameter_name)
                        ->first();

                    $data = [
                        'no_lab' => $no_lab,
                        'no_rm' => $no_rm,
                        'nama' => $nama,
                        'ruangan' => $ruangan,
                        'nama_dokter' => $nama_dokter,
                        'nama_pemeriksaan' => $parameter_name,
                        'hasil' => $hasils[$index] ?? '',
                        'duplo_d1' => null,
                        'duplo_d2' => null,
                        'duplo_d3' => null,
                        'range' => $nilai_rujukan[$index] ?? null,
                        'satuan' => $satuans[$index] ?? null,
                        'metode' => $metodes[$index] ?? null,
                        'flag' => null,
                        'judul' => $judul[$index] ?? null,
                        'department' => $departments[$index] ?? null,
                        'note' => $note ?? null,
                    ];

                    if ($existingHasil) {
                        $existingHasil->update($data);
                    } else {
                        HasilPemeriksaan::create($data);
                    }

                    $savedCount++;
                } catch (\Exception $e) {
                    $errorCount++;
                    Log::error("Failed to save Hapusan Darah parameter {$parameter_name}: " . $e->getMessage());
                }
            }

            // Notifikasi
            if ($savedCount > 0) {
                if ($errorCount > 0) {
                    toast("Data Hapusan Darah berhasil disimpan ({$savedCount} parameter), tapi ada {$errorCount} error", 'warning');
                } else {
                    toast("Data Hapusan Darah berhasil disimpan ({$savedCount} parameter)", 'success');
                }
            } else {
                toast("Tidak ada data Hapusan Darah yang berhasil disimpan", 'error');
                return redirect()->back();
            }
        }

        // Update status pasien
        $data_pasien = Pasien::findOrFail($id);
        $data_pasien->update(['status' => 'Result Review']);

        // Catat history
        HistoryPasien::create([
            'no_lab' => $data_pasien->no_lab,
            'proses' => $hasHapusanDarah ? 'Diverifikasi Oleh Dokter - Hapusan Darah' : 'Diverifikasi Oleh Dokter',
            'tempat' => 'Laboratorium',
            'note' => $request->input('note') ?? null,
            'waktu_proses' => now(),
            'created_at' => now(),
        ]);

        // Notifikasi untuk kasus tanpa Hapusan Darah
        if (!$hasHapusanDarah) {
            toast('Data berhasil diverifikasi', 'success');
        }

        return redirect()->route('vdokter.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }
}
