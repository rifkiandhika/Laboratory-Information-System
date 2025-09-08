<?php

namespace App\Http\Controllers\mcu;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\DetailDepartment;
use App\Models\McuPackage;
use App\Models\McuPackageDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class McuPackageController extends Controller
{

    public function index()
    {
        $mcuPackages = McuPackage::with('detailDepartments.department')->get();
        return view('mcu.index', compact('mcuPackages'));
    }

    public function create()
    {
        $departments = Department::with('detailDepartments')->get();
        return view('mcu.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'diskon' => 'required|numeric|min:0|max:100',
            'pemeriksaan' => 'required|array|min:1',
            'pemeriksaan.*' => 'exists:detail_departments,id',
            'status' => 'required|in:active,inactive',
            'jasa_sarana' => 'nullable|numeric|min:0',
            'jasa_pelayanan' => 'nullable|numeric|min:0',
            'jasa_dokter' => 'nullable|numeric|min:0',
            'jasa_bidan' => 'nullable|numeric|min:0',
            'jasa_perawat' => 'nullable|numeric|min:0',
        ]);


        DB::beginTransaction();

        try {
            // Hitung harga normal dari pemeriksaan yang dipilih
            $selectedPemeriksaan = DetailDepartment::whereIn('id', $request->pemeriksaan)->get();
            $hargaNormal = $selectedPemeriksaan->sum('harga');

            // Hitung harga final setelah diskon
            $diskon = $request->diskon;
            $hargaDiskon = ($diskon / 100) * $hargaNormal;
            $hargaFinal = $hargaNormal - $hargaDiskon;

            // Buat MCU Package
            $mcuPackage = McuPackage::create([
                'nama_paket' => $request->nama_paket,
                'deskripsi' => $request->deskripsi,
                'harga_normal' => $hargaNormal,
                'diskon' => $diskon,
                'harga_final' => $hargaFinal,
                'status' => $request->status,
                'jasa_sarana' => $request->jasa_sarana,
                'jasa_pelayanan' => $request->jasa_pelayanan,
                'jasa_dokter' => $request->jasa_dokter,
                'jasa_bidan' => $request->jasa_bidan,
                'jasa_perawat' => $request->jasa_perawat,
            ]);


            // Simpan detail pemeriksaan
            foreach ($request->pemeriksaan as $pemeriksaanId) {
                McuPackageDetail::create([
                    'mcu_package_id' => $mcuPackage->id,
                    'detail_department_id' => $pemeriksaanId
                ]);
            }

            DB::commit();

            return redirect()->route('mcu.index')->with('success', 'Paket MCU berhasil dibuat!')
                ->with('swal', [
                    'title' => 'Success!',
                    'text' => 'Paket MCU berhasil dibuat.',
                    'icon' => 'success'
                ]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $mcuPackage = McuPackage::with('detailDepartments')->findOrFail($id);
        $departments = Department::with('detailDepartments')->get();
        $selectedPemeriksaan = $mcuPackage->detailDepartments->pluck('id')->toArray();

        return view('mcu.edit', compact('mcuPackage', 'departments', 'selectedPemeriksaan'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'diskon' => 'required|numeric|min:0|max:100',
            'pemeriksaan' => 'required|array|min:1',
            'pemeriksaan.*' => 'exists:detail_departments,id',
            'status' => 'required|in:active,inactive',
            'jasa_sarana' => 'nullable|numeric|min:0',
            'jasa_pelayanan' => 'nullable|numeric|min:0',
            'jasa_dokter' => 'nullable|numeric|min:0',
            'jasa_bidan' => 'nullable|numeric|min:0',
            'jasa_perawat' => 'nullable|numeric|min:0',
        ]);
        DB::beginTransaction();

        try {
            $mcuPackage = McuPackage::findOrFail($id);

            // Hitung ulang harga
            $selectedPemeriksaan = DetailDepartment::whereIn('id', $request->pemeriksaan)->get();
            $hargaNormal = $selectedPemeriksaan->sum('harga');
            $diskon = $request->diskon;
            $hargaDiskon = ($diskon / 100) * $hargaNormal;
            $hargaFinal = $hargaNormal - $hargaDiskon;

            // Update MCU Package
            $mcuPackage->update([
                'nama_paket' => $request->nama_paket,
                'deskripsi' => $request->deskripsi,
                'harga_normal' => $hargaNormal,
                'diskon' => $diskon,
                'harga_final' => $hargaFinal,
                'status' => $request->status,
                'jasa_sarana' => $request->jasa_sarana,
                'jasa_pelayanan' => $request->jasa_pelayanan,
                'jasa_dokter' => $request->jasa_dokter,
                'jasa_bidan' => $request->jasa_bidan,
                'jasa_perawat' => $request->jasa_perawat,
            ]);

            // Hapus detail lama dan buat yang baru
            McuPackageDetail::where('mcu_package_id', $mcuPackage->id)->delete();

            foreach ($request->pemeriksaan as $pemeriksaanId) {
                McuPackageDetail::create([
                    'mcu_package_id' => $mcuPackage->id,
                    'detail_department_id' => $pemeriksaanId
                ]);
            }

            DB::commit();

            return redirect()->route('mcu.index')->with('success', 'Paket MCU berhasil diupdate!')
                ->with('swal', [
                    'title' => 'Success!',
                    'text' => 'Paket MCU berhasil diupdate.',
                    'icon' => 'success'
                ]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Hitung ulang harga
    // $selectedPemeriksaan = DetailDepartment::whereIn('id', $request->pemeriksaan)->get();
    // $hargaNormal = $selectedPemeriksaan->sum('harga');

    // // Tambahkan jasa
    // $jasaTotal = $request->jasa_sarana + $request->jasa_pelayanan + $request->jasa_dokter + $request->jasa_bidan + $request->jasa_perawat;
    // $hargaNormal += $jasaTotal;

    // $diskon = $request->diskon;
    // $hargaDiskon = ($diskon / 100) * $hargaNormal;
    // $hargaFinal = $hargaNormal - $hargaDiskon;

    // // Update MCU Package
    // $mcuPackage->update([
    //     'nama_paket' => $request->nama_paket,
    //     'deskripsi' => $request->deskripsi,
    //     'harga_normal' => $hargaNormal,
    //     'diskon' => $diskon,
    //     'harga_final' => $hargaFinal,
    //     'status' => $request->status,
    //     'jasa_sarana' => $request->jasa_sarana,
    //     'jasa_pelayanan' => $request->jasa_pelayanan,
    //     'jasa_dokter' => $request->jasa_dokter,
    //     'jasa_bidan' => $request->jasa_bidan,
    //     'jasa_perawat' => $request->jasa_perawat,
    // ]);

    public function destroy($id)
    {
        try {
            $mcuPackage = McuPackage::findOrFail($id);
            $mcuPackage->delete();

            return redirect()->route('mcu.index')->with('success', 'Paket MCU berhasil dihapus!')
                ->with('swal', [
                    'title' => 'Success!',
                    'text' => 'Paket MCU berhasil dihapus.',
                    'icon' => 'success'
                ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // API untuk mendapatkan detail paket MCU (untuk digunakan di form pasien)
    public function getPackageDetails($id)
    {
        $mcuPackage = McuPackage::with('detailDepartments.department')->findOrFail($id);

        return response()->json([
            'id' => $mcuPackage->id,
            'nama_paket' => $mcuPackage->nama_paket,
            'harga_normal' => $mcuPackage->harga_normal,
            'diskon' => $mcuPackage->diskon,
            'harga_final' => $mcuPackage->harga_final,
            'pemeriksaan' => $mcuPackage->detailDepartments->map(function ($detail) {
                return [
                    'id' => $detail->id,
                    'nama_pemeriksaan' => $detail->nama_pemeriksaan,
                    'harga' => $detail->harga,
                    'department' => $detail->department->nama_department
                ];
            })
        ]);
    }
}
