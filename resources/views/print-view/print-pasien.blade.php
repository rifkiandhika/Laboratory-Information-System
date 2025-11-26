<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Cetak Hasil</title>
    <style>
        body {
            font-size: 10px !important;
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 5px;
        }
        div {
            font-family: Arial, Helvetica, sans-serif;
        }
        .table-borderless th,
        .table-borderless td {
            padding: 1px 0;
            font-size: 10px !important;
        }
        .header h5 {
            font-size: 9px !important;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .header p {
            font-size: 8px !important;
            margin-bottom: 2px;
        }
        hr {
            margin: 3px 0;
            border-top: 1px solid black;
        }
        .data-pasien table {
            font-size: 12px !important;
        }
        .hasil-pemeriksaan {
            position: relative;
            min-height: auto;
            padding-bottom: 0;
        }
        #tabel-pemeriksaan table {
            font-size: 9px !important;
        }
        #tabel-pemeriksaan th, 
        #tabel-pemeriksaan td {
            padding: 2px 3px !important;
        }
        .note-section {
            font-size: 10px !important;
            margin-top: 8px;
        }
        .footer {
            position: static;
            margin-top: 15px;
            border-top: 1px solid #000;
            padding-top: 8px;
        }

        .footer-container h6 {
            font-size: 8px !important;
            margin-bottom: 15px;
        }
        .bg-light {
            background-color: #f8f9fa !important;
            padding: 3px !important;
        }

        @media print {
            body {
                font-size: 10pt !important;
                color: black;
                background-color: white !important;
                margin: 0;
                padding: 5px;
            }
            .no-print {
                display: none;
            }
            .print-only {
                display: block;
            }
            .header h5, .header p,
            #tabel-pemeriksaan table,
            .note-section,
            .footer-container h6 {
                font-size: 12pt !important;
            }
            .table-borderless th,
            .table-borderless td {
                padding: 1px 0;
                font-size: 16px !important;
            }
            .footer-container {
                padding: 15px;
            }
            .footer-container .user-info {
                flex: 1;
            }
            .footer-container .doctor-info {
                flex: 1;
                text-align: right;
            }
            .footer-container h6 {
                margin: 0;
            }
            .flag i, .flag .printable-icon {
                display: inline-block !important;
                font-size: 12px !important;
            }
            .text-primary {
                color: #206bc4 !important;
            }
            .text-danger {
                color: #d63939 !important;
            }
            .printable-icon {
                font-weight: bold;
                font-size: 12px !important;
            }
        }

        .flag i {
            font-family: 'tabler-icons' !important;
            font-style: normal;
            font-size: 12px !important;
        }

        .address-container {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 0.3rem;
        }
        .address-label {
            white-space: nowrap;
        }
        .address-value {
            word-wrap: break-word;
        }

        .rapi-table {
            table-layout: fixed;
            width: 100%;
        }
        
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -5px;
            margin-left: -5px;
        }
        .col-3, .col-8, .col-4 {
            position: relative;
            width: 100%;
            padding-right: 5px;
            padding-left: 5px;
        }
        .col-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }
        .col-8 {
            flex: 0 0 66.666667%;
            max-width: 66.666667%;
        }
        .col-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }
        .text-center {
            text-align: center !important;
        }
        .text-end {
            text-align: right !important;
        }
        .fw-bold {
            font-weight: bold !important;
        }
        .mb-0 {
            margin-bottom: 0 !important;
        }
        .mb-2 {
            margin-bottom: 5px !important;
        }
        .ms-2 {
            margin-left: 5px !important;
        }
        .ml-4 {
            margin-left: 15px !important;
        }
        .p-0 {
            padding: 0 !important;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .table {
            width: 100%;
            margin-bottom: 8px;
            border-collapse: collapse;
        }
        .table-sm th, .table-sm td {
            padding: 2px;
        }
        .table-borderless th, .table-borderless td {
            border: none;
        }
        .d-flex {
            display: flex !important;
        }
        .justify-content-between {
            justify-content: space-between !important;
        }
        .bg-light {
            background-color: #f8f9fa !important;
        }
        @font-face {
            font-family: "Calibri Light";
            src: url("/fonts/calibril.ttf") format("truetype");
            font-weight: normal;
            font-style: normal;
        }
        .calibri {
            font-family: "Calibri Light", Calibri, sans-serif;
            white-space: pre;
        }
        .courier-new {
            font-family: "Courier New", Courier, monospace;
            white-space: pre;
        }

        .content {
            padding: 20px;
            height: 1200px;
        }

        .footer-en {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 60px;
            padding: 15px;
        }

        .footer-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #555;
            font-size: 14px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
</head>
<body>
    <div>
        <div class="header text-sm pb-1 mb-2" style="margin-bottom: 10px;">
            <div class="d-flex justify-content-between align-items-center" style="width: 100%; text-align: center;">
                <div style="flex: 1; text-align: left;">
                    <img src="{{ asset('image/YKU.png') }}" alt="Yayasan" style="width: 180px; opacity: 65%;">
                </div>
                <div style="flex: 1; text-align: center;">
                    <img src="{{ asset('image/KRIMS-1.png') }}" alt="Klinik Utama Muslimat Singosari" style="width: 250px; opacity: 80%;">
                </div>
                <div style="flex: 1; text-align: right;">
                    <img src="{{ asset('image/LASKESI.png') }}" alt="Laskesi" style="width: 180px; opacity: 65%;">
                </div>
            </div>

            <div style="margin-top: 8px;">
                <table style="width: 100%; text-align: center;">
                    <tr>
                        <th style="padding: 0 10px;">
                            <span class="icon"><i class="ti ti-mail"></i></span>
                            <span class="text">rs.muslimatsingosari@gmail.com</span>
                        </th>
                        <th style="padding: 0 10px;">
                            <span class="icon"><i class="ti ti-map-pin"></i></span>
                            <span class="text">Jl. Ronggolawe 24 Singosari Malang, 65153</span>
                        </th>
                        <th style="padding: 0 10px;">
                            <span class="icon"><i class="ti ti-phone"></i></span>
                            <span class="text">+62 341 458344</span>
                        </th>
                    </tr>
                </table>
            </div>

            <hr style="border-top: 1px solid black; margin-top: 5px;">
        </div>

        <div class="data-pasien mb-2"> 
            <div class="row"> 
                <div class="col-12"> 
                    <table class="table table-borderless table-sm mb-0" style="width:100%;"> 
                        <tr> 
                            <td style="width:120px;">No. RM</td> 
                            <td style="width:10px;">:</td> 
                            <td style="width:200px;">{{ $data_pasien->no_rm ?? '-'}}</td> 
                            <td style="width:150px;">No. Laboratorium</td> 
                            <td style="width:10px;">:</td> 
                            <td style="width:150px;">{{ $data_pasien->no_lab ?? '-' }}</td> 
                        </tr> 
                        <tr> 
                            <td>Nama Pasien</td> 
                            <td>:</td> 
                            <td><b>{{ $data_pasien->nama ?? '-'}}</b></td> 
                            <td>Tanggal Transaksi</td> 
                            <td>:</td> 
                            <td>{{ $data_pasien->tanggal_masuk ? \Carbon\Carbon::parse($data_pasien->tanggal_masuk)->format('d-m-Y H:i:s') : '-' }}</td>
                        </tr> 
                        <tr> 
                            @php
                                $lahir = \Carbon\Carbon::parse($data_pasien->lahir);
                                $sekarang = \Carbon\Carbon::now();
                                $umur = $lahir->diff($sekarang);
                            @endphp
                            <td>Umur</td> 
                            <td>:</td> 
                            <td> {{ $umur->y }} Tahun {{ $umur->m }} Bulan {{ $umur->d }} Hari  </td> 
                            <td>Tanggal Diterima</td> 
                            <td>:</td> 
                            <td>{{ $data_pasien->created_at ? $data_pasien->created_at->format('d-m-Y H:i:s') : '-' }}</td>
                        </tr> 
                        <tr> 
                            <td>Jenis Kelamin</td> 
                            <td>:</td> 
                            <td>{{ $data_pasien->jenis_kelamin ?? '-'}}</td> 
                            <td>Tanggal Selesai</td> 
                            <td>:</td> 
                            <td>{{ $data_pasien->updated_at ? $data_pasien->updated_at->format('d-m-Y H:i:s') : '-' }}</td>
                        </tr> 
                        <tr> 
                            <td>Asal Pasien</td> 
                            <td>:</td> 
                            <td>{{ $data_pasien->asal_ruangan }}</td> 
                            <td>Dokter External / Pengirim</td> 
                            <td>:</td> 
                            <td>{{ $data_pasien->dokter_external ?? '-'}}</td> 
                        </tr> 
                        <tr> 
                            <td>Dokter Internal / Pengirim</td> 
                            <td>:</td> 
                            <td colspan="4">{{ $data_pasien->kode_dokter ?? '-'}}</td> 
                        </tr> 
                        <tr> 
                            <td>Alamat Pasien</td> 
                            <td>:</td> 
                            <td colspan="4">{{ $data_pasien->alamat ?? '-'}}</td> 
                        </tr> 
                    </table> 
                </div> 
            </div> 
        </div>
        
        <div class="hasil-pemeriksaan p-0">
            <p class="calibri m-0 p-0 text-center" style="font-size: 18px"><b>HASIL LABORATORIUM</b></p>
            <div id="tabel-pemeriksaan" class="table-responsive">
                <table class="table table-sm table-borderless table-striped" id="worklistTable">
                    <thead style="border-top: 1px solid black; border-bottom: 1px solid black">
                        <tr>
                            <th style="width: 30%; padding: 3px; font-size: 14px">Jenis Pemeriksaan</th>
                            <th style="width: 20%; padding: 3px; font-size: 14px">Hasil</th>
                            <th style="width: 10%; padding: 3px; font-size: 14px">Flag</th>
                            <th class="text-center" style="width: 10%; padding: 3px; font-size: 14px">Satuan</th>
                            <th class="text-center" style="width: 15%; padding: 3px; font-size: 14px">Nilai Rujukan</th>
                            <th class="text-center" style="width: 15%; padding: 3px; font-size: 14px">Metode</th>
                        </tr>
                    </thead>
                    <tbody id="hasil-tbody">
                        @foreach ($hasil_pemeriksaans->groupBy('department') as $department => $hasil_group)
                            <tr>
                                <th colspan="6" style="font-size: 14px; font-weight: 900;">
                                    <b><strong>{{ strtoupper($department) }}</strong></b>
                                </th>
                            </tr>

                            @foreach ($hasil_group->groupBy('judul') as $judul => $group_by_judul)
                                @if($judul)
                                    <tr>
                                        <td style="font-size: 14px;" colspan="6"><b>‎ ‎{{ $judul ?? '' }}</b></td>
                                    </tr>
                                @endif

                                @foreach ($group_by_judul as $hasil)
                                    @php
                                        if (
                                            strtolower($hasil->nama_pemeriksaan) === strtolower($department)
                                            && strtolower($department) !== 'golongan darah'
                                        ) {
                                            continue;
                                        }

                                        $rujukanDefaults = [
                                            'WBC' => 'L. 4.0-10.0 P. 4.0-10.0',
                                            'LYM#' => '1.0-4.0',
                                            'MID#' => '0.2-0.8',
                                            'GRAN#' => '2.0-7.0',
                                            'LYM%' => '20-40',
                                            'MID%' => '3-15',
                                            'GRAN%' => '50-70',
                                            'RBC' => 'L. 4.5-6.5 P. 3.0-6.0',
                                            'HGB' => 'L. 13.3-17.0 P. 11.7-15.7',
                                            'HCT' => 'L. 40-50 P. 36-46',
                                            'MCV' => '80-100',
                                            'MCH' => '27-33',
                                            'MCHC' => '32-36',
                                            'RDW-CV' => '11.5-14.5',
                                            'RDW-SD' => '39-46',
                                            'PLT' => '150-350',
                                            'MPV' => '7-11',
                                            'PDW' => '10-18',
                                            'PCT' => '0.15-0.50',
                                            'P-LCC' => '30-90',
                                            'P-LCR' => '13-43',
                                            'Salmonella Typhi H' => 'Negatif',
                                            'Salmonella Typhi O' => 'Negatif',
                                            'Salmonella Paratyphi AO' => 'Negatif',
                                            'Salmonella Paratyphi BO' => 'Negatif',
                                            'Warna' => 'Kuning',
                                            'Kekeruhan' => 'Jernih',
                                            'Berat Jenis' => '1.003-1.035',
                                            'PH' => '4.5-8.0',
                                            'Leukosit' => 'Negatif',
                                            'Nitrit' => 'Negatif',
                                            'Protein' => 'Negatif',
                                            'Glukosa' => 'Negatif',
                                            'Keton' => 'Negatif',
                                            'Urobilinogen' => 'Negatif',
                                            'Bilirubin' => 'Negatif',
                                            'Blood' => 'Negatif',
                                            'Eritrosit' => '0-2 /lpb',
                                            'Leukosit_sedimen' => '0-5 /lpb',
                                            'Epithel' => 'Tidak ada - Sedikit',
                                            'Silinder' => 'Tidak ada',
                                            'Kristal' => 'Tidak ada',
                                            'Bakteri' => 'Tidak ada',
                                            'Jamur' => 'Tidak ada',
                                            'Lain-lain' => '-'
                                        ];

                                        $jenis_kelamin = strtolower($data_pasien->jenis_kelamin);

                                        $raw_rujukan = $nilai_rujukan_map[$hasil->nama_pemeriksaan] 
                                            ?? $rujukanDefaults[$hasil->nama_pemeriksaan] 
                                            ?? $hasil->range 
                                            ?? null;

                                        $nilai_rujukan = '';

                                        if ($raw_rujukan) {
                                            $raw_rujukan = preg_replace('/\s+/', ' ', trim($raw_rujukan));

                                            preg_match('/L\.\s*([\d\.,\-–]+)/i', $raw_rujukan, $match_l);
                                            preg_match('/P\.\s*([\d\.,\-–]+)/i', $raw_rujukan, $match_p);

                                            if ($jenis_kelamin === 'laki-laki' && isset($match_l[1])) {
                                                $nilai_rujukan = trim($match_l[1]);
                                            } elseif ($jenis_kelamin === 'perempuan' && isset($match_p[1])) {
                                                $nilai_rujukan = trim($match_p[1]);
                                            }

                                            if (empty($nilai_rujukan) && !str_contains($raw_rujukan, 'L.') && !str_contains($raw_rujukan, 'P.')) {
                                                $nilai_rujukan = $raw_rujukan;
                                            }
                                        }

                                        $hematologiMapping = [
                                            'WBC'   => 'Leukosit',
                                            'LYM#'  => 'LYM#',
                                            'MID#'  => 'MID#',
                                            'GRAN#' => 'GRAN#',
                                            'LYM%'  => 'Limfosit',
                                            'MID%'  => 'Monosit',
                                            'GRAN%' => 'Granulosit',
                                            'RBC'   => 'Eritrosit',
                                            'HGB'   => 'Hemoglobin',
                                            'HCT'   => 'Hematokrit',
                                            'MCV'   => 'MCV',
                                            'MCH'   => 'MCH',
                                            'MCHC'  => 'MCHC',
                                            'RDW-CV'=> 'RDW-CV',
                                            'RDW-SD'=> 'RDW-SD',
                                            'PLT'   => 'Trombosit',
                                            'MPV'   => 'MPV',
                                            'PDW'   => 'PDW',
                                            'PCT'   => 'PCT',
                                            'P-LCR' => 'P-LCR',
                                        ];

                                        // Tentukan flag mana yang digunakan
                                        $displayFlag = ($hasil->is_switched == 1) ? $hasil->flag_dx : $hasil->flag;
                                    @endphp

                                    <tr>
                                        <td>
                                            <strong>‎ ‎ ‎ ‎</strong>{{ $hematologiMapping[$hasil->nama_pemeriksaan] ?? $hasil->nama_pemeriksaan }}
                                        </td>
                                        <td>
                                            @if($hasil->nama_pemeriksaan === 'WBC')
                                                {{ (strpos($hasil->hasil, '.') !== false && strlen(substr(strrchr($hasil->hasil, "."), 1)) == 2) 
                                                    ? $hasil->hasil . '0' 
                                                    : $hasil->hasil }}
                                            @elseif($hasil->nama_pemeriksaan === 'PLT')
                                                {{ $hasil->hasil . '.000' }}
                                            @else
                                                {{ $hasil->hasil ?? 'Tidak ada hasil' }}
                                            @endif
                                        </td>
                                        <td class="flag" style="font-weight: 900">
                                            @if(strtolower($displayFlag) === 'high')
                                                <i class="ti ti-arrow-up text-danger"></i>
                                            @elseif(strtolower($displayFlag) === 'low')
                                                <i class="ti ti-arrow-down text-primary"></i>
                                            @elseif(strtolower($displayFlag) === 'high*')
                                                <i class="ti ti-arrow-up text-danger">*</i>
                                            @elseif(strtolower($displayFlag) === 'low*')
                                                <i class="ti ti-arrow-down text-primary">*</i>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $hasil->satuan ?? '-' }}</td>
                                        <td class="text-center">{{ $nilai_rujukan ?? '-' }}</td>
                                        <td class="text-center">{{ $hasil->metode ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
                <hr>
            </div>
        </div>
        
        @if($hasil_pemeriksaans->first() && $hasil_pemeriksaans->first()->note)
            <table class="note-section">
                <tr>
                    <td valign="top" style="white-space: nowrap;"><b>Catatan :</b></td>
                    <td class="courier-new">- {{ $hasil_pemeriksaans->first()->note }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="courier-new">- Hasil di atas merupakan interpretasi berdasarkan pemeriksaan laboratorium saat ini dan dari keterangan klinis yang dicantumkan.</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="courier-new">- *) Nilai Kritis</td>
                </tr>
            </table>
        @else
            <table class="note-section">
                <tr>
                    <td valign="top" style="white-space: nowrap;"><b>Catatan :</b></td>
                    <td class="courier-new">- Hasil di atas merupakan interpretasi berdasarkan pemeriksaan laboratorium saat ini dan dari keterangan klinis yang dicantumkan.</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="courier-new">- *) Nilai Kritis</td>
                </tr>
            </table>
        @endif

        <div class="footer-container d-flex justify-content-between align-items-start">
            @if($dokterName && $userDokter && $userDokter->signature && $userDokter->status === 'active')
                <!-- KIRI: Dokter Internal -->
                <div class="doctor-info">
                    <h6 style="margin-left: 15px;">Dokter Pemeriksa</h6>
                    <div style="text-align: left; margin-left: 15px;">
                        <img src="{{ asset('signatures/' . $userDokter->signature) }}"
                            alt="Signature"
                            style="display:block; height:150px; width:auto; object-fit:contain; margin-left:auto;">
                        <span style="border-bottom:1px solid #000; padding:0 5px;">
                            {{ $dokterName }}
                        </span>
                        <div style="margin-top:2px;">
                            NIK. {{ $data_pasien->dokter->nip ?? '' }}
                        </div>
                    </div>
                </div>

                <!-- KANAN: Analis dari tabel pasien -->
                @if($userAnalyst && $userAnalyst->status === 'active')
                <div class="user-info text-end">
                    <h6 style="margin-right: 60px;">Analis Pemeriksa</h6>
                    @if($userAnalyst->signature)
                        <img src="{{ asset('signatures/' . $userAnalyst->signature) }}"
                            alt="Signature"
                            style="display:block; height:150px; width:auto; object-fit:contain; margin-left:auto;">
                    @endif
                    <div style="padding-right: 25px; margin-top:5px; text-align:right; margin-right: 15px;">
                        <div style="display: inline-block; text-align: center;">
                            <div style="padding-top: 2px; min-width: 65px;">
                                <div style="font-weight: bold;">{{ $userAnalyst->name }}</div>
                                <div style="border-top: 1px solid #000;">NIK. {{ $userAnalyst->nik }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @else
                <!-- Kalau tidak ada dokter/signature, hanya tampilkan analyst -->
                @if($userAnalyst && $userAnalyst->status === 'active')
                <div class="doctor-info text-end w-100">
                    <h6 style="margin-right: 60px;">Analis Pemeriksa</h6>
                    @if($userAnalyst->signature)
                        <img src="{{ asset('signatures/' . $userAnalyst->signature) }}"
                            alt="Signature"
                            style="display:block; height:150px; width:auto; object-fit:contain; margin-left:auto;">
                    @endif
                    <div style="padding-right: 25px; margin-top:5px; text-align:right; margin-right: 15px;">
                        <div style="display: inline-block; text-align: center;">
                            <div style="padding-top: 2px; min-width: 65px;">
                                <div style="font-weight: bold;">{{ $userAnalyst->name }}</div>
                                <div style="border-top: 1px solid #000;">NIK. {{ $userAnalyst->nik }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endif
        </div>

        <table class="note-section calibri">
            @if($hasil_pemeriksaans->first() && $hasil_pemeriksaans->first()->kesimpulan)
                <tr>
                    <td><b>Kesimpulan :</b></td>
                    <td class="courier-new"> - {{ $hasil_pemeriksaans->first()->kesimpulan }}</td>
                </tr>
            @endif
            @if($hasil_pemeriksaans->first() && $hasil_pemeriksaans->first()->saran)
                <tr>
                    <td><b>Saran :</b></td>
                    <td class="courier-new"> - {{ $hasil_pemeriksaans->first()->saran }}</td>
                </tr>
            @endif
        </table>

    </div>
</body>
</html>