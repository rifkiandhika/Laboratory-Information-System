<?php

namespace App\Http\Controllers\pemeriksaan;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Pemeriksaan;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

class PemeriksaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pemeriksaans = Pemeriksaan::with('department')->get();
        $data['departments'] = Department::all();
        return view('pemeriksaan.index',$data, compact('pemeriksaans'));
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
        // dd($request);
        $request->validate([
            'nama_parameter' => 'required|unique:pemeriksaans,nama_parameter',
            'nama_pemeriksaan' => 'required|unique:pemeriksaans,nama_pemeriksaan',
            'id_departement' => 'required',
            'harga' => 'required',
            
        ]);
        Pemeriksaan::create($request->all());
        toast('Berhasil Menambahkan Data Pemeriksaan','success'); 
        error('data gagal dikirim', 'warning');
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
            'nama_parameter' => 'required',
            'nama_pemeriksaan' => 'required',
            'id_departement' => 'required',
            'harga' => 'required',
        ]);
        
        $pemeriksaans = Pemeriksaan::findOrfail($id);
        // dd($id);
        $pemeriksaans->nama_parameter = $request->nama_parameter;
        $pemeriksaans->nama_pemeriksaan = $request->nama_pemeriksaan;
        $pemeriksaans->id_departement = $request->id_departement;
        $pemeriksaans->harga = $request->harga;
        $pemeriksaans->save();

        toast('Data Berhasil di Update', 'success');
        return redirect()->route('pemeriksaan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pemeriksaans = Pemeriksaan::findOrFail($id);
        $pemeriksaans->delete();

        toast('Data Berhasi Di Hapus', 'success');
        return redirect()->route('pemeriksaan.index');
    }
}
