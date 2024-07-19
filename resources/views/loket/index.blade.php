<title>Dashboard|Pasien</title>
@extends('layouts.admin')

@section('title', 'Loket')

@section('content')
    <div class="content" id="scroll-content">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex  mt-3">
                <h1 class="h3 mb-0 text-gray-600">Dashboard</h1>
            </div>

            <!-- Content Row -->
            <div class="row mt-3">

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Pasien Masuk (Harian)</div>
                                    <div class="h3 mt-3 font-weight-bold text-gray-600">
                                        <h3>{{ $tanggal }}</h3>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bx bx-chart fa-3x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pasien Belum Dilayani</div>
                                    <div class="h3 mt-3 font-weight-bold text-gray-600">
                                    <h3>{{$data}}</h3>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bx bx-info-circle fa-3x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pasien Telah
                                        Dilayani
                                    </div>
                                    <div class="h3 mt-3 font-weight-bold text-gray-600">250</div>

                                </div>
                                <div class="col-auto">
                                    <i class="bx bxs-user-check fa-3x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-bottom-info shadow h-100 py-2">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <div class="row no-gutters">
                                <p class="h1 font-weight-bold text-gray-800 mt-3" id="waktu">00:00:00</p>
                                <span id="timeformat" class="text-gray-500 ml-2">AM</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Content Row -->
            {{-- <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card shadow mb-4" id="cardPreviewPasien">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold" style="color: #96B6C5;">Preview Pasien</h6>
                            <div class="status" id="status">
                                <div class="ribbon-shape-dgr">
                                    <p class="mt-3 text-white">Belum Dilayani</p>
                                </div>
                            </div>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body p-4">
                            <div class="text-end" id="tanggal-pemeriksaan">
                                <!-- Tanggal -->
                                <p class="h6 font-weight-normal text-muted">{{ now()->format('d F Y H:i:s') }}</p>
                            </div>
                            <hr>

                        </div>
                    </div>
                </div> --}}

            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold ml-1" style="color: #96B6C5;">Antrian Pasien</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="">
                            {{-- <form class="form-inline">
                                    <input class="form-control mr-sm-2" type="search" placeholder="Search"
                                        aria-label="Search">
                                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                                </form> --}}
                            <a href="{{ route('pasien.create') }}" class="btn btn-outline-primary">
                                <i class='bx bx-plus'></i> + Add Inspection
                            </a>
                        </div>
                        <div class="">
                            <table class="table table-striped table-bordered table-responsive" id="myTable">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">No.RM</th>
                                        <th scope="col">Cito</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Date Of Birt</th>
                                        <th scope="col">Gender</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Poly Origin</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" class="col-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data_pasien as $x => $dc)
                                        <tr>
                                            <td scope="row">{{ $x + 1 }}</td>
                                            <td>{{ $dc->no_rm }}</td>
                                            <td class="text-center">
                                                <i class='bi bi-bell-fill mt-2 ml-1 {{ $dc->cito == '1' ? 'text-danger' : 'text-secondary' }}'
                                                    style="font-size: 23px;"></i>
                                            </td>
                                            <td>{{ $dc->nama }}</td>
                                            <!-- ganti format dengan tanggal-bulan-tahun -->
                                            <td>
                                                {{ date('d-m-Y', strtotime($dc->lahir)) }}
                                                <br>
                                                ({{ \Carbon\Carbon::parse($dc->lahir)->age }} tahun)
                                            </td>
                                            <td>{{ $dc->jenis_kelamin }}</td>
                                            <td>{{ $dc->alamat }}</td>
                                            <td> - </td>
                                            <td>
                                                @if ($dc->status == 'Belum Dilayani')
                                                    <span class="badge bg-danger text-white">Belum Di Layani</span>
                                                @elseif($dc->status == 'Telah Dikirim ke Lab')
                                                    <span class="badge bg-success text-white">Dikirim ke Lab</span>
                                                @elseif($dc->status == 'Diproses')
                                                    <span class="badge bg-warning text-white">Diproses</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" data-bs-target="#modalPreviewPasien"
                                                    data-bs-toggle="modal" class="btn btn-info btn-edit text-white "
                                                    data-id="{{ $dc->id }}"><i class='bi bi-eye'></i></button>

                                                <button type="button" data-bs-target="#modalPembayaran"
                                                    data-bs-toggle="modal" class="btn btn-success btn-payment text-white "
                                                    data-payment="{{ $dc->id }}"><i class='bi bi-cash'></i></button>


                                                    <form id="delete-form-{{ $dc->id }}"
                                                        action="{{ route('pasien.destroy', $dc->id) }}" method="POST"
                                                        style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <button class="btn btn-danger"
                                                    onclick="confirmDelete({{ $dc->id }})"><i
                                                        class="bi bi-trash"></i></button>

                                                    {{-- <a href="{{ route('print.barcode', $dc->no_lab) }}" class="btn btn-warning"><i class="bi bi-upc"></i></a> --}}
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    {{-- Preview Pasien --}}
    <div class="modal fade" id="modalPreviewPasien" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Preview Patient</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="pembayaran-pasien" style="max-height: 700px;">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            Patient
                            <hr>
                            <table class="table table-borderless">
                                <tr>
                                    <th scope="row">No.Lab</th>
                                    <td>
                                        <div class="flex-container">
                                            :  <span class="ms-2" id="Nolab"></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Cito</th>
                                    <td>
                                        <div class="flex-container">
                                            <span class="label">:</span>
                                            <i class="bi bi-bell-fill" id="Cito"></i>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>NIK</th>
                                    <td>
                                        <div class="flex-container">
                                          :  <span id="Nik">:</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>
                                        <div class="flex-container">
                                           : <span id="Nama"></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td>
                                        <div class="flex-container">
                                          : <span id="Gender">:</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>
                                        <div class="flex-container">
                                           : <span id="Alamat"></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Phone Number</th>
                                    <td>
                                        <div class="flex-container">
                                           : <span id="Telp"></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Service</th>
                                    <td>
                                        <div class="flex-container">
                                           : <span id="JenisPelayanan">:</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Room</th>
                                    <td>
                                        <div class="flex-container">
                                           : <span id="Ruangan"></span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-12 col-md-6">
                            Doctor
                            <hr>
                            <table class="table table-borderless">
                                <tbody>
                                    <tr class="mb-4">
                                        <th scope="row">Name</th>
                                        <td> : <span id="Dokter"></span></td>
                                    </tr>
                                    <tr>
                                        <div class="flex-container mt-2">
                                            <th style="margin-top: 10px">Room</th>
                                            <td> : <span id="Ruangandok"></span></td>
                                        </div>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td> : <span id="Telpdok"></span></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td> : <span id="Email"></span></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Diagnosis
                                        </th>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <textarea class="form-control" disabled name="diagnosa" id="Diagnosa" cols="20" rows="5"></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h5>Inspection Details</h5>
                            <hr>
                            <div id="detailPemeriksaan">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button">Verification</button>
                </div>

            </div>
        </div>
    </div>
    {{-- Pembayaran Pasien --}}
    <div class="modal fade" id="modalPembayaran" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Payment Patient</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="pembayaran-pasien" style="max-height: 700px;">
                    <form action="{{ route('pasien.kirimlab') }}" method="POST">
                        @csrf
                        <div class="row">
                         <div>
                            <h5>Inspection Details</h5>
                            <hr>
                            <div id="detailPembayaran">
                            </div>
                         </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success " id="submit-button" type="submit">Payment</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


@endsection


@push('script')
    <script>
        $(function() {
            // ngambil data dari id = detailPemeriksaan
            let detailPemeriksaan = document.getElementById('detailPemeriksaan');
            // button preview waktu di klik mendapatkan data sesuai id
            $('.btn-edit').on('click', function() {
                // untuk mendapatkan data sesuai idnya
                const id = this.getAttribute('data-id');

                // Memanggil API
                fetch(`/api/get-data-pasien/${id}`).then(response => {
                    if (!response.ok) {
                        throw new Error("HTTP error" + response.status);
                    }
                    return response.json();
                }).then(res => {
                    if (res.status === 'success') {
                        const {
                            cito,
                            no_lab,
                            nik,
                            nama,
                            jenis_kelamin,
                            no_telp,
                            alamat,
                            jenis_pelayanan,
                            asal_ruangan,
                            diagnosa,
                        } = res.data;

                        dokter = res.data.dokter;
                        data_pemeriksaan_pasien = res.data.dpp;

                        $('#Cito').val(cito == 1 ? 'text-danger' : 'text-secondary');
                        $('#Nolab').val(no_lab);
                        $('#Nik').val(nik);
                        $('#Nama').val(nama);
                        $('#Gender').val(jenis_kelamin);
                        $('#Alamat').val(alamat);
                        $('#Telp').val(no_telp);
                        $('#JenisPelayanan').val(jenis_pelayanan);
                        $('#Ruangan').val(asal_ruangan);
                        const citoIcon = $('#Cito');
                        if (cito == '1') {
                            citoIcon.removeClass('text-secondary').addClass('text-danger');
                        } else {
                            citoIcon.removeClass('text-danger').addClass('text-secondary');
                        }
                        $('#Nolab').text(no_lab);
                        $('#Nik').text(nik);
                        $('#Nama').text(nama);
                        $('#Gender').text(jenis_kelamin);
                        $('#Alamat').text(alamat);
                        $('#Telp').text(no_telp);
                        $('#JenisPelayanan').text(jenis_pelayanan);
                        $('#Ruangan').text(asal_ruangan);
                        $('#Dokter').text(dokter.nama_dokter);
                        $('#Ruangandok').text(asal_ruangan);
                        $('#Telpdok').text(dokter.no_telp);
                        $('#Email').text(dokter.email);
                        $('#Diagnosa').val(diagnosa);

                        let old = 0;
                        let detailContent = '<div class="row">';
                        let subContent = [];
                            // memanggil data departement
                        data_pemeriksaan_pasien.forEach((e, i) => {
                            // console.log(e.data);
                            detailContent += `<div class="col-12 col-md-6" id="${e.id_departement}">
                                                        <h6>${e.data_departement.nama_department}</h6>
                                                        <ol>`;
                            e.pasiens.forEach((e, i) => {
                                console.log(e.data_pemeriksaan);
                                detailContent +=
                                    `<li>${e.data_pemeriksaan.nama_pemeriksaan}- Rp ${e.data_pemeriksaan.harga}</li>`;
                            });
                            detailContent += `</ol></div>`;
                        });
                        console.log(data_pemeriksaan_pasien);
                        detailContent += '</div>';
                        // console.log(detailContent);
                        // menampilkan data yang diambil dari API
                        detailPemeriksaan.innerHTML = detailContent;
                        // if (data_pemeriksaan_pasien.length > 0) {
                        //     const department = data_pemeriksaan_pasien[0].department;
                        //     $('#Department').text(department.nama_department);
                        // }

                    }
                });
                // Form edit
                // $('#modalPreviewPasien').attr('action', '/poli/' + id);

            });
        })
    </script>

    <script>
        $(function() {
            let detailPembayaran = document.getElementById('detailPembayaran');
            $('.btn-payment').on('click', function() {
                const id = this.getAttribute('data-payment');

                fetch(`/api/get-data-pasien/${id}`).then(response => {
                    if (!response.ok) {
                        throw new Error("HTTP error" + response.status);
                    }
                    return response.json();
                }).then(res => {
                    if (res.status === 'success') {
                        data_pasien = res.data;
                        data_pemeriksaan_pasien = res.data.dpp;

                        let old = 0;
                        let detailContent = '<div class="row">';
                        let subContent = [];
                        let totalHarga = 0;

                        //Status Pemeriksaan
                            if (data_pasien.status == "Belum Dilayani") {
                                status.innerHTML =
                                    `<div class="ribbon-shape-dgr"><p class="mt-3 text-white">Belum Dilayani</p></div>`;
                            } else if (data_pasien.status == "Diproses") {
                                status.innerHTML =
                                    `<div class="ribbon-shape-wrn"><p class="mt-3 text-white">Diproses</p></div>`;
                            } else if (data_pasien.status == "Dilayani") {
                                status.innerHTML =
                                    `<div class="ribbon-shape-scs"><p class="mt-3 text-white">Dilayani</p></div>`;
                            }

                        data_pemeriksaan_pasien.forEach((e, i) => {
                            // console.log(e.data);
                            detailContent += `<div class="col-12 col-md-6" id="${e.id_departement}">
                                                        <h6>${e.data_departement.nama_department}</h6>
                                                        <ol>`;
                            e.pasiens.forEach((e, i) => {
                                console.log(e.data_pemeriksaan);
                                detailContent +=
                                    `<li>${e.data_pemeriksaan.nama_pemeriksaan} - Rp ${e.data_pemeriksaan.harga}</li>`;
                                    totalHarga += e.data_pemeriksaan.harga;
                            });
                            detailContent += `</ol><hr></div>`;

                        });
                        detailContent += '</div>';
                        let pembayaranContent = `
                            <h5>Payment Details</h5>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-12 col-md-6"
                                    <label>Payment Method</label>
                                    <input class="form-control " type="text" name="no_lab" value="${data_pasien.no_lab }" readonly hidden>
                                    <input class="form-control bg-secondary-subtle" type="text" name="metode_pembayaran" value="${data_pasien.jenis_pelayanan }" readonly>
                                </div>
                                <div class="col-12 col-md-6"
                                    <label>Total Payment</label>
                                    <input class="form-control bg-secondary-subtle" type="text" id="total_pembayaran" name="total_pembayaran"  value="${totalHarga}" readonly>
                                </div>
                                <div class="col-12 col-md-6"
                                    <label>Payment Amount</label>
                                    <input class="form-control " id="jumlah_bayar" name="jumlah_bayar" type="number" value="">
                                </div>
                                <div class="col-12 col-md-6"
                                    <label>Change Money</label>
                                    <input class="form-control bg-secondary-subtle" value="" id="kembalian" name="kembalian" readonly>
                                </div>
                            </div>
                        `;
                        console.log(data_pemeriksaan_pasien);
                        console.log(data_pasien);
                        detailContent += pembayaranContent;

                        detailPembayaran.innerHTML = detailContent;
                        console.log(detailContent);

                        document.getElementById('jumlah_bayar').addEventListener('input', function() {
                            if(this.value < 0){
                                this.value = 0;
                                return false;
                            }
                            let totalPembayaran = parseFloat(document.getElementById('total_pembayaran').value);
                            let jumlahBayar = parseFloat(this.value);
                            let kembalian = jumlahBayar - totalPembayaran;

                            document.getElementById('kembalian').value = kembalian > 0 ? kembalian : 0;

                            // Validasi untuk mengaktifkan atau menonaktifkan tombol submit
                            let submitButton = document.getElementById('submit-button');
                            if (jumlahBayar >= totalPembayaran) {
                                submitButton.disabled = false;
                            } else {
                                submitButton.disabled = true;
                            }
                        });

                            document.getElementById('submit-button').disabled = true;
                    }
                });
                // Form edit
                // $('#modalPreviewPasien').attr('action', '/poli/' + id);

                // show the modal
                // $('#modalPreviewPasien').modal('show');
            });
        })
    </script>



    <!-- Preview Pasien -->
    {{-- <script>
        function previewPasien(nolab) {
            var y = document.getElementById("preview-pasien-close");

            fetch('/api/previewpasien/' + nolab)
                .then(response => {
                    if (!response.ok) {
                        throw new Error("HTTP error " + response.status);
                    }
                    return response.json();
                })

                .then(data => {
                    console.log(data); // Tambahkan log ini untuk melihat respons API

                    if (!data || !data.data_pasien) {
                        throw new Error("Data pasien tidak ditemukan");
                    }
                    y.style.display = "none";
                    var status = document.getElementById("status");
                    var container = document.getElementById("preview-pasien-open");
                    var tanggal = document.getElementById("tanggal-pemeriksaan");

                    //Status Pemeriksaan
                    if (data.data_pasien.status == "Belum Dilayani") {
                        status.innerHTML =
                            `<div class="ribbon-shape-dgr"><p class="mt-3 text-white">Belum Dilayani</p></div>`;
                    } else if (data.data_pasien.status == "Telah Dikirim ke Lab") {
                        status.innerHTML =
                            `<div class="ribbon-shape-scs"><p class="mt-3 text-white">Telah Dikirim</p></div>`;
                    } else if (data.data_pasien.status == "Diproses") {
                        status.innerHTML =
                            `<div class="ribbon-shape-wrn"><p class="mt-3 text-white">Diproses</p></div>`;
                    }

                    //ubah format tanggal created_at
                    var date = new Date(data.data_pasien.tanggal_masuk);
                    var year = date.getFullYear();
                    var month = date.getMonth() + 1;
                    var dt = date.getDate();

                    //ambil nama hari
                    var day = date.getDay();
                    var days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
                    day = days[day];

                    if (dt < 10) {
                        dt = '0' + dt;
                    }
                    if (month < 10) {
                        month = '0' + month;
                    }

                    var tanggal_pemeriksaan =
                        `${day} , ${dt}-${month}-${year} ${date.getHours()}:${date.getMinutes()}`;

                    //tampilkan tanggal pemeriksaan
                    tanggal.innerHTML = `<p class="h6 font-weight-normal">${tanggal_pemeriksaan}</p>`;

                    //menghitung umur dari tanggal lahir
                    var dob = new Date(data.data_pasien.lahir);
                    var today = new Date();
                    var age = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));


                }).catch(function(error) {
                    console.log(error);
                });
        }
    </script> --}}

    <!-- Pembayaran Pasien -->
    {{-- <script>
        function pembayaranPasien(nolab) {
            var y = document.getElementById("payment");

            //mengambil data pasien dari database
            fetch('/api/get-data-pemeriksaan/'${id})
                .then(response => {
                    if (!response.ok) {
                        throw new Error("HTTP error " + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    y.style.display = "none";
                    var status = document.getElementById("status");
                    var tanggal = document.getElementById("tanggal-pemeriksaan");

                    //Status Pemeriksaan
                    if (data.data_pasien.status == "Belum Dilayani") {
                        status.innerHTML =
                            `<div class="ribbon-shape-dgr"><p class="mt-3 text-white">Belum Dilayani</p></div>`;
                    } else if (data.data_pasien.status == "Diproses") {
                        status.innerHTML =
                            `<div class="ribbon-shape-wrn"><p class="mt-3 text-white">Diproses</p></div>`;
                    } else if (data.data_pasien.status == "Dilayani") {
                        status.innerHTML =
                            `<div class="ribbon-shape-scs"><p class="mt-3 text-white">Dilayani</p></div>`;
                    }

                    //ubah format tanggal created_at
                    var date = new Date(data.data_pasien.created_at);
                    var year = date.getFullYear();
                    var month = date.getMonth() + 1;
                    var dt = date.getDate();

                    //ambil nama hari
                    var day = date.getDay();

                    if (day == 0) {
                        day = "Minggu";
                    } else if (day == 1) {
                        day = "Senin";
                    } else if (day == 2) {
                        day = "Selasa";
                    } else if (day == 3) {
                        day = "Rabu";
                    } else if (day == 4) {
                        day = "Kamis";
                    } else if (day == 5) {
                        day = "Jumat";
                    } else if (day == 6) {
                        day = "Sabtu";
                    }

                    if (dt < 10) {
                        dt = '0' + dt;
                    }
                    if (month < 10) {
                        month = '0' + month;
                    }

                    var tanggal_pemeriksaan = day + ', ' + dt + '-' + month + '-' + year + ' ' + date.getHours() + ':' +
                        date.getMinutes();

                    console.log(tanggal_pemeriksaan);

                    //tampilkan tanggal pemeriksaan
                    tanggal.innerHTML = `<p class="h6 font-weight-normal">` + tanggal_pemeriksaan + `</p>`;

                    //megnhitung umur dari tanggal lahir
                    // var dob = new Date(data.data_pasien.lahir);
                    // var today = new Date();
                    // var age = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));

                    // var diagnosa = data.icd10.filter(function(el) {
                    //     return el.code == data.data_pasien.diagnosa;
                    // });

                    //perulangan untuk menampilkan pemeriksaan yang di pilih
                    var departement = "";
                    var pemeriksaan = "";

                    for (let i = 0; i < data.id_departement_pasien.length; i++) {
                        departement += `<p class="h6 text-gray-800">`
                        //buat perintah where untuk mencari id_departement
                        for (let j = 0; j < data.data_departement.length; j++) {
                            if (data.data_departement[j].id_departement == data.id_departement_pasien[i].id_departement)
                                departement += data.data_departement[j].nama_departement;
                        }
                        departement += `</p>
                                    <div class="sub-detail p-2">`
                        for (let k = 0; k < data.data_pemeriksaan_pasien.length; k++) {
                            if (data.data_pemeriksaan_pasien[k].id_departement == data.id_departement_pasien[i]
                                .id_departement) {
                                for (let l = 0; l < data.data_pemeriksaan.length; l++) {
                                    if (data.data_pemeriksaan_pasien[k].nama_parameter == data.data_pemeriksaan[l]
                                        .nama_parameter) {
                                        departement += `<p class="text-gray-600 offset-md-3">` + data.data_pemeriksaan[
                                            l].nama_pemeriksaan + `</p>`;
                                    }
                                }
                            }
                        }
                        departement += `</div>`
                    }

                    //mengambil data icd10 dari database


                    // var citoMerah = `<label for="staticEmail" class="col-sm-5 col-form-label">Cito</label>
                    //             <div class="col-sm-7">
                    //                 <i class='bx bxs-bell-ring mt-2 ml-1 text-danger' style="font-size: 23px;"></i>
                    //             </div>`;
                    // var citoGray = `<label for="staticEmail" class="col-sm-5 col-form-label">Cito</label>
                    //             <div class="col-sm-7">
                    //                 <i class='bx bxs-bell-ring mt-2 ml-1 text-secondary' style="font-size: 23px;"></i>
                    //             </div>`;

                    var html = `<form action="{{ route('pasien.kirimlab') }}" method="POST" class="row table-preview" style="overflow-y: scroll; max-height: 600px;">
                                @csrf
                                <div class="pasien col-xl-6 col-lg-12 col-sm-12 mb-3">
                                    <p class="h5 text-gray-800 mb-2">Pasien</p>
                                    <hr>
                                    <div class="row">`
                    if (data.data_pasien.cito == 1) {
                        html += citoMerah;
                    } else {
                        html += citoGray;
                    }
                    html +=
                        `</div>
                                    <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">No LAB : </label>
                                    <div class="col-sm-7">
                                        <input type="text" name="no_lab" readonly class="form-control-plaintext" id="staticEmail" value="` +
                        data.data_pasien.no_lab +
                        `">
                                    </div>
                                    </div>
                                    <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">No RM</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ` +
                        data.data_pasien
                        .no_rm +
                        `">
                                    </div>
                                    </div>
                                    <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">NIK</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ` +
                        data.data_pasien.nik +
                        `">
                                    </div>
                                    </div>
                                    <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">Nama</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ` +
                        data
                        .data_pasien.nama +
                        `">
                                    </div>
                                    </div>
                                    <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">Gender</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ` +
                        data
                        .data_pasien.jenis_kelamin +
                        `">
                                    </div>
                                    </div>
                                    <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">Umur</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ` +
                        age +
                        ` tahun">
                                    </div>
                                    </div>
                                    <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">Alamat</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ` +
                        data.data_pasien.alamat +
                        `">
                                    </div>
                                    </div>
                                    <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">Telp</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ` +
                        data.data_pasien.no_telp +
                        `">
                                    </div>
                                    </div>
                                    <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">Jenis Pasien</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ` +
                        data.data_pasien.jenis_pelayanan +
                        `">
                                    </div>
                                    </div>
                                    <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">Ruangan</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ` +
                        data.data_pasien.asal_ruangan +
                        `">
                                    </div>
                                    </div>
                                </div>
                                <div class="dokter col-xl-6 col-lg-12 col-sm-12 mb-3">
                                    <p class="h5 text-gray-800">Dokter</p>
                                    <hr>
                                    <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">Nama Dokter</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": Dr. Bande">
                                    </div>
                                    </div>
                                    <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">Ruangan</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": Abu Thalib">
                                    </div>
                                    </div>
                                    <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">Telp</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": 0812313">
                                    </div>
                                    </div>
                                    <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">Email</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": gmail.com">
                                    </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label for="exampleFormControlTextarea1">Diagnosa :</label>
                                            <textarea class="form-control txt-area" style="resize: none; height: 160px;" id="note-1" rows="3" name="note-2" disabled>` +
                        diagnosa[0].name_id + `</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="detail_pemeriksaan col-12 ">
                                    <p class="h5 text-gray-800 mb-2">Detail Pemeriksaan</p>
                                    <hr>
                                    <div class="row">
                                    <div class="col-md-6">`

                    html += departement;

                    html +=
                        `</div>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <p class="h5 text-gray-800 mb-2">Pembayaran</p>
                                    <hr>
                                    <div class="form-row">
                                    <div class="form-group col-sm-6">
                                        <label for="exampleFormControlSelect1">Metode Pembayaran</label>
                                        <input type="text" class="form-control" aria-label="" name="jenispelayanan" aria-describedby="basic-addon1" value="` +
                        data.data_pasien.jenis_pelayanan +
                        `" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleFormControlSelect1" class="ml-3">Total</label>
                                        <input type="number" class="form-control" aria-label="" name="hargapemeriksaan" aria-describedby="basic-addon1" value="` +
                        data.data_pemeriksaan_pasien[0].harga + `" readonly>
                                    </div>
                                    </div>
                                    <div class="form-row">
                                    <div class="form-group col-12 col-md-6">
                                        <label for="exampleFormControlSelect1">Jumlah Bayar</label>
                                        <input type="number" class="form-control" aria-label="" name="jumlahbayar" aria-describedby="basic-addon1" oninput="hitungKembalian(this.value)">
                                    </div>
                                    </div>
                                    <div class="form-row">
                                    <div class="form-group col-12 col-md-6">
                                        <label for="exampleFormControlSelect1">Kembalian</label>
                                        <input type="number" class="form-control" aria-label="" name="kembalian" id="kembalian" aria-describedby="basic-addon1" value="0" readonly>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer ">
                                <button type="submit" class="btn btn-success btn-varifikasi" id="btn-varifikasi" style="cursor: not-allowed" disabled>Verifikasi</button>
                            </form>`

                    document.getElementById("pembayaran-pasien").innerHTML = html;

                })
                .catch(error => ('Error:', error));

        }
    </script> --}}

    <!-- Edit Pasien -->
    {{-- <script>
        function editPasien(nolab) {
            var x = document.getElementById("editPasien");

            fetch('/api/previewpasien/' + nolab)
                .then(response => {
                    if (!response.ok) {
                        throw new Error("HTTP error " + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data.data_pemeriksaan_pasien);
                    html =
                        `<form action="{{ route(
                            'pasien.update',
                            '`
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                html += data.data_pasien.no_lab
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                html += `',
                        ) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="d-flex justify-content-between">
                        <p class="h5">Data Pasien</p>
                        <div class="row" style="margin-top: -5px;">
                            <label for="staticEmail" class="col-sm-4 col-form-label">No LAB : </label>
                            <div class="col-lg">
                                <input type="text" readonly class="form-control-plaintext font-weight-bold" name="nolab" id="staticEmail" value="` +
                        data.data_pasien.no_lab + `">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-12 col-md-6">
                            <label for="basic-url">Nomor RM</label>
                            <div class="input-group mb-6">
                                <input type="text" class="form-control" aria-label="" name="norm" readonly value="` +
                        data.data_pasien.no_rm + `">
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="basic-url">Nomor Induk Kewarganegaraan</label>
                            <div class="input-group mb-6">
                                <input type="text" class="form-control" aria-label="" name="nik" value="` + data
                        .data_pasien.nik + `">
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="basic-url">Nama Lengkap</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" aria-label="" name="nama" value="` + data
                        .data_pasien.nama + `">
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <!-- <label for="name" class="">Date</label> -->
                            <label for="startDate">Tanggal Lahir</label>
                            <input id="startDate" class="form-control" type="date" name="tanggal_lahir" value="` + data
                        .data_pasien.lahir + `"/>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="exampleFormControlSelect1">Jenis Kelamin</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="jenis_kelamin">
                                <!-- <option >Pilih Jenis Kelamin</option> -->
                                <option value="Laki - Laki" `
                    if (data.data_pasien.jenis_kelamin == "Laki - Laki") {
                        html += `Selected`
                    }
                    html += `>Laki - Laki</option>
                                <option value="Perempuan" `
                    if (data.data_pasien.jenis_kelamin == "Perempuan") {
                        html += `Selected`
                    }
                    html += `>Perempuan</option>
                                <option value="-" `
                    if (data.data_pasien.jenis_kelamin == "-") {
                        html += `Selected`
                    }
                    html += `>Tidak Disebutkan</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="name">No Telepon / Hp</label>
                            <input type="text" class="form-control" value="` + data.data_pasien.no_telp + `" id="" name="no_telepon">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="name">Jenis Pasien</label>
                            <input type="text" class="form-control" value="` + data.data_pasien.jenis_pelayanan + `" id="" name="jenis_pelayanan" readonly>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="name">Ruangan</label>
                            <input type="text" class="form-control" value="` + data.data_pasien.asal_ruangan +
                        `" id="" name="ruangan">
                        </div>
                        <div class="form-group col-12">
                            <label for="exampleFormControlTextarea1">Alamat Lengkap</label>
                            <textarea class="form-control" style="resize: none; height: 130px;" id="alamat" rows="3" name="alamat">` +
                        data.data_pasien.alamat + `</textarea>
                        </div>
                        <div class="form-group col-12 col-md-6"">
                            <label for="exampleFormControlSelect1">Dokter Pengirim</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="dokter">
                                <!-- <option selected>Pilih</option> -->
                                <option value="1" `
                    if (data.data_pasien.kode_dokter == "1") {
                        html += `Selected`
                    }
                    html += `>Permintaan Sendiri</option>
                                <option value="2" `
                    if (data.data_pasien.kode_dokter == "2") {
                        html += `Selected`
                    }
                    html += `>dr. Poli Umum</option>
                                <option value="3" `
                    if (data.data_pasien.kode_dokter == "3") {
                        html += `Selected`
                    }
                    html += `>dr. Poli KIA</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="name">Diagnosa</label>
                            <input type="text" class="form-control" value="` + data.data_pasien.diagnosa +
                        `" id="" name="diagnosa" readonly>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mt-4">
                        <p class="h5">Pilih Pemeriksaan</p>
                        <div class="row" style="margin-top: -5px;">
                            <label for="staticEmail" class="col-form-label">Total Harga : <b>Rp.</b> </label>
                            <div class="">
                                <input type="text" class="form-control-plaintext font-weight-bold" name="hargapemeriksaan" id="harga-pemeriksaan" value="`
                    //ubah format angkah dengan titik data.data_pemeriksaan_pasien[0].harga
                    var reverse = data.data_pemeriksaan_pasien[0].harga.toString().split('').reverse().join(''),
                        ribuan = reverse.match(/\d{1,3}/g);
                    ribuan = ribuan.join('.').split('').reverse().join('');
                    html += ribuan;
                    html += `" readonly>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="row pemeriksaan">`
                    for (a = 0; a < data.data_departement.length; a++) {
                        html += `<div class="col-xl-3">
                                <!-- Parent Pemeriksaan -->
                                <div class="parent-pemeriksaan" id="parent-pemeriksaan">
                                    <div class="heading heading-color btn-block  mb-3">` + data.data_departement[a]
                            .nama_departement + `</div>
                                    <!-- Child pemeriksaan -->
                                    <div class="child-pemeriksaan" id="child-pemeriksaan-hematologi">`
                        for (b = 0; b < data.data_pemeriksaan.length; b++) {
                            if (data.data_pemeriksaan[b].id_departement == data.data_departement[a].id_departement) {
                                html +=
                                    `<div class="form-check">
                                                    <input class="form-check-input child-pemeriksaan" type="checkbox" name="pemeriksaan[]" value="` +
                                    data.data_pemeriksaan[b].id_departement + `,` + data.data_pemeriksaan[b]
                                    .nama_parameter + `" id="` + data.data_pemeriksaan[b].nama_parameter +
                                    `" onclick="checkpemeriksaan(` + data.data_pemeriksaan[b].harga +
                                    `)" data-harga="` + data.data_pemeriksaan[b].harga + `" `
                                for (c = 0; c < data.data_pemeriksaan_pasien.length; c++) {
                                    if (data.data_pemeriksaan[b].nama_parameter == data.data_pemeriksaan_pasien[c]
                                        .nama_parameter) {
                                        html += `checked`
                                    }
                                }
                                html += `>
                                                    <label class="form-check-label" for="` + data.data_pemeriksaan[b]
                                    .nama_parameter + `">
                                                        ` + data.data_pemeriksaan[b].nama_pemeriksaan + ` ` + data
                                    .data_pemeriksaan[b].harga + `
                                                    </label>
                                                </div>`
                            }
                        }
                        html += `</div>
                                </div>
                                <hr>
                            </div>`
                    }
                    html += `</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Save changes</button>
                </form>`

                    x.innerHTML = html;

                })
                .catch(error => ('Error:', error));

        }
    </script> --}}

    <!-- hitung harga otomatis saat memilih checkbox mengambil harga dari database -->
    {{-- <script type="text/javascript">
        function checkpemeriksaan(lab) {
            var total = 0;
            var harga = 0;
            var harga_pemeriksaan = document.getElementById('harga-pemeriksaan');
            var checkboxes = document.getElementsByClassName('child-pemeriksaan');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked == true) {
                    harga = checkboxes[i].getAttribute('data-harga');
                    total = parseInt(total) + parseInt(harga);
                }
            }

            //mengubah format angka ke rupiah
            var reverse = total.toString().split('').reverse().join(''),
                ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');

            harga_pemeriksaan.value = ribuan;
        }
    </script> --}}

    <!-- menghitung kembalian -->
    <script>
        function hitungKembalian(jumlahbayar) {
            var kembalian = document.getElementsByName('kembalian')[0];
            var hargapemeriksaan = document.getElementsByName('hargapemeriksaan')[0];
            var button = document.getElementById('btn-varifikasi');
            var total = jumlahbayar - hargapemeriksaan.value;

            if (total < 0) {
                total = 0;
                button.disabled = true;
                button.style.cursor = "not-allowed";
            } else {
                total = total;
                button.disabled = false;
                button.style.cursor = "pointer";
            }

            kembalian.value = total;
        }
    </script>

    <script src="{{ asset('js/time.js') }}"></script>
@endpush
