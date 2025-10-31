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
        // dd($request->all());
        // Validasi input dengan UID sebagai key
        $request->validate([
            'no_lab' => 'required',
            'no_rm' => 'required',
            'nama' => 'required',
            'ruangan' => 'required',
            'nama_dokter' => 'required',
            'uid' => 'required|array',
            'uid.*' => 'required|string',
            'parameter_name' => 'nullable|array',
            'nama_pemeriksaan' => 'nullable|array',
            'hasil' => 'nullable|array',
            'duplo_d1' => 'nullable|array',
            'duplo_d2' => 'nullable|array',
            'duplo_d3' => 'nullable|array',
            'nilai_rujukan' => 'nullable|array',
            'satuan' => 'nullable|array',
            'metode' => 'nullable|array',
            'department' => 'nullable|array',
            'flag' => 'nullable|array',
            'judul' => 'nullable|array',
            'note' => 'nullable|string',
        ]);

        // Ambil data umum pasien
        $no_lab = $request->input('no_lab');
        $no_rm = $request->input('no_rm');
        $nama = $request->input('nama');
        $ruangan = $request->input('ruangan');
        $nama_dokter = $request->input('nama_dokter');
        $note = $request->input('note');

        // Ambil array UID sebagai master key
        $uids = $request->input('uid', []);

        // Ambil semua data dengan UID sebagai key
        $parameter_names = $request->input('parameter_name', []);
        $nama_pemeriksaans = $request->input('nama_pemeriksaan', []);
        $hasils = $request->input('hasil', []);
        $duplo_d1s = $request->input('duplo_d1', []);
        $duplo_d2s = $request->input('duplo_d2', []);
        $duplo_d3s = $request->input('duplo_d3', []);
        $nilai_rujukans = $request->input('nilai_rujukan', []);
        $satuans = $request->input('satuan', []);
        $metodes = $request->input('metode', []);
        $juduls = $request->input('judul', []);
        $flags = $request->input('flag', []);
        $departments = $request->input('department', []);

        // Log untuk debugging
        Log::info('Total UIDs received: ' . count($uids));

        $savedCount = 0;
        $errorCount = 0;
        $skippedCount = 0;
        $errors = [];

        DB::beginTransaction();

        try {
            // Loop berdasarkan UID (master key)
            foreach ($uids as $uid) {
                // Ambil data untuk UID ini
                $parameter_name = $parameter_names[$uid] ?? null;
                $nama_pemeriksaan = $nama_pemeriksaans[$uid] ?? null;
                $hasil = $hasils[$uid] ?? null;
                $duplo_d1 = $duplo_d1s[$uid] ?? null;
                $duplo_d2 = $duplo_d2s[$uid] ?? null;
                $duplo_d3 = $duplo_d3s[$uid] ?? null;
                $nilai_rujukan = $nilai_rujukans[$uid] ?? null;
                $satuan = $satuans[$uid] ?? null;
                $metode = $metodes[$uid] ?? null;
                $judul = $juduls[$uid] ?? null;
                $flag = $flags[$uid] ?? null;
                $department = $departments[$uid] ?? null;

                // Validasi data wajib untuk parameter ini
                if (empty($parameter_name) || empty($nama_pemeriksaan)) {
                    Log::warning("Skipping UID {$uid}: missing parameter_name or nama_pemeriksaan", [
                        'parameter_name' => $parameter_name,
                        'nama_pemeriksaan' => $nama_pemeriksaan
                    ]);
                    $skippedCount++;
                    continue;
                }

                // Skip jika hasil kosong (opsional, tergantung kebutuhan)
                // if (empty($hasil)) {
                //     $skippedCount++;
                //     continue;
                // }

                try {
                    // Cari existing record berdasarkan no_lab dan parameter_name
                    // PENTING: Gunakan kombinasi yang unik untuk identifikasi
                    $existingHasil = HasilPemeriksaan::where('no_lab', $no_lab)
                        ->where('nama_pemeriksaan', $parameter_name)
                        ->where('judul', $judul ?? '')
                        ->first();

                    // Prepare data untuk save
                    $dataToSave = [
                        'uid' => $uid,
                        'no_lab' => $no_lab,
                        'no_rm' => $no_rm,
                        'nama' => $nama,
                        'ruangan' => $ruangan,
                        'nama_dokter' => $nama_dokter,
                        'nama_pemeriksaan' => $parameter_name,
                        'hasil' => $hasil ?? '',
                        'duplo_d1' => $duplo_d1,
                        'duplo_d2' => $duplo_d2,
                        'duplo_d3' => $duplo_d3,
                        'range' => $nilai_rujukan,
                        'satuan' => $satuan,
                        'metode' => $metode,
                        'flag' => $flag,
                        'judul' => $judul,
                        'department' => $department,
                        'note' => $note,
                    ];

                    // Log detail untuk debugging spesifik parameter
                    Log::info("Processing UID: {$uid}", [
                        'parameter_name' => $parameter_name,
                        'nama_pemeriksaan' => $nama_pemeriksaan,
                        'judul' => $judul,
                        'hasil' => $hasil,
                        'flag' => $flag,
                        'duplo_d1' => $duplo_d1,
                        'duplo_d2' => $duplo_d2,
                        'duplo_d3' => $duplo_d3,
                    ]);

                    if ($existingHasil) {
                        // Update existing record
                        $existingHasil->update($dataToSave);
                        Log::info("✓ Updated: {$parameter_name} (UID: {$uid})", [
                            'hasil' => $hasil,
                            'flag' => $flag
                        ]);
                    } else {
                        // Create new record
                        HasilPemeriksaan::create($dataToSave);
                        Log::info("✓ Created: {$parameter_name} (UID: {$uid})", [
                            'hasil' => $hasil,
                            'flag' => $flag
                        ]);
                    }

                    $savedCount++;
                } catch (\Exception $e) {
                    $errorCount++;
                    $errorMsg = "Failed to save UID {$uid} ({$parameter_name}): " . $e->getMessage();
                    Log::error($errorMsg);
                    $errors[] = $errorMsg;
                }
            }

            // Update status pasien
            $pasien = Pasien::where('no_lab', $no_lab)
                ->where(function ($query) {
                    $query->where('status', 'Check In Spesiment')
                        ->orWhere('status', 'Dikembalikan');
                })
                ->first();

            if (!$pasien) {
                throw new \Exception('Pasien tidak ditemukan atau status tidak sesuai');
            }

            $analystName = Auth::user()->name;

            $pasien->update([
                'status' => 'Result Review',
                'analyst' => $analystName,
            ]);

            // Simpan riwayat
            HistoryPasien::create([
                'no_lab' => $pasien->no_lab,
                'proses' => 'Diverifikasi Analyst',
                'tempat' => 'Laboratorium',
                'note' => $note,
                'waktu_proses' => now(),
                'created_at' => now(),
            ]);

            Report::where('nolab', $no_lab)->update([
                'analyst' => $analystName,
                'updated_at' => now(),
            ]);

            DB::commit();

            // Log summary
            Log::info("=== STORE SUMMARY ===", [
                'no_lab' => $no_lab,
                'total_uids' => count($uids),
                'saved' => $savedCount,
                'skipped' => $skippedCount,
                'errors' => $errorCount
            ]);

            // Response berdasarkan hasil
            if ($errorCount > 0) {
                toast("Data berhasil disimpan: {$savedCount} parameter. {$errorCount} error terjadi.", 'warning');
            } else {
                toast("Berhasil menyimpan {$savedCount} parameter", 'success');
            }

            return redirect()->route('worklist.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Store transaction failed: ' . $e->getMessage());

            return redirect()->back()
                ->withErrors(['message' => 'Gagal menyimpan data: ' . $e->getMessage()])
                ->withInput();
        }
    }


    public function updateHasil(Request $request, $no_lab)
    {
        // Validasi
        // dd($request->all());
        $request->validate([
            'no_lab' => 'required',
            'uid' => 'required|array',
            'uid.*' => 'required|string',
            'nama_pemeriksaan' => 'required|array',
            'nama_pemeriksaan.*' => 'required|string',
            'hasil' => 'nullable|array',
            'duplo_dx' => 'nullable|array',
            'is_switched' => 'nullable|array',
            'flag_dx' => 'nullable|array',
        ]);

        try {
            $data = $request->all();
            $updateCount = 0;
            $failedUpdates = [];
            $successUpdates = [];

            // DEBUG: Cek semua UID yang ada di database untuk no_lab ini
            $existingUIDs = HasilPemeriksaan::where('no_lab', $no_lab)
                ->pluck('nama_pemeriksaan', 'uid')
                ->toArray();

            Log::info("=== UID di Database ===", $existingUIDs);
            Log::info("=== UID dari Request ===", $data['uid']);

            foreach ($data['uid'] as $uniqueID => $uidValue) {
                $namaPemeriksaan = $data['nama_pemeriksaan'][$uniqueID] ?? null;

                Log::info("Processing", [
                    'uniqueID_key' => $uniqueID,
                    'uidValue' => $uidValue,
                    'nama_pemeriksaan' => $namaPemeriksaan
                ]);

                // PERBAIKAN 1: Query berdasarkan UID
                $hasil = HasilPemeriksaan::where('uid', $uniqueID)
                    ->where('no_lab', $no_lab)
                    ->first();

                // PERBAIKAN 2: Jika tidak ketemu, coba cari berdasarkan nama_pemeriksaan
                if (!$hasil && $namaPemeriksaan) {
                    $hasil = HasilPemeriksaan::where('no_lab', $no_lab)
                        ->where('nama_pemeriksaan', $namaPemeriksaan)
                        ->first();

                    if ($hasil) {
                        Log::warning("UID Mismatch - Update UID", [
                            'old_uid' => $hasil->uid,
                            'new_uid' => $uniqueID,
                            'nama_pemeriksaan' => $namaPemeriksaan
                        ]);

                        // Update UID agar match ke depannya
                        $hasil->uid = $uniqueID;
                        $hasil->save();
                    }
                }


                if (!$hasil) {
                    Log::error("Data tidak ditemukan", [
                        'uniqueID' => $uniqueID,
                        'nama_pemeriksaan' => $namaPemeriksaan,
                        'no_lab' => $no_lab,
                        'available_uids' => array_keys($existingUIDs)
                    ]);

                    $failedUpdates[] = [
                        'uid' => $uniqueID,
                        'nama' => $namaPemeriksaan,
                        'reason' => 'Data tidak ditemukan di database'
                    ];
                    continue;
                }

                // Ambil nilai baru dari request
                $newHasil = $data['hasil'][$uniqueID] ?? null;
                $newDx = $data['duplo_dx'][$uniqueID] ?? null;
                $newFlagDx = $data['flag_dx'][$uniqueID] ?? null;
                $requestSwitch = isset($data['is_switched'][$uniqueID]) ? (int) $data['is_switched'][$uniqueID] : 0;

                // Simpan nilai lama untuk tracking
                $oldHasil = $hasil->hasil;
                $oldDx = $hasil->duplo_dx;
                $oldSwitch = (int) $hasil->is_switched;
                $oldFlagDx = $hasil->flag_dx;

                // Logika penentuan is_switched
                $newSwitch = $oldSwitch;

                if (!is_null($newDx) && trim($newDx) !== '') {
                    // Kondisi 1: DX baru diisi pertama kali dengan nilai dari hasil
                    if ((is_null($oldDx) || trim($oldDx) === '') &&
                        trim($newDx) === trim($oldHasil) &&
                        !is_null($oldHasil)
                    ) {
                        $newSwitch = 1;
                        Log::info("Switch Case 1: DX filled with original hasil", ['uid' => $uniqueID]);
                    }
                    // Kondisi 2: Terjadi pertukaran nilai (swap)
                    elseif ((trim($newHasil) === trim($oldDx) && trim($newDx) === trim($oldHasil)) &&
                        (!is_null($oldHasil) || !is_null($oldDx))
                    ) {
                        $newSwitch = $oldSwitch === 1 ? 0 : 1;
                        Log::info("Switch Case 2: Values swapped", ['uid' => $uniqueID, 'new_switch' => $newSwitch]);
                    }
                    // Kondisi 3: Request mengirim is_switched = 1
                    elseif ($requestSwitch === 1) {
                        $newSwitch = 1;
                        Log::info("Switch Case 3: Request forced switch", ['uid' => $uniqueID]);
                    }
                } else {
                    // DX dikosongkan - reset switch
                    $newSwitch = 0;
                    $newFlagDx = null;
                    Log::info("Switch Reset: DX emptied", ['uid' => $uniqueID]);
                }

                // Validasi flag_dx
                if (is_null($newDx) || trim($newDx) === '') {
                    $finalFlagDx = null;
                } else {
                    // Jika switch aktif atau baru aktif → gunakan flag_dx dari request, atau default 'Normal'
                    if ($newSwitch === 1 || $requestSwitch === 1) {
                        $finalFlagDx = !empty($newFlagDx) && trim($newFlagDx) !== ''
                            ? trim($newFlagDx)
                            : 'Normal';
                    } else {
                        // Jika belum switch tapi user isi flag, tetap simpan
                        $finalFlagDx = !empty($newFlagDx) && trim($newFlagDx) !== ''
                            ? trim($newFlagDx)
                            : $oldFlagDx;
                    }
                }

                // Prepare update data
                $updateData = [
                    'hasil' => $newHasil,
                    'duplo_dx' => $newDx,
                    'flag_dx' => $finalFlagDx,
                    'is_switched' => $newSwitch,
                    'updated_at' => now(),
                ];

                // Cek apakah ada perubahan
                $hasChanges = false;
                $changes = [];

                foreach ($updateData as $key => $value) {
                    if ($key !== 'updated_at' && $hasil->$key != $value) {
                        $hasChanges = true;
                        $changes[$key] = [
                            'old' => $hasil->$key,
                            'new' => $value
                        ];
                    }
                }

                if ($hasChanges) {
                    Log::info("Updating", [
                        'uid' => $uniqueID,
                        'nama_pemeriksaan' => $namaPemeriksaan,
                        'changes' => $changes
                    ]);

                    $hasil->update($updateData);
                    $updateCount++;

                    $successUpdates[] = [
                        'uid' => $uniqueID,
                        'nama' => $namaPemeriksaan,
                        'changes' => $changes
                    ];
                } else {
                    Log::info("No changes", [
                        'uid' => $uniqueID,
                        'nama_pemeriksaan' => $namaPemeriksaan
                    ]);
                }
            }

            // Logging hasil akhir
            Log::info("=== Update Summary ===", [
                'total_processed' => count($data['uid']),
                'success' => $updateCount,
                'failed' => count($failedUpdates),
                'no_changes' => count($data['uid']) - $updateCount - count($failedUpdates)
            ]);

            if (count($failedUpdates) > 0) {
                Log::error("Failed Updates Detail", $failedUpdates);
            }

            if (count($successUpdates) > 0) {
                Log::info("Success Updates Detail", $successUpdates);
            }

            // History
            if ($updateCount > 0) {
                $totalHistory = HistoryPasien::where('no_lab', $no_lab)
                    ->where('proses', 'like', '%Update Hasil%')
                    ->count();

                HistoryPasien::create([
                    'no_lab' => $no_lab,
                    'proses' => "Update Hasil ke-" . ($totalHistory + 1),
                    'tempat' => 'Result Review',
                    'waktu_proses' => now(),
                    'created_at' => now(),
                ]);

                $message = "Berhasil update $updateCount data";
                if (count($failedUpdates) > 0) {
                    $message .= ", gagal " . count($failedUpdates) . " data";
                }
                toast($message, 'success');
            } else {
                if (count($failedUpdates) > 0) {
                    toast('Gagal update semua data. Cek log untuk detail.', 'error');
                } else {
                    toast('Tidak ada perubahan data', 'info');
                }
            }

            return redirect()->back();
        } catch (\Exception $e) {
            Log::error("Update Exception", [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            toast('Gagal update: ' . $e->getMessage(), 'error');
            return redirect()->back()->withInput();
        }
    }

    // TAMBAHAN: Method untuk debug UID
    public function debugUID($no_lab)
    {
        $hasil = HasilPemeriksaan::where('no_lab', $no_lab)->get();

        $debug = $hasil->map(function ($item) {
            return [
                'id' => $item->id,
                'uid' => $item->uid,
                'nama_pemeriksaan' => $item->nama_pemeriksaan,
                'hasil' => $item->hasil,
                'duplo_dx' => $item->duplo_dx,
                'is_switched' => $item->is_switched,
            ];
        });

        return response()->json([
            'total' => $hasil->count(),
            'data' => $debug
        ]);
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
