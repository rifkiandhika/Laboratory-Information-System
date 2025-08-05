<?php

namespace App\Http\Controllers\analyst;

use Carbon\Carbon;
use App\Models\pasien;
use Illuminate\Http\Request;
use App\Models\historyPasien;
use App\Models\spesimentHandling;
use Illuminate\Support\Facades\DB;
use App\Models\spesimentCollection;
use App\Http\Controllers\Controller;
use App\Models\pembayaran;
use App\Models\pemeriksaan_pasien;
use Exception;
use Illuminate\Support\Facades\Log;

class spesimentHendlingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pasienharian = pasien::where('created_at', now())->count();

        $bl = pasien::where('status', 'Acc Collection')->count();
        $dl = pasien::where('status', 'Check In Spesiment')->count();

        $dataPasienCito = pasien::whereIn('status', ['Check in', 'Spesiment', 'Acc Collection', 'Acc Handling'])
            ->orderBy('cito', 'desc')
            ->paginate(20);

        $dataPasien = pasien::whereIn('status', ['Check in', 'Spesiment'])
            ->where('cito', 0)
            ->paginate(20);
        // $dataPasien = pasien::where(function ($query) {
        //     $query->where('status', 'Check in')
        //         ->orWhere('status', 'Spesiment');
        // })
        //     ->where('cito', 0)
        //     ->get();

        // $dataPasienCito = pasien::where(function ($query) {
        //     $query->where('status', 'Check in')
        //         ->orWhere('status', 'Spesiment');
        // })
        //     ->where('cito', 1)
        //     ->get();


        $dataHistory = historyPasien::where('proses', '=', 'order')->get();

        return view('analyst.s-handling', compact('dataPasien', 'dataPasienCito', 'dataHistory', 'pasienharian', 'bl', 'dl'));
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
        // Debugging request
        // dd($request);

        // dd($request);
        $request->validate([
            'no_lab' => 'required',
            'serum' => 'required|array',
            'serumc' => 'required|array'
        ]);

        // Ambil input dari request
        $no_lab = $request->input('no_lab');
        $serum = $request->input('serum');
        $serumc = $request->input('serumc');
        $notes = $request->input('note', []);

        // Menghapus data lama sebelum memasukkan data baru
        spesimentHandling::where('no_lab', $no_lab)->delete();  // Hapus semua data spesimen yang terkait dengan no_lab
        // historyPasien::where('no_lab', $no_lab)->delete(); // Hapus history pasien terkait no_lab

        // Jika ada kapasitas, simpan data baru untuk tabung EDTA
        if (!empty($serum)) {
            foreach ($serum as $x => $serum) {
                spesimentHandling::create([
                    'no_lab' => $no_lab,
                    'tabung' => 'CLOT-ACT',
                    'serum' => $serum,
                    'status' => 'Acc Handling',
                    'note' => $notes[$x] ?? null,
                    'tanggal' => now(),
                ]);

                historyPasien::create([
                    'no_lab' => $no_lab,
                    'proses' => 'Acc Handling',
                    'tempat' => 'Laboratorium',
                    'waktu_proses' => now(),
                ]);
            }
        }
        if (!empty($serumc)) {
            foreach ($serumc as $x => $serc) {
                spesimentHandling::create([
                    'no_lab' => $no_lab,
                    'tabung' => 'CLOT',
                    'serum' => $serc,
                    'status' => 'Acc Handling',
                    'note' => $notes[$x] ?? null,
                    'tanggal' => now(),
                ]);

                historyPasien::create([
                    'no_lab' => $no_lab,
                    'proses' => 'Acc Handling',
                    'tempat' => 'Laboratorium',
                    'waktu_proses' => now(),
                ]);
            }
        }

        // Update status pasien menjadi 'Acc Collection'
        pasien::where('no_lab', $no_lab)->update([
            'status' => 'Acc Handling',
        ]);

        // Success toast notification
        toast('Berhasil Approve Spesiment', 'success');
        return redirect()->route('spesiment.index');
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
        $request->validate([
            'nik' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
        ]);

        $data_pasien = pasien::findOrFail($id);
        $data_pasien->nik = $request->nik;
        $data_pasien->nama = $request->nama;
        $data_pasien->alamat = $request->alamat;
        $data_pasien->save();

        toast('Data berhasil diperbarui!', 'success');
        return redirect()->route('spesiment.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $no_lab)
    {
        // Cari data pasien berdasarkan no_lab
        $pasien = pasien::where('no_lab', $no_lab)->first();

        // Cek apakah data pasien belum diverifikasi
        if ($pasien && $pasien->status = 'Check In') {
            // Hapus data dari tabel pemeriksaan_pasien
            pemeriksaan_pasien::where('no_lab', $no_lab)->delete();

            // Hapus data dari tabel pembayaran
            pembayaran::where('no_lab', $no_lab)->delete();

            // Hapus data dari tabel pasien
            $pasien->delete();

            toast('Berhasil Menghapus Data Pasien', 'success');
            return redirect()->route('spesiment.index');
        }
        toast('Tidak dapat menghapus data yang sudah diverifikasi', 'error');
        return redirect()->route('spesiment.index');
    }

    public function checkin(Request $request)
    {
        $ids = $request->ids;
        $pasiens = pasien::whereIn('id', $ids)->get();

        foreach ($pasiens as $pasien) {
            $no_lab = $pasien->no_lab;

            // Cek apakah sudah ada data spesiment_handling untuk no_lab ini
            $sudahAda = spesimentHandling::where('no_lab', $no_lab)->exists();

            if ($sudahAda) {
                // ✅ Jika SUDAH ADA data spesiment_handling
                $pasien->update(['status' => 'Check In Spesiment']);

                historyPasien::create([
                    'no_lab' => $no_lab,
                    'proses' => 'Check in spesiment',
                    'tempat' => 'Laboratorium',
                    'waktu_proses' => now(),
                ]);

                continue; // lanjut pasien berikutnya
            }

            // ✅ Jika BELUM ADA data spesimen, jalankan proses seperti store()

            // Siapkan array sesuai struktur store()
            $serum = [];          // Untuk tabung CLOT-ACT
            $notes_serum = [];

            $serumc = [];         // Untuk tabung CLOT
            $notes_serumc = [];

            // Ambil data spesimen dari relasi
            foreach ($pasien->spesiment as $spesiment) {
                if ($spesiment->tabung === 'CLOT-ACT') {
                    $serum[] = $spesiment->serum ?? 4;
                    $notes_serum[] = $spesiment->note ?? 'Normal';
                } elseif ($spesiment->tabung === 'CLOT') {
                    $serumc[] = $spesiment->serum ?? 4;
                    $notes_serumc[] = $spesiment->note ?? 'Normal';
                }
            }

            // Simpan CLOT-ACT
            foreach ($serum as $i => $value) {
                spesimentHandling::create([
                    'no_lab' => $no_lab,
                    'tabung' => 'CLOT-ACT',
                    'serum' => $value,
                    'status' => 'Acc Handling',
                    'note' => $notes_serum[$i] ?? null,
                    'tanggal' => now(),
                ]);

                historyPasien::create([
                    'no_lab' => $no_lab,
                    'proses' => 'Acc Handling',
                    'tempat' => 'Laboratorium',
                    'waktu_proses' => now(),
                ]);
            }

            // Simpan CLOT
            foreach ($serumc as $i => $value) {
                spesimentHandling::create([
                    'no_lab' => $no_lab,
                    'tabung' => 'CLOT',
                    'serum' => $value,
                    'status' => 'Acc Handling',
                    'note' => $notes_serumc[$i] ?? null,
                    'tanggal' => now(),
                ]);

                historyPasien::create([
                    'no_lab' => $no_lab,
                    'proses' => 'Acc Handling',
                    'tempat' => 'Laboratorium',
                    'waktu_proses' => now(),
                ]);
            }

            // Update status dan catat check-in
            $pasien->update(['status' => 'Check In Spesiment']);

            historyPasien::create([
                'no_lab' => $no_lab,
                'proses' => 'Check in spesiment',
                'tempat' => 'Laboratorium',
                'waktu_proses' => now(),
            ]);
        }

        toast('Pasien telah check in dari Spesiment', 'success');
        return response()->json(['success' => 'Data berhasil dikonfirmasi!']);
    }



    public function back(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|string|max:255',
        ]);

        $pasien = pasien::find($id);

        // Update status pasien
        $pasien->update(['status' => 'Dikembalikan AnalystS']);

        pemeriksaan_pasien::where('no_lab', $pasien->no_lab)
            ->update(['status' => 'lama']);

        historyPasien::create([
            'no_lab' => $pasien->no_lab,
            'proses' => 'Dikembalikan oleh analyst',
            'tempat' => 'Laboratorium',
            'note' => $request->input('note'),
            'waktu_proses' => now(),
            'created_at' => now(),
        ]);

        toast('Data telah dikembalikan ke loket', 'success');
        return redirect()->route('spesiment.index');
    }

    public function backdashboard(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|string|max:255',
        ]);

        $pasien = pasien::find($id);

        // Update status pasien
        $pasien->update(['status' => 'Dikembalikan Analyst']);

        historyPasien::create([
            'no_lab' => $pasien->no_lab,
            'proses' => 'Dikembalikan oleh analyst',
            'tempat' => 'Laboratorium',
            'note' => $request->input('note'),
            'waktu_proses' => now(),
            'created_at' => now(),
        ]);

        toast('Data telah dikembalikan ke Dashboard', 'success');
        return redirect()->route('spesiment.index');
    }
}
