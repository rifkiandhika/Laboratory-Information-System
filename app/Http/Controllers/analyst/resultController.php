<?php

namespace App\Http\Controllers\analyst;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\HasilPemeriksaan;
use App\Models\historyPasien;
use App\Models\pasien;
use App\Models\pemeriksaan_pasien;
use Illuminate\Http\Request;

class resultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $dataPasien = pasien::where('status', 'Result Review')->orWhere('status', 'Spesiment')->where('cito', 0)->paginate(20);
        $dataPasien = pasien::whereIn('status', ['Result Review', 'diselesaikan'])
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        $dataHistory = historyPasien::where('proses', '=', 'order')->get();
        return view('analyst.result-review', compact('dataPasien', 'dataHistory'));
    }

    public function updateStatus($id)
    {
        // Temukan data pasien berdasarkan ID
        $pasien = pasien::findOrFail($id);

        // Update status pasien menjadi "diselesaikan"
        $pasien->status = 'diselesaikan';
        $pasien->save();

        // Kembalikan respon (misalnya redirect ke halaman sebelumnya)
        toast('Pasien telah diselesaikan', 'success');
        return redirect()->route('result.index');
    }

    public function print($no_lab, Request $request)
    {

        // return view('print-view.print-pasien');
        // dd('Fungsi print berhasil dipanggil');
        // dd($request);
        $note = $request->input('note');
        // $data_pasien = pasien::with(['data_pemeriksaan_pasien.data_departement', 'dpp.pasiens', 'hasil_pemeriksaan'])->where('no_lab', $no_lab)->first();
        $data_pasien = pasien::where('no_lab', $no_lab)->with([
            'dpp.pasiens' => function ($query) use ($no_lab) {
                $query->where('no_lab', $no_lab);
                $query->with('data_pemeriksaan');
            },
            'dpp.data_departement',
            'dokter',
            'hasil_pemeriksaan'
        ])->first();
        $hasil_pemeriksaans = HasilPemeriksaan::where('no_lab', $no_lab)->get();
        return view('print-view.print-pasien', compact('data_pasien', 'note', 'hasil_pemeriksaans'));
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
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        return view('print-view.print-pasien', compact('id'));
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
