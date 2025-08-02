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
        // dd($request->all());
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
            'status.*' => 'required',
            'permission.*' => 'required',
            'barcode.*' => 'required',
            'handling.*' => 'required',
            'opsi_output.*' => 'nullable',
            'urutan.*' => 'nullable',
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
                isset($request->status[$x]) &&
                isset($request->permission[$x]) &&
                isset($request->barcode[$x]) &&
                isset($request->handling[$x])
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
                        'status' => $request->status[$x],
                        'permission' => $request->permission[$x],
                        'barcode' => $request->barcode[$x],
                        'handling' => $request->handling[$x],
                        'tipe_inputan' => $request->tipe_inputan[$x],
                        'opsi_output' => $request->opsi_output[$x] ?? null,
                        'urutan' => $request->urutan[$x] ?? null,
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
            'kode_hidden.*' => 'required',
            'nama_parameter.*' => 'required',
            'nama_pemeriksaan.*' => 'required',
            'harga.*' => 'required',
            'nilai_rujukan.*' => 'required',
            'nilai_satuan.*' => 'required',
            'tipe_inputan.*' => 'required',
            'opsi_output.*' => 'required',
            'urutan.*' => 'required',
            'status.*' => 'nullable', // Checkbox bisa tidak ada
            'permission.*' => 'nullable', // Checkbox bisa tidak ada
            'barcode.*' => 'nullable', // Checkbox bisa tidak ada
            'handling.*' => 'nullable', // Checkbox bisa tidak ada
        ]);

        // Temukan department berdasarkan ID
        $department = Department::findOrFail($id);

        // Update nama department
        $department->update([
            'nama_department' => $request->nama_department,
        ]);

        // Ambil detail yang lama dari database
        $existingDetails = $department->detailDepartments->keyBy('id');

        // Iterasi input form
        $count = count($request->nama_parameter);
        for ($i = 0; $i < $count; $i++) {
            $detailId = $request->id_detail[$i] ?? null;
            $kode = $request->kode_hidden[$i];

            $data = [
                'kode' => $kode,
                'nama_parameter' => $request->nama_parameter[$i],
                'nama_pemeriksaan' => $request->nama_pemeriksaan[$i],
                'harga' => $request->harga[$i],
                'jasa_sarana' => $request->jasa_sarana[$i] ?? null,
                'jasa_pelayanan' => $request->jasa_pelayanan[$i] ?? null,
                'jasa_dokter' => $request->jasa_dokter[$i] ?? null,
                'jasa_bidan' => $request->jasa_bidan[$i] ?? null,
                'jasa_perawat' => $request->jasa_perawat[$i] ?? null,
                'nilai_rujukan' => $request->nilai_rujukan[$i],
                'nilai_satuan' => $request->nilai_satuan[$i],
                'status' => $request->status[$i] ?? 'deactive', // Jika tidak dicentang
                'permission' => $request->permission[$i] ?? 'deactive', // Jika tidak dicentang
                'barcode' => $request->barcode[$i] ?? 'deactive', // Jika tidak dicentang
                'handling' => $request->handling[$i] ?? 'deactive', // Jika tidak dicentang
                'tipe_inputan' => $request->tipe_inputan[$i],
                'opsi_output' => $request->opsi_output[$i],
                'urutan' => $request->urutan[$i],
            ];

            if ($detailId) {
                // Jika ID detail ada → update
                DetailDepartment::where('id', $detailId)->update($data);
                $existingDetails->forget($detailId); // Tandai sebagai sudah diproses
            } else {
                // Jika tidak ada ID → tambahkan baru
                $data['department_id'] = $department->id;
                DetailDepartment::create($data);
            }
        }

        // Hapus detail yang tidak ada lagi di input
        // foreach ($existingDetails as $detail) {
        //     $detail->delete();
        // }

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
