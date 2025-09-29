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
                                                <a class="dropdown-item editBtn" 
                                                data-id="{{ $dpc->no_lab }}" 
                                                href="#">
                                                    <i class="ti ti-pencil me-2"></i> Edit
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
    // const UrineParams = [
    //     {
    //         nama: 'Warna',
    //         display_name: 'Warna',
    //         satuan: '-',
    //         normal_min: '-',
    //         normal_max: '-',
    //         tipe_inputan: 'Dropdown',
    //         opsi_output: 'Kuning;Kuning Pucat;Kuning Tua;Kuning kecokelatan;Orange;Merah;Coklat',
    //         default: 'Kuning'
    //     },
    //     {
    //         nama: 'Kekeruhan',
    //         display_name: 'Kekeruhan',
    //         satuan: '-',
    //         normal_min: '-',
    //         normal_max: '-',
    //         tipe_inputan: 'Dropdown',
    //         opsi_output: 'Jernih;Agak Keruh;Keruh;Sangat keruh',
    //         default: 'Jernih'
    //     },
    //     {
    //         nama: 'Berat Jenis',
    //         display_name: 'Berat Jenis',
    //         satuan: '-',
    //         normal_min: 1.003,
    //         normal_max: 1.035,
    //         tipe_inputan: 'Dropdown',
    //         opsi_output: '<1.005;1.005;1.010;1.015;1.020;1.025;1.030',
    //         default: '1.015'
    //     },
    //     {
    //         nama: 'PH',
    //         display_name: 'pH',
    //         satuan: '-',
    //         normal_min: 4.5,
    //         normal_max: 8.0,
    //         tipe_inputan: 'Dropdown',
    //         opsi_output: '4.5;5.0;5.5;6.0;6.5;7.0;7.5;8.0;8.5;9.0',
    //         default: '6.0'
    //     },
    //     {
    //         nama: 'Leukosit',
    //         display_name: 'Leukosit',
    //         satuan: '-',
    //         normal_min: '-',
    //         normal_max: '-',
    //         tipe_inputan: 'Dropdown',
    //         opsi_output: 'Negatif;Positif;Positif(+);Positif(++);Positif(+++)',
    //         default: 'Negatif'
    //     },
    //     {
    //         nama: 'Nitrit',
    //         display_name: 'Nitrit',
    //         satuan: '-',
    //         normal_min: '-',
    //         normal_max: '-',
    //         tipe_inputan: 'Dropdown',
    //         opsi_output: 'Negatif;Positif(+);Positif(++);Positif(+++)',
    //         default: 'Negatif'
    //     },
    //     {
    //         nama: 'Protein',
    //         display_name: 'Protein',
    //         satuan: '-',
    //         normal_min: '-',
    //         normal_max: '-',
    //         tipe_inputan: 'Dropdown',
    //         opsi_output: 'Negatif;Positif(+);Positif(++);Positif(+++)',
    //         default: 'Negatif'
    //     },
    //     {
    //         nama: 'Glukosa',
    //         display_name: 'Glukosa',
    //         satuan: '-',
    //         normal_min: '-',
    //         normal_max: '-',
    //         tipe_inputan: 'Dropdown',
    //         opsi_output: 'Negatif;Positif(+);Positif(++);Positif(+++)',
    //         default: 'Negatif'
    //     },
    //     {
    //         nama: 'Keton',
    //         display_name: 'Keton',
    //         satuan: '-',
    //         normal_min: '-',
    //         normal_max: '-',
    //         tipe_inputan: 'Dropdown',
    //         opsi_output: 'Negatif;Positif(+);Positif(++);Positif(+++)',
    //         default: 'Negatif'
    //     },
    //     {
    //         nama: 'Urobilinogen',
    //         display_name: 'Urobilinogen',
    //         satuan: '-',
    //         normal_min: '-',
    //         normal_max: '-',
    //         tipe_inputan: 'Dropdown',
    //         opsi_output: 'Negatif;Positif(+);Positif(++);Positif(+++)',
    //         default: 'Negatif'
    //     },
    //     {
    //         nama: 'Bilirubin',
    //         display_name: 'Bilirubin',
    //         satuan: '-',
    //         normal_min: '-',
    //         normal_max: '-',
    //         tipe_inputan: 'Dropdown',
    //         opsi_output: 'Negatif;Positif(+);Positif(++);Positif(+++)',
    //         default: 'Negatif'
    //     },
    //     {
    //         nama: 'Blood',
    //         display_name: 'Blood',
    //         satuan: '-',
    //         normal_min: '-',
    //         normal_max: '-',
    //         tipe_inputan: 'Dropdown',
    //         opsi_output: 'Negatif;Positif(+);Positif(++);Positif(+++)',
    //         default: 'Negatif'
    //     },
    //     {
    //         nama: 'Eritrosit',
    //         display_name: '- Eritrosit',
    //         satuan: '',
    //         normal_min: 0,
    //         normal_max: 2,
    //         tipe_inputan: 'Text',
    //         default: 'Negatif'
    //     },
    //     {
    //         nama: 'Leukosit_sedimen',
    //         display_name: '- Leukosit',
    //         satuan: '',
    //         normal_min: 0,
    //         normal_max: 5,
    //         tipe_inputan: 'Text',
    //         default: 'Negatif'
    //     },
    //     {
    //         nama: 'Epithel',
    //         display_name: '- Epithel',
    //         satuan: '-',
    //         normal_min: '-',
    //         normal_max: '-',
    //         tipe_inputan: 'Text',
    //         default: 'Negatif'
    //     },
    //     {
    //         nama: 'Silinder',
    //         display_name: '- Silinder',
    //         satuan: '-',
    //         normal_min: '-',
    //         normal_max: '-',
    //         tipe_inputan: 'Dropdown',
    //         opsi_output: 'Negatif;Positif;Positif(+);Positif(++);Positif(+++);Positif(++++)',
    //         default: 'Negatif'
    //     },
    //     {
    //         nama: 'Kristal',
    //         display_name: '- Kristal',
    //         satuan: '-',
    //         normal_min: '-',
    //         normal_max: '-',
    //         tipe_inputan: 'Dropdown',
    //         opsi_output: 'Tidak ada;Asam urat;Kalsium oksalat;Fosfat amorf;Lainnya',
    //         default: 'Negatif'
    //     },
    //     {
    //         nama: 'Bakteri',
    //         display_name: '- Bakteri',
    //         satuan: '-',
    //         normal_min: '-',
    //         normal_max: '-',
    //         tipe_inputan: 'Dropdown',
    //         opsi_output: 'Negatif;Positif;Positif(+);Positif(++);Positif(+++);Positif(++++)',
    //         default: 'Negatif'
    //     },
    //     {
    //         nama: 'Jamur',
    //         display_name: '- Jamur',
    //         satuan: '-',
    //         normal_min: '-',
    //         normal_max: '-',
    //         tipe_inputan: 'Dropdown',
    //         opsi_output: 'Negatif;Positif;Positif(+);Positif(++);Positif(+++)',
    //         default: 'Negatif'
    //     },
    //     {
    //         nama: 'Lain-lain',
    //         display_name: '- Lain-lain',
    //         satuan: '-',
    //         normal_min: '',
    //         normal_max: '',
    //         tipe_inputan: 'Text',
    //         default: ''
    //     }
    // ];
    const UrineParams = [
        {
            nama: 'Warna',
            display_name: 'Warna',
            satuan: '-',
            normal_min: 'L.- P.-',
            normal_max: 'L.- P.-',
            nilai_rujukan: '-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Kuning;Orange;Merah;Coklat',
        },
        {
            nama: 'Kekeruhan',
            display_name: 'Kekeruhan',
            satuan: '-',
            normal_min: 'L.- P.-',
            normal_max: 'L.- P.-',
            nilai_rujukan: 'L.- P.-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Jernih;Agak Keruh;Keruh',
        },
        {
            nama: 'Berat Jenis',
            display_name: 'Berat Jenis',
            satuan: '-',
            normal_min: 'L.1,003 P.1,003',
            normal_max: 'L.1,035 P.1,035',
            nilai_rujukan: 'L.1,003-1,035 P.1,003-1,035',
            tipe_inputan: 'text',
        },
        {
            nama: 'PH',
            display_name: 'PH',
            satuan: '-',
            normal_min: 'L.4,5 P.4,5',
            normal_max: 'L.8,0 P.8,0',
            nilai_rujukan: 'L.4,5-8,0 P.4,5-8,0',
            tipe_inputan: 'text',
        },
        {
            nama: 'Leukosit',
            display_name: 'Leukosit',
            satuan: '-',
            normal_min: 'L.- P.-',
            normal_max: 'L.- P.-',
            nilai_rujukan: 'L.- P.-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Negatif;Positif',
        },
        {
            nama: 'Nitrit',
            display_name: 'Nitrit',
            satuan: '-',
            normal_min: 'L.- P.-',
            normal_max: 'L.- P.-',
            nilai_rujukan: 'L.- P.-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Negatif;Positif',
        },
        {
            nama: 'Preotein',
            display_name: 'Protein',
            satuan: '-',
            normal_min: 'L.- P.-',
            normal_max: 'L.- P.-',
            nilai_rujukan: 'L.- P.-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Negatif;Positif',
        },
        {
            nama: 'Glukosa',
            display_name: 'Glukosa',
            satuan: '-',
            normal_min: 'L.- P.-',
            normal_max: 'L.- P.-',
            nilai_rujukan: 'L.- P.-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Negatif;Positif',
        },
        {
            nama: 'Keton',
            display_name: 'Keton',
            satuan: '-',
            normal_min: 'L.- P.-',
            normal_max: 'L.- P.-',
            nilai_rujukan: 'L.- P.-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Negatif;Positif',
        },
        {
            nama: 'Urobilinogen',
            display_name: 'Urobilinogen',
            satuan: '-',
            normal_min: 'L.- P.-',
            normal_max: 'L.- P.-',
            nilai_rujukan: 'L.- P.-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Negatif;Positif',
        },
        {
            nama: 'Bilirubin',
            display_name: 'Bilirubin',
            satuan: '-',
            normal_min: 'L.- P.-',
            normal_max: 'L.- P.-',
            nilai_rujukan: 'L.- P.-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Negatif;Positif',
        },
        {
            nama: 'Blood',
            display_name: 'Blood',
            satuan: '-',
            normal_min: 'L.- P.-',
            normal_max: 'L.- P.-',
            nilai_rujukan: 'L.- P.-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Negatif;Positif',
        }
    ];
    // Parameter Miccrobiologi
    const MicrobiologiParams = [
        {
            nama: 'Observation',
            display_name: 'Observation',
            satuan: '-',
            normal_min_l: '-',
            normal_max_l: '-',
            normal_min_p: '-',
            normal_max_p: '-',
            nilai_rujukan_l: '-',
            nilai_rujukan_p: '-',
            tipe_inputan: 'Dropdown',
            opsi_output: 'Negatif;Ditemukan Adanya Jamur Berbentuk Hifa'
        },
        {
            nama: 'Leukosit',
            display_name: 'Leukosit',
            satuan: '/LP',
            normal_min_l: '-',
            normal_max_l: '-',
            normal_min_p: '-',
            normal_max_p: '-',
            nilai_rujukan_l: 'L.- P.-',
            nilai_rujukan_p: 'L.- P.-',
            tipe_inputan: 'Text',
            opsi_output: ''
        },
        {
            nama: 'Epithel',
            display_name: 'Epithel',
            satuan: '/LP',
            normal_min_l: '-',
            normal_max_l: '-',
            normal_min_p: '-',
            normal_max_p: '-',
            nilai_rujukan_l: 'L.- P.-',
            nilai_rujukan_p: 'L.- P.-',
            tipe_inputan: 'Text',
            opsi_output: ''
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
                duplo_dx: item.duplo_dx || '',
                range: item.range || '',
                satuan: item.satuan || '',
                note: item.note || '',
                flag: item.flag || '',
                switched : item.is_switched || '',
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

    // PERBAIKAN: Fungsi getDataValues yang lebih robust
function getDataValues(parameterName, namaPemeriksaan) {
    // Debug: Log apa yang sedang dicari
    // console.log('🔍 Mencari data untuk:', { parameterName, namaPemeriksaan });
    // console.log('📊 HasilMap keys:', Object.keys(hasilMap));
    
    // Prioritas: data dari database, kemudian OBX sebagai fallback
    let foundData = null;
    
    // Cari berdasarkan nama pemeriksaan dulu
    if (namaPemeriksaan && hasilMap[namaPemeriksaan]) {
        foundData = hasilMap[namaPemeriksaan];
        // console.log('✅ Data ditemukan dengan namaPemeriksaan:', namaPemeriksaan, foundData);
    } 
    // Jika tidak ada, cari berdasarkan parameter name
    else if (parameterName && hasilMap[parameterName]) {
        foundData = hasilMap[parameterName];
        // console.log('✅ Data ditemukan dengan parameterName:', parameterName, foundData);
    }

    // Jika data ditemukan dari database
    if (foundData) {
        const result = {
            duplo_d1: foundData.duplo_d1 || '',
            duplo_d2: foundData.duplo_d2 || '',
            duplo_d3: foundData.duplo_d3 || '',
            duplo_dx: foundData.duplo_dx || '',
            hasilUtama: foundData.hasil || '',
            satuan: foundData.satuan || '',
            range: foundData.range || '',
            flag: foundData.flag || '',
            switched: foundData.switched || foundData.is_switched || false // PERBAIKAN: Cek kedua field
        };
        
        // console.log('📋 Data hasil:', result);
        return result;
    }
    
    // Fallback ke OBX jika tidak ada data database
    // console.log('⚠️ Tidak ada data database, menggunakan OBX fallback');
    const values = obxMap[parameterName] || [];
    return {
        duplo_d1: values[0] || '',
        duplo_d2: values[1] || '',
        duplo_d3: values[2] || '',
        duplo_dx: '',
        hasilUtama: values[0] || '',
        satuan: '',
        range: '',
        flag: '',
        switched: false
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

    // function updateFlag(value, flagCell, parameter = null, isHematologi = false, isWidal = false, isUrine = false) {
    //     const nilaiHasil = parseFloat(value);
    //     let flagIcon = '';
        
    //     // Untuk Widal, tidak ada flag karena tidak ada nilai normal/abnormal
    //     if (isWidal) {
    //         return '';
    //     }
        
    //     if (!isNaN(nilaiHasil)) {
    //         if (isHematologi && parameter) {
    //             // range normal untuk parameter hematologi
    //             const paramData = hematologiParams.find(p => p.nama === parameter);
    //             if (paramData) {
    //                 if (nilaiHasil < paramData.normal_min) {
    //                     flagIcon = `<i class="ti ti-arrow-down text-primary"></i> L`;
    //                 } else if (nilaiHasil > paramData.normal_max) {
    //                     flagIcon = `<i class="ti ti-arrow-up text-danger"></i> H`;
    //                 } else {
    //                     flagIcon = ``;
    //                 }
    //             }
    //         } else if (isUrine && parameter) {
    //             // range normal untuk parameter urine (hanya untuk parameter numerik)
    //             const paramData = UrineParams.find(p => p.nama === parameter);
    //             if (paramData && typeof paramData.normal_min === 'number' && typeof paramData.normal_max === 'number') {
    //                 if (nilaiHasil < paramData.normal_min) {
    //                     flagIcon = `<i class="ti ti-arrow-down text-primary"></i> L`;
    //                 } else if (nilaiHasil > paramData.normal_max) {
    //                     flagIcon = `<i class="ti ti-arrow-up text-danger"></i> H`;
    //                 } else {
    //                     flagIcon = ``;
    //                 }
    //             }
    //         } else {
    //             // Flag logic untuk non-hematologi
    //             if (nilaiHasil < 5) {
    //                 flagIcon = `<i class="ti ti-arrow-down text-primary"></i>`;
    //             } else if (nilaiHasil > 10) {
    //                 flagIcon = `<i class="ti ti-arrow-up text-danger"></i>`;
    //             }
    //         }
    //     }
    //     if (flagCell && flagCell.innerHTML !== undefined) {
    //         flagCell.innerHTML = flagIcon;
    //     }
    //     return flagIcon;
    // }
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

                                            const hasMikrobiologi = e.pasiens.some(p => {
                                                const isMikrobiologi = p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('microbiologi');
                                                return isMikrobiologi;
                                                // console.log('Nama pemeriksaan:', p.data_pemeriksaan.nama_pemeriksaan.toLowerCase());
                                            });
                                            
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
                                                const flagContent = renderFlag(
                                                    dataValues.hasilUtama,
                                                    { innerHTML: '' },
                                                    param.nama,
                                                    true,
                                                    false,
                                                    false
                                                );

                                                return `
                                                    <tr data-id="${rowId}" data-parameter="${param.nama}" class="hematologi-row">
                                                        <td class="col-2 ${judulHematologi ? 'ps-4' : ''}" ${judulHematologi ? 'style="border-left: 2px solid #e9ecef;"' : ''}>
                                                            <strong>${param.display_name}</strong>
                                                            <small class="text-muted d-block">${param.normal_min}-${param.normal_max}</small>
                                                            <input type="hidden" name="nama_pemeriksaan[]" value="${param.nama}" />
                                                            ${judulHematologi ? `<input type="hidden" name="judul[]" value="${judulHematologi}" />` : ''}
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
                                                        <td class="col-2 duplo dx-column text-center">
                                                            <div class="d-flex align-items-center justify-content-center gap-1">
                                                                <input type="number" 
                                                                    name="duplo_dx[]" 
                                                                    class="form-control dx w-60 p-0 text-center" 
                                                                    value="${dataValues.duplo_dx ?? ''}" 
                                                                    step="0.01" />

                                                                <!-- Hidden input untuk simpan status switch -->
                                                                <input type="hidden" 
                                                                    name="is_switched[]" 
                                                                    value="${dataValues.switched ? 1 : 0}">

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
                                                            ${renderFlag(dataValues.flag || flagContent(dataValues.hasilUtama, {innerHTML: ''}, p.data_pemeriksaan.nama_parameter))}
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

                                        // flag apakah ada hasil duplo
                                        const hasDuplo = obxValues.duplo_dx || obxValues.duplo_d1 || obxValues.duplo_d2 || obxValues.duplo_d3;

                                        return `
                                            <tr data-id="${rowId}" data-parameter="${param.nama}" class="widal-row">
                                                <td class="col-2 ${judulWidal ? 'ps-4' : ''}" ${judulWidal ? 'style="border-left: 2px solid #e9ecef;"' : ''}>
                                                    <strong>${param.display_name}</strong>
                                                    <input type="hidden" name="nama_pemeriksaan[]" value="${namaPemeriksaanWidal}" />
                                                    ${judulWidal ? `<input type="hidden" name="judul[]" value="${judulWidal}" />` : ''}
                                                    <input type="hidden" name="parameter_name[]" value="${param.nama}" />
                                                    <input type="hidden" name="nilai_rujukan[]" value="${normalValues.rujukan}" />
                                                    <input type="hidden" name="department[]" value="${e.data_departement.nama_department}" />
                                                </td>
                                                <td class="col-2">
                                                    <select name="hasil[]" class="form-select manualInput w-60 p-0">
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
                                                        <select name="duplo_dx[]" class="form-select dx w-60 p-0">
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

                                                        <input type="hidden"
                                                            name="is_switched[]"
                                                            value="${obxValues.switched ? 1 : 0}">

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
                                                        <select name="duplo_d1[]" class="form-select d1 w-60 p-0" disabled>
                                                            ${param.opsi_output.split(';').map(opt => `
                                                                <option value="${opt.trim()}" ${obxValues.duplo_d1 === opt.trim() ? 'selected' : ''}>
                                                                    ${opt.trim()}
                                                                </option>
                                                            `).join('')}
                                                        </select>
                                                    </td>
                                                    <td class="col-2 duplo d2-column" style="display: ${duploStatus.hasD2 ? 'table-cell' : 'none'};">
                                                        <select name="duplo_d2[]" class="form-select d2 w-60 p-0" disabled>
                                                            ${param.opsi_output.split(';').map(opt => `
                                                                <option value="${opt.trim()}" ${obxValues.duplo_d2 === opt.trim() ? 'selected' : ''}>
                                                                    ${opt.trim()}
                                                                </option>
                                                            `).join('')}
                                                        </select>
                                                    </td>
                                                    <td class="col-2 duplo d3-column" style="display: ${duploStatus.hasD3 ? 'table-cell' : 'none'};">
                                                        <select name="duplo_d3[]" class="form-select d3 w-60 p-0" disabled>
                                                            ${param.opsi_output.split(';').map(opt => `
                                                                <option value="${opt.trim()}" ${obxValues.duplo_d3 === opt.trim() ? 'selected' : ''}>
                                                                    ${opt.trim()}
                                                                </option>
                                                            `).join('')}
                                                        </select>
                                                    </td>
                                                ` : ''}
                                                <td class="col-3 flag-cell"></td>
                                                <td>
                                                    <input type="hidden" name="satuan[]" value="${param.satuan}" readonly />
                                                    ${param.satuan}
                                                </td>
                                            </tr>
                                        `;
                                    }).join('');

                                        return html;
                                    } else if (hasUrine) {
                                    // Jika ada urine, tampilkan parameter urine lengkap
                                    const urinePemeriksaan = e.pasiens.find(p => 
                                        p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('urin') ||
                                        p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('urine')
                                    );
                                    const judulUrine = e.pasiens.find(p => p.data_pemeriksaan?.judul)?.data_pemeriksaan?.judul || '';
                                    const namaPemeriksaanUrine = urinePemeriksaan ? urinePemeriksaan.data_pemeriksaan.nama_pemeriksaan : 'Urinalisis';

                                    let html = '';

                                    // Header judul (jika ada)
                                    if (judulUrine) {
                                        html += `
                                            <tr class="urine-title-header">
                                                <td colspan="8" class="fw-bold text-info ps-3"
                                                    style="background-color:#e1f5fe; border-left:4px solid #00bcd4; padding:10px;">
                                                    ${judulUrine}
                                                </td>
                                            </tr>
                                        `;
                                    }

                                    // Parameter Urine
                                    html += UrineParams.map((param, paramIdx) => {
                                        const obxValues = getDataValues(param.nama);
                                        const rowId = `urine_${idx}_${paramIdx}`;
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
                                            <tr data-id="${rowId}" data-parameter="${param.nama}" class="urine-row">
                                                <td class="col-2 ${judulUrine ? 'ps-4' : ''}" ${judulUrine ? 'style="border-left:2px solid #e9ecef;"' : ''}>
                                                    <strong>${param.display_name}</strong>
                                                    ${normalValues.rujukan !== '-' && normalValues.rujukan !== '' 
                                                        ? `<small class="text-muted d-block">${normalValues.rujukan ?? ''}</small>` 
                                                        : ''}
                                                    <input type="hidden" name="nama_pemeriksaan[]" value="${namaPemeriksaanUrine}" />
                                                    ${judulUrine ? `<input type="hidden" name="judul[]" value="${judulUrine}" />` : ''}
                                                    <input type="hidden" name="parameter_name[]" value="${param.nama}" />
                                                    <input type="hidden" name="nilai_rujukan[]" value="${normalValues.rujukan}" />
                                                    <input type="hidden" name="department[]" value="${e.data_departement.nama_department}" />
                                                </td>
                                                <td class="col-2">
                                                    ${param.tipe_inputan === 'text' ? `
                                                        <input type="text" name="hasil[]" 
                                                            class="form-control manualInput w-60 p-0 text-center"
                                                            disabled value="${obxValues.hasilUtama || param.default || ''}" />
                                                    ` : `
                                                        <select name="hasil[]" class="form-select manualInput w-60 p-0" disabled>
                                                            ${param.opsi_output.split(';').map(opt => `
                                                                <option value="${opt.trim()}" ${(obxValues.hasilUtama || param.default) === opt.trim() ? 'selected' : ''}>
                                                                    ${opt.trim()}
                                                                </option>
                                                            `).join('')}
                                                        </select>
                                                    `}
                                                </td>
                                                <td class="col-1">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm switch-btn"
                                                            data-index="${paramIdx}" data-switch-index="0">
                                                        <i class="ti ti-switch-2"></i>
                                                    </button>
                                                </td>
                                                <td class="col-2 text-center">
                                                <div class="d-flex align-items-center justify-content-center gap-1">
                                                    ${param.tipe_inputan === 'text' ? `
                                                        <input type="text"
                                                            name="duplo_dx[]"
                                                            class="form-control dx w-60 p-0 text-center"
                                                            value="${obxValues.duplo_dx || ''}" />
                                                    ` : `
                                                        <select name="duplo_dx[]" class="form-select dx w-60 p-0">
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

                                                    <input type="hidden"
                                                        name="is_switched[]"
                                                        value="${obxValues.switched ? 1 : 0}">

                                                    ${obxValues.switched ? `
                                                        <div class='checkbox-r-container d-flex align-items-center gap-1'>
                                                            <input type='checkbox' class='checkbox-r form-check-input' checked disabled>
                                                            <span class='text-danger fw-bold'>R</span>
                                                        </div>
                                                    ` : ''}
                                                </div>
                                            </td>
                                                <td class="col-2 duplo d1-column text-center" style="display:none;">
                                                    ${param.tipe_inputan === 'text' ? `
                                                        <input type="text" name="duplo_d1[]" 
                                                            class="form-control d1 w-60 p-0 text-center"
                                                            disabled value="${obxValues.duplo_d1 || ''}" />
                                                    ` : `
                                                        <select name="duplo_d1[]" class="form-select d1 w-60 p-0" disabled>
                                                            ${param.opsi_output.split(';').map(opt => `
                                                                <option value="${opt.trim()}" ${obxValues.duplo_d1 === opt.trim() ? 'selected' : ''}>
                                                                    ${opt.trim()}
                                                                </option>
                                                            `).join('')}
                                                        </select>
                                                    `}
                                                </td>
                                                <td class="col-2 duplo d2-column" style="display:none;">
                                                    ${param.tipe_inputan === 'text' ? `
                                                        <input type="text" name="duplo_d2[]" 
                                                            class="form-control d2 w-60 p-0 text-center"
                                                            disabled value="${obxValues.duplo_d2 || ''}" />
                                                    ` : `
                                                        <select name="duplo_d2[]" class="form-select d2 w-60 p-0" disabled>
                                                            ${param.opsi_output.split(';').map(opt => `
                                                                <option value="${opt.trim()}" ${obxValues.duplo_d2 === opt.trim() ? 'selected' : ''}>
                                                                    ${opt.trim()}
                                                                </option>
                                                            `).join('')}
                                                        </select>
                                                    `}
                                                </td>
                                                <td class="col-2 duplo d3-column" style="display:none;">
                                                    ${param.tipe_inputan === 'text' ? `
                                                        <input type="text" name="duplo_d3[]" 
                                                            class="form-control d3 w-50 p-0 text-center"
                                                            disabled value="${obxValues.duplo_d3 || ''}" />
                                                    ` : `
                                                        <select name="duplo_d3[]" class="form-select d3 w-50 p-0" disabled>
                                                            ${param.opsi_output.split(';').map(opt => `
                                                                <option value="${opt.trim()}" ${obxValues.duplo_d3 === opt.trim() ? 'selected' : ''}>
                                                                    ${opt.trim()}
                                                                </option>
                                                            `).join('')}
                                                        </select>
                                                    `}
                                                </td>
                                                <td class="col-3 flag-cell">
                                                    ${renderFlag(obxValues.flag || flagContent(obxValues.hasilUtama, {innerHTML: ''}, p.data_pemeriksaan.nama_parameter))}
                                                </td>
                                                <td>
                                                    <input type="hidden" name="satuan[]" value="${param.satuan}" readonly />
                                                    ${param.satuan}
                                                </td>
                                            </tr>
                                        `;
                                    }).join('');

                                    return html;
                                } else if (hasMikrobiologi) {
                                // Jika ada mikrobiologi, tampilkan parameter mikrobiologi lengkap
                                const mikrobiologiPemeriksaan = e.pasiens.find(p =>
                                    p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('mikrobiologi')
                                );
                                const judulMikrobiologi = e.pasiens.find(p => p.data_pemeriksaan?.judul)?.data_pemeriksaan?.judul || '';
                                const namaPemeriksaanMikrobiologi = mikrobiologiPemeriksaan ? mikrobiologiPemeriksaan.data_pemeriksaan.nama_pemeriksaan : 'Mikrobiologi';
                                
                                let html = '';

                                // Tampilkan header judul hanya sekali
                                if (judulMikrobiologi) {
                                    html += `
                                        <tr class="mikrobiologi-title-header">
                                            <td colspan="8" class="fw-bold text-secondary ps-3" 
                                                style="background-color: #f8f9fa; border-left: 4px solid #28a745; padding: 10px;">
                                                ${judulMikrobiologi}
                                            </td>
                                        </tr>
                                    `;
                                }

                                // Loop semua parameter
                                html += MicrobiologiParams.map((param, paramIdx) => {
                                    const obxValues = getDataValues(param.nama); // ambil hasil
                                    const rowId = `mikrobiologi_${idx}_${paramIdx}`;

                                    return `
                                        <tr data-id="${rowId}" data-parameter="${param.nama}" class="mikrobiologi-row">
                                            <td class="col-2 ${judulMikrobiologi ? 'ps-4' : ''}" ${judulMikrobiologi ? 'style="border-left: 2px solid #e9ecef;"' : ''}>
                                                <strong>${param.display_name}</strong>
                                                ${param.nilai_rujukan !== '-' && param.nilai_rujukan !== '' ? 
                                                    `<small class="text-muted d-block">${param.nilai_rujukan ?? ''}</small>` : ''}
                                                
                                                <input type="hidden" name="nama_pemeriksaan[]" value="${namaPemeriksaanMikrobiologi}" />
                                                ${judulMikrobiologi ? `<input type="hidden" name="judul[]" value="${judulMikrobiologi}" />` : ''}
                                                <input type="hidden" name="parameter_name[]" value="${param.nama}" />
                                                <input type="hidden" name="nilai_rujukan[]" value="${param.nilai_rujukan ?? '-'}" />
                                                <input type="hidden" name="department[]" value="${e.data_departement.nama_department}" />
                                            </td>
                                            <td class="col-2 text-center">
                                                <div class="d-flex align-items-center justify-content-center gap-1">
                                                    ${param.tipe_inputan === 'Text' ? `
                                                        <input type="text"
                                                            name="duplo_dx[]"
                                                            class="form-control dx w-60 p-0 text-center"
                                                            value="${obxValues.duplo_dx || ''}" />
                                                    ` : `
                                                        <select name="duplo_dx[]" class="form-select dx w-60 p-0">
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

                                                    <input type="hidden"
                                                        name="is_switched[]"
                                                        value="${obxValues.switched ? 1 : 0}">

                                                    ${obxValues.switched ? `
                                                        <div class='checkbox-r-container d-flex align-items-center gap-1'>
                                                            <input type='checkbox' class='checkbox-r form-check-input' checked disabled>
                                                            <span class='text-danger fw-bold'>R</span>
                                                        </div>
                                                    ` : ''}
                                                </div>
                                            </td>
                                            <td class="col-1">
                                                <button type="button" class="btn btn-outline-secondary btn-sm switch-btn" 
                                                        data-index="${paramIdx}" data-switch-index="0">
                                                    <i class="ti ti-switch-2"></i>
                                                </button>
                                            </td>
                                            <td class="col-2">
                                                ${param.tipe_inputan === 'Text' ? `
                                                    <input type="text" name="duplo_dx[]" 
                                                        class="form-control  w-60 p-0 text-center" 
                                                        disabled value="${obxValues.duplo_dx || ''}" />
                                                ` : `
                                                    <select name="duplo_dx[]" class="form-select dx duplo_dx w-60 p-0" disabled>
                                                        ${param.opsi_output ? param.opsi_output.split(';').map(opt => `
                                                            <option value="${opt.trim()}" ${obxValues.duplo_dx === opt.trim() ? 'selected' : ''}>
                                                                ${opt.trim()}
                                                            </option>
                                                        `).join('') : '<option value="">Pilih...</option>'}
                                                    </select>
                                                `}
                                            </td>
                                            <td class="col-2 duplo d1-column text-center" style="display: none;">
                                                ${param.tipe_inputan === 'Text' ? `
                                                    <input type="text" name="duplo_d1[]" 
                                                        class="form-control d1 w-60 p-0 text-center" 
                                                        disabled value="${obxValues.duplo_d1 || ''}" />
                                                ` : `
                                                    <select name="duplo_d1[]" class="form-select d1 w-60 p-0" disabled>
                                                        ${param.opsi_output ? param.opsi_output.split(';').map(opt => `
                                                            <option value="${opt.trim()}" ${obxValues.duplo_d1 === opt.trim() ? 'selected' : ''}>
                                                                ${opt.trim()}
                                                            </option>
                                                        `).join('') : '<option value="">Pilih...</option>'}
                                                    </select>
                                                `}
                                            </td>
                                            <td class="col-2 duplo d2-column" style="display: none;">
                                                ${param.tipe_inputan === 'Text' ? `
                                                    <input type="text" name="duplo_d2[]" 
                                                        class="form-control d2 w-60 p-0 text-center" 
                                                        disabled value="${obxValues.duplo_d2 || ''}" />
                                                ` : `
                                                    <select name="duplo_d2[]" class="form-select d2 w-60 p-0" disabled>
                                                        ${param.opsi_output ? param.opsi_output.split(';').map(opt => `
                                                            <option value="${opt.trim()}" ${obxValues.duplo_d2 === opt.trim() ? 'selected' : ''}>
                                                                ${opt.trim()}
                                                            </option>
                                                        `).join('') : '<option value="">Pilih...</option>'}
                                                    </select>
                                                `}
                                            </td>
                                            <td class="col-2 duplo d3-column" style="display: none;">
                                                ${param.tipe_inputan === 'Text' ? `
                                                    <input type="text" name="duplo_d3[]" 
                                                        class="form-control d3 w-50 p-0 text-center" 
                                                        disabled value="${obxValues.duplo_d3 || ''}" />
                                                ` : `
                                                    <select name="duplo_d3[]" class="form-select d3 w-50 p-0" disabled>
                                                        ${param.opsi_output ? param.opsi_output.split(';').map(opt => `
                                                            <option value="${opt.trim()}" ${obxValues.duplo_d3 === opt.trim() ? 'selected' : ''}>
                                                                ${opt.trim()}
                                                            </option>
                                                        `).join('') : '<option value="">Pilih...</option>'}
                                                    </select>
                                                `}
                                            </td>
                                            <td class="col-3 flag-cell">
                                                <!-- Bisa disesuaikan kalau mikrobiologi perlu flag -->
                                            </td>
                                            <td>
                                                <input type="hidden" name="satuan[]" class="form-control w-100 p-0" 
                                                    value="${param.satuan || ''}" readonly />
                                                ${param.satuan || ''}
                                            </td>
                                        </tr>
                                    `;
                                }).join('');

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

                            e.pasiens.forEach((p, pIdx) => {
                                const judul = p.data_pemeriksaan?.judul;
                                const hasHeader = judul && judul !== p.data_pemeriksaan.nama_pemeriksaan;

                                // Tampilkan header judul jika ada
                                if (hasHeader) {
                                    html += `
                                        <tr class="individual-title-header">
                                            <td colspan="8" class="fw-bold text-dark ps-3"
                                                style="background-color:#f1f3f4; border-left:4px solid #6c757d; padding:10px;">
                                                ${judul}
                                            </td>
                                        </tr>
                                    `;
                                }

                                // Ambil hasil OBX
                                const obxValues = getDataValues(p.data_pemeriksaan.nama_parameter);
                                const rowId = p.data_pemeriksaan.id;

                                // Flag awal
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

                                html += `
                                    <tr data-id="${rowId}" data-parameter="${p.data_pemeriksaan.nama_parameter}">
                                        <td class="col-2 ${hasHeader ? 'ps-4' : ''}" ${hasHeader ? 'style="border-left:2px solid #e9ecef;"' : ''}>
                                            <strong>${hasHeader ? p.data_pemeriksaan.nama_parameter : p.data_pemeriksaan.nama_pemeriksaan}</strong>
                                            ${nilaiRujukanDisplay ? `<br><small class="text-muted">${nilaiRujukanDisplay}</small>` : ''}
                                            <input type="hidden" name="nama_pemeriksaan[]" value="${p.data_pemeriksaan.nama_pemeriksaan}" />
                                            <input type="hidden" name="judul[]" value="${judul || ''}" />
                                            <input type="hidden" name="parameter_name[]" value="${p.data_pemeriksaan.nama_parameter}" />
                                            <input type="hidden" name="nilai_rujukan[]" value="${p.data_pemeriksaan.nilai_rujukan || ''}" />
                                            <input type="hidden" name="department[]" value="${e.data_departement.nama_department}" />
                                        </td>

                                        <!-- Kolom hasil utama -->
                                        <td class="col-2">
                                            ${p.data_pemeriksaan.tipe_inputan === 'Dropdown' ? `
                                                <select name="hasil[]" class="form-select manualInput w-60 p-0" disabled>
                                                    ${p.data_pemeriksaan.opsi_output.split(';').map(opt => `
                                                        <option value="${opt.trim()}" ${obxValues.hasilUtama === opt.trim() ? 'selected' : ''}>
                                                            ${opt.trim()}
                                                        </option>
                                                    `).join('')}
                                                </select>
                                            ` : `
                                                <input type="text" name="hasil[]" 
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
                                                    <select name="duplo_dx[]" class="form-select dx w-60 p-0">
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
                                                        name="duplo_dx[]" 
                                                        class="form-control dx w-60 p-0 text-center"
                                                        value="${obxValues.duplo_dx || ''}" />
                                                `}

                                                <!-- Hidden input untuk kirim status switch -->
                                                <input type="hidden" 
                                                    name="is_switched[]" 
                                                    value="${obxValues.switched ? 1 : 0}">

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
                                                <select name="duplo_d1[]" class="form-select d1 w-60 p-0" disabled>
                                                    ${p.data_pemeriksaan.opsi_output.split(';').map(opt => `
                                                        <option value="${opt.trim()}" ${obxValues.duplo_d1 === opt.trim() ? 'selected' : ''}>
                                                            ${opt.trim()}
                                                        </option>
                                                    `).join('')}
                                                </select>
                                            ` : `
                                                <input type="text" name="duplo_d1[]" 
                                                    class="form-control d1 w-60 p-0 text-center" 
                                                    value="${obxValues.duplo_d1 || ''}" disabled />
                                            `}
                                        </td>

                                        <!-- Duplo D2 -->
                                        <td class="col-2 duplo d2-column text-center" style="display:none;">
                                            ${p.data_pemeriksaan.tipe_inputan === 'Dropdown' ? `
                                                <select name="duplo_d2[]" class="form-select d2 w-60 p-0" disabled>
                                                    ${p.data_pemeriksaan.opsi_output.split(';').map(opt => `
                                                        <option value="${opt.trim()}" ${obxValues.duplo_d2 === opt.trim() ? 'selected' : ''}>
                                                            ${opt.trim()}
                                                        </option>
                                                    `).join('')}
                                                </select>
                                            ` : `
                                                <input type="text" name="duplo_d2[]" 
                                                    class="form-control d2 w-60 p-0 text-center" 
                                                    value="${obxValues.duplo_d2 || ''}" disabled />
                                            `}
                                        </td>

                                        <!-- Duplo D3 -->
                                        <td class="col-2 duplo d3-column text-center" style="display:none;">
                                            ${p.data_pemeriksaan.tipe_inputan === 'Dropdown' ? `
                                                <select name="duplo_d3[]" class="form-select d3 w-50 p-0" disabled>
                                                    ${p.data_pemeriksaan.opsi_output.split(';').map(opt => `
                                                        <option value="${opt.trim()}" ${obxValues.duplo_d3 === opt.trim() ? 'selected' : ''}>
                                                            ${opt.trim()}
                                                        </option>
                                                    `).join('')}
                                                </select>
                                            ` : `
                                                <input type="text" name="duplo_d3[]" 
                                                    class="form-control d3 w-50 p-0 text-center" 
                                                    value="${obxValues.duplo_d3 || ''}" disabled />
                                            `}
                                        </td>

                                        <!-- Flag -->
                                        <td class="col-3 flag-cell">
                                            ${renderFlag(obxValues.flag || initialFlag(obxValues.hasilUtama, {innerHTML: ''}, p.data_pemeriksaan.nama_parameter))}
                                        </td>

                                        <!-- Satuan -->
                                        <td>
                                            <input type="hidden" name="satuan[]" 
                                                value="${p.data_pemeriksaan.nilai_satuan || ''}" readonly />
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

            setTimeout(() => {
                document.querySelectorAll('tr[data-parameter]').forEach(row => {
                    const hasilInput = row.querySelector('.manualInput');
                    const dxInput = row.querySelector('.dx, input[name="duplo_dx[]"], select[name="duplo_dx[]"]');
                    const hiddenSwitch = row.querySelector('input[name="is_switched[]"]');

                    if (!hasilInput || !dxInput || !hiddenSwitch) {
                        console.log('Element tidak ditemukan untuk row:', row.dataset.parameter);
                        return;
                    }

                    // Pastikan data original tersimpan
                    if (!hasilInput.dataset.original && hasilInput.value?.trim()) {
                        hasilInput.dataset.original = hasilInput.value.trim();
                    }

                    console.log('Checking parameter:', row.dataset.parameter, 'is_switched value:', hiddenSwitch.value);

                    // PERBAIKAN: Cek berdasarkan nilai is_switched dari database
                    if (hiddenSwitch.value === '1' || hiddenSwitch.value === 1) {
                        // Jika is_switched = 1, berarti sudah di-switch
                        // Tampilkan checkbox R di kolom DX
                        const existingCheckbox = dxInput.parentElement.querySelector('.checkbox-r-container');
                        if (!existingCheckbox) {
                            addCheckboxR(dxInput);
                            console.log('✅ Checkbox R ditampilkan untuk parameter:', row.dataset.parameter);
                        } else {
                            console.log('Checkbox R sudah ada untuk parameter:', row.dataset.parameter);
                        }
                    } else {
                        // Jika is_switched = 0, pastikan tidak ada checkbox R
                        removeCheckboxR(dxInput);
                        console.log('❌ Checkbox R dihapus untuk parameter:', row.dataset.parameter);
                    }
                });
            }, 100);

            // Event klik tombol switch
            document.querySelectorAll('.switch-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const hasilInput = row.querySelector('.manualInput');
                    const dxInput = row.querySelector('.dx, input[name="duplo_dx[]"], select[name="duplo_dx[]"]');
                    const flagCell = row.querySelector('.flag-cell');
                    const parameter = row.dataset.parameter;
                    const originalValue = hasilInput.dataset.original?.trim() || '';

                    if (!hasilInput || !dxInput) return;

                    // Tukar nilai
                    const tempHasil = hasilInput.value;
                    hasilInput.value = dxInput.value;
                    dxInput.value = tempHasil;

                    // Cek apakah nilai asli pindah ke DX
                    if (dxInput.value.trim() === originalValue && originalValue !== '') {
                        addCheckboxR(dxInput);
                        setSwitchStatus(row, 1);
                    } else if (hasilInput.value.trim() === originalValue) {
                        // Jika nilai asli kembali ke hasil utama
                        removeCheckboxR(dxInput);
                        setSwitchStatus(row, 0);
                    } else {
                        // Hilangkan R jika tidak ada nilai asli di DX
                        removeCheckboxR(dxInput);
                        setSwitchStatus(row, 0);
                    }

                    // Update flag hasil
                    if (flagCell && parameter) {
                        updateFlag(hasilInput.value, flagCell, parameter);
                    }
                });
            });

            // ✅ Tambahkan checkbox R + label teks “R” di sebelah DX
             function addCheckboxR(dxInput) {
                // Hapus yang lama jika ada
                removeCheckboxR(dxInput);

                // Pastikan parent element ada
                if (!dxInput.parentElement) return;

                const container = document.createElement('div');
                container.className = 'checkbox-r-container d-flex align-items-center gap-1';

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

                // Tambahkan setelah input DX
                dxInput.parentElement.appendChild(container);
                
                console.log('Checkbox R berhasil ditambahkan');
            }

            // Fungsi removeCheckboxR tetap sama
            function removeCheckboxR(dxInput) {
                const container = dxInput.parentElement?.querySelector('.checkbox-r-container');
                if (container) {
                    container.remove();
                    console.log('Checkbox R berhasil dihapus');
                }
            }

            // ✅ Fungsi untuk menambahkan/ubah input hidden is_switched[]
            function setSwitchStatus(row, value) {
                let hidden = row.querySelector('input[name="is_switched[]"]');
                if (!hidden) {
                    hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'is_switched[]';
                    row.appendChild(hidden);
                }
                hidden.value = value;
            }

         function switchAllHasilToDX() {
                // Ambil semua row yang memiliki data parameter
                const allRows = document.querySelectorAll('tr[data-parameter]');
                let switchedCount = 0;
                
                allRows.forEach(row => {
                    const hasilInput = row.querySelector('.manualInput'); // Field HASIL
                    const dxInput = row.querySelector('.dx, input[name="duplo_dx[]"], select[name="duplo_dx[]"]'); // Field DX
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
    
    // Fungsi untuk mengecek dan menampilkan kolom duplo - ALWAYS SHOW VERSION
    function checkAndShowDuploColumns() {
        const accordion = document.getElementById('accordionPemeriksaan');
        if (!accordion) {
            // console.log('Accordion not found');
            return;
        }
        
        // const d1Cells = accordion.querySelectorAll('.d1-column');
        // const d2Cells = accordion.querySelectorAll('.d2-column');
        // const d3Cells = accordion.querySelectorAll('.d3-column');
        
        // console.log('Found duplo cells:', {
        //     d1: d1Cells.length,
        //     d2: d2Cells.length,
        //     d3: d3Cells.length
        // });
        
        let hasD1 = false;
        let hasD2 = false;
        let hasD3 = false;
        
        // Check if any D1, D2, D3 values exist
        const duploInputs = accordion.querySelectorAll('input.d1, input.d2, input.d3');
        // console.log('Found duplo inputs:', duploInputs.length);
        
        duploInputs.forEach(input => {
            const value = input.value ? input.value.trim() : '';
            if (value !== '' && value !== '0' && value !== '0.00') {
                if (input.classList.contains('d1')) {
                    hasD1 = true;
                    // console.log('Found D1 data:', value);
                }
                if (input.classList.contains('d2')) {
                    hasD2 = true;
                    // console.log('Found D2 data:', value);
                }
                if (input.classList.contains('d3')) {
                    hasD3 = true;
                    // console.log('Found D3 data:', value);
                }
            }
        });
        
        // console.log('Duplo data status:', { hasD1, hasD2, hasD3 });
        
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
        
        // console.log('All duplo columns are now visible');
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
