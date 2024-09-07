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
                                <th scope="row" class="p-0">Tanggal Lahir</th>
                                <td>
                                    <div>
                                        :  <span class="ms-2" id="lahir">{{ $data_pasien->lahir }}</span>
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
                                    :  <span class="ms-2" id="dokter">{{ $data_pasien->dokter->nama_dokter}}</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="p-0">Diagnosa</th>
                            <td>
                                <div>
                                    :  <span class="ms-2" id="diagnosa">{{ $data_pasien->diagnosa }}</span>

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
                            <!-- Kondisi Duplo -->
                            <th class="col-3 fw-bold">D1</th>
                            <th class="col-3 fw-bold">D2</th>
                            <th class="col-2 fw-bold">Flag</th>
                            <th class="col-2 fw-bold">Satuan</th>
                            <th class="col-2 fw-bold">Range</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_pasien->dpp as $e)
                            <tr>
                                <th scope="row">{{ $e->data_departement->nama_department }}</th>
                            </tr>

                            @php
                                // Ambil nama pemeriksaan untuk department ini
                                $pemeriksaanNames = $e->pasiens->pluck('data_pemeriksaan.nama_pemeriksaan');
                            @endphp

                            @foreach ($pemeriksaanNames as $pemeriksaanName)
                                @php
                                    // Temukan hasil pemeriksaan yang sesuai berdasarkan nama_pemeriksaan
                                    $hasilItem = $data_pasien->hasil_pemeriksaan->firstWhere('nama_pemeriksaan', $pemeriksaanName);
                                @endphp

                                <tr>
                                    <td>{{ $pemeriksaanName }}</td>
                                    <td>{{ $hasilItem ? $hasilItem->hasil : 'Tidak ada hasil' }}</td>
                                    <td></td>
                                    <td></td>
                                    <td><input type="hidden" class="form-control p-0" readonly/></td>
                                    <td class="text-center">{{ $hasilItem ? $hasilItem->satuan : 'Tidak ada satuan' }}</td>
                                    <td><input type="hidden" name="range[]" class="form-control w-50 p-0" value="1-10" readonly/>1-10</td>
                                </tr>
                            @endforeach
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>
        <div class="footer-container text-end">
            <h6>Dokter Penanggung Jawab</h6>
            <img src="" alt="Barcode">
            <h6 style="padding-right: 30px !important;">{{ $data_pasien->dokter->nama_dokter }}</h6>
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
