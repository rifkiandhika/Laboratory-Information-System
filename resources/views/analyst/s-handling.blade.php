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
</style>

<div class="content" id="scroll-content">
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
                        
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="myTable">
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
                                            <td class="col-4">
                                                <button title="Preview" class="btn btn-outline-secondary btn-preview" data-id="{{ $dpc->id }}" data-bs-target="#modalSpesimen" data-bs-toggle="modal">
                                                    <i class="ti ti-test-pipe-2"></i>
                                                </button>
                                                
                                                <button class="btn btn-secondary barcodeBtn btn-barcode"
                                                    onclick="showBarcodeModal('{{ $dpc->id }}', '{{ $dpc->no_lab }}')"
                                                    title="Tampilkan Barcode">
                                                    <i class="ti ti-barcode"></i>
                                                </button> 
                                                
                                                <button title="Edit" class="btn btn-outline-secondary btn-edit" data-id="{{ $dpc->id }}" data-bs-target="#modalEdit" data-bs-toggle="modal">
                                                    <i class="ti ti-edit"></i>
                                                </button>
                                                
                                                <form id="backdashboard-{{ $dpc->id }}" action="{{ route('spesiment.backdashboard', $dpc->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                                <button title="Kembalikan Ke Dashboard" class="btn btn-outline-secondary" onclick="confirmBackdashboard({{ $dpc->id }})">
                                                    <i class="ti ti-arrow-back-up"></i>
                                                </button>
                                                
                                                <form id="spesimentBack-{{ $dpc->id }}" action="{{ route('spesiment.back', $dpc->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                                <button title="Kembalikan Ke Loket" class="btn btn-outline-secondary" onclick="confirmBack({{ $dpc->id }})">
                                                    <i class="ti ti-arrow-back-up"></i>
                                                </button>
                                                
                                                {{-- <form action="" method="post">
                                                </form> --}}

                                                <form id="delete-form-{{ $dpc->id }}"
                                                    action="{{ route('spesiment.destroy', $dpc->no_lab) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                
                                                <button title="Hapus" class="btn btn-danger"
                                                    onclick="confirmDelete({{ $dpc->id }})"><i
                                                    class="ti ti-trash"></i>
                                                </button>

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
                                    <button type="button" class="btn btn-success" onclick="printBarcode()">
                                        <i class="ti ti-printer me-1"></i>Print Barcode
                                    </button>
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
                  return 'Note wajib diisi!'; // Pesan kesalahan jika input kosong
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
                  return 'Note wajib diisi!'; // Pesan kesalahan jika input kosong
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
        const detected = [];

        if (!Array.isArray(departments)) return [];

        departments.forEach(dept => {
            const pemeriksaan = dept?.pasiens?.[0]?.data_pemeriksaan;
            const name = (dept?.data_departement?.nama_department || '').toLowerCase();

            // Tambahkan logika pengecekan agar hanya departemen dengan barcode aktif yang terdeteksi
            if (pemeriksaan && pemeriksaan.barcode === 'active') {
                if (name.includes('hematologi')) detected.push('hematologi');
                if (name.includes('kimia')) detected.push('kimia');
            }
        });

        return detected;
    }

    function getDepartmentConfig(key) {
        const config = {
            hematologi: {
                code: 'H-',
                name: 'Hematologi',
                icon: 'ti-droplet',
                class: 'bg-success'
            },
            kimia: {
                code: 'K-',
                name: 'Kimia Klinik',
                icon: 'ti-flask',
                class: 'bg-primary'
            }
        };
        return config[key] || {
            code: 'X-',
            name: key,
            icon: 'ti-medical-cross',
            class: 'bg-secondary'
        };
    }

    async function showBarcodeModal(id, noLab = '', departments = null) {
        try {
            if (!id) throw new Error("ID pasien tidak boleh kosong");
            document.getElementById('currentNoLab').textContent = noLab;
            currentBarcodeData = noLab;

            const barcodeRow = document.getElementById('barcodeRow');
            const downloadButtons = document.getElementById('downloadButtons');
            barcodeRow.innerHTML = '<div class="col-12 text-center"><div class="spinner-border"></div><p>Memuat data departemen...</p></div>';
            downloadButtons.innerHTML = '';
            barcodeModal.show();

            if (!departments) {
                departments = await fetchPatientDepartments(id);
            }

            availableDepartments = detectDepartments(departments);
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

        if (availableDepartments.length === 0) {
            barcodeRow.innerHTML = `<div class="col-12 text-center"><div class="alert alert-warning">Departemen tidak ditemukan.</div></div>`;
            downloadButtons.innerHTML = '';
            return;
        }

        // Tombol download tetap seperti yang kamu inginkan
        downloadButtons.innerHTML = `
            <button class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                <i class="ti ti-download me-1"></i>Download
            </button>
            <ul class="dropdown-menu">
                ${availableDepartments.map(d => {
                    const c = getDepartmentConfig(d);
                    return `<li><a class="dropdown-item" href="#" onclick="downloadBarcode('${d}')"><i class="${c.icon} me-1"></i>${c.name}</a></li>`;
                }).join('')}
            </ul>
        `;

        const colSize = availableDepartments.length === 1 ? '12' : '6';
        barcodeRow.innerHTML = '';

        availableDepartments.forEach(dept => {
            const config = getDepartmentConfig(dept);
            const code = config.code + currentBarcodeData;
            const elementId = `barcode${dept}`;

            // Render hanya untuk departemen yang aktif
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

        // Render barcode hanya untuk departemen yang aktif
        setTimeout(() => {
            availableDepartments.forEach(dept => {
                const config = getDepartmentConfig(dept);
                const code = config.code + currentBarcodeData;
                const elementId = `barcode${dept}`;
                const target = document.getElementById(elementId);

                if (!target) {
                    console.warn(`Element #${elementId} tidak ditemukan, barcode tidak dirender.`);
                    return;
                }

                JsBarcode(target, code, {
                    format: "CODE128",
                    width: 2,
                    height: 80,
                    displayValue: false,
                    fontSize: 14,
                    margin: 10
                });
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
        canvas.height = 200;

        const img = new Image();
        const svgBlob = new Blob([new XMLSerializer().serializeToString(svg)], { type: 'image/svg+xml' });
        const url = URL.createObjectURL(svgBlob);

        img.onload = () => {
            ctx.fillStyle = '#fff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(img, 50, 30, 300, 120);

            ctx.fillStyle = '#000';
            ctx.font = 'bold 16px Arial';
            ctx.textAlign = 'center';
            ctx.fillText(config.name, canvas.width / 2, 25);
            ctx.font = 'bold 14px Arial';
            ctx.fillText(code, canvas.width / 2, 170);
            ctx.font = '10px Arial';
            ctx.fillText(new Date().toLocaleDateString('id-ID'), canvas.width / 2, 190);

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
                let data_pasien = res.data;
                let scollection = res.data.spesimentcollection;
                let spesimen = res.data.spesiment; // spesimen array
                let data_pemeriksaan_pasien = res.data.dpp;

                let detailContent = '';
                detailContent += `<h5 class="title mt-3">Inspection Details</h5><hr><div class="row">`;

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

                // Tentukan tabung yang masuk ke Spesiment Collection dan Handlings
                const collectionTabs = ['K3-EDTA', 'CLOTH-ACTIVATOR', 'CLOTH-ACT'];
                const handlingTabs = ['CLOT-ACT']; // misalnya tabung lain untuk handling

                // Render Spesiment Collection dulu: paksa urutan CLOTH-ACT di atas
                let hasCollectionHeader = false;
                collectionTabs.forEach(tabungName => {
                    spesimen
                        .filter(e => e.tabung === tabungName)
                        .forEach(e => {
                            if (!hasCollectionHeader) {
                                detailContent += `<h5 class="title mt-3">Spesiment Collection</h5><hr>`;
                                hasCollectionHeader = true;
                            }
                            detailContent += generateAccordionHTML(e, scollection);
                        });
                });

                // Render sisanya (Handlings) jika ada
                let hasHandlingHeader = false;
                spesimen
                    .filter(e => !collectionTabs.includes(e.tabung))
                    .forEach(e => {
                        if (!hasHandlingHeader) {
                            detailContent += `<h5 class="title mt-3">Spesiment Handlings</h5><hr>`;
                            hasHandlingHeader = true;
                        }
                        detailContent += generateAccordionHTML(e, scollection);
                    });

                detailSpesiment.innerHTML = detailContent;
            }
        });
    });
});

// fungsi yang menghasilkan HTML accordion untuk setiap tabung
function generateAccordionHTML(e, scollection) {
    let details = '';
    let hasCollectionData = false;
    let noteText = '';
    let kapasitas, serumh, clotact;

    const collectionItem = scollection.find(item => item.no_lab === e.laravel_through_key && item.tabung === e.tabung);
    if (collectionItem) {
        hasCollectionData = true;
        noteText = collectionItem.note || '';
        kapasitas = collectionItem.kapasitas;
        serumh = collectionItem.serumh;
        clotact = collectionItem.clotact;
    }

    if (e.details && e.details.length > 0) {
        details = `<div class="detail-container col-12 col-md-6">`;
        e.details.forEach(detail => {
            const imageUrl = `/gambar/${detail.gambar}`;
            let isChecked = '';
            let isDisabled = '';

            if (hasCollectionData) {
                if (e.tabung === 'K3-EDTA') {
                    isChecked = kapasitas == detail.id ? 'checked' : '';
                    isDisabled = kapasitas == detail.id ? '' : 'disabled';
                } else if (e.tabung === 'CLOTH-ACTIVATOR') {
                    isChecked = serumh == detail.id ? 'checked' : '';
                    isDisabled = serumh == detail.id ? '' : 'disabled';
                } else if (e.tabung === 'CLOTH-ACT') {
                    isChecked = clotact == detail.id ? 'checked' : '';
                    isDisabled = clotact == detail.id ? '' : 'disabled';
                }
            } else {
                if (detail.nama_parameter.toLowerCase().includes('normal')) {
                    isChecked = 'checked';
                }
                isDisabled = '';
            }

            details += `
            <div class="detail-item">
                <div class="detail-text">${detail.nama_parameter}</div>
                <div class="detail-image-container">
                    <img src="${imageUrl}" alt="${detail.nama_parameter}" width="35" class="detail-image"/>
                </div>
                <div class="detail-radio-container">
                    ${e.tabung === 'K3-EDTA' ? `<input type="radio" name="kapasitas[]" value="${detail.id}" class="detail.radio" ${isChecked} ${isDisabled}/>` : ''}
                    ${e.tabung === 'CLOTH-ACTIVATOR' ? `<input type="radio" name="serumh[]" value="${detail.id}" class="detail.radio" ${isChecked} ${isDisabled}/>` : ''}
                    ${e.tabung === 'CLOTH-ACT' ? `<input type="radio" name="clotact[]" value="${detail.id}" class="detail.radio" ${isChecked} ${isDisabled}/>` : ''}
                    ${e.tabung === 'CLOT-ACT' ? `<input type="radio" name="serum[]" value="${detail.id}" class="detail.radio" ${isChecked} ${isDisabled}/>` : ''}
                    ${e.tabung === 'CLOT-' ? `<input type="radio" name="serumc[]" value="${detail.id}" class="detail.radio" ${isChecked} ${isDisabled}/>` : ''}
                </div>
            </div>`;
        });
        details += `</div>`;
    }

    let note = (e.tabung === 'CLOTH-ACT' || e.tabung === 'CLOT-ACT') ?
        '<p class="mb-0"><strong>Note</strong></p>' : '';

    return `
    <div class="accordion accordion-custom-button mt-4" id="accordion${e.tabung}">
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading${e.tabung}">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${e.tabung}">
                    Tabung ${e.tabung}
                </button>
            </h2>
            <div id="collapse${e.tabung}" class="accordion-collapse collapse" aria-labelledby="heading${e.tabung}">
                <div class="accordion-body">
                    <div class="container">${details}</div>
                    ${note}
                    <textarea class="form-control" name="note[]" row="3" placeholder="${noteText || 'null'}" ${hasCollectionData ? 'disabled' : ''}></textarea>
                </div>
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



{{-- <script>
    //event ketika element a dengan id submit-collection di klik
    document.getElementById("submit-collection").addEventListener("click", function(event){
        event.preventDefault();
        createUser();
    });
    // JavaScript
    function createUser() {
        //mengambil data di element input text dengan name tabung sesuai dengan jumlah input text tabung
        const elements = document.querySelectorAll('[name*="tabung"]');
        const count = elements.length;

        var form = document.getElementById("form-collection");

        for(let i = 0; i < count; i++){
            var namaTabung = document.getElementsByName("tabung")[i].value;

            const no_lab = document.getElementsByName("no_lab")[0].value;
            const tabung = document.getElementsByName("tabung")[i].value;
            const kapasitas = document.querySelector('input[name="kapasitas-'+ document.getElementsByName("tabung")[i].value +'"]:checked').value;
            const note = document.getElementsByName("note-" + document.getElementsByName("tabung")[i].value)[0].value;

            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Buat objek data
            const data = {
                no_lab,
                tabung,
                kapasitas,
                note,
            };

            //kirim data menggunakan ajax
            $.ajax({
                url: '{{ route('collection.post') }}',
type: 'POST',
data,
header: {
'X-CSRF-TOKEN': csrfToken,
},
success: function(data) {
// Tampilkan data baru
alert(data.no_lab + ' telah dibuat.');
},
error: function(error) {
// Tampilkan pesan error
alert(error.responseJSON.message);
},
});
}
}

</script> --}}

<script src="{{ asset('js/check-all.js') }}"></script>
<script src="{{ asset('js/time.js') }}"></script>
@endsection

@section('modal')

@endsection