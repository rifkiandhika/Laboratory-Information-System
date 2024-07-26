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
        $dokters = dokter::with('poli')->get();
        $data['polis'] = Poli::all();
        return view("dokter.index", $data,  compact('dokters'));
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
            'kode_dokter' => 'required|unique:dokters,kode_dokter',
            'nama_dokter' => 'required|unique:dokters,nama_dokter',
            'id_poli' => 'required',
            'no_telp' => 'required|unique:dokters,no_telp',
            'email' => 'required|unique:dokters,email'
        ]);
        dokter::create($request->all());
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
            'kode_dokter' => ['required', Rule::unique('dokters')->ignore($id)],
            'nama_dokter' => 'required',
            'id_poli' => 'required',
            'no_telp' => ['required', Rule::unique('dokters')->ignore($id)],
            'email' => ['required', Rule::unique('dokters')->ignore($id)],
        ]);

        $dokters = dokter::findOrfail($id);
        // dd($id);
        $dokters->kode_dokter = $request->kode_dokter;
        $dokters->nama_dokter = $request->nama_dokter;
        $dokters->id_poli = $request->id_poli;
        $dokters->no_telp = $request->no_telp;
        $dokters->email = $request->email;
        $dokters->save();

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
            return redirect()->route('department.index');
        }

        $dokters->delete();

        toast('Data Berhasil di Hapus', 'success');
        return redirect()->route('dokter.index');
    }
}
