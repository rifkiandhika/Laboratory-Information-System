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
                note: item.note || ''
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
                range: data.range
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
            range: ''
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

    function updateFlag(value, flagCell, parameter = null, isHematologi = false) {
        const nilaiHasil = parseFloat(value);
        let flagIcon = '';
        
        if (!isNaN(nilaiHasil)) {
            if (isHematologi && parameter) {
                // range normal untuk parameter hematologi
                const paramData = hematologiParams.find(p => p.nama === parameter);
                if (paramData) {
                    if (nilaiHasil < paramData.normal_min) {
                        flagIcon = `<i class="ti ti-arrow-down text-primary"></i> Low`;
                    } else if (nilaiHasil > paramData.normal_max) {
                        flagIcon = `<i class="ti ti-arrow-up text-danger"></i> High`;
                    } else {
                        flagIcon = `<i class="ti ti-check text-success"></i> Normal`;
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

    const labData = data_pasien;
    const dokterData = data_pasien.dokter;
    const isDikembalikan = data_pasien.status === "Dikembalikan";
    const obx = data_pasien.obx;

    // Ambil note dari database jika ada
    const noteValue = hasil.length > 0 && hasil[0].note ? hasil[0].note : '';

    const content = `
        
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
                                            
                                            if (hasHematologi) {
                                                // Jika ada hematologi, tampilkan parameter hematologi lengkap
                                                return hematologiParams.map((param, paramIdx) => {
                                                    // Cari data hasil untuk parameter ini
                                                    const dataValues = getDataValues(param.nama, param.nama);
                                                    const rowId = `hematologi_${idx}_${paramIdx}`;
                                                    const flagContent = updateFlag(dataValues.hasilUtama, {innerHTML: ''}, param.nama, true);
                                                    
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
                                                                    data-index="${paramIdx}" disabled>
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
                                            } else {
                                                // Jika bukan hematologi, tampilkan seperti biasa
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
                                                            <input type="number" name="hasil[]" 
                                                                class="form-control manualInput w-60 p-0" 
                                                                value="${dataValues.hasilUtama}" readonly />
                                                        </td>
                                                        <td class="col-1">
                                                            <button type="button" class="btn btn-outline-secondary btn-sm switch-btn" 
                                                                    data-index="0" disabled>
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
                                                            ${flagContent}
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
            
            <div>
                <label>Catatan</label>
                <textarea class="form-control" name="note" cols="3" rows="3" 
                        placeholder="" readonly>${noteValue}</textarea>
            </div>
        </div>
        
                <div class="row w-100 text-center">
                    <div class="col-lg-6 mt-2">
                        <form id="dokterForm-${data_pasien.id}"
                             action="dokter/back/${data_pasien.id}" method="POST"
                             style="display: none;">
                            @csrf
                        </form>
                        <button class="btn btn-outline-info w-100" onclick="confirmVerify(${data_pasien.id})">Back To Analyst</button>
                    </div>
                    <div class="col-lg-6 mt-2">
                        <form id="kirimForm-${data_pasien.id}"
                             action="dokter/send/${data_pasien.id}" method="POST"
                             style="display: none;">
                            @csrf
                        </form>
                        <button class="btn btn-outline-primary w-100" onclick="confirmDokter(${data_pasien.id})">Verifikasi</button>
                    </div>
                </div>
    
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



{{-- <script> 
    $(function() {
        $('.preview').on('click', function(event) {
            event.preventDefault();
            const id = this.getAttribute('data-id');
            const previewDataPasien = document.getElementById('previewDataPasien');

            fetch(`/api/get-data-pasien/${id}`).then(response => {
                if (!response.ok) {
                    throw new Error("HTTP error" + response.status);
                }
                return response.json();
            }).then(res => {
                if (res.status === 'success') {
                    const data_pasien = res.data;
                    const data_pemeriksaan_pasien = res.data.dpp;

                    console.log(data_pasien);
                    console.log(data_pemeriksaan_pasien);
                    // if (!data_pasien.dokter) {
                    // console.error('Data dokter null');
                    // return;
                    // }

                    let detailContent = '<div class="row">';

                        // Loop hanya sekali
                        data_pemeriksaan_pasien.forEach((e, i) => {
                                detailContent += `
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="col-lg-8">
                                            <div class="row" style="margin-bottom: -5px;">
                                                <label for="staticEmail" class="col-sm-5 col-form-label font-bold">Cito</label>
                                                <div class="col-lg-9">
                                                    <i class='bx bxs-bell-ring mt-2 ml-1 text-danger' style="font-size: 23px;"></i>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom: -10px;">
                                                <label for="staticEmail" class="col-sm-5 col-form-label font-bold">No LAB</label>
                                                <div class="col-lg-6">
                                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ${data_pasien.no_lab}">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom: -10px;">
                                                <label for="staticEmail" class="col-sm-5 col-form-label font-bold">No RM</label>
                                                <div class="col-lg-6">
                                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ${data_pasien.no_rm}">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom: -10px;">
                                                <label for="staticEmail" class="col-sm-5 col-form-label font-bold">Nama</label>
                                                <div class="col-lg-6">
                                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ${data_pasien.nama}">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom: -10px;">
                                                <label for="staticEmail" class="col-sm-5 col-form-label font-bold">Ruangan</label>
                                                <div class="col-lg-6">
                                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ${data_pasien.asal_ruangan}">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom: -10px;">
                                                <label for="staticEmail" class="col-lg-5 col-form-label font-bold">Tanggal Lahir Usia</label>
                                                <div class="col-lg-6">
                                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ${data_pasien.lahir} Tahun">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom: -10px;">
                                                <label for="staticEmail" class="col-sm-5 col-form-label font-bold">Dokter</label>
                                                <div class="col-lg-6">
                                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ${data_pasien.dokter.nama_dokter}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="div">
                                            <div class="timeline timeline-sm">
                                                <div class="timeline-item">
                                                    <div class="timeline-item-marker">
                                                        <div class="timeline-item-marker-text">19.25</div>
                                                        <div class="timeline-item-marker-indicator"><i class="bi bi-check-lg mb-2"></i></div>
                                                    </div>
                                                    <div class="timeline-item-content">Order</div>
                                                </div>
                                                <div class="timeline-item">
                                                    <div class="timeline-item-marker">
                                                        <div class="timeline-item-marker-text">19.35</div>
                                                        <div class="timeline-item-marker-indicator"><i class="bi bi-check-lg mb-2"></i></div>
                                                    </div>
                                                    <div class="timeline-item-content">Payment</div>
                                                </div>
                                                <div class="timeline-item">
                                                    <div class="timeline-item-marker">
                                                        <div class="timeline-item-marker-text">19.50</div>
                                                        <div class="timeline-item-marker-indicator"><i class="bi bi-check-lg mb-2"></i></div>
                                                    </div>
                                                    <div class="timeline-item-content">Sampling</div>
                                                </div>
                                                <div class="timeline-item">
                                                    <div class="timeline-item-marker">
                                                        <div class="timeline-item-marker-text">20.00</div>
                                                        <div class="timeline-item-marker-indicator"><i class="bi bi-check-lg mb-2"></i></div>
                                                    </div>
                                                    <div class="timeline-item-content">Spesimen Collection</div>
                                                </div>
                                                <div class="timeline-item">
                                                    <div class="timeline-item-marker">
                                                        <div class="timeline-item-marker-text">20.15</div>
                                                        <div class="timeline-item-marker-indicator"><i class="bi bi-check-lg mb-2"></i></div>
                                                    </div>
                                                    <div class="timeline-item-content">Spesimen Handling</div>
                                                </div>
                                                <div class="timeline-item">
                                                    <div class="timeline-item-marker">
                                                        <div class="timeline-item-marker-text">20.45</div>
                                                        <div class="timeline-item-marker-indicator"><i class="bi bi-check-lg mb-2"></i></div>
                                                    </div>
                                                    <div class="timeline-item-content">Result</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });
                            detailContent += '</div>';

                    // Object.keys(Tabung).forEach(spesiment => {

                    //   res.data.spesiment.forEach((e, i) => {
                    //             let details = '';
                        
                    //             if (e.details && e.details.length > 0){
                    //                 details = `<div class="detail-container col-12 col-md-6">`;
                    //                 e.details.forEach(detail => {
                    //                     const imageUrl = `/gambar/${detail.gambar}`;
                    //                     const isChecked = (e.tabung === 'EDTA' && detail.nama_parameter === 'Normal' ) ||
                    //                                         (e.tabung === 'CLOTH-ACT' && detail.nama_parameter === 'Normal') ||
                    //                                         (e.tabung === 'CLOT-ACT' && detail.nama_parameter === 'Normal') ? 'checked' : '';

                    //                     // const approvedDetail = res.data.approvedDetails.find(d => d.id === detail.id);
                    //                     // const approvedChecked = approvedDetail ? 'checked' : '';
                    //                     // const approvedNote = approvedDetail ? approvedDetail.note : '';

                    //                     details +=  
                    //                     `<div class="detail-item">
                    //                         <div class="detail-text">${detail.nama_parameter}</div>
                    //                         <div class="detail-image-container">
                    //                             <img src="${imageUrl}" alt="${detail.nama_parameter}" width="35" class="detail-image"/>    
                    //                         </div>
                    //                         <div class="detail-radio-container">
                    //                             ${e.tabung === 'EDTA' ? `<input type="radio" name="kapasitas[]" value="${detail.id}" class="detail.radio" ${isChecked}/>` : ''}
                    //                             ${e.tabung === 'CLOTH-ACT' ? `<input type="radio" name="serumh[]" value="${detail.id}" class="detail.radio" ${isChecked}/>` : ''}
                    //                             ${e.tabung === 'CLOT-ACT' ? `<input type="radio" name="serum[]" value="${detail.id}" class="detail.radio" ${isChecked}/>` : ''}    
                    //                         </div>
                    //                     </div>`;
                    //                 });
                    //                 details += `</div>`
                    //             }

                    //             let title = '';
                    //             let subtext = '';
                    //             if (e.tabung === 'EDTA') {
                    //                 title = '<h5 class="title">Spesiment Collection</h5> <hr>';
                    //             } else if (e.spesiment === 'Spesiment Collection') {
                    //                 subtext = '<div class="subtext">Serum</div>';
                    //             } else if (e.spesiment === 'Spesiment Handlings') {
                    //                 title = '<h5>Spesiment Handlings</h5> <hr>';
                    //                 subtext = '<div class="subtext">Serum</div>';
                    //             }
                                
                    //             let note = '';
                    //             if (e.tabung === 'EDTA' || e.tabung === 'CLOT-ACT', 'CLOTH-ACT') {
                    //                     note = '<p class="mb-0"><strong>Note</strong></p>';
                    //                 }

                    //             detailContent += `${title}
                    //                 <div class="accordion mb-2" id="accordion${e.tabung}">
                                                        
                    //                     <div class="accordion-item">
                    //                         <h2 class="accordion-header" id="heading${e.tabung}">
                    //                             <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${e.tabung}" aria-expanded="true" aria-controls="collapse${e.tabung}">
                    //                             Tabung ${e.tabung}
                    //                             </button>
                    //                         </h2>
                    //                         <div id="collapse${e.tabung}" class="accordion-collapse collapse" aria-labelledby="heading${e.tabung}" data-bs-parent="#accordion${e.tabung}">
                    //                             <div class="accordion-body">
                                                    
                    //                                 ${subtext}
                    //                                 <div class="container">
                    //                                     ${details}
                    //                                 </div>
                    //                                 ${note}
                    //                                 ${e.tabung === 'EDTA' ? `<textarea class="form-control" name="note[]" row="3" placeholder="Write a note here"></textarea>` : ''}
                    //                                 ${e.tabung === 'CLOTH-ACT' ? `<textarea class="form-control" name="note[]" row="3" placeholder="Write a note here"></textarea>` : ''}
                    //                                 ${e.tabung === 'CLOT-ACT' ? `<textarea class="form-control" name="note[]" row="3" placeholder="Write a note here"></textarea>` : ''}
                                                    
                    //                             </div>
                    //                         </div>
                    //                     </div>
                    //                     </div>`;
                    //          });
                     
                    // });
                    
                    previewDataPasien.innerHTML = detailContent;
                    console.log(detailContent);
                }
            });
        });
    }) 
</script> --}}

{{-- <script>
    function previewPasien(nolab) {
        var y = document.getElementById("preview-pasien-close");
        console.log(nolab);

        //mengambil data pasien dari database
        fetch('/api/previewpasien/'+nolab)
            .then(response => {
                if (!response.ok) {
                    throw new Error("HTTP error " + response.status);
                }
                return response.json();
            })
            .then(data => {
                y.style.display = "none";
                var status = document.getElementById("status");
                var container = document.getElementById("container-preview");
                var tanggal = document.getElementById("tanggal-pemeriksaan");

                //megnhitung umur dari tanggal lahir
                var dob = new Date(data.data_pasien.lahir);
                var today = new Date();
                var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));

                var diagnosa = data.icd10.filter(function (el) {
                    return el.code == data.data_pasien.diagnosa;
                });

                var dataPasien = `<div class="d-flex justify-content-between mx-3">
                                    <div class="">
                                    <div class="row" style="margin-bottom: -5px;">
                                        <label for="staticEmail" class="col-sm-5 col-form-label font-weight-bold">Cito</label>
                                        <div class="col-lg-6"">
                                        <i class='bx bxs-bell-ring mt-2 ml-1 text-danger' style="font-size: 23px;"></i>
                                        </div>
                                        <div id="coba">asdfkj</div>
                                    </div>
                                    <div class="row" style="margin-bottom: -10px;">
                                        <label for="staticEmail" class="col-sm-5 col-form-label font-weight-bold">No LAB</label>
                                        <div class="col-lg-6"">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": `+ data.data_pasien.no_lab +`">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: -10px;">
                                        <label for="staticEmail" class="col-sm-5 col-form-label font-weight-bold">No RM</label>
                                        <div class="col-lg-6"">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": `+ data.data_pasien.no_rm +`">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: -10px;">
                                        <label for="staticEmail" class="col-sm-5 col-form-label font-weight-bold">Nama</label>
                                        <div class="col-lg-6"">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": `+ data.data_pasien.nama +`">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: -10px;">
                                        <label for="staticEmail" class="col-sm-5 col-form-label font-weight-bold">Ruangan</label>
                                        <div class="col-lg-6"">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": `+ data.data_pasien.asal_ruangan +`">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: -10px;">
                                        <label for="staticEmail" class="col-lg-5 col-form-label font-weight-bold">Tanggal Lahir Usia</label>
                                        <div class="col-lg-6">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": `+ data.data_pasien.lahir +`, `+ age +`th">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: -10px;">
                                        <label for="staticEmail" class="col-sm-5 col-form-label font-weight-bold">Dokter</label>
                                        <div class="col-lg-6"">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": Dr. Bande">
                                        </div>
                                    </div>
                                    </div>
                                    <div class="div">
                                    <div class="timeline timeline-sm">
                                        <div class="timeline-item">
                                            <div class="timeline-item-marker">
                                                <div class="timeline-item-marker-text">19.25</div>
                                                <div class="timeline-item-marker-indicator"><i class="bx bx-check"></i></div>
                                            </div>
                                            <div class="timeline-item-content">Order</div>
                                        </div>
                                        <div class="timeline-item">
                                            <div class="timeline-item-marker">
                                                <div class="timeline-item-marker-text">19.35</div>
                                                <div class="timeline-item-marker-indicator"><i class="bx bx-check"></i></div>
                                            </div>
                                            <div class="timeline-item-content">Payment</div>
                                        </div>
                                        <div class="timeline-item">
                                            <div class="timeline-item-marker">
                                                <div class="timeline-item-marker-text">19.50</div>
                                                <div class="timeline-item-marker-indicator"><i class="bx bx-check"></i></div>
                                            </div>
                                            <div class="timeline-item-content">Sampling</div>
                                        </div>
                                        <div class="timeline-item">
                                            <div class="timeline-item-marker">
                                                <div class="timeline-item-marker-text">20.00</div>
                                                <div class="timeline-item-marker-indicator"><i class="bx bx-check"></i></div>
                                            </div>
                                            <div class="timeline-item-content">Spesimen Collection</div>
                                        </div>
                                        <div class="timeline-item">
                                            <div class="timeline-item-marker">
                                                <div class="timeline-item-marker-text">20.15</div>
                                                <div class="timeline-item-marker-indicator"><i class="bx bx-check"></i></div>
                                            </div>
                                            <div class="timeline-item-content">Spesimen Handling</div>
                                        </div>
                                        <div class="timeline-item">
                                            <div class="timeline-item-marker">
                                                <div class="timeline-item-marker-text">20.45</div>
                                                <div class="timeline-item-marker-indicator"><i class="bx bx-check"></i></div>
                                            </div>
                                            <div class="timeline-item-content">Result</div>
                                        </div>
                                    </div>
                                    </div>
                                </div>`;

                var previewButton =`<div class="row">
                                        <div class="col-lg-2">
                                            <button type="button" class="btn btn-outline-secondary btn-block">Manual</button>
                                        </div>
                                        <div class="col-lg-2">
                                            <button type="button" class="btn btn-outline-info btn-block">Duplo</button>
                                        </div>
                                        <div class="col-lg-2">
                                            <button type="button" class="btn btn-outline-warning btn-block" data-bs-toggle="modal" data-bs-target="#exampleModal">Sample History</button>
                                        </div>
                                        <div class="col-lg-2">
                                            <button type="button" class="btn btn-outline-danger btn-block">Delete</button>
                                        </div>
                                    </div>`;

                //perulangan untuk menampilkan pemeriksaan yang di pilih

                var departement = "";
                var pemeriksaan = "";

                for (let i = 0; i < data.id_departement_pasien.length; i++) {
                    departement += `<p class="h6 text-gray-800">`
                                    //buat perintah where untuk mencari id_departement
                                    for (let j = 0; j < data.data_departement.length; j++) {
                                        if(data.data_departement[j].id_departement == data.id_departement_pasien[i].id_departement)
                                            // departement += data.data_departement[j].nama_departement;
                                            departement += `<table class="table" style="font-size: 14px;">
                                                                <thead>
                                                                <tr>
                                                                    <th scope="col">Parameter</th>
                                                                    <th scope="col">Hasil</th>
                                                                    <!-- Kondisi Duplo -->
                                                                    <th scope="col">Flag</th>
                                                                    <th scope="col">Satuan</th>
                                                                    <th scope="col">Range</th>
                                                                </tr>
                                                                </thead>
                                                                <tr class="mt-2">
                                                                    <th scope="row">`+ data.data_departement[j].nama_departement +`</th>
                                                                </tr>
                                                                <tbody>`;
                                    }
                                        for (let k = 0; k < data.data_pemeriksaan_pasien.length; k++) {
                                            if(data.data_pemeriksaan_pasien[k].id_departement == data.id_departement_pasien[i].id_departement){
                                                for (let l = 0; l < data.data_pemeriksaan.length; l++) {
                                                    if(data.data_pemeriksaan_pasien[k].nama_parameter == data.data_pemeriksaan[l].nama_parameter){
                                                        // departement += `<p class="text-gray-600 offset-md-3">`+ data.data_pemeriksaan[l].nama_pemeriksaan +`</p>`;
                                                        if(data.data_pemeriksaan[l].nama_pemeriksaan == 'Darah Lengkap'){

                                                            // departement = `<div id="">`;
                                                                departement += `<tr class="">
                                                                                    <td scope="row" class="col-4">`+ data.data_pemeriksaan[l].nama_pemeriksaan +`</th>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td class="text-center"></td>
                                                                                    <td class="text-center"></td>
                                                                                </tr>
                                                                                <tr class="" >
                                                                                    <td scope="row" class="col-4 pl-5">WBC</td>
                                                                                    <td><input type="text" class="col-5 input-detail justify-content-center" readonly value=" "></td>
                                                                                    <td></td>
                                                                                    <td class="text-center">%</td>
                                                                                    <td class="text-center">1-10</td>
                                                                                </tr>
                                                                                <tr class="" >
                                                                                    <td scope="row" class="col-4 pl-5">Lym#</td>
                                                                                    <td><input type="text" class="col-5 input-detail justify-content-center" readonly value=" "></td>
                                                                                    <td></td>
                                                                                    <td class="text-center">%</td>
                                                                                    <td class="text-center">1-10</td>
                                                                                </tr>
                                                                                <tr class="" >
                                                                                    <td scope="row" class="col-4 pl-5">Mid#</td>
                                                                                    <td><input type="text" class="col-5 input-detail justify-content-center" readonly value=" "></td>
                                                                                    <td></td>
                                                                                    <td class="text-center">%</td>
                                                                                    <td class="text-center">1-10</td>
                                                                                </tr>
                                                                                <tr class="" >
                                                                                    <td scope="row" class="col-4 pl-5">Gran#</td>
                                                                                    <td><input type="text" class="col-5 input-detail justify-content-center" readonly value=" "></td>
                                                                                    <td></td>
                                                                                    <td class="text-center">%</td>
                                                                                    <td class="text-center">1-10</td>
                                                                                </tr>
                                                                                <tr class="" >
                                                                                    <td scope="row" class="col-4 pl-5">Lym%</td>
                                                                                    <td><input type="text" class="col-5 input-detail justify-content-center" readonly value=" "></td>
                                                                                    <td></td>
                                                                                    <td class="text-center">%</td>
                                                                                    <td class="text-center">1-10</td>
                                                                                </tr>
                                                                                <tr class="" >
                                                                                    <td scope="row" class="col-4 pl-5">Mid%</td>
                                                                                    <td><input type="text" class="col-5 input-detail justify-content-center" readonly value=" "></td>
                                                                                    <td></td>
                                                                                    <td class="text-center">%</td>
                                                                                    <td class="text-center">1-10</td>
                                                                                </tr>
                                                                                <tr class="" >
                                                                                    <td scope="row" class="col-4 pl-5">Gran%</td>
                                                                                    <td><input type="text" class="col-5 input-detail justify-content-center" readonly value=" "></td>
                                                                                    <td></td>
                                                                                    <td class="text-center">%</td>
                                                                                    <td class="text-center">1-10</td>
                                                                                </tr>
                                                                                <tr class="" >
                                                                                    <td scope="row" class="col-4 pl-5">RBC</td>
                                                                                    <td><input type="text" class="col-5 input-detail justify-content-center" readonly value=" "></td>
                                                                                    <td></td>
                                                                                    <td class="text-center">%</td>
                                                                                    <td class="text-center">1-10</td>
                                                                                </tr>
                                                                                <tr class="" >
                                                                                    <td scope="row" class="col-4 pl-5">HGB</td>
                                                                                    <td><input type="text" class="col-5 input-detail justify-content-center" readonly value=" "></td>
                                                                                    <td></td>
                                                                                    <td class="text-center">%</td>
                                                                                    <td class="text-center">1-10</td>
                                                                                </tr>
                                                                                <tr class="" >
                                                                                    <td scope="row" class="col-4 pl-5">HCT</td>
                                                                                    <td><input type="text" class="col-5 input-detail justify-content-center" readonly value=" "></td>
                                                                                    <td></td>
                                                                                    <td class="text-center">%</td>
                                                                                    <td class="text-center">1-10</td>
                                                                                </tr>
                                                                                <tr class="" >
                                                                                    <td scope="row" class="col-4 pl-5">MCV</td>
                                                                                    <td><input type="text" class="col-5 input-detail justify-content-center" readonly value=" "></td>
                                                                                    <td></td>
                                                                                    <td class="text-center">%</td>
                                                                                    <td class="text-center">1-10</td>
                                                                                </tr>
                                                                                <tr class="" >
                                                                                    <td scope="row" class="col-4 pl-5">MCH</td>
                                                                                    <td><input type="text" class="col-5 input-detail justify-content-center" readonly value=" "></td>
                                                                                    <td></td>
                                                                                    <td class="text-center">%</td>
                                                                                    <td class="text-center">1-10</td>
                                                                                </tr>
                                                                                <tr class="" >
                                                                                    <td scope="row" class="col-4 pl-5">MCHC</td>
                                                                                    <td><input type="text" class="col-5 input-detail justify-content-center" readonly value=" "></td>
                                                                                    <td></td>
                                                                                    <td class="text-center">%</td>
                                                                                    <td class="text-center">1-10</td>
                                                                                </tr>
                                                                                <tr class="" >
                                                                                    <td scope="row" class="col-4 pl-5">RDW-CV</td>
                                                                                    <td><input type="text" class="col-5 input-detail justify-content-center" readonly value=" "></td>
                                                                                    <td></td>
                                                                                    <td class="text-center">%</td>
                                                                                    <td class="text-center">1-10</td>
                                                                                </tr>
                                                                                <tr class="" >
                                                                                    <td scope="row" class="col-4 pl-5">RDW-SD</td>
                                                                                    <td><input type="text" class="col-5 input-detail justify-content-center" readonly value=" "></td>
                                                                                    <td></td>
                                                                                    <td class="text-center">%</td>
                                                                                    <td class="text-center">1-10</td>
                                                                                </tr>
                                                                                <tr class="" >
                                                                                    <td scope="row" class="col-4 pl-5">PLT</td>
                                                                                    <td><input type="text" class="col-5 input-detail justify-content-center" readonly value=" "></td>
                                                                                    <td></td>
                                                                                    <td class="text-center">%</td>
                                                                                    <td class="text-center">1-10</td>
                                                                                </tr>
                                                                                <tr class="" >
                                                                                    <td scope="row" class="col-4 pl-5">MPV</td>
                                                                                    <td><input type="text" class="col-5 input-detail justify-content-center" readonly value=" "></td>
                                                                                    <td></td>
                                                                                    <td class="text-center">%</td>
                                                                                    <td class="text-center">1-10</td>
                                                                                </tr>
                                                                                <tr class="" >
                                                                                    <td scope="row" class="col-4 pl-5">PDW</td>
                                                                                    <td><input type="text" class="col-5 input-detail justify-content-center" readonly value=" "></td>
                                                                                    <td></td>
                                                                                    <td class="text-center">%</td>
                                                                                    <td class="text-center">1-10</td>
                                                                                </tr>
                                                                                <tr class="" >
                                                                                    <td scope="row" class="col-4 pl-5">PCT</td>
                                                                                    <td><input type="text" class="col-5 input-detail justify-content-center" readonly value=" "></td>
                                                                                    <td></td>
                                                                                    <td class="text-center">%</td>
                                                                                    <td class="text-center">1-10</td>
                                                                                </tr>
                                                                                <tr class="" >
                                                                                    <td scope="row" class="col-4 pl-5">P-LCC</td>
                                                                                    <td><input type="text" class="col-5 input-detail justify-content-center" readonly value=" "></td>
                                                                                    <td></td>
                                                                                    <td class="text-center">%</td>
                                                                                    <td class="text-center">1-10</td>
                                                                                </tr>
                                                                                <tr class="" >
                                                                                    <td scope="row" class="col-4 pl-5">P-LCR</td>
                                                                                    <td><input type="text" class="col-5 input-detail justify-content-center" readonly value=" "></td>
                                                                                    <td></td>
                                                                                    <td class="text-center">%</td>
                                                                                    <td class="text-center">1-10</td>
                                                                                </tr>`;


                                                        }else{
                                                            departement += `
                                                                            <tr class="">
                                                                                <td scope="row" class="col-4">`+ data.data_pemeriksaan[l].nama_pemeriksaan +`</td>
                                                                                <td><input type="text" class="col-5 input-detail justify-content-center" readonly value=" "></td>
                                                                                <td></td>
                                                                                <td class="text-center">%</td>
                                                                                <td class="text-center">1-10</td>
                                                                            </tr>`;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    departement += `</tbody>
                                                    </table>`
                }


                var citoMerah = `<label for="staticEmail" class="col-sm-5 col-form-label">Cito</label>
                                <div class="col-sm-7">
                                    <i class='bx bxs-bell-ring mt-2 ml-1 text-danger' style="font-size: 23px;"></i>
                                </div>`;
                var citoGray = `<label for="staticEmail" class="col-sm-5 col-form-label">Cito</label>
                                <div class="col-sm-7">
                                    <i class='bx bxs-bell-ring mt-2 ml-1 text-secondary' style="font-size: 23px;"></i>
                                </div>`;

                var html = `<div class="row">
                                <div class="table-scroll table-pasien p-3" style="width: 100%;">
                                    <div id="tabel-pemeriksaan-worklist">
                                        <!-- tabel -->
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                <button type="button" class="btn btn-outline-teal btn-block">Verifikasi Hasil</button>
                                </div>
                                <div class="col-lg-6">
                                <button type="button" class="btn btn-outline-primary btn-block">Verifikasi Dokter PK</button>
                                </div>
                            </div>`

                document.getElementById("preview-data-pasien").innerHTML = dataPasien;
                document.getElementById("preview-button").innerHTML = previewButton;
                document.getElementById("preview-pemeriksaan").innerHTML = html;
                document.getElementById("tabel-pemeriksaan-worklist").innerHTML = departement;


            })
            .catch(error => ('Error:', error));

    }
</script> --}}


{{-- <script>
    $(document).ready(function() {
    selesai();
    });

    function selesai() {
    setTimeout(function() {
        tampilData();
        selesai();
    }, 1000);
    }

    function tampilData() {
    var link = '/worklist/tampildarahlengkap/' + nolab;
    $.ajax({
        url: link,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
        // Kosongkan variabel coba sebelum diisi dengan data terbaru
        $('#coba').html('');
        var coba = data;
        $('#coba').html(coba);
        console.log(data);
        }
    });
</script> --}}


<script src="{{ asset('../js/ak.js') }}"></script>
@endpush
