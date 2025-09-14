@extends('layouts.admin')
@section('title', 'Spesiment Handling')

@section('content')
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
        .subtext {
            text-align: center;
            font-size: 1.2rem;
            margin-bottom: 1rem;
            font-weight: bold;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .detail-container {
            display: flex;
            gap: 20px; /* Space between items */
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100px; /* Adjust width as needed */
        }

        .detail-text {
            text-align: center;
            margin-bottom: 5px;
        }

        .detail-image-container {
            text-align: center;
        }

        .detail-image {
            display: block;
            margin-bottom: 5px;
        }

        .detail-radio-container {
            text-align: center;
        }

        .detail-radio {
            margin-top: 5px;
        }
        .dropdown-menu {
    max-height: none !important;
    overflow: visible !important;
}


</style>

<div>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex  mt-3">
            <h1 class="h3 mb-0 text-gray-600">Spesimen Handling</h1>
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
                                    Jumlah Pasien Masuk (Harian)</div>
                                <div class="h3 mt-3 font-weight-bold text-gray-600">{{ $pasienharian }}</div>
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
                                <div class="h3 mt-3 font-weight-bold text-gray-600">{{ $bl }}</div>
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
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pasien Telah Dilayani
                                </div>
                                <div class="h3 mt-3 font-weight-bold text-gray-600">{{ $dl }}</div>
                                <!-- <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div> -->
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
        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold" style="color: #96B6C5;">Antrian Pasien</h6>
                        <a href="#" id="konfirmasiallselecteddata"  type="button" class="btn btn-outline-primary mb-2 mt-2 ">Check In</a>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        {{-- <form action="{{ route('spesiment.checkin') }}" method="post">
                            @csrf
                            <div class="text-end">
                                <div class="text-end">
                                    <button type="submit" style="margin-right: 10px;" class="btn btn-outline-primary" id="check-in" hidden>Check In</button>
                                    <input  style="font-size: 20px" type="checkbox" class="form-check-input" id="checkbox-rect1" name="check">
                                    <label for="checkbox-rect1" class="mt-1">Check All</label>
                                </div>
                            </div>
                        </form> --}}
                        
                            <div>
                                <table class="table table-striped table-bordered table-responsive" id="myTable">
                                    <thead>
                                        <tr>
                                            <th class="sorting_disabled"><input style="font-size: 20px; cursor: pointer; clear:" type="checkbox" name="check" id="select_all_ids" class="form-check-input"></th>
                                            <th scope="col">Tanggal Order</th>
                                            <th scope="col">Cito</th>
                                            <th scope="col">No RM</th>
                                            <th scope="col">No LAB</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Asal Poli</th>
                                            <th scope="col">Umur</th>
                                            <th scope="col">Status</th>
                                            <th scope="col" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataPasienCito as $dpc)
                                        <tr>                                 
                                            <th id="checkin{{ $dpc->id }}">
                                                <input style="font-size: 20px; cursor: pointer;" type="checkbox" name="ids" id="checkbox" class="form-check-input checkbox_ids" value="{{ $dpc->id }}">
                                            </th>
                                            <td class="col-2">
                                                {{ date('d-m-Y', strtotime($dpc->tanggal_masuk)) }}/{{ date('H:i', strtotime($dpc->tanggal_masuk)) }}
                                            </td>
                                            <td>
                                                <i class='ti ti-bell-filled {{ $dpc->cito == '1' ? 'text-danger' : 'text-secondary' }}' style="font-size: 23px;"></i>
                                            </td>
                                            <td>{{ $dpc->no_rm }}</td>
                                            <td>{{ $dpc->no_lab }}</td>
                                            <td class="col-2">{{ $dpc->nama }}</td>
                                            <td>{{ $dpc->asal_ruangan }}</td>
                                            {{-- <td>
                                                @if ($dpc->cito == 1)
                                                <i class='bx bxs-bell-ring mt-2 ml-1 text-danger' style="font-size: 23px;"></i>
                                                @else
                                                <i class='bx bxs-bell-ring mt-2 ml-1 text-secondary' style="font-size: 23px;"></i>
                                                @endif
                                            </td> --}}
                                            <td class="col-1">
                                                {{ \Carbon\Carbon::parse($dpc->lahir)->age }} Tahun
                                            </td>
                                            <td>
                                                @if($dpc->status == "Acc Collection")
                                                <span class="badge bg-danger text-white">Waiting...</span>
                                                @elseif($dpc->status == "Acc Handling")
                                                <span class="badge bg-success text-white">Approved</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown position-static">
                                                    <!-- Tombol titik tiga -->
                                                    <a href="#" 
                                                    class="text-secondary" 
                                                    id="aksiDropdown{{ $dpc->id }}" 
                                                    data-bs-toggle="dropdown" 
                                                    data-bs-display="static" 
                                                    aria-expanded="false">
                                                        <i class="ti ti-dots-vertical fs-5"></i>
                                                    </a>

                                                    <!-- Menu dropdown tanpa ul li -->
                                                    <div class="dropdown-menu dropdown-menu-end  shadow" aria-labelledby="aksiDropdown{{ $dpc->id }}">
                                                        
                                                        <!-- Preview -->
                                                        <button class="dropdown-item btn-preview"
                                                                data-id="{{ $dpc->id }}"
                                                                data-bs-target="#modalSpesimen"
                                                                data-bs-toggle="modal">
                                                            <i class="ti ti-test-pipe-2 me-2"></i> Preview
                                                        </button>

                                                        <!-- Barcode -->
                                                        <button class="dropdown-item barcodeBtn btn-barcode"
                                                                onclick="showBarcodeModal('{{ $dpc->id }}', '{{ $dpc->no_lab }}')">
                                                            <i class="ti ti-barcode me-2"></i> Barcode
                                                        </button>

                                                        <!-- Edit -->
                                                        <button class="dropdown-item btn-edit"
                                                                data-id="{{ $dpc->id }}"
                                                                data-bs-target="#modalEdit"
                                                                data-bs-toggle="modal">
                                                            <i class="ti ti-edit me-2"></i> Edit
                                                        </button>

                                                        <!-- Divider -->
                                                        <div class="dropdown-divider"></div>

                                                        <!-- Back to Dashboard -->
                                                        <form id="backdashboard-{{ $dpc->id }}" 
                                                            action="{{ route('spesiment.backdashboard', $dpc->id) }}" 
                                                            method="POST" 
                                                            style="display: none;">
                                                            @csrf
                                                        </form>
                                                        <button class="dropdown-item"
                                                                onclick="confirmBackdashboard({{ $dpc->id }})">
                                                            <i class="ti ti-arrow-back-up me-2"></i> Back to Dashboard
                                                        </button>

                                                        <!-- Back to Locket -->
                                                        <form id="spesimentBack-{{ $dpc->id }}" 
                                                            action="{{ route('spesiment.back', $dpc->id) }}" 
                                                            method="POST" 
                                                            style="display: none;">
                                                            @csrf
                                                        </form>
                                                        <button class="dropdown-item"
                                                                onclick="confirmBack({{ $dpc->id }})">
                                                            <i class="ti ti-arrow-back-up me-2"></i> Back to Locket
                                                        </button>

                                                        <!-- Divider -->
                                                        <div class="dropdown-divider"></div>

                                                        <!-- Delete -->
                                                        <form id="delete-form-{{ $dpc->id }}" 
                                                            action="{{ route('spesiment.destroy', $dpc->no_lab) }}" 
                                                            method="POST" 
                                                            style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <button class="dropdown-item text-danger"
                                                                onclick="confirmDelete({{ $dpc->id }})">
                                                            <i class="ti ti-trash me-2"></i> Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        {{-- @foreach ($dataPasien as $dp)
                                        <tr>
                                            @if ($dp->status == "Check in spesiment")
                                            <th scope="row"></th>
                                            @else
                                            <th scope="row"><input type="checkbox" name="pilihan[]" class="pilih" onclick="hitung()" value="{{ $dp->no_lab }}"></th>
                                            @endif
                                            <td>
                                                @foreach ($dataHistory as $dh)
                                                @if ($dh->no_lab == $dp->no_lab)
                                                {{ date('d-m-Y', strtotime($dh->waktu_proses)) }}/{{ date('H:i', strtotime($dh->waktu_proses)) }}
                                                @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $dp->no_rm }}</td>
                                            <td>{{ $dp->no_lab }}</td>
                                            <td>{{ $dp->nama }}</td>
                                            <td>{{ $dp->asal_ruangan }}</td>
                                            <td>
                                                @if ($dp->cito == 1)
                                                <i class='bx bxs-bell-ring mt-2 ml-1 text-danger' style="font-size: 23px;"></i>
                                                @else
                                                <i class='bx bxs-bell-ring mt-2 ml-1 text-secondary' style="font-size: 23px;"></i>
                                                @endif
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($dp->lahir)->age }} tahun
                                            </td>
                                            <td>
                                                @if($dp->status == "Check in")
                                                <span class="badge bg-danger text-white">Belum Diproses</span>
                                                @elseif($dp->status == "Spesiment")
                                                <span class="badge bg-warning text-white">Disetujui</span>
                                                @endif
                                            </td>
                                            <td class="d-flex action-tombol">
                                                @if ($dp->status == "Check in")
                                                <a href="#" tooltip="Preview"><i class="fa-solid fa-file mx-1 mt-2" id="open-pasien" data-lab="{{ $dp->no_lab }}" onclick="previewPasien('{{ $dp->no_lab }}')"></i></a>
                                                @else
                                                <a href="#"></a>
                                                @endif
                                                <a href="#" tooltip="Tambah Parameter"><i class="fas fa-plus mx-1 mt-2" onclick="mengambilData()"></i></a>
                                                <a href="#" tooltip="Cetak Barcode"><i class="fas fa-barcode mx-1 mt-2"></i></a>
                                                <a href="#" tooltip="Resample"><i class="fas fa-syringe mx-1 mt-2"></i></a>
                                                <a href="#" tooltip="Hapus Data" flow="left"><i class="fas fa-trash mx-1 mt-2"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                            {{-- Pemeriksaan Pasien --}}
                    <div class="modal fade" id="modalSpesimen" tabindex="-1" role="dialog"aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content ">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="sampleHistoryModalLabel">Detail Inspection Patient</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style=" max-height: 600px; overflow-y: auto" id="pembayaran-pasien">
                                    @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    <form action="{{ route('spesiment.store') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div>
                                            <h5>Inspection Details</h5>
                                            <hr>
                                            <div id="detailSpesiment">
                                                {{-- <input type="hidden" name="no_lab" value="{{ $dataPasien->no_lab }}"> --}}
                                            </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="modal-footer">
                                            <button class="btn btn-success btn-verify" id="verification" type="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>

                             </div>
                        </div>
                    </div>
                    {{-- edit data --}}
                    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog"aria-labelledby="exampleModal" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content ">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="sampleHistoryModalLabel">Edit Data Patient</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="overflow-y: scroll" id="pembayaran-pasien" style="max-height: 700px;">
                                    <form id="editFormPasien" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-12">
                                                <label for=""><strong>NIK</strong></label>
                                                <input type="text" name="nik" id="Nik" class="form-control">
                                            </div>
                                            <div class="col-12">
                                                <label for=""><strong>Name</strong></label>
                                                <input type="text" name="nama" id="Nama" class="form-control">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label for=""><strong>Address</strong></label>
                                                <input type="text" name="alamat" id="Alamat" class="form-control">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-success btn-verify" id="verification" type="submit">Submit</button>
                                        </form>
                                        </div>
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
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
</div>

@push('script')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Untuk setiap tombol, kita memeriksa dan menambahkan event listener
        document.querySelectorAll('.btn-preview, .btn-edit, .btn-warning, .btn-primary, .btn-barcode').forEach(function(button) {
            const buttonId = button.getAttribute('data-id');  // Ambil ID unik dari tombol
            const clickedStatus = localStorage.getItem(`clicked-${buttonId}`);  // Cek apakah sudah diklik di localStorage

            // Jika tombol sudah diklik sebelumnya, setel warnanya
            if (clickedStatus === 'clicked') {
                if (button.classList.contains('btn-preview')) {
                    button.classList.remove('btn-outline-secondary');
                    button.classList.add('btn-info');  // Ganti warna tombol Preview setelah diklik
                } else if (button.classList.contains('btn-edit')) {
                    button.classList.remove('btn-outline-secondary');
                    button.classList.add('btn-success');  // Ganti warna tombol Edit setelah diklik
                } else if (button.classList.contains('btn-warning')) {
                    button.classList.remove('btn-outline-secondary');
                    button.classList.add('btn-warning');  // Ganti warna tombol Kembalikan ke Dashboard
                } else if (button.classList.contains('btn-primary')) {
                    button.classList.remove('btn-outline-secondary');
                    button.classList.add('btn-primary');  // Ganti warna tombol Kembalikan ke Loket
                } else if (button.classList.contains('btn-barcode')) {
                    button.classList.remove('btn-outline-secondary');
                    button.classList.add('btn-warning');  // Ganti warna tombol Cetak Barcode setelah diklik
                }
            }

            // Tambahkan event listener untuk menangani klik
            button.addEventListener('click', function() {
                // Ganti warna tombol setelah diklik
                if (this.classList.contains('btn-preview')) {
                    this.classList.remove('btn-outline-secondary');
                    this.classList.add('btn-info');  // Tombol Preview
                } else if (this.classList.contains('btn-edit')) {
                    this.classList.remove('btn-outline-secondary');
                    this.classList.add('btn-success');  // Tombol Edit
                } else if (this.classList.contains('btn-warning')) {
                    this.classList.remove('btn-outline-secondary');
                    this.classList.add('btn-warning');  // Tombol Kembalikan ke Dashboard
                } else if (this.classList.contains('btn-primary')) {
                    this.classList.remove('btn-outline-secondary');
                    this.classList.add('btn-primary');  // Tombol Kembalikan ke Loket
                } else if (this.classList.contains('btn-barcode')) {
                    this.classList.remove('btn-outline-secondary');
                    this.classList.add('btn-warning');  // Tombol Cetak Barcode
                }

                // Simpan status klik tombol ke localStorage
                localStorage.setItem(`clicked-${buttonId}`, 'clicked');
            });
        });
    });
</script>


<script>
    function confirmBack(id) {
      Swal.fire({
          title: 'Apakah Anda yakin?',
          text: "Data akan dikirim kembali ke loket?",
          icon: 'warning',
          input: 'textarea',
          inputPlaceholder: 'Tambahkan catatan di sini...',
          showCancelButton: true,
          confirmButtonText: 'Ya, Kirim!',
          cancelButtonText: 'Batal',
          inputValidator: (value) => {
            if (!value) {
                  return 'Catatan wajib diisi!'; // Pesan kesalahan jika input kosong
              }
              return null;
          }
      }).then((result) => {
          if (result.isConfirmed) {
              if (result.value) {
                  let noteInput = document.createElement('input');
                  noteInput.type = 'hidden';
                  noteInput.name = 'note';
                  noteInput.value = result.value;
                  document.getElementById(`spesimentBack-${id}`).appendChild(noteInput);
              }
              document.getElementById(`spesimentBack-${id}`).submit();
          }
      });
  }
  </script>
<script>
    function confirmBackdashboard(id) {
      Swal.fire({
          title: 'Apakah Anda yakin?',
          text: "Data akan dikirim kembali ke dashboard?",
          icon: 'warning',
          input: 'textarea',
          inputPlaceholder: 'Tambahkan catatan di sini...',
          showCancelButton: true,
          confirmButtonText: 'Ya, Kirim!',
          cancelButtonText: 'Batal',
          inputValidator: (value) => {
            if (!value) {
                  return 'Catatan wajib diisi!'; // Pesan kesalahan jika input kosong
              }
              return null;
          }
      }).then((result) => {
          if (result.isConfirmed) {
              if (result.value) {
                  let noteInput = document.createElement('input');
                  noteInput.type = 'hidden';
                  noteInput.name = 'note';
                  noteInput.value = result.value;
                  document.getElementById(`backdashboard-${id}`).appendChild(noteInput);
              }
              document.getElementById(`backdashboard-${id}`).submit();
          }
      });
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

<script>
  $(function () {
    let detailSpesiment = document.getElementById('detailSpesiment');

    $('.btn-preview').on('click', function () {
        const id = this.getAttribute('data-id');

        fetch(`/api/get-data-pasien/${id}`).then(response => {
            if (!response.ok) throw new Error("HTTP error " + response.status);
            return response.json();
        }).then(res => {
            if (res.status === 'success') {
                let scollection = res.data.spesimentcollection;
                let spesimen = res.data.spesiment;
                let data_pemeriksaan_pasien = res.data.dpp;

                let detailContent = '';
                detailContent += `<h5 class="title mt-3">Inspection Details</h5><hr><div class="row">`;

                // render pemeriksaan pasien
                data_pemeriksaan_pasien.forEach(e => {
                    detailContent += `
                        <input type="hidden" name="no_lab" value="${e.no_lab}">
                        <div class="col-12 col-md-6" id="${e.id_departement}">
                            <h6>${e.data_departement.nama_department}</h6>
                            <ol>
                    `;
                    e.pasiens.forEach(p => {
                        detailContent += `<li>${p.data_pemeriksaan.nama_pemeriksaan}</li>`;
                    });
                    detailContent += `</ol><hr></div>`;
                });

                detailContent += `</div>`;

                // daftar tabung Collection
                const collectionTabs = ['K3-EDTA', 'CLOTH-ACTIVATOR', 'CLOTH-ACT'];

                // ------------ Spesiment Collection ------------
                let collectionSpecimens = spesimen.filter(e => e.spesiment === "Spesiment Collection");
                if (collectionSpecimens.length > 0) {
                    detailContent += `<h5 class="title mt-3">Spesiment Collection</h5><hr>`;
                    detailContent += `<div class="accordion" id="accordionCollection">`;
                    collectionSpecimens.forEach(e => {
                        detailContent += generateAccordionHTML(e, scollection, "collection");
                    });
                    detailContent += `</div>`;
                }

                // ------------ Spesiment Handlings ------------
                let handlingSpecimens = spesimen.filter(e => e.spesiment === "Spesiment Handlings");
                if (handlingSpecimens.length > 0) {
                    detailContent += `<h5 class="title mt-3">Spesiment Handlings</h5><hr>`;
                    detailContent += `<div class="accordion" id="accordionHandling">`;
                    handlingSpecimens.forEach(e => {
                        detailContent += generateAccordionHTML(e, scollection, "handling");
                    });
                    detailContent += `</div>`;
                }

                detailSpesiment.innerHTML = detailContent;
            }
        });
    });
});

// fungsi generate accordion
function generateAccordionHTML(e, scollection, type) {
    let details = '';
    let hasCollectionData = false;
    let noteText = '';
    let kapasitas, serumh, clotact;

    const collectionItem = scollection.find(item =>
        item.no_lab === e.laravel_through_key &&
        item.tabung === e.tabung &&
        item.kode === e.kode
    );

    if (collectionItem) {
        hasCollectionData = true;
        noteText = collectionItem.note || '';
        kapasitas = collectionItem.kapasitas;
        serumh = collectionItem.serumh;
        clotact = collectionItem.clotact;
    }

    const uniqId = `${e.tabung}-${e.kode}`.replace(/\s+/g, '');

    if (e.details && e.details.length > 0) {
        details = `<div class="detail-container col-12 col-md-6">`;
        e.details.forEach(detail => {
            const imageUrl = `/gambar/${detail.gambar}`;
            let isChecked = '';
            let isDisabled = '';

            if (hasCollectionData) {
                if (e.tabung === 'K3-EDTA') {
                    isChecked = kapasitas == detail.id ? 'checked' : '';
                    isDisabled = 'disabled';
                } else if (e.tabung === 'CLOTH-ACTIVATOR') {
                    isChecked = serumh == detail.id ? 'checked' : '';
                    isDisabled = 'disabled';
                } else if (e.tabung === 'CLOTH-ACT') {
                    isChecked = clotact == detail.id ? 'checked' : '';
                    isDisabled = 'disabled';
                }
            } else {
                if (detail.nama_parameter.toLowerCase().includes('normal')) {
                    isChecked = 'checked';
                }
                isDisabled = '';
            }

            // Handling → serum[kode]
            // Collection → hanya tampil readonly
            const radioName = (type === "handling") ? `serum[${e.kode}]` : `${e.tabung}_${e.kode}`;

            details += `
            <div class="detail-item">
                <div class="detail-text">${detail.nama_parameter}</div>
                <div class="detail-image-container">
                    <img src="${imageUrl}" alt="${detail.nama_parameter}" width="35" class="detail-image"/>
                </div>
                <div class="detail-radio-container">
                    <input type="radio" name="${radioName}" value="${detail.id}" ${isChecked} ${isDisabled}/>
                </div>
            </div>`;
        });
        details += `</div>`;
    }

    // note + kode
    let noteHTML = '';
    if (type === "handling") {
        noteHTML = `
            <input type="hidden" name="kode[]" value="${e.kode}">
            <p class="mb-0"><strong>Catatan</strong></p>
            <textarea class="form-control" name="note[${e.kode}]" rows="3">${noteText}</textarea>
        `;
    } else {
        noteHTML = `
            <p class="mb-0"><strong>Catatan</strong></p>
            <textarea class="form-control" rows="3" disabled>${noteText || '-'}</textarea>
        `;
    }

    return `
    <div class="accordion-item">
        <h2 class="accordion-header" id="heading${uniqId}">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${uniqId}">
                Tabung ${e.tabung} (${e.kode})
            </button>
        </h2>
        <div id="collapse${uniqId}" class="accordion-collapse collapse" aria-labelledby="heading${uniqId}">
            <div class="accordion-body">
                <div class="container">${details}</div>
                ${noteHTML}
            </div>
        </div>
    </div>`;
}
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
                url:"{{ route('spesiment.checkin') }}",
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

@endpush



<script src="{{ asset('js/check-all.js') }}"></script>
<script src="{{ asset('js/time.js') }}"></script>
@endsection

@section('modal')

@endsection