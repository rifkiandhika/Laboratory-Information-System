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
use App\Models\Report;
use App\Models\spesimentCollection;
use App\Models\spesimentHandling;
use App\Models\Worklist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class worklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataPasienCito = pasien::where('status', 'Check in spesiment')->orderBy('cito', 'desc')->paginate(20);
        $verifikasi = pasien::where('status', 'Verifikasi')->orderBy('cito', 'desc')->paginate(20);

        // $dataPasien = pasien::where(function ($query) {
        //     $query->where('status', 'Check in spesiment');
        // })
        //     ->where('cito', 0)
        //     ->get();

        // $dataPasienCito = pasien::where(function ($query) {
        //     $query->where('status', 'Check in spesiment');
        // })
        //     ->where('cito', 1)
        //     ->get();

        $dikembalikan = pasien::where('status', 'Dikembalikan')->orderBy('cito', 'desc')->paginate(20);
        // $dikembalikan = pasien::where(function ($query) {
        //     $query->where('status', 'Dikembalikan');
        // })->get();

        return view('analyst.worklist', compact('dataPasienCito', 'dikembalikan', 'verifikasi'));
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
        // DEBUGGING - Uncomment untuk debug
        // dd($request->all());

        // Validasi input - DIPERBAIKI
        $request->validate([
            'no_lab' => 'required',
            'no_rm' => 'required',
            'nama' => 'required',
            'ruangan' => 'required',
            'nama_dokter' => 'required',
            'parameter_name.*' => 'required',
            'nama_pemeriksaan.*' => 'required',
            'hasil.*' => 'nullable',
            'duplo_d1.*' => 'nullable',
            'duplo_d2.*' => 'nullable',
            'duplo_d3.*' => 'nullable',
            'nilai_rujukan.*' => 'nullable',
            'satuan.*' => 'nullable',
            'metode.*' => 'nullable',
            'department.*' => 'required',
            'flag' => 'nullable',
            'flag.*' => 'nullable',
            'judul.*' => 'nullable',
            'note' => 'nullable',
        ]);


        // Ambil data dari request
        $no_lab = $request->input('no_lab');
        $no_rm = $request->input('no_rm');
        $nama = $request->input('nama');
        $ruangan = $request->input('ruangan');
        $nama_dokter = $request->input('nama_dokter');

        // PERBAIKAN: Ambil semua array data
        $parameter_names = $request->input('parameter_name', []); // Ini yang di JS: parameter_name[]
        $nama_pemeriksaan = $request->input('nama_pemeriksaan', []); // Ini grup pemeriksaan (Hematologi, Urine, dll)
        $hasils = $request->input('hasil', []);
        $d1 = $request->input('duplo_d1', []);
        $d2 = $request->input('duplo_d2', []);
        $d3 = $request->input('duplo_d3', []);
        $nilai_rujukan = $request->input('nilai_rujukan', []);
        $satuans = $request->input('satuan', []);
        $metodes = $request->input('metode', []);
        $judul = $request->input('judul', []);
        $flags = $request->input('flag', []);
        $departments = $request->input('department', []);
        $note = $request->input('note'); // Note adalah string, bukan array

        // Debug detail parameter urine
        $urineParams = [];
        foreach ($parameter_names as $idx => $param) {
            if (in_array($param, [
                'Warna',
                'Kekeruhan',
                'Berat Jenis',
                'PH',
                'Leukosit',
                'Nitrit',
                'Protein',
                'Glukosa',
                'Keton',
                'Urobilinogen',
                'Bilirubin',
                'Blood',
                'Eritrosit',
                'Leukosit_sedimen',
                'Epithel',
                'Silinder',
                'Kristal',
                'Bakteri',
                'Jamur',
                'Lain-lain'
            ])) {
                $urineParams[] = "{$idx}: {$param} = " . ($hasils[$idx] ?? 'NULL');
            }
        }
        // Validasi panjang data
        $expectedLength = count($parameter_names);
        if (
            count($nama_pemeriksaan) !== $expectedLength ||
            count($hasils) !== $expectedLength ||
            count($departments) !== $expectedLength
        ) {

            // \Log::error('Array length mismatch:', [
            //     'parameter_names' => count($parameter_names),
            //     'nama_pemeriksaan' => count($nama_pemeriksaan),
            //     'hasils' => count($hasils),
            //     'departments' => count($departments)
            // ]);

            return redirect()->back()->withErrors(['message' => 'Data tidak valid - panjang array tidak sama']);
        }

        $savedCount = 0;
        $errorCount = 0;

        // PERBAIKAN: Loop berdasarkan index parameter_names
        foreach ($parameter_names as $index => $parameter_name) {

            // Skip jika parameter kosong
            if (empty($parameter_name)) {
                // \Log::warning("Skipping empty parameter at index {$index}");
                continue;
            }

            try {
                // PERBAIKAN: Cek existing berdasarkan no_lab DAN parameter_name
                // Karena parameter_name di DB sebenarnya diisi dari nama_pemeriksaan JavaScript
                $existingHasil = HasilPemeriksaan::where('no_lab', $no_lab)
                    ->where('nama_pemeriksaan', $parameter_name) // Gunakan parameter_name dari JS sebagai nama_pemeriksaan
                    ->first();

                // Data yang akan disimpan/diupdate
                $data = [
                    'no_lab' => $no_lab,
                    'no_rm' => $no_rm,
                    'nama' => $nama,
                    'ruangan' => $ruangan,
                    'nama_dokter' => $nama_dokter,
                    'nama_pemeriksaan' => $parameter_name, // parameter_name dari JS masuk ke nama_pemeriksaan DB
                    'hasil' => $hasils[$index] ?? '',
                    'duplo_d1' => $d1[$index] ?? null,
                    'duplo_d2' => $d2[$index] ?? null,
                    'duplo_d3' => $d3[$index] ?? null,
                    'range' => $nilai_rujukan[$index] ?? null, // Gunakan field range yang sudah ada
                    'satuan' => $satuans[$index] ?? null,
                    'metode' => $metodes[$index] ?? null,
                    'flag' => $flags[$index] ?? null,
                    'judul' => $judul[$index] ?? null,
                    'department' => $departments[$index] ?? null,
                    'note' => $note ?? null,
                ];

                if ($existingHasil) {
                    // Update existing record
                    $existingHasil->update($data);
                    // \Log::info("Updated parameter: {$parameter_name} = {$data['hasil']}");
                } else {
                    // Create new record
                    HasilPemeriksaan::create($data);
                    // \Log::info("Created parameter: {$parameter_name} = {$data['hasil']}");
                }

                $savedCount++;
            } catch (\Exception $e) {
                $errorCount++;
                // \Log::error("Failed to save parameter {$parameter_name}: " . $e->getMessage());
            }
        }

        // \Log::info("Saved: {$savedCount}, Errors: {$errorCount}");

        // Cari pasien dengan no_lab yang sama dan status 'Check In Spesiment'
        $pasien = pasien::where('no_lab', $no_lab)
            ->where(function ($query) {
                $query->where('status', 'Check In Spesiment')
                    ->orWhere('status', 'Dikembalikan');
            })
            ->first();

        // Cek apakah pasien ditemukan
        if ($pasien) {
            // Update status pasien jika ditemukan

            $analystName = Auth::user()->name;
            $pasien->update([
                'status' => 'Result Review',
                'analyst' => $analystName,
            ]);

            // Menyimpan riwayat pasien
            historyPasien::create([
                'no_lab' => $pasien->no_lab,
                'proses' => 'Diverifikasi Analyst',
                'tempat' => 'Laboratorium',
                'note' => $note ?? null,
                'waktu_proses' => now(),
                'created_at' => now(),
            ]); // ambil nama user yang login
            Report::where('nolab', $no_lab)
                ->update([
                    'analyst' => $analystName,
                    'updated_at' => now(),
                ]);
        } else {
            // Jika pasien tidak ditemukan, lakukan tindakan yang sesuai
            return redirect()->back()->withErrors(['message' => 'Pasien tidak ditemukan atau status tidak sesuai']);
        }

        // Menampilkan toast dan redirect
        if ($errorCount > 0) {
            toast("Data berhasil disimpan, tapi ada {$errorCount} error", 'warning');
        } else {
            toast("Data berhasil disimpan", 'success');
        }

        return redirect()->route('worklist.index');
    }


    public function updateHasil(Request $request, $no_lab)
    {

        // dd($request->all());
        $request->validate([
            'no_lab' => 'required',
            'nama_pemeriksaan.*' => 'required',
            'hasil.*' => 'nullable',
            'duplo_d1.*' => 'nullable',
            'duplo_d2.*' => 'nullable',
            'duplo_d3.*' => 'nullable',
            'duplo_dx' => 'nullable',
            'duplo_dx.*' => 'nullable',
            'is_switched.*' => 'nullable|boolean',
            'flag_dx' => 'nullable',
            'flag_dx.*' => 'nullable',
        ]);

        try {
            $data = $request->all();

            Log::info('=== UPDATE HASIL PEMERIKSAAN ===', [
                'no_lab' => $no_lab,
                'total_pemeriksaan' => count($data['nama_pemeriksaan']),
            ]);

            // 🔍 DEBUG: Log semua flag_dx yang dikirim
            Log::info('📦 FLAG_DX yang diterima dari request:', [
                'flag_dx_array' => $data['flag_dx'] ?? 'TIDAK ADA',
                'flag_dx_keys' => isset($data['flag_dx']) ? array_keys($data['flag_dx']) : [],
            ]);

            $updateCount = 0;

            for ($i = 0; $i < count($data['nama_pemeriksaan']); $i++) {
                $nama = $data['nama_pemeriksaan'][$i] ?? null;
                if (!$nama) continue;

                $hasil = HasilPemeriksaan::where('no_lab', $no_lab)
                    ->where('nama_pemeriksaan', $nama)
                    ->first();

                if ($hasil) {
                    $oldHasil = $hasil->hasil;
                    $oldDx = $hasil->duplo_dx;
                    $oldSwitch = (int) $hasil->is_switched;
                    $oldFlagDx = $hasil->flag_dx; // 🔍 Tambahkan ini

                    $newHasil = $data['hasil'][$i] ?? null;
                    $newDx = $data['duplo_dx'][$i] ?? null;

                    // ✅ Ambil flag_dx berdasarkan nama pemeriksaan
                    $newFlagDx = isset($data['flag_dx'][$nama]) ? $data['flag_dx'][$nama] : null;

                    // 🔍 DEBUG: Log detail per parameter
                    Log::info("📋 Processing: $nama", [
                        'index' => $i,
                        '--- OLD VALUES ---' => '',
                        'old_hasil' => $oldHasil,
                        'old_duplo_dx' => $oldDx,
                        'old_is_switched' => $oldSwitch,
                        'old_flag_dx' => $oldFlagDx,
                        '--- NEW VALUES ---' => '',
                        'new_hasil' => $newHasil,
                        'new_duplo_dx' => $newDx,
                        'new_flag_dx_from_request' => $newFlagDx,
                        '--- REQUEST INFO ---' => '',
                        'flag_dx_key_exists' => isset($data['flag_dx'][$nama]) ? 'YES' : 'NO',
                        'flag_dx_value' => $data['flag_dx'][$nama] ?? 'NOT SET',
                    ]);

                    $newSwitch = $oldSwitch;

                    if (!is_null($newDx) && $newDx !== '') {
                        // Kondisi 1: DX baru diisi
                        if ((is_null($oldDx) || $oldDx === '') && $newDx === $oldHasil && $oldHasil !== null) {
                            $newSwitch = 1;
                            Log::info("✅ KONDISI 1: DX baru diisi untuk $nama → is_switched = 1");
                        }
                        // Kondisi 2: Terjadi pertukaran
                        elseif (($newHasil === $oldDx && $newDx === $oldHasil) &&
                            ($oldHasil !== null || $oldDx !== null)
                        ) {
                            $newSwitch = $oldSwitch === 1 ? 0 : 1;
                            Log::info("✅ KONDISI 2: Pertukaran hasil-DX untuk $nama → is_switched toggle {$oldSwitch} → {$newSwitch}");
                        }
                        // DEBUG: Kondisi tidak terpenuhi
                        else {
                            Log::info("⚠️ KONDISI TIDAK TERPENUHI untuk $nama", [
                                'kondisi_1_check' => [
                                    'oldDx_is_null_or_empty' => (is_null($oldDx) || $oldDx === ''),
                                    'newDx_equals_oldHasil' => $newDx === $oldHasil,
                                    'oldHasil_not_null' => $oldHasil !== null,
                                ],
                                'kondisi_2_check' => [
                                    'newHasil_equals_oldDx' => $newHasil === $oldDx,
                                    'newDx_equals_oldHasil' => $newDx === $oldHasil,
                                    'old_values_not_null' => ($oldHasil !== null || $oldDx !== null),
                                ],
                            ]);
                        }
                    } else {
                        // DX dikosongkan
                        $newSwitch = 0;
                        $newFlagDx = null;
                        Log::info("DX dikosongkan untuk $nama → is_switched = 0, flag_dx = null");
                    }

                    // Validasi flag_dx
                    $finalFlagDx = (!empty($newFlagDx) && trim($newFlagDx) !== '') ? $newFlagDx : null;


                    $hasil->update([
                        'hasil' => $newHasil,
                        'duplo_d1' => $data['duplo_d1'][$i] ?? null,
                        'duplo_d2' => $data['duplo_d2'][$i] ?? null,
                        'duplo_d3' => $data['duplo_d3'][$i] ?? null,
                        'duplo_dx' => $newDx,
                        'flag_dx' => $finalFlagDx,
                        'is_switched' => $newSwitch,
                        'updated_at' => now(),
                    ]);

                    Log::info("💾 SAVED $nama", [
                        'flag_dx_saved' => $finalFlagDx,
                        'is_switched_saved' => $newSwitch,
                    ]);

                    $updateCount++;
                } else {
                    Log::warning("⚠️ Hasil pemeriksaan tidak ditemukan untuk $nama", [
                        'no_lab' => $no_lab,
                    ]);
                }
            }

            if ($updateCount > 0) {
                $totalHistory = HistoryPasien::where('no_lab', $no_lab)
                    ->where('proses', 'like', '%Update Hasil%')
                    ->count();

                $updateNumber = $totalHistory + 1;

                HistoryPasien::create([
                    'no_lab' => $no_lab,
                    'proses' => "Update Hasil ke-$updateNumber",
                    'tempat' => 'Result Review',
                    'waktu_proses' => now(),
                    'created_at' => now(),
                ]);

                Log::info('✅ History berhasil disimpan', [
                    'proses' => "Update Hasil ke-$updateNumber",
                ]);
            }

            toast("Data hasil diperbarui", 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error('Gagal update hasil pemeriksaan', [
                'no_lab' => $no_lab,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            toast('Gagal update data: ' . $e->getMessage(), 'error');
            return redirect()->back();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function checkin(Request $request, $id)
    {
        // Validasi input - disamakan dengan store
        $request->validate([
            'no_lab' => 'required',
            'no_rm' => 'required',
            'nama' => 'required',
            'ruangan' => 'required',
            'nama_dokter' => 'required',
            'parameter_name.*' => 'required',
            'nama_pemeriksaan.*' => 'required',
            'hasil.*' => 'nullable',   // ⬅️ sama dengan store (tidak wajib)
            'duplo_d1.*' => 'nullable',
            'duplo_d2.*' => 'nullable',
            'duplo_d3.*' => 'nullable',
            'nilai_rujukan.*' => 'nullable',
            'satuan.*' => 'nullable',
            'metode.*' => 'nullable',
            'department.*' => 'required',
            'flag.*' => 'nullable',
            'judul.*' => 'nullable',
            'note' => 'nullable',
        ]);

        // Ambil data dari request
        $no_lab = $request->input('no_lab');
        $no_rm = $request->input('no_rm');
        $nama = $request->input('nama');
        $ruangan = $request->input('ruangan');
        $nama_dokter = $request->input('nama_dokter');

        $parameter_names = $request->input('parameter_name', []);
        $nama_pemeriksaan = $request->input('nama_pemeriksaan', []);
        $hasils = $request->input('hasil', []);
        $d1 = $request->input('duplo_d1', []);
        $d2 = $request->input('duplo_d2', []);
        $d3 = $request->input('duplo_d3', []);
        $nilai_rujukan = $request->input('nilai_rujukan', []);
        $satuans = $request->input('satuan', []);
        $metodes = $request->input('metode', []);
        $judul = $request->input('judul', []);
        $flags = $request->input('flag', []);
        $departments = $request->input('department', []);
        $note = $request->input('note');

        // Validasi panjang data
        $expectedLength = count($parameter_names);
        if (
            count($nama_pemeriksaan) !== $expectedLength ||
            count($hasils) !== $expectedLength ||
            count($departments) !== $expectedLength
        ) {
            return redirect()->back()->withErrors(['message' => 'Data tidak valid - panjang array tidak sama']);
        }

        $savedCount = 0;
        $errorCount = 0;

        foreach ($parameter_names as $index => $parameter_name) {
            if (empty($parameter_name)) continue;

            try {
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
                    'duplo_d1' => $d1[$index] ?? null,
                    'duplo_d2' => $d2[$index] ?? null,
                    'duplo_d3' => $d3[$index] ?? null,
                    'range' => $nilai_rujukan[$index] ?? null,
                    'satuan' => $satuans[$index] ?? null,
                    'metode' => $metodes[$index] ?? null,
                    'flag' => $flags[$index] ?? null,
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
                Log::error("Failed to save parameter {$parameter_name}: " . $e->getMessage());
            }
        }

        // Update status pasien (⬅️ hanya bagian ini yang beda dengan store)
        $pasien = Pasien::findOrFail($id);
        $newStatus = $pasien->status === 'Dikembalikan'
            ? 'Diverifikasi Ulang'
            : 'Verifikasi Dokter';

        $pasien->update(['status' => $newStatus]);

        HistoryPasien::create([
            'no_lab' => $pasien->no_lab,
            'proses' => $newStatus,
            'tempat' => 'Laboratorium',
            'note' => $note ?? null,
            'waktu_proses' => now(),
            'created_at' => now(),
        ]);

        if ($errorCount > 0) {
            toast("Data berhasil disimpan , tapi ada {$errorCount} error", 'warning');
        } else {
            toast("Data berhasil disimpan ", 'success');
        }

        return redirect()->route('worklist.index');
    }




    public function end($id)
    {
        $data_pasien = pasien::find($id);

        $data_pasien->update(['status' => 'Result Review']);

        toast('Data Berhasil Diselesaikan', 'success');
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



    // public function tampilPemeriksaan($lab)
    // {
    //     $nolab = null;
    //     $nolab = $lab;
    //     $data = pasien::all();
    //     return response()->json($nolab);
    // }

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
