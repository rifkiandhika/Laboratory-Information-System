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
use App\Models\Pemeriksaan;
use App\Models\Report;
use Carbon\Carbon;
use Exception;

class pasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $data_pasien_cito = pasien::where('cito', 1)->where('status', 'Belum Dilayani')->get();
        // $data_pasien = pasien::where('cito', 0)->where('status', 'Belum Dilayani')->get();
        $data = pasien::where('status', 'Belum Dilayani')->count();
        $tanggal = pasien::whereDate('created_at', Carbon::today())->count();
        $dl = pasien::where('status', 'Telah Dikirim ke Lab')->count();
        $data_pasien = pasien::where('status', 'Belum Dilayani')->orderBy('cito', 'desc')->paginate(20);
        $payment = pasien::where('status', 'Telah Dibayar')->orderBy('cito', 'desc')->paginate(20);
        $dikembalikan = pasien::where('status', 'Dikembalikan Analyst')->orderBy('cito', 'desc')->paginate(20);
        // $data_pemeriksaan_pasien = pemeriksaan_pasien::all();
        // dd($data_pasien);
        // $data_departement = Department::all();
        // $data_pemeriksaan = Pemeriksaan::all();
        broadcast(new DataUpdated($data));


        return view('loket.index', compact('data_pasien', 'data', 'tanggal', 'payment', 'dikembalikan', 'dl'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $data['departments'] = Department::with('pemeriksaan')->get();
        $data['dokters'] = dokter::with('polis')->get();

        $tanggal = date('dmy');
        $urutan = pasien::where('no_lab', 'like', 'LAB' . $tanggal . '%')->count() + 1;

        $urutan = sprintf("%03d", $urutan);
        $data['no_lab'] = 'LAB' . $tanggal . $urutan;

        return view('loket.tambah-pasien', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->cito) {
            $cito = 1;
        } else {
            $cito = 0;
        }

        // Memproses harga pemeriksaan
        $harga = (int)str_replace('.', '', $request->hargapemeriksaan);

        // Menentukan dokter internal atau eksternal
        $dokter = null;

        if ($request->dokter_internal) {
            // Jika dokter internal dipilih, simpan kode dokter internal
            $dokter = $request->dokter_internal;
        } elseif ($request->dokter_external) {
            // Jika dokter eksternal dipilih, simpan nama dokter eksternal
            $dokter = $request->dokter_external;
        }

        // Menyimpan data pasien
        pasien::create([
            'no_lab' => $request->nolab,
            'no_rm' => $request->norm,
            'cito' => $cito,
            'nik' => $request->nik,
            'jenis_pelayanan' => $request->jenispelayanan,
            'nama' => $request->nama,
            'lahir' => $request->tanggallahir,
            'jenis_kelamin' => $request->jeniskelamin,
            'no_telp' => $request->notelepon,
            'kode_dokter' => $dokter,  // Simpan kode dokter internal atau nama dokter eksternal
            'asal_ruangan' => $request->asal_ruangan,
            'diagnosa' => $request->diagnosa,
            'tanggal_masuk' => now(),
            'alamat' => $request->alamat,
            'tanggal' => Carbon::today(),
        ]);

        // Menyimpan pemeriksaan
        $no = 0;
        foreach ($request->pemeriksaan as $pemeriksaan) {
            $data = DetailDepartment::find($pemeriksaan);
            pemeriksaan_pasien::create([
                'no_lab' => $request->nolab,
                'id_parameter' => $pemeriksaan,
                'id_departement' => $data->department_id,
                'nama_parameter' => $data->nama_parameter,
                'harga' => $harga,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $no++;

            // Simpan atau update ke report
            $existingReport = Report::where('department', $data->department_id)
                ->where('nolab', $request->nolab)
                ->where('payment_method', $request->jenispelayanan)
                ->where('id_parameter', $pemeriksaan)
                ->where('nama_parameter', $data->nama_parameter)
                ->whereDate('tanggal', now())
                ->first();

            if ($existingReport) {
                $existingReport->increment('quantity');
            } else {
                Report::create([
                    'nolab'   => $request->nolab,
                    'department'   => $data->department_id,
                    'payment_method'  => $request->jenispelayanan,
                    'id_parameter'    => $pemeriksaan,
                    'nama_parameter'  => $data->nama_parameter,
                    'quantity'        => 1,
                    'tanggal'         => now(),
                ]);
            }
        }



        // Menyimpan riwayat pasien
        historyPasien::create([
            'no_lab' => $request->nolab,
            'proses' => 'Order',
            'tempat' => 'Loket',
            'waktu_proses' => now(),
            'note' => $request->note ?? ''
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

        // Cek jika harga valid
        if (!is_numeric($harga)) {
            return redirect()->back()->withErrors(['message' => 'Harga tidak valid']);
        }

        $pasien = pasien::findOrFail($no_lab);

        // Update data pasien
        $pasien->update([
            'no_rm' => $request->norm,
            'cito' => $cito,
            'nik' => $request->nik,
            'jenis_pelayanan' => $request->jenispelayanan,
            'nama' => $request->nama,
            'lahir' => $request->tanggallahir,
            'jenis_kelamin' => $request->jeniskelamin,
            'no_telp' => $request->notelepon,
            'kode_dokter' => $request->dokter,
            'asal_ruangan' => $request->asal_ruangan,
            'diagnosa' => $request->diagnosa,
            'alamat' => $request->alamat,
        ]);

        if ($pasien->status === 'Dikembalikan Analyst') {
            // Jika pasien statusnya "Dikembalikan Analyst", periksa dan update pemeriksaan yang ada
            foreach ($request->pemeriksaan as $pemeriksaan) {
                // Cari pemeriksaan yang sudah ada untuk pasien ini dan parameter ini
                $existingPemeriksaan = pemeriksaan_pasien::where('no_lab', $pasien->no_lab)
                    ->where('id_parameter', $pemeriksaan)
                    ->first();

                if ($existingPemeriksaan) {
                    // Jika pemeriksaan sudah ada, update
                    $data = DetailDepartment::find($pemeriksaan);
                    $existingPemeriksaan->update([
                        'id_departement' => $data->department_id,
                        'nama_parameter' => $data->nama_parameter,
                        'harga' => $harga,
                    ]);
                } else {
                    // Jika pemeriksaan belum ada, buat yang baru
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
        } else {
            // Jika pasien statusnya bukan "Dikembalikan Analyst", langsung tambahkan pemeriksaan baru
            foreach ($request->pemeriksaan as $pemeriksaan) {
                // Periksa apakah pemeriksaan sudah ada untuk pasien ini dan id_parameter ini
                $existingPemeriksaan = pemeriksaan_pasien::where('no_lab', $pasien->no_lab)
                    ->where('id_parameter', $pemeriksaan)
                    ->first();

                if (!$existingPemeriksaan) {
                    // Jika pemeriksaan belum ada, buat yang baru
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

        // Set status flash dan session
        session()->flash('status', 'updated');
        session(['updatedButtonIds' => $no_lab]);
        toast('Berhasil mengubah data pasien', 'success');

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
        // $data_pasien = pasien::where('no_lab', $lab)->first();
        // $data_pemeriksaan_pasien = pemeriksaan_pasien::where('no_lab', $lab)->get();
        // $id_departement_pasien = pemeriksaan_pasien::where('no_lab', $lab)->distinct()->get(['id_departement']);
        // // $icd10 = icd10::all() ?? [];
        // $icd10 = [];
        // $data_departement = Department::all();
        // $data_pemeriksaan = Pemeriksaan::all();
        // $history_pasien = historyPasien::where('no_lab', $lab)->where('proses', 'Disetujui oleh analis lab')->get();
        // $dataTabung = tabung::all();

        // $dataOBR = obr::where('order_number', $lab)->count();

        // // $res = [
        // //     'success' => true,
        // //     'message' => 'Data pasien ditemukan',
        // //     'data_pasien' => $data_pasien,
        // //     'data_pemeriksaan_pasien' => $data_pemeriksaan_pasien,
        // //     'id_departement_pasien' => $id_departement_pasien,
        // //     'icd10' => $icd10,
        // //     'data_departement' => $data_departement,
        // //     'data_pemeriksaan' => $data_pemeriksaan,
        // //     'history_pasien' => $history_pasien,
        // //     'dataTabung' => $dataTabung,
        // //     'dataOBR' => $dataOBR,
        // // ];

        // if($data_pasien)
        // {
        //     return response()->json([
        //         'success' => true,
        //         'message' => 'Data pasien ditemukan',
        //         'data_pasien' => $data_pasien,
        //         'data_pemeriksaan_pasien' => $data_pemeriksaan_pasien,
        //         'id_departement_pasien' => $id_departement_pasien,
        //         'icd10' => $icd10,
        //         'data_departement' => $data_departement,
        //         'data_pemeriksaan' => $data_pemeriksaan,
        //         'history_pasien' => $history_pasien,
        //         'dataTabung' => $dataTabung,
        //         'dataOBR' => $dataOBR,
        //     ], 200);
        // }
        // else
        // {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Data pasien tidak ditemukan',
        //     ], 404);
        // }

        // $no_lab = pasien::where('id', $lab)->value('no_lab');
        // $data_pasien = pasien::where('id', $lab)->with(['dpp.pasiens' => function ($query) use ($no_lab) {
        //     $query->where('no_lab', $no_lab);
        //     $query->with('data_pemeriksaan');
        // }, 'dpp.data_departement', 'dokter', 'spesiment'])->first();

        // return $data_pasien;

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
                'obx'
            ])->first();

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
        pasien::whereIn('id', $ids)->update(['status' => 'Telah Dikirim ke Lab']);
        $pasien = pasien::whereIn('id', $ids)->get();

        foreach ($pasien as $pasiens) {

            historyPasien::create([
                'no_lab' => $pasiens->no_lab,
                'proses' => 'Dikirim ke dashboard',
                'tempat' => 'Laboratorium',
                'waktu_proses' => now(),
                'created_at' => now(),
            ]);
        }
        toast('Pasien telah dikirim ke Lab', 'success');
        return response()->json(['success' => 'Data berhasil Dikonfirmasi!']);
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
