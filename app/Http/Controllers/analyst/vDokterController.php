<?php

namespace App\Http\Controllers\analyst;

use App\Http\Controllers\Controller;
use App\Models\historyPasien;
use App\Models\pasien;
use Illuminate\Http\Request;

class vDokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $dataPasien = pasien::where(function ($query) {
        //     $query->where('status', 'Verifikasi Dokter');
        // })->get();

        $dataPasien = pasien::where('status', 'Verifikasi Dokter')->orderBy('cito', 'desc')->paginate(20);

        $verifikasi = pasien::where('status', 'Diverifikasi Ulang')->orderBy('cito', 'desc')->paginate(20);

        return view('analyst.main-dokter', compact('dataPasien', 'verifikasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
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
        $pasien->update(['status' => 'Dikembalikan']);

        historyPasien::create([
            'no_lab' => $pasien->no_lab,
            'proses' => 'Dikembalikan oleh dokter',
            'tempat' => 'Laboratorium',
            'note' => $request->input('note'),
            'waktu_proses' => now(),
            'created_at' => now(),
        ]);

        toast('Data telah dikembalikan untuk dicek kembali', 'success');
        return redirect()->route('vdokter.index');
    }

    public function sentToReview($id)
    {
        $data_pasien = pasien::find($id);

        $data_pasien->update(['status' => 'Result Review']);

        historyPasien::create([
            'no_lab' => $data_pasien->no_lab,
            'proses' => 'Diverifikasi Oleh Dokter',
            'tempat' => 'Laboratorium',
            'waktu_proses' => now(),
            'created_at' => now(),
        ]);

        toast('Data Berhasil Diselesaikan', 'success');
        return redirect()->route('vdokter.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
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
}
