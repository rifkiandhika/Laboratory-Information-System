<?php

namespace App\Http\Controllers\loket;

use App\Http\Controllers\Controller;
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
    public function show(string $id)
    {
        //
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
