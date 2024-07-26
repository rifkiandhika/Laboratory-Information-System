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

class spesimentHendlingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataPasienCito = pasien::where('status', 'Check in')->orWhere('status', 'Spesiment')->orderBy('cito', 'desc')->paginate(20);
        $dataPasien = pasien::where('status', 'Check in')->orWhere('status', 'Spesiment')->where('cito', 0)->paginate(20);
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

        return view('analyst.s-handling', compact('dataPasien', 'dataPasienCito', 'dataHistory'));
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

        $request->validate([
            'no_lab' => 'required',
            'kapasitas' => 'required_without:serum|array',
            'serum' => 'required_without:kapasitas|array'
        ]);

        $no_lab = $request->input('no_lab');
        $kapasitas = $request->input('kapasitas');
        $serum = $request->input('serum');
        $notes = $request->input('note', []);

        if (!empty($kapasitas)) {
            foreach ($kapasitas as $x => $kapasitas) {
                spesimentCollection::create([
                    'no_lab' => $no_lab,
                    'tabung' => 'EDTA',
                    'kapasitas' => $kapasitas,
                    'status' => 'Acc',
                    'note' => $notes[$x] ?? null,
                    'tanggal' => now(),
                ]);

                historyPasien::create([
                    'no_lab' => $no_lab,
                    'proses' => 'Acc Collection',
                    'tempat' => 'Laboratorium',
                    'waktu_proses' => now(),
                ]);
            }
        }

        if (!empty($serum)) {
            foreach ($serum as $x => $serum) {
                spesimentHandling::create([
                    'no_lab' => $no_lab,
                    'tabung' => 'CLOT-ACT',
                    'serum' => $serum,
                    'status' => 'Acc',
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

        // Update pasien status
        pasien::where('no_lab', $no_lab)->update([
            'status' => 'Spesiment',
        ]);
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
        //
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

    public function postSpesiment(Request $request)
    {
        // dd($request->all());
        // $request->validate([
        //     'no_lab' => 'required',
        //     'kapasitas' => 'required|array',
        //     'serum' => 'required|array',
        //     'note' => 'nullable|array',
        // ]);

        // $no_lab = $request->input('no_lab');
        // $kapasitas = $request->input('kapasitas');
        // $serum = $request->input('serum');
        // $notes = $request->input('note', []);

        // // Loop through kapasitas array and create spesimentCollection records
        // foreach ($kapasitas as $x => $kapasitas) {
        //     spesimentCollection::create([
        //         'no_lab' => $no_lab,
        //         'tabung' => 'EDTA',
        //         'kapasitas' => $kapasitas,
        //         'status' => 'Acc',
        //         'note' => $notes[$x] ?? null,
        //         'tanggal' => now(),
        //     ]);

        //     historyPasien::create([
        //         'no_lab' => $no_lab,
        //         'proses' => 'Acc Collection',
        //         'tempat' => 'Laboratorium',
        //         'waktu_proses' => now(),
        //     ]);
        // }

        // // Loop through serum array and create spesimentHandling records
        // foreach ($serum as $x => $serum) {
        //     spesimentHandling::create([
        //         'no_lab' => $no_lab,
        //         'tabung' => 'CLOT-ACT',
        //         'serum' => $serum,
        //         'status' => 'Acc',
        //         'note' => $notes[$x] ?? null,
        //         'tanggal' => now(),
        //     ]);

        //     historyPasien::create([
        //         'no_lab' => $no_lab,
        //         'proses' => 'Acc Handling',
        //         'tempat' => 'Laboratorium',
        //         'waktu_proses' => now(),
        //     ]);
        // }

        // // Update pasien status
        // pasien::where('no_lab', $no_lab)->update([
        //     'status' => 'Spesiment',
        // ]);
        // toast('Berhasil Approve Spesiment', 'success');
        // return redirect()->route('spesiment.index');
    }

    public function checkin(Request $request)
    {
        // foreach ($request->pilihan as $pilihan) {

        //     pasien::where('no_lab', $pilihan)->update([
        //         'status' => 'Check in Spesiment',
        //     ]);

        //     historyPasien::create([
        //         'no_lab' => $pilihan,
        //         'proses' => 'Check in spesiment',
        //         'tempat' => 'Laboratorium',
        //         'note' => 'nullable',
        //         'waktu_proses' => now(),
        //     ]);
        // }
        // try {
        // $ids = $request->ids;
        // $kapasitas = $request->input('kapasitas');
        // $serum = $request->input('serum');
        // $notes = $request->input('note', []);

        // Ambil data pasien berdasarkan id
        // $pasiens = pasien::whereIn('id', $ids)->get();

        // foreach ($pasiens as $pasien) {

        //     // dd($pasien);
        //     // Cek apakah status pasien "waiting"
        //     if ($pasien->status == 'Check In') {
        //         // Simpan data ke spesimentCollection jika kapasitas ada
        //         foreach ($pasien->data_pemeriksaan_pasien as $pemeriksaan) {

        //             if ($pemeriksaan->id_departement == 1) {
        //                 // KONDISI UNTUK INPUT SPESIMENT COLLECTION
        //                 spesimentCollection::create([
        //                     'no_lab' => $pasien->no_lab,
        //                     'tabung' => 'EDTA',
        //                     'kapasitas' => 2, // 2 untuk normal dari tabel details
        //                     'status' => 'Acc',
        //                     'note' => null,
        //                     'tanggal' => now(),
        //                 ]);
        //                 $proses = 'Acc Collection';
        //             } else if ($pemeriksaan->id_departement == 2) {
        //                 // KONDISI UNTUK INPUT SPESIMENT HANDLING
        //                 spesimentHandling::create([
        //                     'no_lab' => $pasien->no_lab,
        //                     'tabung' => 'CLOT-ACT',
        //                     'serum' => 4, // 4 untuk normal dari tabel details
        //                     'status' => 'Acc',
        //                     'note' => null,
        //                     'tanggal' => now(),
        //                 ]);
        //                 $proses = 'Acc Handling';
        //             }

        //             historyPasien::create([
        //                 'no_lab' => $pasien->no_lab,
        //                 'proses' => 'Acc Collection',
        //                 'tempat' => 'Laboratorium',
        //                 'waktu_proses' => now(),
        //             ]);
        //         }
        //         // if (!empty($kapasitas)) {
        //         //     foreach ($kapasitas as $x => $kapasitas) {
        //         //         spesimentCollection::create([
        //         //             'no_lab' => $pasien->no_lab,
        //         //             'tabung' => 'EDTA',
        //         //             'kapasitas' => $kapasitas,
        //         //             'status' => 'Acc',
        //         //             'note' => $notes[$x] ?? null,
        //         //             'tanggal' => now(),
        //         //         ]);

        //         //         historyPasien::create([
        //         //             'no_lab' => $pasien->no_lab,
        //         //             'proses' => 'Acc Collection',
        //         //             'tempat' => 'Laboratorium',
        //         //             'waktu_proses' => now(),
        //         //         ]);
        //         //     }
        //         // }

        //         // // Simpan data ke spesimentHandling jika serum ada
        //         // if (!empty($serum)) {
        //         //     foreach ($serum as $x => $serum) {
        //         //         spesimentHandling::create([
        //         //             'no_lab' => $pasien->no_lab,
        //         //             'tabung' => 'CLOT-ACT',
        //         //             'serum' => $serum,
        //         //             'status' => 'Acc',
        //         //             'note' => $notes[$x] ?? null,
        //         //             'tanggal' => now(),
        //         //         ]);

        //         //         historyPasien::create([
        //         //             'no_lab' => $pasien->no_lab,
        //         //             'proses' => 'Acc Handling',
        //         //             'tempat' => 'Laboratorium',
        //         //             'waktu_proses' => now(),
        //         //         ]);
        //         //     }
        //         // }
        //     }
        // }

        //     pasien::whereIn('id', $ids)->update(['status' => 'Check In Spesiment']);

        //     foreach ($pasiens as $pasien) {

        //         historyPasien::create([
        //             'no_lab' => $pasien->no_lab,
        //             'proses' => 'Check in spesiment',
        //             'tempat' => 'Laboratorium',
        //             'waktu_proses' => now(),
        //             'created_at' => now(),
        //         ]);
        //     }


        //     toast('Pasien telah Check in dari Spesiment', 'success');
        //     return response()->json(['success' => 'Data berhasil Dikonfirmasi!']);
        // } catch (Exception $e) {
        //     return response()->json(['fail' => $e->getMessage()]);
        // }

        $ids = $request->ids;
        $pasiens = pasien::whereIn('id', $ids)->get();

        pasien::whereIn('id', $ids)->update(['status' => 'Check In Spesiment']);

        foreach ($pasiens as $pasien) {

            historyPasien::create([
                'no_lab' => $pasien->no_lab,
                'proses' => 'Check in spesiment',
                'tempat' => 'Laboratorium',
                'waktu_proses' => now(),
                'created_at' => now(),
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Pasien telah Check in dari Spesiment']);
        // toast('Pasien telah Check in dari Spesiment', 'success');
        // return back();

        // $request->validate([
        //     'pilihan' => 'required|array',
        //     'pilihan.*' => 'exists:pasiens,no_lab'
        // ]);

        // foreach ($request->pilihan as $pilihan) {
        //     pasien::where('no_lab', $pilihan)->update([
        //         'status' => 'Check in Spesiment',
        //     ]);

        //     historyPasien::create([
        //         'no_lab' => $pilihan,
        //         'proses' => 'Check in spesiment',
        //         'tempat' => 'Laboratorium',
        //         'note' => 'nullable',
        //         'waktu_proses' => now(),
        //     ]);


        //     toast('Pasien telah Check in dari Spesiment', 'success');
        //     return redirect()->route('spesiment.index');
        // }
    }
}
