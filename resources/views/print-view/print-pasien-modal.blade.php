{{-- <div id="printable-content">
    <style>
        .print-container {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }
        .print-container .table-borderless th,
        .print-container .table-borderless td {
            padding: 2px 0;
        }
        .print-container .header {
            margin-bottom: 15px;
        }
        .print-container .data-pasien {
            margin-bottom: 15px;
        }
        .print-container .hasil-pemeriksaan {
            position: relative;
            min-height: 50vh;
            padding-bottom: 30px;
        }
        .print-container .footer-container {
            margin-top: 30px;
            padding: 20px 0;
        }
        .print-container .flag i {
            font-family: 'tabler-icons' !important;
            font-style: normal;
            font-size: 16px;
        }
        .print-container .text-primary {
            color: #206bc4 !important;
        }
        .print-container .text-danger {
            color: #d63939 !important;
        }
        .print-container .address-container {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 0.5rem;
        }
        .print-container .address-label {
            white-space: nowrap;
        }
        .print-container .address-value {
            word-wrap: break-word;
        }
        
        @media print {
            .print-container {
                font-size: 12pt;
                color: black;
            }
            .print-container .no-print {
                display: none;
            }
            .print-container .flag i, 
            .print-container .flag .printable-icon {
                display: inline-block !important;
            }
        }
    </style>

    <div class="print-container">
        <div class="header text-sm">
            <div class="row m-0">
                <div class="col-3 col-md-2 p-0">
                    <img class="ml-4" src="{{ asset('image/logo-rs-1.png') }}" width="120" alt="Logo">
                </div>
                <div class="col-8 col-md-8 text-center">
                    <h5 class="fw-bold mb-0">RUMAH SAKIT MUSLIMAT SINGOSARI</h5>
                    <p class="fw-bold mb-0">Jl. Ronggolawe No.24, Pangetan, Kec. Singosari, Kab. Malang</p>
                    <p class="fw-bold">Pelayanan 24 Jam</p>
                </div>
                <hr style="border-top: 1px solid black;">
            </div>
        </div>
        
        <div class="data-pasien mb-2">
            <div class="row">
                <div class="col-8 col-md-8">
                    <table class="table-borderless mb-0" style="width: 100%;">
                        <tr>
                            <th scope="row" class="p-0" style="width: 30%;">No.RM</th>
                            <td>: <span class="ms-2">{{ $data_pasien->no_rm }}</span></td>
                        </tr>
                        <tr>
                            <th scope="row" class="p-0">Nama Pasien</th>
                            <td>: <span class="ms-2 fw-bold">{{ $data_pasien->nama }}</span></td>
                        </tr>
                        <tr>
                            <th scope="row" class="p-0">Umur</th>
                            <td>: <span class="ms-2">{{ \Carbon\Carbon::parse($data_pasien->lahir)->age }} tahun</span></td>
                        </tr>
                        <tr>
                            <th scope="row" class="p-0">Jenis Kelamin</th>
                            <td>: <span class="ms-2">{{ $data_pasien->jenis_kelamin }}</span></td>
                        </tr>
                        <tr>
                            <th scope="row" class="p-0">Alamat Pasien</th>
                            <td>
                                <div class="address-container">
                                    <span class="address-label">:</span>
                                    <span class="address-value">{{ $data_pasien->alamat }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="p-0">Asal Pasien</th>
                            <td>: <span class="ms-2">-</span></td>
                        </tr>
                    </table>
                </div>
                
                <div class="col-4 col-md-4">
                    <table class="table-borderless" style="width: 100%;">
                        <tr>
                            <th scope="row" class="p-0" style="width: 40%;">No. Laboratorium</th>
                            <td>: <span class="ms-2">{{ $data_pasien->no_lab }}</span></td>
                        </tr>
                        <tr>
                            <th scope="row" class="p-0">Tanggal Transaksi</th>
                            <td>: <span class="ms-2">{{ $data_pasien->tanggal_masuk }}</span></td>
                        </tr>
                        <tr>
                            <th scope="row" class="p-0">Tanggal Diterima</th>
                            <td>: <span class="ms-2">{{ $data_pasien->created_at }}</span></td>
                        </tr>
                        <tr>
                            <th scope="row" class="p-0">Tanggal Selesai</th>
                            <td>: <span class="ms-2">{{ $data_pasien->updated_at }}</span></td>
                        </tr>
                        <tr>
                            <th scope="row" class="p-0 mb-0">Dokter Pengirim</th>
                            <td>: <span class="ms-2">{{ $data_pasien->kode_dokter}}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="hasil-pemeriksaan p-0">
            <div class="table-responsive">
                <table class="table table-sm table-bordered" style="width: 100%;">
                    <thead style="border-top: 1px solid black; border-bottom: 1px solid black; background-color: #f8f9fa;">
                        <tr>
                            <th style="width: 35%; padding: 5px;">Jenis Pemeriksaan</th>
                            <th style="width: 20%; padding: 5px;">Hasil</th>
                            <th style="width: 10%; padding: 5px;">Flag</th>
                            <th style="width: 15%; padding: 5px;">Satuan</th>
                            <th style="width: 20%; padding: 5px;">Nilai Rujukan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($processedResults as $department => $results)
                            <tr>
                                <th colspan="5" class="bg-light text-center" style="padding: 8px;">{{ strtoupper($department) }}</th>
                            </tr>
                            @foreach ($results as $result)
                                <tr>
                                    <td style="padding: 3px 5px;">{{ $result['display_name'] }}</td>
                                    <td style="padding: 3px 5px;">{{ $result['hasil'] ?: 'Tidak ada hasil' }}</td>
                                    <td class="flag text-center" style="padding: 3px 5px;">{!! $result['flag'] !!}</td>
                                    <td class="text-center" style="padding: 3px 5px;">{{ $result['satuan'] }}</td>
                                    <td style="padding: 3px 5px;">{{ $result['nilai_rujukan'] }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        @if(isset($note) && !empty($note))
            <div style="margin: 15px 0;">
                <p><strong>Note:</strong> {{ $note }}</p>
            </div>
        @endif
        
        <div class="footer-container d-flex justify-content-between">
            <div class="user-info">
                <h6>Lab Penanggung Jawab</h6>
                <br>
                <br>
                <h6 style="padding-left: 25px">{{ auth()->user()->name }}</h6>
            </div>
            <div class="doctor-info text-end">
                <h6>Dokter Penanggung Jawab</h6>
                <br>
                <br>
                <h6 style="padding-right: 30px;">{{ $data_pasien->kode_dokter }}</h6>
            </div>
        </div>
    </div>
</div> --}}