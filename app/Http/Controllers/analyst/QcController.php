<?php

namespace App\Http\Controllers\analyst;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\pasien;
use App\Models\quality_control;
use Exception;
use Illuminate\Http\Request;

class QcController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $department = Department::all();
        $qcs = quality_control::with('department')->get();

        return view('analyst.quality-control', compact('department', 'qcs'));
    }

    public function getdepartment($department_id)
    {
        $quality_control = quality_control::where('department_id', $department_id)->get();


        return view('analyst.quality-control', compact('quality_control'));
    }

    public function getDataQc(Request $request, $id)
    {
        try {
            // Ambil data QC berdasarkan id yang diberikan, beserta relasi yang mungkin diperlukan
            $data_qc = quality_control::where('id', $id)
                ->with([
                    'department',  // Jika ada relasi ke departemen
                ])
                ->first();

            // Cek apakah data QC ditemukan
            if (!$data_qc) {
                return response()->json([
                    'status' => 'fail',
                    'msg' => 'Data QC tidak ditemukan'
                ], 404);
            }

            // Jika data ditemukan, kembalikan dalam bentuk JSON
            return response()->json([
                'status' => 'success',
                'msg' => 'Data QC ditemukan',
                'data' => $data_qc
            ], 200);
        } catch (Exception $e) {
            // Jika terjadi error, kembalikan status fail
            return response()->json([
                'status' => 'fail',
                'msg' => 'Terjadi kesalahan saat mengambil data QC'
            ], 500);
        }
    }


    // public function daftar()
    // {

    //     return view('analyst.daftar-qc');
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        quality_control::create($request->all());

        toast('Berhasil Menambahkan QC!!', 'success');
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
