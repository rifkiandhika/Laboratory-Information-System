<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Cetak Hasil</title>
    <style>
        body {
            font-size: 8px !important;
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
            font-size: 8px !important;
        }
        .hasil-pemeriksaan {
            position: relative;
            min-height: auto;   /* ikut isi, bukan paksa setengah halaman */
            padding-bottom: 0;  /* buang jarak ekstra */
        }
        #tabel-pemeriksaan table {
            font-size: 8px !important;
        }
        #tabel-pemeriksaan th, 
        #tabel-pemeriksaan td {
            padding: 2px 3px !important;
        }
        .note-section {
            font-size: 8px !important;
            margin-top: 8px;
        }
        .footer {
            position: static;
            margin-top: 15px;
            border-top: 1px solid #000; /* kasih garis pemisah */
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
                font-size: 8pt !important;
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
            .data-pasien table,
            #tabel-pemeriksaan table,
            .note-section,
            .footer-container h6 {
                font-size: 8pt !important;
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
            }
            .text-primary {
                color: #206bc4 !important;
            }
            .text-danger {
                color: #d63939 !important;
            }
            .printable-icon {
                font-weight: bold;
                font-size: 8px !important;
            }
        }

        .flag i {
            font-family: 'tabler-icons' !important;
            font-style: normal;
            font-size: 8px !important;
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
        
        /* Tambahan untuk tampilan lebih rapi */
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
            src: url("/fonts/calibril.ttf") format("truetype"); /* path ke file Calibri Light */
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

    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
</head>
<body>
    <script>
        // Parameter mapping untuk semua jenis pemeriksaan dengan rujukan defaults
        const hematologiParams = [
            { nama: 'WBC', display_name: 'Leukosit', rujukan: 'L. 4.0-10.0 P. 4.0-10.0' },
            { nama: 'LYM#', display_name: 'LYM#', rujukan: '1.0-4.0' },
            { nama: 'MID#', display_name: 'MID#', rujukan: '0.2-0.8' },
            { nama: 'GRAN#', display_name: 'GRAN#', rujukan: '2.0-7.0' },
            { nama: 'LYM%', display_name: 'Limfosit', rujukan: '20-40' },
            { nama: 'MID%', display_name: 'Monosit', rujukan: '3-15' },
            { nama: 'GRAN%', display_name: 'Granulosit', rujukan: '50-70' },
            { nama: 'RBC', display_name: 'Eritrosit', rujukan: 'L. 4.5-6.5 P. 3.0-6.0' },
            { nama: 'HGB', display_name: 'Hemoglobin', rujukan: 'L. 13.3-17.0 P. 11.7-15.7' },
            { nama: 'HCT', display_name: 'Hematokrit', rujukan: 'L. 40-50 P. 36-46' },
            { nama: 'MCV', display_name: 'MCV', rujukan: '80-100' },
            { nama: 'MCH', display_name: 'MCH', rujukan: '27-33' },
            { nama: 'MCHC', display_name: 'MCHC', rujukan: '32-36' },
            { nama: 'RDW-CV', display_name: 'RDW-CV', rujukan: '11.5-14.5' },
            { nama: 'RDW-SD', display_name: 'RDW-SD', rujukan: '39-46' },
            { nama: 'PLT', display_name: 'Trombosit', rujukan: '150-350' },
            { nama: 'MPV', display_name: 'MPV', rujukan: '7-11' },
            { nama: 'PDW', display_name: 'PDW', rujukan: '10-18' },
            { nama: 'PCT', display_name: 'PCT', rujukan: '0.15-0.50' },
            { nama: 'P-LCC', display_name: 'P-LCC', rujukan: '30-90' },
            { nama: 'P-LCR', display_name: 'P-LCR', rujukan: '13-43' }
        ];

        const WidalParams = [
            { nama: 'Salmonella Typhi H', display_name: 'Salmonella Typhi H', rujukan: 'Negatif' },
            { nama: 'Salmonella Typhi O', display_name: 'Salmonella Typhi O', rujukan: 'Negatif' },
            { nama: 'Salmonella Paratyphi AO', display_name: 'Salmonella Paratyphi AO', rujukan: 'Negatif' },
            { nama: 'Salmonella Paratyphi BO', display_name: 'Salmonella Paratyphi BO', rujukan: 'Negatif' }
        ];

        const UrineParams = [
            // Makroskopis
            { nama: 'Warna', display_name: 'Warna', rujukan: 'Kuning' },
            { nama: 'Kekeruhan', display_name: 'Kekeruhan', rujukan: 'Jernih' },
            { nama: 'Berat Jenis', display_name: 'Berat Jenis', rujukan: '1.003-1.035' },
            // Kimia
            { nama: 'PH', display_name: 'pH', rujukan: '4.5-8.0' },
            { nama: 'Leukosit', display_name: 'Leukosit', rujukan: 'Negatif' },
            { nama: 'Nitrit', display_name: 'Nitrit', rujukan: 'Negatif' },
            { nama: 'Protein', display_name: 'Protein', rujukan: 'Negatif' },
            { nama: 'Glukosa', display_name: 'Glukosa', rujukan: 'Negatif' },
            { nama: 'Keton', display_name: 'Keton', rujukan: 'Negatif' },
            { nama: 'Urobilinogen', display_name: 'Urobilinogen', rujukan: 'Negatif' },
            { nama: 'Bilirubin', display_name: 'Bilirubin', rujukan: 'Negatif' },
            { nama: 'Blood', display_name: 'Blood', rujukan: 'Negatif' },
            // Sedimen
            { nama: 'Eritrosit', display_name: 'Eritrosit', rujukan: '0-2 /lpb' },
            { nama: 'Leukosit_sedimen', display_name: 'Leukosit', rujukan: '0-5 /lpb' },
            { nama: 'Epithel', display_name: 'Epithel', rujukan: 'Tidak ada - Sedikit' },
            { nama: 'Silinder', display_name: 'Silinder', rujukan: 'Tidak ada' },
            { nama: 'Kristal', display_name: 'Kristal', rujukan: 'Tidak ada' },
            { nama: 'Bakteri', display_name: 'Bakteri', rujukan: 'Tidak ada' },
            { nama: 'Jamur', display_name: 'Jamur', rujukan: 'Tidak ada' },
            { nama: 'Lain-lain', display_name: 'Lain-lain', rujukan: '-' }
        ];

        // Gabungkan semua parameter untuk mapping yang mudah
        const allParams = [...hematologiParams, ...WidalParams, ...UrineParams];
        const paramMapping = {};
        const rujukanMapping = {};

        allParams.forEach(param => {
            paramMapping[param.nama] = param.display_name;
            rujukanMapping[param.nama] = param.rujukan;
        });

        // Fungsi untuk mendapatkan display name
        function getDisplayName(namaParameter) {
            return paramMapping[namaParameter] || namaParameter;
        }

        // Fungsi untuk mendapatkan rujukan default
        function getRujukanDefault(namaParameter) {
            return rujukanMapping[namaParameter];
        }

        // Fungsi untuk memformat hasil berdasarkan parameter khusus
        function formatHasil(hasil, namaParameter) {
            if (!hasil || hasil === '' || hasil === null) {
                return hasil;
            }
            
            // Konversi ke string untuk pemrosesan
            let hasilStr = hasil.toString();
            
            // Format khusus untuk WBC - tambahkan satu angka 0 di belakang
            if (namaParameter === 'WBC') {
                // Cek apakah sudah berupa angka
                const numericValue = parseFloat(hasilStr);
                if (!isNaN(numericValue)) {
                    // Jika tidak ada desimal, tambahkan .0
                    if (!hasilStr.includes('.')) {
                        return hasilStr + '.0';
                    } else {
                        // Jika sudah ada desimal, tambahkan 0 di akhir
                        return hasilStr + '0';
                    }
                }
            }
            
            // Format khusus untuk PLT - tambahkan tiga angka 0 di belakang (.000)
            if (namaParameter === 'PLT') {
                const numericValue = parseFloat(hasilStr);
                if (!isNaN(numericValue)) {
                    // Jika tidak ada desimal, tambahkan .000
                    if (!hasilStr.includes('.')) {
                        return hasilStr + '.000';
                    } else {
                        // Jika sudah ada desimal, tambahkan 000 di akhir
                        return hasilStr + '000';
                    }
                }
            }
            
            // Return hasil original jika bukan WBC atau PLT
            return hasil;
        }

        // Fungsi untuk menentukan flag berdasarkan nilai dan parameter
        function getFlag(hasil, namaParameter) {
            if (!hasil || hasil === '' || hasil === null) {
                return '';
            }
            
            // Untuk parameter numerik hematologi
            if (namaParameter && ['WBC', 'LYM#', 'MID#', 'GRAN#', 'RBC', 'HGB', 'HCT', 'MCV', 'MCH', 'MCHC', 'RDW-CV', 'RDW-SD', 'PLT', 'MPV', 'PDW', 'PCT', 'P-LCC', 'P-LCR'].includes(namaParameter)) {
                const numericValue = parseFloat(hasil);
                if (!isNaN(numericValue)) {
                    // Logika flag berdasarkan rujukan (contoh sederhana)
                    const rujukan = rujukanMapping[namaParameter];
                    if (rujukan && rujukan.includes('-')) {
                        // Parse rujukan untuk mendapatkan range
                        const match = rujukan.match(/([\d\.]+)-([\d\.]+)/);
                        if (match) {
                            const min = parseFloat(match[1]);
                            const max = parseFloat(match[2]);
                            if (numericValue < min) {
                                return '<i class="ti ti-arrow-down text-primary"></i>';
                            } else if (numericValue > max) {
                                return '<i class="ti ti-arrow-up text-danger"></i>';
                            }
                        }
                    }
                }
            }
            
            // Untuk parameter non-numerik (Widal, Urine), biasanya tidak ada flag
            // kecuali ada kondisi khusus yang ingin ditampilkan
            return '';
        }
    </script>

    <div>
        <div class="header text-sm pb-1 mb-2">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Logo -->
                <div style="width:120px;">
                    <img src="{{ asset('image/KRIMS.png') }}" width="100" alt="Logo">
                </div>

                <!-- Teks Header -->
                <div class="text-end" style="color:#0b980b; line-height:1.2; flex:1;">
                    <p class="m-0 p-0 fw-bolder" style="font-size:15px !important;">LABORATORIUM</p>
                    <p class="m-0 p-0 fw-bolder" style="font-size:15px !important; ">KLINIK RAWAT INAP MUSLIMAT SINGOSARI</p>
                    <p class="m-0 p-0" style="font-family: 'Times New Roman', Times, serif; font-size:12px !important;">Ijin Operasional No. 12120003102510002</p>
                    <p class="m-0 p-0" style="font-family: 'Times New Roman', Times, serif; font-size:12px !important; ">Jalan Ronggolawe No.24, Pangetan, Kec. Singosari, Kab. Malang</p>
                    <p class="m-0 p-0" style="font-family: 'Times New Roman', Times, serif; font-size:12px !important;">Telp. (0341) 458344 e-mail : rs.muslimatsingosari@gmail.com</p>
                    {{-- <p class="m-0 p-0" style="font-family: 'Times New Roman', Times, serif; font-size:12px !important;">Pelayanan 24 Jam</p> --}}
                </div>
            </div>
        </div>
        <hr style="border-top: 1px solid black;">
        
        <div class="data-pasien mb-2">
            <div class="row">
                <div class="col-12">
                   <table class="table table-borderless table-sm mb-0" style="font-size:14px; width:100%;">
                        <tr>
                            <td style="width:120px;">No. RM</td>
                            <td style="width:10px;">:</td>
                            <td style="width:250px;">{{ $data_pasien->no_rm ?? '-'}}</td>
                            <td style="width:150px;">No. Laboratorium</td>
                            <td style="width:10px;">:</td>
                            <td>{{ $data_pasien->no_lab ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Nama Pasien</td>
                            <td>:</td>
                            <td><b>{{ $data_pasien->nama ?? '-'}}</b></td>
                            <td>Tanggal Transaksi</td>
                            <td>:</td>
                            <td>{{ $data_pasien->tanggal_masuk ?? '-'}}</td>
                        </tr>
                        <tr>
                            <td>Umur</td>
                            <td>:</td>
                            <td>{{ \Carbon\Carbon::parse($data_pasien->lahir)->age ?? '-' }} tahun</td>
                            <td>Tanggal Diterima</td>
                            <td>:</td>
                            <td>{{ $data_pasien->created_at ?? '-'}}</td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td>{{ $data_pasien->jenis_kelamin ?? '-'}}</td>
                            <td>Tanggal Selesai</td>
                            <td>:</td>
                            <td>{{ $data_pasien->updated_at ?? '-'}}</td>
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
            <div id="tabel-pemeriksaan" class="table-responsive">
        <table class="table table-sm" id="worklistTable">
        <thead style="border-top: 1px solid black; border-bottom: 1px solid black">
            <tr>
                <th style="width: 35%; padding: 3px; font-size: 10px">Jenis Pemeriksaan</th>
                <th style="width: 20%; padding: 3px; font-size: 10px">Hasil</th>
                <th style="width: 10%; padding: 3px; font-size: 10px">Flag</th>
                <th class="text-center" style="width: 15%; padding: 3px; font-size: 10px">Satuan</th>
                <th class="text-center" style="width: 20%; padding: 3px; font-size: 10px">Nilai Rujukan</th>
            </tr>
        </thead>
         <tbody id="hasil-tbody">
    @foreach ($hasil_pemeriksaans->groupBy('department') as $department => $hasil_group)
        {{-- Judul Department --}}
        <tr>
            <th colspan="5" style="font-size: 9px; font-weight: 900;">
                <b><strong>{{ strtoupper($department) }}</strong></b>
            </th>
        </tr>

        {{-- Group by judul supaya tidak duplicate --}}
        @foreach ($hasil_group->groupBy('judul') as $judul => $group_by_judul)
            @if($judul)
                <tr>
                    <td style="font-size: 9px;" colspan="5"><b>‎ ‎{{ $judul ?? '' }}</b></td>
                </tr>
            @endif

            {{-- Loop data hasil berdasarkan judul --}}
            @foreach ($group_by_judul as $hasil)
                @php
                    // ==== PERBAIKAN DI SINI ====
                    // skip jika nama pemeriksaan sama dengan department
                    // KECUALI kalau department = "Golongan Darah"
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
                    <td class="flag">
                        @if(strtolower($hasil->flag) === 'high')
                            <i class="ti ti-arrow-up text-danger"></i>
                        @elseif(strtolower($hasil->flag) === 'low')
                            <i class="ti ti-arrow-down text-primary"></i>
                        @elseif(strtolower($hasil->flag) === 'high*')
                            <i class="ti ti-arrow-up text-danger">*</i>
                        @elseif(strtolower($hasil->flag) === 'low*')
                            <i class="ti ti-arrow-down text-primary">*</i>
                        @endif
                    </td>
                    <td class="text-center">{{ $hasil->satuan ?? '-' }}</td>
                    <td class="text-center">{{ $nilai_rujukan ?? '-' }}</td>
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
            <td><b>Catatan :</b></td>
            <td class="courier-new">- {{ $hasil_pemeriksaans->first()->note }}</td>
        </tr>
        <tr>
            <td></td>
            <td class="courier-new">- Hasil di atas merupakan interpretasi berdasarkan pemeriksaan laboratorium saat ini 
                dan dari keterangan klinis yang dicantumkan.</td>
        </tr>
    @else
        <tr>
            <td><b>Catatan :</b></td>
            <td class="courier-new">- Hasil di atas merupakan interpretasi berdasarkan pemeriksaan laboratorium saat ini 
                dan dari keterangan klinis yang dicantumkan.</td>
        </tr>
    @endif
</table>

        
        <div class="footer-container d-flex justify-content-between">
            @if($dokterName && $userDokter && $userDokter->signature && $userDokter->status === 'active')
                <!-- KIRI: Dokter Internal -->
                <div>
                    <h6 style="margin-left: 15px">Dokter Pemeriksa</h6>
                    <div>
                        <img src="{{ asset('signatures/' . $userDokter->signature) }}"
                            alt="Signature"
                            style="max-height:80px; display:block;">
                        <span style="border-bottom:1px solid #000; padding:0 5px; margin-left: 20px">
                            {{ $dokterName }}
                        </span>
                        <div style="margin-top:2px; margin-left: 20px">
                            NIK. {{ $data_pasien->dokter->nip ?? '' }}
                        </div>
                    </div>
                </div>

                <!-- KANAN: Analis -->
                
                @if(auth()->user()->status === 'active')
                <div class="user-info text-end">
                    <h6 style="margin-right: 55px">Analis Pemeriksa</h6>
                    @if(auth()->user()->signature && auth()->user()->status === 'active')
                        <img src="{{ asset('signatures/' . auth()->user()->signature) }}"
                            alt="Signature"
                            style="max-height:80px; display:block; margin-left:auto; margin-right:0;">
                    @endif
                    <div style="padding-right: 25px; margin-top:5px; text-align:right; margin-right: 50px">
                        <div style="display: inline-block; text-align: center;">
                            <div style="padding-top: 2px; min-width: 65px;">
                                <div style="font-weight: bold;">{{ auth()->user()->name }}</div>
                                <div style="border-top: 1px solid #000;">NIK. {{ auth()->user()->nik }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @else
                <!-- Kalau tidak ada dokter/signature -->
                @if(auth()->user()->status === 'active')
                <div class="doctor-info text-end w-100">
                    <h6 style="margin-right: 55px">Analis Pemeriksa</h6>
                    @if(auth()->user()->signature)
                        <img class="text-end"
                            src="{{ asset('signatures/' . auth()->user()->signature) }}"
                            alt="Signature"
                            style="max-height:80px; display:block; margin-left:78%;">
                    @endif
                    <div style="padding-right: 25px; margin-top:5px; text-align:right; margin-right: 50px">
                        <div style="display: inline-block; text-align: center;">
                            <div style="padding-top: 2px; min-width: 65px;">
                                <div style="font-weight: bold;">{{ auth()->user()->name }}</div>
                                <div style="border-top: 1px solid #000;">NIK. {{ auth()->user()->nik }}</div>
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

    <script>
        function renderPemeriksaan(data) {
            let html = '';

            data.forEach((hasil) => {
                const displayName = getDisplayName(hasil.nama_pemeriksaan);
                const formattedHasil = formatHasil(hasil.hasil, hasil.nama_pemeriksaan);

                let flagHtml = '';
                if (hasil.flag === 'L') {
                    flagHtml = '<span class="flag-low">L</span>';
                } else if (hasil.flag === 'H') {
                    flagHtml = '<span class="flag-high">H</span>';
                }


                html += `
                    <tr>
                        <td>${displayName}</td>
                        <td>${formattedHasil || 'Tidak ada hasil'}</td>
                        <td class="flag">${flagHtml}</td>
                        <td class="text-center">${hasil.satuan || '-'}</td>
                        <td>${hasil.nilai_rujukan || '-'}</td>
                    </tr>
                `;
            });

            return html;
        }
        
        // window.print();
    </script>
</body>
</html>