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
        // Validasi input
        // dd($request->all());
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

        // Ambil data dari request
        $no_lab = $request->input('no_lab');
        $no_rm = $request->input('no_rm');
        $nama = $request->input('nama');
        $ruangan = $request->input('ruangan');
        $nama_dokter = $request->input('nama_dokter');
        $nama_pemeriksaan = $request->input('nama_pemeriksaan');
        $hasils = $request->input('hasil', []);
        $d1 = $request->input('duplo_d1', []);
        $d2 = $request->input('duplo_d2', []);
        $d3 = $request->input('duplo_d3', []);
        $notes = $request->input('note', []);
        $ranges = $request->input('range', []);
        $satuans = $request->input('satuan', []);
        $departments = $request->input('department');

        // Validasi panjang data nama_pemeriksaan dan hasil
        if (count($nama_pemeriksaan) !== count($hasils)) {
            return redirect()->back()->withErrors(['message' => 'Data tidak valid']);
        }

        // Proses data pemeriksaan
        foreach ($nama_pemeriksaan as $x => $pemeriksaan) {
            $existingHasil = HasilPemeriksaan::where('no_lab', $no_lab)
                ->where('nama_pemeriksaan', $pemeriksaan)
                ->first();

            if ($existingHasil) {
                // Jika data sudah ada, lakukan update
                $existingHasil->update([
                    'hasil' => $hasils[$x],
                    'range' => $ranges[$x] ?? $existingHasil->range,
                    'duplo_d1' => $d1[$x] ?? $existingHasil->duplo_d1,
                    'duplo_d2' => $d2[$x] ?? $existingHasil->duplo_d2,
                    'duplo_d3' => $d3[$x] ?? $existingHasil->duplo_d3,
                    'satuan' => $satuans[$x] ?? $existingHasil->satuan,
                    'department' => $departments[$x] ?? $existingHasil->department,

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
                    'duplo_d1' => $d1[$x] ?? null,
                    'duplo_d2' => $d2[$x] ?? null,
                    'duplo_d3' => $d3[$x] ?? null,
                    'note' => $notes[$x] ?? null,
                    'hasil' => $hasils[$x],
                    'range' => $ranges[$x] ?? null,
                    'satuan' => $satuans[$x] ?? null,
                    'department' => $departments[$x] ?? null,
                ]);
            }
        }

        // Cari pasien dengan no_lab yang sama dan status 'Check In Spesiment'
        $pasien = pasien::where('no_lab', $no_lab)
            ->where(function ($query) {
                $query->where('status', 'Check In Spesiment')
                    ->orWhere('status', 'Dikembalikan'); // Jika pasien sudah dikembalikan
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
        toast('Data berhasil di selesaikan', 'success');
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
        // Validasi input
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
            'hasil' => 'required|array',
            'nama_pemeriksaan' => 'required|array',
            'department' => 'required|array',
        ]);

        try {
            DB::beginTransaction(); // Mulai transaction untuk memastikan data konsisten

            // Cari data pasien
            $pasien = Pasien::findOrFail($id);

            // Jika status Dikembalikan, hapus semua data terkait
            if ($pasien->status === 'Dikembalikan') {
                // Hapus hasil pemeriksaan lama
                HasilPemeriksaan::where('no_lab', $pasien->no_lab)->delete();
            }

            // Simpan hasil pemeriksaan baru
            foreach ($request->nama_pemeriksaan as $index => $nama_pemeriksaan) {
                HasilPemeriksaan::create([
                    'no_lab' => $request->no_lab,
                    'nama_pemeriksaan' => $nama_pemeriksaan,
                    'hasil' => $request->hasil[$index],
                    'duplo_d1' => $request->duplo_d1[$index],
                    'duplo_d2' => $request->duplo_d2[$index],
                    'duplo_d3' => $request->duplo_d3[$index],
                    'note' => $request->note,
                    'department' => $request->department[$index],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // Update status pasien dan buat history baru
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

            DB::commit(); // Commit transaksi jika semua berhasil

            toast($pasien->status === 'Dikembalikan' ?
                'Data telah diperbarui dan dikirim untuk verifikasi ulang' :
                'Data telah dikirim untuk diverifikasi', 'success');

            return redirect()->route('worklist.index');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback jika terjadi kesalahan
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
