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
                  <a href="{{ route('result.report') }}" class="btn btn-primary">Report</a>
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
                      <th scope="col">Status</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                        @foreach ( $dataPasien as $x => $dpc )
                            <tr>
                                <th class="text-center" scope="row">{{ $x + 1 }}</th>
                                <td>
                                    @foreach ($dataHistory as $dh)
                                    @if ($dh->no_lab == $dpc->no_lab)
                                    {{ date('d-m-Y', strtotime($dh->waktu_proses)) }}/{{ date('H:i', strtotime($dh->waktu_proses)) }}
                                    @endif
                                    @endforeach
                                </td>
                                <td class="text-center">{{ $dpc->no_rm }}</td>
                                <td>{{ $dpc->no_lab }}</td>
                                <td>{{ $dpc->nama }}</td>
                                <td>{{ $dpc->asal_ruangan }}</td>
                                <td>
                                    <i class='ti ti-bell-filled {{ $dpc->cito == '1' ? 'text-danger' : 'text-secondary' }}' style="font-size: 23px;"></i>
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($dpc->lahir)->age }} Tahun
                                </td>
                                <td>{{ $dpc->alamat }}</td>
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
                                                <button type="button" 
                                                        class="dropdown-item editBtn" 
                                                        data-id="{{ $dpc->no_lab }}">
                                                    <i class="ti ti-pencil me-2"></i> Edit
                                                </button>
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
                                           @hasanyrole('superadmin|dokter')
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
                        console.log('API Response:', res);
                        console.log('Hasil Pemeriksaan:', res.data.hasil_pemeriksaan);
                        
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

    // Tambahkan parameter Widal
    const WidalParams = [
        {
            nama: 'Salmonella Typhi H',
            display_name: 'Salmonella Typhi H',
            satuan: '-',
            normal_min: '-',
            normal_max: '-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Negatif;1/80;1/160;1/320;1/640'
        },
        {
            nama: 'Salmonella Typhi O',
            display_name: 'Salmonella Typhi O',
            satuan: '-',
            normal_min: '-',
            normal_max: '-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Negatif;1/80;1/160;1/320;1/640'
        },
        {
            nama: 'Salmonella Paratyphi AO',
            display_name: 'Salmonella Paratyphi AO',
            satuan: '-',
            normal_min: '-',
            normal_max: '-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Negatif;1/80;1/160;1/320;1/640'
        },
        {
            nama: 'Salmonella Paratyphi BO',
            display_name: 'Salmonella Paratyphi BO',
            satuan: '-',
            normal_min: '-',
            normal_max: '-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Negatif;1/80;1/160;1/320;1/640'
        }
    ];

    // Tambahkan parameter Urine
    const UrineParams = [
        {
            nama: 'Warna',
            display_name: 'Warna',
            satuan: '-',
            normal_min: '-',
            normal_max: '-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Kuning;Kuning Pucat;Kuning Tua;Kuning kecokelatan;Orange;Merah;Coklat',
            default: 'Kuning'
        },
        {
            nama: 'Kekeruhan',
            display_name: 'Kekeruhan',
            satuan: '-',
            normal_min: '-',
            normal_max: '-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Jernih;Agak Keruh;Keruh;Sangat keruh',
            default: 'Jernih'
        },
        {
            nama: 'Berat Jenis',
            display_name: 'Berat Jenis',
            satuan: '-',
            normal_min: 1.003,
            normal_max: 1.035,
            tipe_inputan: 'Dropdown',
            opsi_output: '<1.005;1.005;1.010;1.015;1.020;1.025;1.030',
            default: '1.015'
        },
        {
            nama: 'PH',
            display_name: 'pH',
            satuan: '-',
            normal_min: 4.5,
            normal_max: 8.0,
            tipe_inputan: 'Dropdown',
            opsi_output: '4.5;5.0;5.5;6.0;6.5;7.0;7.5;8.0;8.5;9.0',
            default: '6.0'
        },
        {
            nama: 'Leukosit',
            display_name: 'Leukosit',
            satuan: '-',
            normal_min: '-',
            normal_max: '-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Negatif;Positif;Positif(+);Positif(++);Positif(+++)',
            default: 'Negatif'
        },
        {
            nama: 'Nitrit',
            display_name: 'Nitrit',
            satuan: '-',
            normal_min: '-',
            normal_max: '-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Negatif;Positif(+);Positif(++);Positif(+++)',
            default: 'Negatif'
        },
        {
            nama: 'Protein',
            display_name: 'Protein',
            satuan: '-',
            normal_min: '-',
            normal_max: '-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Negatif;Positif(+);Positif(++);Positif(+++)',
            default: 'Negatif'
        },
        {
            nama: 'Glukosa',
            display_name: 'Glukosa',
            satuan: '-',
            normal_min: '-',
            normal_max: '-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Negatif;Positif(+);Positif(++);Positif(+++)',
            default: 'Negatif'
        },
        {
            nama: 'Keton',
            display_name: 'Keton',
            satuan: '-',
            normal_min: '-',
            normal_max: '-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Negatif;Positif(+);Positif(++);Positif(+++)',
            default: 'Negatif'
        },
        {
            nama: 'Urobilinogen',
            display_name: 'Urobilinogen',
            satuan: '-',
            normal_min: '-',
            normal_max: '-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Negatif;Positif(+);Positif(++);Positif(+++)',
            default: 'Negatif'
        },
        {
            nama: 'Bilirubin',
            display_name: 'Bilirubin',
            satuan: '-',
            normal_min: '-',
            normal_max: '-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Negatif;Positif(+);Positif(++);Positif(+++)',
            default: 'Negatif'
        },
        {
            nama: 'Blood',
            display_name: 'Blood',
            satuan: '-',
            normal_min: '-',
            normal_max: '-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Negatif;Positif(+);Positif(++);Positif(+++)',
            default: 'Negatif'
        },
        {
            nama: 'Eritrosit',
            display_name: '- Eritrosit',
            satuan: '',
            normal_min: 0,
            normal_max: 2,
            tipe_inputan: 'Text',
            default: 'Negatif'
        },
        {
            nama: 'Leukosit_sedimen',
            display_name: '- Leukosit',
            satuan: '',
            normal_min: 0,
            normal_max: 5,
            tipe_inputan: 'Text',
            default: 'Negatif'
        },
        {
            nama: 'Epithel',
            display_name: '- Epithel',
            satuan: '-',
            normal_min: '-',
            normal_max: '-',
            tipe_inputan: 'Text',
            default: 'Negatif'
        },
        {
            nama: 'Silinder',
            display_name: '- Silinder',
            satuan: '-',
            normal_min: '-',
            normal_max: '-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Negatif;Positif;Positif(+);Positif(++);Positif(+++);Positif(++++)',
            default: 'Negatif'
        },
        {
            nama: 'Kristal',
            display_name: '- Kristal',
            satuan: '-',
            normal_min: '-',
            normal_max: '-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Tidak ada;Asam urat;Kalsium oksalat;Fosfat amorf;Lainnya',
            default: 'Negatif'
        },
        {
            nama: 'Bakteri',
            display_name: '- Bakteri',
            satuan: '-',
            normal_min: '-',
            normal_max: '-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Negatif;Positif;Positif(+);Positif(++);Positif(+++);Positif(++++)',
            default: 'Negatif'
        },
        {
            nama: 'Jamur',
            display_name: '- Jamur',
            satuan: '-',
            normal_min: '-',
            normal_max: '-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Negatif;Positif;Positif(+);Positif(++);Positif(+++)',
            default: 'Negatif'
        },
        {
            nama: 'Lain-lain',
            display_name: '- Lain-lain',
            satuan: '-',
            normal_min: '',
            normal_max: '',
            tipe_inputan: 'Text',
            default: ''
        }
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
                range: item.range || '',
                satuan: item.satuan || '',
                note: item.note || '',
                flag: item.flag || ''
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
                hasilUtama: data.hasil,
                satuan: data.satuan,
                range: data.range,
                flag: data.flag
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
            flag: '' 
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

    function updateFlag(value, flagCell, parameter = null, isHematologi = false, isWidal = false, isUrine = false) {
        const nilaiHasil = parseFloat(value);
        let flagIcon = '';
        
        // Untuk Widal, tidak ada flag karena tidak ada nilai normal/abnormal
        if (isWidal) {
            return '';
        }
        
        if (!isNaN(nilaiHasil)) {
            if (isHematologi && parameter) {
                // range normal untuk parameter hematologi
                const paramData = hematologiParams.find(p => p.nama === parameter);
                if (paramData) {
                    if (nilaiHasil < paramData.normal_min) {
                        flagIcon = `<i class="ti ti-arrow-down text-primary"></i> L`;
                    } else if (nilaiHasil > paramData.normal_max) {
                        flagIcon = `<i class="ti ti-arrow-up text-danger"></i> H`;
                    } else {
                        flagIcon = ``;
                    }
                }
            } else if (isUrine && parameter) {
                // range normal untuk parameter urine (hanya untuk parameter numerik)
                const paramData = UrineParams.find(p => p.nama === parameter);
                if (paramData && typeof paramData.normal_min === 'number' && typeof paramData.normal_max === 'number') {
                    if (nilaiHasil < paramData.normal_min) {
                        flagIcon = `<i class="ti ti-arrow-down text-primary"></i> L`;
                    } else if (nilaiHasil > paramData.normal_max) {
                        flagIcon = `<i class="ti ti-arrow-up text-danger"></i> H`;
                    } else {
                        flagIcon = ``;
                    }
                }
            } else {
                // Flag logic untuk non-hematologi
                if (nilaiHasil < 5) {
                    flagIcon = `<i class="ti ti-arrow-down text-primary"></i>`;
                } else if (nilaiHasil > 10) {
                    flagIcon = `<i class="ti ti-arrow-up text-danger"></i>`;
                }
            }
        }
        if (flagCell && flagCell.innerHTML !== undefined) {
            flagCell.innerHTML = flagIcon;
        }
        return flagIcon;
    }
    function renderFlag(flag) {
        if (!flag) return '';

        if (flag.toLowerCase() === 'normal') {
            return ``;
        }
        if (flag.toLowerCase() === 'high') {
            return `<i class="ti ti-arrow-up text-danger"></i>H`;
        }
        if (flag.toLowerCase() === 'low') {
            return `<i class="ti ti-arrow-down text-primary"></i>L`;
        }
        return flag;
    }

    const labData = data_pasien;
    const dokterData = data_pasien.dokter;
    const isDikembalikan = data_pasien.status === "Dikembalikan";
    const obx = data_pasien.obx;

    // Ambil note dari database jika ada
    const noteValue = hasil.length > 0 && hasil[0].note ? hasil[0].note : '';
    const kesimpulanValue = hasil.length > 0 && hasil[0].kesimpulan ? hasil[0].kesimpulan : '';
    const saranValue = hasil.length > 0 && hasil[0].saran ? hasil[0].saran : '';

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
                                                p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('hematologi')
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
                                            
                                            if (hasHematologi) {
                                                // Jika ada hematologi, tampilkan parameter hematologi lengkap
                                                return hematologiParams.map((param, paramIdx) => {
                                                    // Cari data hasil untuk parameter ini
                                                    const dataValues = getDataValues(param.nama, param.nama);
                                                    const rowId = `hematologi_${idx}_${paramIdx}`;
                                                    const flagContent = updateFlag(dataValues.hasilUtama, {innerHTML: ''}, param.nama, true, false, false);
                                                    
                                                    return `
                                                    <tr data-id="${rowId}" data-parameter="${param.nama}" class="hematologi-row">
                                                        <td class="col-2">
                                                            <strong>${param.display_name}</strong>
                                                            <small class="text-muted d-block">${param.normal_min}-${param.normal_max}</small>
                                                            <input type="hidden" name="nama_pemeriksaan[]" value="${param.nama}" />
                                                            <input type="hidden" name="department[]" value="${e.data_departement.nama_department}" />
                                                        </td>
                                                        <td class="col-2">
                                                            <input type="number" name="hasil[]" 
                                                                class="form-control manualInput w-60 p-0 text-center" 
                                                                value="${dataValues.hasilUtama}" 
                                                                step="0.01" placeholder="" readonly />
                                                        </td>
                                                        <td class="col-1">
                                                            <button type="button" class="btn btn-outline-secondary btn-sm switch-btn" 
                                                                    data-index="${paramIdx}">
                                                                <i class="ti ti-switch-2"></i>
                                                            </button>
                                                        </td>
                                                        <td class="col-2 duplo d1-column text-center" style="display: ${duploStatus.hasD1 ? 'table-cell' : 'none'};">
                                                            <input type="number" name="duplo_d1[]" 
                                                                class="form-control d1 w-60 p-0 text-center" 
                                                                value="${dataValues.duplo_d1}" step="0.01" readonly />
                                                        </td>
                                                        <td class="col-2 duplo d2-column" style="display: ${duploStatus.hasD2 ? 'table-cell' : 'none'};">
                                                            <input type="number" name="duplo_d2[]" 
                                                                class="form-control d2 w-60 p-0 text-center" 
                                                                value="${dataValues.duplo_d2}" step="0.01" readonly />
                                                        </td>
                                                        <td class="col-2 duplo d3-column" style="display: ${duploStatus.hasD3 ? 'table-cell' : 'none'};">
                                                            <input type="number" name="duplo_d3[]" 
                                                                class="form-control d3 w-50 p-0 text-center" 
                                                                value="${dataValues.duplo_d3}" step="0.01" readonly />
                                                        </td>
                                                        <td class="col-3 flag-cell">
                                                            ${flagContent}
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="satuan[]" class="form-control w-100 p-0" 
                                                                value="${dataValues.satuan || param.satuan}" readonly />
                                                            <input type="hidden" name="range[]" class="form-control w-100 p-0" 
                                                                value="${dataValues.range || param.normal_min + '-' + param.normal_max}" readonly />
                                                            ${dataValues.satuan || param.satuan}
                                                        </td>
                                                    </tr>
                                                    `;
                                                }).join('');
                                            } else if (hasWidal) {
                                                // Jika ada widal, tampilkan parameter widal lengkap
                                                return WidalParams.map((param, paramIdx) => {
                                                    // Cari data hasil untuk parameter ini
                                                    const dataValues = getDataValues(param.nama, param.nama);
                                                    const rowId = `widal_${idx}_${paramIdx}`;
                                                    const flagContent = updateFlag(dataValues.hasilUtama, {innerHTML: ''}, param.nama, false, true, false);
                                                    
                                                    return `
                                                    <tr data-id="${rowId}" data-parameter="${param.nama}" class="widal-row">
                                                        <td class="col-2">
                                                            <strong>${param.display_name}</strong>
                                                            <small class="text-muted d-block">Negatif</small>
                                                            <input type="hidden" name="nama_pemeriksaan[]" value="${param.nama}" />
                                                            <input type="hidden" name="department[]" value="${e.data_departement.nama_department}" />
                                                        </td>
                                                        <td class="col-2">
                                                            <select name="hasil[]" 
                                                                class="form-select manualInput w-80 p-0" disabled>
                                                                ${param.opsi_output.split(';').map(opt => `
                                                                    <option value="${opt.trim()}" ${dataValues.hasilUtama === opt.trim() ? 'selected' : ''}>
                                                                        ${opt.trim()}
                                                                    </option>
                                                                `).join('')}
                                                            </select>
                                                        </td>
                                                        <td class="col-1">
                                                            <button type="button" class="btn btn-outline-secondary btn-sm switch-btn" 
                                                                    data-index="${paramIdx}">
                                                                <i class="ti ti-switch-2"></i>
                                                            </button>
                                                        </td>
                                                        <td class="col-2 duplo d1-column text-center" style="display: ${duploStatus.hasD1 ? 'table-cell' : 'none'};">
                                                            <select name="duplo_d1[]" 
                                                                class="form-select d1 w-80 p-0" readonly>
                                                                ${param.opsi_output.split(';').map(opt => `
                                                                    <option value="${opt.trim()}" ${dataValues.duplo_d1 === opt.trim() ? 'selected' : ''}>
                                                                        ${opt.trim()}
                                                                    </option>
                                                                `).join('')}
                                                            </select>
                                                        </td>
                                                        <td class="col-2 duplo d2-column" style="display: ${duploStatus.hasD2 ? 'table-cell' : 'none'};">
                                                            <select name="duplo_d2[]" 
                                                                class="form-select d2 w-80 p-0" readonly>
                                                                ${param.opsi_output.split(';').map(opt => `
                                                                    <option value="${opt.trim()}" ${dataValues.duplo_d2 === opt.trim() ? 'selected' : ''}>
                                                                        ${opt.trim()}
                                                                    </option>
                                                                `).join('')}
                                                            </select>
                                                        </td>
                                                        <td class="col-2 duplo d3-column" style="display: ${duploStatus.hasD3 ? 'table-cell' : 'none'};">
                                                            <select name="duplo_d3[]" 
                                                                class="form-select d3 w-80 p-0" readonly>
                                                                ${param.opsi_output.split(';').map(opt => `
                                                                    <option value="${opt.trim()}" ${dataValues.duplo_d3 === opt.trim() ? 'selected' : ''}>
                                                                        ${opt.trim()}
                                                                    </option>
                                                                `).join('')}
                                                            </select>
                                                        </td>
                                                        <td class="col-3 flag-cell">
                                                            ${flagContent}
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="satuan[]" class="form-control w-100 p-0" 
                                                                value="${dataValues.satuan || param.satuan}" readonly />
                                                            <input type="hidden" name="range[]" class="form-control w-100 p-0" 
                                                                value="${dataValues.range || '-'}" readonly />
                                                            ${dataValues.satuan || param.satuan}
                                                        </td>
                                                    </tr>
                                                    `;
                                                }).join('');
                                            } else if (hasUrine) {
                                                // Jika ada urine, tampilkan parameter urine lengkap
                                                return UrineParams.map((param, paramIdx) => {
                                                    // Cari data hasil untuk parameter ini
                                                    const dataValues = getDataValues(param.nama, param.nama);
                                                    const rowId = `urine_${idx}_${paramIdx}`;
                                                    const flagContent = updateFlag(dataValues.hasilUtama, {innerHTML: ''}, param.nama, false, false, true);
                                                    
                                                    // Tentukan range display
                                                    let rangeDisplay = '';
                                                    if (typeof param.normal_min === 'number' && typeof param.normal_max === 'number') {
                                                        rangeDisplay = `${param.normal_min}-${param.normal_max}`;
                                                    } else if (param.normal_min !== '-' && param.normal_max !== '-') {
                                                        rangeDisplay = 'Normal';
                                                    } else {
                                                        rangeDisplay = '-';
                                                    }
                                                    
                                                    return `
                                                    <tr data-id="${rowId}" data-parameter="${param.nama}" class="urine-row">
                                                        <td class="col-2">
                                                            <strong>${param.display_name}</strong>
                                                            <small class="text-muted d-block">${rangeDisplay}</small>
                                                            <input type="hidden" name="nama_pemeriksaan[]" value="${param.nama}" />
                                                            <input type="hidden" name="department[]" value="${e.data_departement.nama_department}" />
                                                        </td>
                                                        <td class="col-2">
                                                            ${param.tipe_inputan === 'Text' ? `
                                                                <input type="text" name="hasil[]" 
                                                                    class="form-control manualInput w-80 p-0 text-center" 
                                                                    value="${dataValues.hasilUtama || param.default || ''}" disabled />
                                                            ` : `
                                                                <select name="hasil[]" 
                                                                    class="form-select manualInput w-80 p-0" disabled>
                                                                    ${param.opsi_output.split(';').map(opt => `
                                                                        <option value="${opt.trim()}" ${(dataValues.hasilUtama || param.default) === opt.trim() ? 'selected' : ''}>
                                                                            ${opt.trim()}
                                                                        </option>
                                                                    `).join('')}
                                                                </select>
                                                            `}
                                                        </td>
                                                        <td class="col-1">
                                                            <button type="button" class="btn btn-outline-secondary btn-sm switch-btn" 
                                                                    data-index="${paramIdx}">
                                                                <i class="ti ti-switch-2"></i>
                                                            </button>
                                                        </td>
                                                        <td class="col-2 duplo d1-column text-center" style="display: ${duploStatus.hasD1 ? 'table-cell' : 'none'};">
                                                            ${param.tipe_inputan === 'Text' ? `
                                                                <input type="text" name="duplo_d1[]" 
                                                                    class="form-control d1 w-80 p-0 text-center" 
                                                                    value="${dataValues.duplo_d1 || ''}" readonly />
                                                            ` : `
                                                                <select name="duplo_d1[]" 
                                                                    class="form-select d1 w-80 p-0" readonly>
                                                                    ${param.opsi_output.split(';').map(opt => `
                                                                        <option value="${opt.trim()}" ${dataValues.duplo_d1 === opt.trim() ? 'selected' : ''}>
                                                                            ${opt.trim()}
                                                                        </option>
                                                                    `).join('')}
                                                                </select>
                                                            `}
                                                        </td>
                                                        <td class="col-2 duplo d2-column" style="display: ${duploStatus.hasD2 ? 'table-cell' : 'none'};">
                                                            ${param.tipe_inputan === 'Text' ? `
                                                                <input type="text" name="duplo_d2[]" 
                                                                    class="form-control d2 w-80 p-0 text-center" 
                                                                    value="${dataValues.duplo_d2 || ''}" readonly />
                                                            ` : `
                                                                <select name="duplo_d2[]" 
                                                                    class="form-select d2 w-80 p-0" readonly>
                                                                    ${param.opsi_output.split(';').map(opt => `
                                                                        <option value="${opt.trim()}" ${dataValues.duplo_d2 === opt.trim() ? 'selected' : ''}>
                                                                            ${opt.trim()}
                                                                        </option>
                                                                    `).join('')}
                                                                </select>
                                                            `}
                                                        </td>
                                                        <td class="col-2 duplo d3-column" style="display: ${duploStatus.hasD3 ? 'table-cell' : 'none'};">
                                                            ${param.tipe_inputan === 'Text' ? `
                                                                <input type="text" name="duplo_d3[]" 
                                                                    class="form-control d3 w-80 p-0 text-center" 
                                                                    value="${dataValues.duplo_d3 || ''}" readonly />
                                                            ` : `
                                                                <select name="duplo_d3[]" 
                                                                    class="form-select d3 w-80 p-0" readonly>
                                                                    ${param.opsi_output.split(';').map(opt => `
                                                                        <option value="${opt.trim()}" ${dataValues.duplo_d3 === opt.trim() ? 'selected' : ''}>
                                                                            ${opt.trim()}
                                                                        </option>
                                                                    `).join('')}
                                                                </select>
                                                            `}
                                                        </td>
                                                        <td class="col-3 flag-cell">
                                                            ${flagContent}
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="satuan[]" class="form-control w-100 p-0" 
                                                                value="${dataValues.satuan || param.satuan}" readonly />
                                                            <input type="hidden" name="range[]" class="form-control w-100 p-0" 
                                                                value="${dataValues.range || rangeDisplay}" readonly />
                                                            ${dataValues.satuan || param.satuan}
                                                        </td>
                                                    </tr>
                                                    `;
                                                }).join('');
                                            } else {
                                                // Jika bukan hematologi, widal, atau urine, tampilkan seperti biasa
                                                return e.pasiens.map(p => {
                                                    const dataValues = getDataValues(p.data_pemeriksaan.nama_parameter, p.data_pemeriksaan.nama_pemeriksaan);
                                                    const rowId = p.data_pemeriksaan.id;
                                                    const flagContent = updateFlag(dataValues.hasilUtama, {innerHTML: ''}, p.data_pemeriksaan.nama_parameter);
                                                    
                                                    return `
                                                    <tr data-id="${rowId}" data-parameter="${p.data_pemeriksaan.nama_parameter}">
                                                        <td class="col-2">
                                                            <strong>${p.data_pemeriksaan.nama_pemeriksaan}</strong>
                                                            <input type="hidden" name="nama_pemeriksaan[]" 
                                                                value="${p.data_pemeriksaan.nama_pemeriksaan}" />
                                                            <input type="hidden" name="department[]" value="${e.data_departement.nama_department}" />
                                                        </td>
                                                        <td class="col-2">
                                                            <input type="text" name="hasil[]" 
                                                                class="form-control manualInput w-60 p-0 text-center" 
                                                                value="${dataValues.hasilUtama}" readonly />
                                                        </td>
                                                        <td class="col-1">
                                                            <button type="button" class="btn btn-outline-secondary btn-sm switch-btn" 
                                                                    data-index="0">
                                                                <i class="ti ti-switch-2"></i>
                                                            </button>
                                                        </td>
                                                        <td class="col-2 duplo d1-column text-center" style="display: ${duploStatus.hasD1 ? 'table-cell' : 'none'};">
                                                            <input type="number" name="duplo_d1[]" 
                                                                class="form-control d1 w-60 p-0 text-center" 
                                                                value="${dataValues.duplo_d1}" readonly />
                                                        </td>
                                                        <td class="col-2 duplo d2-column" style="display: ${duploStatus.hasD2 ? 'table-cell' : 'none'};">
                                                            <input type="number" name="duplo_d2[]" 
                                                                class="form-control d2 w-60 p-0 text-center" 
                                                                value="${dataValues.duplo_d2}" readonly />
                                                        </td>
                                                        <td class="col-2 duplo d3-column" style="display: ${duploStatus.hasD3 ? 'table-cell' : 'none'};">
                                                            <input type="number" name="duplo_d3[]" 
                                                                class="form-control d3 w-50 p-0 text-center" 
                                                                value="${dataValues.duplo_d3}" readonly />
                                                        </td>
                                                        <td class="col-3 flag-cell">
                                                            ${renderFlag(dataValues.flag || updateFlag(dataValues.hasilUtama, {innerHTML: ''}, p.data_pemeriksaan.nama_parameter))}
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="satuan[]" class="form-control w-100 p-0" 
                                                                value="${dataValues.satuan || p.data_pemeriksaan.nilai_satuan}" readonly />
                                                            <input type="hidden" name="range[]" class="form-control w-100 p-0" 
                                                                value="${dataValues.range}" readonly />
                                                            ${dataValues.satuan || p.data_pemeriksaan.nilai_satuan}
                                                        </td>
                                                    </tr>
                                                    `;
                                                }).join('');
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
    </style>
    `;

    setTimeout(() => {
        // Referensi elemen-elemen yang diperlukan
        const kembalikanBtn = document.getElementById('kembalikanBtn');
        const releaseBtn = document.getElementById('releaseBtn');

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

        document.querySelectorAll('.switch-btn').forEach((button) => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const hasilInput = row.querySelector('.manualInput');
                const d1Input = row.querySelector('.d1');
                const d2Input = row.querySelector('.d2');
                const d3Input = row.querySelector('.d3');
                const flagCell = row.querySelector('.flag-cell');
                const parameter = row.dataset.parameter;

                let currentIndex = parseInt(this.getAttribute('data-switch-index')) || 0;

                const updateValues = () => {
                    switch (currentIndex) {
                        case 0:
                            if (d1Input && window.getComputedStyle(d1Input.closest('.d1-column')).display !== 'none') {
                                const tempHasil = hasilInput.value;
                                hasilInput.value = d1Input.value;
                                d1Input.value = tempHasil;
                            }
                            break;
                        case 1:
                            if (d2Input && window.getComputedStyle(d2Input.closest('.d2-column')).display !== 'none') {
                                const tempHasil = hasilInput.value;
                                hasilInput.value = d2Input.value;
                                d2Input.value = tempHasil;
                            }
                            break;
                        case 2:
                            if (d3Input && window.getComputedStyle(d3Input.closest('.d3-column')).display !== 'none') {
                                const tempHasil = hasilInput.value;
                                hasilInput.value = d3Input.value;
                                d3Input.value = tempHasil;
                            }
                            break;
                    }
                };

                updateValues();
                currentIndex = (currentIndex + 1) % 3;
                this.setAttribute('data-switch-index', currentIndex);
                updateFlag(hasilInput.value, flagCell, parameter);
            });
        });

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
    
    // Fungsi untuk mengecek dan menampilkan kolom duplo - ALWAYS SHOW VERSION
    function checkAndShowDuploColumns() {
        const accordion = document.getElementById('accordionPemeriksaan');
        if (!accordion) {
            console.log('Accordion not found');
            return;
        }
        
        // const d1Cells = accordion.querySelectorAll('.d1-column');
        // const d2Cells = accordion.querySelectorAll('.d2-column');
        // const d3Cells = accordion.querySelectorAll('.d3-column');
        
        console.log('Found duplo cells:', {
            d1: d1Cells.length,
            d2: d2Cells.length,
            d3: d3Cells.length
        });
        
        let hasD1 = false;
        let hasD2 = false;
        let hasD3 = false;
        
        // Check if any D1, D2, D3 values exist
        const duploInputs = accordion.querySelectorAll('input.d1, input.d2, input.d3');
        console.log('Found duplo inputs:', duploInputs.length);
        
        duploInputs.forEach(input => {
            const value = input.value ? input.value.trim() : '';
            if (value !== '' && value !== '0' && value !== '0.00') {
                if (input.classList.contains('d1')) {
                    hasD1 = true;
                    console.log('Found D1 data:', value);
                }
                if (input.classList.contains('d2')) {
                    hasD2 = true;
                    console.log('Found D2 data:', value);
                }
                if (input.classList.contains('d3')) {
                    hasD3 = true;
                    console.log('Found D3 data:', value);
                }
            }
        });
        
        console.log('Duplo data status:', { hasD1, hasD2, hasD3 });
        
        // Always show all duplo columns regardless of data availability
        d1Cells.forEach(cell => {
            cell.style.display = 'table-cell';
            if (hasD1) {
                cell.style.backgroundColor = '#e3f2fd';
            }
        });
        
        d2Cells.forEach(cell => {
            cell.style.display = 'table-cell';
            if (hasD2) {
                cell.style.backgroundColor = '#f3e5f5';
            }
        });
        
        d3Cells.forEach(cell => {
            cell.style.display = 'table-cell';
            if (hasD3) {
                cell.style.backgroundColor = '#e8f5e8';
            }
        });
        
        console.log('All duplo columns are now visible');
    }
});
</script>






<script>
   // Ambil semua elemen dengan class 'editBtn'
var editBtns = document.querySelectorAll('.editBtn');

// Loop untuk setiap tombol
editBtns.forEach(function(editBtn) {
    var no_lab = editBtn.getAttribute('data-id');  // Ambil nilai no_lab dari atribut data-id
    var editUrl = "{{ route('pasien.viewedit', ':no_lab') }}";
    editUrl = editUrl.replace(':no_lab', no_lab);  // Gantilah :no_lab dengan nilai yang telah diambil
    editBtn.href = editUrl;  // Set URL pada href tombol Edit
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
                    accordionContent += `<h5 class="title mt-3">Spesiment Collection</h5><hr>`;
                    accordionContent += `<div class="accordion" id="accordionCollection">`;
                    collectionSpecimens.forEach(e => {
                        accordionContent += generateAccordionHTML(e, scollection, shandling, "collection");
                    });
                    accordionContent += `</div>`;
                }

                // ========== Spesimen Handlings ==========
                let handlingSpecimens = spesimen.filter(e => e.spesiment === "Spesiment Handlings");
                if (handlingSpecimens.length > 0) {
                    accordionContent += `<h5 class="title mt-3">Spesiment Handlings</h5><hr>`;
                    accordionContent += `<div class="accordion" id="accordionHandling">`;
                    handlingSpecimens.forEach(e => {
                        accordionContent += generateAccordionHTML(e, scollection, shandling, "handling");
                    });
                    accordionContent += `</div>`;
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

        if (dataItem) {
            hasData  = true;
            noteText = dataItem.note || '';
            kapasitas = dataItem.kapasitas;
            serumh   = dataItem.serumh;
            clotact  = dataItem.clotact;
            serum    = dataItem.serum;
        }

        const uniqId = `${e.tabung}-${e.kode}`.replace(/\s+/g, '');

        if (e.details && e.details.length > 0) {
            details = `<div class="detail-container col-12 col-md-6">`;
            e.details.forEach(detail => {
                const imageUrl = `/gambar/${detail.gambar}`;
                let isChecked = '';
                let isDisabled = '';

                if (hasData) {
                    if (type === "collection") {
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
                    } else if (type === "handling") {
                        if (e.tabung === 'CLOTH-ACTIVATOR' || e.tabung === 'CLOT-ACTIVATOR') {
                            isChecked = parseInt(serum) === parseInt(detail.id) ? 'checked' : '';
                            isDisabled = 'disabled';
                        }
                    }
                } else {
                    if (detail.nama_parameter.toLowerCase().includes('normal')) {
                        isChecked = 'checked';
                    }
                    isDisabled = '';
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
