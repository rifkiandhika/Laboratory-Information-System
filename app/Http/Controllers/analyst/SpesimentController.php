<?php

namespace App\Http\Controllers\analyst;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\DetailSpesiment;
use App\Models\Spesiment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class SpesimentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $spesiments = Spesiment::paginate(20);
        $departments = Department::paginate(20);
        $detail = DetailSpesiment::paginate(20);
        return view('spesiment.index', compact('spesiments', 'departments', 'detail'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $departments = Department::all();
        return view('spesiment.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate(
            [
                'id_departement' => 'required',
                'spesiment' => 'required|unique:spesiments,spesiment',
                'note' => 'nullable',
                'nama_parameter.*' => 'required',
                // 'nama_parameter.*' => 'required|string',
                'gambar.*' => 'required',
                // 'gambar.*' => 'required|string',
            ],
            [
                'gambar.required' => 'Add a image!!'
            ]
        );

        $spesiments = Spesiment::create([
            'id_departement' => $request->id_departement,
            'spesiment' => $request->spesiment,
            'note' => $request->note,
        ]);

        foreach ($request->nama_parameter as $x => $nama_parameter) {
            try {
                $name = null;

                if ($request->hasFile('gambar') && isset($request->gambar[$x])) {
                    $files = $request->file('gambar')[$x];
                    $extension = $files->getClientOriginalExtension();
                    $name = hash('sha256', time() . $x) . '.' . $extension;
                    $files->move(public_path('gambar'), $name);
                }

                $spesiments->details()->create([
                    'nama_parameter' => $nama_parameter,
                    'gambar' => $name,
                ]);
            } catch (Exception $e) {
                dd($e->getMessage());
            }
        }
        toast('Berhasil Menambahkan Data Spesiment', 'success');
        return redirect()->route('spesiments.index');
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
        $spesiments = Spesiment::with('details')->findOrFail($id);
        $departments = Department::paginate(20);
        return view('spesiment.edit', compact('spesiments', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_departement' => 'required',
            'spesiment' => 'required|unique:spesiments,spesiment,' . $id,
            'note' => 'nullable',
            'nama_parameter.*' => 'required',
            'gambar.*' => 'nullable',
        ]);

        $spesiments = Spesiment::findOrFail($id);
        $spesiments->update([
            'id_departement' => $request->id_departement,
            'spesiment' => $request->spesiment,
            'note' => $request->note,
        ]);

        foreach ($request->nama_parameter as $x => $nama_parameter) {
            $detail = $spesiments->details[$x] ?? new DetailSpesiment();
            $detail->spesiment_id = $spesiments->id;
            $detail->nama_parameter = $nama_parameter;

            if (isset($request->file('gambar')[$x])) {
                $file = $request->file('gambar')[$x];
                $extension = $file->getClientOriginalExtension();
                $name = hash('sha256', time() . $x) . '.' . $extension;
                $file->move(public_path('gambar'), $name);

                // Menghapus gambar lama
                if ($detail->exists && $detail->gambar) {
                    File::delete(public_path('gambar/' . $detail->gambar));
                }
                $detail->gambar = $name;
            }
            $detail->save();
        }
        toast('Berhasil update data spesiment', 'success');
        return redirect()->route('spesiments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $spesiments = Spesiment::with('details')->findOrFail($id);

        // Menghapus gambar dari setiap detail
        foreach ($spesiments->details as $detail) {
            if ($detail->gambar && File::exists(public_path('gambar/' . $detail->gambar))) {
                File::delete(public_path('gambar/' . $detail->gambar));
            }
            // menghapus detail dari details spesiment
            $detail->delete();
        }

        // menghapus data dari database spesiment
        $spesiments->delete();

        toast('Data Berhasil di Hapus', 'success');
        return redirect()->route('spesiments.index');
    }
}
