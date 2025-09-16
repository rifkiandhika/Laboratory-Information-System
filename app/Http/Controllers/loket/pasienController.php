<?php

namespace App\Http\Controllers\loket;

use Alert;
use App\Events\DataUpdated;
use App\Models\obr;
use App\Models\obx;
use App\Models\icd10;
use App\Models\pasien;
use App\Models\tabung;
use App\Models\pasienLab;


use App\Models\pembayaran;

use Illuminate\Http\Request;
use App\Models\historyPasien;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\pemeriksaan_pasien;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\DetailDepartment;
use App\Models\dokter;
use App\Models\McuPackage;
use App\Models\Pemeriksaan;
use App\Models\Report;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class pasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = pasien::where('status', 'Belum Dilayani')->count();
        $tanggal = pasien::whereDate('created_at', Carbon::today())->count();
        $dl = pasien::where('status', 'Telah Dikirim ke Lab')->count();
        $data_pasien = pasien::where('status', 'Belum Dilayani')->orderBy('cito', 'desc')->paginate(20);
        $payment = pasien::where('status', 'Telah Dibayar')->orderBy('cito', 'desc')->paginate(20);
        $dikembalikan = pasien::where('status', 'Dikembalikan Analyst')->orderBy('cito', 'desc')->paginate(20);
        broadcast(new DataUpdated($data));


        return view('loket.index', compact('data_pasien', 'data', 'tanggal', 'payment', 'dikembalikan', 'dl'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['departments']  = Department::with('pemeriksaan')->get();
        $data['dokters']      = Dokter::with('polis')->get();
        $data['mcuPackages']  = McuPackage::with('detailDepartments')
            ->where('status', 'active')
            ->get();

        // ✅ Generate nomor lab unik
        $tanggal = date('dmy');
        do {
            // 4 digit angka random
            $random = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);

            $noLab = 'LAB' . $tanggal . $random;
        } while (Pasien::where('no_lab', $noLab)->exists());

        $data['no_lab'] = $noLab;

        return view('loket.tambah-pasien', $data);
    }





    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // flag cito
        $cito = $request->cito ? 1 : 0;

        // proses harga
        $harga = (int) str_replace('.', '', $request->hargapemeriksaan);

        // dokter internal / eksternal
        // $dokter = $request->dokter_internal ?: $request->dokter_external;

        // Ambil no_lab dari form
        $noLab = $request->no_lab;

        // Validasi jika no_lab sudah dipakai
        if (Pasien::where('no_lab', $noLab)->exists()) {
            return back()->withErrors([
                'no_lab' => 'Nomor LAB sudah dipakai, silakan refresh halaman untuk mendapatkan nomor baru.'
            ])->withInput();
        }

        // Simpan data pasien
        Pasien::create([
            'no_lab'          => $noLab,
            'no_rm'           => $request->norm,
            'cito'            => $cito,
            'nik'             => $request->nik,
            'jenis_pelayanan' => $request->jenispelayanan,
            'nama'            => $request->nama,
            'lahir'           => $request->tanggallahir,
            'jenis_kelamin'   => $request->jeniskelamin,
            'no_telp'         => $request->notelepon,
            'kode_dokter'     => $request->dokter_internal,
            'dokter_external' => $request->dokter_external,
            'asal_ruangan'    => $request->asal_ruangan,
            'diagnosa'        => $request->diagnosa,
            'tanggal_masuk'   => now(),
            'alamat'          => $request->alamat,
            'tanggal'         => Carbon::today(),
        ]);

        // Simpan pemeriksaan pasien
        foreach ($request->pemeriksaan as $pemeriksaan) {
            $data = DetailDepartment::find($pemeriksaan);

            pemeriksaan_pasien::create([
                'no_lab'          => $noLab,
                'id_parameter'    => $pemeriksaan,
                'id_departement'  => $data->department_id,
                'nama_parameter'  => $data->nama_parameter,
                'harga'           => $harga,
                'mcu_package_id'  => $request->mcu_package_id ?? null, // 👈 tambahkan ini
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            // Simpan atau update ke report
            $existingReport = Report::where('department', $data->department_id)
                ->where('nolab', $noLab)
                ->where('payment_method', $request->jenispelayanan)
                ->where('id_parameter', $pemeriksaan)
                ->where('nama_parameter', $data->nama_parameter)
                ->whereDate('tanggal', now())
                ->first();

            if ($existingReport) {
                $existingReport->increment('quantity');
                $existingReport->update([
                    'nama_dokter'   => $request->dokter_internal,
                    'mcu_package_id' => $request->mcu_package_id, // 👈 update kalau sudah ada
                ]);
            } else {
                Report::create([
                    'nolab'          => $noLab,
                    'department'     => $data->department_id,
                    'payment_method' => $request->jenispelayanan,
                    'id_parameter'   => $pemeriksaan,
                    'nama_parameter' => $data->nama_parameter,
                    'nama_dokter'    => $request->dokter_internal,
                    'mcu_package_id' => $request->mcu_package_id, // 👈 simpan saat create
                    'quantity'       => 1,
                    'tanggal'        => now(),
                ]);
            }
        }

        // Simpan riwayat pasien
        HistoryPasien::create([
            'no_lab'       => $noLab,
            'proses'       => 'Order',
            'tempat'       => 'Loket',
            'waktu_proses' => now(),
            'note'         => $request->note ?? ''
        ]);

        toast('Berhasil Menambah data pasien', 'success');
        return redirect()->route('pasien.index');
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
    public function edit($no_lab)
    {

        // $pasien = pasien::findOrFail($no_lab);
        $data_pasien = pasien::where('no_lab', $no_lab)->with([
            'dpp.pasiens' => function ($query) use ($no_lab) {
                $query->where('no_lab', $no_lab)->with('data_pemeriksaan');
            },
            'dpp.data_departement',
            'dokter',
            'pembayaran',
            'pemeriksaan_pasien' => function ($query) {
                $query->with('data_pemeriksaan');
            }
        ])->first();

        if (!$data_pasien) {
            // Jika pasien tidak ditemukan, redirect ke halaman daftar pasien dengan pesan error
            return redirect()->route('pasien.index')->with('error', 'Data pasien tidak ditemukan.');
        }

        $dokters = dokter::all();

        $departments = Department::with('detailDepartments')->get();

        // Ambil ID pemeriksaan yang sudah dipilih dari tabel pemeriksaan_pasien
        $selectedInspections = $data_pasien->pemeriksaan_pasien->pluck('id_parameter')->toArray();

        // dd($data_pasien->pembayaran);


        // Menghitung total harga pemeriksaan yang sudah dipilih
        // $totalHarga = $data_pasien->dpp->sum('pasiens.harga');


        // return response()->json($data_pasien);
        return view('loket.edit', compact('data_pasien', 'dokters', 'departments', 'selectedInspections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $no_lab)
    {
        $cito = $request->cito ? 1 : 0;
        $harga = str_replace('.', '', $request->hargapemeriksaan);

        if (!is_numeric($harga)) {
            return redirect()->back()->withErrors(['message' => 'Harga tidak valid']);
        }

        $pasien = pasien::findOrFail($no_lab);

        $pasien->update([
            'no_rm' => $request->norm,
            'cito' => $cito,
            'nik' => $request->nik,
            'jenis_pelayanan' => $request->jenispelayanan,
            'nama' => $request->nama,
            'lahir' => $request->tanggallahir,
            'jenis_kelamin' => $request->jeniskelamin,
            'no_telp' => $request->notelepon,
            'kode_dokter' => $request->dokter_internal,
            'dokter_external' => $request->dokter_external,
            'asal_ruangan' => $request->asal_ruangan,
            'diagnosa' => $request->diagnosa,
            'alamat' => $request->alamat,
        ]);

        if ($request->filled('no_pasien')) {
            $pembayaran = $pasien->pembayaran()->first();
            if ($pembayaran) {
                $pembayaran->update([
                    'no_pasien' => $request->no_pasien,
                ]);
            }
        }

        // Update pemeriksaan pasien
        if ($pasien->status === 'Dikembalikan Analyst') {
            foreach ($request->pemeriksaan as $pemeriksaan) {
                $existingPemeriksaan = pemeriksaan_pasien::where('no_lab', $pasien->no_lab)
                    ->where('id_parameter', $pemeriksaan)
                    ->first();

                $data = DetailDepartment::find($pemeriksaan);
                if ($existingPemeriksaan && $data) {
                    $existingPemeriksaan->update([
                        'id_departement' => $data->department_id,
                        'nama_parameter' => $data->nama_parameter,
                        'harga' => $harga,
                    ]);
                } elseif ($data) {
                    pemeriksaan_pasien::create([
                        'no_lab' => $pasien->no_lab,
                        'id_parameter' => $pemeriksaan,
                        'id_departement' => $data->department_id,
                        'nama_parameter' => $data->nama_parameter,
                        'harga' => $harga,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        } else {
            foreach ($request->pemeriksaan as $pemeriksaan) {
                $existingPemeriksaan = pemeriksaan_pasien::where('no_lab', $pasien->no_lab)
                    ->where('id_parameter', $pemeriksaan)
                    ->first();

                if (!$existingPemeriksaan) {
                    $data = DetailDepartment::find($pemeriksaan);
                    if ($data) {
                        pemeriksaan_pasien::create([
                            'no_lab' => $pasien->no_lab,
                            'id_parameter' => $pemeriksaan,
                            'id_departement' => $data->department_id,
                            'nama_parameter' => $data->nama_parameter,
                            'harga' => $harga,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }

        session()->flash('status', 'updated');
        session(['updatedButtonIds' => $no_lab]);
        toast('Berhasil mengubah data pasien', 'success');

        if ($pasien->status === 'Result Review' || $pasien->status === 'diselesaikan') {
            return redirect()->route('result.index');
        }

        return redirect()->route('pasien.index');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $no_lab)
    {
        $pasien = pasien::where('no_lab', $no_lab)->first();

        // Cek apakah data pasien belum diverifikasi
        if ($pasien && $pasien->status = 'Belum Dilayani') {
            // Hapus data dari tabel pemeriksaan_pasien
            pemeriksaan_pasien::where('no_lab', $no_lab)->delete();

            // Hapus data dari tabel pasien
            $pasien->delete();

            toast('Berhasil Menghapus Data Pasien', 'success');
            return redirect()->route('pasien.index');
        }
        toast('Tidak dapat menghapus data yang sudah diverifikasi', 'error');
        return redirect()->route('pasien.index');
    }
    public function getDataPasien(Request $request, $lab)
    {
        try {
            // $data_pasien = pasien::with('dokter')->findOrFail($id);
            // $no_lab = pasien::where('id', $lab)->value('no_lab');
            // $data_pasien = pasien::where('id', $lab)->with(['data_pemeriksaan_pasien.data_departement', 'data_pemeriksaan_pasien.data_pemeriksaan', 'dokter'])->first();
            $no_lab = pasien::where('id', $lab)->value('no_lab');
            $data_pasien = pasien::where('id', $lab)->with([
                'dpp.pasiens' => function ($query) use ($no_lab) {
                    $query->where('no_lab', $no_lab);
                    $query->with('data_pemeriksaan');
                },
                'dpp.data_departement',
                'dokter',
                'pembayaran',
                'history',
                'spesiment.details',
                'spesimentcollection',
                'spesimenthandling.details',
                'hasil_pemeriksaan',
                'mcuPackage',
                // 'obx'
            ])->first();

            $data_pasien->obrs = $data_pasien->obrs;

            if ($data_pasien && $data_pasien->spesimentcollection) {
                foreach ($data_pasien->spesimentcollection as $spesimen) {
                    // Ambil details berdasarkan kapasitas atau serumh
                    $spesimen->details = $spesimen->getDetailsByCriteria();
                }
            }

            return response()->json(['status' => 'success', 'msg' => 'ok', 'data' => $data_pasien]);
        } catch (Exception $e) {

            return response()->json(['status' => 'fail', 'msg' => 'Failed to fetch Data']);
        }
    }

    public function kirimLab(Request $request)
    {
        // $data_pasien = pasien::all();
        $pasien = pasien::where('no_lab', $request->no_lab)->first();

        $status = 'Telah Dibayar';
        $history_proses = 'Payment';
        // dd($data_pasien);
        // foreach ($data_pasien as $pasien) {
        // if ($pasien->status === 'Dikembalikan Analyst') {
        //     $status = 'Telah Dibayar';
        //     $history_proses = 'Additional Inspection Payment';

        //     $pasien->update([
        //         'status' => $status,
        //     ]);
        // }
        // }

        if ($pasien) {
            $pasien->update(['status' => 'Telah Dibayar']);
        }



        $no_pasien = $request->no_pasien ?? null;
        $diskon = $request->diskon ?? 0;
        // dd($request);
        DB::table('pembayarans')->insert([
            'no_lab' => $request->no_lab,
            'petugas' => $request->petugas,
            'no_pasien' => $no_pasien,
            'metode_pembayaran' => $request->metode_pembayaran,
            'total_pembayaran_asli' => $request->total_pembayaran_asli,
            'total_pembayaran' => $request->total_pembayaran,
            'jumlah_bayar' => $request->jumlah_bayar,
            'diskon' => $diskon,
            'kembalian' => $request->kembalian,
            'tanggal_pembayaran' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        historyPasien::create([
            'no_lab' => $request->no_lab,
            'proses' => $history_proses,
            'tempat' => 'Loket',
            'waktu_proses' => now(),
        ]);

        toast('Pembayaran Berhasil!!', 'success');
        return redirect()->route('pasien.index');
    }

    public function checkin(Request $request)
    {
        $ids = $request->ids;
        $pasiens = pasien::whereIn('id', $ids)
            ->with('data_pemeriksaan_pasien.data_pemeriksaan')
            ->get();

        foreach ($pasiens as $pasien) {
            $has_permission_active = false;
            $has_handling_active   = false;
            $has_full_active       = false;

            foreach ($pasien->data_pemeriksaan_pasien as $pemeriksaan) {
                $detail = $pemeriksaan->data_pemeriksaan;
                if (!$detail) continue;

                $permission = strtolower(trim((string) $detail->permission)) === 'active';
                $handling   = strtolower(trim((string) $detail->handling)) === 'active';

                if ($permission && $handling) {
                    $has_full_active = true;
                }

                if ($handling) {
                    $has_handling_active = true;
                }

                if ($permission) {
                    $has_permission_active = true;
                }
            }

            // Urutan prioritas status
            if ($has_full_active) {
                $status = 'Telah Dikirim ke Lab';
                $proses = 'Dikirim ke dashboard';
                $tempat = 'Laboratorium';
            } elseif ($has_handling_active) {
                $status = 'Acc Collection';
                $proses = 'Spesimen Diterima';
                $tempat = 'Spesiment Handling';
            } elseif ($has_permission_active) {
                $status = 'Telah Dikirim ke Lab';
                $proses = 'Dikirim ke dashboard';
                $tempat = 'Laboratorium';
            } else {
                $status = 'Check In Spesiment';
                $proses = 'Check in Spesiment';
                $tempat = 'Worklist';
            }

            // Update status pasien
            $pasien->update(['status' => $status]);

            // Simpan history
            historyPasien::create([
                'no_lab'      => $pasien->no_lab,
                'proses'      => $proses,
                'tempat'      => $tempat,
                'waktu_proses' => now(),
                'created_at'  => now(),
            ]);
        }

        toast('Pasien telah diproses', 'success');
        return response()->json(['success' => 'Data berhasil dikonfirmasi!']);
    }

    public function previewPrint($lab)
    {
        $data_pasien = pasien::where('no_lab', $lab)->first();

        $nama = $data_pasien->nama;

        $nama = str_replace(' ', '%5Ct%5Ct', $nama);

        $data = [
            'nama' => $data_pasien->nama,
            'no_lab' => $data_pasien->no_lab . '%5Ct%5Ct',
            'nama_barcode' => $nama,
        ];

        $html = view('print-view.barcode-print', $data)->render();

        $pdf = Pdf::loadHtml($html);

        $pdf->setPaper([0, 0, 144, 72]);

        return $pdf->stream();
    }

    public function getDataDiagnosa(Request $request)
    {
        $keyword = $request->keyword;
        // $data = icd10::selectRaw(DB::raw('id, str as text'))->where(function($query)use($keyword){
        //     $query->where('skri', $keyword)->orWhere('str', 'like', '%'.$keyword.'%');
        // })->get();

        if ($request->ajax()) {
            try {
                $keyword = $request->keyword;
                $data = icd10::selectRaw(DB::raw('str, str as text'))->where(function ($query) use ($keyword) {
                    $query->where('skri', $keyword)->orWhere('str', 'like', '%' . $keyword . '%');
                })->get();
            } catch (Exception $e) {
                return response()->json(['status' => 'fail', 'msg' => 'Failed to fetch data']);
            }

            return response()->json(['status' => 'success', 'msg' => 'Data Fetched!', 'data' => $data]);
        }
    }
}
