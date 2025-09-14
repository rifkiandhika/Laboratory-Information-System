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
                                    <div class="h3 mt-3 font-weight-bold text-gray-600">{{ $dl }}</div>

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
                        <div>
                            <table class="table table-striped table-bordered table-responsive" id="myTable">
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
                                            <td class="col-md-1">
                                                <div class="dropdown">
                                                    <a href="#" class="text-secondary" id="aksiDropdown{{ $dc->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ti ti-dots-vertical fs-5"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="aksiDropdown{{ $dc->id }}">
                                                        <li>
                                                            <button type="button" data-bs-target="#modalPreviewPasien"
                                                                data-bs-toggle="modal" class="dropdown-item btn-edit btn-update"
                                                                data-id="{{ $dc->id }}">
                                                                <i class="ti ti-edit me-2"></i> Edit
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button type="button" data-bs-target="#modalPembayaran"
                                                                data-bs-toggle="modal" class="dropdown-item btn-payment"
                                                                data-payment="{{ $dc->id }}">
                                                                <i class="ti ti-cash-banknote me-2"></i> Payment
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item disabled"
                                                                    onclick="showBarcodeModal('{{ $dc->no_lab }}')">
                                                                <i class="ti ti-barcode me-2"></i> Barcode
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <form id="delete-form-{{ $dc->id }}"
                                                                action="{{ route('pasien.destroy', $dc->no_lab) }}" method="POST"
                                                                style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                            <button class="dropdown-item text-danger"
                                                                onclick="confirmDelete({{ $dc->id }})">
                                                                <i class="ti ti-trash me-2"></i> Delete
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
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
                                            <td class="col-md-1">
                                                <div class="dropdown">
                                                    <a href="#" class="text-secondary" id="aksiDropdown{{ $pm->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ti ti-dots-vertical fs-5"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="aksiDropdown{{ $pm->id }}">
                                                        <li>
                                                            <button type="button" data-bs-target="#modalPreviewPasien"
                                                                data-bs-toggle="modal" class="dropdown-item btn-edit btn-update"
                                                                data-id="{{ $pm->id }}">
                                                                <i class="ti ti-edit me-2"></i> Edit
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button type="button" data-bs-target="#modalPembayaran"
                                                                data-bs-toggle="modal" class="dropdown-item btn-payment disabled btn-secondary"
                                                                data-payment="{{ $pm->id }}">
                                                                <i class="ti ti-cash-banknote me-2"></i> Payment
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item"
                                                                onclick="showBarcodeModal('{{ $pm->id }}', '{{ $pm->no_lab }}')">
                                                                <i class="ti ti-barcode me-2"></i> Barcode
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <form id="delete-form-{{ $pm->id }}"
                                                                action="{{ route('pasien.destroy', $pm->no_lab) }}" method="POST"
                                                                style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                            <button class="dropdown-item text-danger"
                                                                onclick="confirmDelete({{ $pm->id }})">
                                                                <i class="ti ti-trash me-2"></i> Delete
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
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
                                            <td class="col-md-1">
                                                <div class="dropdown">
                                                    <a href="#" class="text-secondary" id="aksiDropdown{{ $dk->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ti ti-dots-vertical fs-5"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="aksiDropdown{{ $dk->id }}">
                                                        <li>
                                                            <button type="button" data-bs-target="#modalPreviewPasien"
                                                                data-bs-toggle="modal" class="dropdown-item btn-edit btn-update btn-bf"
                                                                data-id="{{ $dk->id }}">
                                                                <i class="ti ti-edit me-2"></i> Edit
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button type="button" data-bs-target="#modalPembayaran"
                                                                data-bs-toggle="modal" class="dropdown-item btn-payment btn-pybf"
                                                                data-payment="{{ $dk->id }}">
                                                                <i class="ti ti-cash-banknote me-2"></i> Payment
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item btn-bcbf"
                                                                onclick="showBarcodeModal('{{ $dk->id }}', '{{ $dk->no_lab }}')">
                                                                <i class="ti ti-barcode me-2"></i> Barcode
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <form id="delete-form-{{ $dk->id }}"
                                                                action="{{ route('pasien.destroy', $dk->no_lab) }}" method="POST"
                                                                style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                            <button class="dropdown-item text-danger"
                                                                onclick="confirmDelete({{ $dk->id }})">
                                                                <i class="ti ti-trash me-2"></i> Delete
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
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
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Patient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="pembayaran-pasien">
                    <form id="paymentForm" action="{{ route('pasien.kirimlab') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div>
                                <h5>Payment</h5>
                                <hr>
                                <div id="detailPembayaran"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success payment" id="submit-button" type="submit">Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Barcode Modal --}}
    <div class="modal fade" id="barcodeModal" tabindex="-1" aria-labelledby="barcodeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="barcodeModalLabel">
                        <i class="ti ti-barcode me-2"></i>Barcode Pasien
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">

                    <div id="patientInfo" class="mb-3 text-center">
                        <!-- Nama dan Tanggal Lahir akan ditampilkan di sini -->
                    </div>

                    <div class="mb-3">
                        <strong>No Lab: <span id="currentNoLab"></span></strong>
                    </div>
                                    
                    <!-- Dynamic Barcode Container -->
                    <div class="row" id="barcodeRow">
                        <!-- Barcode akan ditampilkan di sini secara dinamis -->
                    </div>
                    
                    <!-- Info Barcode -->
                    <div class="alert alert-info">
                        <small>
                            <i class="ti ti-info-circle me-1"></i>
                            Barcode menggunakan format Code 128 dan dapat di-scan dengan scanner barcode standar.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" id="printButtons">
                        <!-- Tombol print akan ditampilkan di sini secara dinamis -->
                    </div>
                    <div class="btn-group" id="downloadButtons">
                        <!-- Tombol download akan ditampilkan di sini secara dinamis -->
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>


@endsection


@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // console.log('Echo:', Echo); // Cek apakah Echo sudah didefinisikan
        Echo.channel('data-updates')
            .listen('DataUpdated', (e) => {
                console.log('Data diperbarui:', e);
                location.reload(); // Contoh: refresh halaman saat event diterima
            });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        initializeButtons('.btn-bf', 'buttonBF', 'data-id');      // Tombol Edit
        initializeButtons('.btn-pybf', 'buttonPYBF', 'data-payment');  // Tombol Payment
        initializeButtons('.btn-bcbf', 'buttonBCBF', 'data-barcode');  // Tombol Barcode
        
    });

    function initializeButtons(selector, storageKeyPrefix, dataAttr) {
        const buttons = document.querySelectorAll(selector);

        buttons.forEach(button => {
            const id = button.getAttribute(dataAttr);
            if (!id) return;

            const storageKey = `${storageKeyPrefix}_${id}`;

            // Cek apakah tombol pernah diklik (diambil dari localStorage)
            if (localStorage.getItem(storageKey) === 'true') {
                changeButtonColor(button, storageKeyPrefix);
            } else {
                resetToDefault(button);
            }

            // Event listener untuk klik tombol
            button.addEventListener('click', function () {
                const currentStatus = localStorage.getItem(storageKey) === 'true';
                
                if (currentStatus) {
                    localStorage.setItem(storageKey, 'false'); // Reset ke abu-abu
                    resetToDefault(button);
                } else {
                    localStorage.setItem(storageKey, 'true'); // Ubah warna sesuai fungsi tombol
                    changeButtonColor(button, storageKeyPrefix);
                }
            });
        });
    }

    function resetToDefault(button) {
        button.classList.remove('btn-warning', 'btn-success', 'btn-info');
        button.classList.add('btn-secondary');
    }

    function changeButtonColor(button, storageKeyPrefix) {
        button.classList.remove('btn-secondary');

        if (storageKeyPrefix === 'buttonBF') {
            button.classList.add('btn-info'); // Tombol Edit (Biru)
        } else if (storageKeyPrefix === 'buttonPYBF') {
            button.classList.add('btn-success'); // Tombol Payment (Hijau)
        } else if (storageKeyPrefix === 'buttonBCBF') {
            button.classList.add('btn-warning'); // Tombol Barcode (Kuning)
        }
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    // Ambil semua tombol dengan class 'btn-update'
    const buttons = document.querySelectorAll(".btn-update");

    buttons.forEach(button => {
        const buttonId = button.getAttribute("data-id"); // Ambil ID tombol

        // Cek di localStorage apakah tombol ini sudah diklik
        if (localStorage.getItem(`button_clicked_${buttonId}`) === "true") {
            button.classList.remove("btn-secondary");
            button.classList.add("btn-info");
        }

        // Tambahkan event click
        button.addEventListener("click", function () {
            button.classList.remove("btn-secondary");
            button.classList.add("btn-info");

            // Simpan status di localStorage
            localStorage.setItem(`button_clicked_${buttonId}`, "true");
        });
    });
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        initializeBarcodeButtons();
        initializePaymentButton();
    });

    function initializeBarcodeButtons() {
        const barcodeButtons = document.querySelectorAll('.barcodeBtn');
        barcodeButtons.forEach(button => {
            const noLab = button.getAttribute('data-id');
            const barcodeStatusKey = `buttonBarcode_${noLab}`;

            // Pastikan warna sesuai dengan localStorage
            if (localStorage.getItem(barcodeStatusKey) === 'true') {
                button.classList.remove('btn-secondary');
                button.classList.add('btn-warning');
            } else {
                button.classList.remove('btn-warning');
                button.classList.add('btn-secondary');
            }

            button.addEventListener('click', function () {
                this.classList.remove('btn-secondary');
                this.classList.add('btn-warning');
                localStorage.setItem(barcodeStatusKey, 'true');
            });
        });
    }

    function initializePaymentButton() {
        const paymentForm = document.getElementById('paymentForm');
        if (!paymentForm) return;

        paymentForm.addEventListener('submit', function (event) {
            const paymentButton = document.querySelector('.btn-payment');
            if (paymentButton) {
                const paymentId = paymentButton.getAttribute('data-payment');
                const paymentStatusKey = `buttonPayment_${paymentId}`;

                localStorage.setItem(paymentStatusKey, 'true');

                // Ubah warna tombol payment setelah submit
                paymentButton.classList.remove('btn-secondary');
                paymentButton.classList.add('btn-success');
            }
        });

        // Pastikan warna tombol payment sesuai dengan localStorage saat halaman dimuat
        const paymentButtons = document.querySelectorAll('.btn-payment');
        paymentButtons.forEach(button => {
            const paymentId = button.getAttribute('data-payment');
            const paymentStatusKey = `buttonPayment_${paymentId}`;

            if (localStorage.getItem(paymentStatusKey) === 'true') {
                button.classList.remove('btn-secondary');
                button.classList.add('btn-success');
            } else {
                button.classList.remove('btn-warning');
                button.classList.add('btn-secondary');
            }
        });
    }
</script>


{{-- edit --}}
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

        fetch(`/api/get-data-pasien/${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error("HTTP error" + response.status);
            }
            return response.json();
        }).then(res => {
            if (res.status === 'success') {
                let data_pasien = res.data;
                let data_pemeriksaan_pasien = res.data.dpp;
                
                // Dapatkan no_lab pasien yang sedang diproses
                let currentNoLab = data_pasien.no_lab;
                
                let detailContent = '<div class="row">';
                let totalHarga = 0;
                let departmentIds = new Set();
                
                // Cek apakah ini paket MCU berdasarkan no_lab
                let isMCUPackage = currentNoLab && currentNoLab.includes('MCU');
                let packagePrice = 0; // Harga paket dari database
                let originalPackagePrice = 0; // Harga total individual

                // Reset semua nilai sebelumnya
                totalHarga = 0;
                packagePrice = 0;
                originalPackagePrice = 0;

                // Memfilter data dengan status "baru" dan no_lab yang sesuai
                data_pemeriksaan_pasien.forEach((e) => {
                    // Pastikan hanya data dengan no_lab yang sesuai yang diproses
                    if (e.no_lab !== currentNoLab) return;
                    
                    // Untuk paket MCU, ambil harga paket dari database
                    if (isMCUPackage) {
                        packagePrice = e.harga; // Ambil harga paket terbaru
                    }
                    
                    // Cek apakah ada pasiens dengan status "baru" di dalam array e.pasiens
                    let filteredPasiens = e.pasiens.filter(pemeriksaan => 
                        pemeriksaan.status === 'baru' && pemeriksaan.no_lab === currentNoLab
                    );

                    if (filteredPasiens.length > 0) {
                        let departmentName = e.data_departement.nama_department;

                        if (!departmentIds.has(e.id_departement)) {
                            departmentIds.add(e.id_departement);
                            detailContent += `<div class="col-12 col-md-6" id="${e.id_departement}">
                                                <h6>${departmentName}</h6>
                                                <ol>`;
                        }

                        filteredPasiens.forEach((pemeriksaan) => {
                            // Tampilkan harga asli pemeriksaan (tidak berubah)
                            let hargaAsli = pemeriksaan.data_pemeriksaan.harga;
                            detailContent += `<li>${pemeriksaan.data_pemeriksaan.nama_pemeriksaan} - Rp ${hargaAsli.toLocaleString('id-ID')}</li>`;
                            
                            // Hitung total harga individual untuk perbandingan
                            originalPackagePrice += Number(pemeriksaan.data_pemeriksaan.harga);
                        });
                        
                        detailContent += `</ol><hr></div>`;
                    }
                });

                // Tentukan total harga berdasarkan jenis
                if (isMCUPackage) {
                    totalHarga = packagePrice;
                } else {
                    totalHarga = originalPackagePrice;
                }

                console.log('Current No Lab:', currentNoLab);
                console.log('Total Harga:', totalHarga);
                console.log('Is Package:', isMCUPackage);
                console.log('Package Price from DB:', packagePrice);
                console.log('Original Individual Price:', originalPackagePrice);

                detailContent += '</div>';
                let pembayaranContent = `
                    <h5>Payment Details</h5>
                    <hr>
                    ${isMCUPackage && originalPackagePrice > packagePrice ? `
                        <div class="alert alert-info">
                            <strong>Paket ${currentNoLab.includes('MCU') ? 'MCU' : 'Khusus'} - Diskon Khusus!</strong><br>
                            Total Harga Individual: Rp ${originalPackagePrice.toLocaleString('id-ID')}<br>
                            Harga Paket: Rp ${packagePrice.toLocaleString('id-ID')}<br>
                            <span class="text-success"><strong>Hemat: Rp ${(originalPackagePrice - packagePrice).toLocaleString('id-ID')}</strong></span>
                        </div>
                    ` : ''}
                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <label>Payment Method</label>
                            <input class="form-control " type="text" name="no_lab" value="${currentNoLab}" readonly hidden>
                            <input class="form-control bg-secondary-subtle" type="text" name="metode_pembayaran" value="${data_pasien.jenis_pelayanan}" readonly>
                        </div>
                        <div class="col-12 col-md-6">
                            <label>Total Payment</label>
                            <input class="form-control bg-secondary-subtle" type="text" id="total_pembayaran_asli" name="total_pembayaran_asli" value="${totalHarga}" readonly>
                        </div>
                        ${data_pasien.jenis_pelayanan === 'umum' ? `
                            <div class="col-12 col-md-6">
                                <label>No Transaksi</label>
                                <input class="form-control" id="no_pasien" name="no_pasien" type="number"  required />
                            </div>
                        ` : ''}
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
                            <input class="form-control " id="diskon" name="diskon" type="number" placeholder="Enter discount if any" value="0" min="0">
                        </div>
                        <div class="col-12 col-md-6">
                            <label>Payment Amount</label>
                            <input class="form-control " id="jumlah_bayar" name="jumlah_bayar" type="number" value="0" min="0">
                        </div>
                        <div class="col-12 col-md-6">
                            <label>Total Payment Disc</label>
                            <input class="form-control bg-secondary-subtle" type="text" id="total_pembayaran" name="total_pembayaran" value="${totalHarga}" readonly>
                        </div>
                        <div class="col-12 col-md-6">
                            <label>Change Money</label>
                            <input class="form-control bg-secondary-subtle" value="0" id="kembalian" name="kembalian" readonly>
                        </div>
                    </div>
                `;
                detailContent += pembayaranContent;

                detailPembayaran.innerHTML = detailContent;

                // Fungsi untuk menghitung total pembayaran setelah diskon
                function hitungTotalPembayaran() {
                    let totalPembayaranAsli = parseFloat(document.getElementById('total_pembayaran_asli').value) || 0;
                    let diskon = parseFloat(document.getElementById('diskon').value) || 0;
                    let totalSetelahDiskon = totalPembayaranAsli - diskon;
                    
                    if (totalSetelahDiskon < 0) {
                        totalSetelahDiskon = 0;
                    }
                    
                    document.getElementById('total_pembayaran').value = totalSetelahDiskon;
                    hitungKembalian(); // Panggil hitungKembalian setelah mengupdate total
                }

                // Fungsi untuk menghitung uang kembalian
                function hitungKembalian() {
                    let totalPembayaran = parseFloat(document.getElementById('total_pembayaran').value) || 0;
                    let jumlahBayar = parseFloat(document.getElementById('jumlah_bayar').value) || 0;
                    let kembalian = jumlahBayar - totalPembayaran;
                    
                    document.getElementById('kembalian').value = kembalian >= 0 ? kembalian : 0;

                    let submitButton = document.getElementById('submit-button');
                    if (jumlahBayar >= totalPembayaran && totalPembayaran > 0) {
                        submitButton.disabled = false;
                    } else {
                        submitButton.disabled = true;
                    }
                }

                // Event listener untuk input jumlah bayar dan diskon
                document.getElementById('jumlah_bayar').addEventListener('input', hitungKembalian);
                document.getElementById('diskon').addEventListener('input', hitungTotalPembayaran);

                // Nonaktifkan tombol submit awal
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
        }).catch(error => {
            console.error('Error fetching patient data:', error);
            alert('Terjadi kesalahan saat mengambil data pasien. Silakan coba lagi.');
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

{{-- menghitung kembalian --}}
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

{{-- Script Barcode --}}
<script>
    let barcodeModal;
    let currentBarcodeData = '';
    let availableDepartments = [];
    let patientDepartments = [];
    let currentPatientName = '';
    let currentPatientDOB = '';

    document.addEventListener('DOMContentLoaded', function () {
        barcodeModal = new bootstrap.Modal(document.getElementById('barcodeModal'));
    });

    async function fetchPatientDepartments(id) {
        try {
            const response = await fetch(`/api/get-data-pasien/${id}`);
            if (!response.ok) throw new Error(`HTTP error ${response.status}`);
            const res = await response.json();
            if (res.data && Array.isArray(res.data.dpp)) {
                patientDepartments = res.data.dpp;
                return res.data.dpp;
            }
            return [];
        } catch (error) {
            console.error('Error fetching patient departments:', error);
            throw error;
        }
    }

    function detectDepartments(departments) {
        const activeDepts = [];

        departments.forEach((dept) => {
            const pemeriksaan = dept?.pasiens?.[0]?.data_pemeriksaan;
            if (pemeriksaan && pemeriksaan.barcode === 'active') {
                const deptName = dept.data_departement?.nama_department?.toLowerCase();
                if (deptName) {
                    activeDepts.push(deptName); // contoh: "kimia klinik"
                }
            }
        });

        return activeDepts;
    }

    function getDepartmentConfig(deptName) {
        switch (deptName.toLowerCase()) {
            case 'hematologi':
                return {
                    name: 'Hematologi',
                    code: 'H-',
                    icon: 'ti-droplet',
                    class: 'bg-success' // Ungu
                };
            case 'kimia klinik':
                return {
                    name: 'Kimia Klinik',
                    code: 'K-',
                    icon: 'ti-flask',
                    class: 'bg-primary' // Hijau
                };
            case 'imunoserologi':
                return {
                    name: 'Imunoserologi',
                    code: 'I-',
                    icon: 'ti-shield',
                    class: 'bg-warning' // Kuning
                };
            case 'mikrobiologi':
                return {
                    name: 'Mikrobiologi',
                    code: 'M-',
                    icon: 'ti-bug',
                    class: 'bg-danger' // Merah
                };
            default:
                return {
                    name: deptName,
                    code: 'X-',
                    icon: 'ti-alert-circle',
                    class: 'bg-secondary' // Default abu-abu
                };
        }
    }


    async function showBarcodeModal(id, noLab = '', departments = null) {
        try {
            if (!id) throw new Error("ID pasien tidak boleh kosong");
            document.getElementById('currentNoLab').textContent = noLab;
            currentBarcodeData = noLab;

            const barcodeRow = document.getElementById('barcodeRow');
            const downloadButtons = document.getElementById('downloadButtons');
            const patientInfo = document.getElementById('patientInfo');

            barcodeRow.innerHTML = '<div class="col-12 text-center"><div class="spinner-border"></div><p>Memuat data departemen...</p></div>';
            downloadButtons.innerHTML = '';
            patientInfo.innerHTML = '';
            barcodeModal.show();

            let resData;
            if (!departments) {
                const response = await fetch(`/api/get-data-pasien/${id}`);
                if (!response.ok) throw new Error(`HTTP error ${response.status}`);
                const res = await response.json();
                departments = res.data.dpp;
                resData = res.data;
            }

            availableDepartments = detectDepartments(departments);

            if (resData && resData.nama && resData.lahir) {
                const formattedLahir = new Date(resData.lahir).toLocaleDateString('id-ID', {
                    year: 'numeric', month: 'long', day: 'numeric'
                });

                currentPatientName = resData.nama;
                currentPatientDOB = formattedLahir;

                patientInfo.innerHTML = `
                    <h6 class="mb-1"><strong>Nama : ${resData.nama}</strong></h6>
                    <p class="text-muted mb-0">Tanggal Lahir : ${formattedLahir}</p>
                `;
            }

            generateBarcodeUI();

        } catch (error) {
            console.error("Error:", error);
            document.getElementById('barcodeRow').innerHTML = `
                <div class="col-12 text-center">
                    <div class="alert alert-danger">Gagal memuat data: ${error.message}</div>
                    <button class="btn btn-primary" onclick="showBarcodeModal('${id}', '${noLab}')">Coba Lagi</button>
                </div>`;
        }
    }

    function generateBarcodeUI() {
        const barcodeRow = document.getElementById('barcodeRow');
        const downloadButtons = document.getElementById('downloadButtons');
        const printButtons = document.getElementById('printButtons');

        if (availableDepartments.length === 0) {
            barcodeRow.innerHTML = `<div class="col-12 text-center"><div class="alert alert-warning">Departemen tidak ditemukan.</div></div>`;
            downloadButtons.innerHTML = '';
            return;
        }

        
        downloadButtons.innerHTML = `
            <button class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                <i class="ti ti-download me-1"></i>Download
            </button>
            <ul class="dropdown-menu">
                ${availableDepartments.map(d => {
                    const c = getDepartmentConfig(d);
                    return `
                        <li><a class="dropdown-item" href="#" onclick="downloadBarcode('${d}')"><i class="me-1"></i>Download ${c.name}</a></li>
                    `;
                }).join('')}
            </ul>
        `;

        printButtons.innerHTML = `
            <button class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown">
                <i class="ti ti-printer me-1"></i>Print
            </button>
            <ul class="dropdown-menu">
                ${availableDepartments.map(d => {
                    const c = getDepartmentConfig(d);
                    return `
                        <li><a class="dropdown-item" href="#" onclick="printBarcode('${d}')">Print ${c.name}</a></li>
                    `;
                }).join('')}
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#" onclick="printAllBarcodes()">Print Semua</a></li>
            </ul>
        `;

        const colSize = availableDepartments.length === 1 ? '12' : '6';
        barcodeRow.innerHTML = '';

        // Generate tampilan barcode
        availableDepartments.forEach(dept => {
            const config = getDepartmentConfig(dept);
            const code = config.code + currentBarcodeData;
            const elementId = `barcode${dept}`;

            barcodeRow.innerHTML += `
                <div class="col-md-${colSize}">
                    <div class="card mb-3">
                        <div class="card-header ${config.class} text-white">
                            <i class="ti ${config.icon} me-1"></i> ${config.name}
                        </div>
                        <div class="card-body text-center">
                            <svg id="${elementId}"></svg>
                            <div class="mt-2"><strong>${code}</strong></div>
                        </div>
                    </div>
                </div>
            `;
        });

        // Render barcode
        setTimeout(() => {
            availableDepartments.forEach(dept => {
                const config = getDepartmentConfig(dept);
                const code = config.code + currentBarcodeData;
                const elementId = `barcode${dept}`;
                const svgEl = document.getElementById(elementId);

                if (svgEl) {
                    JsBarcode(svgEl, code, {
                        format: "CODE128",
                        width: 2,
                        height: 80,
                        displayValue: false,
                        fontSize: 14,
                        margin: 10
                    });
                } else {
                    console.warn(`Element #${elementId} tidak ditemukan, barcode tidak dirender.`);
                }
            });
        }, 100);
    }


    function downloadBarcode(dept) {
        const elementId = `barcode${dept}`;
        const svg = document.getElementById(elementId);
        if (!svg) return alert('Barcode tidak ditemukan');

        const config = getDepartmentConfig(dept);
        const code = config.code + currentBarcodeData;
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = 400;
        canvas.height = 240;

        const img = new Image();
        const svgBlob = new Blob([new XMLSerializer().serializeToString(svg)], { type: 'image/svg+xml' });
        const url = URL.createObjectURL(svgBlob);

        img.onload = () => {
            ctx.fillStyle = '#fff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            // Gambar barcode di posisi lebih atas karena tidak ada judul di atas
            ctx.drawImage(img, 50, 20, 300, 100);

            // Format: (Departemen) Kode-NoLab di bawah barcode
            ctx.fillStyle = '#000';
            ctx.font = 'bold 14px Arial';
            ctx.textAlign = 'center';
            const titleText = `(${config.name}) ${code}`;
            ctx.fillText(titleText, canvas.width / 2, 140);
            
            ctx.font = '12px Arial';
            ctx.fillText(`Nama: ${currentPatientName}`, canvas.width / 2, 160);
            ctx.fillText(`Tanggal Lahir: ${currentPatientDOB}`, canvas.width / 2, 180);
            ctx.font = '10px Arial';
            ctx.fillText(new Date().toLocaleDateString('id-ID'), canvas.width / 2, 200);

            canvas.toBlob(blob => {
                const link = document.createElement('a');
                link.download = `barcode_${currentBarcodeData}_${dept}.png`;
                link.href = URL.createObjectURL(blob);
                link.click();
            }, 'image/png');
        };

        img.onerror = () => alert("Gagal memuat gambar barcode");
        img.src = url;
    }

    function printBarcode(dept) {
    const elementId = `barcode${dept}`;
    const svg = document.getElementById(elementId);
    if (!svg) return alert('Barcode tidak ditemukan');

    const config = getDepartmentConfig(dept);
    const code = config.code + currentBarcodeData;
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    canvas.width = 400;
    canvas.height = 240;

    const img = new Image();
    const svgBlob = new Blob([new XMLSerializer().serializeToString(svg)], { type: 'image/svg+xml' });
    const url = URL.createObjectURL(svgBlob);

    img.onload = () => {
        // Gambar background putih
        ctx.fillStyle = '#fff';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        
        // Gambar barcode di posisi lebih atas karena tidak ada judul di atas
        ctx.drawImage(img, 50, 20, 300, 100);

        // Tambahkan teks dengan format "(Departemen) Kode-NoLab" di bawah barcode
        ctx.fillStyle = '#000';
        ctx.font = 'bold 14px Arial';
        ctx.textAlign = 'center';
        const titleText = `(${config.name}) ${code}`;
        ctx.fillText(titleText, canvas.width / 2, 140);
        ctx.font = '12px Arial';
        ctx.fillText(`Nama: ${currentPatientName}`, canvas.width / 2, 160);
        ctx.fillText(`Tanggal Lahir: ${currentPatientDOB}`, canvas.width / 2, 180);
        ctx.font = '10px Arial';
        ctx.fillText(new Date().toLocaleDateString('id-ID'), canvas.width / 2, 200);

        // Convert to image data URL
        const imageData = canvas.toDataURL("image/png");
        
        // Cleanup blob URL
        URL.revokeObjectURL(url);
        
        // Method 1: Menggunakan iframe tersembunyi (Recommended)
        printWithIframe(imageData, config.name);
        
        // Method 2: Alternative - jika method 1 tidak berfungsi, uncomment baris di bawah
        // printWithNewWindow(imageData, config.name);
    };

    img.onerror = () => {
        URL.revokeObjectURL(url);
        alert("Gagal memuat gambar barcode");
    };
    
    img.src = url;
}
async function printAllBarcodes() {
    if (availableDepartments.length === 0) {
        alert('Tidak ada barcode untuk diprint');
        return;
    }

    const printWindow = window.open('', '_blank', 'width=800,height=600');
    if (!printWindow) {
        alert('Pop-up diblokir! Silakan izinkan pop-up untuk print.');
        return;
    }

    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Print Semua Barcode</title>
            <style>
                @page { size: A4; margin: 0.5in; }
                body { font-family: Arial, sans-serif; text-align: center; }
                .page { page-break-after: always; padding: 20px; }
                img { max-width: 100%; height: auto; }
            </style>
        </head>
        <body>
    `);

    for (const dept of availableDepartments) {
        const elementId = `barcode${dept}`;
        const svg = document.getElementById(elementId);
        if (!svg) continue;

        const config = getDepartmentConfig(dept);
        const code = config.code + currentBarcodeData;

        // Convert SVG to PNG (pakai canvas sama seperti printBarcode)
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = 400;
        canvas.height = 240;

        const svgBlob = new Blob([new XMLSerializer().serializeToString(svg)], { type: 'image/svg+xml' });
        const url = URL.createObjectURL(svgBlob);

        await new Promise((resolve, reject) => {
            const img = new Image();
            img.onload = () => {
                ctx.fillStyle = '#fff';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(img, 50, 20, 300, 100);

                ctx.fillStyle = '#000';
                ctx.font = 'bold 14px Arial';
                ctx.textAlign = 'center';
                ctx.fillText(`(${config.name}) ${code}`, canvas.width / 2, 140);
                ctx.font = '12px Arial';
                ctx.fillText(`Nama: ${currentPatientName}`, canvas.width / 2, 160);
                ctx.fillText(`Tanggal Lahir: ${currentPatientDOB}`, canvas.width / 2, 180);
                ctx.font = '10px Arial';
                ctx.fillText(new Date().toLocaleDateString('id-ID'), canvas.width / 2, 200);

                const imageData = canvas.toDataURL("image/png");

                printWindow.document.write(`
                    <div class="page">
                        <img src="${imageData}" alt="Barcode ${config.name}" />
                    </div>
                `);

                URL.revokeObjectURL(url);
                resolve();
            };
            img.onerror = reject;
            img.src = url;
        });
    }

    printWindow.document.write(`</body></html>`);
    printWindow.document.close();

    // tunggu render lalu print
    printWindow.onload = () => {
        setTimeout(() => {
            printWindow.print();
        }, 500);
    };
}

// Method 1: Print menggunakan iframe tersembunyi
function printWithIframe(imageData, departmentName) {
    // Hapus iframe lama jika ada
    const oldIframe = document.getElementById('printFrame');
    if (oldIframe) {
        oldIframe.remove();
    }

    // Buat iframe tersembunyi
    const iframe = document.createElement('iframe');
    iframe.id = 'printFrame';
    iframe.style.position = 'absolute';
    iframe.style.width = '0px';
    iframe.style.height = '0px';
    iframe.style.border = 'none';
    
    document.body.appendChild(iframe);
    
    // Tunggu iframe siap
    iframe.onload = function() {
        const doc = iframe.contentDocument || iframe.contentWindow.document;
        
        doc.open();
        doc.write(`
            <!DOCTYPE html>
            <html>
                <head>
                    <title>Print Barcode - ${departmentName}</title>
                    <style>
                        @page {
                            margin: 0.5in;
                            size: A4;
                        }
                        body {
                            margin: 0;
                            padding: 20px;
                            text-align: center;
                            font-family: Arial, sans-serif;
                        }
                        .barcode-container {
                            display: inline-block;
                            border: 1px solid #ddd;
                            padding: 20px;
                            background: white;
                        }
                        img {
                            max-width: 100%;
                            height: auto;
                        }
                        @media print {
                            body { margin: 0; padding: 10px; }
                            .no-print { display: none; }
                        }
                    </style>
                </head>
                <body>
                    <div class="barcode-container">
                        <img src="${imageData}" alt="Barcode ${departmentName}" />
                    </div>
                </body>
            </html>
        `);
        doc.close();
        
        // Tunggu sebentar lalu print
        setTimeout(() => {
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
            
            // Hapus iframe setelah print selesai
            setTimeout(() => {
                iframe.remove();
            }, 1000);
        }, 500);
    };
    
    // Trigger onload
    iframe.src = 'about:blank';
}

// Method 2: Print dengan window baru (alternative)
function printWithNewWindow(imageData, departmentName) {
    const printWindow = window.open('', '_blank', 'width=800,height=600');
    
    if (!printWindow) {
        alert('Pop-up diblokir! Silakan izinkan pop-up untuk print.');
        return;
    }
    
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
            <head>
                <title>Print Barcode - ${departmentName}</title>
                <style>
                    @page {
                        margin: 0.5in;
                        size: A4;
                    }
                    body {
                        margin: 0;
                        padding: 20px;
                        text-align: center;
                        font-family: Arial, sans-serif;
                    }
                    .barcode-container {
                        display: inline-block;
                        border: 1px solid #ddd;
                        padding: 20px;
                        background: white;
                    }
                    img {
                        max-width: 100%;
                        height: auto;
                    }
                    .no-print {
                        margin-top: 20px;
                    }
                    @media print {
                        .no-print { display: none; }
                    }
                </style>
            </head>
            <body>
                <div class="barcode-container">
                    <img src="${imageData}" alt="Barcode ${departmentName}" onload="window.print();" />
                </div>
                <div class="no-print">
                    <p>Jika print tidak otomatis, tekan Ctrl+P</p>
                    <button onclick="window.print()">Print Manual</button>
                    <button onclick="window.close()">Tutup</button>
                </div>
            </body>
        </html>
    `);
    
    printWindow.document.close();
    
    // Auto close setelah print
    printWindow.addEventListener('afterprint', () => {
        setTimeout(() => {
            printWindow.close();
        }, 1000);
    });
}

    // supaya bisa dipanggil dari HTML
    window.printBarcode = printBarcode;


    // Agar bisa diakses oleh elemen HTML
    window.showBarcodeModal = showBarcodeModal;
    window.downloadBarcode = downloadBarcode;
    
</script>



    <script src="{{ asset('js/time.js') }}"></script>
@endpush
