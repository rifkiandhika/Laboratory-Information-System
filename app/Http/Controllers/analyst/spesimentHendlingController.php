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

class spesimentHendlingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataPasien = pasien::where(function($query) {
                        $query->where('status', 'Check in')
                            ->orWhere('status', 'Spesiment');
                    })
                    ->where('cito', 0)
                    ->get();

        $dataPasienCito = pasien::where(function($query) {
                        $query->where('status', 'Check in')
                            ->orWhere('status', 'Spesiment');
                    })
                    ->where('cito', 1)
                    ->get();

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

    public function postSpesiment(Request $request)
    {
        $tabung = [];
        $tabung = $request->tabung;

        $tanggalCollection = Carbon::parse($request->tanggal_collection)->format('Y-m-d H:i');
        $tanggalHandling = Carbon::parse($request->tanggal_handling)->format('Y-m-d H:i');

        for($i = 0; $i < count($tabung); $i++) {
            $noteCollection = $request->{"note_kapasitas_".$tabung[$i]};
            $noteHandling = $request->{"note_serum_".$tabung[$i]};

            DB::table('spesiment_collections')->insert([
                'no_lab' => $request->no_lab,
                'tabung' => $tabung[$i],
                'kapasitas' => $request->{"kapasitas_".$tabung[$i]},
                'status' => "Acc",
                'note' => $noteCollection,
                'tanggal' => $tanggalCollection,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            DB::table('spesiment_handlings')->insert([
                'no_lab' => $request->no_lab,
                'tabung' => $tabung[$i],
                'serum' => $request->{"serum_".$tabung[$i]},
                'status' => "Acc",
                'note' => $noteHandling,
                'tanggal' => $tanggalHandling,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            historyPasien::create([
                'no_lab' => $request->no_lab,
                'proses' => 'Acc Collection',
                'tempat' => 'Laboratorium',
                'waktu_proses' => now(),
            ]);

            historyPasien::create([
                'no_lab' => $request->no_lab,
                'proses' => 'Acc Handling',
                'tempat' => 'Laboratorium',
                'waktu_proses' => now(),
            ]);
        };

        pasien::where('no_lab', $request->no_lab)->update([
            'status' => 'Spesiment',
        ]);

        toast('Berhasil Approve Spesiment','success');
        return redirect()->route('spesiment.index');
    }
    public function checkin(Request $request)
    {

        foreach($request->pilihan as $pilihan){

            DB::table('pasiens')->where('no_lab', $pilihan)->update([
                'status' => 'Check in spesiment',
            ]);

            historyPasien::create([
                'no_lab' => $pilihan,
                'proses' => 'Check in spesiment',
                'tempat' => 'Laboratorium',
                'note' => $request->note,
                'waktu_proses' => now(),
            ]);
        }

        toast('Pasien telah Check in dari Spesiment','success');
        return redirect()->route('spesiment.index');
    }
}
