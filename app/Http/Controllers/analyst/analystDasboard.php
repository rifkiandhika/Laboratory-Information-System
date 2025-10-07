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

        $dataPasien = pasien::whereIn('status', ['Telah Dikirim ke Lab', 'Dikembalikan AnalystS'])
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
        // Validasi input
        $request->validate([
            'no_lab' => 'required',
            'kapasitas' => 'nullable|array',
            'serumh' => 'nullable|array',
            'clotact' => 'nullable|array',
            'note' => 'nullable|array',
            'kode' => 'nullable|array',
        ]);

        // Ambil input dari request
        $no_lab = $request->input('no_lab');
        $kapasitas = $request->input('kapasitas', []);
        $serumh   = $request->input('serumh', []);
        $clotact  = $request->input('clotact', []);
        $notes    = $request->input('note', []);
        $kode     = $request->input('kode', []);

        // Hapus data lama sebelum memasukkan data baru
        spesimentCollection::where('no_lab', $no_lab)->delete();

        // Simpan data baru untuk kapasitas (tabung K3-EDTA)
        foreach ($kapasitas as $i => $kap) {
            spesimentCollection::create([
                'no_lab'    => $no_lab,
                'kode'      => $kode[$i] ?? null,
                'tabung'    => 'K3-EDTA',
                'kapasitas' => $kap,
                'status'    => 'Acc',
                'note'      => $notes[$i] ?? null,
                'tanggal'   => now(),
            ]);

            historyPasien::create([
                'no_lab'       => $no_lab,
                'proses'       => 'Acc Collection',
                'tempat'       => 'Laboratorium',
                'waktu_proses' => now(),
            ]);
        }

        // Simpan data baru untuk serumh (tabung CLOTH-ACTIVATOR)
        foreach ($serumh as $j => $ser) {
            spesimentCollection::create([
                'no_lab'   => $no_lab,
                'kode'     => $kode[$j] ?? null,
                'tabung'   => 'CLOTH-ACTIVATOR',
                'serumh'   => $ser,
                'status'   => 'Acc',
                'note'     => $notes[$j] ?? null,
                'tanggal'  => now(),
            ]);

            historyPasien::create([
                'no_lab'       => $no_lab,
                'proses'       => 'Acc Collection',
                'tempat'       => 'Laboratorium',
                'waktu_proses' => now(),
            ]);
        }

        // (opsional) clotact kalau mau dipakai nanti

        // Update status pasien berdasarkan handling active
        $pasien = pasien::where('no_lab', $no_lab)
            ->with('data_pemeriksaan_pasien.data_pemeriksaan')
            ->first();

        if ($pasien) {
            $has_handling_active = false;

            foreach ($pasien->data_pemeriksaan_pasien as $pemeriksaan) {
                $detail = $pemeriksaan->data_pemeriksaan;
                if (!$detail) continue;

                if (strtolower(trim((string) $detail->handling)) === 'active') {
                    $has_handling_active = true;
                    break;
                }
            }

            if ($has_handling_active) {
                $pasien->status = 'Acc Collection';
                historyPasien::create([
                    'no_lab'       => $no_lab,
                    'proses'       => 'Pasien Check In',
                    'tempat'       => 'Laboratorium',
                    'waktu_proses' => now(),
                ]);
            } else {
                $pasien->status = 'Check In Spesiment';
                historyPasien::create([
                    'no_lab'       => $no_lab,
                    'proses'       => 'Check In Spesiment',
                    'tempat'       => 'Worklist',
                    'waktu_proses' => now(),
                ]);
            }

            $pasien->save();
        }

        // Tampilkan notifikasi sukses dan redirect
        toast('Berhasil Approve Spesimen', 'success');
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
        $pasiens = pasien::whereIn('id', $ids)
            ->with('data_pemeriksaan_pasien.data_pemeriksaan')
            ->get();

        foreach ($pasiens as $pasien) {
            $has_handling_active = false;

            foreach ($pasien->data_pemeriksaan_pasien as $pemeriksaan) {
                $detail = $pemeriksaan->data_pemeriksaan;
                if (!$detail) continue;

                $handling = strtolower(trim((string) $detail->handling)) === 'active';

                if ($handling) {
                    $has_handling_active = true;
                    break; // cukup satu yang active, langsung true
                }
            }

            if ($has_handling_active) {
                $status = 'Check In';
                $proses = 'Pasien Check In';
                $tempat = 'Laboratorium';
            } else {
                $status = 'Check In Spesiment';
                $proses = 'Check In Spesiment';
                $tempat = 'Worklist';
            }

            // Update status pasien
            $pasien->update(['status' => $status]);

            // Simpan history
            historyPasien::create([
                'no_lab'       => $pasien->no_lab,
                'proses'       => $proses,
                'tempat'       => $tempat,
                'waktu_proses' => now(),
                'created_at'   => now(),
            ]);
        }

        toast('Pasien telah Check in', 'success');
        return response()->json(['success' => 'Data berhasil dikonfirmasi!']);
    }
}
