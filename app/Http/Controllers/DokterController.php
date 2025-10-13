<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\dokter;
use App\Models\Poli;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokters = Dokter::all();
        $polis = Poli::all();
        return view("dokter.index", compact('dokters', 'polis'));
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
        $request->validate([
            'kode_dokter' => 'required',
            'nama_dokter' => 'required|unique:dokters,nama_dokter',
            'nip' => 'required',
            'id_poli' => 'required|array',
            'poli' => 'required',
            'status' => 'required',
            'jabatan' => 'required',
            'no_telp' => 'required|unique:dokters,no_telp',
            'email' => 'required|unique:dokters,email'
        ]);

        dokter::create([
            'kode_dokter' => $request->kode_dokter,
            'nama_dokter' => $request->nama_dokter,
            'nip' => $request->nip,
            'id_poli' => json_encode($request->id_poli),
            'poli' => $request->poli,
            'status' => $request->status,
            'jabatan' => $request->jabatan,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
        ]);

        toast('Berhasil Menambahkan Data Dokter', 'success');
        return back();
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
            'kode_dokter' => 'required',
            'nip' => 'required',
            'nama_dokter' => 'required',
            'id_poli' => 'required|array',
            'poli' => 'required',
            'status' => 'required',
            'jabatan' => 'required',
            'no_telp' => 'required',
            'email' => 'required',
        ]);

        $dokters = dokter::findOrfail($id);
        // dd($id);
        $dokters->update([
            'kode_dokter' => $request->kode_dokter,
            'nip' => $request->nip,
            'nama_dokter' => $request->nama_dokter,
            'id_poli' => json_encode($request->id_poli),
            'poli' => $request->poli,
            'status' => $request->status,
            'jabatan' => $request->jabatan,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
        ]);

        toast('Data Berhasil di Update', 'success');
        return redirect()->route('dokter.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dokters = dokter::findOrFail($id);
        if ($dokters->pasien()->count() > 0) {
            Alert::error('Error', 'Tidak bisa menghapus dokter yang masih memiliki pemeriksaan.');
            return redirect()->route('dokter.index');
        }

        $dokters->delete();

        toast('Data Berhasil di Hapus', 'success');
        return redirect()->route('dokter.index');
    }
}
