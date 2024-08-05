<?php

namespace App\Http\Controllers\department;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\DetailDepartment;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::with('detailDepartments')->paginate(20);
        return view('department.index', compact('departments'));
    }

    public function data()
    {
        $departments = Department::all();
        return response()->json($departments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('department.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'nama_department' => 'required|unique:departments,nama_department',
            'kode.*' => 'required',
            'nama_parameter.*' => 'required',
            'nama_pemeriksaan.*' => 'required',
            'harga.*' => 'required',
            'nilai_statik.*' => 'required',
            'nilai_satuan.*' => 'required',
        ]);

        $departments = Department::create([
            'nama_department' => $request->nama_department,
        ]);


        $array_length = count($request->nama_parameter);

        for ($x = 0; $x < $array_length; $x++) {
            // Pastikan semua elemen array ada
            if (
                isset($request->kode[$x]) &&
                isset($request->nama_parameter[$x]) &&
                isset($request->nama_pemeriksaan[$x]) &&
                isset($request->harga[$x]) &&
                isset($request->nilai_statik[$x]) &&
                isset($request->nilai_satuan[$x])
            ) {
                // Tambahkan detail baru
                try {
                    $departments->detailDepartments()->create([
                        'kode' => $request->kode[$x],
                        'nama_parameter' => $request->nama_parameter[$x],
                        'nama_pemeriksaan' => $request->nama_pemeriksaan[$x],
                        'harga' => $request->harga[$x],
                        'nilai_statik' => $request->nilai_statik[$x],
                        'nilai_satuan' => $request->nilai_satuan[$x],
                    ]);
                } catch (Exception $e) {
                    dd($e->getMessage());
                }
            } else {
                // Log data yang hilang untuk debugging
                dd("Missing data at index $x");
            }
        }
        toast('Berhasil Menambahkan Data Department', 'success');
        return redirect()->route('department.index');
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
        $departments = Department::with('detailDepartments')->findOrFail($id);
        return view('department.edit', compact('departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi data input
        $request->validate([
            'nama_department' => 'required|unique:departments,nama_department,' . $id,
            'kode.*' => 'required',
            'nama_parameter.*' => 'required',
            'nama_pemeriksaan.*' => 'required',
            'harga.*' => 'required',
            'nilai_statik.*' => 'required',
            'nilai_satuan.*' => 'required',
        ]);

        // Temukan department berdasarkan ID
        $departments = Department::findOrFail($id);

        // Update nama department
        $departments->update([
            'nama_department' => $request->nama_department,
        ]);

        // Hapus detail lama
        $departments->detailDepartments()->delete();

        // Tambahkan detail baru
        $array_length = count($request->nama_parameter);
        for ($x = 0; $x < $array_length; $x++) {
            if (
                isset($request->kode[$x]) &&
                isset($request->nama_parameter[$x]) &&
                isset($request->nama_pemeriksaan[$x]) &&
                isset($request->harga[$x]) &&
                isset($request->nilai_statik[$x]) &&
                isset($request->nilai_satuan[$x])
            ) {
                $detail = new DetailDepartment();
                $detail->department_id = $departments->id;
                $detail->kode = $request->kode[$x];
                $detail->nama_parameter = $request->nama_parameter[$x];
                $detail->nama_pemeriksaan = $request->nama_pemeriksaan[$x];
                $detail->harga = $request->harga[$x];
                $detail->nilai_statik = $request->nilai_statik[$x];
                $detail->nilai_satuan = $request->nilai_satuan[$x];
                $detail->save();
            }
        }

        toast('Berhasil Memperbarui Data Department', 'success');
        return redirect()->route('department.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $departments = Department::with('detailDepartments')->findOrFail($id);
        if ($departments->pemeriksaan()->count() > 0 || $departments->spesiment()->count() > 0) {
            Alert::error('Error', 'Tidak bisa menghapus department yang masih memiliki pemeriksaan.');
            return redirect()->route('department.index');
        }
        // Hapus Detail Department
        $departments->detailDepartments()->delete();
        // Jika tidak ada pemeriksaan berelasi, hapus department
        $departments->delete();

        toast('Data Berhasi Di Hapus', 'success');
        return redirect()->route('department.index');
    }
}
