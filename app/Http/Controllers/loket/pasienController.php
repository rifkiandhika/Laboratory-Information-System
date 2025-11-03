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
use App\Jobs\SendPasienToLis;
use App\Models\DataAsuransi;
use App\Models\DataBpjs;
use App\Models\DataPasien;
use App\Models\Department;
use App\Models\DetailDepartment;
use App\Models\dokter;
use App\Models\McuPackage;
use App\Models\Pemeriksaan;
use App\Models\Poli;
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

        // filter dokter berdasarkan status
        $data['dokterInternal'] = Dokter::where('status', 'internal')
            ->get();

        $data['dokterExternal'] = Dokter::where('status', 'external')
            ->get();

        // filter poli berdasarkan status
        $data['poliInternal'] = Poli::where('status', 'internal')->get();
        $data['poliExternal'] = Poli::where('status', 'external')->get();

        $data['mcuPackages']  = McuPackage::with('detailDepartments')
            ->where('status', 'active')
            ->get();

        $tanggal = date('dmy');
        do {
            $random = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
            $noLab = 'LAB' . $tanggal . $random;
        } while (Pasien::where('no_lab', $noLab)->exists());

        $data['no_lab'] = $noLab;

        $roomByDokter = [];


        foreach ($data['dokterInternal'] as $dokter) {
            $poliIds = json_decode($dokter->id_poli, true);
            $poliNames = [];

            if (is_array($poliIds)) {
                foreach ($poliIds as $poliId) {
                    $poli = Poli::find($poliId);
                    if ($poli) {
                        $poliNames[] = $poli->nama_poli;
                    }
                }
            }

            $roomByDokter[$dokter->id] = [
                'nama' => $dokter->nama_dokter,
                'jabatan' => $dokter->jabatan,
                'status' => 'internal',
                'ruangan' => $poliNames
            ];
        }


        foreach ($data['dokterExternal'] as $dokter) {
            $poliIds = json_decode($dokter->id_poli, true);
            $poliNames = [];

            if (is_array($poliIds)) {
                foreach ($poliIds as $poliId) {
                    $poli = Poli::find($poliId);
                    if ($poli) {
                        $poliNames[] = $poli->nama_poli;
                    }
                }
            }

            $roomByDokter[$dokter->id] = [
                'nama' => $dokter->nama_dokter,
                'jabatan' => $dokter->jabatan,
                'status' => 'external',
                'ruangan' => $poliNames
            ];
        }

        $data['roomByDokter'] = $roomByDokter;

        return view('loket.tambah-pasien', $data);
    }

    public function DataPasien(Request $request)
    {
        $keyword = $request->keyword;

        if (!$keyword || strlen($keyword) < 3) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Minimal 3 karakter'
            ]);
        }

        // Pencarian hanya berdasarkan nik, nama, dan uid
        $pasiens = DataPasien::where('nik', 'LIKE', "%{$keyword}%")
            ->orWhere('nama', 'LIKE', "%{$keyword}%")
            ->orWhere('uid', 'LIKE', "%{$keyword}%") // Tambahkan pencarian UID
            ->limit(10)
            ->get(['id', 'nik', 'uid', 'no_rm', 'nama', 'lahir', 'jenis_kelamin', 'no_telp', 'alamat']); // no_rm tetap diambil

        return response()->json([
            'status' => 'success',
            'data' => $pasiens
        ]);
    }




    public function syncFromExternal(Request $request)
    {
        $validated = $request->validate([
            'no_lab' => 'required',
            'nama' => 'required',
            'lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'pemeriksaan' => 'array|required',
        ]);

        // Simpan/Update pasien
        $pasien = pasien::updateOrCreate(
            ['no_lab' => $validated['no_lab']],
            collect($request->all())->except(['pemeriksaan', 'reports', 'histories'])->toArray()
        );

        // Simpan pemeriksaan
        foreach ($request->pemeriksaan as $periksa) {
            pemeriksaan_pasien::updateOrCreate(
                [
                    'no_lab' => $pasien->no_lab,
                    'id_parameter' => $periksa['id_parameter']
                ],
                $periksa
            );
        }

        // Reports
        foreach ($request->reports ?? [] as $report) {
            Report::updateOrCreate(
                [
                    'nolab' => $report['nolab'],
                    'id_parameter' => $report['id_parameter'],
                ],
                $report
            );
        }

        // Histories
        foreach ($request->histories ?? [] as $history) {
            historyPasien::create($history);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data pasien berhasil diterima & disinkronkan.'
        ]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $cito = $request->cito ? 1 : 0;

        $harga = (int) str_replace('.', '', $request->hargapemeriksaan);

        $noLab = $request->no_lab;

        if (Pasien::where('no_lab', $noLab)->exists()) {
            return back()->withErrors([
                'no_lab' => 'Nomor LAB sudah dipakai, silakan refresh halaman untuk mendapatkan nomor baru.'
            ])->withInput();
        }

        $nik = trim($request->nik) ?: '000';
        $norm = trim($request->norm) ?: '000';

        Pasien::create([
            'no_lab'          => $noLab,
            'no_rm'           => $norm,
            'cito'            => $cito,
            'nik'             => $nik,
            'jenis_pelayanan' => $request->jenispelayanan,
            'nama'            => $request->nama,
            'lahir'           => $request->tanggallahir,
            'jenis_kelamin'   => $request->jeniskelamin,
            'no_telp'         => $request->notelepon,
            'kode_dokter'     => $request->dokter_internal,
            'dokter_external' => $request->dokter_external,
            'asal_ruangan'    => $request->asal_ruangan,
            'diagnosa'        => $request->diagnosa,
            'alamat'          => $request->alamat,
            'tanggal'         => Carbon::today(),
        ]);

        if ($nik !== '000') {
            $existingDataPasien = DataPasien::where('no_rm', $request->norm)
                ->orWhere('nik', $nik)
                ->first();
        } else {
            // Jika NIK = '000', cek hanya berdasarkan no_rm saja
            $existingDataPasien = DataPasien::where('no_rm', $request->norm)->first();
        }

        if (!$existingDataPasien) {
            // Jika belum ada, baru buat baru
            DataPasien::create([
                'uid'             => $norm,
                'no_rm'           => $norm,
                'nik'             => $nik,
                'nama'            => $request->nama,
                'lahir'           => $request->tanggallahir,
                'jenis_kelamin'   => $request->jeniskelamin,
                'no_telp'         => $request->notelepon,
                'alamat'          => $request->alamat,
            ]);
        }

        // Simpan pemeriksaan pasien
        foreach ($request->pemeriksaan as $pemeriksaan) {
            $data = DetailDepartment::find($pemeriksaan);

            pemeriksaan_pasien::create([
                'no_lab'          => $noLab,
                'id_parameter'    => $pemeriksaan,
                'id_departement'  => $data->department_id,
                'nama_parameter'  => $data->nama_parameter,
                'harga'           => $harga,
                'mcu_package_id'  => $request->mcu_package_id ?? null,
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
                    'dokter_external' => $request->dokter_external,
                    'mcu_package_id' => $request->mcu_package_id,
                ]);
            } else {
                Report::create([
                    'nolab'          => $noLab,
                    'department'     => $data->department_id,
                    'payment_method' => $request->jenispelayanan,
                    'id_parameter'   => $pemeriksaan,
                    'nama_parameter' => $data->nama_parameter,
                    'nama_dokter'    => $request->dokter_internal,
                    'asal_ruangan'    => $request->asal_ruangan,
                    'dokter_external' => $request->dokter_external,
                    'mcu_package_id' => $request->mcu_package_id,
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


    private function generateUid($nama, $tanggalLahir)
    {

        $namaClean = preg_replace('/[^a-zA-Z]/', '', $nama);
        $namaLength = strlen($namaClean);


        $namaChars = '';
        $positions = [];
        for ($i = 0; $i < 3 && $i < $namaLength; $i++) {
            do {
                $pos = rand(0, $namaLength - 1);
            } while (in_array($pos, $positions));
            $positions[] = $pos;
            $namaChars .= $namaClean[$pos];
        }


        $tanggalStr = str_replace(['-', '/', ' '], '', $tanggalLahir);
        $tanggalNums = preg_replace('/[^0-9]/', '', $tanggalStr);
        $tanggalLength = strlen($tanggalNums);


        $tanggalChars = '';
        $positions = [];
        for ($i = 0; $i < 3 && $i < $tanggalLength; $i++) {
            do {
                $pos = rand(0, $tanggalLength - 1);
            } while (in_array($pos, $positions));
            $positions[] = $pos;
            $tanggalChars .= $tanggalNums[$pos];
        }


        $random = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 4));


        $parts = [$namaChars, $tanggalChars, $random];
        shuffle($parts);

        $uid = strtoupper(implode('', $parts));


        while (DataPasien::where('uid', $uid)->exists()) {
            $uid = strtoupper(substr(str_shuffle($uid . rand(1000, 9999)), 0, 10));
        }

        return $uid;
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
            return redirect()->route('pasien.index')->with('error', 'Data pasien tidak ditemukan.');
        }

        $dokterInternal = Dokter::where('status', 'internal')->get();

        $dokterExternal = Dokter::where('status', 'external')->get();

        $poliInternal = Poli::where('status', 'internal')->get();

        // Dokter umum
        $dokters = Dokter::all();

        // Departemen
        $departments = Department::with('detailDepartments')->get();

        // Pemeriksaan yang sudah dipilih
        $selectedInspections = $data_pasien->pemeriksaan_pasien->pluck('id_parameter')->toArray();

        return view('loket.edit', compact(
            'data_pasien',
            'dokters',
            'departments',
            'selectedInspections',
            'dokterInternal',
            'dokterExternal',
            'poliInternal'
        ));
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
            'nik' => $request->nik ?: '000',
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

        $dataPasien = DataPasien::where('no_rm', $request->norm)->first();
        if ($dataPasien) {
            $dataPasien->update([
                'nik'           => $request->nik ?: '000',
                'nama'          => $request->nama,
                'lahir'         => $request->tanggallahir,
                'jenis_kelamin' => $request->jeniskelamin,
                'no_telp'       => $request->notelepon,
                'alamat'        => $request->alamat,
            ]);
        }

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
                'dataPasien.dataBpjs',
                'dataPasien.dataAsuransi'
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
            return response()->json([
                'status' => 'fail',
                'msg' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
        }
    }


    public function kirimLab(Request $request)
    {
        $pasien = Pasien::with(['pemeriksaan_pasien'])
            ->where('no_lab', $request->no_lab)
            ->firstOrFail();

        // Update status pasien
        $pasien->update(['status' => 'Telah Dibayar']);

        $no_pasien = $request->no_pasien ?? null;
        $diskon = $request->diskon ?? 0;

        pemeriksaan_pasien::where('no_lab', $pasien->no_lab)
            ->update(['status' => 'lama']);

        // Simpan pembayaran
        $pembayaran = pembayaran::create([
            'no_lab' => $request->no_lab,
            'petugas' => $request->petugas,
            'no_pasien' => $no_pasien,
            'penjamin' => $request->penjamin,
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

        $dataPasien = DataPasien::where('no_rm', $pasien->no_rm)->first();

        if ($dataPasien) {
            if (strtolower($request->metode_pembayaran) === 'bpjs') {
                // Cek apakah sudah ada BPJS dengan nomor sama untuk pasien ini
                $existingBpjs = DataBpjs::where('data_pasiens_id', $dataPasien->id)
                    ->where('no_bpjs', $request->no_pasien)
                    ->first();

                if (!$existingBpjs) {
                    DataBpjs::create([
                        'data_pasiens_id' => $dataPasien->id,
                        'no_bpjs' => $request->no_pasien ?? null,
                    ]);
                }
            } elseif (strtolower($request->metode_pembayaran) === 'asuransi') {
                // Cek apakah sudah ada Asuransi dengan nomor sama untuk pasien ini
                $existingAsuransi = DataAsuransi::where('data_pasiens_id', $dataPasien->id)
                    ->where('no_penjamin', $request->no_pasien)
                    ->first();

                if (!$existingAsuransi) {
                    DataAsuransi::create([
                        'data_pasiens_id' => $dataPasien->id,
                        'penjamin' => $request->penjamin,
                        'no_penjamin' => $request->no_pasien ?? null,
                    ]);
                }
            }
        }


        // Tambahkan riwayat pasien
        HistoryPasien::create([
            'no_lab' => $request->no_lab,
            'proses' => 'Payment',
            'tempat' => 'Loket',
            'waktu_proses' => now(),
        ]);

        // Siapkan payload untuk dikirim ke LIS
        $payload = [
            'no_lab' => $pasien->no_lab,
            'no_rm' => $pasien->no_rm,
            'cito' => $pasien->cito,
            'nik' => $pasien->nik,
            'jenis_pelayanan' => $pasien->jenis_pelayanan,
            'nama' => $pasien->nama,
            'lahir' => $pasien->lahir,
            'jenis_kelamin' => $pasien->jenis_kelamin,
            'no_telp' => $pasien->no_telp,
            'kode_dokter' => $pasien->kode_dokter,
            'dokter_external' => $pasien->dokter_external,
            'asal_ruangan' => $pasien->asal_ruangan,
            'diagnosa' => $pasien->diagnosa,
            'tanggal_masuk' => $pasien->tanggal_masuk,
            'alamat' => $pasien->alamat,
            'tanggal' => $pasien->tanggal,
            'status' => $pasien->status,
            'pemeriksaan' => $pasien->pemeriksaan_pasien->map(fn($p) => $p->toArray()),
        ];

        // Dispatch job ke queue (jika digunakan)
        // SendPasienToLis::dispatch($payload);

        toast('Pembayaran Berhasil', 'success');
        return redirect()->route('pasien.index');
    }




    public function checkin(Request $request)
    {
        $ids = $request->ids;
        $pasiens = pasien::whereIn('id', $ids)
            ->with('data_pemeriksaan_pasien.data_pemeriksaan')
            ->get();

        foreach ($pasiens as $pasien) {
            $has_permission = false;
            $has_handling   = false;

            foreach ($pasien->data_pemeriksaan_pasien as $pemeriksaan) {
                $detail = $pemeriksaan->data_pemeriksaan;
                if (!$detail) continue;

                if (strtolower(trim((string) $detail->permission)) === 'active') {
                    $has_permission = true;
                }

                if (strtolower(trim((string) $detail->handling)) === 'active') {
                    $has_handling = true;
                }
            }

            // Urutan prioritas status (harus melewati tahap sebelumnya)
            if ($has_permission) {
                $status = 'Telah Dikirim ke Lab';
                $proses = 'Dikirim ke dashboard';
                $tempat = 'Laboratorium';
            } elseif ($has_handling) {
                $status = 'Acc Collection';
                $proses = 'Spesimen Diterima';
                $tempat = 'Spesiment Handling';
            } else {
                $status = 'Check In Spesiment';
                $proses = 'Check in Spesiment';
                $tempat = 'Worklist';
            }

            // Update status pasien
            $pasien->update(['status' => $status]);

            // Simpan history
            historyPasien::create([
                'no_lab'       => $pasien->no_lab,
                'proses'       => $proses,
                'tempat'       => $tempat,
                'waktu_proses' => now(),
                'created_at'   => now(),
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
