<?php

namespace App\Http\Controllers\analyst;

use App\Http\Controllers\Controller;
use App\Models\historyPasien;
use App\Models\pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class analystDasboard extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pasienharian = pasien::where('created_at', now())->get();
        $dataPasien = pasien::where('status', 'Telah Dikirim ke Lab')
            ->orWhere('status', 'Disetujui oleh analis lab')->orderby('cito', 'desc')->get();

        $dataPasienCito = pasien::where(function ($query) {
            $query->where('status', 'Telah Dikirim ke Lab')
                ->orWhere('status', 'Disetujui oleh analis lab');
        })
            ->where('cito', 1)
            ->get();

        $dataHistory = historyPasien::where('proses', '=', 'order')->get();

        return view('analyst.dashboard', compact('dataPasien', 'pasienharian', 'dataPasienCito', 'dataHistory'));
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
                'proses' => 'Disetujui oleh analis lab',
                'tempat' => 'Laboratorium',
                'waktu_proses' => now(),
                'created_at' => now(),
            ]);
        }
        toast('Pasien telah Check in', 'success');
        return response()->json(['success' => 'Data berhasil Dikonfirmasi!']);
    }
}
