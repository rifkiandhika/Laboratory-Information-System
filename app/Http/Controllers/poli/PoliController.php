<?php

namespace App\Http\Controllers\poli;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PoliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $polis = Poli::get();
        return view("poli.index", compact('polis'));
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
            'kode' => 'required',
            'nama_poli' => 'required|unique:polis,nama_poli',
            'status' => 'required',

        ]);
        Poli::create($request->all());
        toast('Berhasil Menambahkan Data Poli', 'success');
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
            'kode' => 'required',
            'nama_poli' => 'required',
            'status' => 'required',
        ]);

        $polis = Poli::findOrfail($id);
        // dd($id);
        $polis->kode = $request->kode;
        $polis->nama_poli = $request->nama_poli;
        $polis->status = $request->status;
        $polis->save();

        toast('Data Berhasil di Update', 'success');
        return redirect()->route('poli.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $polis = Poli::findOrFail($id);
        if ($polis->dokters()->count() > 0) {
            Alert::error('Error', 'Tidak bisa menghapus Poli yang sudah berkaitan dengan Dokter.');
            return redirect()->route('poli.index');
        }

        // Jika tidak ada pemeriksaan berelasi, hapus department
        $polis->delete();

        toast('Data Berhasi Di Hapus', 'success');
        return redirect()->route('poli.index');
    }
}
