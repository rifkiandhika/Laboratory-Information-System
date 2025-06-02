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
                                    {{-- <button class="btn btn-info btn-preview" data-id={{ $dpc->id }} data-bs-target="#modalSpesimen"
                                        data-bs-toggle="modal" ><i class="ti ti-eye"></i></button>
                                    <button class="btn btn-warning"><i class="ti ti-barcode"></i></button>
                                    <button class="btn btn-success btn-edit" data-id={{ $dpc->id }} data-bs-target="#modalEdit" data-bs-toggle="modal"><i class="ti ti-edit"></i></button>
                                    
                                    <form id="delete-form-{{ $dpc->id }}"
                                        action="{{ route('spesiment.destroy', $dpc->no_lab) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    
                                    <button class="btn btn-danger"
                                        onclick="confirmDelete({{ $dpc->id }})"><i
                                        class="ti ti-trash"></i>
                                    </button> --}}
                                    <!-- Tombol Edit -->
                                    <a style="cursor: pointer" data-id="{{ $dpc->no_lab }}" class="btn btn-sm btn-outline-secondary editBtn">
                                        <i title="Edit" class="ti ti-pencil"></i>
                                    </a>

                                    <!-- Tombol Sample History -->
                                    <button href="#" id="sampleHistoryBtn-{{ $dpc->id }}" class="btn btn-sm btn-outline-secondary mr-2 preview" data-id="{{ $dpc->id }}" data-bs-toggle="modal" data-bs-target="#sampleHistoryModal">
                                        <i title="Sample History" class="ti ti-clock"></i>
                                    </button>

                                    
                                    <!-- Tombol Selesaikan -->
                                    <form id="kirimresult-{{ $dpc->id }}" action="result/done/{{ $dpc->id }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    <!-- Tombol Selesaikan -->
                                    <button class="btn btn-sm btn-outline-secondary" onclick="confirmResult({{ $dpc->id }})" {{ $dpc->status == 'diselesaikan' ? 'disabled' : '' }} id="selesaikanBtn-{{ $dpc->id }}">
                                        <i title="Selesaikan" class="ti ti-checklist"></i>
                                    </button>

                                    <!-- Tombol Print -->
                                    <button class="btn btn-sm btn-outline-secondary" id="printBtn-{{ $dpc->id }}" onclick="openModal('{{ $dpc->no_lab }}')" {{ $dpc->status != 'diselesaikan' ? 'disabled' : '' }}>
                                        <i title="Print Result" class="ti ti-printer"></i>
                                    </button>

                                        {{-- <button class="btn btn-sm btn-outline-primary" data-id={{ $dpc->no_lab }} data-bs-toggle="modal"data-bs-target="#printResult">Print Result</button> --}}

                                                
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
                {{-- Print Result --}}
                {{-- <div class="modal fade" id="printResult" tabindex="-1" aria-labelledby="printResultLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="printResultLabel">Preview Cetak Hasil</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <iframe src="{{ route('print.pasien', $dpc->no_lab) }}" frameborder="0"></iframe>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="button" class="btn btn-primary">Print</button>
                            </div>
                        </div>
                    </div>
                </div> --}}
              </div>
          </div>
      </div>
      </div>
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
    
    <!-- Button untuk setiap baris data -->
@foreach ( $dataPasien as $x => $dpc )
<button class="btn btn-sm btn-outline-secondary" onclick="openModal('{{ $dpc->no_lab }}')" {{ $dpc->status != 'diselesaikan' ? 'disabled' : '' }}>
    <i title="Print Result" class="ti ti-printer"></i>
</button>
@endforeach
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
    let noteModal = null;

    function openModal(noLab) {
        if (!noteModal) {
            noteModal = new bootstrap.Modal(document.getElementById('noteModal'));
        }
        document.getElementById('currentNoLab').value = noLab;
        document.getElementById('patientNote').value = '';
        noteModal.show();
    }

    function submitNote() {
        const note = document.getElementById('patientNote').value;
        const noLab = document.getElementById('currentNoLab').value;

        if (note.trim() === "") {
            alert("Please enter a note before printing.");
            return;
        }

        // Tambahkan prefix 'analyst' ke URL
        const printUrl = `{{ url('analyst/print/pasien') }}/${noLab}?note=${encodeURIComponent(note)}`;
        
        window.open(printUrl, '_blank');
        noteModal.hide();
    }
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
                console.log(res);
                if (res.status === 'success') {
                    const data_pasien = res.data;
                    const data_pemeriksaan_pasien = res.data.dpp;
                    const history = res.data.history;
                    const spesimen = res.data.spesiment; // Load spesimen data
                    const scollection = res.data.spesimentcollection;
                    const shandling = res.data.spesimenthandling;
                    const hasil = res.data.hasil_pemeriksaan;

                    // Populate Modal
                    let accordionContent = '';

                    accordionContent += `
                    <hr>
                    <h5>Detail Sampling</h5>
                    <hr>
                    <h5>History</h5>
                    <ul class="step-wizard-list mt-4">
                        ${history.map((h, index) => {
                            // Membuat objek Date dari h.created_at
                            let createdAt = new Date(h.created_at);

                            // Format tanggal dan waktu sesuai dengan yang diinginkan
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

                    spesimen.forEach(e => {
        let details = '';
        let detailsData = [];
        let kapasitas, serumh, serum;
        let processTime = '';

        const checkInSpesimen = history.find(h => h.status === 'Check in spesiment');
        let noteFromCollection = null;
        let noteFromHandling = null;

        if (e.tabung === 'K3-EDTA') {
            const collectionItem = scollection.find(item => item.no_lab === e.laravel_through_key);
            if (collectionItem) {
                detailsData = collectionItem.details.filter(detail => 
                    e.details.some(spesimenDetail => spesimenDetail.id === detail.id)
                );
                kapasitas = collectionItem.kapasitas;
                noteFromCollection = collectionItem.note;
            }
        } else if (e.tabung === 'K3') {
            const collectionItem = scollection.find(item => 
                item.no_lab === e.laravel_through_key && item.tabung === 'K3'
            );
            if (collectionItem) {
                detailsData = collectionItem.details.filter(detail => 
                    e.details.some(spesimenDetail => spesimenDetail.id === detail.id)
                );
                serumh = collectionItem.serumh;
                noteFromCollection = collectionItem.note;
            }
        } else if (e.tabung === 'CLOT-ACT') {
            const handlingItem = shandling.find(item => item.no_lab === e.laravel_through_key);
            if (handlingItem) {
                detailsData = handlingItem.details.filter(detail => 
                    e.details.some(spesimenDetail => spesimenDetail.id === detail.id)
                );
                serum = handlingItem.serum;
                noteFromHandling = handlingItem.note;
            }
        }

        if (e.details && e.details.length > 0){
            details = `<div class="detail-container col-12 col-md-6">`;
            e.details.forEach(detail => {
                const imageUrl = `/gambar/${detail.gambar}`;
                let isChecked = '';
                let isDisabled = 'disabled';

                const matchedDetail = detailsData.find(d => d.id === detail.id)
                if(matchedDetail){
                    if (e.tabung === 'K3-EDTA' && kapasitas == detail.id) {
                        isChecked = 'checked';
                        isDisabled = '';
                    } else if (e.tabung === 'K3' && serumh == detail.id) {
                        isChecked = 'checked';
                        isDisabled = '';
                    } else if (e.tabung === 'CLOT-ACT' && serum == detail.id) {
                        isChecked = 'checked';
                        isDisabled = '';
                    }
                }

                details +=  
                `<div class="detail-item">
                    <div class="detail-text">${detail.nama_parameter}</div>
                    <div class="detail-image-container">
                        <img src="${imageUrl}" alt="${detail.nama_parameter}" width="35" class="detail-image"/>    
                    </div>
                    <div class="detail-radio-container ">
                        <input type="radio" name="${e.tabung}" class="detail.radio" value="${detail.id}" ${isChecked} ${isDisabled} />  
                    </div>
                </div>`;
            });
            details += `</div>`
        }

        let title = '';
        let subtext = '';

        if (e.tabung === 'K3-EDTA') {
            title = '<h5 class="title">Spesiment Collection</h5> <hr>';
        } else if (e.tabung === 'CLOTH-ACT') {
            subtext = '<div class="subtext">Serum</div>';
        } else if (e.tabung === 'CLOT-ACT') {
            title = '<h5 class="title mt-3">Spesiment Handlings</h5> <hr>';
            subtext = '<div class="subtext">Serum</div>';
        }

        let note = '';
        if (e.tabung === 'K3-EDTA' || e.tabung === 'CLOT-ACT' || e.tabung === 'CLOTH-ACT') {
            note = '<p class="mb-0"><strong>Note</strong></p>';
        }

        accordionContent += `${title}
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
                            ${e.tabung === 'K3-EDTA' ? 
                                `<textarea class="form-control" name="note[]" row="3" placeholder="${noteFromCollection || 'null'}" ${noteFromCollection ? '' : 'disabled'} disabled></textarea>` : ''}
                            ${e.tabung === 'CLOTH-ACT' ? 
                                `<textarea class="form-control" name="note[]" row="3" placeholder="${noteFromCollection || 'null'}" ${noteFromCollection ? '' : 'disabled'} disabled></textarea>` : ''}
                            ${e.tabung === 'CLOT-ACT' ? 
                                `<textarea class="form-control" name="note[]" row="3" placeholder="${noteFromHandling || 'null'}" ${noteFromHandling ? '' : 'disabled'} disabled></textarea>` : ''}
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
                    

                    // let detailContent = `
                    //     <div class="row mb-3">
                    //         <div class="header text-center mb-3">
                    //             <h4>Data Pemeriksaan Pasien</h4>
                    //         </div>
                    //         <hr>
                    //         <div class="col-lg-7 col-md-5 col-sm-12">
                    //             <div class="row mb-1">
                    //                 <label class="col-5 col-form-label fw-bold">Cito</label>
                    //                 <div class="col-7">
                    //                     : <i class='ti ti-bell-filled text-danger' style="font-size: 23px;"></i>
                    //                 </div>
                    //             </div>
                    //             <div class="row mb-1">
                    //                 <label class="col-5 col-form-label fw-bold">No LAB</label>
                    //                 <div class="col-7">
                    //                     <input type="text" readonly class="form-control-plaintext" value=": ${data_pasien.no_lab}">
                    //                 </div>
                    //             </div>
                    //             <div class="row mb-1">
                    //                 <label class="col-5 col-form-label fw-bold">No RM</label>
                    //                 <div class="col-7">
                    //                     <input type="text" readonly class="form-control-plaintext" value=": ${data_pasien.no_rm}">
                    //                 </div>
                    //             </div>
                    //             <div class="row mb-1">
                    //                 <label class="col-5 col-form-label fw-bold">Nama</label>
                    //                 <div class="col-7">
                    //                     <input type="text" readonly class="form-control-plaintext" value=": ${data_pasien.nama}">
                    //                 </div>
                    //             </div>
                    //             <div class="row mb-1">
                    //                 <label class="col-5 col-form-label fw-bold">Ruangan</label>
                    //                 <div class="col-7">
                    //                     <input type="text" readonly class="form-control-plaintext" value=": ${data_pasien.asal_ruangan}">
                    //                 </div>
                    //             </div>
                    //             <div class="row mb-1">
                    //                 <label class="col-5 col-form-label fw-bold">Tanggal Lahir Usia</label>
                    //                 <div class="col-7">
                    //                     <input type="text" readonly class="form-control-plaintext" value=": ${data_pasien.lahir} Tahun">
                    //                 </div>
                    //             </div>
                    //             <div class="row mb-1">
                    //                 <label class="col-5 col-form-label fw-bold">Dokter</label>
                    //                 <div class="col-7">
                    //                     <input type="text" readonly class="form-control-plaintext" value=": ${data_pasien.dokter.nama_dokter}">
                    //                 </div>
                    //             </div>
                    //         </div>
                    // `;

                    // detailContent += accordionContent;
                    previewDataPasien.innerHTML = accordionContent;

                    loader.hide();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                loader.hide();
            });
});
</script>
<script src="{{ asset('../js/ak.js') }}"></script>
@endpush
