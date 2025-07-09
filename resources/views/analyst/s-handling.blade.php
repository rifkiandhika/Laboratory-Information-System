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
                                                @foreach ($dataHistory as $dh)
                                                @if ($dh->no_lab == $dpc->no_lab)
                                                {{ date('d-m-Y', strtotime($dh->waktu_proses)) }}/{{ date('H:i', strtotime($dh->waktu_proses)) }}
                                                @endif
                                                @endforeach
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
                                                    <i class="ti ti-eye"></i>
                                                </button>
                                                
                                                <a title="Cetak Barcode" style="cursor: pointer" href="{{ route('print.barcode', $dpc->no_lab) }}" class="btn btn-outline-secondary btn-barcode" target="_blank">
                                                    <i class="ti ti-barcode"></i>
                                                </a>
                                                
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

<script>
    $(function() {
        let detailSpesiment = document.getElementById('detailSpesiment');
        
        $('.btn-preview').on('click', function() {
            const id = this.getAttribute('data-id');

            fetch(`/api/get-data-pasien/${id}`).then(response => {
                if (!response.ok) {
                    throw new Error("HTTP error" + response.status);
                }
                return response.json();
            }).then(res => {
                if (res.status === 'success') {
                    data_pasien = res.data;
                    data_pemeriksaan_pasien = res.data.dpp;
                    const spesimen = res.data.spesiment; // Load spesimen data
                    const scollection = res.data.spesimentcollection;
                    const shandling = res.data.spesimenthandling;
                    let status = data_pasien.status;

                    if (status == 'Spesiment') {
                        $('#verification').attr('style', `display:none`);
                    } else {
                        $('#verification').attr('style', `display:inherit`);
                    }

                    let detailContent = '<div class="row">';
                    let Tabung = {};

                    data_pemeriksaan_pasien.forEach((e, i) => {
                        detailContent += `
                            <input type="hidden" name="no_lab" value="${e.no_lab}">
                            <div class="col-12 col-md-6" id="${e.id_departement}">
                                <h6>${e.data_departement.nama_department}</h6>
                                <ol>`;
                        e.pasiens.forEach(e => {
                            detailContent += `<li>${e.data_pemeriksaan.nama_pemeriksaan}</li>`;
                            if(!Tabung[e.spesiment]) {
                                Tabung[e.spesiment] = [];
                            }
                            Tabung[e.spesiment] += `<li>${e.data_pemeriksaan.nama_pemeriksaan}</li>`;  
                        });
                        detailContent += `</ol><hr></div>`;
                    });
                    detailContent += '</div>';

                    Object.keys(Tabung).forEach(spesiment => {
                        res.data.spesiment.forEach((e, i) => {
                            let details = '';
                            let detailsData = [];
                            let serum;
                            let processTime = '';
                            let noteText = ''; // Variable untuk menyimpan note

                            // Check if collection data exists for the current specimen
                            let hasCollectionData = false;
                            
                            if (e.tabung === 'K3-EDTA') {
                                const collectionItem = scollection.find(item => item.no_lab === e.laravel_through_key);
                                if (collectionItem) {
                                    hasCollectionData = true;
                                    detailsData = collectionItem.details.filter(detail => 
                                        e.details.some(spesimenDetail => spesimenDetail.id === detail.id)
                                    );
                                    kapasitas = collectionItem.kapasitas;
                                    noteText = collectionItem.note; // Mengambil note untuk EDTA
                                }
                            } else if (e.tabung === 'EDTA') {
                                const collectionItem = scollection.find(item => 
                                    item.no_lab === e.laravel_through_key && item.tabung === 'EDTA'
                                );
                                if (collectionItem) {
                                    hasCollectionData = true;
                                    detailsData = collectionItem.details.filter(detail => 
                                        e.details.some(spesimenDetail => spesimenDetail.id === detail.id)
                                    );
                                    serumh = collectionItem.serumh;
                                    noteText = collectionItem.note; // Mengambil note untuk K3
                                }
                            } else if (e.tabung === 'CLOT-ACT') {
                                const handlingItem = shandling.find(item => item.no_lab === e.laravel_through_key);
                                if (handlingItem) {
                                    hasCollectionData = true;
                                    detailsData = handlingItem.details.filter(detail => 
                                        e.details.some(spesimenDetail => spesimenDetail.id === detail.id)
                                    );
                                    serum = handlingItem.serum;
                                    noteText = handlingItem.note; // Mengambil note untuk CLOT-ACT
                                }
                            }

                            if (e.details && e.details.length > 0) {
                                details = `<div class="detail-container col-12 col-md-6">`;
                                e.details.forEach(detail => {
                                    const imageUrl = `/gambar/${detail.gambar}`;
                                    let isChecked = '';
                                    let isDisabled = '';  // Default to enabled

                                    if (hasCollectionData) {
                                        // Jika ada data di database
                                        if (e.tabung === 'K3-EDTA') {
                                            isChecked = kapasitas == detail.id ? 'checked' : '';
                                            isDisabled = kapasitas == detail.id ? '' : 'disabled';  // Disable yang tidak terpilih
                                        } else if (e.tabung === 'EDTA') {
                                            isChecked = serumh == detail.id ? 'checked' : '';
                                            isDisabled = serumh == detail.id ? '' : 'disabled';  // Disable yang tidak terpilih
                                        } else if (e.tabung === 'CLOT-ACT') {
                                            isChecked = serum == detail.id ? 'checked' : '';
                                            isDisabled = serum == detail.id ? '' : 'disabled';  // Disable yang tidak terpilih
                                        }
                                    } else {
                                        // Jika tidak ada data, set normal sebagai default dan semua radio enabled
                                        if (detail.nama_parameter.toLowerCase().includes('normal')) {
                                            isChecked = 'checked';
                                        }
                                        isDisabled = '';  // Semua radio button enabled
                                    }

                                    details += `
                                    <div class="detail-item">
                                        <div class="detail-text">${detail.nama_parameter}</div>
                                        <div class="detail-image-container">
                                            <img src="${imageUrl}" alt="${detail.nama_parameter}" width="35" class="detail-image"/>    
                                        </div>
                                        <div class="detail-radio-container">
                                        ${e.tabung === 'K3-EDTA' ? `<input type="radio" name="kapasitas[]" value="${detail.id}" class="detail.radio" ${isChecked} ${isDisabled}/>` : ''}
                                        ${e.tabung === 'EDTA' ? `<input type="radio" name="serumh[]" value="${detail.id}" class="detail.radio" ${isChecked} ${isDisabled}/>` : ''}    
                                        ${e.tabung === 'CLOT-ACT' ? `<input type="radio" name="serum[]" value="${detail.id}" class="detail.radio" ${isChecked} ${isDisabled}/>` : ''}    
                                        </div>
                                    </div>`;
                                });
                                details += `</div>`;
                            }

                            let title = '';
                            let subtext = '';

                            // Filter and only add details for CLOT-ACT
                            if (e.tabung === 'CLOT-ACT') {
                                title = '<h5 class="title mt-3">Spesiment Handlings</h5> <hr>';
                                subtext = '<div class="subtext">Serum</div>';
                            }

                            let note = '';
                            if (e.tabung === 'CLOT-ACT') {
                                note = '<p class="mb-0"><strong>Note</strong></p>';
                            }
                            
                            detailContent += `${title}
                            <div class="accordion accordion-custom-button mt-4" id="accordion${e.tabung}">                          
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading${e.tabung}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${e.tabung}" aria-expanded="true" aria-controls="collapse${e.tabung}">
                                            Tabung ${e.tabung}
                                        </button>
                                    </h2>
                                    <div id="collapse${e.tabung}" class="accordion-collapse collapse" aria-labelledby="heading${e.tabung}" data-bs-parent="#accordion${e.tabung}">
                                        <div class="accordion-body">
                                            ${subtext}
                                            <div class="container">
                                                ${details}
                                            </div>
                                            ${note}
                                            <textarea class="form-control" name="note[]" row="3" placeholder="${noteText || 'null'}" ${hasCollectionData ? 'disabled' : ''}></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                        });
                    });

                    detailSpesiment.innerHTML = detailContent;
                }
            });
        });
    })
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