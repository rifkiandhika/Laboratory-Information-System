<?php

namespace App\Http\Controllers\department;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::paginate(20);
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'nama_department' => 'required|unique:departments,nama_department',
        ]);
        Department::create($request->all());
        toast('Berhasil Menambahkan Data Department', 'success');
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
            'nama_department' => 'required',
        ]);

        $departments = Department::findOrfail($id);
        // dd($id);
        $departments->nama_department = $request->nama_department;
        $departments->save();

        toast('Data Berhasil di Update', 'success');
        return redirect()->route('department.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $departments = Department::findOrFail($id);
        if ($departments->pemeriksaan()->count() > 0) {
            Alert::error('Error', 'Tidak bisa menghapus department yang masih memiliki pemeriksaan.');
            return redirect()->route('department.index');
        }

        // Jika tidak ada pemeriksaan berelasi, hapus department
        $departments->delete();

        toast('Data Berhasi Di Hapus', 'success');
        return redirect()->route('department.index');
    }
}
