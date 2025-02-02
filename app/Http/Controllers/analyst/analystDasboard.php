<?php

namespace App\Http\Controllers\analyst;

use App\Http\Controllers\Controller;
use App\Models\historyPasien;
use App\Models\pasien;
use App\Models\pembayaran;
use App\Models\pemeriksaan_pasien;
use App\Models\spesimentCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class analystDasboard extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pasienharian = pasien::where('created_at', now())->count();

        $bl = pasien::where('status', 'Telah Dikirim ke Lab')->count();
        // $dl = pasien::where('status', 'Acc Collection')->count();
        // $dataPasien = pasien::where('status', 'Telah Dikirim ke Lab')
        //     ->orWhere('status', 'Disetujui oleh analis lab')->orderby('cito', 'desc')->get();

        $dataPasien = pasien::whereIn('status', ['Telah Dikirim ke Lab', 'Dikembalikan Analyst'])
            ->orderBy('cito', 'desc')
            ->get();

        $dataPasienCito = pasien::where(function ($query) {
            $query->where('status', 'Telah Dikirim ke Lab')
                ->orWhere('status', 'Disetujui oleh analis lab');
        })
            ->where('cito', 1)
            ->get();

        $dataHistory = historyPasien::where('proses', '=', 'order')->get();

        return view('analyst.dashboard', compact('dataPasien', 'pasienharian', 'dataPasienCito', 'dataHistory', 'bl'));
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
        // Validasi data request
        // dd($request)->all();
        $request->validate([
            'no_lab' => 'required',
            'kapasitas' => 'required_without:serum|array',
        ]);

        // Ambil input dari request
        $no_lab = $request->input('no_lab');
        $kapasitas = $request->input('kapasitas');
        // $serumh = $request->input('serumh');
        $notes = $request->input('note', []);

        // Menghapus data lama sebelum memasukkan data baru
        spesimentCollection::where('no_lab', $no_lab)->delete();  // Hapus semua data spesimen yang terkait dengan no_lab
        // historyPasien::where('no_lab', $no_lab)->delete(); // Hapus history pasien terkait no_lab

        // Jika ada kapasitas, simpan data baru untuk tabung EDTA
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

        // Jika ada serumh, simpan data baru untuk tabung K3
        // if (!empty($serumh)) {
        //     foreach ($serumh as $x => $serumh) {
        //         spesimentCollection::create([
        //             'no_lab' => $no_lab,
        //             'tabung' => 'K3',
        //             'serumh' => $serumh,
        //             'status' => 'Acc',
        //             'note' => $notes[$x] ?? null,
        //             'tanggal' => now(),
        //         ]);
        //     }
        // }

        // Update status pasien menjadi 'Acc Collection'
        $pasien = pasien::where('no_lab', $request->no_lab)->first();
        $pasien->status = $request->status;
        $pasien->save();

        // Berikan notifikasi sukses
        toast('Berhasil Approve Spesiment', 'success');

        // Redirect ke halaman analyst.index
        return redirect()->route('analyst.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
        $pasien->update(['status' => 'Dikembalikan Analyst']);

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
        return redirect()->route('analyst.index');
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
            return redirect()->route('analyst.index');
        }
        toast('Tidak dapat menghapus data yang sudah diverifikasi', 'error');
    }

    public function approve(Request $request)
    {
        DB::table('pasiens')->where('no_lab', $request->no_lab)->update([
            'status' => 'Disetujui oleh analis lab',
        ]);
        if (isset($request->note)) {

            DB::table('history_pasiens')->insert([
                'no_lab' => $request->no_lab,
                'proses' => 'Disetujui oleh analis lab',
                'tempat' => 'Laboratorium',
                'note' => $request->note,
                'waktu_proses' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            DB::table('history_pasiens')->insert([
                'no_lab' => $request->no_lab,
                'proses' => 'Disetujui oleh analis lab',
                'tempat' => 'Laboratorium',
                'waktu_proses' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        toast('Data di setujui', 'success');
        return redirect()->route('analyst.index');
    }

    public function checkinall(Request $request)
    {
        $ids = $request->ids;
        pasien::whereIn('id', $ids)->update(['status' => 'Check In']);
        $pasien = pasien::whereIn('id', $ids)->get();

        foreach ($pasien as $pasiens) {

            historyPasien::create([
                'no_lab' => $pasiens->no_lab,
                'proses' => 'Dikirim ke spesiment',
                'tempat' => 'Laboratorium',
                'waktu_proses' => now(),
                'created_at' => now(),
            ]);
        }
        toast('Pasien telah Check in', 'success');
        return response()->json(['success' => 'Data berhasil Dikonfirmasi!']);
    }
}
