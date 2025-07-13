<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Cetak Hasil</title>
    <style>
        div {
            font-family: 'Times New Roman', Times, serif, sans-serif;
        }
        .table-borderless th,
        .table-borderless td {
            padding: 2px 0; /* Atur padding atas dan bawah */
        }
        .table-striped .tbody {
        box-shadow: none !important;
    }
    .hasil-pemeriksaan {
        position: relative;
        min-height: 50vh; /* Agar kontainer memenuhi tinggi viewport */
        padding-bottom: 30px; /* Ruang untuk footer */
    }
    .footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        background-color: white; /* Optional: Sesuaikan dengan latar belakang halaman */
        padding: 10px;
        
    }
    @media print {
    /* Aturan CSS khusus untuk cetak */
    body {
        font-size: 12pt;
        color: black;
        background-color: gray !important;
    }

    .no-print {
        display: none;
    }

    /* Gaya khusus untuk elemen tertentu saat dicetak */
    .print-only {
        display: block;
        background-color: antiquewhite;
    }
    .footer-container {
    padding: 20px;
}

.footer-container .user-info {
    flex: 1;  /* Memberikan ruang yang cukup di sebelah kiri */
}

.footer-container .doctor-info {
    flex: 1;  /* Memberikan ruang yang cukup di sebelah kanan */
    text-align: right;
}

.footer-container h6 {
    margin: 0;
}
     /* Pastikan icon tetap muncul saat print */
     .flag i, .flag .printable-icon {
            display: inline-block !important;
        }
        .text-primary {
            color: #206bc4 !important;
        }
        .text-danger {
            color: #d63939 !important;
        }
        /* Jika menggunakan simbol unicode */
        .printable-icon {
            font-weight: bold;
            font-size: 16px;
        }
    }

    /* Style untuk preview dan print */
    .flag i {
        font-family: 'tabler-icons' !important;
        font-style: normal;
        font-size: 16px;
    }
    </style>
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&display=swap" rel="stylesheet"> --}}
    
      <link rel="stylesheet" href="{{ asset('/assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
      <link rel="stylesheet" href="{{ asset('/assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
      <link rel="stylesheet" href="{{ asset('/assets/css/demo.css') }}" />
      
      <!-- Vendors CSS -->
      <link rel="stylesheet" href="{{ asset('/assets/vendor/libs/node-waves/node-waves.css') }}" />
      <link rel="stylesheet" href="{{ asset('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
      <link rel="stylesheet" href="{{ asset('/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <!-- atau jika menggunakan versi spesifik -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/tabler-icons.min.css">
</head>
<body>
    <div>
        <div class="header">
            <div class="row">
                <div class="col-3 col-md-2 p-0">
                    <img class="ml-4" src="{{ asset('image/logo-rs-1.png') }}" width="150" alt="Logo">
                </div>
                <div class="col-7 col-md-4 text-center">
                    <h4 class="fw-bold mb-0">RUMAH SAKIT MUSLIMAT SINGOSARI</h4>
                    {{-- <p class="mb-0">Instalasi Laboratorium Patologi Klinik</p> --}}
                    <p class="fw-bold mb-0">Jl. Ronggolawe No.24, Pangetan, Kec. Singosari, Kab. Malang</p>
                    <p class="fw-bold">Pelayanan 24 Jam</p>
                </div>
                <hr style="border-top: 1px solid black;">
            </div>
        </div>
        <div class="data-pasien">
            <div class="row">
                    <div class="col-6 col-md-6">
                        <table class="table-borderless mb-0">
                            <tr>
                                <th scope="row" class="p-0">No. RM</th>
                                <td>
                                    <div>
                                        :  <span class="ms-2" id="norm">{{ $data_pasien->no_rm }}</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="p-0">Nama Pasien</th>
                                <td>
                                    <div>
                                        :  <span class="ms-2 fw-bold" id="nama">{{ $data_pasien->nama }}</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="p-0">Umur</th>
                                <td>
                                    <div>
                                        : <span class="ms-2">
                                            {{ \Carbon\Carbon::parse($data_pasien->lahir)->age }} tahun
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="p-0">Alamat Pasien</th>
                                <td>
                                    <div>
                                        :  <span class="ms-2" id="alamat">{{ $data_pasien->alamat }}</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="p-0">Asal Pasien </th>
                                <td>
                                    <div>
                                        :  <span class="ms-2" id="asal">-</span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <br>
                    
                <div class="col-6 col-md-6">
                    <table class="table-borderless">
                        <tr>
                            <th scope="row" class="p-0">No. Laboratorium</th>
                            <td>
                                <div>
                                    :  <span class="ms-2" id="nolab">{{ $data_pasien->no_lab }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="p-0">Tanggal Transaksi</th>
                            <td>
                                <div>
                                    :  <span class="ms-2" id="tgltransaksi">{{ $data_pasien->tanggal_masuk }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="p-0">Tanggal Diterima</th>
                            <td>
                                <div>
                                    :  <span class="ms-2" id="tglterima">{{ $data_pasien->created_at }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="p-0">Tanggal Selesai</th>
                            <td>
                                <div>
                                    :  <span class="ms-2" id="tglselesai">{{ $data_pasien->updated_at }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="p-0 mb-0">Dokter Pengirim</th>
                            <td>
                                <div>
                                    :  <span class="ms-2" id="dokter">{{ $data_pasien->kode_dokter}}</span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <div class="hasil-pemeriksaan">
            <div id="tabel-pemeriksaan" class="table-responsive">
                <table class="table" id="worklistTable">
                    <thead style="border-top: 1px solid black; border-bottom: 1px solid black">
                        <tr scope="row">
                            <th class="col-4 fw-bold">Jenis Pemeriksaan</th>
                            <th class="col-3 ml-2 fw-bold">Hasil</th>
                            <th class="col-2 fw-bold">Flag</th>
                            <th class="col-2 fw-bold">Satuan</th>
                            <th class="col-2 fw-bold">Range</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tbody>
                            @foreach ($hasil_pemeriksaans->groupBy('department') as $department => $hasil_group)
                                <tr>
                                    <th colspan="8" class="bg-light">{{ strtoupper($department) }}</th>
                                </tr>
                                @foreach ($hasil_group as $hasil)
                                    <tr>
                                        <td>{{ $hasil->nama_pemeriksaan }}</td>
                                        <td>{{ $hasil->hasil ?? 'Tidak ada hasil' }}</td>
                                        <td class="flag">
                                            @if(is_numeric($hasil->hasil))
                                                @if(floatval($hasil->hasil) < 5)
                                                    <i class="ti ti-arrow-down text-primary"></i>
                                                @elseif(floatval($hasil->hasil) > 10)
                                                    <i class="ti ti-arrow-up text-danger"></i>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $hasil->satuan ?? 'Tidak ada satuan' }}</td>
                                        <td>1-10</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                </table>
            </div>
        </div>
        @if(isset($note) && !empty($note))
            <p><strong>Note:</strong> {{ $note }}</p>
        @endif
        <div class="footer-container d-flex justify-content-between">
            <!-- Bagian Kiri untuk Nama User -->
            <div class="user-info">
                <h6>Lab Penanggung Jawab</h6>
                <br>
                <br>
                <h6 style="padding-left: 25px">{{ auth()->user()->name }}</h6> <!-- Nama user yang sedang login -->
            </div>
        
            <!-- Bagian Kanan untuk Nama Dokter -->
            <div class="doctor-info text-end">
                <h6>Dokter Penanggung Jawab</h6>
                <br>
                <br>
                <h6 style="padding-right: 30px !important;">{{ $data_pasien->kode_dokter }}</h6>
            </div>
        </div>
        
</div>
    

</body>
<script type="text/javascript">
    window.print();
</script>
    <script src="{{ asset('/assets/vendor/libs/jquery/jquery.js') }}"></script>
    {{-- <script src="{{ asset('/assets/vendor/libs/popper/popper.js') }}"></script> --}}
    <script src="{{ asset('/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('/assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->
    

</html>
