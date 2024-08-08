<?php

namespace App\Http\Controllers\loket;

use Alert;
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
        $data_pasien = pasien::where('status', 'Belum Dilayani')->orderBy('cito', 'desc')->paginate(20);
        // $data_pemeriksaan_pasien = pemeriksaan_pasien::all();
        // dd($data_pasien);
        // $data_departement = Department::all();
        // $data_pemeriksaan = Pemeriksaan::all();



        return view('loket.index', compact('data_pasien', 'data', 'tanggal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $data['departments'] = Department::with('pemeriksaan')->get();
        $data['dokters'] = dokter::with('poli')->get();

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

        $harga = (int)str_replace('.', '', $request->hargapemeriksaan);

        // $harga = (int)$harga;

        // foreach($request->pemeriksaan as $pemeriksaan)
        // {
        //     $pemeriksaan_temp = explode(',', $pemeriksaan);

        //     $id_departement[] = $pemeriksaan_temp[0];

        //     $nama_parameter[] = $pemeriksaan_temp[1];
        // } 

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
            'kode_dokter' => $request->dokter,
            'asal_ruangan' => $request->asal_ruangan,
            'diagnosa' => $request->diagnosa,
            'tanggal_masuk' => now(),
            'alamat' => $request->alamat,
        ]);

        $no = 0;
        foreach ($request->pemeriksaan as $pemeriksaan) {
            // dd($nama_parameter);
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
        }

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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $lab)
    {

        $harga = str_replace('.', '', $request->hargapemeriksaan);

        $harga = (int)$harga;

        pasien::where('no_lab', $request->nolab)->update([
            'nik' => $request->nik,
            'jenis_pelayanan' => $request->jenis_pelayanan,
            'nama' => $request->nama,
            'lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telp' => $request->no_telepon,
            'kode_dokter' => $request->dokter,
            'asal_ruangan' => $request->ruangan,
            'diagnosa' => $request->diagnosa,
            'tanggal_masuk' => now(),
            'alamat' => $request->alamat,
        ]);

        pemeriksaan_pasien::where('no_lab', $request->nolab)->delete();

        foreach ($request->pemeriksaan as $pemeriksaan) {
            $pemeriksaan_temp = explode(',', $pemeriksaan);

            $id_departement[] = $pemeriksaan_temp[0];

            $nama_parameter[] = $pemeriksaan_temp[1];
        }

        $no = 0;
        foreach ($request->pemeriksaan as $x => $pemeriksaan) {
            pemeriksaan_pasien::create([
                'no_lab' => $request->nolab,
                'id_departement' => explode(',', $pemeriksaan)[1],
                'nama_parameter' => $nama_parameter[$no],
                'harga' => $harga,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $no++;
        }

        historyPasien::where('no_lab', $request->nolab)->update([
            'waktu_proses' => now(),
        ]);

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

    public function getIcd10(Request $request)
    {
        //     if ($request->get('query')) {
        //         $query = $request->get('query');
        //         $data = icd10::where('code', 'LIKE', "%{$query}%")->orWhere('name_id', 'LIKE', "%{$query}%")->get();
        //         $output = '<ul class="dropdown-menu diagnosa-auto" style="display:block; position:absolute">';
        //         foreach ($data as $row) {
        //             $output .= '
        //             <li><a href="#">' . $row->code . ' ' . $row->name_id . '</a></li>
        //             ';
        //         }
        //         $output .= '</ul>';
        //         echo $output;
        //     }
        // }

        // public function getDataPasien($lab)
        // {
        //     $data_pasien = pasien::where('no_lab', $lab)->first();
        //     $data_pemeriksaan_pasien = pemeriksaan_pasien::where('no_lab', $lab)->get();
        //     $id_departement_pasien = pemeriksaan_pasien::where('no_lab', $lab)->distinct()->get(['id_departement']);
        //     // $icd10 = icd10::all() ?? [];
        //     $icd10 = [];
        //     $data_departement = Department::all();
        //     $data_pemeriksaan = Pemeriksaan::all();
        //     $history_pasien = historyPasien::where('no_lab', $lab)->where('proses', 'Disetujui oleh analis lab')->get();
        //     $dataTabung = tabung::all();

        //     $dataOBR = obr::where('order_number', $lab)->count();

        //     if($data_pasien)
        //     {
        //         return response()->json([
        //             'success' => true,
        //             'message' => 'Data pasien ditemukan',
        //             'data_pasien' => $data_pasien,
        //             'data_pemeriksaan_pasien' => $data_pemeriksaan_pasien,
        //             'id_departement_pasien' => $id_departement_pasien,
        //             'icd10' => $icd10,
        //             'data_departement' => $data_departement,
        //             'data_pemeriksaan' => $data_pemeriksaan,
        //             'history_pasien' => $history_pasien,
        //             'dataTabung' => $dataTabung,
        //             'dataOBR' => $dataOBR,
        //         ], 200);
        //     }
        //     else
        //     {
        //         return response()->json([
        //             'success' => false,
        //             'message' => 'Data pasien tidak ditemukan',
        //         ], 404);
        //     }
        // }
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
                }, 'dpp.data_departement', 'dokter', 'history', 'spesiment.details', 'spesimentcollection', 'spesimenthandling.details', 'hasil_pemeriksaan'
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
        $data_pasien = pasien::where('no_lab', $request->nolab)->first();

        pasien::where('no_lab', $request->no_lab)->update([
            'status' => 'Telah Dikirim ke Lab',
        ]);
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
            'proses' => 'Payment',
            'tempat' => 'Loket',
            'waktu_proses' => now(),
        ]);

        toast('Berhasil mengirim data pasien ke Lab', 'success');
        return redirect()->route('pasien.index');
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
