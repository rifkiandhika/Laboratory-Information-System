@extends('layouts.admin')
@section('title')
Dashboard|Spesiment
@endsection
@section('content')
<style>
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
</style>
<section>
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class=" mt-3">
                <h1 class="h3 mb-0 ml-2 text-gray-600">Dashboard Laboratorium</h1>
            </div>
            @php
                $no1=1;
                $no2=1;
                $no3=1;
            @endphp

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
                                    <div class="h3 mt-3 font-weight-bold text-gray-600">
                                        {{ $pasienharian }}
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
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Pasien Telah Dilayani
                                    </div>
                                    <div class="h3 mt-3 font-weight-bold text-gray-600">@foreach ($dataPasien as $dp)
                                        @php
                                            $no3++
                                        @endphp
                                    @endforeach
                                @foreach ($dataPasienCito as $dpc)
                                        @php
                                            $no3++
                                        @endphp
                                @endforeach{{ $no3 }}</div>
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
                <div class="col-xl-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            {{-- <div class="d-flex justify-content-between">
                                <h6 class="m-0 font-weight-bold" style="color: #96B6C5;">Antrian Pasien</h6>
                                <a href="#" id="konfirmasiallselecteddata" type="button" class="btn btn-outline-primary mb-2 mt-2 " >Check In</a>
                            </div> --}}
                        </div>
                        <div class="card-body card-datatable">
                            <div class="table-responsive" style="width: 100%;">
                                <table class="table table-striped w-100 d-block d-md-table" id="myTable">
                                    @php
                                        $no=1;
                                    @endphp
                                    <thead >

                                        <th>No</th>
                                            <th scope="col">Cito</th>
                                            <th scope="col">No RM</th>
                                            <th scope="col">No Lab</th>
                                            <th scope="col">Nama</th>
                                            {{-- <th scope="col" style="max-width: min-content">Barcode</th> --}}
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>

                                    </thead>
                                    <tbody style="font-size: 14px">
                                        @foreach ($dataPasien as $data1)
                                            <tr id="voucher{{ $data1->id }}">
                                                {{-- @if ($data1->status == 'Disetujui oleh analis lab') --}}

                                                {{-- <td><input style="font-size: 20px; cursor: pointer;" type="checkbox" name="ids" id="checkbox" class="form-check-input checkbox_ids" value="{{ $data1->id }}"></td> --}}
                                                {{-- @else --}}
                                                <td>{{ $no++ }}</td>
                                                {{-- @endif --}}

                                            <td>
                                                <i class='ti ti-bell-filled {{ $data1->cito == '1' ? 'text-danger' : 'text-secondary' }}' style="font-size: 23px;"></i>

                                            </td>
                                                <td scope="row">{{ $data1->no_rm }}</td>
                                                <td scope="row">{{ $data1->no_lab }}</td>
                                                <td scope="row">{{ $data1->nama }}</td>
                                                {{-- <td>{!! DNS1D::getBarcodeHTML('$ '. $data1->no_lab, 'C39') !!}</td> --}}
                                                <td>
                                                    @if($data1->status == 'Telah Dikirim ke Lab')
                                                        <span class="badge bg-warning text-white">Sent to lab</span>
                                                    @elseif($data1->status == 'Disetujui oleh analis lab')
                                                        <span class="badge bg-success text-white">Approved of analyst</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button title="Check Collection" class="btn btn-outline-secondary btn-preview" data-id={{ $data1->id }} data-bs-target="#modalSpesimen"
                                                        data-bs-toggle="modal" ><i class="ti ti-temperature"></i></button>

                                                        <form id="spesimentBack-{{ $data1->id }}" action="{{ route('analyst.back', $data1->id) }}" method="POST" style="display: none;">
                                                            @csrf
                                                        </form>

                                                        <button title="Kembalikan Ke Loket" class="btn btn-outline-secondary" onclick="confirmBack({{ $data1->id }})">
                                                            <i class="ti ti-arrow-back-up"></i>
                                                        </button>

                                                
                                                        <button class="btn btn-secondary barcode-btn"
                                                                onclick="showBarcodeModal('{{ $data1->no_lab }}')"
                                                                title="Tampilkan Barcode">
                                                            <i class="ti ti-barcode"></i>
                                                        </button>

                                                        <form id="delete-form-{{ $data1->id }}"
                                                            action="{{ route('analyst.destroy', $data1->no_lab) }}" method="POST"
                                                            style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        
                                                        <button class="btn btn-danger"
                                                            onclick="confirmDelete({{ $data1->id }})"><i
                                                            class="ti ti-trash"></i>
                                                        </button>
    
                                                  </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Preview Pasien --}}
        <div class="modal fade" id="modalSpesimen" tabindex="-1" role="dialog"aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sampleHistoryModalLabel">Detail Inspection Patient</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style=" max-height: 600px; overflow-y: auto" id="pembayaran-pasien">
                        <form action="{{ route('analyst.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div>
                                <h5>Inspection Details</h5>
                                <hr>
                                <div id="patientDoctorInfo"></div>
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
                    
                    <!-- Canvas untuk Barcode -->
                    <div class="barcode-container mb-3">
                        <svg id="barcode"></svg>
                    </div>
                    
                    <!-- Info Barcode -->
                    <div class="alert alert-info">
                        <small>
                            <i class="ti ti-info-circle me-1"></i>
                            Barcode ini menggunakan format Code 128 dan dapat di-scan dengan scanner barcode standar.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="printBarcode()">
                        <i class="ti ti-printer me-1"></i>Print Barcode
                    </button>
                    <button type="button" class="btn btn-primary" onclick="downloadBarcode()">
                        <i class="ti ti-download me-1"></i>Download PNG
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>


</section>

@endsection
@push('script')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Ambil semua tombol dengan class 'barcode-btn'
        const buttons = document.querySelectorAll(".barcode-btn");
    
        buttons.forEach(button => {
            const barcode = button.getAttribute("data-barcode");
    
            // Cek di localStorage apakah tombol ini sudah diklik sebelumnya
            if (localStorage.getItem(`barcode_clicked_${barcode}`) === "true") {
                button.classList.remove("btn-secondary");
                button.classList.add("btn-warning");
            }
    
            // Tambahkan event click untuk mengubah warna tombol dan menyimpan status di localStorage
            button.addEventListener("click", function () {
                button.classList.remove("btn-secondary");
                button.classList.add("btn-warning");
                
                // Simpan status di localStorage
                localStorage.setItem(`barcode_clicked_${barcode}`, "true");
            });
        });
    });
</script>

{{-- Script Barcode --}}
    <script>
        // Variabel global untuk menyimpan modal instance
        let barcodeModal;
        let currentBarcodeData = '';

        // Inisialisasi modal saat document ready
        document.addEventListener('DOMContentLoaded', function() {
            barcodeModal = new bootstrap.Modal(document.getElementById('barcodeModal'));
        });

        // Fungsi untuk menampilkan barcode dalam modal
        function showBarcodeModal(noLab) {
            // Set no lab di modal
            document.getElementById('currentNoLab').textContent = noLab;
            currentBarcodeData = noLab;
            
            // Generate barcode menggunakan JsBarcode
            try {
                JsBarcode("#barcode", noLab, {
                    format: "CODE128",
                    width: 2,
                    height: 100,
                    displayValue: true,
                    fontSize: 16,
                    textMargin: 10,
                    fontOptions: "bold"
                });
                
                // Tampilkan modal
                barcodeModal.show();
                
            } catch (error) {
                alert('Error generating barcode: ' + error.message);
            }
        }

        // Fungsi untuk generate barcode manual
        function generateManualBarcode() {
            const noLab = document.getElementById('manualNoLab').value.trim();
            
            if (!noLab) {
                alert('Silakan masukkan No Lab terlebih dahulu!');
                return;
            }

            showBarcodeModal(noLab);
        }

        // Fungsi untuk print barcode
        function printBarcode() {
            // Buat window baru untuk print
            const printWindow = window.open('', '_blank');
            const barcodeElement = document.getElementById('barcode');
            
            if (barcodeElement) {
                const svgContent = barcodeElement.outerHTML;
                
                printWindow.document.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Print Barcode - ${currentBarcodeData}</title>
                        <style>
                            body { 
                                font-family: Arial, sans-serif; 
                                text-align: center; 
                                padding: 20px; 
                            }
                            .header { margin-bottom: 20px; }
                            .barcode-container { margin: 20px 0; }
                            @media print {
                                body { margin: 0; }
                                .no-print { display: none; }
                            }
                        </style>
                    </head>
                    <body>
                        <div class="header">
                            <h3>Barcode Label</h3>
                            <p><strong>No Lab: ${currentBarcodeData}</strong></p>
                        </div>
                        <div class="barcode-container">
                            ${svgContent}
                        </div>
                        <div class="no-print">
                            <button onclick="window.print()">Print</button>
                            <button onclick="window.close()">Close</button>
                        </div>
                    </body>
                    </html>
                `);
                
                printWindow.document.close();
                
                // Auto print setelah loading
                printWindow.onload = function() {
                    printWindow.print();
                };
            }
        }

        // Fungsi untuk download barcode sebagai PNG
        function downloadBarcode() {
            const svgElement = document.getElementById('barcode');
            
            if (svgElement) {
                // Convert SVG to Canvas
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                const img = new Image();
                
                // Set canvas size
                canvas.width = svgElement.clientWidth || 400;
                canvas.height = svgElement.clientHeight || 150;
                
                // Convert SVG to data URL
                const svgData = new XMLSerializer().serializeToString(svgElement);
                const svgBlob = new Blob([svgData], {type: 'image/svg+xml;charset=utf-8'});
                const url = URL.createObjectURL(svgBlob);
                
                img.onload = function() {
                    // Draw image to canvas
                    ctx.fillStyle = 'white';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);
                    ctx.drawImage(img, 0, 0);
                    
                    // Download canvas as PNG
                    canvas.toBlob(function(blob) {
                        const link = document.createElement('a');
                        link.download = `barcode_${currentBarcodeData}.png`;
                        link.href = URL.createObjectURL(blob);
                        link.click();
                        
                        // Cleanup
                        URL.revokeObjectURL(url);
                        URL.revokeObjectURL(link.href);
                    });
                };
                
                img.src = url;
            }
        }

        // Event listener untuk input manual (Enter key)
        document.getElementById('manualNoLab').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                generateManualBarcode();
            }
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
    $('#verification').click(function(e) {
   e.preventDefault();
   
   // Dapatkan semua department yang ada
   const departments = new Set();
   data_pemeriksaan_pasien.forEach(e => {
       departments.add(e.data_departement.nama_department);
   });

   // Set status berdasarkan jumlah department
   let newStatus;
   if (departments.size === 1 && departments.has('Hematologi')) {
       newStatus = 'Check In Spesiment';
   } else if (departments.size > 1) {
       newStatus = 'Acc Collection'; 
   }

   // Tambahkan status ke form sebelum submit
   $('form').append(`<input type="hidden" name="status" value="${newStatus}">`);
   $('form').submit();
});
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
                    let status = data_pasien.status;
                    
                    // Menyembunyikan atau menampilkan bagian verifikasi
                    if (status == 'Spesiment') {
                        $('#verification').attr('style', `display:none`);
                    } else {
                        $('#verification').attr('style', `display:inherit`);
                    }

                    console.log(data_pasien);
                    console.log(data_pemeriksaan_pasien);

                    // HTML untuk informasi pasien dan dokter yang diambil dari res.data
                    let patientDoctorHTML = `
                    <div class="modal-body" style="max-height: 700px;">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                Pasien
                                <hr>
                                <table class="table table-borderless">
                                    <tr>
                                        <th scope="row">No.Lab</th>
                                        <td>
                                            <div class="flex-container">
                                                :  <span class="ms-2" id="Nolab">${res.data.no_lab}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Cito</th>
                                        <td>
                                            <div class="flex-container">
                                                <span class="label">:</span>
                                                <i class="ti ti-bell-filled" id="Cito">${res.data.cito ? 'Cito' : ''}</i>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>NIK</th>
                                        <td>
                                            <div class="flex-container">
                                              :  <span id="Nik">${res.data.nik}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nama</th>
                                        <td>
                                            <div class="flex-container">
                                               : <span id="Nama">${res.data.nama}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <td>
                                            <div class="flex-container">
                                              : <span id="Gender">${res.data.jenis_kelamin}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>
                                            <div class="flex-container">
                                               : <span id="Alamat">${res.data.alamat}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>No. Telepon</th>
                                        <td>
                                            <div class="flex-container">
                                               : <span id="Telp">${res.data.no_telp}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Pelayanan</th>
                                        <td>
                                            <div class="flex-container">
                                               : <span id="JenisPelayanan">${res.data.jenis_pelayanan}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Ruangan</th>
                                        <td>
                                            <div class="flex-container">
                                               : <span id="Ruangan">${res.data.asal_ruangan}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                    </div>`;

                    // Masukkan HTML informasi pasien dan dokter ke dalam modal
                    $('#patientDoctorInfo').html(patientDoctorHTML);

                    // Mulai menghasilkan detail Spesiment
                    let detailContent = '<div class="row">';
                    let Tabung = {};

                    data_pemeriksaan_pasien.forEach((e, i) => {
                        detailContent += `          <input type="hidden" name="no_lab" value="${e.no_lab}">
                                                    <div class="col-12 col-md-6" id="${e.id_departement}">
                                                    <h6>${e.data_departement.nama_department}</h6>
                                                    <ol>`;
                        e.pasiens.forEach(e => {
                            detailContent += `<li>${e.data_pemeriksaan.nama_pemeriksaan}</li>`;
                            if (!Tabung[e.spesiment]) {
                                Tabung[e.spesiment] = [];
                            }
                            Tabung[e.spesiment] += `<li>${e.data_pemeriksaan.nama_pemeriksaan}</li>`;
                        });
                        detailContent += `</ol><hr></div>`;
                    });
                    detailContent += '</div>';

                    Object.keys(Tabung).forEach(spesiment => {
                    res.data.spesiment.forEach((e, i) => {
                        // Skip if the tabung is CLOT-ACT
                        if (e.tabung === 'CLOT-ACT') {
                            return; // Skip this iteration if tabung is CLOT-ACT
                        }

                        let details = '';
                        if (e.details && e.details.length > 0) {
                            details = `<div class="detail-container col-12 col-md-6">`;
                            e.details.forEach(detail => {
                                const imageUrl = `/gambar/${detail.gambar}`;
                                const isChecked = (e.tabung === 'K3-EDTA' && detail.nama_parameter === 'Normal') ||
                                                (e.tabung === 'K3' && detail.nama_parameter === 'Normal') ? 'checked' : '';

                                details +=  
                                `<div class="detail-item">
                                    <div class="detail-text">${detail.nama_parameter}</div>
                                    <div class="detail-image-container">
                                        <img src="${imageUrl}" alt="${detail.nama_parameter}" width="35" class="detail-image"/>    
                                    </div>
                                    <div class="detail-radio-container">
                                        ${e.tabung === 'K3-EDTA' ? `<input type="radio" name="kapasitas[]" value="${detail.id}" class="detail.radio" ${isChecked}/>` : ''}
                                        ${e.tabung === 'K3' ? `<input type="radio" name="serumh[]" value="${detail.id}" class="detail.radio" ${isChecked}/>` : ''}  
                                    </div>
                                </div>`;
                            });
                            details += `</div>`;
                        }

                        let title = '';
                        let subtext = '';
                        if (e.tabung === 'K3-EDTA') {
                            title = '<h5 class="title">Pengambilan Spesimen</h5> <hr>';
                        }

                        let note = '';
                        if (e.tabung === 'K3-EDTA' || e.tabung === 'K3') {
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
                                            ${e.tabung === 'K3-EDTA' ? `<textarea class="form-control" name="note[]" row="3" placeholder="Tulis catatan disini"></textarea>` : ''}
                                            ${e.tabung === 'K3' ? `<textarea class="form-control" name="note[]" row="3" placeholder="Tulis catatan disini"></textarea>` : ''}
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                    });
                });


                    // Masukkan detail spesimen ke dalam modal
                    detailSpesiment.innerHTML = detailContent;
                    console.log(detailContent);
                }
            });
        });
    });
</script>


{{-- <script>
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
                    let status = data_pasien.status;
                     if(status == 'Spesiment'){
                                 $('#verification').attr('style',`display:none`);
                             }
                             else{
                                 $('#verification').attr('style',`display:inherit`);
                             }

                    console.log(data_pasien);
                    console.log(data_pemeriksaan_pasien);
                    // if (!data_pasien.dokter) {
                    // console.error('Data dokter null');
                    // return;
                    // }

                    let detailContent = '<div class="row">';
                    let Tabung = {};

                    data_pemeriksaan_pasien.forEach((e, i) => {
                        // console.log(e.data);
                        detailContent += `          <input type="hidden" name="no_lab" value="${e.no_lab}">
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
                        
                                if (e.details && e.details.length > 0){
                                    details = `<div class="detail-container col-12 col-md-6">`;
                                    e.details.forEach(detail => {
                                        const imageUrl = `/gambar/${detail.gambar}`;
                                        const isChecked = (e.tabung === 'EDTA' && detail.nama_parameter === 'Normal' ) ||
                                                            (e.tabung === 'K3' && detail.nama_parameter === 'Normal' ) ? 'checked' : '';

                                        // const approvedDetail = res.data.approvedDetails.find(d => d.id === detail.id);
                                        // const approvedChecked = approvedDetail ? 'checked' : '';
                                        // const approvedNote = approvedDetail ? approvedDetail.note : '';

                                        details +=  
                                        `<div class="detail-item">
                                            <div class="detail-text">${detail.nama_parameter}</div>
                                            <div class="detail-image-container">
                                                <img src="${imageUrl}" alt="${detail.nama_parameter}" width="35" class="detail-image"/>    
                                            </div>
                                            <div class="detail-radio-container">
                                                ${e.tabung === 'EDTA' ? `<input type="radio" name="kapasitas[]" value="${detail.id}" class="detail.radio" ${isChecked}/>` : ''}
                                                ${e.tabung === 'K3' ? `<input type="radio" name="serumh[]" value="${detail.id}" class="detail.radio" ${isChecked}/>` : ''  }  
                                            </div>
                                        </div>`;
                                    });
                                    details += `</div>`
                                }

                                let title = '';
                                let subtext = '';

                                if (e.tabung === 'EDTA') {
                                    title = '<h5 class="title">Spesiment Collection</h5> <hr>';
                                }else

                                if (e.tabung === 'K3') {
                                }else

                                if (e.tabung === 'CLOT-ACT') {
                                    title = '<h5 class="title mt-3">Spesiment Handlings</h5> <hr>';
                                    subtext = '<div class="subtext">Serum</div>';
                                }

                                let note = '';
                                if (e.tabung === 'EDTA' || e.tabung === 'CLOT-ACT' || e.tabung === 'K3') {
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
                                                    ${e.tabung === 'EDTA' ? `<textarea class="form-control" name="note[]" row="3" placeholder="Write a note here"></textarea>` : ''}
                                                    ${e.tabung === 'K3' ? `<textarea class="form-control" name="note[]" row="3" placeholder="Write a note here"></textarea>` : ''}
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        </div>`;
                             });
                     
                    });
                    
                    detailSpesiment.innerHTML = detailContent;
                    console.log(detailContent);
                }
            });
        });
    })
</script> --}}

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
                    url:"{{ route('analyst.checkinall') }}",
                    method:"POST",
                    data:{
                        ids:all_ids,
                        _token:'{{csrf_token()}}'
                    },
                    success:function(response){
                        $.each(all_ids,function(key,val){
                            $('#voucher'+val).remove();
                        })
                        location. reload()

                    }
                })
            })
            });

        </script>

        <script>
            $(function() {
                // ngambil data dari id = detailPemeriksaan
                let detailDashboard = document.getElementById('detailDashboard');
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
                                id,
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
                                status,
                            } = res.data;

                            dokter = res.data.dokter;
                            data_pemeriksaan_pasien = res.data.dpp;
                            if(status == 'Disetujui oleh analis lab'){
                                $('#verification').attr('style',`display:none`);
                                $('#note').attr('style',`display:none`);
                                $('#notelabel').attr('style',`display:none`);

                            }
                            else{
                                $('#verification').attr('style',`display:inherit`);
                            }

                            $('#form').attr('action',`approve/${id}`);
                            $('#no_lab').attr('value',no_lab);
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
                            $('#Dokter').text(dokter != null ? dokter.nama_dokter : '-');
                            $('#Ruangandok').text(asal_ruangan);
                            $('#Telpdok').text(dokter != null ? dokter.no_telp : '-');
                            $('#Email').text(dokter != null ? dokter.email : '-');
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
                            detailDashboard.innerHTML = detailContent;
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
<script src="{{ asset('js/time.js') }}"></script>
@endpush
