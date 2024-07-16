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
use App\Models\dokter;
use App\Models\Pemeriksaan;

class pasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $data_pasien_cito = pasien::where('cito', 1)->where('status', 'Belum Dilayani')->get();
        // $data_pasien = pasien::where('cito', 0)->where('status', 'Belum Dilayani')->get();
        $data_pasien = pasien::where('status', 'Belum Dilayani')->orderBy('cito', 'desc')->paginate(20);
        $data = pasien::with('dokter')->get();
        // $data_pemeriksaan_pasien = pemeriksaan_pasien::all();
        // dd($data_pasien);
        // $data_departement = Department::all();
        // $data_pemeriksaan = Pemeriksaan::all();

        $title = 'Menghapus data Pasien!';
        $text = "Anda yakin untuk menghapus data ini?";
        confirmDelete($title, $text);

        return view('loket.index', compact('data_pasien', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $data['departments'] = Department::with('pemeriksaan')->get();
        $data['dokters'] = dokter::with('poli')->get();

        $tanggal = date('dmy');
        $urutan = pasien::where('no_lab', 'like', 'LAB'.$tanggal.'%')->count()+1;

        $urutan = sprintf("%03d", $urutan);
        $data['no_lab'] = 'LAB'.$tanggal.$urutan;

        return view('loket.tambah-pasien', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->cito)
        {
            $cito = 1;
        }
        else
        {
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
            'asal_ruangan' => '-',
            'diagnosa' => $request->diagnosa,
            'tanggal_masuk' => now(),
            'alamat' => $request->alamat,
        ]);

        $no = 0;
        foreach($request->pemeriksaan as $pemeriksaan)
        {
            // dd($nama_parameter);
            $data = Pemeriksaan::find($pemeriksaan);
            pemeriksaan_pasien::create([
                'no_lab' => $request->nolab,
                'id_parameter' => $pemeriksaan,
                'id_departement' => $data->id_departement,
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

        toast('Berhasil Menambah data pasien','success');
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

        foreach($request->pemeriksaan as $pemeriksaan)
        {
            $pemeriksaan_temp = explode(',', $pemeriksaan);

            $id_departement[] = $pemeriksaan_temp[0];

            $nama_parameter[] = $pemeriksaan_temp[1];
        }

        $no = 0;
        foreach($request->pemeriksaan as $x => $pemeriksaan)
        {
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

        toast('Berhasil mengubah data pasien','success');
        return redirect()->route('pasien.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        pasien::where('no_lab', $id)->delete();
        pemeriksaan_pasien::where('no_lab', $id)->delete();
        pembayaran::where('no_lab', $id)->delete();

        toast('Berhasil menghapus data pasien','success');
        return redirect()->route('pasien.index');
    }

    public function getIcd10(Request $request)
    {
        if($request->get('query'))
        {
            $query = $request->get('query');
            $data = icd10::where('code', 'LIKE', "%{$query}%")->orWhere('name_id', 'LIKE', "%{$query}%")->get();
            $output = '<ul class="dropdown-menu diagnosa-auto" style="display:block; position:absolute">';
            foreach($data as $row)
            {
                $output .= '
                <li><a href="#">'.$row->code.' '.$row->name_id.'</a></li>
                ';
            }
            $output .= '</ul>';
            echo $output;
        }
    }

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

    public function getDataPasien(Request $request, $lab){
        $data_pasien = pasien::where('no_lab', $lab)->first();
        $data_pemeriksaan_pasien = pemeriksaan_pasien::where('no_lab', $lab)->get();
        $id_departement_pasien = pemeriksaan_pasien::where('no_lab', $lab)->distinct()->get(['id_departement']);
        // $icd10 = icd10::all() ?? [];
        $icd10 = [];
        $data_departement = Department::all();
        $data_pemeriksaan = Pemeriksaan::all();
        $history_pasien = historyPasien::where('no_lab', $lab)->where('proses', 'Disetujui oleh analis lab')->get();
        $dataTabung = tabung::all();

        $dataOBR = obr::where('order_number', $lab)->count();

        // $res = [
        //     'success' => true,
        //     'message' => 'Data pasien ditemukan',
        //     'data_pasien' => $data_pasien,
        //     'data_pemeriksaan_pasien' => $data_pemeriksaan_pasien,
        //     'id_departement_pasien' => $id_departement_pasien,
        //     'icd10' => $icd10,
        //     'data_departement' => $data_departement,
        //     'data_pemeriksaan' => $data_pemeriksaan,
        //     'history_pasien' => $history_pasien,
        //     'dataTabung' => $dataTabung,
        //     'dataOBR' => $dataOBR,
        // ];

        if($data_pasien)
        {
            return response()->json([
                'success' => true,
                'message' => 'Data pasien ditemukan',
                'data_pasien' => $data_pasien,
                'data_pemeriksaan_pasien' => $data_pemeriksaan_pasien,
                'id_departement_pasien' => $id_departement_pasien,
                'icd10' => $icd10,
                'data_departement' => $data_departement,
                'data_pemeriksaan' => $data_pemeriksaan,
                'history_pasien' => $history_pasien,
                'dataTabung' => $dataTabung,
                'dataOBR' => $dataOBR,
            ], 200);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Data pasien tidak ditemukan',
            ], 404);
        }

        $data_pasien = pasien::where('no_lab', $lab)->with(['data_pemeriksaan_pasien.data_departement', 'data_pemeriksaan_pasien.data_pemeriksaan'])->first();

        return response()->json([$data_pasien]);
    }

    public function kirimLab(Request $request){
        $data_pasien = pasien::where('no_lab', $request->nolab)->first();

        pasien::where('no_lab', $request->no_lab)->update([
            'status' => 'Telah Dikirim ke Lab',
        ]);

        DB::table('pembayarans')->insert([
            'no_lab' => $request->no_lab,
            'metode_pembayaran' => $request->jenispelayanan,
            'total_pembayaran' => $request->hargapemeriksaan,
            'jumlah_bayar' => $request->jumlahbayar,
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

        toast('Berhasil mengirim data pasien ke Lab','success');
        return redirect()->route('pasien.index');
    }

    public function dataPasien(){
        $data_pasien = pasien::where('status', '!=', 'Belum Dilayani')->get();

        return view('loket.data-pasien', compact('data_pasien'));
    }

    public function previewPrint($lab){
        $data_pasien = pasien::where('no_lab', $lab)->first();

        $nama = $data_pasien->nama;

        $nama = str_replace(' ', '%5Ct%5Ct', $nama);

        $data = [
            'nama' => $data_pasien->nama,
            'nama_barcode' => $nama,
            'no_lab' => $data_pasien->no_lab.'%5Ct%5Ct',
        ];

        $html = view('print-view.barcode-print', $data)->render();

        $pdf = Pdf::loadHtml($html);

        $pdf->setPaper([0, 0, 144, 72]);

        return $pdf->stream();
    }
}
