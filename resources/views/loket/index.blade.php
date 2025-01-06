<title>Dashboard|Pasien</title>
@extends('layouts.admin')

@section('title', 'Loket')
<style>
    ::-webkit-scrollbar {
        width: 5px; 
    }
    ::-webkit-scrollbar-thumb {
        background: lightgray;
        border-radius: 10px;
    }
    .scrollbox{
        overflow: auto;
    }
</style>
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
                    <div class="card card-border-shadow-primary h-100">
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
                    <div class="card card-border-shadow-warning h-100">
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
                    <div class="card card-border-shadow-success h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pasien Telah
                                        Dilayani
                                    </div>
                                    <div class="h3 mt-3 font-weight-bold text-gray-600"></div>

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
                    <div class="card card-border-shadow-info h-100">
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
                        <div class="py-3 d-flex flex-row align-items-center justify-content-between">
                            {{-- <form class="form-inline">
                                    <input class="form-control mr-sm-2" type="search" placeholder="Search"
                                        aria-label="Search">
                                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                                </form> --}}
                            <a href="{{ route('pasien.create') }}" class="btn btn-outline-primary">
                                <i class='bx bx-plus'></i> + Add Inspection
                            </a>
                            
                        <a href="#" id="konfirmasiallselecteddata" type="button" class="btn btn-outline-info" >Check In</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered " id="myTable">
                                <thead>
                                    <tr>
                                        <th class="sorting_disabled"><input style="font-size: 20px; cursor: pointer;clear:" type="checkbox" name="" id="select_all_ids" class="form-check-input" ></th>
                                        <th scope="col">No.</th>
                                        <th scope="col">Cito</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Date Of Birt</th>
                                        <th scope="col">Gender</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Room</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" class="col-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $counter = 1; // Inisialisasi counter untuk nomor urut
                                    @endphp
                                    @forelse ($data_pasien as $dc)
                                    <tr>
                                        <th>
                                            <input style="font-size: 20px; cursor: pointer; display: none" type="checkbox" class="form-check-input checkbox_ids" value="{{ $dc->id }}">
                                        </th>
                                            <td scope="row">{{ $counter }}</td>
                                            <td class="text-center">
                                                <i class='ti ti-bell-filled {{ $dc->cito == '1' ? 'text-danger' : 'text-secondary' }}'
                                                    style="font-size: 23px;"></i>
                                            </td>
                                            <td class="col-2">{{ $dc->nama }}</td>
                                            <!-- ganti format dengan tanggal-bulan-tahun -->
                                            <td class="col-2">
                                                {{ date('d-m-Y', strtotime($dc->lahir)) }}
                                                <br>
                                                ({{ \Carbon\Carbon::parse($dc->lahir)->age }} tahun)
                                            </td>
                                            <td>{{ $dc->jenis_kelamin }}</td>
                                            <td>{{ $dc->alamat }}</td>
                                            <td>{{ $dc->asal_ruangan }}</td>
                                            <td>
                                                @if ($dc->status == 'Belum Dilayani')
                                                    <span class="badge bg-danger text-white">Waiting...</span>
                                                @endif
                                            </td>
                                            <td class="col-md-3">
                                                <button type="button" data-bs-target="#modalPreviewPasien"
                                                    data-bs-toggle="modal" class="btn btn-info btn-edit text-white "
                                                    title="Edit"
                                                    data-id="{{ $dc->id }}"><i class='ti ti-edit'></i>
                                                </button>
                                                                                                    
                                                <button type="button" data-bs-target="#modalPembayaran"
                                                    data-bs-toggle="modal" class="btn btn-secondary btn-payment text-white "
                                                    title="Pembayaran"
                                                    data-payment="{{ $dc->id }}"><i class='ti ti-cash-banknote'></i>
                                                </button>

                                                <a title="Cetak Barcode" style="cursor: pointer" href="{{ route('print.barcode', $dc->no_lab) }}" class="btn btn-secondary disabled" target="_blank"><i class="ti ti-barcode"></i></a>
                                                

                                                <form id="delete-form-{{ $dc->id }}"
                                                    action="{{ route('pasien.destroy', $dc->no_lab) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                
                                                <button class="btn btn-danger"
                                                    title="Hapus Data"
                                                    onclick="confirmDelete({{ $dc->id }})"><i
                                                    class="ti ti-trash"></i>
                                                </button>

                                            
                                                </td>
                                        </tr>
                                        @php
                                            $counter++; // Tambah counter setelah setiap iterasi
                                        @endphp
                                    @empty
                                    @endforelse

                                    @forelse ($payment as $pm)
                                    <tr>
                                        <th id="checkin{{ $pm->id }}">
                                            <input style="font-size: 20px; cursor: pointer;" type="checkbox" name="ids" id="checkbox" class="form-check-input checkbox_ids" value="{{ $pm->id }}">
                                        </th>
                                            <td scope="row">{{ $counter }}</td>
                                            <td class="text-center">
                                                <i class='ti ti-bell-filled {{ $pm->cito == '1' ? 'text-danger' : 'text-secondary' }}'
                                                    style="font-size: 23px;"></i>
                                            </td>
                                            <td class="col-2">{{ $pm->nama }}</td>
                                            <!-- ganti format dengan tanggal-bulan-tahun -->
                                            <td class="col-2">
                                                {{ date('d-m-Y', strtotime($pm->lahir)) }}
                                                <br>
                                                ({{ \Carbon\Carbon::parse($pm->lahir)->age }} tahun)
                                            </td>
                                            <td>{{ $pm->jenis_kelamin }}</td>
                                            <td>{{ $pm->alamat }}</td>
                                            <td>{{ $pm->asal_ruangan }}</td>
                                            <td>
                                                @if ($pm->status == 'Telah Dibayar')
                                                    <span class="badge bg-success text-white">Payment</span>
                                                @endif
                                            </td>
                                            <td class="col-md-3">
                                                <button type="button" data-bs-target="#modalPreviewPasien"
                                                    data-bs-toggle="modal" class="btn btn-info btn-edit text-white "
                                                    data-id="{{ $pm->id }}"><i class='ti ti-edit'></i>
                                                </button>
                                                    
                                                <button type="button" data-bs-target="#modalPembayaran"
                                                    data-bs-toggle="modal" class="btn btn-payment btn-success text-white" 
                                                    data-payment="{{ $pm->id }}"><i class='ti ti-cash-banknote'></i>
                                                </button>

                                                <a style="cursor: pointer" href="{{ route('print.barcode', $pm->no_lab) }}" class="btn btn-warning" target="_blank"><i class="ti ti-barcode"></i></a>
                                                

                                                <form id="delete-form-{{ $pm->id }}"
                                                    action="{{ route('pasien.destroy', $pm->no_lab) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                
                                                <button class="btn btn-danger"
                                                    onclick="confirmDelete({{ $pm->id }})"><i
                                                    class="ti ti-trash"></i>
                                                </button>

                                            
                                                </td>
                                        </tr>
                                        @php
                                            $counter++; // Tambah counter setelah setiap iterasi
                                        @endphp
                                    @empty
                                    @endforelse

                                    @forelse ($dikembalikan as $dk)
                                    <tr>
                                        <th id="checkin{{ $dk->id }}">
                                            <input style="font-size: 20px; cursor: pointer; display: none" type="checkbox" class="form-check-input checkbox_ids" value="{{ $dk->id }}">
                                        </th>
                                            <td scope="row">{{ $counter }}</td>
                                            <td class="text-center">
                                                <i class='ti ti-bell-filled {{ $dk->cito == '1' ? 'text-danger' : 'text-secondary' }}'
                                                    style="font-size: 23px;"></i>
                                            </td>
                                            <td class="col-2">{{ $dk->nama }}</td>
                                            <!-- ganti format dengan tanggal-bulan-tahun -->
                                            <td class="col-2">
                                                {{ date('d-m-Y', strtotime($dk->lahir)) }}
                                                <br>
                                                ({{ \Carbon\Carbon::parse($dk->lahir)->age }} tahun)
                                            </td>
                                            <td>{{ $dk->jenis_kelamin }}</td>
                                            <td>{{ $dk->alamat }}</td>
                                            <td>{{ $dk->asal_ruangan }}</td>
                                            <td>
                                                @if ($dk->status == 'Dikembalikan Analyst')
                                                    <span class="badge bg-warning text-white">Returned by analyst</span>
                                                @endif
                                            </td>
                                            <td class="col-md-3">
                                                <button type="button" data-bs-target="#modalPreviewPasien"
                                                    data-bs-toggle="modal" class="btn btn-info btn-edit text-white "
                                                    data-id="{{ $dk->id }}"><i class='ti ti-edit'></i>
                                                </button>
                                                    
                                                <button type="button" data-bs-target="#modalPembayaran"
                                                    data-bs-toggle="modal" class="btn btn-secondary btn-payment text-white" 
                                                    data-payment="{{ $dk->id }}"><i class='ti ti-cash-banknote'></i>
                                                </button>

                                                <a style="cursor: pointer" href="{{ route('print.barcode', $dk->no_lab) }}" class="btn btn-warning" target="_blank"><i class="ti ti-barcode"></i></a>
                                                

                                                <form id="delete-form-{{ $dk->id }}"
                                                    action="{{ route('pasien.destroy', $dk->no_lab) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                
                                                <button class="btn btn-danger"
                                                    onclick="confirmDelete({{ $dk->id }})"><i
                                                    class="ti ti-trash"></i>
                                                </button>

                                            
                                                </td>
                                        </tr>
                                        @php
                                            $counter++; // Tambah counter setelah setiap iterasi
                                        @endphp
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
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="sampleHistoryModalLabel">Preview Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body scrollbox" style="max-height: 550px;">
                    <div class="row scrollbox-inner">
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
                                    <th scope="row">No.RM</th>
                                    <td>
                                        <div class="flex-container">
                                            :  <span class="ms-2" id="Norm"></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Cito</th>
                                    <td>
                                        <div class="flex-container">
                                            <span class="label">:</span>
                                            <i class="ti ti-bell-filled" id="Cito"></i>
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
                    <a style="cursor: pointer" id="editBtn" class="btn btn-outline-primary">Edit</a>
                </div>

            </div>
        </div>
    </div>
    {{-- Pembayaran Pasien --}}
    <div class="modal fade" id="modalPembayaran" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="sampleHistoryModalLabel">Preview Patient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="pembayaran-pasien" style="max-height: 700px;">
                    <form action="{{ route('pasien.kirimlab') }}" method="POST">
                        @csrf
                        <div class="row">
                         <div>
                            <h5>Payment</h5>
                            <hr>
                            <div id="detailPembayaran">
                            </div>
                         </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success payment" id="submit-button" type="submit" >Payment</button>
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
            let detailPemeriksaan = document.getElementById('detailPemeriksaan');
            
            $('.btn-edit').on('click', function() {
                const id = this.getAttribute('data-id');

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
                            no_rm,
                            nik,
                            nama,
                            jenis_kelamin,
                            no_telp,
                            alamat,
                            jenis_pelayanan,
                            asal_ruangan,
                            diagnosa,
                            kode_dokter
                        } = res.data;

                        dokter = res.data.dokter;
                        data_pemeriksaan_pasien = res.data.dpp;
                        const history = res.data.history;
                        // console.log(res.data.history);
                        // Mencari riwayat dengan proses 'Dikembalikan oleh analyst'
                        const historyItem = history.find(h => h.proses === 'Dikembalikan oleh analyst');

                        // Menampilkan informasi pasien
                        $('#Cito').val(cito == 1 ? 'text-danger' : 'text-secondary');
                        const citoIcon = $('#Cito');
                        if (cito == '1') {
                            citoIcon.removeClass('text-secondary').addClass('text-danger');
                        } else {
                            citoIcon.removeClass('text-danger').addClass('text-secondary');
                        }
                        $('#Nolab').text(no_lab);
                        $('#Norm').text(no_rm);
                        $('#Nik').text(nik);
                        $('#Nama').text(nama);
                        $('#Gender').text(jenis_kelamin);
                        $('#Alamat').text(alamat);
                        $('#Telp').text(no_telp);
                        $('#JenisPelayanan').text(jenis_pelayanan);
                        $('#Ruangan').text(asal_ruangan);
                        const dokterText = dokter != null && dokter.nama_dokter ? dokter.nama_dokter : kode_dokter;
                        $('#Dokter').text(kode_dokter);
                        $('#Ruangandok').text(asal_ruangan);
                        $('#Telpdok').text(dokter != null ? dokter.no_telp : '-');
                        $('#Email').html(dokter != null ? dokter.email : '-');
                        $('#Diagnosa').val(diagnosa);

                        // Menampilkan detail pemeriksaan dan note (jika ada)
                        let detailContent = '<div class="row">';
                        data_pemeriksaan_pasien.forEach((e, i) => {
                            detailContent += `<div class="col-12 col-md-6" id="${e.id_departement}">
                                                <h6>${e.data_departement.nama_department}</h6>
                                                <ol>`;
                            e.pasiens.forEach((e, i) => {
                                detailContent += `<li>${e.data_pemeriksaan.nama_pemeriksaan}- Rp ${e.data_pemeriksaan.harga}</li>`;
                            });
                            detailContent += `</ol></div>`;
                        });
                        detailContent += '</div>';

                        // Jika terdapat note dari analyst, tampilkan di bawah detail pemeriksaan
                        if (historyItem && historyItem.note) {
                            detailContent += `
                                <div class="col-lg-12">
                                    <h6 class="fw-bold mt-2">Note dari Analyst</h6>
                                    <textarea id="noteTextarea" class="form-control" rows="3" placeholder="${historyItem.note}" disabled></textarea>
                                </div>
                            `;
                        }

                        detailPemeriksaan.innerHTML = detailContent;

                        // Menyesuaikan URL untuk tombol edit
                        var editBtn = document.getElementById('editBtn');
                        var editUrl = "{{ route('pasien.viewedit', ':no_lab') }}";
                        editUrl = editUrl.replace(':no_lab', no_lab);
                        editBtn.href = editUrl;
                    }
                });
            });
        })
    </script>


    <script>
        $(function() {
            let detailPembayaran = document.getElementById('detailPembayaran');
            $('.btn-payment').on('click', function() {
                const id = this.getAttribute('data-payment');

                fetch(`/api/get-data-pasien/${id}?t=${new Date().getTime()}`).then(response => {
                    if (!response.ok) {
                        throw new Error("HTTP error" + response.status);
                    }
                    return response.json();
                }).then(res => {
                    if (res.status === 'success') {
                        let data_pasien = res.data;
                        let data_pemeriksaan_pasien = res.data.dpp;

                        let detailContent = '<div class="row">';
                        let totalHarga = 0;
                        let departmentIds = new Set();

                        // Memfilter data dengan status "baru" dari `pasiens`
                        data_pemeriksaan_pasien.forEach((e) => {
                            let filteredPasiens = e.pasiens.filter(pemeriksaan => pemeriksaan.status === 'baru');

                            if (filteredPasiens.length > 0) {
                                let departmentName = e.data_departement.nama_department;

                                if (!departmentIds.has(e.id_departement)) {
                                    departmentIds.add(e.id_departement);
                                    detailContent += `<div class="col-12 col-md-6" id="${e.id_departement}">
                                                        <h6>${departmentName}</h6>
                                                        <ol>`;
                                }

                                filteredPasiens.forEach((pemeriksaan) => {
                                    detailContent += `<li>${pemeriksaan.data_pemeriksaan.nama_pemeriksaan} - Rp ${pemeriksaan.data_pemeriksaan.harga}</li>`;
                                    totalHarga += pemeriksaan.data_pemeriksaan.harga;
                                });

                                detailContent += `</ol><hr></div>`;
                            }
                        });

                        detailContent += '</div>';
                        let pembayaranContent = `
                            <h5>Payment Details</h5>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-12 col-md-6">
                                    <label>Payment Method</label>
                                    <input class="form-control " type="text" name="no_lab" value="${data_pasien.no_lab}" readonly hidden>
                                    <input class="form-control bg-secondary-subtle" type="text" name="metode_pembayaran" value="${data_pasien.jenis_pelayanan}" readonly>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label>Total Payment</label>
                                    <input class="form-control bg-secondary-subtle" type="text" id="total_pembayaran_asli" name="total_pembayaran_asli" value="${totalHarga}" readonly>
                                </div>
                                ${data_pasien.jenis_pelayanan === 'bpjs' ? `
                                    <div class="col-12 col-md-6">
                                        <label>No Bpjs</label>
                                        <input class="form-control" id="no_pasien" name="no_pasien" type="number"  required />
                                    </div>
                                ` : ''}
                                ${data_pasien.jenis_pelayanan === 'asuransi' ? `
                                    <div class="col-12 col-md-6">
                                        <label>No Asuransi</label>
                                        <input class="form-control" id="no_pasien" name="no_pasien" type="number" required />
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label>Penjamin</label>
                                        <input class="form-control" id="penjamin" name="penjamin" type="text" required />
                                    </div>
                                ` : ''}
                                <div class="col-12 col-md-6">
                                    <label>Officer</label>
                                    <input class="form-control" type="text" name="petugas" required>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label>Disc</label>
                                    <input class="form-control " id="diskon" name="diskon" type="number" placeholder="Enter discount if any" value="" min="0">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label>Payment Amount</label>
                                    <input class="form-control " id="jumlah_bayar" name="jumlah_bayar" type="number" value="">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label>Total Payment Disc</label>
                                    <input class="form-control bg-secondary-subtle" type="text" id="total_pembayaran" name="total_pembayaran" value="${totalHarga}" readonly>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label>Change Money</label>
                                    <input class="form-control bg-secondary-subtle" value="" id="kembalian" name="kembalian" readonly>
                                </div>
                            </div>
                        `;
                        detailContent += pembayaranContent;

                        detailPembayaran.innerHTML = detailContent;

                        function hitungTotalPembayaran() {
                            let totalPembayaranAsli = parseFloat(document.getElementById('total_pembayaran_asli').value);
                            let diskon = parseFloat(document.getElementById('diskon').value) || 0;
                            let totalSetelahDiskon = totalPembayaranAsli - diskon;
                            if (totalSetelahDiskon < 0) {
                                totalSetelahDiskon = 0;
                            }
                            document.getElementById('total_pembayaran').value = totalSetelahDiskon;
                        }

                        function hitungKembalian() {
                            let totalPembayaran = parseFloat(document.getElementById('total_pembayaran').value);
                            let jumlahBayar = parseFloat(document.getElementById('jumlah_bayar').value) || 0;
                            let kembalian = jumlahBayar - totalPembayaran;
                            document.getElementById('kembalian').value = kembalian >= 0 ? kembalian : 0;

                            let submitButton = document.getElementById('submit-button');
                            if (jumlahBayar >= totalPembayaran) {
                                submitButton.disabled = false;
                            } else {
                                submitButton.disabled = true;
                            }
                        }

                        document.getElementById('jumlah_bayar').addEventListener('input', function() {
                            hitungTotalPembayaran();
                            hitungKembalian();
                        });

                        document.getElementById('diskon').addEventListener('input', function() {
                            hitungTotalPembayaran();
                            hitungKembalian();
                        });
                        document.getElementById('submit-button').disabled = true;

                        if (data_pasien.status === 'Telah Dibayar') {
                            document.querySelector('.btn-payment').disabled = true;
                        }

                        // Jika status pasien 'Dikembalikan Analyst', ambil data no_pasien dari API
                        if (data_pasien.status === 'Dikembalikan Analyst') {
                            fetch(`/api/get-data-pasien/${id}`).then(response => response.json())
                            .then(data => {
                                let pembayaranArray = data.data.pembayaran;

                                // Pastikan pembayaranArray adalah array dan memiliki elemen
                                if (Array.isArray(pembayaranArray) && pembayaranArray.length > 0) {
                                    let pembayaran = pembayaranArray[0]; // Ambil elemen pertama dari array
                                    let no_pasien = pembayaran.no_pasien; // Ambil no_pasien dari objek
                                    let nopasienInput = document.getElementById('no_pasien');

                                    if (data_pasien.jenis_pelayanan === 'bpjs' || data_pasien.jenis_pelayanan === 'asuransi') {
                                        nopasienInput.value = no_pasien;
                                        nopasienInput.disabled = true;
                                    }
                                } else {
                                    console.error('Pembayaran is an empty array or not an array');
                                }
                            }).catch(error => console.error('Error fetching no_pasien:', error));
                        }
                    }
                });
            });
        });

    </script>
    
<script>
    $(function(e){
        $("#select_all_ids").click(function(){
            $('.checkbox_ids').prop('checked',$(this).prop('checked'));
        });
        $('#konfirmasiallselecteddata').click(function(e){
            e.preventDefault();
            var all_ids = [];
            $('input:checkbox[name=ids]:checked').each(function(){
                all_ids.push($(this).val());
            });

            $.ajax({
                url:"{{ route('pasien.checkin') }}",
                method:"POST",
                data:{
                    ids:all_ids,
                    _token:'{{csrf_token()}}'
                },
                success:function(response){
                    $.each(all_ids,function(key,val){
                        $('#checkin'+val).remove();
                    })
                    location.reload()

                }
            })
        })
    });

</script>

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
