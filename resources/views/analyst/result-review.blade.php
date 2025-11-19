@extends('layouts.admin')
@section('title', 'Result Review')
@section('content')
<link rel="stylesheet" href="{{ asset('css/timeline.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    @media print {
        body {
    background-color: #ccc; /* Warna abu-abu untuk background */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}
}
    iframe {
        overflow: auto;
        width: 100%; /* Atur sesuai keinginan */
        height: 90vh; /* Atur sesuai keinginan */
        margin: 20px auto; /* Agar iframe berada di tengah */
        display: block;
        border: 10px solid #fff; /* Simulasi margin kertas */
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); /* Bayangan untuk efek lebih realistis */
    }
    .step-wizard-list {
    background: #fff;
    box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
    color: lightslategray;
    list-style-type: none;
    border-radius: 10px;
    display: flex;
    padding: 20px 10px;
    position: relative;
    z-index: 10;
    max-width: 100%; /* Membatasi lebar maksimal sesuai dengan ukuran modal */
    overflow: auto; /* Menambahkan scroll horizontal jika konten terlalu besar */
    margin-bottom: 10px; /* Memberikan ruang untuk scrollbar */
}

.step-wizard-item {
    padding: 0 10px; /* Mengurangi padding untuk item agar lebih kompak */
    flex-basis: 0;
    flex-grow: 1;
    max-width: 100%;
    display: flex;
    flex-direction: column;
    text-align: center;
    min-width: 120px; /* Kurangi ukuran minimum agar lebih fleksibel */
    position: relative;
}

@media (max-width: 576px) {
    .step-wizard-item {
        min-width: 100px; /* Mengatur ulang ukuran untuk layar kecil */
    }
}
 .step-wizard-item + .step-wizard-item:after{
    content: "";
    position: absolute;
    left: 0;
    top: 19px;
    background: #13ee88;
    width: 100%;
    height: 2px;
    transform: translateX(-50%);
    z-index: -10;
 }
 .progress-count{
    height: 40px;
    width: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-weight: 600;
    margin: 0 auto;
    position: relative;
    z-index: 10;
    color: transparent;
 }
 .progress-count::after{
    content: "";
    height: 35px;
    width: 35px;
    background: #13ee88;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    border-radius: 50%;
    z-index: -10;
 }
 .progress-count::before{
    content: "";
    height: 10px;
    width: 20px;
    border-left: 2px solid #fff;
    border-bottom: 2px solid #fff;
    position: absolute;
    left: 50%;
    top: 45%;
    transform: translate(-50%, -60%) rotate(-45deg);
    transform-origin: center center;
 }
 .progress-label{
    font-size: 14px;
    font-weight: 600;
    margin-top: 10px;
 }
#loadingDots {
  display: none; /* default hidden */
  display: flex; /* aktif hanya saat JS set ke flex */
  justify-content: center;
  align-items: center;
  flex-direction: column;
}
.dots {
  display: flex;
  gap: 6px;
}
.dots span {
  width: 10px;
  height: 10px;
  background: #0d6efd;
  border-radius: 50%;
  display: inline-block;
  animation: bounce 1.4s infinite ease-in-out both;
}
.dots span:nth-child(1) { animation-delay: -0.32s; }
.dots span:nth-child(2) { animation-delay: -0.16s; }
@keyframes bounce {
  0%, 80%, 100% { transform: scale(0); }
  40% { transform: scale(1); }
}
/* CSS untuk mengatur z-index SweetAlert agar di atas modal */
.swal-high-z-index {
    z-index: 10000 !important;
}

.swal2-container.swal-high-z-index {
    z-index: 10000 !important;
}

/* Jika menggunakan SweetAlert2 */
.swal2-container {
    z-index: 10000 !important;
}
  </style>
  
<div class="content" id="scroll-content">
    <div class="container-fluid">
      <!-- Page Heading -->
      <div class="d-sm-flex  mt-3">
        <h1 class="h3 mb-0 text-gray-600">Result Review</h1>
      </div>
      

      <!-- Content Row -->
      <div class="row mt-2">
        <div class="col-xl-12 col-lg-12">
          <div class="card shadow mb-4">
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold" style="color: #96B6C5;">Result Pasien</h6>
                  
                @hasanyrole('Superadmin')
                  <a href="{{ route('result.report') }}" class="btn btn-primary">Report</a>
                @endhasanyrole
              </div>
              
              <!-- Card Body -->
              <div class="card-body">
                <div class="d-flex justify-content-between mb-3 pr-3">
                </div>
                <div class="tab">
                <table class="table table-striped table-responsive" style="font-size: 12px;" id="myTable">
                  <thead>
                    <tr>
                      <th scope="col" class="text-center">No</th>
                      <th scope="col">Tanggal Order</th>
                      <th scope="col" class="text-center">No RM</th>
                      <th scope="col">No LAB</th>
                      <th scope="col">Nama</th>
                      <th scope="col">Asal Poli</th>
                      <th scope="col">Cito</th>
                      <th scope="col">Umur</th>
                      <th scope="col">Alamat</th>
                      <th scope="col">Analyst</th>
                      <th scope="col">Status</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                        @foreach ( $dataPasien as $x => $dpc )
                            @php
                                $lahir = \Carbon\Carbon::parse($dpc->lahir);
                                $sekarang = \Carbon\Carbon::now();
                                $umur = $lahir->diff($sekarang);
                            @endphp
                            <tr>
                                <th class="text-center" scope="row">{{ $x + 1 }}</th>
                                <td>
                                    @if ($dpc->no_lab == $dpc->no_lab)
                                    {{ date('d-m-Y', strtotime($dpc->tanggal_masuk)) }}/{{ date('H:i', strtotime($dpc->tanggal_masuk)) }}
                                    @endif
                                </td>
                                <td class="text-center">{{ $dpc->no_rm }}</td>
                                <td>{{ $dpc->no_lab }}</td>
                                <td>{{ $dpc->nama }}</td>
                                <td>{{ $dpc->asal_ruangan }}</td>
                                <td>
                                    <i class='ti ti-bell-filled {{ $dpc->cito == '1' ? 'text-danger' : 'text-secondary' }}' style="font-size: 23px;"></i>
                                </td>
                                <td>
                                     {{ $umur->y }} Tahun {{ $umur->m }} Bulan {{ $umur->d }} Hari
                                </td>
                                <td>{{ $dpc->alamat }}</td>
                                <td>{{ $dpc->analyst }}</td>
                                <td>
                                    @if($dpc->status == "Result Review")
                                    <span class="badge bg-danger text-white">Waiting...</span>
                                    @else
                                    @endif
                                    @if($dpc->status == "diselesaikan")
                                    <span class="badge bg-success text-white">Patient Done</span>
                                    @else
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="text-secondary" id="aksiDropdown{{ $dpc->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical fs-5"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="aksiDropdown{{ $dpc->id }}">
                                            <li>
                                                <a class="dropdown-item editBtn" 
                                                data-id="{{ $dpc->no_lab }}" 
                                                href="#">
                                                    <i class="ti ti-pencil me-2"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item EditClock" 
                                                data-id="{{ $dpc->id }}" 
                                                href="#">
                                                    <i class="ti ti-clock-edit me-2"></i> Edit Time
                                                </a>
                                            </li>
                                            <li>
                                                <button type="button" 
                                                        class="dropdown-item preview" 
                                                        data-id="{{ $dpc->id }}" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#sampleHistoryModal">
                                                    <i class="ti ti-clock me-2"></i> Sample History
                                                </button>
                                            </li>
                                            <li>
                                                <button type="button" 
                                                        class="dropdown-item btn-show-result"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#resultReviewModal"
                                                        data-id="{{ $dpc->id }}">
                                                    <i class="ti ti-report-analytics me-2"></i> Check Hasil
                                                </button>
                                            </li>
                                            <li>
                                                <form id="kirimresult-{{ $dpc->id }}" 
                                                    action="result/done/{{ $dpc->id }}" 
                                                    method="POST" 
                                                    style="display: none;">
                                                    @csrf
                                                </form>
                                                <button type="button" 
                                                        class="dropdown-item" 
                                                        onclick="confirmResult({{ $dpc->id }})" 
                                                        {{ $dpc->status == 'diselesaikan' ? 'disabled' : '' }}>
                                                    <i class="ti ti-checklist me-2"></i> Selesaikan
                                                </button>
                                            </li>
                                            <li>
                                                <button type="button" 
                                                        class="dropdown-item" 
                                                        onclick="openModal('{{ $dpc->no_lab }}')" 
                                                        {{ $dpc->status != 'diselesaikan' ? 'disabled' : '' }}>
                                                    <i class="ti ti-printer me-2"></i> Print Result
                                                </button>
                                            </li>

                                           @hasanyrole('Superadmin|Doctor')
                                                @if(Str::startsWith($dpc->no_lab, 'MCU'))
                                                    <li>
                                                        <button type="button" 
                                                                class="dropdown-item btn-kesimpulan-saran"
                                                                data-id="{{ $dpc->no_lab }}"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#kesimpulanSaranModal">
                                                            <i class="ti ti-notes me-2"></i> Kesimpulan & Saran
                                                        </button>
                                                    </li>
                                                @endif
                                            @endhasanyrole

                                           @hasanyrole('Superadmin')
                                                <li>
                                                    <form action="{{ route('hasil.kirim', $dpc->no_lab) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="ti ti-notes me-2"></i> Kirim Hasil
                                                        </button>
                                                    </form>
                                                </li>
                                            @endhasanyrole

                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                  </tbody>
                  </table>
                </div>
                {{-- Sample History --}}
                <div class="modal fade" id="noteModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Enter Patient's Note (Optional)</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <textarea id="patientNote" class="form-control" rows="4" placeholder="Enter your note here..."></textarea>
                                <input type="hidden" id="currentNoLab">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" onclick="submitNote()">Print</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- historysample --}}
                <div class="modal fade" id="sampleHistoryModal" tabindex="-1" aria-labelledby="sampleHistoryModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="sampleHistoryModalLabel">Sample History</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="previewDataPasien"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- View Result --}}
                <div class="modal fade" id="resultReviewModal" tabindex="-1" aria-labelledby="resultReviewModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="resultReviewModalLabel">Result Review</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="modalResultContent">
                            <div class="text-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p>Loading data...</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                             <button type="button" class="btn btn-success update-btn">
                                <i class="ti ti-device-floppy"></i> Update
                            </button>
                        </div>
                        </div>
                    </div>
                </div>
                {{-- View Print --}}
                <!-- Modal Preview & Print -->
                <div class="modal fade" id="printModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Preview & Print</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        
                        <!-- Hasil print dimasukkan di sini -->
                        <div class="modal-body" id="printContent"></div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-primary" onclick="printDiv()">Print</button>
                        </div>
                        </div>
                    </div>
                </div>
                {{-- Modal Kesimpulan dan saran --}}
                <div class="modal fade" id="kesimpulanSaranModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <form id="kesimpulanSaranForm" method="POST" action="{{ route('hasil_pemeriksaans.simpanKesimpulanSaran') }}">
                            @csrf
                            <input type="hidden" name="no_lab" id="modalNoLab">

                            <div class="modal-header">
                            <h5 class="modal-title">Kesimpulan & Saran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                            <div class="mb-3">
                                <label for="kesimpulan" class="form-label">Kesimpulan</label>
                                <textarea name="kesimpulan" id="kesimpulan" rows="3" class="form-control"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="saran" class="form-label">Saran</label>
                                <textarea name="saran" id="saran" rows="3" class="form-control"></textarea>
                            </div>
                            </div>

                            <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
                {{-- Modal Edit Time --}}
                <div class="modal fade" id="modalEditTime" tabindex="-1" aria-labelledby="modalEditTimeLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditTimeLabel">
                            <i class="ti ti-clock-edit me-2"></i> Edit Waktu Order
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formEditTime">
                                <input type="hidden" id="edit_id" name="id">
                                <input type="hidden" id="edit_no_lab" name="no_lab">

                                <div class="mb-3">
                                    <label for="edit_tanggal_masuk" class="form-label fw-bold">Tanggal Transaksi</label>
                                    <input type="datetime-local" class="form-control" id="edit-asd" name="tanggal_masuk">
                                </div>

                                <div class="mb-3">
                                    <label for="edit_created_at" class="form-label fw-bold">Tanggal Diterima</label>
                                    <input type="datetime-local" class="form-control" id="edit-asp" name="created_at">
                                </div>

                                <div class="mb-3">
                                    <label for="edit_updated_at" class="form-label fw-bold">Tanggal Selesai</label>
                                    <input type="datetime-local" class="form-control" id="edit-asu" name="updated_at">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" id="btnSaveEditTime" class="btn btn-success">Simpan</button>
                        </div>
                        </div>
                    </div>
                </div>
              </div>
          </div>
      </div>
      </div>
    </div>

    <!-- Dot Loading -->
    <div id="loadingDots" 
    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
            background:rgba(255,255,255,0.7); z-index:2000; 
            justify-content:center; align-items:center; flex-direction:column;">
        <div class="dots">
            <span></span><span></span><span></span>
        </div>
        <p style="margin-top:10px; font-weight:500;">Memuat data...</p>
    </div>


  </div>
@endsection
@push('script')
<script>
      document.querySelectorAll('.editBtn, .preview, [id^="selesaikanBtn-"], [id^="printBtn-"], [id^="sampleHistoryBtn-"]').forEach(function(button) {
    // Ambil ID penuh dari button
    const buttonId = button.id || button.getAttribute('data-id');
    
    // Set warna default ke secondary
    if (button.classList.contains('editBtn') || 
        button.classList.contains('preview') || 
        button.id.startsWith('selesaikanBtn-') || 
        button.id.startsWith('printBtn-') ||
        button.id.startsWith('sampleHistoryBtn-')) {
        button.classList.add('btn-outline-secondary');
    }

    // Cek status klik untuk ID spesifik
    const clickedStatus = localStorage.getItem(`clicked-${buttonId}`);

    // Kembalikan warna untuk button yang sudah di-klik
    if (clickedStatus === 'clicked') {
        if (button.classList.contains('editBtn')) {
            button.classList.replace('btn-outline-secondary', 'btn-outline-primary');
        } else if (button.classList.contains('preview')) {
            button.classList.replace('btn-outline-secondary', 'btn-outline-warning'); 
        } else if (button.id.startsWith('selesaikanBtn-')) {
            button.classList.replace('btn-outline-secondary', 'btn-outline-success');
        } else if (button.id.startsWith('printBtn-')) {
            button.classList.replace('btn-outline-secondary', 'btn-outline-info');
        } else if (button.id.startsWith('sampleHistoryBtn-')) {
            button.classList.replace('btn-outline-secondary', 'btn-outline-warning');
        }
    }

    button.addEventListener('click', function() {
        if (this.classList.contains('editBtn')) {
            this.classList.replace('btn-outline-secondary', 'btn-outline-primary');
        } else if (this.classList.contains('preview')) {
            this.classList.replace('btn-outline-secondary', 'btn-outline-warning');
        } else if (this.id.startsWith('selesaikanBtn-')) {
            this.classList.replace('btn-outline-secondary', 'btn-outline-success');
        } else if (this.id.startsWith('printBtn-')) {
            this.classList.replace('btn-outline-secondary', 'btn-outline-info');
        } else if (this.id.startsWith('sampleHistoryBtn-')) {
            this.classList.replace('btn-outline-secondary', 'btn-outline-warning');
        }
        // Simpan status klik dengan ID spesifik
        localStorage.setItem(`clicked-${buttonId}`, 'clicked');
    });
});
    </script>
    
<!-- Modal yang akan digunakan bersama -->
<div class="modal fade" id="noteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enter Patient's Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <textarea id="patientNote" class="form-control" rows="4" placeholder="Enter your note here..."></textarea>
                <input type="hidden" id="currentNoLab">
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="submitNote()">Print with Note</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-kesimpulan-saran').forEach(btn => {
        btn.addEventListener('click', function () {
            const noLab = this.getAttribute('data-id');
            document.getElementById('modalNoLab').value = noLab;
        });
    });
});
</script>


<script>
    let noteModal = null;

    function openModal(noLab) {
        // tampilkan loading dots
        document.getElementById('loadingDots').style.display = 'flex';

        fetch(`/analyst/print/pasien/${noLab}`)
            .then(res => res.text())
            .then(html => {
                document.getElementById('printContent').innerHTML = html;

                // sembunyikan loading dots
                document.getElementById('loadingDots').style.display = 'none';

                // buka modal
                const modal = new bootstrap.Modal(document.getElementById('printModal'));
                modal.show();
            })
            .catch(err => {
                document.getElementById('loadingDots').style.display = 'none';
                alert("Gagal mengambil data cetak: " + err);
            });
    }

    // Hapus isi printContent setiap kali modal ditutup
    document.getElementById('printModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('printContent').innerHTML = '';
    });


    function submitNote() {
        const note = document.getElementById('patientNote').value;
        const noLab = document.getElementById('currentNoLab').value;


        // Tambahkan prefix 'analyst' ke URL
        const printUrl = `{{ url('analyst/print/pasien') }}/${noLab}?note=${encodeURIComponent(note)}`;
        
        window.open(printUrl, '_blank');
        noteModal.hide();
    }

    function printDiv() {
        const printContent = document.getElementById('printContent').innerHTML;

        const printWindow = window.open('', '', 'width=900,height=650');
        printWindow.document.write(`
            <html>
            <head>
                <title>Print Preview</title>
                <link rel="stylesheet" href="{{ asset('/assets/vendor/css/rtl/core.css') }}">
                <link rel="stylesheet" href="{{ asset('/assets/vendor/css/rtl/theme-default.css') }}">
                <link rel="stylesheet" href="{{ asset('/assets/css/demo.css') }}">
            </head>
            <body>
                ${printContent}
                <script>
                    window.onload = function() {
                        window.print();
                        window.onafterprint = function() { window.close(); }
                    }
                <\/script>
            </body>
            </html>
        `);
        printWindow.document.close();
    }
</script>

{{-- Script View Result --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Event listener untuk tombol result review
    document.querySelectorAll('[data-bs-target="#resultReviewModal"]').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const noLab = this.getAttribute('data-id');
            const modalContent = document.getElementById('modalResultContent');
            
            // Show loading state
            modalContent.innerHTML = `
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p>Loading data...</p>
                </div>
            `;
            
            // Fetch data
            fetch(`/api/get-data-pasien/${noLab}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error("HTTP error " + response.status);
                    }
                    return response.json();
                })
                .then(res => {
                    if (res.status === 'success') {
                        // Debug: Log data untuk melihat struktur
                        // console.log('API Response:', res);
                        // console.log('Hasil Pemeriksaan:', res.data.hasil_pemeriksaan);
                        
                        const data_pasien = res.data;
                        const data_pemeriksaan_pasien = res.data.dpp;
                        const hasil_pemeriksaan = res.data.hasil_pemeriksaan || [];
                        const history = res.data.history;
                        
                        // Generate content untuk modal
                        const resultContent = getResultTableContent(data_pemeriksaan_pasien, data_pasien, hasil_pemeriksaan, history);
                        modalContent.innerHTML = resultContent;

                                              
                        // Initialize duplo column visibility setelah content dimuat
                        setTimeout(() => {
                            checkAndShowDuploColumns();
                        }, 200); // Increased timeout for better reliability
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    modalContent.innerHTML = `
                        <div class="alert alert-danger" role="alert">
                            <i class="ti ti-alert-circle"></i>
                            Error loading data: ${error.message}
                        </div>
                    `;
                });
        });
    });
    
    // Fungsi untuk menghitung usia
    function calculateAge(birthDate) {
        const birth = new Date(birthDate);
        const today = new Date();
        let age = today.getFullYear() - birth.getFullYear();
        const monthDiff = today.getMonth() - birth.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
            age--;
        }
        return age;
    }

    // Fungsi untuk generate content hasil pemeriksaan dalam modal
    function getResultTableContent(data_pemeriksaan_pasien, data_pasien, hasil, history) {
            const hematologiParams = [
                { nama: 'WBC', display_name: 'Leukosit', satuan: '10³/µL', normal_min: 4.0, normal_max: 10.0 },
                { nama: 'LYM#', display_name: 'LYM#', satuan: '10³/µL', normal_min: 1.0, normal_max: 4.0 },
                { nama: 'MID#', display_name: 'MID#', satuan: '10³/µL', normal_min: 0.2, normal_max: 0.8 },
                { nama: 'GRAN#', display_name: 'GRAN#', satuan: '10³/µL', normal_min: 2.0, normal_max: 7.0 },
                { nama: 'LYM%', display_name: 'Limfosit', satuan: '%', normal_min: 20, normal_max: 40 },
                { nama: 'MID%', display_name: 'Monosit', satuan: '%', normal_min: 3, normal_max: 15 },
                { nama: 'GRAN%', display_name: 'Granulosit', satuan: '%', normal_min: 50, normal_max: 70 },
                { nama: 'RBC', display_name: 'Eritrosit', satuan: '10⁶/µL', normal_min: 4.0, normal_max: 5.5 },
                { nama: 'HGB', display_name: 'Hemoglobin', satuan: 'g/dL', normal_min: 12.0, normal_max: 16.0 },
                { nama: 'HCT', display_name: 'Hematokrit', satuan: '%', normal_min: 36, normal_max: 48 },
                { nama: 'MCV', display_name: 'MCV', satuan: 'fL', normal_min: 80, normal_max: 100 },
                { nama: 'MCH', display_name: 'MCH', satuan: 'pg', normal_min: 27, normal_max: 32 },
                { nama: 'MCHC', display_name: 'MCHC', satuan: 'g/dL', normal_min: 32, normal_max: 36 },
                { nama: 'RDW-CV', display_name: 'RDW-CV', satuan: '%', normal_min: 11.5, normal_max: 14.5 },
                { nama: 'RDW-SD', display_name: 'RDW-SD', satuan: 'fL', normal_min: 39, normal_max: 46 },
                { nama: 'PLT', display_name: 'Trombosit', satuan: '10³/µL', normal_min: 150, normal_max: 450 },
                { nama: 'MPV', display_name: 'MPV', satuan: 'fL', normal_min: 7.0, normal_max: 11.0 },
                { nama: 'PDW', display_name: 'PDW', satuan: 'fL', normal_min: 10.0, normal_max: 18.0 },
                { nama: 'PCT', display_name: 'PCT', satuan: '%', normal_min: 0.15, normal_max: 0.50 },
                { nama: 'P-LCC', display_name: 'P-LCC', satuan: '10³/µL', normal_min: 30, normal_max: 90 },
                { nama: 'P-LCR', display_name: 'P-LCR', satuan: '%', normal_min: 13, normal_max: 43 }
            ];

            const WidalParams = [
                {
                    nama: 'Salmonella Typhi H',
                    display_name: 'Salmonella Typhi H',
                    satuan: '-',
                    normal_min_l: '-',
                    normal_max_l: '-',
                    normal_min_p: '-',
                    normal_max_p: '-',
                    nilai_rujukan_l: '-',
                    nilai_rujukan_p: '-',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan: 'Dropdown',
                    opsi_output: 'Negatif;1/80;1/160;1/320;1/640' 
                },
                {
                    nama: 'Salmonella Typhi O',
                    display_name: 'Salmonella Typhi O',
                    satuan: '-',
                    normal_min_l: '-',
                    normal_max_l: '-',
                    normal_min_p: '-',
                    normal_max_p: '-',
                    nilai_rujukan_l: '-',
                    nilai_rujukan_p: '-',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan: 'Dropdown',
                    opsi_output: 'Negatif;1/80;1/160;1/320;1/640' 
                },
                {
                    nama: 'Salmonella Paratyphi AO',
                    display_name: 'Salmonella Paratyphi AO',
                    satuan: '-',
                    normal_min_l: '-',
                    normal_max_l: '-',
                    normal_min_p: '-',
                    normal_max_p: '-',
                    nilai_rujukan_l: '-',
                    nilai_rujukan_p: '-',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan: 'Dropdown',
                    opsi_output: 'Negatif;1/80;1/160;1/320;1/640' 
                },
                {
                    nama: 'Salmonella Paratyphi BO',
                    display_name: 'Salmonella Paratyphi BO',
                    satuan: '-',
                    normal_min_l: '-',
                    normal_max_l: '-',
                    normal_min_p: '-',
                    normal_max_p: '-',
                    nilai_rujukan_l: '-',
                    nilai_rujukan_p: '-',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan: 'Dropdown',
                    opsi_output: 'Negatif;1/80;1/160;1/320;1/640' 
                }
            ];
            const UrineParams = [
                {
                    judul: 'Urine Lengkap',
                    nama: 'Warna Urine',
                    display_name: 'Warna',
                    satuan: '-',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: '-',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Dropdown',
                    opsi_output : 'Kuning;Kuning Pucat;Kuning Tua;Kuning kecokelatan;Orange;Merah;Coklat',
                    default: 'Kuning' 
                },
                {
                    judul: 'Urine Lengkap',
                    nama: 'Kekeruhan',
                    display_name: 'Kekeruhan',
                    satuan: '-',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: 'L.- P.-',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Dropdown',
                    opsi_output : 'Jernih;Agak Keruh;Keruh;Sangat keruh',
                    default: 'Jernih' 
                },
                {
                    judul: 'Urine Lengkap',
                    nama: 'Berat Jenis',
                    display_name: 'Berat Jenis',
                    satuan: '-',
                    normal_min: 'L.1,003 P.1,003',
                    normal_max: 'L.1,035 P.1,035',
                    nilai_rujukan: 'L.1,003-1,035 P.1,003-1,035',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Dropdown',
                    opsi_output : '<1.005;1.005;1.010;1.015;1.020;1.025;1.030',
                    default: '1.015' 
                },
                {
                    judul: 'Urine Lengkap',
                    nama: 'PH',
                    display_name: 'pH',
                    satuan: '-',
                    normal_min: 'L.4,5 P.4,5',
                    normal_max: 'L.8,0 P.8,0',
                    nilai_rujukan: 'L.4,5-8,0 P.4,5-8,0',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Dropdown',
                    opsi_output : '4.5;5.0;5.5;6.0;6.5;7.0;7.5;8.0;8.5;9.0',
                    default: '6.0' 
                },
                {
                    judul: 'Urine Lengkap',
                    nama: 'Leukosit (Strip)',
                    display_name: 'Leukosit',
                    satuan: '-',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: 'L.- P.-',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Dropdown',
                    opsi_output : 'Negatif;Positif;Positif(+);Positif(++);Positif(+++)',
                    default: 'Negatif' 
                },
                {
                    judul: 'Urine Lengkap',
                    nama: 'Nitrit',
                    display_name: 'Nitrit',
                    satuan: '-',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: 'L.- P.-',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Dropdown',
                    opsi_output : 'Negatif;Positif(+);Positif(++);Positif(+++) ',
                    default: 'Negatif' 
                },
                {
                    judul: 'Urine Lengkap',
                    nama: 'Protein',
                    display_name: 'Protein',
                    satuan: '-',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: 'L.- P.-',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Dropdown',
                    opsi_output : 'Negatif;Positif(+);Positif(++);Positif(+++) ',
                    default: 'Negatif' 
                },
                {
                    judul: 'Urine Lengkap',
                    nama: 'Glukosa',
                    display_name: 'Glukosa',
                    satuan: '-',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: 'L.- P.-',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Dropdown',
                    opsi_output : 'Negatif;Positif(+);Positif(++);Positif(+++) ',
                    default: 'Negatif' 
                },
                {
                    judul: 'Urine Lengkap',
                    nama: 'Keton',
                    display_name: 'Keton',
                    satuan: '-',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: 'L.- P.-',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Dropdown',
                    opsi_output : 'Negatif;Positif(+);Positif(++);Positif(+++) ',
                    default: 'Negatif'  
                },
                {
                    judul: 'Urine Lengkap',
                    nama: 'Urobilinogen',
                    display_name: 'Urobilinogen',
                    satuan: '-',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: 'L.- P.-',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Dropdown',
                    opsi_output : 'Negatif;Positif(+);Positif(++);Positif(+++)',
                    default: 'Negatif' 
                },
                {
                    judul: 'Urine Lengkap',
                    nama: 'Bilirubin',
                    display_name: 'Bilirubin',
                    satuan: '-',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: 'L.- P.-',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Dropdown',
                    opsi_output : 'Negatif;Positif(+);Positif(++);Positif(+++) ',
                    default: 'Negatif' 
                },
                {
                    judul: 'Urine Lengkap',
                    nama: 'Blood',
                    display_name: 'Blood',
                    satuan: '-',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: 'L.- P.-',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Dropdown',
                    opsi_output : 'Negatif;Positif(+);Positif(++);Positif(+++) ',
                    default: 'Negatif' 
                },
                {
                    judul: 'Sedimen',
                    nama: 'Eritrosit Urine',
                    display_name: '- Eritrosit',
                    satuan: '',
                    normal_min: 'L.0 P.0',
                    normal_max: 'L.2 P.2',
                    nilai_rujukan: 'L.0-2 P.0-2',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Text',
                    opsi_output : '',
                    default: 'Negatif'
                },
                {
                    judul: 'Sedimen',
                    nama: 'Leukosit Urine',
                    display_name: '- Leukosit',
                    satuan: '',
                    normal_min: 'L.0 P.0',
                    normal_max: 'L.5 P.5',
                    nilai_rujukan: 'L.0-5 P.0-5',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Text',
                    opsi_output : '',
                    default: 'Negatif'
                },
                {
                    judul: 'Sedimen',
                    nama: 'Epithel Urine',
                    display_name: '- Epithel',
                    satuan: '-',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: 'Tidak ada - Sedikit',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Text',
                    opsi_output : 'Tidak ada;Sedikit;Sedang;Banyak',
                    default: 'Negatif'
                },
                {
                    judul: 'Sedimen',
                    nama: 'Silinder',
                    display_name: '- Silinder',
                    satuan: '-',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: 'Negatif',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Dropdown',
                    opsi_output : 'Negatif;Positif;Positif(+);Positif(++);Positif(+++);Positif(++++)',
                    default: 'Negatif'
                },
                {
                    judul: 'Sedimen',
                    nama: 'Kristal',
                    display_name: '- Kristal',
                    satuan: '-',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: 'Negatif',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Dropdown',
                    opsi_output : 'Tidak ada;Asam urat;Kalsium oksalat;Fosfat amorf;Lainnya',
                    default: 'Negatif'
                },
                {
                    judul: 'Sedimen',
                    nama: 'Bakteri',
                    display_name: '- Bakteri',
                    satuan: '-',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: 'Negatif',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Dropdown',
                    opsi_output : 'Negatif;Positif;Positif(+);Positif(++);Positif(+++);Positif(++++)',
                    default: 'Negatif'
                },
                {
                    judul: 'Sedimen',
                    nama: 'Jamur',
                    display_name: '- Jamur',
                    satuan: '-',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: 'Negatif',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Dropdown',
                    opsi_output : 'Negatif;Positif;Positif(+);Positif(++);Positif(+++)',
                    default: 'Negatif'
                },
                {
                    judul: 'Sedimen',
                    nama: 'Sedimen-Lain-lain',
                    display_name: '- Lain-lain',
                    satuan: '-',
                    normal_min: '',
                    normal_max: '',
                    nilai_rujukan: '',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Text',
                    opsi_output : '',
                    default: ''
                }
            ];
            const MicrobiologiParams = [
                {
                    judul: '',
                    nama: 'Preparat Gram',
                    display_name: 'Preparat Gram',
                    satuan: '-',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: '-',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Dropdown',
                    opsi_output : 'Ditemukan Kuman;Tidak Ditemukan Kuman' 
                },
                {
                    judul: '',
                    nama: 'Batang Gram Negatif',
                    display_name: 'Batang Gram Negatif',
                    satuan: '-',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: '-',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Dropdown',
                    opsi_output : '-;Positif +;Positif ++;Positif +++;Positif ++++' 
                },
                {
                    judul: '',
                    nama: 'Batang Gram Positif',
                    display_name: 'Batang Gram Positif',
                    satuan: '-',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: '-',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Dropdown',
                    opsi_output : '-;Positif +;Positif ++;Positif +++;Positif ++++' 
                },
                {
                    judul: '',
                    nama: 'Coccus Gram Negatif',
                    display_name: 'Coccus Gram Negatif',
                    satuan: '-',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: '-',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Dropdown',
                    opsi_output : '-;Positif +;Positif ++;Positif +++;Positif ++++'
                },
                {
                    judul: '',
                    nama: 'Coccus Gram Positif',
                    display_name: 'Coccus Gram Positif',
                    satuan: '-',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: '-',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Dropdown',
                    opsi_output : '-;Positif +;Positif ++;Positif +++;Positif ++++' 
                }
            ];
            const PreparatBasahParams = [
                {
                    judul: 'Preparat Basah',
                    nama: 'Preparat Basah',
                    display_name: 'Preparat Basah',
                    satuan: '-',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: '-',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Dropdown',
                    opsi_output : 'Tidak Ditemukan Jamur;Ditemukan Jamur Berbentuk Hifa' 
                },
                {
                    judul: '',
                    nama: 'Leukosit',
                    display_name: 'Leukosit',
                    satuan: '/LP',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: '-',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Text',
                    opsi_output : '',
                },
                {
                    judul: '',
                    nama: 'Epithel',
                    display_name: 'Epithel',
                    satuan: '/LP',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: '-',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan : 'Text',
                    opsi_output : '',
                }
            ];
            const DengueParams =  [
                {
                    judul: 'Dengue_IgG/IgM',
                    nama: 'Dengue_IgG',
                    display_name: 'Dengue IgG',
                    satuan: '-',
                    normal_min: '—',
                    normal_max: '—',
                    nilai_rujukan: 'Negatif',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan: 'Dropdown',
                    opsi_output: 'Negatif;Positif(+)',
                    default: 'Negatif'
                },
                {
                    judul: 'Dengue_IgG/IgM',
                    nama: 'Dengue_IgM',
                    display_name: 'Dengue IgM',
                    satuan: '-',
                    normal_min: '—',
                    normal_max: '—',
                    nilai_rujukan: 'Negatif',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan: 'Dropdown',
                    opsi_output: 'Negatif;Positif(+)',
                    default: 'Negatif'
                },
                {
                    judul: 'Dengue_IgG/IgM',
                    nama: 'COI_IgG',
                    display_name: 'Cutoff Index IgG (COI)',
                    satuan: '',
                    normal_min: '0.00',
                    normal_max: '∞',
                    nilai_rujukan: '< 1.00',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan: 'Text',
                    opsi_output: '',
                    default: ''
                },
                {
                    judul: 'Dengue_IgG/IgM',
                    nama: 'COI_IgM',
                    display_name: 'Cutoff Index IgM (COI)',
                    satuan: '',
                    normal_min: '0.00',
                    normal_max: '∞',
                    nilai_rujukan: '< 1.00',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan: 'Text',
                    opsi_output: '',
                    default: ''
                }
            ];
            const NS1Params =  [
                {
                    judul: 'Dengue_Ns1',
                    nama: 'Dengue_Ns1',
                    display_name: 'Dengue_Ns1',
                    satuan: '-',
                    normal_min: '—',
                    normal_max: '—',
                    nilai_rujukan: 'Negatif',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan: 'Dropdown',
                    opsi_output: 'Negatif;Positif(+)',
                    default: 'Negatif'
                },
                {
                    judul: 'Dengue_Ns1',
                    nama: 'COI_Ns1',
                    display_name: 'Cutoff Index (COI)',
                    satuan: '-',
                    normal_min: '-',
                    normal_max: '-',
                    nilai_rujukan: '<1.00',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan: 'Text',
                    opsi_output: '-',
                    default: ''
                }
            ];
            const TifoidParams = [
                {
                    judul: 'Typhoid_IgG/IgM',
                    nama: 'Typhoid_IgM',
                    display_name: 'Typhoid IgM',
                    satuan: '-',
                    normal_min: '-',
                    normal_max: '-',
                    nilai_rujukan: 'Negatif',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan: 'Dropdown',
                    opsi_output: 'Negatif;Positif(+)',
                    default: 'Negatif'
                },
                {
                    judul: 'Typhoid_IgG/IgM',
                    nama: 'Typhoid_IgG',
                    display_name: 'Typhoid IgG',
                    satuan: '-',
                    normal_min: '-',
                    normal_max: '-',
                    nilai_rujukan: 'Negatif',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan: 'Dropdown',
                    opsi_output: 'Negatif;Positif(+)',
                    default: 'Negatif'
                }
            ];
            const FesesParams = [
                {
                    judul: 'Feses',
                    nama: 'Konsistensi',
                    display_name: 'Konsistensi',
                    satuan: '-',
                    normal_min: '-',
                    normal_max: '-',
                    nilai_rujukan: 'Lunak',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan: 'Dropdown',
                    opsi_output: 'Lunak;Padat;Setengah cair;Cair',
                    default: 'Lunak'
                },
                {
                    judul: 'Feses',
                    nama: 'Feses-Warna',
                    display_name: 'Warna',
                    satuan: '-',
                    normal_min: '-',
                    normal_max: '-',
                    nilai_rujukan: 'Coklat',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan: 'Dropdown',
                    opsi_output: 'Coklat;Coklat kekuningan;Coklat kehijauan;Hitam;Pucat;Merah',
                    default: 'Coklat'
                },
                {
                    judul: 'Feses',
                    nama: 'Lendir',
                    display_name: 'Lendir',
                    satuan: '-',
                    normal_min: '-',
                    normal_max: '-',
                    nilai_rujukan: 'Negatif',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan: 'Dropdown',
                    opsi_output: 'Negatif;Positif(+);Positif(++);Positif(+++) ',
                    default: 'Negatif'
                },
                {
                    judul: 'Feses',
                    nama: 'Darah',
                    display_name: 'Darah',
                    satuan: '-',
                    normal_min: '-',
                    normal_max: '-',
                    nilai_rujukan: 'Negatif',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan: 'Dropdown',
                    opsi_output: 'Negatif;Positif(+);Positif(++);Positif(+++) ',
                    default: 'Negatif'
                },
                {
                    judul: 'Feses',
                    nama: 'Telur Cacing',
                    display_name: 'Telur Cacing',
                    satuan: '-',
                    normal_min: '-',
                    normal_max: '-',
                    nilai_rujukan: 'Tidak ditemukan',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan: 'Dropdown',
                    opsi_output: 'Tidak ditemukan;Ascaris;Trichuris;Hookworm;Oxyuris;Lainnya',
                    default: 'Tidak ditemukan'
                },
                {
                    judul: 'Feses',
                    nama: 'Kista Protozoa',
                    display_name: 'Kista Protozoa',
                    satuan: '-',
                    normal_min: '-',
                    normal_max: '-',
                    nilai_rujukan: 'Tidak ditemukan',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan: 'Dropdown',
                    opsi_output: 'Tidak ditemukan;Entamoeba histolytica;Entamoeba coli;Giardia lamblia;Lainnya',
                    default: 'Tidak ditemukan'
                },
                {
                    judul: 'Feses',
                    nama: 'Trofozoit',
                    display_name: 'Trofozoit',
                    satuan: '-',
                    normal_min: '-',
                    normal_max: '-',
                    nilai_rujukan: 'Tidak ditemukan',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan: 'Dropdown',
                    opsi_output: 'Tidak ditemukan;Entamoeba histolytica;Giardia lamblia;Lainnya',
                    default: 'Tidak ditemukan'
                },
                {
                    judul: 'Feses',
                    nama: 'Feses-Leukosit',
                    display_name: 'Leukosit',
                    satuan: '-',
                    normal_min: '-',
                    normal_max: '-',
                    nilai_rujukan: '0-1/lpb',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan: 'Text',
                    opsi_output: '',
                    default: '0-1/lpb'
                },
                {
                    judul: 'Feses',
                    nama: 'Eritrosit',
                    display_name: 'Eritrosit',
                    satuan: '-',
                    normal_min: '-',
                    normal_max: '-',
                    nilai_rujukan: '0/lpb',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan: 'Text',
                    opsi_output: '',
                    default: '0/lpb'
                },
                {
                    judul: 'Feses',
                    nama: 'Lemak',
                    display_name: 'Lemak',
                    satuan: '-',
                    normal_min: '-',
                    normal_max: '-',
                    nilai_rujukan: 'Negatif',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan: 'Dropdown',
                    opsi_output: 'Negatif;Positif(+);Positif(++);Positif(+++) ',
                    default: 'Negatif'
                },
                {
                    judul: 'Feses',
                    nama: 'Sisa Makanan',
                    display_name: 'Sisa Makanan',
                    satuan: '-',
                    normal_min: '-',
                    normal_max: '-',
                    nilai_rujukan: 'Negatif',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan: 'Dropdown',
                    opsi_output: 'Negatif;Positif(+);Positif(++);Positif(+++) ',
                    default: 'Negatif'
                },
                {
                    judul: 'Feses',
                    nama: 'Lain-lain',
                    display_name: 'Lain-lain',
                    satuan: '-',
                    normal_min: '-',
                    normal_max: '-',
                    nilai_rujukan: '',
                    nilai_kritis: 'L.- P.-',
                    metode: '-',
                    tipe_inputan: 'Text',
                    opsi_output: '',
                    default: ''
                },
            ];

   // Buat map dari data hasil pemeriksaan yang ada di database
    const hasilMap = {};
    if (hasil && hasil.length > 0) {
        hasil.forEach(item => {
            hasilMap[item.nama_pemeriksaan] = {
                hasil: item.hasil || '',
                duplo_d1: item.duplo_d1 || '',
                duplo_d2: item.duplo_d2 || '',
                duplo_d3: item.duplo_d3 || '',
                duplo_dx: item.duplo_dx || '',
                range: item.range || '',
                satuan: item.satuan || '',
                note: item.note || '',
                flag: item.flag || '',
                flag_dx: item.flag_dx || '',
                uid: item.uid || '',
                is_switched: Number(item.is_switched) || 0
            };
        });
    }

    // Create a map of OBX data by parameter name for quick lookup (fallback jika tidak ada data database)
    const obxMap = {};
    if (data_pasien.obx) {
        data_pasien.obx.forEach(obxItem => {
            if (!obxMap[obxItem.identifier_name]) {
                obxMap[obxItem.identifier_name] = [];
            }
            obxMap[obxItem.identifier_name].push(obxItem.identifier_value);
        });
    }

    function getDataValues(parameterName, namaPemeriksaan) {
        // Prioritas: data dari database, kemudian OBX sebagai fallback
        if (hasilMap[namaPemeriksaan] || hasilMap[parameterName]) {
            const data = hasilMap[namaPemeriksaan] || hasilMap[parameterName];
            return {
                duplo_d1: data.duplo_d1,
                duplo_d2: data.duplo_d2,
                duplo_d3: data.duplo_d3,
                duplo_dx: data.duplo_dx,
                hasilUtama: data.hasil,
                satuan: data.satuan,
                range: data.range,
                flag: data.flag,
                flag_dx: data.flag_dx || '',
                uid: data.uid || '',
                switched: Number(data.is_switched) || 0
            };
        }
        
        // Fallback ke OBX jika tidak ada data database
        const values = obxMap[parameterName] || [];
        return {
            duplo_d1: values[0] || '',
            duplo_d2: values[1] || '',
            duplo_d3: values[2] || '',
            hasilUtama: values[0] || '',
            satuan: '',
            range: '',
            flag: '' ,
            flag_dx: '',
            uid: '',
        };
    }

    // Cek apakah ada data duplo untuk menentukan kolom mana yang perlu ditampilkan
    function checkDuploColumns() {
        const duploStatus = {
            hasD1: false,
            hasD2: false,
            hasD3: false
        };

        // Cek dari data database
        Object.values(hasilMap).forEach(item => {
            if (item.duplo_d1 && item.duplo_d1.trim() !== '') duploStatus.hasD1 = true;
            if (item.duplo_d2 && item.duplo_d2.trim() !== '') duploStatus.hasD2 = true;
            if (item.duplo_d3 && item.duplo_d3.trim() !== '') duploStatus.hasD3 = true;
        });

        // Jika tidak ada data database, cek OBX
        if (!duploStatus.hasD1 && !duploStatus.hasD2 && !duploStatus.hasD3) {
            Object.values(obxMap).forEach(values => {
                if (values[0] && values[0].trim() !== '') duploStatus.hasD1 = true;
                if (values[1] && values[1].trim() !== '') duploStatus.hasD2 = true;
                if (values[2] && values[2].trim() !== '') duploStatus.hasD3 = true;
            });
        }

        return duploStatus;
    }

    const duploStatus = checkDuploColumns();
    function renderFlag(flag) {
        if (!flag) return '';

        if (flag.toLowerCase() === 'normal') {
            return ``;
        }
        if (flag.toLowerCase() === 'high') {
            return `<i class="ti ti-arrow-up text-danger"></i>`;
        }
        if (flag.toLowerCase() === 'low') {
            return `<i class="ti ti-arrow-down text-primary"></i>`;
        }
        if (flag.toLowerCase() === 'low*') {
            return `<i class="ti ti-arrow-down text-primary">*</i>`;
        }
        if (flag.toLowerCase() === 'high*') {
            return `<i class="ti ti-arrow-up text-danger">*</i>`;
        }
        return flag;
    }

    function getNormalValues(param, jenisKelamin) {
        const isLakiLaki = jenisKelamin && jenisKelamin.toLowerCase() === 'l' || jenisKelamin && jenisKelamin.toLowerCase() === 'laki-laki';
        
        return {
            min: isLakiLaki ? param.normal_min_l : param.normal_min_p,
            max: isLakiLaki ? param.normal_max_l : param.normal_max_p,
            rujukan: isLakiLaki ? param.nilai_rujukan_l : param.nilai_rujukan_p,
            display: isLakiLaki ? 
                `${param.normal_min_l}-${param.normal_max_l}` : 
                `${param.normal_min_p}-${param.normal_max_p}`
        };
    }

    const labData = data_pasien;
    const dokterData = data_pasien.dokter;
    const isDikembalikan = data_pasien.status === "Dikembalikan";
    const obx = data_pasien.obx;

    // Ambil note dari database jika ada
    const noteValue = hasil.length > 0 && hasil[0].note ? hasil[0].note : '';
    const kesimpulanValue = hasil.length > 0 && hasil[0].kesimpulan ? hasil[0].kesimpulan : '';
    const saranValue = hasil.length > 0 && hasil[0].saran ? hasil[0].saran : '';

    let parameterCounter = 0;
    
    function generateParameterUID(pemeriksaan, parameter, idx) {
        parameterCounter++;
        const cleanPemeriksaan = pemeriksaan.replace(/[^a-zA-Z0-9]/g, '_');
        const cleanParameter = parameter.replace(/[^a-zA-Z0-9]/g, '_');
        return `${cleanPemeriksaan}_${cleanParameter}_${idx}_${parameterCounter}`;
    }

    const content = `
    <form id="worklistForm" method="POST">
        @csrf
        <input type="hidden" name="no_lab" value="${data_pasien.no_lab}">
        <input type="hidden" name="no_rm" value="${data_pasien.no_rm}">
        <input type="hidden" name="nama" value="${data_pasien.nama}">
        <input type="hidden" name="ruangan" value="${data_pasien.asal_ruangan}">
        <input type="hidden" name="nama_dokter" value="${data_pasien.kode_dokter}">
        
        <div id="tabel-pemeriksaan">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="col-2">PARAMETER</th>
                            <th class="col-2">HASIL</th>
                            <th class="col-1"></th>
                            <th class="col-2 duplo dx-column">DX</th>
                            <th class="col-2 duplo d1-column" style="display: ${duploStatus.hasD1 ? 'table-cell' : 'none'};">D1</th>
                            <th class="col-2 duplo d2-column" style="display: ${duploStatus.hasD2 ? 'table-cell' : 'none'};">D2</th>
                            <th class="col-2 duplo d3-column" style="display: ${duploStatus.hasD3 ? 'table-cell' : 'none'};">D3</th>
                            <th class="col-3">FLAG</th>
                            <th class="col-2">Unit</th>
                        </tr>
                    </thead>
                </table>
            </div>
            
            <div class="accordion" id="accordionPemeriksaan">
                ${data_pemeriksaan_pasien.map((e, idx) => `
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading${idx}">
                            <button class="accordion-button collapsed" type="button" 
                                    data-bs-toggle="collapse" data-bs-target="#collapse${idx}"
                                    aria-expanded="false" aria-controls="collapse${idx}">
                                <span>${e.data_departement.nama_department}</span>
                            </button>
                        </h2>
                        
                        <div id="collapse${idx}" class="accordion-collapse collapse" 
                            aria-labelledby="heading${idx}" data-bs-parent="#accordionPemeriksaan">
                            <div class="accordion-body">
                                <table class="table table-striped">
                                    <thead style="visibility: collapse;">
                                        <tr>
                                            <th class="col-2">PARAMETER</th>
                                            <th class="col-2">HASIL</th>
                                            <th class="col-1"></th>
                                            <th class="col-2 duplo dx-column">DX</th>
                                            <th class="col-2 duplo d1-column" style="display: ${duploStatus.hasD1 ? 'table-cell' : 'none'};">D1</th>
                                            <th class="col-2 duplo d2-column" style="display: ${duploStatus.hasD2 ? 'table-cell' : 'none'};">D2</th>
                                            <th class="col-2 duplo d3-column" style="display: ${duploStatus.hasD3 ? 'table-cell' : 'none'};">D3</th>
                                            <th class="col-3">FLAG</th>
                                            <th class="col-2">Unit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${(() => {
                                            // Cek apakah ada pemeriksaan hematologi di grup ini
                                            const hasHematologi = e.pasiens.some(p => 
                                                p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('darah lengkap')
                                            );
                                            
                                            // Cek apakah ada pemeriksaan widal di grup ini
                                            const hasWidal = e.pasiens.some(p => 
                                                p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('widal')
                                            );
                                            
                                            // Cek apakah ada pemeriksaan urine di grup ini
                                            const hasUrine = e.pasiens.some(p => 
                                                p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('urin') ||
                                                p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('urine')
                                            );

                                            const hasMikrobiologi = e.pasiens.some(p => {
                                                const isMikrobiologi = p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('preparat gram');
                                                return isMikrobiologi;
                                                // console.log('Nama pemeriksaan:', p.data_pemeriksaan.nama_pemeriksaan.toLowerCase());
                                            });

                                            const hasPreparatBasah = e.pasiens.some(p => {
                                                return (
                                                    p.data_pemeriksaan.nama_pemeriksaan?.toLowerCase().includes('preparat basah') ||
                                                    p.data_pemeriksaan.nama_parameter?.toLowerCase().includes('preparat_basah')
                                                );
                                            });

                                            const hasFeses = e.pasiens.some(p => p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('feses'));
                                            const hasDengue = e.pasiens.some(p => p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('dengue_igg/igm'));
                                            const hasNS1 = e.pasiens.some(p => p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('dengue_ns1'));
                                            const hasTifoid = e.pasiens.some(p => p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('tifoid igm/igg'));

                                            function renderSerologiSection({ e, idx, flag, params, judul, warna, defaultName }) {
                                                if (!flag) return '';

                                                const pemeriksaan = e.pasiens.find(p =>
                                                    p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes(judul.toLowerCase().split('_')[0])
                                                );

                                                const namaPemeriksaan = pemeriksaan
                                                    ? pemeriksaan.data_pemeriksaan.nama_pemeriksaan
                                                    : defaultName;

                                                let html = `
                                                    <tr class="section-title-header">
                                                        <td colspan="8" class="fw-bold text-secondary ps-3"
                                                            style="background-color: #f8f9fa; border-left: 4px solid ${warna}; padding: 10px;">
                                                            ${judul}
                                                        </td>
                                                    </tr>
                                                `;

                                                html += params.map((param, paramIdx) => {
                                                    const obxValues = getDataValues(param.nama);
                                                    const rowId = `${judul}_${idx}_${paramIdx}`;
                                                    const label = param.display_name || param.nama || '-';
                                                    const uniqueID = generateParameterUID(judul, param.nama, paramIdx);
                                                    const flagContent = renderFlag(
                                                        obxValues.hasilUtama,
                                                        { innerHTML: '' },
                                                        param.nama,
                                                        false,
                                                        false,
                                                        true
                                                    );

                                                    const renderField = (name, value, className) => {
                                                        if (param.tipe_inputan === 'Dropdown') {
                                                            return `
                                                                <select name="${name}[${uniqueID}]" class="form-select ${className} w-60 p-0">
                                                                    <option value="" hidden>Pilih...</option>
                                                                    ${param.opsi_output.split(';').map(opt => `
                                                                        <option value="${opt.trim()}" ${value === opt.trim() ? 'selected' : ''}>${opt.trim()}</option>
                                                                    `).join('')}
                                                                </select>
                                                            `;
                                                        } else {
                                                            return `
                                                                <input type="text" name="${name}[${uniqueID}]" 
                                                                    class="form-control ${className} w-60 p-0 text-center" 
                                                                     value="${value || ''}" />
                                                            `;
                                                        }
                                                    };

                                                    return `
                                                        <tr data-id="${rowId}" data-parameter="${param.nama}" data-uid="${uniqueID}" class="serologi-row">
                                                            <!-- Nama parameter -->
                                                            <td class="col-2 ps-4">
                                                                <strong>${label}</strong>
                                                                ${param.nilai_rujukan ? `<small class="text-muted d-block">${param.nilai_rujukan}</small>` : ''}
                                                                <input type="hidden" name="uid[${uniqueID}]" value="${obxValues.uid}" />
                                                                <input type="hidden" name="nama_pemeriksaan[${uniqueID}]" value="${param.nama}" />
                                                                <input type="hidden" name="judul[${uniqueID}]" value="${judul}" />
                                                                <input type="hidden" name="parameter_name[${uniqueID}]" value="${param.nama}" />
                                                                <input type="hidden" name="nilai_rujukan[${uniqueID}]" value="${param.nilai_rujukan}" />
                                                                <input type="hidden" name="department[${uniqueID}]" value="${e.data_departement.nama_department}" />
                                                            </td>

                                                            <!-- Hasil utama -->
                                                            <td class="col-2 text-center">
                                                                <div class="d-flex align-items-center justify-content-center gap-1">
                                                                    ${renderField('hasil', obxValues.hasilUtama || param.default, 'manualInput')}
                                                                </div>
                                                            </td>

                                                            <!-- Tombol switch -->
                                                            <td class="col-1">
                                                                <button type="button" class="btn btn-outline-secondary btn-sm switch-btn" 
                                                                        data-index="${paramIdx}" data-switch-index="0">
                                                                    <i class="ti ti-switch-2"></i>
                                                                </button>
                                                            </td>

                                                            <!-- Duplo DX -->
                                                            <td class="col-2 text-center">
                                                                <div class="d-flex align-items-center justify-content-center gap-1">
                                                                    ${renderField('duplo_dx', obxValues.duplo_dx, 'dx')}
                                                                    <input type="hidden" name="is_switched[${uniqueID}]" value="${Number(obxValues.switched) === 1 ? 1 : 0}">
                                                                    ${obxValues.switched ? `
                                                                        <div class='checkbox-r-container d-flex align-items-center gap-1'>
                                                                            <input type='checkbox' class='checkbox-r form-check-input' checked disabled>
                                                                            <span class='text-danger fw-bold'>R</span>
                                                                        </div>
                                                                    ` : ''}
                                                                </div>
                                                            </td>

                                                            <!-- Duplo D1 -->
                                                            <td class="col-2 duplo d1-column text-center" style="display:none;">
                                                                ${renderField('duplo_d1', obxValues.duplo_d1, 'd1')}
                                                            </td>

                                                            <!-- Duplo D2 -->
                                                            <td class="col-2 duplo d2-column text-center" style="display:none;">
                                                                ${renderField('duplo_d2', obxValues.duplo_d2, 'd2')}
                                                            </td>

                                                            <!-- Duplo D3 -->
                                                            <td class="col-2 duplo d3-column text-center" style="display:none;">
                                                                ${renderField('duplo_d3', obxValues.duplo_d3, 'd3')}
                                                            </td>

                                                            <!-- Flag -->
                                                            <td class="col-3 flag-cell">
                                                                ${obxValues.switched ? `
                                                                <div class='checkbox-r-container d-flex align-items-center gap-1'>
                                                                    <input type='checkbox' class='checkbox-r form-check-input' checked disabled>
                                                                    <span class='text-danger fw-bold'>R</span>
                                                                    <select name="flag_dx[${uniqueID}]" class="form-select form-select-sm flag-dx-select" style="width: 100px;">
                                                                        <option value="Normal" ${(obxValues.flag_dx || 'Normal') === 'Normal' ? 'selected' : ''}>Normal</option>
                                                                        <option value="Low" ${obxValues.flag_dx === 'Low' ? 'selected' : ''}>Low</option>
                                                                        <option value="Low*" ${obxValues.flag_dx === 'Low*' ? 'selected' : ''}>Low*</option>
                                                                        <option value="High" ${obxValues.flag_dx === 'High' ? 'selected' : ''}>High</option>
                                                                        <option value="High*" ${obxValues.flag_dx === 'High*' ? 'selected' : ''}>High*</option>
                                                                    </select>
                                                                </div>
                                                            ` : `
                                                            `}
                                                            </td>

                                                            <!-- Satuan -->
                                                            <td>
                                                                ${param.satuan || ''}
                                                            </td>
                                                        </tr>
                                                    `;
                                                }).join('');

                                                return html;
                                            }
                                            
                                           if (hasHematologi) {
                                            const judulHematologi = e.pasiens.find(p => p.data_pemeriksaan?.judul)?.data_pemeriksaan?.judul || '';

                                            let html = '';

                                            // kalau ada judul → tampilkan header
                                            if (judulHematologi) {
                                                html += `
                                                    <tr class="hematologi-title-header">
                                                        <td colspan="9" class="fw-bold text-primary ps-3" 
                                                            style="background-color: #e3f2fd; border-left: 4px solid #2196f3; padding: 10px;">
                                                            ${judulHematologi}
                                                        </td>
                                                    </tr>
                                                `;
                                            }

                                            // looping parameter hematologi
                                            html += hematologiParams.map((param, paramIdx) => {
                                                const dataValues = getDataValues(param.nama, param.nama);
                                                const rowId = `hematologi_${idx}_${paramIdx}`;
                                                const uniqueID = generateParameterUID('Hematologi', param.nama, paramIdx);
                                                const flagContent = renderFlag(
                                                    dataValues.hasilUtama,
                                                    { innerHTML: '' },
                                                    param.nama,
                                                    true,
                                                    false,
                                                    false
                                                );

                                                return `
                                                    <tr data-id="${rowId}" data-parameter="${param.nama}" data-uid="${uniqueID}" class="hematologi-row">
                                                        <td class="col-2 ${judulHematologi ? 'ps-4' : ''}" ${judulHematologi ? 'style="border-left: 2px solid #e9ecef;"' : ''}>
                                                            <strong>${param.display_name}</strong>
                                                            <small class="text-muted d-block">${param.normal_min}-${param.normal_max}</small>
                                                            <input type="hidden" name="uid[${uniqueID}]" value="${dataValues.uid}" />
                                                            <input type="hidden" name="nama_pemeriksaan[${uniqueID}]" value="${param.nama}" />
                                                            ${judulHematologi ? `<input type="hidden" name="judul[${uniqueID}]" value="${judulHematologi}" />` : ''}
                                                            <input type="hidden" name="department[${uniqueID}]" value="${e.data_departement.nama_department}" />
                                                        </td>
                                                        <td class="col-2">
                                                            <input type="number" name="hasil[${uniqueID}]" 
                                                                class="form-control manualInput w-60 p-0 text-center" 
                                                                value="${dataValues.hasilUtama}" 
                                                                step="0.01" placeholder="" />
                                                        </td>
                                                        <td class="col-1">
                                                            <button type="button" class="btn btn-outline-secondary btn-sm switch-btn" 
                                                                    data-index="${paramIdx}">
                                                                <i class="ti ti-switch-2"></i>
                                                            </button>
                                                        </td>
                                                        <td class="col-2 duplo dx-column text-center">
                                                            <div class="d-flex align-items-center justify-content-center gap-1">
                                                                <input type="number" 
                                                                    name="duplo_dx[${uniqueID}]" 
                                                                    class="form-control dx w-60 p-0 text-center" 
                                                                    value="${dataValues.duplo_dx ?? ''}" 
                                                                    step="0.01" />

                                                                <!-- Hidden input untuk simpan status switch -->
                                                                <input type="hidden" name="is_switched[${uniqueID}]" value="${Number(dataValues.switched) === 1 ? 1 : 0}">

                                                                <!-- Jika sudah di-switch, tampilkan checkbox R -->
                                                                ${dataValues.switched ? `
                                                                    <div class='checkbox-r-container d-flex align-items-center gap-1'>
                                                                        <input type='checkbox' class='checkbox-r form-check-input' checked disabled>
                                                                        <span class='text-danger fw-bold'>R</span>
                                                                    </div>
                                                                ` : ''}
                                                            </div>
                                                        </td>
                                                        <td class="col-2 duplo d1-column text-center" style="display: ${duploStatus.hasD1 ? 'table-cell' : 'none'};">
                                                            <input type="number" name="duplo_d1[${uniqueID}]" 
                                                                class="form-control d1 w-60 p-0 text-center" 
                                                                value="${dataValues.duplo_d1}" step="0.01" readonly />
                                                        </td>
                                                        <td class="col-2 duplo d2-column" style="display: ${duploStatus.hasD2 ? 'table-cell' : 'none'};">
                                                            <input type="number" name="duplo_d2[${uniqueID}]" 
                                                                class="form-control d2 w-60 p-0 text-center" 
                                                                value="${dataValues.duplo_d2}" step="0.01" readonly />
                                                        </td>
                                                        <td class="col-2 duplo d3-column" style="display: ${duploStatus.hasD3 ? 'table-cell' : 'none'};">
                                                            <input type="number" name="duplo_d3[${uniqueID}]" 
                                                                class="form-control d3 w-50 p-0 text-center" 
                                                                value="${dataValues.duplo_d3}" step="0.01" readonly />
                                                        </td>
                                                        <td class="col-3 flag-cell">
                                                            ${renderFlag(dataValues.flag || flagContent(dataValues.hasilUtama, {innerHTML: ''}, p.data_pemeriksaan.nama_parameter))}
                                                            
                                                            ${dataValues.switched ? `
                                                                <div class='checkbox-r-container d-flex align-items-center gap-1'>
                                                                    <input type='checkbox' class='checkbox-r form-check-input' checked disabled>
                                                                    <span class='text-danger fw-bold'>R</span>
                                                                    <select name="flag_dx[${uniqueID}]" class="form-select form-select-sm flag-dx-select" style="width: 100px;">
                                                                        <option value="Normal" ${(dataValues.flag_dx || 'Normal') === 'Normal' ? 'selected' : ''}>Normal</option>
                                                                        <option value="Low" ${dataValues.flag_dx === 'Low' ? 'selected' : ''}>Low</option>
                                                                        <option value="Low*" ${dataValues.flag_dx === 'Low*' ? 'selected' : ''}>Low*</option>
                                                                        <option value="High" ${dataValues.flag_dx === 'High' ? 'selected' : ''}>High</option>
                                                                        <option value="High*" ${dataValues.flag_dx === 'High*' ? 'selected' : ''}>High*</option>
                                                                    </select>
                                                                </div>
                                                            ` : ''}
                                                        </td>
                                                        
                                                        <td>
                                                            ${dataValues.satuan || param.satuan}
                                                        </td>
                                                    </tr>
                                                `;
                                            }).join('');

                                            return html;
                                        } else if (hasWidal) {
                                        // Jika ada Widal, tampilkan parameter Widal lengkap
                                        const widalPemeriksaan = e.pasiens.find(p =>
                                            p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('widal')
                                        );
                                        const judulWidal = e.pasiens.find(p => p.data_pemeriksaan?.judul)?.data_pemeriksaan?.judul || '';
                                        const namaPemeriksaanWidal = widalPemeriksaan ? widalPemeriksaan.data_pemeriksaan.nama_pemeriksaan : 'Widal';

                                        let html = '';

                                        // Header judul (jika ada)
                                        if (judulWidal) {
                                            html += `
                                                <tr class="widal-title-header">
                                                    <td colspan="8" class="fw-bold text-warning ps-3"
                                                        style="background-color:#fff3e0; border-left:4px solid #ff9800; padding:10px;">
                                                        ${judulWidal}
                                                    </td>
                                                </tr>
                                            `;
                                        }

                                        // Parameter Widal
                                        html += WidalParams.map((param, paramIdx) => {
                                        const obxValues = getDataValues(param.nama, param.nama);
                                        const rowId = `widal_${idx}_${paramIdx}`;
                                        const normalValues = getNormalValues(param, data_pasien.jenis_kelamin);
                                        const uniqueID = generateParameterUID('Widal', param.nama, paramIdx);

                                        // flag apakah ada hasil duplo
                                        const hasDuplo = obxValues.duplo_dx || obxValues.duplo_d1 || obxValues.duplo_d2 || obxValues.duplo_d3;

                                        return `
                                            <tr data-id="${rowId}" data-parameter="${param.nama}" data-uid="${uniqueID}" class="widal-row">
                                                <td class="col-2 ${judulWidal ? 'ps-4' : ''}" ${judulWidal ? 'style="border-left: 2px solid #e9ecef;"' : ''}>
                                                    <strong>${param.display_name}</strong>
                                                    <input type="hidden" name="uid[${uniqueID}]" value="${obxValues.uid}" />
                                                    <input type="hidden" name="nama_pemeriksaan[${uniqueID}]" value="${namaPemeriksaanWidal}" />
                                                    ${judulWidal ? `<input type="hidden" name="judul[${uniqueID}]" value="${judulWidal}" />` : ''}
                                                    <input type="hidden" name="parameter_name[${uniqueID}]" value="${param.nama}" />
                                                    <input type="hidden" name="nilai_rujukan[${uniqueID}]" value="${normalValues.rujukan}" />
                                                    <input type="hidden" name="department[${uniqueID}]" value="${e.data_departement.nama_department}" />
                                                </td>
                                                <td class="col-2">
                                                    <select name="hasil[${uniqueID}]" class="form-select manualInput w-60 p-0">
                                                        ${param.opsi_output.split(';').map(opt => `
                                                            <option value="${opt.trim()}" ${obxValues.hasilUtama === opt.trim() ? 'selected' : ''}>
                                                                ${opt.trim()}
                                                            </option>
                                                        `).join('')}
                                                    </select>
                                                </td>
                                                <td class="col-1">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm switch-btn"
                                                            data-index="${paramIdx}" data-switch-index="0">
                                                        <i class="ti ti-switch-2"></i>
                                                    </button>
                                                </td>
                                                <td class="col-2 text-center">
                                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                                        <select name="duplo_dx[${uniqueID}]" class="form-select dx w-60 p-0">
                                                        <option value="" selected hidden>Pilih...</option>
                                                            ${param.opsi_output
                                                                ? param.opsi_output.split(';').map(opt => `
                                                                    <option value="${opt.trim()}"
                                                                        ${obxValues.duplo_dx === opt.trim() ? 'selected' : ''}>
                                                                        ${opt.trim()}
                                                                    </option>
                                                                `).join('')
                                                                : '<option value="">Pilih...</option>'
                                                            }
                                                        </select>

                                                        <input type="hidden" name="is_switched[${uniqueID}]" value="${Number(obxValues.switched) === 1 ? 1 : 0}">

                                                        ${obxValues.switched ? `
                                                            <div class='checkbox-r-container d-flex align-items-center gap-1'>
                                                                <input type='checkbox' class='checkbox-r form-check-input' checked disabled>
                                                                <span class='text-danger fw-bold'>R</span>
                                                            </div>
                                                        ` : ''}
                                                    </div>
                                                </td>
                                                ${hasDuplo ? `
                                                    <td class="col-2 duplo d1-column text-center" style="display: ${duploStatus.hasD1 ? 'table-cell' : 'none'};">
                                                        <select name="duplo_d1[${uniqueID}]" class="form-select d1 w-60 p-0" disabled>
                                                        <option value="" selected hidden>Pilih...</option>
                                                            ${param.opsi_output.split(';').map(opt => `
                                                                <option value="${opt.trim()}" ${obxValues.duplo_d1 === opt.trim() ? 'selected' : ''}>
                                                                    ${opt.trim()}
                                                                </option>
                                                            `).join('')}
                                                        </select>
                                                    </td>
                                                    <td class="col-2 duplo d2-column" style="display: ${duploStatus.hasD2 ? 'table-cell' : 'none'};">
                                                        <select name="duplo_d2[${uniqueID}]" class="form-select d2 w-60 p-0" disabled>
                                                        <option value="" selected hidden>Pilih...</option>
                                                            ${param.opsi_output.split(';').map(opt => `
                                                                <option value="${opt.trim()}" ${obxValues.duplo_d2 === opt.trim() ? 'selected' : ''}>
                                                                    ${opt.trim()}
                                                                </option>
                                                            `).join('')}
                                                        </select>
                                                    </td>
                                                    <td class="col-2 duplo d3-column" style="display: ${duploStatus.hasD3 ? 'table-cell' : 'none'};">
                                                        <select name="duplo_d3[${uniqueID}]" class="form-select d3 w-60 p-0" disabled>
                                                        <option value="" selected hidden>Pilih...</option>
                                                            ${param.opsi_output.split(';').map(opt => `
                                                                <option value="${opt.trim()}" ${obxValues.duplo_d3 === opt.trim() ? 'selected' : ''}>
                                                                    ${opt.trim()}
                                                                </option>
                                                            `).join('')}
                                                        </select>
                                                    </td>
                                                ` : ''}
                                                <td class="col-3 flag-cell">
                                                    ${obxValues.switched ? `
                                                    <div class='checkbox-r-container d-flex align-items-center gap-1'>
                                                        <input type='checkbox' class='checkbox-r form-check-input' checked disabled>
                                                        <span class='text-danger fw-bold'>R</span>
                                                        <select name="flag_dx[${uniqueID}]" class="form-select form-select-sm flag-dx-select" style="width: 100px;">
                                                            <option value="Normal" ${(obxValues.flag_dx || 'Normal') === 'Normal' ? 'selected' : ''}>Normal</option>
                                                            <option value="Low" ${obxValues.flag_dx === 'Low' ? 'selected' : ''}>Low</option>
                                                            <option value="Low*" ${obxValues.flag_dx === 'Low*' ? 'selected' : ''}>Low*</option>
                                                            <option value="High" ${obxValues.flag_dx === 'High' ? 'selected' : ''}>High</option>
                                                            <option value="High*" ${obxValues.flag_dx === 'High*' ? 'selected' : ''}>High*</option>
                                                        </select>
                                                    </div>
                                                ` : `
                                                `}
                                                </td>
                                                
                                                <td>
                                                    ${param.satuan}
                                                </td>
                                            </tr>
                                        `;
                                    }).join('');

                                        return html;
                                    } else if (hasUrine) {
                                        const urinePemeriksaan = e.pasiens.find(p => 
                                            p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('urin') ||
                                            p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('urine')
                                        );
                                        const namaPemeriksaanUrine = urinePemeriksaan 
                                            ? urinePemeriksaan.data_pemeriksaan.nama_pemeriksaan 
                                            : 'Urinalisis';

                                        let html = '';

                                        const groupedParams = UrineParams.reduce((acc, param) => {
                                            if (!acc[param.judul]) acc[param.judul] = [];
                                            acc[param.judul].push(param);
                                            return acc;
                                        }, {});

                                        Object.entries(groupedParams).forEach(([judulGroup, params]) => {
                                            html += `
                                                <tr class="urine-title-header">
                                                    <td colspan="8" class="fw-bold text-info ps-3"
                                                        style="background-color:#e1f5fe; border-left:4px solid #00bcd4; padding:10px;">
                                                        ${judulGroup}
                                                    </td>
                                                </tr>
                                            `;

                                            html += params.map((param, paramIdx) => {
                                                const obxValues = getDataValues(param.nama);
                                                const rowId = `urine_${idx}_${paramIdx}`;
                                                const paramKey = param.nama.replace(/\s+/g, '_');
                                                const uniqueID = generateParameterUID('Urine_' + judulGroup, param.nama, paramIdx);
                                                
                                                const initialFlag = renderFlag(
                                                    obxValues.hasilUtama,
                                                    param.nama,
                                                    false,
                                                    true,
                                                    null,
                                                    data_pasien.jenis_kelamin
                                                );
                                                const normalValues = getNormalValues(param, data_pasien.jenis_kelamin);

                                                return `
                                                    <tr data-id="${rowId}" data-parameter="${param.nama}" data-uid="${uniqueID}" class="urine-row">
                                                        <td class="col-2 ps-4" style="border-left:2px solid #e9ecef;">
                                                            <strong>${param.display_name}</strong>
                                                            ${normalValues.rujukan !== '-' && normalValues.rujukan !== '' 
                                                                ? `<small class="text-muted d-block">${normalValues.rujukan ?? ''}</small>` 
                                                                : ''}
                                                            
                                                            <input type="hidden" name="uid[${uniqueID}]" value="${obxValues.uid}" />
                                                            <input type="hidden" name="nama_pemeriksaan[${uniqueID}]" value="${param.nama}" />
                                                            <input type="hidden" name="judul[${uniqueID}]" value="${param.judul}" />
                                                            <input type="hidden" name="parameter_name[${uniqueID}]" value="${param.nama}" />
                                                            <input type="hidden" name="nilai_rujukan[${uniqueID}]" value="${normalValues.rujukan}" />
                                                            <input type="hidden" name="department[${uniqueID}]" value="${e.data_departement.nama_department}" />
                                                        </td>

                                                        <td class="col-2">
                                                            ${param.tipe_inputan.toLowerCase() === 'text' ? `
                                                                <input type="text" name="hasil[${uniqueID}]" 
                                                                    class="form-control manualInput w-60 p-0 text-center"
                                                                    data-uid="${uniqueID}"
                                                                    data-parameter="${param.nama}"
                                                                     value="${obxValues.hasilUtama || param.default || ''}" />
                                                            ` : `
                                                                <select name="hasil[${uniqueID}]" 
                                                                    class="form-select manualInput w-60 p-0"
                                                                    data-uid="${uniqueID}"
                                                                    data-parameter="${param.nama}"
                                                                    >
                                                                    ${param.opsi_output.split(';').map(opt => `
                                                                        <option value="${opt.trim()}" 
                                                                            ${(obxValues.hasilUtama || param.default) === opt.trim() ? 'selected' : ''}>
                                                                            ${opt.trim()}
                                                                        </option>
                                                                    `).join('')}
                                                                </select>
                                                            `}
                                                        </td>

                                                        <td class="col-1">
                                                            <button type="button" class="btn btn-outline-secondary btn-sm switch-btn"
                                                                    data-uid="${uniqueID}"
                                                                    data-parameter="${param.nama}"
                                                                    data-index="${paramIdx}" 
                                                                    data-switch-index="0">
                                                                <i class="ti ti-switch-2"></i>
                                                            </button>
                                                        </td>

                                                        <!-- Kolom duplo DX dengan identifier unik -->
                                                        <td class="col-2 text-center">
                                                            <div class="d-flex align-items-center justify-content-center gap-1">
                                                                ${param.tipe_inputan.toLowerCase() === 'text' ? `
                                                                    <input type="text"
                                                                        name="duplo_dx[${uniqueID}]"
                                                                        class="form-control dx w-60 p-0 text-center"
                                                                        data-uid="${uniqueID}"
                                                                        value="${obxValues.duplo_dx || ''}" />
                                                                ` : `
                                                                    <select name="duplo_dx[${uniqueID}]" 
                                                                        class="form-select dx w-60 p-0"
                                                                        data-uid="${uniqueID}">
                                                                        <option value="" selected hidden>Pilih...</option>
                                                                        ${param.opsi_output
                                                                            ? param.opsi_output.split(';').map(opt => `
                                                                                <option value="${opt.trim()}"
                                                                                    ${obxValues.duplo_dx === opt.trim() ? 'selected' : ''}>
                                                                                    ${opt.trim()}
                                                                                </option>
                                                                            `).join('')
                                                                            : '<option value="">Pilih...</option>'
                                                                        }
                                                                    </select>
                                                                `}

                                                                <!-- PENTING: is_switched dengan key unik -->
                                                                <input type="hidden" 
                                                                    name="is_switched[${uniqueID}]" 
                                                                    class="is-switched-input"
                                                                    data-uid="${uniqueID}"
                                                                    value="${Number(obxValues.switched) === 1 ? 1 : 0}">

                                                                ${obxValues.switched ? `
                                                                    <div class='checkbox-r-container d-flex align-items-center gap-1'
                                                                        data-uid="${uniqueID}">
                                                                        <input type='checkbox' 
                                                                            class='checkbox-r form-check-input' 
                                                                            data-uid="${uniqueID}"
                                                                            checked disabled>
                                                                        <span class='text-danger fw-bold'>R</span>
                                                                    </div>
                                                                ` : ''}
                                                            </div>
                                                        </td>

                                                        <!-- Kolom duplo D1 -->
                                                        <td class="col-2 duplo d1-column text-center" style="display:none;">
                                                            ${param.tipe_inputan.toLowerCase() === 'text' ? `
                                                                <input type="text" name="duplo_d1[${uniqueID}]" 
                                                                    class="form-control d1 w-60 p-0 text-center"
                                                                    data-uid="${uniqueID}"
                                                                    disabled value="${obxValues.duplo_d1 || ''}" />
                                                            ` : `
                                                                <select name="duplo_d1[${uniqueID}]" 
                                                                    class="form-select d1 w-60 p-0"
                                                                    data-uid="${uniqueID}"
                                                                    disabled>
                                                                    <option value="" selected hidden>Pilih...</option>
                                                                    ${param.opsi_output.split(';').map(opt => `
                                                                        <option value="${opt.trim()}" ${obxValues.duplo_d1 === opt.trim() ? 'selected' : ''}>
                                                                            ${opt.trim()}
                                                                        </option>
                                                                    `).join('')}
                                                                </select>
                                                            `}
                                                        </td>

                                                        <!-- Kolom duplo D2 -->
                                                        <td class="col-2 duplo d2-column" style="display:none;">
                                                            ${param.tipe_inputan.toLowerCase() === 'text' ? `
                                                                <input type="text" name="duplo_d2[${uniqueID}]" 
                                                                    class="form-control d2 w-60 p-0 text-center"
                                                                    data-uid="${uniqueID}"
                                                                    disabled value="${obxValues.duplo_d2 || ''}" />
                                                            ` : `
                                                                <select name="duplo_d2[${uniqueID}]" 
                                                                    class="form-select d2 w-60 p-0"
                                                                    data-uid="${uniqueID}"
                                                                    disabled>
                                                                    <option value="" selected hidden>Pilih...</option>
                                                                    ${param.opsi_output.split(';').map(opt => `
                                                                        <option value="${opt.trim()}" ${obxValues.duplo_d2 === opt.trim() ? 'selected' : ''}>
                                                                            ${opt.trim()}
                                                                        </option>
                                                                    `).join('')}
                                                                </select>
                                                            `}
                                                        </td>

                                                        <!-- Kolom duplo D3 -->
                                                        <td class="col-2 duplo d3-column" style="display:none;">
                                                            ${param.tipe_inputan.toLowerCase() === 'text' ? `
                                                                <input type="text" name="duplo_d3[${uniqueID}]" 
                                                                    class="form-control d3 w-50 p-0 text-center"
                                                                    data-uid="${uniqueID}"
                                                                    disabled value="${obxValues.duplo_d3 || ''}" />
                                                            ` : `
                                                                <select name="duplo_d3[${uniqueID}]" 
                                                                    class="form-select d3 w-50 p-0"
                                                                    data-uid="${uniqueID}"
                                                                    disabled>
                                                                    <option value="" selected hidden>Pilih...</option>
                                                                    ${param.opsi_output.split(';').map(opt => `
                                                                        <option value="${opt.trim()}" ${obxValues.duplo_d3 === opt.trim() ? 'selected' : ''}>
                                                                            ${opt.trim()}
                                                                        </option>
                                                                    `).join('')}
                                                                </select>
                                                            `}
                                                        </td>

                                                        <!-- Kolom Flag dengan identifier unik -->
                                                        <td class="col-3 flag-cell" data-uid="${uniqueID}">
                                                            ${obxValues.switched ? `
                                                                <div class='checkbox-r-container d-flex align-items-center gap-1'>
                                                                    <input type='checkbox' 
                                                                        class='checkbox-r form-check-input' 
                                                                        data-uid="${uniqueID}"
                                                                        checked disabled>
                                                                    <span class='text-danger fw-bold'>R</span>
                                                                    <select name="flag_dx[${uniqueID}]" 
                                                                        class="form-select form-select-sm flag-dx-select"
                                                                        data-uid="${uniqueID}"
                                                                        style="width: 100px;">
                                                                        <option value="Normal" ${(obxValues.flag_dx || 'Normal') === 'Normal' ? 'selected' : ''}>Normal</option>
                                                                        <option value="Low" ${obxValues.flag_dx === 'Low' ? 'selected' : ''}>Low</option>
                                                                        <option value="Low*" ${obxValues.flag_dx === 'Low*' ? 'selected' : ''}>Low*</option>
                                                                        <option value="High" ${obxValues.flag_dx === 'High' ? 'selected' : ''}>High</option>
                                                                        <option value="High*" ${obxValues.flag_dx === 'High*' ? 'selected' : ''}>High*</option>
                                                                    </select>
                                                                </div>
                                                            ` : `
                                                            `}
                                                        </td>

                                                        <!-- Kolom Satuan -->
                                                        <td>
                                                            ${param.satuan}
                                                        </td>
                                                    </tr>
                                                `;
                                            }).join('');
                                        });

                                        return html;
                                    } if (hasMikrobiologi || hasPreparatBasah) {
                                            let html = '';

                                            // ================== MICROBIOLOGI ==================
                                            if (hasMikrobiologi) {
                                                const mikrobiologiPemeriksaan = e.pasiens.find(p =>
                                                    p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('preparat gram')
                                                );
                                                const judulMikrobiologi = e.pasiens.find(p => 
                                                    p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('preparat gram') && p.data_pemeriksaan?.judul
                                                )?.data_pemeriksaan?.judul || '';
                                                const namaPemeriksaanMikrobiologi = mikrobiologiPemeriksaan ? mikrobiologiPemeriksaan.data_pemeriksaan.nama_pemeriksaan : 'Preparat Gram';

                                                if (judulMikrobiologi) {
                                                    html += `
                                                        <tr class="mikrobiologi-title-header">
                                                            <td colspan="8" class="fw-bold text-secondary ps-3" style="background-color: #f8f9fa; border-left: 4px solid #28a745; padding: 10px;">
                                                                ${judulMikrobiologi}
                                                            </td>
                                                        </tr>
                                                    `;
                                                }

                                                html += MicrobiologiParams.map((param, paramIdx) => {
                                                    const obxValues = getDataValues(param.nama);
                                                    const rowId = `mikrobiologi_${idx}_${paramIdx}`;
                                                    const normalValues = getNormalValues(param, data_pasien.jenis_kelamin);
                                                    const label = param.judul || param.display_name || param.nama || '-';
                                                    const uniqueID = generateParameterUID('Microbiologi', param.nama, paramIdx);

                                                    return `
                                                        <tr data-id="${rowId}" data-parameter="${param.nama}" data-uid="${uniqueID}" class="mikrobiologi-row">
                                                            <td class="col-2 ps-4" style="border-left: 2px solid #e9ecef;">
                                                                <strong>${label}</strong>
                                                                ${param.nilai_rujukan !== '-' && param.nilai_rujukan !== '' ? 
                                                                    `<small class="text-muted d-block">${param.nilai_rujukan ?? ''}</small>` : ''}
                                                                <input type="hidden" name="uid[${uniqueID}]" value="${obxValues.uid}" />
                                                                <input type="hidden" name="nama_pemeriksaan[${uniqueID}]" value="${namaPemeriksaanMikrobiologi}" />
                                                                <input type="hidden" name="judul[${uniqueID}]" value="${judulMikrobiologi}" />
                                                                <input type="hidden" name="parameter_name[${uniqueID}]" value="${param.nama}" />
                                                                <input type="hidden" name="nilai_rujukan[${uniqueID}]" value="${param.nilai_rujukan ?? '-'}" />
                                                                <input type="hidden" name="department[${uniqueID}]" value="${e.data_departement.nama_department}" />
                                                            </td>
                                                            <td class="col-2">
                                                                ${param.tipe_inputan === 'Text' ? `
                                                                    <input type="text" name="hasil[${uniqueID}]" class="form-control manualInput w-60 p-0 text-center" disabled value="${obxValues.hasilUtama || ''}" />
                                                                ` : `
                                                                    <select name="hasil[${uniqueID}]" class="form-select manualInput w-60 p-0" disabled>
                                                                        ${param.opsi_output ? param.opsi_output.split(';').map(opt => `
                                                                            <option value="${opt.trim()}" ${obxValues.hasilUtama === opt.trim() ? 'selected' : ''}>${opt.trim()}</option>
                                                                        `).join('') : '<option value="">Pilih...</option>'}
                                                                    </select>
                                                                `}
                                                            </td>
                                                            <td class="col-1">
                                                                <button type="button" class="btn btn-outline-secondary btn-sm switch-btn"
                                                                        data-index="${paramIdx}" data-switch-index="0">
                                                                    <i class="ti ti-switch-2"></i>
                                                                </button>
                                                            </td>

                                                            <!-- Kolom duplo DX -->
                                                            <td class="col-2 text-center">
                                                                <div class="d-flex align-items-center justify-content-center gap-1">
                                                                    ${param.tipe_inputan.toLowerCase() === 'Text' ? `
                                                                        <input type="text"
                                                                            name="duplo_dx[${uniqueID}]"
                                                                            class="form-control dx w-60 p-0 text-center"
                                                                            value="${obxValues.duplo_dx || ''}" />
                                                                    ` : `
                                                                        <select name="duplo_dx[${uniqueID}]" class="form-select dx w-60 p-0">
                                                                        <option value="" selected hidden>Pilih...</option>
                                                                            ${param.opsi_output
                                                                                ? param.opsi_output.split(';').map(opt => `
                                                                                    <option value="${opt.trim()}"
                                                                                        ${obxValues.duplo_dx === opt.trim() ? 'selected' : ''}>
                                                                                        ${opt.trim()}
                                                                                    </option>
                                                                                `).join('')
                                                                                : '<option value="">Pilih...</option>'
                                                                            }
                                                                        </select>
                                                                    `}

                                                                    <input type="hidden" name="is_switched[${uniqueID}]" value="${Number(obxValues.switched) === 1 ? 1 : 0}">

                                                                    ${obxValues.switched ? `
                                                                        <div class='checkbox-r-container d-flex align-items-center gap-1'>
                                                                            <input type='checkbox' class='checkbox-r form-check-input' checked disabled>
                                                                            <span class='text-danger fw-bold'>R</span>
                                                                        </div>
                                                                    ` : ''}
                                                                </div>
                                                            </td>

                                                            <td class="col-2 duplo d1-column text-center" style="display: none;">
                                                                ${param.tipe_inputan === 'Text' ? `
                                                                    <input type="text" name="duplo_d1[${uniqueID}]" class="form-control d1 w-60 p-0 text-center" disabled value="${obxValues.duplo_d1 || ''}" />
                                                                ` : `
                                                                    <select name="duplo_d1[${uniqueID}]" class="form-select d1 w-60 p-0" disabled>
                                                                    <option value="" selected hidden>Pilih...</option>
                                                                        ${param.opsi_output ? param.opsi_output.split(';').map(opt => `
                                                                            <option value="${opt.trim()}" ${obxValues.duplo_d1 === opt.trim() ? 'selected' : ''}>${opt.trim()}</option>
                                                                        `).join('') : '<option value="">Pilih...</option>'}
                                                                    </select>
                                                                `}
                                                            </td>
                                                            <td class="col-2 duplo d2-column" style="display: none;">
                                                                ${param.tipe_inputan === 'Text' ? `
                                                                    <input type="text" name="duplo_d2[${uniqueID}]" class="form-control d2 w-60 p-0 text-center" disabled value="${obxValues.duplo_d2 || ''}" />
                                                                ` : `
                                                                    <select name="duplo_d2[${uniqueID}]" class="form-select d2 w-60 p-0" disabled>
                                                                    <option value="" selected hidden>Pilih...</option>
                                                                        ${param.opsi_output ? param.opsi_output.split(';').map(opt => `
                                                                            <option value="${opt.trim()}" ${obxValues.duplo_d2 === opt.trim() ? 'selected' : ''}>${opt.trim()}</option>
                                                                        `).join('') : '<option value="">Pilih...</option>'}
                                                                    </select>
                                                                `}
                                                            </td>
                                                            <td class="col-2 duplo d3-column" style="display: none;">
                                                                ${param.tipe_inputan === 'Text' ? `
                                                                    <input type="text" name="duplo_d3[${uniqueID}]" class="form-control d3 w-50 p-0 text-center" disabled value="${obxValues.duplo_d3 || ''}" />
                                                                ` : `
                                                                    <select name="duplo_d3[${uniqueID}]" class="form-select d3 w-50 p-0" disabled>
                                                                    <option value="" selected hidden>Pilih...</option>
                                                                        ${param.opsi_output ? param.opsi_output.split(';').map(opt => `
                                                                            <option value="${opt.trim()}" ${obxValues.duplo_d3 === opt.trim() ? 'selected' : ''}>${opt.trim()}</option>
                                                                        `).join('') : '<option value="">Pilih...</option>'}
                                                                    </select>
                                                                `}
                                                            </td>
                                                            <td class="col-3 flag-cell">
                                                                ${obxValues.switched ? `
                                                                    <div class='checkbox-r-container d-flex align-items-center gap-1'>
                                                                        <input type='checkbox' class='checkbox-r form-check-input' checked disabled>
                                                                        <span class='text-danger fw-bold'>R</span>
                                                                        <select name="flag_dx[${uniqueID}]" class="form-select form-select-sm flag-dx-select" style="width: 100px;">
                                                                            <option value="Normal" ${(obxValues.flag_dx || 'Normal') === 'Normal' ? 'selected' : ''}>Normal</option>
                                                                            <option value="Low" ${obxValues.flag_dx === 'Low' ? 'selected' : ''}>Low</option>
                                                                            <option value="Low*" ${obxValues.flag_dx === 'Low*' ? 'selected' : ''}>Low*</option>
                                                                            <option value="High" ${obxValues.flag_dx === 'High' ? 'selected' : ''}>High</option>
                                                                            <option value="High*" ${obxValues.flag_dx === 'High*' ? 'selected' : ''}>High*</option>
                                                                        </select>
                                                                    </div>
                                                                ` : `
                                                                `}    
                                                            </td>
                                                            
                                                            <td>
                                                                ${param.satuan || ''}
                                                            </td>
                                                        </tr>
                                                    `;
                                                }).join('');
                                            }

                                            // ================== PREPARAT BASAH ==================
                                            if (hasPreparatBasah) {
                                                const preparatBasahPemeriksaan = e.pasiens.find(p =>
                                                    p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('preparat basah')
                                                );
                                                const judulPreparatBasah = e.pasiens.find(p => 
                                                    p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('preparat basah') && p.data_pemeriksaan?.judul
                                                )?.data_pemeriksaan?.judul || '';
                                                const namaPemeriksaanPreparatBasah = preparatBasahPemeriksaan ? preparatBasahPemeriksaan.data_pemeriksaan.nama_pemeriksaan : 'Preparat Basah';

                                                if (judulPreparatBasah) {
                                                    html += `
                                                        <tr class="preparatbasah-title-header">
                                                            <td colspan="8" class="fw-bold text-secondary ps-3" style="background-color: #f8f9fa; border-left: 4px solid #17a2b8; padding: 10px;">
                                                                ${judulPreparatBasah}
                                                            </td>
                                                        </tr>
                                                    `;
                                                }

                                                html += PreparatBasahParams.map((param, paramIdx) => {
                                                    const obxValues = getDataValues(param.nama);
                                                    const rowId = `preparatbasah_${idx}_${paramIdx}`;
                                                    const normalValues = getNormalValues(param, data_pasien.jenis_kelamin);
                                                    const label = param.judul || param.display_name || param.nama || '-';
                                                    const uniqueID = generateParameterUID('PreparatBasah', param.nama, paramIdx);

                                                    return `
                                                        <tr data-id="${rowId}" data-parameter="${param.nama}" data-uid="${uniqueID}" class="preparatbasah-row">
                                                            <td class="col-2 ps-4" style="border-left: 2px solid #e9ecef;">
                                                                <strong>${label}</strong>
                                                                ${param.nilai_rujukan !== '-' && param.nilai_rujukan !== '' ? 
                                                                    `<small class="text-muted d-block">${param.nilai_rujukan ?? ''}</small>` : ''}
                                                                <input type="hidden" name="uid[${uniqueID}]" value="${obxValues.uid}" />
                                                                <input type="hidden" name="nama_pemeriksaan[${uniqueID}]" value="${namaPemeriksaanPreparatBasah}" />
                                                                <input type="hidden" name="judul[${uniqueID}]" value="${judulPreparatBasah}" />
                                                                <input type="hidden" name="parameter_name[${uniqueID}]" value="${param.nama}" />
                                                                <input type="hidden" name="nilai_rujukan[${uniqueID}]" value="${param.nilai_rujukan ?? '-'}" />
                                                                <input type="hidden" name="department[${uniqueID}]" value="${e.data_departement.nama_department}" />
                                                            </td>
                                                            <td class="col-2">
                                                                ${param.tipe_inputan === 'Text' ? `
                                                                    <input type="text" name="hasil[${uniqueID}]" class="form-control manualInput w-60 p-0 text-center" disabled value="${obxValues.hasilUtama || ''}" />
                                                                ` : `
                                                                    <select name="hasil[${uniqueID}]" class="form-select manualInput w-60 p-0" disabled>
                                                                        ${param.opsi_output ? param.opsi_output.split(';').map(opt => `
                                                                            <option value="${opt.trim()}" ${obxValues.hasilUtama === opt.trim() ? 'selected' : ''}>${opt.trim()}</option>
                                                                        `).join('') : '<option value="">Pilih...</option>'}
                                                                    </select>
                                                                `}
                                                            </td>
                                                            <td class="col-1">
                                                                <button type="button" class="btn btn-outline-secondary btn-sm switch-btn"
                                                                        data-index="${paramIdx}" data-switch-index="0">
                                                                    <i class="ti ti-switch-2"></i>
                                                                </button>
                                                            </td>

                                                            <!-- Kolom duplo DX -->
                                                            <td class="col-2 text-center">
                                                                <div class="d-flex align-items-center justify-content-center gap-1">
                                                                    ${param.tipe_inputan.toLowerCase() === 'text' ? `
                                                                        <input type="text"
                                                                            name="duplo_dx[${uniqueID}]"
                                                                            class="form-control dx w-60 p-0 text-center"
                                                                            value="${obxValues.duplo_dx || ''}" />
                                                                    ` : `
                                                                        <select name="duplo_dx[${uniqueID}]" class="form-select dx w-60 p-0">
                                                                        <option value="" selected hidden>Pilih...</option>
                                                                            ${param.opsi_output
                                                                                ? param.opsi_output.split(';').map(opt => `
                                                                                    <option value="${opt.trim()}"
                                                                                        ${obxValues.duplo_dx === opt.trim() ? 'selected' : ''}>
                                                                                        ${opt.trim()}
                                                                                    </option>
                                                                                `).join('')
                                                                                : '<option value="">Pilih...</option>'
                                                                            }
                                                                        </select>
                                                                    `}

                                                                    <input type="hidden" name="is_switched[${uniqueID}]" value="${Number(obxValues.switched) === 1 ? 1 : 0}">

                                                                    ${obxValues.switched ? `
                                                                        <div class='checkbox-r-container d-flex align-items-center gap-1'>
                                                                            <input type='checkbox' class='checkbox-r form-check-input' checked disabled>
                                                                            <span class='text-danger fw-bold'>R</span>
                                                                        </div>
                                                                    ` : ''}
                                                                </div>
                                                            </td>

                                                            <td class="col-2 duplo d1-column text-center" style="display: none;">
                                                                ${param.tipe_inputan === 'Text' ? `
                                                                    <input type="text" name="duplo_d1[${uniqueID}]" class="form-control d1 w-60 p-0 text-center" disabled value="${obxValues.duplo_d1 || ''}" />
                                                                ` : `
                                                                    <select name="duplo_d1[${uniqueID}]" class="form-select d1 w-60 p-0" disabled>
                                                                    <option value="" selected hidden>Pilih...</option>
                                                                        ${param.opsi_output ? param.opsi_output.split(';').map(opt => `
                                                                            <option value="${opt.trim()}" ${obxValues.duplo_d1 === opt.trim() ? 'selected' : ''}>${opt.trim()}</option>
                                                                        `).join('') : '<option value="">Pilih...</option>'}
                                                                    </select>
                                                                `}
                                                            </td>
                                                            <td class="col-2 duplo d2-column" style="display: none;">
                                                                ${param.tipe_inputan === 'Text' ? `
                                                                    <input type="text" name="duplo_d2[${uniqueID}]" class="form-control d2 w-60 p-0 text-center" disabled value="${obxValues.duplo_d2 || ''}" />
                                                                ` : `
                                                                    <select name="duplo_d2[${uniqueID}]" class="form-select d2 w-60 p-0" disabled>
                                                                    <option value="" selected hidden>Pilih...</option>
                                                                        ${param.opsi_output ? param.opsi_output.split(';').map(opt => `
                                                                            <option value="${opt.trim()}" ${obxValues.duplo_d2 === opt.trim() ? 'selected' : ''}>${opt.trim()}</option>
                                                                        `).join('') : '<option value="">Pilih...</option>'}
                                                                    </select>
                                                                `}
                                                            </td>
                                                            <td class="col-2 duplo d3-column" style="display: none;">
                                                                ${param.tipe_inputan === 'Text' ? `
                                                                    <input type="text" name="duplo_d3[${uniqueID}]" class="form-control d3 w-50 p-0 text-center" disabled value="${obxValues.duplo_d3 || ''}" />
                                                                ` : `
                                                                    <select name="duplo_d3[${uniqueID}]" class="form-select d3 w-50 p-0" disabled>
                                                                    <option value="" selected hidden>Pilih...</option>
                                                                        ${param.opsi_output ? param.opsi_output.split(';').map(opt => `
                                                                            <option value="${opt.trim()}" ${obxValues.duplo_d3 === opt.trim() ? 'selected' : ''}>${opt.trim()}</option>
                                                                        `).join('') : '<option value="">Pilih...</option>'}
                                                                    </select>
                                                                `}
                                                            </td>
                                                            <td class="col-3 flag-cell">
                                                                ${obxValues.switched ? `
                                                                    <div class='checkbox-r-container d-flex align-items-center gap-1'>
                                                                        <input type='checkbox' class='checkbox-r form-check-input' checked disabled>
                                                                        <span class='text-danger fw-bold'>R</span>
                                                                        <select name="flag_dx[${uniqueID}]" class="form-select form-select-sm flag-dx-select" style="width: 100px;">
                                                                            <option value="Normal" ${(obxValues.flag_dx || 'Normal') === 'Normal' ? 'selected' : ''}>Normal</option>
                                                                            <option value="Low" ${obxValues.flag_dx === 'Low' ? 'selected' : ''}>Low</option>
                                                                            <option value="Low*" ${obxValues.flag_dx === 'Low*' ? 'selected' : ''}>Low*</option>
                                                                            <option value="High" ${obxValues.flag_dx === 'High' ? 'selected' : ''}>High</option>
                                                                            <option value="High*" ${obxValues.flag_dx === 'High*' ? 'selected' : ''}>High*</option>
                                                                        </select>
                                                                    </div>
                                                                ` : `
                                                                `}    
                                                            </td>
                                                            
                                                            <td>
                                                                ${param.satuan || ''}
                                                            </td>
                                                        </tr>
                                                    `;
                                                }).join('');
                                            }

                                            return html;
                                        } else if (hasFeses) {
                                const fesesPemeriksaan = e.pasiens.find(p =>
                                    p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('feses')
                                );
                                const judulFeses = 'Feses';
                                const namaPemeriksaanFeses = fesesPemeriksaan 
                                    ? fesesPemeriksaan.data_pemeriksaan.nama_pemeriksaan 
                                    : 'Pemeriksaan Feses';

                                let html = `
                                    <tr class="feses-title-header">
                                        <td colspan="8" class="fw-bold text-secondary ps-3"
                                            style="background-color: #f8f9fa; border-left: 4px solid #ffc107; padding: 10px;">
                                            ${judulFeses}
                                        </td>
                                    </tr>
                                `;

                                html += FesesParams.map((param, paramIdx) => {
                                    const obxValues = getDataValues(param.nama); // ambil hasil dari backend
                                    const rowId = `feses_${idx}_${paramIdx}`;
                                    const label = param.display_name || param.nama || '-';
                                    const uniqueID = generateParameterUID('Feses', param.nama, paramIdx);

                                    const renderField = (name, value, className = '') => {
                                        if (param.tipe_inputan === 'Dropdown') {
                                            return `
                                                <select name="${name}[${uniqueID}]" class="form-select ${className} w-60 p-0">
                                                    <option value="" hidden>Pilih...</option>
                                                    ${param.opsi_output.split(';').map(opt => `
                                                        <option value="${opt.trim()}" ${value === opt.trim() ? 'selected' : ''}>${opt.trim()}</option>
                                                    `).join('')}
                                                </select>
                                            `;
                                        } else {
                                            return `
                                                <input type="text" name="${name}[${uniqueID}]" 
                                                    class="form-control ${className} w-60 p-0 text-center" 
                                                     value="${value || ''}" />
                                            `;
                                        }
                                    };

                                    return `
                                        <tr data-id="${rowId}" data-parameter="${param.nama}" data-uid="${uniqueID}" class="feses-row">
                                            <!-- Nama parameter -->
                                            <td class="col-2 ps-4">
                                                <strong>${label}</strong>
                                                ${param.nilai_rujukan ? `<small class="text-muted d-block">${param.nilai_rujukan}</small>` : ''}
                                                <input type="hidden" name="uid[${uniqueID}]" value="${obxValues.uid}" />
                                                <input type="hidden" name="nama_pemeriksaan[${uniqueID}]" value="${param.nama}" />
                                                <input type="hidden" name="judul[${uniqueID}]" value="${judulFeses}" />
                                                <input type="hidden" name="parameter_name[${uniqueID}]" value="${param.nama}" />
                                                <input type="hidden" name="nilai_rujukan[${uniqueID}]" value="${param.nilai_rujukan}" />
                                                <input type="hidden" name="department[${uniqueID}]" value="${e.data_departement.nama_department}" />
                                            </td>

                                            <!-- Hasil utama -->
                                            <td class="col-2 text-center">
                                                <div class="d-flex align-items-center justify-content-center gap-1">
                                                    ${renderField('hasil', obxValues.hasilUtama || param.default, 'manualInput')}
                                                </div>
                                            </td>

                                            <!-- Tombol switch -->
                                            <td class="col-1">
                                                <button type="button" class="btn btn-outline-secondary btn-sm switch-btn" 
                                                        data-index="${paramIdx}" data-switch-index="0">
                                                    <i class="ti ti-switch-2"></i>
                                                </button>
                                            </td>

                                            <!-- Duplo DX -->
                                            <td class="col-2 text-center">
                                                <div class="d-flex align-items-center justify-content-center gap-1">
                                                    ${renderField('duplo_dx', obxValues.duplo_dx, 'dx')}
                                                    <input type="hidden" name="is_switched[${uniqueID}]" value="${Number(obxValues.switched) === 1 ? 1 : 0}">
                                                    ${obxValues.switched ? `
                                                        <div class='checkbox-r-container d-flex align-items-center gap-1'>
                                                            <input type='checkbox' class='checkbox-r form-check-input' checked disabled>
                                                            <span class='text-danger fw-bold'>R</span>
                                                        </div>
                                                    ` : ''}
                                                </div>
                                            </td>

                                            <!-- Duplo D1 -->
                                            <td class="col-2 duplo d1-column text-center" style="display:none;">
                                                ${renderField('duplo_d1', obxValues.duplo_d1, 'd1')}
                                            </td>

                                            <!-- Duplo D2 -->
                                            <td class="col-2 duplo d2-column text-center" style="display:none;">
                                                ${renderField('duplo_d2', obxValues.duplo_d2, 'd2')}
                                            </td>

                                            <!-- Duplo D3 -->
                                            <td class="col-2 duplo d3-column text-center" style="display:none;">
                                                ${renderField('duplo_d3', obxValues.duplo_d3, 'd3')}
                                            </td>

                                            <!-- Flag -->
                                            <td class="col-3 flag-cell">
                                                ${obxValues.switched ? `
                                                <div class='checkbox-r-container d-flex align-items-center gap-1'>
                                                    <input type='checkbox' class='checkbox-r form-check-input' checked disabled>
                                                    <span class='text-danger fw-bold'>R</span>
                                                    <select name="flag_dx[${uniqueID}]" class="form-select form-select-sm flag-dx-select" style="width: 100px;">
                                                        <option value="Normal" ${(obxValues.flag_dx || 'Normal') === 'Normal' ? 'selected' : ''}>Normal</option>
                                                        <option value="Low" ${obxValues.flag_dx === 'Low' ? 'selected' : ''}>Low</option>
                                                        <option value="Low*" ${obxValues.flag_dx === 'Low*' ? 'selected' : ''}>Low*</option>
                                                        <option value="High" ${obxValues.flag_dx === 'High' ? 'selected' : ''}>High</option>
                                                        <option value="High*" ${obxValues.flag_dx === 'High*' ? 'selected' : ''}>High*</option>
                                                    </select>
                                                </div>
                                            ` : `
                                            `}    
                                            </td>

                                            

                                            <!-- Satuan -->
                                            <td>
                                                ${param.satuan || ''}
                                            </td>
                                        </tr>
                                    `;
                                }).join('');

                                return html;
                            } else if (hasDengue || hasNS1 || hasTifoid) {
                                let html = '';

                                if (hasDengue) {
                                    html += renderSerologiSection({
                                        e,
                                        idx,
                                        flag: hasDengue,
                                        params: DengueParams,
                                        judul: 'Dengue_IgG/IgM',
                                        warna: '#dc3545', // merah
                                        defaultName: 'Dengue IgG/IgM'
                                    });
                                }

                                if (hasNS1) {
                                    html += renderSerologiSection({
                                        e,
                                        idx,
                                        flag: hasNS1,
                                        params: NS1Params,
                                        judul: 'Dengue_NS1',
                                        warna: '#17a2b8', // biru
                                        defaultName: 'Dengue NS1'
                                    });
                                }

                                if (hasTifoid) {
                                    html += renderSerologiSection({
                                        e,
                                        idx,
                                        flag: hasTifoid,
                                        params: TifoidParams,
                                        judul: 'Typhoid_IgG/IgM',
                                        warna: '#28a745', // hijau
                                        defaultName: 'Tifoid IgG/IgM'
                                    });
                                }

                                return html;
                            } else {
                            // Pemeriksaan individual / lainnya
                            function getNilaiRujukanDisplay(nilaiRujukan, jenisKelamin) {
                                if (!nilaiRujukan) return '';
                                const parts = nilaiRujukan.split(' ');
                                let prefix = jenisKelamin.toLowerCase().startsWith('l') ? 'L.' : 'P.';
                                let match = parts.find(part => part.startsWith(prefix));
                                return match ? match.replace(prefix, '') : '';
                            }

                            let html = '';
                            let lastJudul = null;

                            e.pasiens.forEach((p, pIdx) => {
                                const judul = p.data_pemeriksaan?.judul;

                                if (judul && judul !== p.data_pemeriksaan.nama_pemeriksaan && judul !== lastJudul) {
                                    html += `
                                        <tr class="individual-title-header">
                                            <td colspan="8" class="fw-bold text-dark ps-3" style="background-color: #f1f3f4; border-left: 4px solid #6c757d; padding: 10px;">
                                                ${judul}
                                            </td>
                                        </tr>
                                    `;
                                    lastJudul = judul; 
                                }

                                const obxValues = getDataValues(p.data_pemeriksaan.nama_parameter);
                                const rowId = p.data_pemeriksaan.id;

                                const initialFlag = renderFlag(
                                    obxValues.hasilUtama,
                                    p.data_pemeriksaan.nama_parameter,
                                    false,
                                    false,
                                    p.data_pemeriksaan.nilai_rujukan,
                                    data_pasien.jenis_kelamin
                                );

                                // Nilai rujukan ditampilkan (kalau ada)
                                const nilaiRujukanDisplay = getNilaiRujukanDisplay(
                                    p.data_pemeriksaan.nilai_rujukan,
                                    data_pasien.jenis_kelamin
                                );

                                const uniqueID = generateParameterUID(
                                    p.data_pemeriksaan.nama_pemeriksaan, 
                                    p.data_pemeriksaan.nama_parameter, 
                                    pIdx
                                );

                                html += `
                                    <tr data-id="${rowId}" data-parameter="${p.data_pemeriksaan.nama_parameter}" data-uid="${uniqueID}">
                                        <td class="col-2 ${lastJudul ? 'ps-4' : ''}" ${lastJudul ? 'style="border-left:2px solid #e9ecef;"' : ''}>
                                            <strong>${lastJudul ? p.data_pemeriksaan.nama_parameter : p.data_pemeriksaan.nama_pemeriksaan}</strong>
                                            ${nilaiRujukanDisplay ? `<br><small class="text-muted">${nilaiRujukanDisplay}</small>` : ''}
                                            <input type="hidden" name="uid[${uniqueID}]" value="${obxValues.uid}" />
                                            <input type="hidden" name="nama_pemeriksaan[${uniqueID}]" value="${p.data_pemeriksaan.nama_pemeriksaan}" />
                                            <input type="hidden" name="judul[${uniqueID}]" value="${judul || ''}" />
                                            <input type="hidden" name="parameter_name[${uniqueID}]" value="${p.data_pemeriksaan.nama_parameter}" />
                                            <input type="hidden" name="nilai_rujukan[${uniqueID}]" value="${p.data_pemeriksaan.nilai_rujukan || ''}" />
                                            <input type="hidden" name="department[${uniqueID}]" value="${e.data_departement.nama_department}" />
                                        </td>

                                        <!-- Kolom hasil utama -->
                                        <td class="col-2">
                                            ${p.data_pemeriksaan.tipe_inputan === 'Dropdown' ? `
                                                <select name="hasil[${uniqueID}]" class="form-select manualInput w-60 p-0" disabled>
                                                    ${p.data_pemeriksaan.opsi_output.split(';').map(opt => `
                                                        <option value="${opt.trim()}" ${obxValues.hasilUtama === opt.trim() ? 'selected' : ''}>
                                                            ${opt.trim()}
                                                        </option>
                                                    `).join('')}
                                                </select>
                                            ` : `
                                                <input type="text" name="hasil[${uniqueID}]" 
                                                    class="form-control manualInput w-60 p-0 text-center" 
                                                    value="${obxValues.hasilUtama || ''}"  />
                                            `}
                                        </td>

                                        <!-- Tombol switch -->
                                        <td class="col-1">
                                            <button type="button" class="btn btn-outline-secondary btn-sm switch-btn"
                                                data-index="${pIdx}" data-switch-index="0">
                                                <i class="ti ti-switch-2"></i>
                                            </button>
                                        </td>

                                        <td class="col-2 text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-1">
                                                ${p.data_pemeriksaan.tipe_inputan === 'Dropdown' ? `
                                                    <select name="duplo_dx[${uniqueID}]" class="form-select dx w-60 p-0">
                                                    <option value="" selected hidden>Pilih...</option>
                                                        ${p.data_pemeriksaan.opsi_output
                                                            ? p.data_pemeriksaan.opsi_output.split(';').map(opt => `
                                                                <option value="${opt.trim()}" ${obxValues.duplo_dx === opt.trim() ? 'selected' : ''}>
                                                                    ${opt.trim()}
                                                                </option>
                                                            `).join('')
                                                            : '<option value="">Pilih...</option>'
                                                        }
                                                    </select>
                                                ` : `
                                                    <input type="text" 
                                                        name="duplo_dx[${uniqueID}]" 
                                                        class="form-control dx w-60 p-0 text-center"
                                                        value="${obxValues.duplo_dx || ''}" />
                                                `}

                                                <!-- Hidden input untuk kirim status switch -->
                                                <input type="hidden" name="is_switched[${uniqueID}]" value="${Number(obxValues.switched) === 1 ? 1 : 0}">

                                                <!-- Jika sudah di-switch, tampilkan checkbox R -->
                                                ${obxValues.switched ? `
                                                    <div class='checkbox-r-container d-flex align-items-center gap-1'>
                                                        <input type='checkbox' class='checkbox-r form-check-input' checked disabled>
                                                        <span class='text-danger fw-bold'>R</span>
                                                    </div>
                                                ` : ''}
                                            </div>
                                        </td>

                                        <!-- Duplo D1 -->
                                        <td class="col-2 duplo d1-column text-center" style="display:none;">
                                            ${p.data_pemeriksaan.tipe_inputan === 'Dropdown' ? `
                                                <select name="duplo_d1[${uniqueID}]" class="form-select d1 w-60 p-0" disabled>
                                                     <option value="" selected hidden>Pilih...</option>
                                                    ${p.data_pemeriksaan.opsi_output.split(';').map(opt => `
                                                        <option value="${opt.trim()}" ${obxValues.duplo_d1 === opt.trim() ? 'selected' : ''}>
                                                            ${opt.trim()}
                                                        </option>
                                                    `).join('')}
                                                </select>
                                            ` : `
                                                <input type="text" name="duplo_d1[${uniqueID}]" 
                                                    class="form-control d1 w-60 p-0 text-center" 
                                                    value="${obxValues.duplo_d1 || ''}" disabled />
                                            `}
                                        </td>

                                        <!-- Duplo D2 -->
                                        <td class="col-2 duplo d2-column text-center" style="display:none;">
                                            ${p.data_pemeriksaan.tipe_inputan === 'Dropdown' ? `
                                                <select name="duplo_d2[${uniqueID}]" class="form-select d2 w-60 p-0" disabled>
                                                     <option value="" selected hidden>Pilih...</option>
                                                    ${p.data_pemeriksaan.opsi_output.split(';').map(opt => `
                                                        <option value="${opt.trim()}" ${obxValues.duplo_d2 === opt.trim() ? 'selected' : ''}>
                                                            ${opt.trim()}
                                                        </option>
                                                    `).join('')}
                                                </select>
                                            ` : `
                                                <input type="text" name="duplo_d2[${uniqueID}]" 
                                                    class="form-control d2 w-60 p-0 text-center" 
                                                    value="${obxValues.duplo_d2 || ''}" disabled />
                                            `}
                                        </td>

                                        <!-- Duplo D3 -->
                                        <td class="col-2 duplo d3-column text-center" style="display:none;">
                                            ${p.data_pemeriksaan.tipe_inputan === 'Dropdown' ? `
                                                <select name="duplo_d3[${uniqueID}]" class="form-select d3 w-50 p-0" disabled>
                                                     <option value="" selected hidden>Pilih...</option>
                                                    ${p.data_pemeriksaan.opsi_output.split(';').map(opt => `
                                                        <option value="${opt.trim()}" ${obxValues.duplo_d3 === opt.trim() ? 'selected' : ''}>
                                                            ${opt.trim()}
                                                        </option>
                                                    `).join('')}
                                                </select>
                                            ` : `
                                                <input type="text" name="duplo_d3[${uniqueID}]" 
                                                    class="form-control d3 w-50 p-0 text-center" 
                                                    value="${obxValues.duplo_d3 || ''}" disabled />
                                            `}
                                        </td>

                                        <!-- Flag -->
                                        <td class="col-3 flag-cell">
                                        ${renderFlag(obxValues.flag || renderFlag(obxValues.hasilUtama, {innerHTML: ''}, p.data_pemeriksaan.nama_parameter))}
                                            ${obxValues.switched ? `
                                                <div class='checkbox-r-container d-flex align-items-center gap-1'>
                                                    <input type='checkbox' class='checkbox-r form-check-input' checked disabled>
                                                    <span class='text-danger fw-bold'>R</span>
                                                    <select name="flag_dx[${uniqueID}]" class="form-select form-select-sm flag-dx-select" style="width: 100px;">
                                                        <option value="Normal" ${(obxValues.flag_dx || 'Normal') === 'Normal' ? 'selected' : ''}>Normal</option>
                                                        <option value="Low" ${obxValues.flag_dx === 'Low' ? 'selected' : ''}>Low</option>
                                                        <option value="Low*" ${obxValues.flag_dx === 'Low*' ? 'selected' : ''}>Low*</option>
                                                        <option value="High" ${obxValues.flag_dx === 'High' ? 'selected' : ''}>High</option>
                                                        <option value="High*" ${obxValues.flag_dx === 'High*' ? 'selected' : ''}>High*</option>
                                                    </select>
                                                </div>
                                            ` : `
                                            <input type="hidden" name="flag_dx[${uniqueID}]" value="">
                                            `}
                                        </td>


                                        <!-- Satuan -->
                                        <td>
                                            ${p.data_pemeriksaan.nilai_satuan || ''}
                                        </td>
                                    </tr>
                                `;
                            });

                            return html;
                        }
                                        })()}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                `).join('')}
            </div>
        </div>
        </form>
         ${noteValue ? `
            <div class="col-lg-12">
                <label class="fw-bold mt-2">Catatan</label>
                <textarea class="form-control" rows="3" disabled>${noteValue}</textarea>
            </div>
        ` : ''}
         ${kesimpulanValue ? `
        <div class="col-lg-12">
            <label class="fw-bold mt-2">Kesimpulan</label>
            <textarea class="form-control" rows="3" disabled>${kesimpulanValue}</textarea>
        </div>
    ` : ''}

    ${saranValue ? `
        <div class="col-lg-12">
            <label class="fw-bold mt-2">Saran</label>
            <textarea class="form-control" rows="3" disabled>${saranValue}</textarea>
        </div>
    ` : ''}
        
    
    <style>
        .hematologi-row {
            background-color: #f8f9ff;
        }
        .hematologi-row:hover {
            background-color: #e9ecff;
        }
        .widal-row {
            background-color: #fff8e1;
        }
        .widal-row:hover {
            background-color: #fff3c4;
        }
        .urine-row {
            background-color: #f0f8f0;
        }
        .urine-row:hover {
            background-color: #e8f5e8;
        }
        .text-success {
            color: #28a745 !important;
        }
        .hematologi-row small.text-muted,
        .widal-row small.text-muted,
        .urine-row small.text-muted {
            font-size: 0.75rem;
            margin-top: 2px;
        }
        .form-control[readonly] {
            background-color: #f8f9fa;
            opacity: 1;
        }
            .flag-dx-select {
        width: 100px !important;
        padding: 2px 8px;
        font-size: 0.875rem;
    }
    
    .checkbox-r-container {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .flag-cell {
        vertical-align: middle;
    }
    
    .flag-cell .d-flex {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .flag-icon {
        min-width: 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    </style>
    `;

    setTimeout(() => {
    // Referensi elemen-elemen yang diperlukan
    const kembalikanBtn = document.getElementById('kembalikanBtn');
    const releaseBtn = document.getElementById('releaseBtn');
    const masterSwitchAllBtn = document.getElementById('masterSwitchAllBtn');
    
    if (masterSwitchAllBtn) {
        masterSwitchAllBtn.addEventListener('click', () => {
            switchAllHasilToDX();
        });
    }

    // Event listener untuk tombol kembalikan
    if (kembalikanBtn) {
        kembalikanBtn.addEventListener('click', () => {
            if (confirm('Apakah Anda yakin ingin mengembalikan hasil ke Analyst?')) {
                // Buat form baru untuk kembalikan
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `worklist/return/${data_pasien.id}`;
                
                // Tambahkan CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                form.appendChild(csrfInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    // Event listener untuk tombol release
    if (releaseBtn) {
        releaseBtn.addEventListener('click', () => {
            if (confirm('Apakah Anda yakin ingin me-release hasil pemeriksaan?')) {
                document.getElementById('worklistForm').action = `worklist/release/${data_pasien.id}`;
                document.getElementById('worklistForm').submit();
            }
        });
    }

    // Simpan nilai hasil asli dari database ke atribut data-original
    document.querySelectorAll('.manualInput').forEach(input => {
        // Ambil nilai dari input dan pastikan ada nilainya
        const currentValue = input.value?.trim() || '';
        if (currentValue !== '' && !input.dataset.original) {
            input.dataset.original = currentValue;
        }
    });

    // ✅ PERBAIKAN: Gunakan uniqueID untuk setiap parameter
    document.querySelectorAll('tr[data-parameter]').forEach(row => {
        const hasilInput = row.querySelector('.manualInput');
        const dxInput = row.querySelector('.dx, input[name^="duplo_dx"]');
        const uniqueID = row.dataset.uid; // Ambil uniqueID dari data attribute
        const hiddenSwitch = row.querySelector(`input[name="is_switched[${uniqueID}]"]`);

        if (!hasilInput || !dxInput || !hiddenSwitch || !uniqueID) {
            console.log('Element tidak ditemukan untuk row:', row.dataset.parameter);
            return;
        }

        // Pastikan data original tersimpan
        if (!hasilInput.dataset.original && hasilInput.value?.trim()) {
            hasilInput.dataset.original = hasilInput.value.trim();
        }

        console.log('Checking parameter:', row.dataset.parameter, 'uniqueID:', uniqueID, 'is_switched value:', hiddenSwitch.value);

        // PERBAIKAN: Cek berdasarkan nilai is_switched dari database
        if (Number(hiddenSwitch.value) === 1) {
            // Jika is_switched = 1, berarti sudah di-switch
            // Tampilkan checkbox R di kolom DX
            const existingCheckbox = dxInput.parentElement.querySelector('.checkbox-r-container');
            if (!existingCheckbox) {
                addCheckboxR(dxInput, uniqueID);
                console.log('✅ Checkbox R ditampilkan untuk parameter:', row.dataset.parameter, 'uniqueID:', uniqueID);
            } else {
                console.log('Checkbox R sudah ada untuk parameter:', row.dataset.parameter);
            }
        } else {
            // Jika is_switched = 0, pastikan tidak ada checkbox R
            removeCheckboxR(dxInput, uniqueID);
            console.log('❌ Checkbox R dihapus untuk parameter:', row.dataset.parameter);
        }
    });

    // ✅ Event klik tombol switch dengan uniqueID
    document.querySelectorAll('.switch-btn').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const hasilInput = row.querySelector('.manualInput');
            const dxInput = row.querySelector('.dx, input[name^="duplo_dx"]');
            const flagCell = row.querySelector('.flag-cell');
            const parameter = row.dataset.parameter;
            const uniqueID = row.dataset.uid; // Ambil uniqueID dari row
            const originalValue = hasilInput.dataset.original?.trim() || '';
            
            if (!hasilInput || !dxInput || !uniqueID) return;

            // Tukar nilai
            const tempHasil = hasilInput.value;
            hasilInput.value = dxInput.value;
            dxInput.value = tempHasil;

            // Cek apakah nilai asli pindah ke DX
            if (dxInput.value.trim() === originalValue && originalValue !== '') {
                addCheckboxR(dxInput, uniqueID);
                setSwitchStatus(row, 1, uniqueID);
            } else if (hasilInput.value.trim() === originalValue) {
                // Jika nilai asli kembali ke hasil utama
                removeCheckboxR(dxInput, uniqueID);
                setSwitchStatus(row, 0, uniqueID);
            } else {
                // Hilangkan R jika tidak ada nilai asli di DX
                removeCheckboxR(dxInput, uniqueID);
                setSwitchStatus(row, 0, uniqueID);
            }

            // Update flag hasil
            if (flagCell && parameter) {
                updateFlag(hasilInput.value, flagCell, parameter);
            }
        });
    });

    // ✅ Fungsi addCheckboxR dengan uniqueID
    function addCheckboxR(dxInput, uniqueID) {
        // Hapus yang lama jika ada
        removeCheckboxR(dxInput, uniqueID);

        // Pastikan parent element ada
        if (!dxInput.parentElement) return;

        const container = document.createElement('div');
        container.className = 'checkbox-r-container d-flex align-items-center gap-1';
        container.dataset.uid = uniqueID; // Tambahkan uniqueID untuk identifikasi

        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.className = 'checkbox-r form-check-input';
        checkbox.checked = true;
        checkbox.title = 'Nilai asli berpindah ke kolom DX';
        checkbox.disabled = true;

        const label = document.createElement('span');
        label.className = 'text-danger fw-bold';
        label.textContent = 'R';

        container.appendChild(checkbox);
        container.appendChild(label);

        // Tambahkan setelah input DX (dalam parent yang sama)
        dxInput.parentElement.appendChild(container);
        
        // Tambahkan dropdown flag_dx di kolom FLAG dengan uniqueID
        addFlagDxDropdown(dxInput, uniqueID);
        
        console.log('Checkbox R berhasil ditambahkan di kolom DX untuk uniqueID:', uniqueID);
    }

    // ✅ Fungsi untuk menambahkan dropdown flag_dx di kolom FLAG dengan uniqueID
        // Ganti fungsi addFlagDxDropdown lama dengan ini
function addFlagDxDropdown(dxInput, uniqueID) {
    const row = dxInput.closest('tr');
    if (!row) return;
    const flagCell = row.querySelector('.flag-cell');
    if (!flagCell) return;

    // Hapus dropdown lama jika ada (hindari duplikat)
    const existingDropdown = flagCell.querySelector(`.flag-dx-select[data-uid="${uniqueID}"]`);
    if (existingDropdown) existingDropdown.remove();

    // Pastikan ada container
    let flagContainer = flagCell.querySelector('.d-flex');
    if (!flagContainer) {
        flagContainer = document.createElement('div');
        flagContainer.className = 'd-flex align-items-center gap-2';
        // Simpan isi lama (ikon dsb)
        const existingContent = flagCell.innerHTML;
        flagCell.innerHTML = '';
        const iconSpan = document.createElement('span');
        iconSpan.className = 'flag-icon';
        iconSpan.innerHTML = existingContent;
        flagContainer.appendChild(iconSpan);
        flagCell.appendChild(flagContainer);
    }

    // Buat select
    const flagSelect = document.createElement('select');
    flagSelect.className = 'form-select form-select-sm flag-dx-select';
    flagSelect.setAttribute('name', `flag_dx[${uniqueID}]`);
    flagSelect.dataset.uid = uniqueID;
    flagSelect.style.width = '100px';

    const flagOptions = ['Normal', 'Low', 'Low*', 'High', 'High*'];
    flagOptions.forEach(opt => {
        const o = document.createElement('option');
        o.value = opt;
        o.textContent = opt;
        flagSelect.appendChild(o);
    });

    // Pilih default 'Normal' dengan cara yang memastikan browser membaca selected
    flagSelect.value = 'Normal';
    // Pastikan attribute selected juga ada di opsi (untuk kompatibilitas)
    const selOpt = [...flagSelect.options].find(o => o.value === 'Normal');
    if (selOpt) selOpt.selected = true;

    // Append lalu trigger change sehingga FormData/serialize atau listener lain menangkapnya
    flagContainer.appendChild(flagSelect);
    flagSelect.dispatchEvent(new Event('change', { bubbles: true })); // TRIGGER

    console.log('Dropdown flag_dx dibuat untuk uniqueID:', uniqueID);
}



    function removeCheckboxR(dxInput, uniqueID) {
        // Hapus checkbox R dari kolom DX berdasarkan uniqueID
        const dxContainer = dxInput.parentElement?.querySelector(`.checkbox-r-container[data-uid="${uniqueID}"]`);
        if (dxContainer) {
            dxContainer.remove();
            console.log('Checkbox R berhasil dihapus dari kolom DX untuk uniqueID:', uniqueID);
        }
    }

    // ✅ Fungsi untuk menambahkan/ubah input hidden is_switched[] dengan uniqueID
    function setSwitchStatus(row, value, uniqueID) {
        let hidden = row.querySelector(`input[name="is_switched[${uniqueID}]"]`);
        if (!hidden) {
            hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = `is_switched[${uniqueID}]`;
            row.appendChild(hidden);
        }
        hidden.value = value;
        console.log('Set is_switched untuk uniqueID:', uniqueID, 'value:', value);
    }

    function switchAllHasilToDX() {
        // Ambil semua row yang memiliki data parameter
        const allRows = document.querySelectorAll('tr[data-parameter]');
        let switchedCount = 0;
        
        allRows.forEach(row => {
            const hasilInput = row.querySelector('.manualInput'); // Field HASIL
            const dxInput = row.querySelector('.dx, input[name^="duplo_dx"]'); // Field DX
            const flagCell = row.querySelector('.flag-cell');
            const parameter = row.dataset.parameter;

            // Pastikan kedua input ada
            if (hasilInput && dxInput) {
                // Simpan nilai sementara
                const tempHasil = hasilInput.value;
                const tempDx = dxInput.value;
                
                // Tukar nilai
                hasilInput.value = tempDx;
                dxInput.value = tempHasil;
                
                // Update flag berdasarkan nilai baru di HASIL
                if (flagCell && parameter) {
                    updateFlag(hasilInput.value, flagCell, parameter);
                }
                
                switchedCount++;
            }
        });
        
        console.log(`Switched ${switchedCount} parameters between HASIL and DX`);
        
        // Visual feedback pada button
        provideSwitchFeedback();
    }

    function provideSwitchFeedback() {
        const button = masterSwitchAllBtn;
        const icon = button.querySelector('i');
        
        // Animasi feedback
        button.classList.add('btn-success');
        button.classList.remove('btn-outline-primary');
        icon.className = 'ti ti-check';
        
        // Reset setelah 1 detik
        setTimeout(() => {
            button.classList.remove('btn-success');
            button.classList.add('btn-outline-primary');
            icon.className = 'ti ti-arrows-exchange';
        }, 1000);
    }

    // Update function menggunakan form submit seperti worklist.store (tanpa parameter_name)
    document.querySelector('#resultReviewModal .update-btn').addEventListener('click', function () {
        // SweetAlert konfirmasi sebelum update dengan z-index tinggi
        Swal.fire({
            title: 'Konfirmasi Update',
            text: 'Apakah Anda yakin ingin mengupdate hasil pemeriksaan?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Update!',
            cancelButtonText: 'Batal',
            customClass: {
                container: 'swal-high-z-index'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('worklistForm');
                
                // Show loading alert
                Swal.fire({
                    title: 'Sedang memproses...',
                    text: 'Mohon tunggu, data sedang diupdate',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Enable semua input yang disabled agar nilainya bisa terkirim
                const disabledInputs = form.querySelectorAll('input[disabled], select[disabled], textarea[disabled]');
                disabledInputs.forEach(input => {
                    input.removeAttribute('disabled');
                });
                
                // Ubah action form ke route update
                const noLab = form.querySelector('input[name="no_lab"]').value;
                form.action = `/analyst/worklist/update-hasil/${noLab}`;
                
                // Ubah method form ke POST (jika belum)
                form.method = 'POST';
                
                // Submit form seperti worklist.store
                form.submit();
            }
        });
    });
}, 0);


    return content;
}

// Export fungsi jika diperlukan
window.getResultTableContent = getResultTableContent;
    
       function checkAndShowDuploColumns() {
    const accordion = document.getElementById('accordionPemeriksaan');
    if (!accordion) {
        console.log('Accordion not found');
        return;
    }

    const d1Cells = accordion.querySelectorAll('.d1-column');
    const d2Cells = accordion.querySelectorAll('.d2-column');
    const d3Cells = accordion.querySelectorAll('.d3-column');

    console.log('Found duplo cells:', {
        d1: d1Cells.length,
        d2: d2Cells.length,
        d3: d3Cells.length
    });

    let hasD1 = false;
    let hasD2 = false;
    let hasD3 = false;

    // === CEK D1 ===
    const d1Elements = accordion.querySelectorAll('input.d1, select.d1');
    console.log('D1 elements found:', d1Elements.length);

    d1Elements.forEach(element => {
        let value = '';

        // Ambil nilai asli dari database, bukan default select
        if (element.tagName === 'SELECT') {
            const selectedOption = element.querySelector('option[selected]');
            value = selectedOption ? selectedOption.value.trim() : '';
        } else {
            value = element.value ? element.value.trim() : '';
        }

        console.log('Checking D1 element:', {
            tag: element.tagName,
            value: value,
            disabled: element.disabled
        });

        if (value && !['0', '0.00', 'null', 'pilih...', ''].includes(value.toLowerCase())) {
            hasD1 = true;
            // console.log('✓ Found valid D1 data:', value);
        }
    });

    // === CEK D2 ===
    const d2Elements = accordion.querySelectorAll('input.d2, select.d2');
    // console.log('D2 elements found:', d2Elements.length);

    d2Elements.forEach(element => {
        let value = '';

        if (element.tagName === 'SELECT') {
            const selectedOption = element.querySelector('option[selected]');
            value = selectedOption ? selectedOption.value.trim() : '';
        } else {
            value = element.value ? element.value.trim() : '';
        }

        console.log('Checking D2 element:', {
            tag: element.tagName,
            value: value,
            disabled: element.disabled
        });

        if (value && !['0', '0.00', 'null', 'pilih...', ''].includes(value.toLowerCase())) {
            hasD2 = true;
            // console.log('✓ Found valid D2 data:', value);
        }
    });

    // === CEK D3 ===
    const d3Elements = accordion.querySelectorAll('input.d3, select.d3');
    console.log('D3 elements found:', d3Elements.length);

    d3Elements.forEach(element => {
        let value = '';

        if (element.tagName === 'SELECT') {
            const selectedOption = element.querySelector('option[selected]');
            value = selectedOption ? selectedOption.value.trim() : '';
        } else {
            value = element.value ? element.value.trim() : '';
        }

        console.log('Checking D3 element:', {
            tag: element.tagName,
            value: value,
            disabled: element.disabled
        });

        if (value && !['0', '0.00', 'null', 'pilih...', ''].includes(value.toLowerCase())) {
            hasD3 = true;
            // console.log('✓ Found valid D3 data:', value);
        }
    });

    console.log('Final duplo status:', { hasD1, hasD2, hasD3 });

    // === SHOW / HIDE D1 ===
    if (hasD1) {
        d1Cells.forEach(cell => {
            cell.style.display = 'table-cell';
            cell.style.backgroundColor = '#e3f2fd';
            cell.querySelectorAll('input[disabled], select[disabled]').forEach(el => {
                el.style.opacity = '1';
                el.style.cursor = 'not-allowed';
            });
        });
        console.log('✓ D1 columns shown');
    } else {
        d1Cells.forEach(cell => (cell.style.display = 'none'));
        // console.log('✗ D1 columns hidden');
    }

    // === SHOW / HIDE D2 ===
    if (hasD2) {
        d2Cells.forEach(cell => {
            cell.style.display = 'table-cell';
            cell.style.backgroundColor = '#f3e5f5';
            cell.querySelectorAll('input[disabled], select[disabled]').forEach(el => {
                el.style.opacity = '1';
                el.style.cursor = 'not-allowed';
            });
        });
        // console.log('✓ D2 columns shown');
    } else {
        d2Cells.forEach(cell => (cell.style.display = 'none'));
        // console.log('✗ D2 columns hidden');
    }

    // === SHOW / HIDE D3 ===
    if (hasD3) {
        d3Cells.forEach(cell => {
            cell.style.display = 'table-cell';
            cell.style.backgroundColor = '#e8f5e8';
            cell.querySelectorAll('input[disabled], select[disabled]').forEach(el => {
                el.style.opacity = '1';
                el.style.cursor = 'not-allowed';
            });
        });
        // console.log('✓ D3 columns shown');
    } else {
        d3Cells.forEach(cell => (cell.style.display = 'none'));
        // console.log('✗ D3 columns hidden');
    }
}

});
</script>



<script>
   // Ambil semua elemen dengan class 'editBtn'
var editBtns = document.querySelectorAll('.editBtn');

editBtns.forEach(function(editBtn) {
    editBtn.addEventListener('click', function(e) {
        e.preventDefault();
        var no_lab = this.getAttribute('data-id');
        var editUrl = "{{ route('pasien.edit', ':no_lab') }}".replace(':no_lab', no_lab);
        window.location.href = editUrl; // langsung redirect
    });
});


</script>

<script>
 function formatToDatetimeLocal(dateStr) {
    if (!dateStr) return '';
    const d = new Date(dateStr);
    const pad = (n) => String(n).padStart(2, '0');
    return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
}

// Klik tombol Edit Time
$(document).on('click', '.EditClock', function (e) {
    e.preventDefault();
    const id = $(this).data('id');
    $('#edit_id').val(id);

    // Ambil data dari API - sesuaikan dengan route controller Anda
    fetch(`/api/get-data-pasien/${id}`)
        .then(res => res.json())
        .then(response => {
            if (response.status === 'success') {
                const data = response.data;
                $('#edit_no_lab').val(data.no_lab);
                $('#edit-asd').val(formatToDatetimeLocal(data.tanggal_masuk));
                $('#edit-asp').val(formatToDatetimeLocal(data.created_at));
                $('#edit-asu').val(formatToDatetimeLocal(data.updated_at));
                $('#modalEditTime').modal('show');
            } else {
                Swal.fire('Gagal', 'Tidak dapat mengambil data pasien!', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire('Error', 'Terjadi kesalahan pada server!', 'error');
        });
});

// Klik tombol Simpan
$('#btnSaveEditTime').on('click', function () {
    const id = $('#edit_id').val();
    const tanggal_masuk = $('#edit-asd').val();
    const created_at = $('#edit-asp').val();
    const updated_at = $('#edit-asu').val();

    // Validasi sederhana
    if (!id) {
        Swal.fire('Peringatan', 'ID tidak ditemukan!', 'warning');
        return;
    }

    const payload = { 
        tanggal_masuk, 
        created_at, 
        updated_at 
    };

    fetch(`/api/update-time-by-id/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        body: JSON.stringify(payload)
    })
        .then(res => res.json())
        .then(response => {
            if (response.status === 'success') {
                Swal.fire('Berhasil', 'Waktu berhasil diperbarui!', 'success').then(() => {
                    $('#modalEditTime').modal('hide');
                    // Reload halaman atau refresh data table
                    location.reload(); // atau gunakan cara lain untuk refresh data
                });
            } else {
                Swal.fire('Gagal', response.message || 'Update gagal!', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire('Error', 'Terjadi kesalahan pada server!', 'error');
        });
});
</script>
<script>
$('.preview').on('click', function(event) {
    event.preventDefault();
    const id = this.getAttribute('data-id');
    const previewDataPasien = document.getElementById('previewDataPasien');
    const loader = $('#loader');

    loader.show();

    fetch(`/api/get-data-pasien/${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error("HTTP error " + response.status);
            }
            return response.json();
        })
        .then(res => {
            if (res.status === 'success') {
                const data_pasien = res.data;
                const data_pemeriksaan_pasien = res.data.dpp;
                const history = res.data.history;
                const spesimen = res.data.spesiment;
                const scollection = res.data.spesimentcollection;
                const shandling = res.data.spesimenthandling;
                const hasil = res.data.hasil_pemeriksaan;

                let accordionContent = '';

                // ========== History ==========
                accordionContent += `
                    <h5>History</h5>
                    <ul class="step-wizard-list mt-4">
                        ${history.map((h, index) => {
                            let createdAt = new Date(h.created_at);
                            let formattedDate = createdAt.toLocaleString('id-ID', {
                                year: 'numeric',
                                month: 'numeric',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                            return `
                                <li class="step-wizard-item">
                                    <span class="progress-count">${index + 1}</span>
                                    <span class="progress-label">${h.proses}</span>
                                    <span class="progress-label">${formattedDate}</span>
                                </li>
                            `;
                        }).join('')}
                    </ul>
                `;

                // ========== Spesimen Collection ==========
                let collectionSpecimens = spesimen.filter(e => e.spesiment === "Spesiment Collection");
                if (collectionSpecimens.length > 0) {
                    let collectionHTML = '';
                    collectionSpecimens.forEach(e => {
                        const html = generateAccordionHTML(e, scollection, shandling, "collection");
                        if (html) collectionHTML += html;
                    });
                    
                    // Hanya tampilkan section jika ada tabung yang memiliki data
                    if (collectionHTML) {
                        accordionContent += `<h5 class="title mt-3">Spesiment Collection</h5><hr>`;
                        accordionContent += `<div class="accordion" id="accordionCollection">`;
                        accordionContent += collectionHTML;
                        accordionContent += `</div>`;
                    }
                }

                // ========== Spesimen Handlings ==========
                let handlingSpecimens = spesimen.filter(e => e.spesiment === "Spesiment Handlings");
                if (handlingSpecimens.length > 0) {
                    let handlingHTML = '';
                    handlingSpecimens.forEach(e => {
                        const html = generateAccordionHTML(e, scollection, shandling, "handling");
                        if (html) handlingHTML += html;
                    });
                    
                    // Hanya tampilkan section jika ada tabung yang memiliki data
                    if (handlingHTML) {
                        accordionContent += `<h5 class="title mt-3">Spesiment Handlings</h5><hr>`;
                        accordionContent += `<div class="accordion" id="accordionHandling">`;
                        accordionContent += handlingHTML;
                        accordionContent += `</div>`;
                    }
                }

                // ========== Notes ==========
                const historyItem = history.find(h => h.proses === 'Dikembalikan oleh dokter');
                if (historyItem && historyItem.note) {
                    accordionContent += `
                        <div class="d-flex justify-content-between mt-3">
                            <div class="doctor-note" style="width: 48%;">
                                <label class="fw-bold mt-2">Catatan (Doctor)</label>
                                <textarea class="form-control" rows="3" disabled>${historyItem.note}</textarea>
                            </div>
                            <div class="analyst-note" style="width: 48%;">
                                <label class="fw-bold mt-2">Catatan (Analyst)</label>
                                <textarea class="form-control" rows="3" disabled>${hasil.length > 0 && hasil[0].note ? hasil[0].note : '-'}</textarea>
                            </div>
                        </div>
                    `;
                }

                // render ke modal
                previewDataPasien.innerHTML = accordionContent;
                loader.hide();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            loader.hide();
        });

    // ========== Function generateAccordionHTML ==========
    function generateAccordionHTML(e, scollection, shandling, type) {
        let details = '';
        let hasData = false;
        let noteText = '';
        let kapasitas, serumh, clotact, serum;

        let dataItem = null;

        if (type === "collection") {
            dataItem = scollection.find(item =>
                item.no_lab === e.laravel_through_key &&
                item.tabung === e.tabung &&
                item.kode === e.kode
            );
        } else if (type === "handling") {
            dataItem = shandling.find(item =>
                item.no_lab === e.laravel_through_key &&
                item.tabung === e.tabung &&
                item.kode === e.kode
            );
        }

        // Jika tidak ada data di database, return empty string (tidak tampilkan tabung)
        if (!dataItem) {
            return '';
        }

        hasData  = true;
        noteText = dataItem.note || '';
        kapasitas = dataItem.kapasitas;
        serumh   = dataItem.serumh;
        clotact  = dataItem.clotact;
        serum    = dataItem.serum;

        const uniqId = `${e.tabung}-${e.kode}`.replace(/\s+/g, '');

        if (e.details && e.details.length > 0) {
            details = `<div class="detail-container col-12 col-md-6">`;
            e.details.forEach(detail => {
                const imageUrl = `/gambar/${detail.gambar}`;
                let isChecked = '';
                let isDisabled = 'disabled';

                if (type === "collection") {
                    if (e.tabung === 'K3-EDTA') {
                        isChecked = kapasitas == detail.id ? 'checked' : '';
                    } else if (e.tabung === 'CLOTH-ACTIVATOR') {
                        isChecked = serumh == detail.id ? 'checked' : '';
                    } else if (e.tabung === 'CLOTH-ACT') {
                        isChecked = clotact == detail.id ? 'checked' : '';
                    }
                } else if (type === "handling") {
                    if (e.tabung === 'CLOTH-ACTIVATOR' || e.tabung === 'CLOT-ACTIVATOR') {
                        isChecked = parseInt(serum) === parseInt(detail.id) ? 'checked' : '';
                    }
                }

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

        let noteHTML = '';
        if (type === "handling") {
            noteHTML = `
                <input type="hidden" name="kode[]" value="${e.kode}">
                <p class="mb-0"><strong>Catatan</strong></p>
                <textarea class="form-control" name="note[${e.kode}]" rows="3" disabled>${noteText}</textarea>
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
});
</script>

<script src="{{ asset('../js/ak.js') }}"></script>
@endpush
