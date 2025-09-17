<?php

namespace App\Http\Controllers\department;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\DetailDepartment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'kode*' => 'required', // Memastikan kode_hidden diterima
            'judul.*' => 'nullable',
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
                isset($request->kode[$x]) &&
                isset($request->judul[$x]) &&
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
                        'kode' => $request->kode[$x], // Menggunakan kode_hidden
                        'judul' => $request->judul[$x] ?? null,
                        'nama_parameter' => $request->nama_parameter[$x],
                        'nama_pemeriksaan' => $request->nama_pemeriksaan[$x],
                        'harga' => $request->harga[$x],
                        'jasa_sarana' => $request->jasa_sarana[$x] ?? 0, // Nullable jika tidak ada
                        'jasa_pelayanan' => $request->jasa_pelayanan[$x] ?? 0,
                        'jasa_dokter' => $request->jasa_dokter[$x] ?? 0,
                        'jasa_bidan' => $request->jasa_bidan[$x] ?? 0,
                        'jasa_perawat' => $request->jasa_perawat[$x] ?? 0,
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
        // Redirect ke halaman department.index
        return redirect()->route('department.index')->with('success', 'Data Saved!')
            ->with('swal', [
                'title' => 'Success!',
                'text' => 'Data Saved.',
                'icon' => 'success'
            ]);;
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
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            // Update department
            $department = Department::findOrFail($id);
            $department->nama_department = $request->nama_department;
            $department->save();

            // Handle penghapusan data existing
            if ($request->has('delete_detail')) {
                $deleteIds = array_filter($request->delete_detail); // Remove empty values
                if (!empty($deleteIds)) {
                    DetailDepartment::whereIn('id', $deleteIds)->delete();
                }
            }

            // Update existing data
            if ($request->has('id_detail')) {
                foreach ($request->id_detail as $index => $detailId) {
                    if ($detailId && !in_array($detailId, $request->delete_detail ?? [])) {
                        $detail = DetailDepartment::find($detailId);
                        if ($detail) {
                            $detail->update([
                                'kode' => $request->kode[$index] ?? '',
                                'judul' => $request->judul[$index] ?? '',
                                'nama_parameter' => $request->nama_parameter[$index] ?? '',
                                'nama_pemeriksaan' => $request->nama_pemeriksaan[$index] ?? '',
                                'harga' => $request->harga[$index] ?? 0,
                                'nilai_rujukan' => $request->nilai_rujukan[$index] ?? '',
                                'nilai_satuan' => $request->nilai_satuan[$index] ?? '',
                                'jasa_sarana' => $request->jasa_sarana[$index] ?? 0,
                                'jasa_pelayanan' => $request->jasa_pelayanan[$index] ?? 0,
                                'jasa_dokter' => $request->jasa_dokter[$index] ?? 0,
                                'jasa_bidan' => $request->jasa_bidan[$index] ?? 0,
                                'jasa_perawat' => $request->jasa_perawat[$index] ?? 0,
                                'tipe_inputan' => $request->tipe_inputan[$index] ?? '',
                                'opsi_output' => $request->opsi_output[$index] ?? '',
                                'urutan' => $request->urutan[$index] ?? '',
                                'status' => isset($request->status[$index]) ? 'active' : 'deactive',
                                'barcode' => isset($request->barcode[$index]) ? 'active' : 'deactive',
                                'permission' => isset($request->permission[$index]) ? 'active' : 'deactive',
                                'handling' => isset($request->handling[$index]) ? 'active' : 'deactive',
                            ]);
                        }
                    }
                }
            }

            // Handle new data (data yang tidak punya id_detail)
            $existingCount = count($request->id_detail ?? []);
            $totalCount = count($request->nama_parameter ?? []);

            for ($i = $existingCount; $i < $totalCount; $i++) {
                if (isset($request->nama_parameter[$i]) && !empty($request->nama_parameter[$i])) {
                    DetailDepartment::create([
                        'department_id' => $department->id,
                        'kode' => $request->kode[$i] ?? '',
                        'judul' => $request->judul[$i] ?? '',
                        'nama_parameter' => $request->nama_parameter[$i],
                        'nama_pemeriksaan' => $request->nama_pemeriksaan[$i] ?? '',
                        'harga' => $request->harga[$i] ?? 0,
                        'nilai_rujukan' => $request->nilai_rujukan[$i] ?? '',
                        'nilai_satuan' => $request->nilai_satuan[$i] ?? '',
                        'jasa_sarana' => $request->jasa_sarana[$i] ?? 0,
                        'jasa_pelayanan' => $request->jasa_pelayanan[$i] ?? 0,
                        'jasa_dokter' => $request->jasa_dokter[$i] ?? 0,
                        'jasa_bidan' => $request->jasa_bidan[$i] ?? 0,
                        'jasa_perawat' => $request->jasa_perawat[$i] ?? 0,
                        'tipe_inputan' => $request->tipe_inputan[$i] ?? '',
                        'opsi_output' => $request->opsi_output[$i] ?? '',
                        'urutan' => $request->urutan[$i] ?? '',
                        'status' => isset($request->status[$i]) ? 'active' : 'deactive',
                        'barcode' => isset($request->barcode[$i]) ? 'active' : 'deactive',
                        'permission' => isset($request->permission[$i]) ? 'active' : 'deactive',
                        'handling' => isset($request->handling[$i]) ? 'active' : 'deactive',
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('department.index')
                ->with('success', 'Department berhasil diupdate!')
                ->with('swal', [
                    'title' => 'Berhasil!',
                    'text' => 'Data department berhasil diperbarui.',
                    'icon' => 'success'
                ]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->with('swal', [
                    'title' => 'Error!',
                    'text' => 'Terjadi kesalahan: ' . $e->getMessage(),
                    'icon' => 'error'
                ])
                ->withInput();
        }
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

        return redirect()->route('department.index')->with('success', 'Department berhasil dihapus!')
            ->with('swal', [
                'title' => 'Berhasil!',
                'text' => 'Data department berhasil dihapus.',
                'icon' => 'success'
            ]);
    }
}
