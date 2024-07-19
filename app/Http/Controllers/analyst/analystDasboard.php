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
        $pasienharian=pasien::where('created_at',now())->get();
        $dataPasien = pasien::where(function($query) {
                        $query->where('status', 'Telah Dikirim ke Lab')
                            ->orWhere('status', 'Disetujui oleh analis lab');
                    })
                    ->where('cito', 0)
                    ->get();

        $dataPasienCito = pasien::where(function($query) {
                            $query->where('status', 'Telah Dikirim ke Lab')
                                ->orWhere('status', 'Disetujui oleh analis lab');
                        })
                        ->where('cito', 1)
                        ->get();

        $dataHistory = historyPasien::where('proses', '=', 'order')->get();

        return view('analyst.dashboard', compact('dataPasien','pasienharian', 'dataPasienCito', 'dataHistory'));
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

        DB::table('history_pasiens')->insert([
            'no_lab' => $request->no_lab,
            'proses' => 'Disetujui oleh analis lab',
            'tempat' => 'Laboratorium',
            'note' => $request->note,
            'waktu_proses' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        toast('Data di setujui','success');
        return redirect()->route('analyst.index');
    }

    public function checkin(Request $request,$id)
    {

        // foreach($request->pilihan as $pilihan){
        //     DB::table('pasiens')->where('no_lab', $pilihan)->update([
        //         'status' => 'Check in',
        //     ]);

        //     historyPasien::create([
        //         'no_lab' => $request->no_lab,
        //         'proses' => 'Check in',
        //         'tempat' => 'Laboratorium',
        //         'note' => $request->note,
        //         'waktu_proses' => now(),
        //     ]);
        // }

            pasien::find($id)->update([
                'status' => 'Check In'
            ]);
            $no_lab=pasien::find($id)->first();
            historyPasien::create([
                'no_lab' => $no_lab->no_lab,
                'proses' => 'Check in',
                'tempat' => 'Laboratorium',
                'note' => $request->note,
                'waktu_proses' => now(),
            ]);
        toast('Pasien telah Check in','success');
        return redirect()->route('analyst.index');
    }
}
