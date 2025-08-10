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
            'parameter_name.*' => 'required', // Validasi parameter_name
            'nama_pemeriksaan.*' => 'required',
            'hasil.*' => 'nullable', // UBAH: dari required ke nullable untuk parameter yang kosong
            'duplo_d1.*' => 'nullable',
            'duplo_d2.*' => 'nullable',
            'duplo_d3.*' => 'nullable',
            'nilai_rujukan.*' => 'nullable',
            'satuan.*' => 'nullable',
            'department.*' => 'required',
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
        $departments = $request->input('department', []);
        $note = $request->input('note'); // Note adalah string, bukan array

        // DEBUGGING LOG
        \Log::info('=== WORKLIST STORE DEBUG ===');
        \Log::info('Total parameter_names: ' . count($parameter_names));
        \Log::info('Total nama_pemeriksaan: ' . count($nama_pemeriksaan));
        \Log::info('Total hasils: ' . count($hasils));
        \Log::info('Total departments: ' . count($departments));

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
        \Log::info('Urine parameters found: ' . count($urineParams));
        \Log::info('Urine details: ' . implode(', ', $urineParams));

        // Validasi panjang data
        $expectedLength = count($parameter_names);
        if (
            count($nama_pemeriksaan) !== $expectedLength ||
            count($hasils) !== $expectedLength ||
            count($departments) !== $expectedLength
        ) {

            \Log::error('Array length mismatch:', [
                'parameter_names' => count($parameter_names),
                'nama_pemeriksaan' => count($nama_pemeriksaan),
                'hasils' => count($hasils),
                'departments' => count($departments)
            ]);

            return redirect()->back()->withErrors(['message' => 'Data tidak valid - panjang array tidak sama']);
        }

        $savedCount = 0;
        $errorCount = 0;

        // PERBAIKAN: Loop berdasarkan index parameter_names
        foreach ($parameter_names as $index => $parameter_name) {

            // Skip jika parameter kosong
            if (empty($parameter_name)) {
                \Log::warning("Skipping empty parameter at index {$index}");
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
                    'department' => $departments[$index] ?? null,
                    'note' => $note,
                ];

                if ($existingHasil) {
                    // Update existing record
                    $existingHasil->update($data);
                    \Log::info("Updated parameter: {$parameter_name} = {$data['hasil']}");
                } else {
                    // Create new record
                    HasilPemeriksaan::create($data);
                    \Log::info("Created parameter: {$parameter_name} = {$data['hasil']}");
                }

                $savedCount++;
            } catch (\Exception $e) {
                $errorCount++;
                \Log::error("Failed to save parameter {$parameter_name}: " . $e->getMessage());
            }
        }

        \Log::info("Saved: {$savedCount}, Errors: {$errorCount}");

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
            $pasien->update(['status' => 'Result Review']);

            // Menyimpan riwayat pasien
            historyPasien::create([
                'no_lab' => $pasien->no_lab,
                'proses' => 'Diverifikasi Analyst',
                'tempat' => 'Laboratorium',
                'waktu_proses' => now(),
                'created_at' => now(),
            ]);
        } else {
            // Jika pasien tidak ditemukan, lakukan tindakan yang sesuai
            return redirect()->back()->withErrors(['message' => 'Pasien tidak ditemukan atau status tidak sesuai']);
        }

        // Menampilkan toast dan redirect
        if ($errorCount > 0) {
            toast("Data berhasil disimpan ({$savedCount} parameter), tapi ada {$errorCount} error", 'warning');
        } else {
            toast("Data berhasil disimpan ({$savedCount} parameter)", 'success');
        }

        return redirect()->route('worklist.index');
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
        // Validasi input - disesuaikan dengan function store
        $request->validate([
            'no_lab' => 'required',
            'no_rm' => 'required',
            'nama' => 'required',
            'ruangan' => 'required',
            'nama_dokter' => 'required',
            'duplo_d1.*' => 'nullable|numeric',
            'duplo_d2.*' => 'nullable|numeric',
            'duplo_d3.*' => 'nullable|numeric',
            'note' => 'nullable',
            'nama_pemeriksaan.*' => 'required',
            'hasil.*' => 'required',
            'range.*' => 'nullable',
            'satuan.*' => 'nullable',
            'department.*' => 'required',
        ]);

        try {
            DB::beginTransaction();

            // Ambil data dari request - sama seperti function store
            $no_lab = $request->input('no_lab');
            $no_rm = $request->input('no_rm');
            $nama = $request->input('nama');
            $ruangan = $request->input('ruangan');
            $nama_dokter = $request->input('nama_dokter');
            $nama_pemeriksaan = $request->input('nama_pemeriksaan', []);
            $hasils = $request->input('hasil', []);
            $d1 = $request->input('duplo_d1', []);
            $d2 = $request->input('duplo_d2', []);
            $d3 = $request->input('duplo_d3', []);
            $notes = $request->input('note', []);
            $ranges = $request->input('range', []);
            $satuans = $request->input('satuan', []);
            $departments = $request->input('department', []);

            // Validasi panjang data nama_pemeriksaan dan hasil
            if (empty($nama_pemeriksaan) || empty($hasils) || count($nama_pemeriksaan) !== count($hasils)) {
                return redirect()->back()->withErrors(['message' => 'Data tidak valid atau kosong']);
            }

            // Cari data pasien
            $pasien = Pasien::findOrFail($id);

            // Jika status Dikembalikan, hapus semua data terkait
            if ($pasien->status === 'Dikembalikan') {
                HasilPemeriksaan::where('no_lab', $no_lab)->delete();
            }

            // Proses data pemeriksaan - sama seperti function store
            foreach ($nama_pemeriksaan as $x => $pemeriksaan) {
                $existingHasil = HasilPemeriksaan::where('no_lab', $no_lab)
                    ->where('nama_pemeriksaan', $pemeriksaan)
                    ->first();

                if ($existingHasil) {
                    // Jika data sudah ada, lakukan update
                    $existingHasil->update([
                        'hasil' => $hasils[$x] ?? $existingHasil->hasil,
                        'range' => isset($ranges[$x]) ? $ranges[$x] : $existingHasil->range,
                        'duplo_d1' => isset($d1[$x]) ? $d1[$x] : $existingHasil->duplo_d1,
                        'duplo_d2' => isset($d2[$x]) ? $d2[$x] : $existingHasil->duplo_d2,
                        'duplo_d3' => isset($d3[$x]) ? $d3[$x] : $existingHasil->duplo_d3,
                        'satuan' => isset($satuans[$x]) ? $satuans[$x] : $existingHasil->satuan,
                        'department' => isset($departments[$x]) ? $departments[$x] : $existingHasil->department,
                    ]);
                } else {
                    // Jika data belum ada, buat data baru
                    HasilPemeriksaan::create([
                        'no_lab' => $no_lab,
                        'no_rm' => $no_rm,
                        'nama' => $nama,
                        'ruangan' => $ruangan,
                        'nama_dokter' => $nama_dokter,
                        'nama_pemeriksaan' => $pemeriksaan,
                        'duplo_d1' => isset($d1[$x]) ? $d1[$x] : null,
                        'duplo_d2' => isset($d2[$x]) ? $d2[$x] : null,
                        'duplo_d3' => isset($d3[$x]) ? $d3[$x] : null,
                        'note' => isset($notes[$x]) ? $notes[$x] : null,
                        'hasil' => $hasils[$x] ?? null,
                        'range' => isset($ranges[$x]) ? $ranges[$x] : null,
                        'satuan' => isset($satuans[$x]) ? $satuans[$x] : null,
                        'department' => isset($departments[$x]) ? $departments[$x] : null,
                    ]);
                }
            }

            // Update status pasien
            $newStatus = $pasien->status === 'Dikembalikan' ? 'Diverifikasi Ulang' : 'Verifikasi Dokter';

            $pasien->update([
                'status' => $newStatus,
                'updated_at' => now()
            ]);

            // Buat history baru
            HistoryPasien::create([
                'no_lab' => $pasien->no_lab,
                'proses' => $newStatus,
                'tempat' => 'Laboratorium',
                'waktu_proses' => now(),
                'created_at' => now(),
            ]);

            DB::commit();

            toast($pasien->status === 'Dikembalikan' ?
                'Data telah diperbarui dan dikirim untuk verifikasi ulang' :
                'Data telah dikirim untuk diverifikasi', 'success');

            return redirect()->route('worklist.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toast('Terjadi kesalahan: ' . $e->getMessage(), 'error');
            return redirect()->back()->withInput();
        }
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
