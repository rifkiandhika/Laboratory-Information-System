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
        // Validasi data
        // dd($request);
        $request->validate([
            'nama_department' => 'required|unique:departments,nama_department',
            'kode_hidden.*' => 'required', // Memastikan kode_hidden diterima
            'nama_parameter.*' => 'required',
            'nama_pemeriksaan.*' => 'required',
            'harga.*' => 'required',
            'jasa_sarana.*' => 'nullable',
            'jasa_pelayanan.*' => 'nullable',
            'jasa_dokter.*' => 'nullable',
            'jasa_bidan.*' => 'nullable',
            'jasa_perawat.*' => 'nullable',
            'nilai_rujukan.*' => 'required',
            'nilai_satuan.*' => 'required',
            'tipe_inputan.*' => 'required',
            'opsi_output.*' => 'required',
            'urutan.*' => 'required',
        ]);

        // Membuat department baru
        $departments = Department::create([
            'nama_department' => $request->nama_department,
        ]);

        // Menghitung panjang array parameter
        $array_length = count($request->nama_parameter);

        // Looping data untuk setiap detail
        for ($x = 0; $x < $array_length; $x++) {
            // Pastikan semua data ada untuk setiap index
            if (
                isset($request->kode_hidden[$x]) &&
                isset($request->nama_parameter[$x]) &&
                isset($request->nama_pemeriksaan[$x]) &&
                isset($request->harga[$x]) &&
                isset($request->nilai_rujukan[$x]) &&
                isset($request->nilai_satuan[$x]) &&
                isset($request->tipe_inputan[$x]) &&
                isset($request->opsi_output[$x]) &&
                isset($request->urutan[$x])
            ) {
                // Menyimpan detail department jika data lengkap
                try {
                    $departments->detailDepartments()->create([
                        'kode' => $request->kode_hidden[$x], // Menggunakan kode_hidden
                        'nama_parameter' => $request->nama_parameter[$x],
                        'nama_pemeriksaan' => $request->nama_pemeriksaan[$x],
                        'harga' => $request->harga[$x],
                        'jasa_sarana' => $request->jasa_sarana[$x] ?? null, // Nullable jika tidak ada
                        'jasa_pelayanan' => $request->jasa_pelayanan[$x] ?? null,
                        'jasa_dokter' => $request->jasa_dokter[$x] ?? null,
                        'jasa_bidan' => $request->jasa_bidan[$x] ?? null,
                        'jasa_perawat' => $request->jasa_perawat[$x] ?? null,
                        'nilai_rujukan' => $request->nilai_rujukan[$x],
                        'nilai_satuan' => $request->nilai_satuan[$x],
                        'tipe_inputan' => $request->tipe_inputan[$x],
                        'opsi_output' => $request->opsi_output[$x],
                        'urutan' => $request->urutan[$x],
                    ]);
                } catch (Exception $e) {
                    // Menangani error jika ada
                    dd("Error saving data at index $x: " . $e->getMessage());
                }
            } else {
                // Debugging jika ada data yang hilang
                dd("Missing data at index $x");
            }
        }

        // Memberikan feedback jika berhasil
        toast('Berhasil Menambahkan Data Department', 'success');

        // Redirect ke halaman department.index
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

        // Ambil semua detail lama yang ada di database
        $existingDetails = $departments->detailDepartments->keyBy('kode')->toArray();

        // Tambahkan atau update detail baru
        $array_length = count($request->nama_parameter);
        for ($x = 0; $x < $array_length; $x++) {
            $kode = $request->kode[$x];

            // Cek apakah kode sudah ada dalam detail lama
            if (isset($existingDetails[$kode])) {
                // Jika kode sudah ada, kita update datanya
                $detail = DetailDepartment::where('department_id', $departments->id)
                    ->where('kode', $kode)
                    ->first();

                $detail->update([
                    'nama_parameter' => $request->nama_parameter[$x],
                    'nama_pemeriksaan' => $request->nama_pemeriksaan[$x],
                    'harga' => $request->harga[$x],
                    'nilai_statik' => $request->nilai_statik[$x],
                    'nilai_satuan' => $request->nilai_satuan[$x],
                ]);

                // Hapus dari daftar detail lama karena sudah diupdate
                unset($existingDetails[$kode]);
            } else {
                // Jika kode belum ada, buat detail baru
                DetailDepartment::create([
                    'department_id' => $departments->id,
                    'kode' => $kode,
                    'nama_parameter' => $request->nama_parameter[$x],
                    'nama_pemeriksaan' => $request->nama_pemeriksaan[$x],
                    'harga' => $request->harga[$x],
                    'nilai_statik' => $request->nilai_statik[$x],
                    'nilai_satuan' => $request->nilai_satuan[$x],
                ]);
            }
        }

        // Jika ada detail lama yang tidak ada dalam input baru, Anda bisa menghapusnya
        foreach ($existingDetails as $detail) {
            DetailDepartment::where('id', $detail['id'])->delete();
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
