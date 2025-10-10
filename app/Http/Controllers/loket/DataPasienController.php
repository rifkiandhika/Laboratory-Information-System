<?php

namespace App\Http\Controllers\loket;

use App\Http\Controllers\Controller;
use App\Models\DataAsuransi;
use App\Models\DataBpjs;
use App\Models\DataPasien;
use App\Models\historyPasien;
use App\Models\pasien;
use App\Models\pemeriksaan_pasien;
use Illuminate\Http\Request;

class DataPasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_pasien = DataPasien::paginate(10);

        return view('loket.data-pasien', compact('data_pasien'));
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
    public function show($id)
    {
        $pasien = DataPasien::with(['dataBpjs', 'dataAsuransi'])->findOrFail($id);
        return view('data_pasien.show', compact('pasien'));
    }

    public function updated(Request $request, $id)
    {
        $pasien = DataPasien::findOrFail($id);
        $pasien->update([
            'no_rm'         => $request->no_rm,
            'nik'           => $request->nik,
            'nama'          => $request->nama,
            'lahir'         => $request->lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telp'       => $request->no_telp,
            'alamat'        => $request->alamat,
        ]);

        $bpjs = DataBpjs::where('data_pasiens_id', $id)->first();
        if ($bpjs && $request->filled('no_bpjs')) {
            $bpjs->update(['no_bpjs' => $request->no_bpjs]);
        }

        $asuransiList = DataAsuransi::where('data_pasiens_id', $id)->get();

        if ($asuransiList->count() && $request->filled('penjamin')) {
            foreach ($asuransiList as $index => $asuransi) {
                if (isset($request->penjamin[$index])) {
                    $asuransi->update([
                        'penjamin'    => $request->penjamin[$index],
                        'no_penjamin' => $request->no_penjamin[$index] ?? null,
                    ]);
                }
            }
        }

        toast('Berhasil memperbarui data pasien', 'success');
        return redirect()->route('data-pasien.index');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = DataPasien::findOrFail($id);
        return response()->json($data);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request);
        $request->validate([
            'nik' => 'required',
            'nama' => 'required',
            'lahir' => 'required',
            'jenis_kelamin' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
        ]);

        $data_pasien = DataPasien::findOrFail($id);
        $data_pasien->nik = $request->nik;
        $data_pasien->nama = $request->nama;
        $data_pasien->lahir = $request->lahir;
        $data_pasien->jenis_kelamin = $request->jenis_kelamin;
        $data_pasien->no_telp = $request->no_telp;
        $data_pasien->alamat = $request->alamat;
        $data_pasien->save();

        toast('Data berhasil diperbarui!', 'success');
        return redirect()->route('data-pasien.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
