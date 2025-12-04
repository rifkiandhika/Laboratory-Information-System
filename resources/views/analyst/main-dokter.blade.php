@extends('layouts.admin')
@section('title', 'Doctor')

@section('content')
<link rel="stylesheet" href="{{ asset('css/timeline.css') }}">
<style>
    @keyframes fadeInOut {
    0%, 100% { opacity: 0; }
    50% { opacity: 1; }
}

.blinking-icon {
    animation: fadeInOut 2s infinite;
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
<section>
    <div class="content" id="scroll-content">
        <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex  mt-3">
            <h1 class="h3 mb-0 text-gray-600">Doctor Verification</h1>
        </div>

        <!-- Content Row -->
        <div class="row mt-2">
            <div class="col-xl-3 col-lg-3">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold" style="color: #96B6C5;">Antrian Pasien</h6>
                </div>
                <div class="card-body">
                {{-- <div class="d-flex justify-content-between tombol-filter mb-2">
                    <a href="#">FILTER</a>
                    <div class="checkbox-rect">
                    <input style="cursor: pointer" class="form-check-input" type="checkbox" id="checkbox-rect1" name="check-it">
                    <label for="checkbox-rect1">Select All</label>
                    </div>
                </div> --}}
                <div class="table-responsive">
                    <table class="table table-striped" style="font-size: 12px;">
                    <thead>
                        <tr>
                        <th scope="col"><i class="ti ti-hand-click" style="font-size: 18px;"></i></th>
                        <th scope="col">No LAB</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Cito</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Verifikasi Dokter --}}
                        @foreach ( $dataPasien as $dpc )
                            <tr>
                                
                                <th scope="row"><i class="ti ti-clock text-warning"></i></th>
                                <td>
                                    <a href="#" class="preview" data-id={{ $dpc->id }}>{{ $dpc->no_lab }}</a>
                                    
                                </td>
                                <td>{{ $dpc->nama }}</td>
                                <td class="text-center">
                                    <i class='ti ti-bell-filled mt-2 ml-1 {{ $dpc->cito == '1' ? 'text-danger' : 'text-secondary' }}'
                                        style="font-size: 23px;"></i>
                                </td>
                            </tr>
                        @endforeach
                        {{-- Diverifikasi Ulang --}}
                        @foreach ( $verifikasi as $vu )
                            <tr>
                                
                                {{-- <th scope="row"><input class="form-check-input mt-2" style="font-size: 15px; cursor: pointer;" type="checkbox"  name="pilih"></th> --}}
                                
                                <th scope="row"><i class="ti ti-circle-dashed-check text-success blinking-icon"></i></th>
                                <td>
                                    <a href="#" class="preview" data-id={{ $vu->id }}>{{ $vu->no_lab }}</a>
                                    
                                </td>
                                <td>{{ $vu->nama }}</td>
                                <td class="text-center">
                                    <i class='ti ti-bell-filled mt-2 ml-1 {{ $vu->cito == '1' ? 'text-danger' : 'text-secondary' }}'
                                        style="font-size: 23px;"></i>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
                    </div>
                </div>
            </div>
            </div>

            <div class="col-xl-9 col-lg-9">
            <div class="card shadow mb-4">
                <div class="card-body table-responsive mt-1">
                <div class="preview-data-pasien" id="previewDataPasien">
                    <!-- tampilan data pasien-->
                    <div style="background-color: #F5F7F8" class="text-center bg-body-tertiary"><p>Pilih Pasien</p></div>
                </div>
                <hr>
                <!-- Modal -->
                
            </div>
            <div class="modal fade" id="sampleHistoryModal" tabindex="-1" aria-labelledby="sampleHistoryModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="sampleHistoryModalLabel">Sample History</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="accordion" id="sampleHistoryAccordion"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        </div>

    </div>
</section>
  
@endsection

<!-- Preview Pasien -->
@push('script')

{{-- <script>
    const checkit = document.getElementById('checkbox-rect1');
    const pilih = document.getElementsByName('pilih');

    checkit.addEventListener('click', function(){
      if(this.checked){
        for(var i=0; i<pilih.length; i++){
          pilih[i].checked = true;
        }
      }else{
        for(var i=0; i<pilih.length; i++){
          pilih[i].checked = false;
        }
      }
    });
  </script> --}}
{{-- <script>
    $(function() {
        $('.preview').on('click', function(event) {
            event.preventDefault();
            const id = this.getAttribute('data-id');
            const previewDataPasien = document.getElementById('previewDataPasien');
            const loader = previewDataPasien.querySelector('#loader');

            loader.style.display = 'block';

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
                        
                        const timelineItems = history.map(h => {
                            const waktu = new Date(h.waktu_proses);
                            const waktuFormatted = waktu.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                            return `
                                <div class="timeline-item w-100">
                                    <div class="timeline-item-marker">
                                        <div class="timeline-item-marker-text">${waktuFormatted}</div>
                                        <div class="timeline-item-marker-indicator clear text-white"><i class="bi bi-check-lg mb-2"></i></div>
                                    </div>
                                    <div class="timeline-item-content">${h.proses}</div>
                                </div>
                            `;
                        }).join('');

                        console.log(data_pasien);
                        console.log(data_pemeriksaan_pasien);

                        let detailContent = '<div class="row">';

                        // Menampilkan data pasien (hanya sekali)
                        detailContent += `
                        <div class="row mb-3">
                            <div class="header text-center mb-3"><h4>Data Pemeriksaan Pasien</h4></div>
                            <hr>
                            <div class="col-lg-7 mb-2 table-borderless">
                                <div class="row" style="margin-bottom: -5px;">
                                    <label for="staticEmail" class="col-sm-5 col-form-label font-bold">Cito</label>
                                    <div class="col-lg-2">
                                       : <i class='bi bi-bell-fill mt-2 ml-1 text-danger' style="font-size: 23px;"></i>
                                    </div>
                                </div>
                                <div class="row mt-2" style="margin-bottom: -10px;">
                                    <label for="staticEmail" class="col-sm-5 col-form-label font-bold">No LAB</label>
                                    <div class="col-lg-6">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ${data_pasien.no_lab}">
                                    </div>
                                </div>
                                <div class="row mt-2" style="margin-bottom: -10px;">
                                    <label for="staticEmail" class="col-sm-5 col-form-label font-bold">No RM</label>
                                    <div class="col-lg-6">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ${data_pasien.no_rm}">
                                    </div>
                                </div>
                                <div class="row mt-2" style="margin-bottom: -10px;">
                                    <label for="staticEmail" class="col-sm-5 col-form-label font-bold">Nama</label>
                                    <div class="col-lg-6">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ${data_pasien.nama}">
                                    </div>
                                </div>
                                <div class="row mt-2" style="margin-bottom: -10px;">
                                    <label for="staticEmail" class="col-sm-5 col-form-label font-bold">Ruangan</label>
                                    <div class="col-lg-6">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ${data_pasien.asal_ruangan}">
                                    </div>
                                </div>
                                <div class="row mt-2" style="margin-bottom: -10px;">
                                    <label for="staticEmail" class="col-lg-5 col-form-label font-bold">Tanggal Lahir Usia</label>
                                    <div class="col-lg-6">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ${data_pasien.lahir} Tahun">
                                    </div>
                                </div>
                                <div class="row mt-2" style="margin-bottom: -10px;">
                                    <label for="staticEmail" class="col-sm-5 col-form-label font-bold">Dokter</label>
                                    <div class="col-lg-6">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ${data_pasien.dokter.nama_dokter}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 table-borderless">
                                <!-- Timeline -->
                                <div class="timeline timeline-sm">
                                    ${timelineItems}
                                </div>
                            </div>
                        </div>
                        <hr>
                        `;

                        detailContent += `</div> 
                                        </div>
                                    </div>`;

                        detailContent += getButtonContent();
                        detailContent += getTableContent(data_pemeriksaan_pasien);

                        previewDataPasien.innerHTML = detailContent;

                        loader.style.display = 'none';
                        console.log(detailContent);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    
                    loader.style.display = 'none';
                });
        });
        function getButtonContent() {
            return `
                <div class="preview-button" id="preview-button">
                    <div class="row">
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-outline-secondary btn-block">Manual</button>
                        </div>
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-outline-primary btn-block">Duplo</button>
                        </div>
                        <div class="col-lg-3">
                            <button type="button" class="btn btn-outline-info btn-block" data-bs-toggle="modal" data-bs-target="#sampleHistoryModal">Sample History</button>
                        </div>
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-outline-danger btn-block">Delete</button>
                        </div>
                    </div>
                </div>
                <hr>
            `;
        }

        function getTableContent(data_pemeriksaan_pasien) {
            return `
                <table class="table">
                    <thead>
                        <tr scope="row">
                            <th class="col-3" >Parameter</th>
                            <th class="col-3">Hasil</th>
                            <!-- Kondisi Duplo -->
                            <th class="col-2">D1</th>
                            <th class="col-2">D2</th>
                            <th class="col-2">Flag</th>
                            <th class="col-3">Satuan</th>
                            <th class="col-3">Range</th>
                        </tr>
                    </thead>
                    <tbody>
                    ${data_pemeriksaan_pasien.map(e => `
                    <th scope="row">${e.data_departement.nama_department}</th>
                        ${e.pasiens.map(p => `
                        <tr class="mt-2">
                            <td>${p.data_pemeriksaan.nama_pemeriksaan}</td>
                            <td><input type="number" class="form-control w-50 p-0" /></td>
                            <td><input style="background-color" type="number" class="form-control w-50 p-0" readonly /></td>
                            <td><input type="number" class="form-control w-50 p-0" readonly/></td>
                            <td></td>
                            <td>test</td>
                            <td>1-10</td>
                        </tr>
                        `).join('')}
                    `).join('')}
                    </tbody>
                </table>
                <div class="row mt-3">
                    <div class="col-lg-6">
                        <button type="button" class="btn btn-outline-info btn-block">Verifikasi Hasil</button>
                    </div>
                    <div class="col-lg-6">
                        <button type="button" class="btn btn-outline-primary btn-block">Verifikasi Dokter PK</button>
                    </div>
                </div>
            `;
        }
    });
</script> --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {

    $(function() {
        // {{-- fungsi menghitung usia --}}
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
        // fungsi preview

        $('.preview').on('click', function(event) {
            event.preventDefault();
            const id = this.getAttribute('data-id');
            const previewDataPasien = document.getElementById('previewDataPasien');
            const loader = $('#loader');

            // loader.style.display = 'block';
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
                        const spesimen = res.data.spesiment; // Load spesimen data
                        const scollection = res.data.spesimentcollection;
                        const shandling = res.data.spesimenthandling;
                        const hasil = res.data.hasil_pemeriksaan;

                        populateModal(spesimen, scollection, shandling, history, data_pemeriksaan_pasien, hasil);
                        function getDokterDisplay(labData, dokterData) {
                        // Jika tidak ada data
                        if (!labData || !dokterData) {
                            return "Dokter tidak tersedia";
                        }

                        // Ambil kode dokter dari data lab
                        const kodeDokterLab = labData?.kode_dokter;

                        // Cek jika kode dokter lab sama dengan kode dokter di data dokter
                        if (kodeDokterLab === dokterData.kode_dokter) {
                            return dokterData.nama_dokter;
                        }

                        // Jika tidak sama, kembalikan kode dokter dari lab
                        return kodeDokterLab || "Dokter tidak tersedia";
                    }

                    // Penggunaan
                    const labData = data_pasien; // Data lab dengan kode_dokter
                    const dokterData = data_pasien.kode_dokter; // Data dokter

                    let dokterDisplay = getDokterDisplay(labData, dokterData);

                    // Set nilai ke input
                    let inputElement = document.querySelector('[name="dokter"]');
                    if (inputElement) {
                        inputElement.value = dokterDisplay;
                    }

                    // Debug logs
                    // console.log('Lab Data:', labData);
                    // console.log('Dokter Data:', dokterData);
                    // console.log('Display Value:', dokterDisplay);

                        let detailContent = '<div class="row">';

                        // Menampilkan data pasien (hanya sekali)
                        detailContent += `
                        <div class="row mb-3">
                            <div class="header text-center mb-3">
                                <h4>Data Pemeriksaan Pasien</h4>
                            </div>
                            <hr>
                            <div class="col-lg-7 col-md-5 col-sm-12">
                                <!-- Left Column -->
                                <div class="row mb-1">
                                    <label class="col-5 col-form-label fw-bold">Cito</label>
                                    <div class="col-7">
                                    : <i class='ti ti-bell-filled text-danger' style="font-size: 23px;"></i>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label class="col-5 col-form-label fw-bold">No LAB</label>
                                    <div class="col-7">
                                        <input type="text" readonly class="form-control-plaintext" value=": ${data_pasien.no_lab}">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label class="col-5 col-form-label fw-bold">No RM</label>
                                    <div class="col-7">
                                        <input type="text" readonly class="form-control-plaintext" value=": ${data_pasien.no_rm}">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label class="col-5 col-form-label fw-bold">Nama</label>
                                    <div class="col-7">
                                        <input type="text" readonly class="form-control-plaintext" value=": ${data_pasien.nama}">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label class="col-5 col-form-label fw-bold">Ruangan</label>
                                    <div class="col-7">
                                        <input type="text" readonly class="form-control-plaintext" value=": ${data_pasien.asal_ruangan}">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label class="col-5 col-form-label fw-bold">Tanggal Lahir Usia</label>
                                    <div class="col-7">
                                        <input type="text" readonly class="form-control-plaintext" value=": ${data_pasien.lahir}, ${calculateAge(data_pasien.lahir)} Tahun">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label class="col-5 col-form-label fw-bold">Dokter</label>
                                    <div class="col-7">
                                        <input type="text" readonly class="form-control-plaintext" value=": ${dokterDisplay} ">
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-lg-5 col-md-6 col-sm-12">
                                <!-- Right Column - Timeline -->
                                <div class="timeline timeline-sm">
                                    ${timelineItems}
                                </div>
                            </div> --}}
                        </div>
                        <hr>
                        `;

                        detailContent += `</div> 
                                        </div>
                                    </div>`;

                        detailContent += getButtonContent(data_pasien);
                        detailContent += getTableContent(data_pemeriksaan_pasien, data_pasien, hasil);

                        previewDataPasien.innerHTML = detailContent;

                        // loader.style.display = 'none';
                        loader.hide();



                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    
                    loader.hide();
                });
        });

        function getButtonContent(data_pasien) {
            return `
                <div class="preview-button" id="preview-button">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <button type="button" class="btn btn-outline-info btn-block w-100" data-bs-toggle="modal" data-bs-target="#sampleHistoryModal">Sample History<span class="badge bg-danger" style="display: none;">!</span></button>
                        </div>
                    </div>
                </div>
            `;
        }

       function getTableContent(data_pemeriksaan_pasien, data_pasien, hasil) {
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

    // Tambahkan parameter Urine
    const UrineParams = [
        {
            judul: 'Urine Lengkap',
            nama: 'Warna',
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
            nama: 'Leukosit',
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
            nama: 'Eritrosit',
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
            nama: 'Leukosit_sedimen',
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
            nama: 'Epithel',
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
            nilai_rujukan: 'Tidak ada',
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
            nilai_rujukan: 'Tidak ada',
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
            nilai_rujukan: 'Tidak ada',
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
            nilai_rujukan: 'Tidak ada',
            nilai_kritis: 'L.- P.-',
            metode: '-',
            tipe_inputan : 'Dropdown',
            opsi_output : 'Negatif;Positif;Positif(+);Positif(++);Positif(+++)',
            default: 'Negatif'
        },
        {
            judul: 'Sedimen',
            nama: 'Lain-lain',
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
    // Parameter Miccrobiologi
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
            judul: '',
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
            nama: 'Warna',
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
            tipe_inputan: 'Dropdown',
            nilai_kritis: 'L.- P.-',
            metode: '-',
            opsi_output: 'Tidak ditemukan;Entamoeba histolytica;Giardia lamblia;Lainnya',
            default: 'Tidak ditemukan'
        },
        {
            judul: 'Feses',
            nama: 'Leukosit',
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
    const HapusanDarahParams = [
                {
                    judul: 'Hapusan Darah',
                    nama: 'Eritrosit',
                    display_name: 'Eritrosit',
                    satuan: '-',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: '-',
                    tipe_inputan : 'text',
                    opsi_output : '',
                    default: 'Normal'
                },
                {
                    judul: 'Hapusan Darah',
                    nama: 'Leukosit',
                    display_name: 'Leukosit',
                    satuan: '-',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: '-',
                    tipe_inputan : 'text',
                    opsi_output : '',
                    default: 'Normal'
                },
                {
                    judul: 'Hapusan Darah',
                    nama: 'Trombosit',
                    display_name: 'Trombosit',
                    satuan: '-',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: '-',
                    tipe_inputan : 'text',
                    opsi_output : '', 
                    default: 'Normal'
                },
                {
                    judul: 'Hapusan Darah',
                    nama: 'Kesimpulan',
                    display_name: 'Kesimpulan',
                    satuan: '-',
                    normal_min: 'L.- P.-',
                    normal_max: 'L.- P.-',
                    nilai_rujukan: '-',
                    tipe_inputan : 'text',
                    opsi_output : '',
                    default: '-' 
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
    <form id="dokterForm-${data_pasien.id}" method="POST">
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
                                                p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('darah lengkap')
                                            );

                                            const hasHapusanDarah = e.pasiens.some(p => {
                                                const isHapusanDarah = p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('hapusan darah');
                                                return isHapusanDarah;
                                            });
                                            
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

                                                    const renderField = (name, value, className) => {
                                                        if (param.tipe_inputan === 'Dropdown') {
                                                            return `
                                                                <select name="${name}[]" class="form-select ${className} w-60 p-0">
                                                                    <option value="" hidden>Pilih...</option>
                                                                    ${param.opsi_output.split(';').map(opt => `
                                                                        <option value="${opt.trim()}" ${value === opt.trim() ? 'selected' : ''}>${opt.trim()}</option>
                                                                    `).join('')}
                                                                </select>
                                                            `;
                                                        } else {
                                                            return `
                                                                <input type="text" name="${name}[]" 
                                                                    class="form-control ${className} w-60 p-0 text-center" 
                                                                     value="${value || ''}" />
                                                            `;
                                                        }
                                                    };

                                                    return `
                                                        <tr data-id="${rowId}" data-parameter="${param.nama}" class="serologi-row">
                                                            <!-- Nama parameter -->
                                                            <td class="col-2 ps-4">
                                                                <strong>${label}</strong>
                                                                ${param.nilai_rujukan ? `<small class="text-muted d-block">${param.nilai_rujukan}</small>` : ''}
                                                                <input type="hidden" name="nama_pemeriksaan[]" value="${param.nama}" />
                                                                <input type="hidden" name="judul[]" value="${judul}" />
                                                                <input type="hidden" name="parameter_name[]" value="${param.nama}" />
                                                                <input type="hidden" name="nilai_rujukan[]" value="${param.nilai_rujukan}" />
                                                                <input type="hidden" name="department[]" value="${e.data_departement.nama_department}" />
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
                                                            <td class="col-3 flag-cell"></td>

                                                            <!-- Satuan -->
                                                            <td>
                                                                <input type="hidden" name="satuan[]" value="${param.satuan || ''}" />
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
                                                            <input type="hidden"  value="${param.nama}" />
                                                            ${judulHematologi ? `<input type="hidden" value="${judulHematologi}" />` : ''}
                                                            <input type="hidden" value="${e.data_departement.nama_department}" />
                                                        </td>
                                                        <td class="col-2">
                                                            <input type="number" 
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
                                                            <input type="number" 
                                                                class="form-control d1 w-60 p-0 text-center" 
                                                                value="${dataValues.duplo_d1}" step="0.01" readonly />
                                                        </td>
                                                        <td class="col-2 duplo d2-column" style="display: ${duploStatus.hasD2 ? 'table-cell' : 'none'};">
                                                            <input type="number"  
                                                                class="form-control d2 w-60 p-0 text-center" 
                                                                value="${dataValues.duplo_d2}" step="0.01" readonly />
                                                        </td>
                                                        <td class="col-2 duplo d3-column" style="display: ${duploStatus.hasD3 ? 'table-cell' : 'none'};">
                                                            <input type="number"  
                                                                class="form-control d3 w-50 p-0 text-center" 
                                                                value="${dataValues.duplo_d3}" step="0.01" readonly />
                                                        </td>
                                                        <td class="col-3 flag-cell">
                                                            ${renderFlag(dataValues.flag || flagContent(dataValues.hasilUtama, {innerHTML: ''}, p.data_pemeriksaan.nama_parameter))}
                                                        </td>
                                                        <td>
                                                            <input type="hidden"  class="form-control w-100 p-0" 
                                                                value="${dataValues.satuan || param.satuan}" readonly />
                                                            <input type="hidden" class="form-control w-100 p-0" 
                                                                value="${dataValues.range || param.normal_min + '-' + param.normal_max}" readonly />
                                                            ${dataValues.satuan || param.satuan}
                                                        </td>
                                                    </tr>
                                                `;
                                            }).join('');

                                            return html;
                                        }if (hasHapusanDarah) {
                                            const hapusanDarahPemeriksaan = e.pasiens.find(p => 
                                                p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('hapusan darah')
                                            );
                                            const judulHapusan = e.pasiens.find(p => p.data_pemeriksaan?.judul)?.data_pemeriksaan?.judul || '';
                                            const namaPemeriksaanHapusan = hapusanDarahPemeriksaan ? hapusanDarahPemeriksaan.data_pemeriksaan.nama_pemeriksaan : 'Hapusan Darah';
                                            
                                            let html = '';
                                            
                                            if (judulHapusan) {
                                                html += `
                                                    <tr class="hapusan-title-header">
                                                        <td colspan="5" class="fw-bold text-primary ps-3" style="background-color: #e3f2fd; border-left: 4px solid #2196f3; padding: 10px;">
                                                            ${judulHapusan}
                                                        </td>
                                                    </tr>
                                                `;
                                            }
                                            
                                            html += HapusanDarahParams.map((param, paramIdx) => {
                                                const obxValues = getDataValues(param.nama);
                                                const rowId = `hapusan_${idx}_${paramIdx}`;
                                                
                                                return `
                                                    <tr data-id="${rowId}" data-parameter="${param.nama}" class="hapusan-row">
                                                        <td class="col-2 ${judulHapusan ? 'ps-4' : ''}" ${judulHapusan ? 'style="border-left: 2px solid #e9ecef;"' : ''}>
                                                            <strong>${param.display_name}</strong>
                                                            <input type="hidden" name="nama_pemeriksaan[]" value="${namaPemeriksaanHapusan}" />
                                                            ${judulHapusan ? `<input type="hidden" name="judul[]" value="${judulHapusan}" />` : ''}
                                                            <input type="hidden" name="parameter_name[]" value="${param.nama}" />
                                                            <input type="hidden" name="metode[]" value="${param.metode ?? ''}" />
                                                            <input type="hidden" name="department[]" value="${e.data_departement.nama_department}" />
                                                        </td>
                                                        <td class="col-8" colspan="3">
                                                            <textarea name="hasil[]" 
                                                                class="form-control manualInput w-100" 
                                                                rows="3"
                                                                placeholder="Masukkan hasil pemeriksaan..."
                                                                required
                                                                style="resize: vertical; min-height: 60px; width: 100% !important;">${obxValues.hasilUtama || ''}</textarea>
                                                        </td>
                                                        <td class="col-1 text-center">
                                                            <input type="hidden" name="satuan[]" class="form-control" 
                                                                value="${param.satuan}" readonly />
                                                            <span class="text-muted">${param.satuan}</span>
                                                        </td>
                                                    </tr>
                                                `;
                                            }).join('');
                                            
                                            return html;
                                        }
                                         else if (hasWidal) {
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
                                                    <input type="hidden" value="${namaPemeriksaanWidal}" />
                                                    ${judulWidal ? `<input type="hidden" value="${judulWidal}" />` : ''}
                                                    <input type="hidden"  value="${param.nama}" />
                                                    <input type="hidden"  value="${normalValues.rujukan}" />
                                                    <input type="hidden"  value="${e.data_departement.nama_department}" />
                                                </td>
                                                <td class="col-2">
                                                    <select class="form-select manualInput w-60 p-0">
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
                                                ${hasDuplo ? `
                                                    <td class="col-2 duplo d1-column text-center" style="display: ${duploStatus.hasD1 ? 'table-cell' : 'none'};">
                                                        <select  class="form-select d1 w-60 p-0" disabled>
                                                            ${param.opsi_output.split(';').map(opt => `
                                                                <option value="${opt.trim()}" ${obxValues.duplo_d1 === opt.trim() ? 'selected' : ''}>
                                                                    ${opt.trim()}
                                                                </option>
                                                            `).join('')}
                                                        </select>
                                                    </td>
                                                    <td class="col-2 duplo d2-column" style="display: ${duploStatus.hasD2 ? 'table-cell' : 'none'};">
                                                        <select  class="form-select d2 w-60 p-0" disabled>
                                                            ${param.opsi_output.split(';').map(opt => `
                                                                <option value="${opt.trim()}" ${obxValues.duplo_d2 === opt.trim() ? 'selected' : ''}>
                                                                    ${opt.trim()}
                                                                </option>
                                                            `).join('')}
                                                        </select>
                                                    </td>
                                                    <td class="col-2 duplo d3-column" style="display: ${duploStatus.hasD3 ? 'table-cell' : 'none'};">
                                                        <select  class="form-select d3 w-60 p-0" disabled>
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
                                                    <input type="hidden" value="${param.satuan}" readonly />
                                                    ${param.satuan}
                                                </td>
                                            </tr>
                                        `;
                                    }).join('');

                                        return html;
                                    } else if (hasUrine) {
                                        // Ambil nama pemeriksaan urine (fallback: Urinalisis)
                                        const urinePemeriksaan = e.pasiens.find(p => 
                                            p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('urin') ||
                                            p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('urine')
                                        );
                                        const namaPemeriksaanUrine = urinePemeriksaan 
                                            ? urinePemeriksaan.data_pemeriksaan.nama_pemeriksaan 
                                            : 'Urinalisis';

                                        let html = '';

                                        // Group params berdasarkan judul
                                        const groupedParams = UrineParams.reduce((acc, param) => {
                                            if (!acc[param.judul]) acc[param.judul] = [];
                                            acc[param.judul].push(param);
                                            return acc;
                                        }, {});

                                        // Loop setiap grup judul
                                        Object.entries(groupedParams).forEach(([judulGroup, params]) => {
                                            // Tambahkan header judul
                                            html += `
                                                <tr class="urine-title-header">
                                                    <td colspan="8" class="fw-bold text-info ps-3"
                                                        style="background-color:#e1f5fe; border-left:4px solid #00bcd4; padding:10px;">
                                                        ${judulGroup}
                                                    </td>
                                                </tr>
                                            `;

                                            // Render parameter dalam grup
                                            html += params.map((param, paramIdx) => {
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
                                                        <td class="col-2 ps-4" style="border-left:2px solid #e9ecef;">
                                                            <strong>${param.display_name}</strong>
                                                            ${normalValues.rujukan !== '-' && normalValues.rujukan !== '' 
                                                                ? `<small class="text-muted d-block">${normalValues.rujukan ?? ''}</small>` 
                                                                : ''}
                                                            
                                                            <input type="hidden"  value="${param.nama}" />
                                                            <input type="hidden"  value="${param.judul}" />
                                                            <input type="hidden"  value="${param.nama}" />
                                                            <input type="hidden"  value="${normalValues.rujukan}" />
                                                            <input type="hidden"  value="${e.data_departement.nama_department}" />
                                                        </td>

                                                        <td class="col-2">
                                                            ${param.tipe_inputan.toLowerCase() === 'text' ? `
                                                                <input type="text"  
                                                                    class="form-control manualInput w-60 p-0 text-center"
                                                                    disabled value="${obxValues.hasilUtama || param.default || ''}" />
                                                            ` : `
                                                                <select  class="form-select manualInput w-60 p-0" disabled>
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
                                                                    data-index="${paramIdx}" data-switch-index="0">
                                                                <i class="ti ti-switch-2"></i>
                                                            </button>
                                                        </td>

                                                        <!-- Kolom duplo D1 -->
                                                        <td class="col-2 duplo d1-column text-center" style="display:none;">
                                                            ${param.tipe_inputan.toLowerCase() === 'text' ? `
                                                                <input type="text"  
                                                                    class="form-control d1 w-60 p-0 text-center"
                                                                    disabled value="${obxValues.duplo_d1 || ''}" />
                                                            ` : `
                                                                <select  class="form-select d1 w-60 p-0" disabled>
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
                                                                <input type="text"  
                                                                    class="form-control d2 w-60 p-0 text-center"
                                                                    disabled value="${obxValues.duplo_d2 || ''}" />
                                                            ` : `
                                                                <select  class="form-select d2 w-60 p-0" disabled>
                                                                    <option value="" selected  hidden>Pilih...</option>
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
                                                                <input type="text"  
                                                                    class="form-control d3 w-50 p-0 text-center"
                                                                    disabled value="${obxValues.duplo_d3 || ''}" />
                                                            ` : `
                                                                <select  class="form-select d3 w-50 p-0" disabled>
                                                                    <option value="" selected hidden>Pilih...</option>
                                                                    ${param.opsi_output.split(';').map(opt => `
                                                                        <option value="${opt.trim()}" ${obxValues.duplo_d3 === opt.trim() ? 'selected' : ''}>
                                                                            ${opt.trim()}
                                                                        </option>
                                                                    `).join('')}
                                                                </select>
                                                            `}
                                                        </td>

                                                        <!-- Kolom Flag -->
                                                        <td class="col-3 flag-cell">
                                                            
                                                        </td>

                                                        <!-- Kolom Satuan -->
                                                        <td>
                                                            <input type="hidden"  value="${param.satuan}" readonly />
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
                                                p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('mikrobiologi')
                                            );
                                            const judulMikrobiologi = e.pasiens.find(p => 
                                                p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('mikrobiologi') && p.data_pemeriksaan?.judul
                                            )?.data_pemeriksaan?.judul || '';
                                            const namaPemeriksaanMikrobiologi = mikrobiologiPemeriksaan ? mikrobiologiPemeriksaan.data_pemeriksaan.nama_pemeriksaan : 'Mikrobiologi';

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

                                                return `
                                                    <tr data-id="${rowId}" data-parameter="${param.nama}" class="mikrobiologi-row">
                                                        <td class="col-2 ps-4" style="border-left: 2px solid #e9ecef;">
                                                            <strong>${label}</strong>
                                                            ${param.nilai_rujukan !== '-' && param.nilai_rujukan !== '' ? 
                                                                `<small class="text-muted d-block">${param.nilai_rujukan ?? ''}</small>` : ''}
                                                            <input type="hidden"  value="${namaPemeriksaanMikrobiologi}" />
                                                            <input type="hidden"  value="${judulMikrobiologi}" />
                                                            <input type="hidden"  value="${param.nama}" />
                                                            <input type="hidden"  value="${param.nilai_rujukan ?? '-'}" />
                                                            <input type="hidden"  value="${e.data_departement.nama_department}" />
                                                        </td>
                                                        <td class="col-2">
                                                            ${param.tipe_inputan === 'Text' ? `
                                                                <input type="text"  class="form-control manualInput w-60 p-0 text-center" disabled value="${obxValues.hasilUtama || ''}" />
                                                            ` : `
                                                                <select  class="form-select manualInput w-60 p-0" disabled>
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

                                                        <td class="col-2 duplo d1-column text-center" style="display: none;">
                                                            ${param.tipe_inputan === 'Text' ? `
                                                                <input type="text"  class="form-control d1 w-60 p-0 text-center" disabled value="${obxValues.duplo_d1 || ''}" />
                                                            ` : `
                                                                <select  class="form-select d1 w-60 p-0" disabled>
                                                                    ${param.opsi_output ? param.opsi_output.split(';').map(opt => `
                                                                        <option value="${opt.trim()}" ${obxValues.duplo_d1 === opt.trim() ? 'selected' : ''}>${opt.trim()}</option>
                                                                    `).join('') : '<option value="">Pilih...</option>'}
                                                                </select>
                                                            `}
                                                        </td>
                                                        <td class="col-2 duplo d2-column" style="display: none;">
                                                            ${param.tipe_inputan === 'Text' ? `
                                                                <input type="text"  class="form-control d2 w-60 p-0 text-center" disabled value="${obxValues.duplo_d2 || ''}" />
                                                            ` : `
                                                                <select  class="form-select d2 w-60 p-0" disabled>
                                                                    ${param.opsi_output ? param.opsi_output.split(';').map(opt => `
                                                                        <option value="${opt.trim()}" ${obxValues.duplo_d2 === opt.trim() ? 'selected' : ''}>${opt.trim()}</option>
                                                                    `).join('') : '<option value="">Pilih...</option>'}
                                                                </select>
                                                            `}
                                                        </td>
                                                        <td class="col-2 duplo d3-column" style="display: none;">
                                                            ${param.tipe_inputan === 'Text' ? `
                                                                <input type="text"  class="form-control d3 w-50 p-0 text-center" disabled value="${obxValues.duplo_d3 || ''}" />
                                                            ` : `
                                                                <select  class="form-select d3 w-50 p-0" disabled>
                                                                    ${param.opsi_output ? param.opsi_output.split(';').map(opt => `
                                                                        <option value="${opt.trim()}" ${obxValues.duplo_d3 === opt.trim() ? 'selected' : ''}>${opt.trim()}</option>
                                                                    `).join('') : '<option value="">Pilih...</option>'}
                                                                </select>
                                                            `}
                                                        </td>
                                                        <td class="col-3 flag-cell"></td>
                                                        <td>
                                                            <input type="hidden"  value="${param.satuan || ''}" readonly />
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

                                                return `
                                                    <tr data-id="${rowId}" data-parameter="${param.nama}" class="preparatbasah-row">
                                                        <td class="col-2 ps-4" style="border-left: 2px solid #e9ecef;">
                                                            <strong>${label}</strong>
                                                            ${param.nilai_rujukan !== '-' && param.nilai_rujukan !== '' ? 
                                                                `<small class="text-muted d-block">${param.nilai_rujukan ?? ''}</small>` : ''}
                                                            <input type="hidden"  value="${namaPemeriksaanPreparatBasah}" />
                                                            <input type="hidden"  value="${judulPreparatBasah}" />
                                                            <input type="hidden"  value="${param.nama}" />
                                                            <input type="hidden"  value="${param.nilai_rujukan ?? '-'}" />
                                                            <input type="hidden"  value="${e.data_departement.nama_department}" />
                                                        </td>
                                                        <td class="col-2">
                                                            ${param.tipe_inputan === 'Text' ? `
                                                                <input type="text"  class="form-control manualInput w-60 p-0 text-center" disabled value="${obxValues.hasilUtama || ''}" />
                                                            ` : `
                                                                <select  class="form-select manualInput w-60 p-0" disabled>
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

                                                        <td class="col-2 duplo d1-column text-center" style="display: none;">
                                                            ${param.tipe_inputan === 'Text' ? `
                                                                <input type="text"  class="form-control d1 w-60 p-0 text-center" disabled value="${obxValues.duplo_d1 || ''}" />
                                                            ` : `
                                                                <select  class="form-select d1 w-60 p-0" disabled>
                                                                    ${param.opsi_output ? param.opsi_output.split(';').map(opt => `
                                                                        <option value="${opt.trim()}" ${obxValues.duplo_d1 === opt.trim() ? 'selected' : ''}>${opt.trim()}</option>
                                                                    `).join('') : '<option value="">Pilih...</option>'}
                                                                </select>
                                                            `}
                                                        </td>
                                                        <td class="col-2 duplo d2-column" style="display: none;">
                                                            ${param.tipe_inputan === 'Text' ? `
                                                                <input type="text"  class="form-control d2 w-60 p-0 text-center" disabled value="${obxValues.duplo_d2 || ''}" />
                                                            ` : `
                                                                <select  class="form-select d2 w-60 p-0" disabled>
                                                                    ${param.opsi_output ? param.opsi_output.split(';').map(opt => `
                                                                        <option value="${opt.trim()}" ${obxValues.duplo_d2 === opt.trim() ? 'selected' : ''}>${opt.trim()}</option>
                                                                    `).join('') : '<option value="">Pilih...</option>'}
                                                                </select>
                                                            `}
                                                        </td>
                                                        <td class="col-2 duplo d3-column" style="display: none;">
                                                            ${param.tipe_inputan === 'Text' ? `
                                                                <input type="text"  class="form-control d3 w-50 p-0 text-center" disabled value="${obxValues.duplo_d3 || ''}" />
                                                            ` : `
                                                                <select  class="form-select d3 w-50 p-0" disabled>
                                                                    ${param.opsi_output ? param.opsi_output.split(';').map(opt => `
                                                                        <option value="${opt.trim()}" ${obxValues.duplo_d3 === opt.trim() ? 'selected' : ''}>${opt.trim()}</option>
                                                                    `).join('') : '<option value="">Pilih...</option>'}
                                                                </select>
                                                            `}
                                                        </td>
                                                        <td class="col-3 flag-cell"></td>
                                                        <td>
                                                            <input type="hidden" value="${param.satuan || ''}" readonly />
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

                                    const renderField = (name, value, className = '') => {
                                        if (param.tipe_inputan === 'Dropdown') {
                                            return `
                                                <select  class="form-select ${className} w-60 p-0">
                                                    <option value="" hidden>Pilih...</option>
                                                    ${param.opsi_output.split(';').map(opt => `
                                                        <option value="${opt.trim()}" ${value === opt.trim() ? 'selected' : ''}>${opt.trim()}</option>
                                                    `).join('')}
                                                </select>
                                            `;
                                        } else {
                                            return `
                                                <input type="text"  
                                                    class="form-control ${className} w-60 p-0 text-center" 
                                                     value="${value || ''}" />
                                            `;
                                        }
                                    };

                                    return `
                                        <tr data-id="${rowId}" data-parameter="${param.nama}" class="feses-row">
                                            <!-- Nama parameter -->
                                            <td class="col-2 ps-4">
                                                <strong>${label}</strong>
                                                ${param.nilai_rujukan ? `<small class="text-muted d-block">${param.nilai_rujukan}</small>` : ''}
                                                <input type="hidden"  value="${param.nama}" />
                                                <input type="hidden"  value="${judulFeses}" />
                                                <input type="hidden"  value="${param.nama}" />
                                                <input type="hidden"  value="${param.nilai_rujukan}" />
                                                <input type="hidden"  value="${e.data_departement.nama_department}" />
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
                                            <td class="col-3 flag-cell"></td>

                                            <!-- Satuan -->
                                            <td>
                                                <input type="hidden" name="satuan[]" value="${param.satuan || ''}" />
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
                                            <input type="hidden"  value="${p.data_pemeriksaan.nama_pemeriksaan}" />
                                            <input type="hidden"  value="${judul || ''}" />
                                            <input type="hidden"  value="${p.data_pemeriksaan.nama_parameter}" />
                                            <input type="hidden"  value="${p.data_pemeriksaan.nilai_rujukan || ''}" />
                                            <input type="hidden"  value="${e.data_departement.nama_department}" />
                                        </td>

                                        <!-- Kolom hasil utama -->
                                        <td class="col-2">
                                            ${p.data_pemeriksaan.tipe_inputan === 'Dropdown' ? `
                                                <select  class="form-select manualInput w-60 p-0" disabled>
                                                    ${p.data_pemeriksaan.opsi_output.split(';').map(opt => `
                                                        <option value="${opt.trim()}" ${obxValues.hasilUtama === opt.trim() ? 'selected' : ''}>
                                                            ${opt.trim()}
                                                        </option>
                                                    `).join('')}
                                                </select>
                                            ` : `
                                                <input type="text"  
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

                                        <!-- Duplo D1 -->
                                        <td class="col-2 duplo d1-column text-center" style="display:none;">
                                            ${p.data_pemeriksaan.tipe_inputan === 'Dropdown' ? `
                                                <select  class="form-select d1 w-60 p-0" disabled>
                                                    ${p.data_pemeriksaan.opsi_output.split(';').map(opt => `
                                                        <option value="${opt.trim()}" ${obxValues.duplo_d1 === opt.trim() ? 'selected' : ''}>
                                                            ${opt.trim()}
                                                        </option>
                                                    `).join('')}
                                                </select>
                                            ` : `
                                                <input type="text"  
                                                    class="form-control d1 w-60 p-0 text-center" 
                                                    value="${obxValues.duplo_d1 || ''}" disabled />
                                            `}
                                        </td>

                                        <!-- Duplo D2 -->
                                        <td class="col-2 duplo d2-column text-center" style="display:none;">
                                            ${p.data_pemeriksaan.tipe_inputan === 'Dropdown' ? `
                                                <select  class="form-select d2 w-60 p-0" disabled>
                                                    ${p.data_pemeriksaan.opsi_output.split(';').map(opt => `
                                                        <option value="${opt.trim()}" ${obxValues.duplo_d2 === opt.trim() ? 'selected' : ''}>
                                                            ${opt.trim()}
                                                        </option>
                                                    `).join('')}
                                                </select>
                                            ` : `
                                                <input type="text"  
                                                    class="form-control d2 w-60 p-0 text-center" 
                                                    value="${obxValues.duplo_d2 || ''}" disabled />
                                            `}
                                        </td>

                                        <!-- Duplo D3 -->
                                        <td class="col-2 duplo d3-column text-center" style="display:none;">
                                            ${p.data_pemeriksaan.tipe_inputan === 'Dropdown' ? `
                                                <select  class="form-select d3 w-50 p-0" disabled>
                                                    ${p.data_pemeriksaan.opsi_output.split(';').map(opt => `
                                                        <option value="${opt.trim()}" ${obxValues.duplo_d3 === opt.trim() ? 'selected' : ''}>
                                                            ${opt.trim()}
                                                        </option>
                                                    `).join('')}
                                                </select>
                                            ` : `
                                                <input type="text"  
                                                    class="form-control d3 w-50 p-0 text-center" 
                                                    value="${obxValues.duplo_d3 || ''}" disabled />
                                            `}
                                        </td>

                                        <!-- Flag -->
                                        <td class="col-3 flag-cell">
                                            ${renderFlag(obxValues.flag || renderFlag(obxValues.hasilUtama, {innerHTML: ''}, p.data_pemeriksaan.nama_parameter))}
                                        </td>

                                        <!-- Satuan -->
                                        <td>
                                            <input type="hidden"  
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
            
            <div>
                <label>Catatan</label>
                <textarea class="form-control" name="note" cols="3" rows="3" 
                        placeholder="" readonly>${noteValue}</textarea>
            </div>
        </div>
        
                <div class="row w-100 text-center mt-4">
                    <div class="col-lg-6 mt-2">
                        <button type="button" class="btn btn-outline-info w-100" 
                                onclick="confirmVerify(${data_pasien.id})">
                            <i class="ti ti-arrow-back me-1"></i> Back To Analyst
                        </button>
                    </div>
                    <div class="col-lg-6 mt-2">
                        <button type="button" class="btn btn-outline-primary w-100" 
                                onclick="confirmVerifikasi(${data_pasien.id})">
                            <i class="ti ti-check me-1"></i> Verifikasi
                        </button>
                    </div>
                </div>
    </form>
    
    <style>
        .hematologi-row {
            background-color: #f8f9ff;
        }
        .hematologi-row:hover {
            background-color: #e9ecff;
        }
        .text-success {
            color: #28a745 !important;
        }
        .hematologi-row small.text-muted {
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
    }, 0);

    return content;
}

// Export fungsi jika diperlukan
window.getTableContent = getTableContent;


        document.addEventListener('DOMContentLoaded', function() {
        let duploCount = 0;
        const duploButton = document.getElementById('duploButton');
        
            if (duploButton) {
                duploButton.addEventListener('click', () => {
                    duploCount++;
                    // console.log('Duplo Button Clicked. Count:', duploCount); // Debugging tombol yang diklik

                    // Menambahkan kolom baru pada setiap baris tabel
                    const rows = document.querySelectorAll('#worklistTable tbody tr');
                    
                    rows.forEach(row => {
                        const newDuploCell = document.createElement('td');
                        newDuploCell.classList.add('text-center'); // Jika ingin centering
                        newDuploCell.textContent = `D${duploCount}`;
                        row.appendChild(newDuploCell);
                    });
                });
            } else {
                // console.error("Tombol Duplo tidak ditemukan.");
            }
        });




        function populateModal(spesimen, scollection, shandling, history, data_pemeriksaan_pasien, hasil) {
    const accordion = document.getElementById('sampleHistoryAccordion');
    const historyItem = history.find(h => h.proses === 'Dikembalikan oleh dokter');
    let accordionContent = '';
    let noteContent = '';

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
        } else if (e.tabung === 'EDTA') {
            const collectionItem = scollection.find(item => 
                item.no_lab === e.laravel_through_key && item.tabung === 'EDTA'
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
                    } else if (e.tabung === 'EDTA' && serumh == detail.id) {
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
        if (e.tabung === 'K3-EDTA' || e.tabung === 'EDTA' || e.tabung === 'CLOTH-ACT') {
            note = '<p class="mb-0"><strong>Catatan</strong></p>';
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
                            ${e.tabung === 'EDTA' ? 
                                `<textarea class="form-control" name="note[]" row="3" placeholder="${noteFromCollection || 'null'}" ${noteFromCollection ? '' : 'disabled'} disabled></textarea>` : ''}
                            ${e.tabung === 'CLOT-ACT' ? 
                                `<textarea class="form-control" name="note[]" row="3" placeholder="${noteFromHandling || 'null'}" ${noteFromHandling ? '' : 'disabled'} ></textarea>` : ''}
                        </div>
                    </div>
                </div>
            </div>
        `;
    });

    if (historyItem && historyItem.note) {
        accordionContent += `
            <div class="col-lg-12">
                <label class="fw-bold mt-2">Catatan</label>
                <textarea id="noteTextarea" class="form-control" row="3" placeholder="${historyItem.note}" disabled></textarea>
            </div>
        `;
    }

    accordion.innerHTML = accordionContent;
}

    });
    });
</script>




<script src="{{ asset('../js/ak.js') }}"></script>
@endpush
