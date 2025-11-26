@extends('layouts.admin')
@section('title', 'Worklist')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/timeline.css') }}">
    <style>
        @keyframes fadeInOut {

            0%,
            100% {
                opacity: 0;
            }

            50% {
                opacity: 1;
            }
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
            max-width: 100%;
            /* Membatasi lebar maksimal sesuai dengan ukuran modal */
            overflow: auto;
            /* Menambahkan scroll horizontal jika konten terlalu besar */
        }


        .step-wizard-item {
            padding: 0 10px;
            /* Mengurangi padding untuk item agar lebih kompak */
            flex-basis: 0;
            flex-grow: 1;
            max-width: 100%;
            display: flex;
            flex-direction: column;
            text-align: center;
            min-width: 120px;
            /* Kurangi ukuran minimum agar lebih fleksibel */
            position: relative;
        }

        @media (max-width: 576px) {
            .step-wizard-item {
                min-width: 100px;
                /* Mengatur ulang ukuran untuk layar kecil */
            }
        }

        .step-wizard-item+.step-wizard-item:after {
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

        .progress-count {
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

        .progress-count::after {
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

        .progress-count::before {
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

        .progress-label {
            font-size: 14px;
            font-weight: 600;
            margin-top: 10px;
        }

        /* CSS untuk memperbaiki tampilan tabel pemeriksaan */
        #tabel-pemeriksaan {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        #tabel-pemeriksaan .table-responsive {
            border-radius: 12px 12px 0 0;
            overflow-x: auto;
        }

        /* #tabel-pemeriksaan .table thead th {
              background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
              font-weight: 600;
              text-align: center;
              vertical-align: middle;
              padding: 1rem 0.75rem;
              border: none;
              position: sticky;
              top: 0;
              z-index: 10;
            } */

        .tableh {
            table-layout: fixed;
            width: 100%;
        }

        .accordion-button {
            background-color: #f8f9fa;
            border: none;
            font-weight: 600;
            color: #495057;
            padding: 1rem 1.5rem;
            border-radius: 0 !important;
        }

        .accordion-button:not(.collapsed) {
            background-color: #e7f1ff;
            color: #0d6efd;
            box-shadow: none;
        }

        .accordion-item {
            border: none;
            border-bottom: 1px solid #e9ecef;
        }

        .accordion-item:last-child {
            border-bottom: none;
        }

        .accordion-body {
            padding: 0;
        }


        .exam-table td:last-child {
            border-right: none;
        }

        .exam-table tbody tr:hover {
            background-color: #f5f5f5;
        }


        .exam-table .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
        }


        .switch-btn {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .switch-btn:hover {
            background-color: #e9ecef;
        }

        .flag-cell i {
            font-size: 1.2rem;
        }


        .exam-count {
            color: #6c757d;
            font-size: 0.875rem;
        }
    </style>
    <section>
        <div class="content" id="scroll-content">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex  mt-3">
                    <h1 class="h3 mb-0 text-gray-600">Worklist</h1>
                </div>

                <!-- Content Row -->
                <div class="row mt-2">
                    <div class="col-xl-3 col-lg-3">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold" style="color: #96B6C5;">Antrian Pasien</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between tombol-filter mb-2">
                                    <a href="#">FILTER</a>
                                    <div class="checkbox-rect">
                                        <input style="cursor: pointer" class="form-check-input" type="checkbox"
                                            id="checkbox-rect1" name="check-it">
                                        <label for="checkbox-rect1">Select All</label>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped" style="font-size: 12px;">
                                        <thead>
                                            <tr>
                                                <th scope="col"><i class="ti ti-checkbox" style="font-size: 18px;"></i>
                                                </th>
                                                <th scope="col" colspan="2">No LAB</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Cito</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- Data Pasien --}}
                                            @foreach ($dataPasienCito as $dpc)
                                                <tr>
                                                    <th scope="row"><i class="ti ti-clock text-warning"></i></th>
                                                    <td colspan="2">
                                                        <a href="#" class="preview"
                                                            data-id={{ $dpc->id }}>{{ $dpc->no_lab }}</a>

                                                    </td>
                                                    <td>{{ $dpc->nama }}</td>
                                                    <td class="text-center">
                                                        <i class='ti ti-bell-filled mt-2 ml-1 {{ $dpc->cito == '1' ? 'text-danger' : 'text-secondary' }}'
                                                            style="font-size: 23px;"></i>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            {{-- Pasien Diverifikasi --}}
                                            @foreach ($verifikasi as $v)
                                                <tr>
                                                    <th scope="row"><i class="ti ti-circle-check text-success"></i></th>
                                                    <td colspan="2">
                                                        <a href="#" class="preview"
                                                            data-id={{ $v->id }}>{{ $v->no_lab }}</a>

                                                    </td>
                                                    <td>{{ $v->nama }}</td>
                                                    <td class="text-center">
                                                        <i class='ti ti-bell-filled mt-2 ml-1 {{ $v->cito == '1' ? 'text-danger' : 'text-secondary' }}'
                                                            style="font-size: 23px;"></i>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            {{-- Pasien Dikembalikan --}}
                                            @foreach ($dikembalikan as $dk)
                                                <tr>

                                                    <th scope="row"><i
                                                            class="ti ti-alert-triangle text-danger blinking-icon"></i></th>
                                                    {{-- <input class="form-check-input mt-2" style="font-size: 15px; cursor: pointer;" type="checkbox"  name="pilih"> --}}
                                                    <td colspan="2">
                                                        <a href="#" class="preview"
                                                            data-id={{ $dk->id }}>{{ $dk->no_lab }}</a>

                                                    </td>
                                                    <td>{{ $dk->nama }}</td>
                                                    <td class="text-center">
                                                        <i class='ti ti-bell-filled mt-2 ml-1 {{ $dk->cito == '1' ? 'text-danger' : 'text-secondary' }}'
                                                            style="font-size: 23px;"></i>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            {{-- @foreach ($dikembalikan as $dk)
                            <tr>
                                <th scope="row"><input class="form-check-input mt-2" style="font-size: 15px; cursor: pointer;" type="checkbox"  name="pilih"></th>
                                <td><a href="#" class="preview" data-id={{ $dk->id }}>{{ $dk->no_lab }}</a></td>
                                <td>{{ $dk->nama }}</td>
                                <td>
                                    <td class="text-center">
                                        <i class='ti ti-bell-filled mt-2 ml-1 {{ $dk->cito == '1' ? 'text-danger' : 'text-secondary' }}'
                                            style="font-size: 23px;"></i>
                                    </td>
                                </td>
                            </tr>
                        @endforeach --}}
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
                                    <div style="background-color: #F5F7F8" class="text-center">
                                        <p>Pilih Pasien</p>
                                    </div>
                                </div>
                                <hr>
                                <!-- Modal -->

                            </div>
                            <div class="modal fade" id="sampleHistoryModal" tabindex="-1"
                                aria-labelledby="sampleHistoryModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="sampleHistoryModalLabel">Sample History</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="accordion" id="sampleHistoryAccordion"></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Images Modal --}}
                            <!-- Modal Upload Images -->
                            <div class="modal fade" id="imagesModal" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Upload Images</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" id="currentNoLab" value="">
                                            
                                            <div id="imageUploadContainer"></div>
                                            <button type="button" class="btn btn-primary btn-sm mt-2" id="addMoreImageBtn">
                                                <i class="bi bi-plus-circle"></i> Tambah Image Lagi
                                            </button>
                                            
                                            <div class="mt-3" id="uploadedImagesPreview" style="display: none;">
                                                <h6>Images yang sudah diupload:</h6>
                                                <div class="row" id="previewContainer"></div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-success" id="saveImagesBtn">Simpan Semua</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Carousel dengan Zoom -->
                            <div class="modal fade image-carousel-modal" id="imageCarouselModal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Preview Images</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body position-relative">
                                            <div class="image-counter" id="imageCounter">1 / 1</div>
                                            
                                            <div class="zoom-controls">
                                                <button class="btn btn-sm btn-light" onclick="zoomIn()">
                                                    <i class="ti ti-zoom-in"></i>
                                                </button>
                                                <button class="btn btn-sm btn-light" onclick="zoomOut()">
                                                    <i class="ti ti-zoom-out"></i>
                                                </button>
                                                <button class="btn btn-sm btn-light" onclick="resetZoom()">
                                                    <i class="ti ti-refresh"></i>
                                                </button>
                                            </div>
                                            
                                            <div id="imageCarousel" class="carousel slide" data-bs-ride="false">
                                                <div class="carousel-inner" id="carouselInner"></div>
                                                
                                                <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon"></span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon"></span>
                                                </button>
                                                <button onclick="downloadCurrentImage()" class="btn btn-success">
                                                    <i class="bi bi-download"></i> Download
                                                </button>
                                                {{-- <button onclick="printCurrentImage()" class="btn btn-info">
                                                    <i class="bi bi-printer"></i> Print
                                                </button> --}}
                                            </div>
                                            
                                            <div class="carousel-indicators" id="carouselIndicators"></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" id="deleteCurrentImage">
                                                <i class="bi bi-trash"></i> Hapus Image Ini
                                            </button>
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

                                    populateModal(spesimen, scollection, shandling, history,
                                        data_pemeriksaan_pasien, hasil);

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
                                    detailContent += getTableContent(data_pemeriksaan_pasien,
                                        data_pasien, hasil);

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
                        <div class="col-lg-3 mb-3">
                            <button type="button" id="manualButton" class="btn btn-outline-secondary btn-block w-100">Manual</button>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <button type="button" id="duploButton" class="btn btn-outline-primary btn-block w-100">Duplo</button>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <button type="button" class="btn btn-outline-info btn-block w-100" data-bs-toggle="modal" data-bs-target="#sampleHistoryModal">Sample History<span class="badge bg-danger" style="display: none;">!</span></button>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <button type="button" class="btn btn-outline-warning btn-block w-100" data-bs-toggle="modal" 
                                    data-bs-target="#imagesModal">
                                Image
                                <span class="badge bg-danger ml-2" id="imageCountBadge" style="display: none; border-radius: 100%;"> 0</span>
                            </button>
                        </div>
                    </div>
                </div>
            `;
                    }

                   function getTableContent(data_pemeriksaan_pasien, data_pasien, hasil) {
                        const hematologiParams = [
                            {
                                nama: 'WBC',
                                display_name: 'Leukosit',
                                satuan: '10³/µL',
                                normal_min_l: 4.0,      // Laki-laki min
                                normal_max_l: 10.0,     // Laki-laki max
                                normal_min_p: 4.0,      // Perempuan min
                                normal_max_p: 10.0,     // Perempuan max
                                nilai_rujukan_l: '4,0-10,0',
                                nilai_rujukan_p: '4,0-10,0'
                            },
                            {
                                nama: 'LYM#',
                                display_name: 'LYM#',
                                satuan: '10³/µL',
                                normal_min_l: 1.0,
                                normal_max_l: 4.0,
                                normal_min_p: 1.0,
                                normal_max_p: 4.0,
                                nilai_rujukan_l: '1,0-4,0',
                                nilai_rujukan_p: '1,0-4,0'
                            },
                            {
                                nama: 'MID#',
                                display_name: 'MID#',
                                satuan: '10³/µL',
                                normal_min_l: 0.2,
                                normal_max_l: 0.8,
                                normal_min_p: 0.2,
                                normal_max_p: 0.8,
                                nilai_rujukan_l: '0,2-0,8',
                                nilai_rujukan_p: '0,2-0,8'
                            },
                            {
                                nama: 'GRAN#',
                                display_name: 'GRAN#',
                                satuan: '10³/µL',
                                normal_min_l: 2.0,
                                normal_max_l: 7.0,
                                normal_min_p: 2.0,
                                normal_max_p: 7.0,
                                nilai_rujukan_l: '2-7',
                                nilai_rujukan_p: '2-7'
                            },
                            {
                                nama: 'LYM%',
                                display_name: 'Limfosit',
                                satuan: '%',
                                normal_min_l: 20,
                                normal_max_l: 40,
                                normal_min_p: 20,
                                normal_max_p: 40,
                                nilai_rujukan_l: '20-40',
                                nilai_rujukan_p: '20-40'
                            },
                            {
                                nama: 'MID%',
                                display_name: 'Monosit',
                                satuan: '%',
                                normal_min_l: 3,
                                normal_max_l: 15,
                                normal_min_p: 3,
                                normal_max_p: 15,
                                nilai_rujukan_l: '3-15',
                                nilai_rujukan_p: '3-15'
                            },
                            {
                                nama: 'GRAN%',
                                display_name: 'Granulosit',
                                satuan: '%',
                                normal_min_l: 50,
                                normal_max_l: 70,
                                normal_min_p: 50,
                                normal_max_p: 70,
                                nilai_rujukan_l: '50-70',
                                nilai_rujukan_p: '50-70'
                            },
                            {
                                nama: 'RBC',
                                display_name: 'Eritrosit',
                                satuan: 'Juta/mm³',
                                normal_min_l: 4.5,
                                normal_max_l: 6.5,
                                normal_min_p: 3.0,      // Berbeda untuk perempuan
                                normal_max_p: 6.0,      // Berbeda untuk perempuan
                                nilai_rujukan_l: '4,5-6,5',
                                nilai_rujukan_p: '3,0-6,0'
                            },
                            {
                                nama: 'HGB',
                                display_name: 'Hemoglobin',
                                satuan: 'g/dL',
                                normal_min_l: 13.3,
                                normal_max_l: 17.0,
                                normal_min_p: 11.7,     // Berbeda untuk perempuan
                                normal_max_p: 15.7,     // Berbeda untuk perempuan
                                nilai_rujukan_l: '13,3-17,0',
                                nilai_rujukan_p: '11,7-15,7'
                            },
                            {
                                nama: 'HCT',
                                display_name: 'Hematokrit',
                                satuan: '%',
                                normal_min_l: 36,
                                normal_max_l: 48,
                                normal_min_p: 36,
                                normal_max_p: 48,
                                nilai_rujukan_l: '36-48',
                                nilai_rujukan_p: '36-48'
                            },
                            {
                                nama: 'MCV',
                                display_name: 'MCV',
                                satuan: 'fL',
                                normal_min_l: 80,
                                normal_max_l: 100,
                                normal_min_p: 80,
                                normal_max_p: 100,
                                nilai_rujukan_l: '80-100',
                                nilai_rujukan_p: '80-100'
                            },
                            {
                                nama: 'MCH',
                                display_name: 'MCH',
                                satuan: 'pg',
                                normal_min_l: 27,
                                normal_max_l: 32,
                                normal_min_p: 27,
                                normal_max_p: 32,
                                nilai_rujukan_l: '27-32',
                                nilai_rujukan_p: '27-32'
                            },
                            {
                                nama: 'MCHC',
                                display_name: 'MCHC',
                                satuan: 'g/dL',
                                normal_min_l: 32,
                                normal_max_l: 36,
                                normal_min_p: 32,
                                normal_max_p: 36,
                                nilai_rujukan_l: '32-36',
                                nilai_rujukan_p: '32-36'
                            },
                            {
                                nama: 'RDW-CV',
                                display_name: 'RDW-CV',
                                satuan: '%',
                                normal_min_l: 11.5,
                                normal_max_l: 14.5,
                                normal_min_p: 11.5,
                                normal_max_p: 14.5,
                                nilai_rujukan_l: '11,5-14,5',
                                nilai_rujukan_p: '11,5-14,5'
                            },
                            {
                                nama: 'RDW-SD',
                                display_name: 'RDW-SD',
                                satuan: 'fL',
                                normal_min_l: 39,
                                normal_max_l: 46,
                                normal_min_p: 39,
                                normal_max_p: 46,
                                nilai_rujukan_l: '39-46',
                                nilai_rujukan_p: '39-46'
                            },
                            {
                                nama: 'PLT',
                                display_name: 'Trombosit',
                                satuan: '10³/µL',
                                normal_min_l: 150,
                                normal_max_l: 350,
                                normal_min_p: 150,
                                normal_max_p: 350,
                                nilai_rujukan_l: '150-350',
                                nilai_rujukan_p: '150-350'
                            },
                            {
                                nama: 'MPV',
                                display_name: 'MPV',
                                satuan: 'fL',
                                normal_min_l: 7,
                                normal_max_l: 11,
                                normal_min_p: 7,
                                normal_max_p: 11,
                                nilai_rujukan_l: '7-11',
                                nilai_rujukan_p: '7-11'
                            },
                            {
                                nama: 'PDW',
                                display_name: 'PDW',
                                satuan: 'fL',
                                normal_min_l: 10,
                                normal_max_l: 18,
                                normal_min_p: 10,
                                normal_max_p: 18,
                                nilai_rujukan_l: '10-18',
                                nilai_rujukan_p: '10-18'
                            },
                            {
                                nama: 'PCT',
                                display_name: 'PCT',
                                satuan: '%',
                                normal_min_l: 0.15,
                                normal_max_l: 0.50,
                                normal_min_p: 0.15,
                                normal_max_p: 0.50,
                                nilai_rujukan_l: '0,15-0,50',
                                nilai_rujukan_p: '0,15-0,50'
                            },
                            {
                                nama: 'P-LCC',
                                display_name: 'P-LCC',
                                satuan: '10³/µL',
                                normal_min_l: 30,
                                normal_max_l: 90,
                                normal_min_p: 30,
                                normal_max_p: 90,
                                nilai_rujukan_l: '30-90',
                                nilai_rujukan_p: '30-90'
                            },
                            {
                                nama: 'P-LCR',
                                display_name: 'P-LCR',
                                satuan: '%',
                                normal_min_l: 13,
                                normal_max_l: 43,
                                normal_min_p: 13,
                                normal_max_p: 43,
                                nilai_rujukan_l: '13-43',
                                nilai_rujukan_p: '13-43'
                            }
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
                                nama: 'Urine Makro',
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
                                nama: 'Sedimen Urine',
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

                        // Fungsi untuk mendapatkan nilai normal berdasarkan jenis kelamin
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

                        const obxMap = {};

                        if (data_pasien && Array.isArray(data_pasien.obrs)) {
                            data_pasien.obrs.forEach(obr => {
                                if (!Array.isArray(obr.obx)) return;
                                obr.obx.forEach(obx => {
                                    const name = (obx.identifier_name || '').toLowerCase().trim();
                                    const value = obx.identifier_value ?? obx.observation_value ?? '';
                                    
                                    // skip jika kosong
                                    if (value === '' || value === null || value === undefined) return;

                                    if (typeof value === 'string' && /^\^image\^|^data:image/i.test(value)) return;

                                    if (!obxMap[name]) obxMap[name] = [];
                                    obxMap[name].push({
                                        value,
                                        unit: obx.identifier_unit,
                                        flags: obx.identifier_flags,
                                        id: obx.id,
                                        tanggal: obx.tanggal,
                                        raw: obx
                                    });
                                });
                            });

                            // sort tiap grup berdasarkan tanggal (fallback id) supaya urutan deterministik
                            Object.keys(obxMap).forEach(k => {
                                obxMap[k].sort((a,b) => {
                                    const ta = a.tanggal ? new Date(a.tanggal) : null;
                                    const tb = b.tanggal ? new Date(b.tanggal) : null;
                                    if (ta && tb) {
                                        const diff = ta - tb;
                                        if (diff !== 0) return diff;
                                    }
                                    return (a.id || 0) - (b.id || 0);
                                });
                            });
                        }

                        function getObxValues(parameterName) {
                            const key = (parameterName || '').toLowerCase().trim();
                            const obxItems = [];

                            // Guard clause: pastikan data_pasien dan obrs ada
                            if (!data_pasien || !Array.isArray(data_pasien.obrs)) {
                                console.warn('data_pasien.obrs tidak tersedia atau bukan array');
                                return {
                                    duplo_d1: '',
                                    duplo_d2: '',
                                    duplo_d3: '',
                                    hasilUtama: ''
                                };
                            }

                            data_pasien.obrs.forEach(obr => {
                                if (Array.isArray(obr.obx)) {
                                    obr.obx.forEach(obx => {
                                        const name = (obx.identifier_name || '').toLowerCase().trim();
                                        if (name === key) {
                                            obxItems.push(obx.identifier_value);
                                        }
                                    });
                                }
                            });

                            return {
                                duplo_d1: obxItems[1] ?? '',
                                duplo_d2: obxItems[2] ?? '',
                                duplo_d3: obxItems[3] ?? '',
                                hasilUtama: obxItems[0] ?? ''
                            };
                        }


                        function getInitialFlagContent(value, parameter = null, isHematologi = false, isUrine = false, nilaiRujukan = null, jenisKelamin = null) {
                            const nilaiHasil = parseFloat(value);
                            let flagIcon = '';

                            if (!isNaN(nilaiHasil) && value !== '') {
                                if (isHematologi && parameter) {
                                    // range normal untuk parameter hematologi berdasarkan jenis kelamin
                                    const paramData = hematologiParams.find(p => p.nama === parameter);
                                    if (paramData) {
                                        const normalValues = getNormalValues(paramData, jenisKelamin);
                                        
                                        let flagText = '';
                                        if (nilaiHasil < normalValues.min) {
                                            flagText = 'Low';
                                            flagIcon = `<i class="ti ti-arrow-down text-primary"></i> ${flagText}`;
                                        } else if (nilaiHasil > normalValues.max) {
                                            flagText = 'High';
                                            flagIcon = `<i class="ti ti-arrow-up text-danger"></i> ${flagText}`;
                                        } else {
                                            flagText = 'Normal';
                                            flagIcon = `<i class="ti ti-check text-success"></i> ${flagText}`;
                                        }
                                        
                                        // Cek threshold bintang untuk hematologi
                                        const starIndicator = checkStarThresholdHematologi(nilaiHasil, parameter, jenisKelamin);
                                        if (starIndicator) {
                                            flagIcon += ' *';
                                        }
                                    }
                                } else if (isUrine && parameter) {
                                    // range normal untuk parameter urine berdasarkan jenis kelamin
                                    const paramData = UrineParams.find(p => p.nama === parameter);
                                    if (paramData && paramData.normal_min_l !== '-' && paramData.normal_max_l !== '-') {
                                        const normalValues = getNormalValues(paramData, jenisKelamin);
                                        
                                        let flagText = '';
                                        if (nilaiHasil < normalValues.min) {
                                            flagText = 'Low';
                                            flagIcon = `<i class="ti ti-arrow-down text-primary"></i> ${flagText}`;
                                        } else if (nilaiHasil > normalValues.max) {
                                            flagText = 'High';
                                            flagIcon = `<i class="ti ti-arrow-up text-danger"></i> ${flagText}`;
                                        } else {
                                            flagText = 'Normal';
                                            flagIcon = `<i class="ti ti-check text-success"></i> ${flagText}`;
                                        }
                                        
                                        // Cek threshold bintang untuk urine
                                        const starIndicator = checkStarThresholdUrine(nilaiHasil, parameter, jenisKelamin);
                                        if (starIndicator) {
                                            flagIcon += ' *';
                                        }
                                    }
                                } else {
                                    // Flag logic untuk non-hematologi berdasarkan nilai rujukan dari database
                                    if (nilaiRujukan && jenisKelamin) {
                                        const normalRange = parseNilaiRujukan(nilaiRujukan, jenisKelamin);
                                        
                                        if (normalRange) {
                                            let flagText = '';
                                            if (nilaiHasil < normalRange.min) {
                                                flagText = 'Low';
                                                flagIcon = `<i class="ti ti-arrow-down text-primary"></i> ${flagText}`;
                                            } else if (nilaiHasil > normalRange.max) {
                                                flagText = 'High';
                                                flagIcon = `<i class="ti ti-arrow-up text-danger"></i> ${flagText}`;
                                            } else {
                                                flagText = 'Normal';
                                                flagIcon = `<i class="ti ti-check text-success"></i> ${flagText}`;
                                            }
                                            
                                            // Cek apakah perlu menambahkan bintang berdasarkan nilai threshold dalam kurung
                                            const starIndicator = checkStarThreshold(nilaiHasil, nilaiRujukan, jenisKelamin);
                                            if (starIndicator) {
                                                flagIcon += ' *';
                                            }
                                        }
                                    }
                                }
                            }
                            
                            return flagIcon;
                        }

                        function checkStarThresholdHematologi(nilaiHasil, parameter, jenisKelamin) {
                            // Definisi threshold untuk parameter hematologi (format: low;high)
                            const hematologiThreshold = {
                                'WBC': { L: '3.0;15.0', P: '3.0;15.0' },
                                'LYM#': { L: '0.8;5.0', P: '0.8;5.0' },
                                'MID#': { L: '0.1;1.0', P: '0.1;1.0' },
                                'GRAN#': { L: '1.5;8.0', P: '1.5;8.0' },
                                'LYM%': { L: '15;45', P: '15;45' },
                                'MID%': { L: '2;20', P: '2;20' },
                                'GRAN%': { L: '45;80', P: '45;80' },
                                'RBC': { L: '3.5;7.0', P: '2.5;6.5' },
                                'HGB': { L: '12.0;18.0', P: '10.0;16.0' },
                                'HCT': { L: '30;50', P: '30;50' },
                                'MCV': { L: '75;105', P: '75;105' },
                                'MCH': { L: '25;35', P: '25;35' },
                                'MCHC': { L: '30;38', P: '30;38' },
                                'RDW-CV': { L: '10.0;16.0', P: '10.0;16.0' },
                                'RDW-SD': { L: '35;50', P: '35;50' },
                                'PLT': { L: '100;450', P: '100;450' },
                                'MPV': { L: '6;12', P: '6;12' },
                                'PDW': { L: '8;20', P: '8;20' },
                                'PCT': { L: '0.10;0.60', P: '0.10;0.60' },
                                'P-LCC': { L: '25;100', P: '25;100' },
                                'P-LCR': { L: '10;50', P: '10;50' }
                            };

                            if (!hematologiThreshold[parameter]) return false;

                            let genderCode = '';
                            const lowerJenis = jenisKelamin?.toLowerCase() || '';

                            if (lowerJenis.includes('laki') || jenisKelamin === 'L') {
                                genderCode = 'L';
                            } else if (lowerJenis.includes('perempuan') || jenisKelamin === 'P') {
                                genderCode = 'P';
                            }

                            if (!genderCode || !hematologiThreshold[parameter][genderCode]) return false;

                            const thresholdValues = hematologiThreshold[parameter][genderCode].split(';');
                            const lowThreshold = parseFloat(thresholdValues[0]);
                            const highThreshold = parseFloat(thresholdValues[1]);

                            return nilaiHasil < lowThreshold || nilaiHasil > highThreshold;
                        }

                        function checkStarThresholdUrine(nilaiHasil, parameter, jenisKelamin) {
                            const urineThreshold = {
                                'Berat Jenis': { L: '1.005;1.040', P: '1.005;1.040' },
                                'PH': { L: '5.0;8.5', P: '5.0;8.5' }
                            };

                            if (!urineThreshold[parameter]) return false;

                            let genderCode = '';
                            const lowerJenis = jenisKelamin?.toLowerCase() || '';

                            if (lowerJenis.includes('laki') || jenisKelamin === 'L') {
                                genderCode = 'L';
                            } else if (lowerJenis.includes('perempuan') || jenisKelamin === 'P') {
                                genderCode = 'P';
                            }

                            if (!genderCode || !urineThreshold[parameter][genderCode]) return false;

                            const thresholdValues = urineThreshold[parameter][genderCode].split(';');
                            const lowThreshold = parseFloat(thresholdValues[0]);
                            const highThreshold = parseFloat(thresholdValues[1]);

                            return nilaiHasil < lowThreshold || nilaiHasil > highThreshold;
                        }

                        function checkStarThreshold(nilaiHasil, nilaiRujukan, jenisKelamin) {
                            if (!nilaiRujukan || !jenisKelamin) return false;

                            const thresholdMatch = nilaiRujukan.match(/\(([^)]+)\)/);
                            if (!thresholdMatch) return false;

                            const thresholdString = thresholdMatch[1];
                            const parts = thresholdString.split(' ');

                            let genderCode = '';
                            const lowerJenis = jenisKelamin?.toLowerCase() || '';

                            if (lowerJenis.includes('laki') || jenisKelamin === 'L') {
                                genderCode = 'L';
                            } else if (lowerJenis.includes('perempuan') || jenisKelamin === 'P') {
                                genderCode = 'P';
                            }

                            if (!genderCode) return false;

                            for (const part of parts) {
                                if (part.startsWith(genderCode + '.')) {
                                    const thresholdData = part.substring(2);

                                    if (thresholdData.includes(';')) {
                                        const thresholdValues = thresholdData.split(';');
                                        const lowThreshold = parseFloat(thresholdValues[0].replace(',', '.'));
                                        const highThreshold = parseFloat(thresholdValues[1].replace(',', '.'));

                                        if (!isNaN(lowThreshold) && !isNaN(highThreshold)) {
                                            return nilaiHasil < lowThreshold || nilaiHasil > highThreshold;
                                        }
                                    } else {
                                        const thresholdValue = parseFloat(thresholdData.replace(',', '.'));
                                        if (!isNaN(thresholdValue)) {
                                            return nilaiHasil < thresholdValue;
                                        }
                                    }
                                }
                            }

                            return false;
                        }

                        // Fungsi untuk mendapatkan display nilai rujukan (tanpa prefix L/P)
                       function getNilaiRujukanDisplay(nilaiRujukan, jenisKelamin) {
                            if (!nilaiRujukan || !jenisKelamin) return '';
                            
                            const normalRange = parseNilaiRujukan(nilaiRujukan, jenisKelamin);
                            
                            if (normalRange) {
                                if (normalRange.max === Infinity) {
                                    return `>${normalRange.min.toString().replace('.', ',')}`;
                                } else if (normalRange.min === 0 && nilaiRujukan.includes('<')) {
                                    return `<${normalRange.max.toString().replace('.', ',')}`;
                                } else {
                                    const minStr = normalRange.min.toString().replace('.', ',');
                                    const maxStr = normalRange.max.toString().replace('.', ',');
                                    return `${minStr}-${maxStr}`;
                                }
                            }
                            
                            return '';
                        }

                        // Fungsi helper untuk parsing nilai rujukan
                        function parseNilaiRujukan(nilaiRujukan, jenisKelamin) {
                            if (!nilaiRujukan) return null;
                            
                            // Hapus bagian dalam kurung untuk parsing normal range
                            const cleanNilaiRujukan = nilaiRujukan.replace(/\([^)]*\)/, '').trim();
                            
                            // Format: L.120-200 P.120-200 atau L.3,4-7,0 P.2,4-6,0
                            const parts = cleanNilaiRujukan.split(' ');
                            let targetRange = null;
                            
                            // Cari range yang sesuai dengan jenis kelamin
                            for (const part of parts) {
                                if (jenisKelamin === 'L' && part.startsWith('L.')) {
                                    targetRange = part.substring(2); // Hapus "L."
                                    break;
                                } else if (jenisKelamin === 'P' && part.startsWith('P.')) {
                                    targetRange = part.substring(2); // Hapus "P."
                                    break;
                                }
                            }
                            
                            if (!targetRange) return null;
                            
                            // Parse range (format: 120-200 atau 3,4-7,0 atau <200)
                            // Handle format dengan tanda < atau >
                            if (targetRange.startsWith('<')) {
                                const maxValue = parseFloat(targetRange.substring(1).replace(',', '.'));
                                if (!isNaN(maxValue)) {
                                    return { min: 0, max: maxValue };
                                }
                            } else if (targetRange.startsWith('>')) {
                                const minValue = parseFloat(targetRange.substring(1).replace(',', '.'));
                                if (!isNaN(minValue)) {
                                    return { min: minValue, max: Infinity };
                                }
                            } else {
                                // Format normal: min-max
                                const rangeParts = targetRange.split('-');
                                if (rangeParts.length === 2) {
                                    // Ganti koma dengan titik untuk parsing yang benar
                                    const min = parseFloat(rangeParts[0].replace(',', '.'));
                                    const max = parseFloat(rangeParts[1].replace(',', '.'));
                                    
                                    if (!isNaN(min) && !isNaN(max)) {
                                        return { min, max };
                                    }
                                }
                            }
                            
                            return null;
                        }

                        function getUrineNormalValues(param, jenisKelamin) {
                            const gender = jenisKelamin && (jenisKelamin.toLowerCase() === 'l' || jenisKelamin.toLowerCase() === 'laki-laki') 
                                ? 'L' 
                                : 'P';

                            const extractValue = (value) => {
                                if (!value || value === '') return '';

                                const hasGenderPrefix = /L\./i.test(value);
                                
                                if (!hasGenderPrefix) {
                                    return value.trim();
                                }

                                const regex = /L\.([^P]+)(?:\s*P\.(.+))?/i;
                                const match = value.match(regex);

                                if (match) {
                                    if (gender === 'L') {
                                        return match[1] ? match[1].trim() : '';
                                    } else {
                                        return match[2] ? match[2].trim() : (match[1] ? match[1].trim() : '');
                                    }
                                }

                                return value.trim();
                            };

                            const minValue = extractValue(param.normal_min);
                            const maxValue = extractValue(param.normal_max);
                            let rujukanValue = extractValue(param.nilai_rujukan);

                            if (!rujukanValue || rujukanValue === '-') {
                                if (minValue && maxValue && minValue !== '-' && maxValue !== '-') {
                                    rujukanValue = `${minValue}-${maxValue}`;
                                } else if (minValue && minValue !== '-') {
                                    rujukanValue = minValue;
                                } else if (maxValue && maxValue !== '-') {
                                    rujukanValue = maxValue;
                                }
                            }

                            const cleanValue = (val) => (val === '-' || val === 'L.- P.-') ? '' : val;

                            return {
                                min: cleanValue(minValue),
                                max: cleanValue(maxValue),
                                rujukan: cleanValue(rujukanValue)
                            };
                        }
                        let parameterCounter = 0;
    
                        function generateParameterUID(pemeriksaan, parameter, idx) {
                            parameterCounter++;
                            const cleanPemeriksaan = pemeriksaan.replace(/[^a-zA-Z0-9]/g, '_');
                            const cleanParameter = parameter.replace(/[^a-zA-Z0-9]/g, '_');
                            return `${cleanPemeriksaan}_${cleanParameter}_${idx}_${parameterCounter}`;
                        }

                        const content = `
                        <form id="worklistForm" action="{{ route('worklist.store') }}" method="POST">
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
                                                <th class="col-1">
                                                    <!-- Master Switch Button -->
                                                    <button type="button" class="btn btn-outline-secondary btn-sm master-switch-btn" 
                                                            id="masterSwitchBtn" title="Switch All Parameters">
                                                        <i class="ti ti-switch-2"></i>
                                                    </button>
                                                </th>
                                                <th class="col-2 duplo d1-column" style="display: none;">D1</th>
                                                <th class="col-2 duplo d2-column" style="display: none;">D2</th>
                                                <th class="col-2 duplo d3-column" style="display: none;">D3</th>
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
                                                        <th class="col-2 duplo d1-column" style="display: none;">D1</th>
                                                        <th class="col-2 duplo d2-column" style="display: none;">D2</th>
                                                        <th class="col-2 duplo d3-column" style="display: none;">D3</th>
                                                        <th class="col-3">FLAG</th>
                                                        <th class="col-2">Unit</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    ${(() => {
                                                        // Cek apakah ada pemeriksaan hematologi di grup ini
                                                        const hasHematologi = e.pasiens.some(p => {
                                                            const isHematologi = p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('darah lengkap');
                                                            return isHematologi;
                                                        });

                                                        // Cek apakah ada pemeriksaan widal di grup ini
                                                        const hasWidal = e.pasiens.some(p => {
                                                            const isWidal = p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('widal');
                                                            return isWidal;
                                                        });

                                                        // TAMBAHAN: Cek apakah ada pemeriksaan urine di grup ini
                                                        const hasUrine = e.pasiens.some(p => {
                                                            const isUrine = p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('urin') || 
                                                                        p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('urine');
                                                            return isUrine;
                                                        });
                                                        // Cek apakah ada pemeriksaan mikrobiologi di grup ini
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

                                                        // Tambahkan di bagian atas sebelum if-else pemeriksaan
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
                                                                const obxValues = getObxValues(param.nama);
                                                                const rowId = `${judul}_${idx}_${paramIdx}`;
                                                                const label = param.display_name || param.nama || '-';
                                                                
                                                                // ★ TAMBAHAN: Generate UID unik untuk setiap parameter serologi
                                                                const uniqueID = generateParameterUID(judul, param.nama, paramIdx);

                                                                // ★ PERBAIKAN: Ubah renderField untuk menggunakan UID
                                                                const renderField = (name, value, extraClass = '') => {
                                                                    if (param.tipe_inputan === 'Dropdown') {
                                                                        return `
                                                                            <select name="${name}[${uniqueID}]" class="form-select ${extraClass} w-60 p-0" disabled>
                                                                                <option value="" selected hidden></option>
                                                                                ${param.opsi_output.split(';').map(opt => `
                                                                                    <option value="${opt.trim()}" ${value === opt.trim() ? 'selected' : ''}>${opt.trim()}</option>
                                                                                `).join('')}
                                                                            </select>
                                                                        `;
                                                                    } else {
                                                                        return `
                                                                            <input type="text" name="${name}[${uniqueID}]" 
                                                                                class="form-control ${extraClass} w-60 p-0 text-center" 
                                                                                disabled value="${value || ''}" />
                                                                        `;
                                                                    }
                                                                };

                                                                return `
                                                                    <tr data-id="${rowId}" data-parameter="${param.nama}" data-uid="${uniqueID}" class="serologi-row">
                                                                        <td class="col-2 ps-4">
                                                                            <strong>${label}</strong>
                                                                            ${param.nilai_rujukan ? `<small class="text-muted d-block">${param.nilai_rujukan}</small>` : ''}
                                                                            
                                                                            <!-- ★ PERBAIKAN: Tambah UID sebagai master key -->
                                                                            <input type="hidden" name="uid[]" value="${uniqueID}" />
                                                                            
                                                                            <!-- ★ PERBAIKAN: Semua field sekarang menggunakan UID sebagai key -->
                                                                            <input type="hidden" name="nama_pemeriksaan[${uniqueID}]" value="${namaPemeriksaan}" />
                                                                            <input type="hidden" name="judul[${uniqueID}]" value="${judul}" />
                                                                            <input type="hidden" name="parameter_name[${uniqueID}]" value="${param.nama}" />
                                                                            <input type="hidden" name="metode[${uniqueID}]" value="${param.metode ?? ''}" />
                                                                            <input type="hidden" name="nilai_rujukan[${uniqueID}]" value="${param.nilai_rujukan}" />
                                                                            <input type="hidden" name="department[${uniqueID}]" value="${e.data_departement.nama_department}" />
                                                                        </td>

                                                                        <!-- hasil utama -->
                                                                        <td class="col-2" required>
                                                                            ${renderField('hasil', obxValues.hasilUtama || param.default, 'manualInput')}
                                                                        </td>

                                                                        <!-- tombol switch -->
                                                                        <td class="col-1 text-center">
                                                                            <button type="button" class="btn btn-outline-secondary btn-sm switch-btn">
                                                                                <i class="ti ti-switch-2"></i>
                                                                            </button>
                                                                        </td>

                                                                        <!-- duplo D1 -->
                                                                        <td class="col-2 duplo d1-column text-center" style="display:none;">
                                                                            ${renderField('duplo_d1', obxValues.duplo_d1, 'd1')}
                                                                        </td>

                                                                        <!-- duplo D2 -->
                                                                        <td class="col-2 duplo d2-column text-center" style="display:none;">
                                                                            ${renderField('duplo_d2', obxValues.duplo_d2, 'd2')}
                                                                        </td>

                                                                        <!-- duplo D3 -->
                                                                        <td class="col-2 duplo d3-column text-center" style="display:none;">
                                                                            ${renderField('duplo_d3', obxValues.duplo_d3, 'd3')}
                                                                        </td>

                                                                        <!-- flag -->
                                                                        <td class="col-3 flag-cell">
                                                                            <input type="hidden" name="flag[${uniqueID}]" value="" />
                                                                        </td>

                                                                        <!-- satuan -->
                                                                        <td>
                                                                            <input type="hidden" name="satuan[${uniqueID}]" value="${param.satuan || ''}" />
                                                                            ${param.satuan || ''}
                                                                        </td>
                                                                    </tr>
                                                                `;
                                                            }).join('');

                                                            return html;
                                                        }
                                                        if (hasHematologi) {
                                                            const hematologiPemeriksaan = e.pasiens.find(p => 
                                                                p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('darah lengkap')
                                                            );
                                                            const judulHematologi = e.pasiens.find(p => p.data_pemeriksaan?.judul)?.data_pemeriksaan?.judul || '';
                                                            const namaPemeriksaanHematologi = hematologiPemeriksaan ? hematologiPemeriksaan.data_pemeriksaan.nama_pemeriksaan : 'Hematologi Lengkap';
                                                            
                                                            let html = '';
                                                            
                                                            if (judulHematologi) {
                                                                html += `
                                                                    <tr class="hematologi-title-header">
                                                                        <td colspan="8" class="fw-bold text-primary ps-3" style="background-color: #e3f2fd; border-left: 4px solid #2196f3; padding: 10px;">
                                                                            ${judulHematologi}
                                                                        </td>
                                                                    </tr>
                                                                `;
                                                            }
                                                            
                                                            html += hematologiParams.map((param, paramIdx) => {
                                                                
                                                                const obxValues = getObxValues(param.nama);
                                                                const rowId = `hematologi_${idx}_${paramIdx}`;
                                                                const uniqueID = generateParameterUID('Hematologi', param.nama, paramIdx);
                                                                const initialFlag = getInitialFlagContent(obxValues.hasilUtama, param.nama, true, false);
                                                                const normalValues = getNormalValues(param, data_pasien.jenis_kelamin);
                                                                
                                                                return `
                                                                    <tr data-id="${rowId}" data-parameter="${param.nama}" data-uid="${uniqueID}" class="hematologi-row">
                                                                        <td class="col-2 ${judulHematologi ? 'ps-4' : ''}" ${judulHematologi ? 'style="border-left: 2px solid #e9ecef;"' : ''}>
                                                                            <strong>${param.display_name}</strong>
                                                                            <small class="text-muted d-block">${normalValues.display}</small>
                                                                            <input type="hidden" name="uid[]" value="${uniqueID}" />
                                                                            <input type="hidden" name="nama_pemeriksaan[${uniqueID}]" value="${namaPemeriksaanHematologi}" />
                                                                            ${judulHematologi ? `<input type="hidden" name="judul[${uniqueID}]" value="${judulHematologi}" />` : ''}
                                                                            <input type="hidden" name="parameter_name[${uniqueID}]" value="${param.nama}" />
                                                                            <input type="hidden" name="metode[${uniqueID}]" value="${param.metode ?? ''}" />
                                                                            <input type="hidden" name="nilai_rujukan[${uniqueID}]" value="${normalValues.rujukan}" />
                                                                            <input type="hidden" name="department[${uniqueID}]" value="${e.data_departement.nama_department}" />
                                                                        </td>
                                                                        <td class="col-2">
                                                                            <input type="number" name="hasil[${uniqueID}]" 
                                                                                class="form-control manualInput w-60 p-0 text-center" 
                                                                                value="${obxValues.hasilUtama || ''}" 
                                                                                step="0.01" placeholder="" required />
                                                                        </td>
                                                                        <td class="col-1">
                                                                            <button type="button" class="btn btn-outline-secondary btn-sm switch-btn" 
                                                                                    data-index="${paramIdx}" data-switch-index="0">
                                                                                <i class="ti ti-switch-2"></i>
                                                                            </button>
                                                                        </td>
                                                                        <td class="col-2 duplo d1-column text-center" style="display: none;">
                                                                            <input type="number" name="duplo_d1[${uniqueID}]" 
                                                                                class="form-control d1 w-60 p-0 text-center" 
                                                                                disabled value="${obxValues.duplo_d1 || ''}" step="0.01" />
                                                                        </td>
                                                                        <td class="col-2 duplo d2-column" style="display: none;">
                                                                            <input type="number" name="duplo_d2[${uniqueID}]" 
                                                                                class="form-control d2 w-60 p-0 text-center" 
                                                                                disabled value="${obxValues.duplo_d2 || ''}" step="0.01" />
                                                                        </td>
                                                                        <td class="col-2 duplo d3-column" style="display: none;">
                                                                            <input type="number" name="duplo_d3[${uniqueID}]" 
                                                                                class="form-control d3 w-50 p-0 text-center" 
                                                                                disabled value="${obxValues.duplo_d3 || ''}" step="0.01" />
                                                                        </td>
                                                                        <td class="col-3 flag-cell">
                                                                            ${initialFlag}
                                                                            <input type="hidden" name="flag[${uniqueID}]" value="${initialFlag.replace(/<[^>]*>?/gm, '')}" />
                                                                        </td>
                                                                        <td>
                                                                            <input type="hidden" name="satuan[${uniqueID}]" class="form-control w-100 p-0" 
                                                                                value="${param.satuan}" readonly />
                                                                            ${param.satuan}
                                                                        </td>
                                                                    </tr>
                                                                `;
                                                            }).join('');
                                                            
                                                            return html;

                                                        } else if (hasWidal) {
                                                            const widalPemeriksaan = e.pasiens.find(p => 
                                                                p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('widal')
                                                            );
                                                            const judulWidal = e.pasiens.find(p => p.data_pemeriksaan?.judul)?.data_pemeriksaan?.judul || '';
                                                            const namaPemeriksaanWidal = widalPemeriksaan ? widalPemeriksaan.data_pemeriksaan.nama_pemeriksaan : 'Widal';
                                                            
                                                            let html = '';
                                                            
                                                            if (judulWidal) {
                                                                html += `
                                                                    <tr class="widal-title-header">
                                                                        <td colspan="8" class="fw-bold text-warning ps-3" style="background-color: #fff3e0; border-left: 4px solid #ff9800; padding: 10px;">
                                                                            ${judulWidal}
                                                                        </td>
                                                                    </tr>
                                                                `;
                                                            }
                                                            
                                                            // Tampilkan semua parameter dengan indentasi
                                                            html += WidalParams.map((param, paramIdx) => {
                                                                const obxValues = getObxValues(param.nama);
                                                                const rowId = `widal_${idx}_${paramIdx}`;
                                                                const uniqueID = generateParameterUID('Widal', param.nama, paramIdx);
                                                                const normalValues = getNormalValues(param, data_pasien.jenis_kelamin);
                                                                
                                                                return `
                                                                    <tr data-id="${rowId}" data-parameter="${param.nama}" data-uid="${uniqueID}" class="widal-row">
                                                                        <td class="col-2 ${judulWidal ? 'ps-4' : ''}" ${judulWidal ? 'style="border-left: 2px solid #e9ecef;"' : ''}>
                                                                            <strong>${param.display_name}</strong>
                                                                            <small class="text-muted d-block">${normalValues.display}</small>
                                                                            <input type="hidden" name="uid[]" value="${uniqueID}" />
                                                                            <input type="hidden" name="nama_pemeriksaan[${uniqueID}]" value="${namaPemeriksaanWidal}" />
                                                                            ${judulWidal ? `<input type="hidden" name="judul[${uniqueID}]" value="${judulWidal}" />` : ''}
                                                                            <input type="hidden" name="parameter_name[${uniqueID}]" value="${param.nama}" />
                                                                            <input type="hidden" name="metode[${uniqueID}]" value="${param.metode ?? ''}" />
                                                                            <input type="hidden" name="nilai_rujukan[${uniqueID}]" value="${normalValues.rujukan}" />
                                                                            <input type="hidden" name="department[${uniqueID}]" value="${e.data_departement.nama_department}" />
                                                                        </td>
                                                                        <td class="col-2">
                                                                            <select name="hasil[${uniqueID}]" 
                                                                                class="form-select manualInput w-60 p-0" 
                                                                                disabled required>
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
                                                                        <td class="col-2 duplo d1-column text-center" style="display: block;">
                                                                            <select name="duplo_d1[${uniqueID}]" class="form-select d1 w-60 p-0" disabled>
                                                                                ${param.opsi_output.split(';').map(opt => `
                                                                                    <option value="${opt.trim()}" ${obxValues.duplo_d1 === opt.trim() ? 'selected' : ''}>
                                                                                        ${opt.trim()}
                                                                                    </option>
                                                                                `).join('')}
                                                                            </select>
                                                                        </td>
                                                                        <td class="col-2 duplo d2-column" style="display: none;">
                                                                            <select name="duplo_d2[${uniqueID}]" class="form-select d2 w-60 p-0" disabled>
                                                                                ${param.opsi_output.split(';').map(opt => `
                                                                                    <option value="${opt.trim()}" ${obxValues.duplo_d2 === opt.trim() ? 'selected' : ''}>
                                                                                        ${opt.trim()}
                                                                                    </option>
                                                                                `).join('')}
                                                                            </select>
                                                                        </td>
                                                                        <td class="col-2 duplo d3-column" style="display: none;">
                                                                            <select name="duplo_d3[${uniqueID}]" class="form-select d3 w-50 p-0" disabled>
                                                                                ${param.opsi_output.split(';').map(opt => `
                                                                                    <option value="${opt.trim()}" ${obxValues.duplo_d3 === opt.trim() ? 'selected' : ''}>
                                                                                        ${opt.trim()}
                                                                                    </option>
                                                                                `).join('')}
                                                                            </select>
                                                                        </td>
                                                                        <td class="col-3 flag-cell">
                                                                            <!-- Untuk widal tidak ada flag normal/abnormal -->
                                                                        </td>
                                                                        <td>
                                                                            <input type="hidden" name="satuan[${uniqueID}]" class="form-control w-100 p-0" 
                                                                                value="${param.satuan}" readonly />
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
                                                                            style="background-color: #e1f5fe; border-left: 4px solid #00bcd4; padding: 10px;">
                                                                            ${judulGroup}
                                                                        </td>
                                                                    </tr>
                                                                `;

                                                                // Render parameter dalam grup
                                                                html += params.map((param, paramIdx) => {
                                                                    const obxValues = getObxValues(param.nama);
                                                                    const rowId = `urine_${idx}_${paramIdx}`;
                                                                    const initialFlag = getInitialFlagContent(
                                                                        obxValues.hasilUtama, 
                                                                        param.nama, 
                                                                        false, 
                                                                        true, 
                                                                        null, 
                                                                        data_pasien.jenis_kelamin
                                                                    );
                                                                    const uniqueID = generateParameterUID('Urine_' + judulGroup, param.nama, paramIdx);
                                                                    
                                                                    const normalValues = getUrineNormalValues(param, data_pasien.jenis_kelamin);
                                                                    const displayRujukan = normalValues.rujukan || '';

                                                                    return `
                                                                        <tr data-id="${rowId}" data-parameter="${param.nama}" data-uid="${uniqueID}" class="urine-row">
                                                                            <td class="col-2 ps-4" style="border-left: 2px solid #e9ecef;">
                                                                                <strong>${param.display_name}</strong>
                                                                                ${displayRujukan 
                                                                                    ? `<small class="text-muted d-block">${displayRujukan}</small>` 
                                                                                    : ''}

                                                                                <input type="hidden" name="uid[]" value="${uniqueID}" />
                                                                                <input type="hidden" name="nama_pemeriksaan[${uniqueID}]" value="${namaPemeriksaanUrine}" />
                                                                                <input type="hidden" name="judul[${uniqueID}]" value="${param.judul}" />
                                                                                <input type="hidden" name="parameter_name[${uniqueID}]" value="${param.nama}" />
                                                                                <input type="hidden" name="metode[${uniqueID}]" value="${param.metode ?? ''}" />
                                                                                <input type="hidden" name="nilai_rujukan[${uniqueID}]" value="${displayRujukan}" />
                                                                                <input type="hidden" name="department[${uniqueID}]" value="${e.data_departement.nama_department}" />
                                                                            </td>

                                                                            <td class="col-2">
                                                                                ${param.tipe_inputan.toLowerCase() === 'text' ? `
                                                                                    <input type="text" name="hasil[${uniqueID}]" 
                                                                                        class="form-control manualInput w-60 p-0 text-center" 
                                                                                        disabled required value="${obxValues.hasilUtama || param.default || ''}" />
                                                                                ` : `
                                                                                    <select name="hasil[${uniqueID}]" class="form-select manualInput w-60 p-0" required disabled>
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

                                                                            <td class="col-2 duplo d1-column text-center" style="display: none;">
                                                                                ${param.tipe_inputan.toLowerCase() === 'text' ? `
                                                                                    <input type="text" name="duplo_d1[${uniqueID}]" 
                                                                                        class="form-control d1 w-60 p-0 text-center" 
                                                                                        disabled value="${obxValues.duplo_d1 || ''}" />
                                                                                ` : `
                                                                                    <select name="duplo_d1[${uniqueID}]" class="form-select d1 w-60 p-0" disabled>
                                                                                        ${param.opsi_output.split(';').map(opt => `
                                                                                            <option value="${opt.trim()}" ${obxValues.duplo_d1 === opt.trim() ? 'selected' : ''}>
                                                                                                ${opt.trim()}
                                                                                            </option>
                                                                                        `).join('')}
                                                                                    </select>
                                                                                `}
                                                                            </td>

                                                                            <td class="col-2 duplo d2-column" style="display: none;">
                                                                                ${param.tipe_inputan.toLowerCase() === 'text' ? `
                                                                                    <input type="text" name="duplo_d2[${uniqueID}]" 
                                                                                        class="form-control d2 w-60 p-0 text-center" 
                                                                                        disabled value="${obxValues.duplo_d2 || ''}" />
                                                                                ` : `
                                                                                    <select name="duplo_d2[${uniqueID}]" class="form-select d2 w-60 p-0" disabled>
                                                                                        ${param.opsi_output.split(';').map(opt => `
                                                                                            <option value="${opt.trim()}" ${obxValues.duplo_d2 === opt.trim() ? 'selected' : ''}>
                                                                                                ${opt.trim()}
                                                                                            </option>
                                                                                        `).join('')}
                                                                                    </select>
                                                                                `}
                                                                            </td>

                                                                            <td class="col-2 duplo d3-column" style="display: none;">
                                                                                ${param.tipe_inputan.toLowerCase() === 'text' ? `
                                                                                    <input type="text" name="duplo_d3[${uniqueID}]" 
                                                                                        class="form-control d3 w-50 p-0 text-center" 
                                                                                        disabled value="${obxValues.duplo_d3 || ''}" />
                                                                                ` : `
                                                                                    <select name="duplo_d3[${uniqueID}]" class="form-select d3 w-50 p-0" disabled>
                                                                                        ${param.opsi_output.split(';').map(opt => `
                                                                                            <option value="${opt.trim()}" ${obxValues.duplo_d3 === opt.trim() ? 'selected' : ''}>
                                                                                                ${opt.trim()}
                                                                                            </option>
                                                                                        `).join('')}
                                                                                    </select>
                                                                                `}
                                                                            </td>

                                                                            <td class="col-3 flag-cell">
                                                                                ${initialFlag}
                                                                                <input type="hidden" name="flag[${uniqueID}]" 
                                                                                    value="${initialFlag.replace(/<[^>]*>?/gm, '')}" />
                                                                            </td>

                                                                            <td>
                                                                                <input type="hidden" name="satuan[${uniqueID}]" class="form-control w-100 p-0" 
                                                                                    value="${param.satuan}" readonly />
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
                                                                    const obxValues = getObxValues(param.nama);
                                                                    const rowId = `mikrobiologi_${idx}_${paramIdx}`;
                                                                    const uniqueID = generateParameterUID('Mikrobiologi', param.nama, paramIdx);
                                                                    const normalValues = getNormalValues(param, data_pasien.jenis_kelamin);
                                                                    const label = param.judul || param.display_name || param.nama || '-';

                                                                    return `
                                                                        <tr data-id="${rowId}" data-parameter="${param.nama}" data-uid="${uniqueID}" class="mikrobiologi-row">
                                                                            <td class="col-2 ps-4" style="border-left: 2px solid #e9ecef;">
                                                                                <strong>${label}</strong>
                                                                                ${param.nilai_rujukan !== '-' && param.nilai_rujukan !== '' ? 
                                                                                    `<small class="text-muted d-block">${param.nilai_rujukan ?? ''}</small>` : ''}
                                                                                <input type="hidden" name="uid[]" value="${uniqueID}" />
                                                                                <input type="hidden" name="nama_pemeriksaan[${uniqueID}]" value="${namaPemeriksaanMikrobiologi}" />
                                                                                <input type="hidden" name="judul[${uniqueID}]" value="${judulMikrobiologi}" />
                                                                                <input type="hidden" name="parameter_name[${uniqueID}]" value="${param.nama}" />
                                                                                <input type="hidden" name="metode[${uniqueID}]" value="${param.metode ?? ''}" />
                                                                                <input type="hidden" name="nilai_rujukan[${uniqueID}]" value="${param.nilai_rujukan ?? '-'}" />
                                                                                <input type="hidden" name="department[${uniqueID}]" value="${e.data_departement.nama_department}" />
                                                                            </td>
                                                                            <td class="col-2">
                                                                                ${param.tipe_inputan === 'Text' ? `
                                                                                    <input type="text" name="hasil[${uniqueID}]" class="form-control manualInput w-60 p-0 text-center" required disabled value="${obxValues.hasilUtama || ''}" />
                                                                                ` : `
                                                                                    <select name="hasil[${uniqueID}]" class="form-select manualInput w-60 p-0" required disabled>
                                                                                        ${param.opsi_output ? param.opsi_output.split(';').map(opt => `
                                                                                            <option value="${opt.trim()}" ${obxValues.hasilUtama === opt.trim() ? 'selected' : ''}>${opt.trim()}</option>
                                                                                        `).join('') : '<option value="">Pilih...</option>'}
                                                                                    </select>
                                                                                `}
                                                                            </td>
                                                                            <td class="col-1">
                                                                                <button type="button" class="btn btn-outline-secondary btn-sm switch-btn" data-index="${paramIdx}" data-switch-index="0">
                                                                                    <i class="ti ti-switch-2"></i>
                                                                                </button>
                                                                            </td>
                                                                            <td class="col-2 duplo d1-column text-center" style="display: none;">
                                                                                ${param.tipe_inputan === 'Text' ? `
                                                                                    <input type="text" name="duplo_d1[${uniqueID}]" class="form-control d1 w-60 p-0 text-center" disabled value="${obxValues.duplo_d1 || ''}" />
                                                                                ` : `
                                                                                    <select name="duplo_d1[${uniqueID}]" class="form-select d1 w-60 p-0" disabled>
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
                                                                                        ${param.opsi_output ? param.opsi_output.split(';').map(opt => `
                                                                                            <option value="${opt.trim()}" ${obxValues.duplo_d3 === opt.trim() ? 'selected' : ''}>${opt.trim()}</option>
                                                                                        `).join('') : '<option value="">Pilih...</option>'}
                                                                                    </select>
                                                                                `}
                                                                            </td>
                                                                            <td class="col-3 flag-cell"></td>
                                                                            <td>
                                                                                <input type="hidden" name="satuan[${uniqueID}]" value="${param.satuan || ''}" readonly />
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
                                                                    const obxValues = getObxValues(param.nama);
                                                                    const rowId = `preparatbasah_${idx}_${paramIdx}`;
                                                                    const uniqueID = generateParameterUID('PreparatBasah', param.nama, paramIdx);
                                                                    const normalValues = getNormalValues(param, data_pasien.jenis_kelamin);
                                                                    const label = param.judul || param.display_name || param.nama || '-';

                                                                    return `
                                                                        <tr data-id="${rowId}" data-parameter="${param.nama}" data-uid="${uniqueID}" class="preparatbasah-row">
                                                                            <td class="col-2 ps-4" style="border-left: 2px solid #e9ecef;">
                                                                                <strong>${label}</strong>
                                                                                ${param.nilai_rujukan !== '-' && param.nilai_rujukan !== '' ? 
                                                                                    `<small class="text-muted d-block">${param.nilai_rujukan ?? ''}</small>` : ''}
                                                                                <input type="hidden" name="uid[]" value="${uniqueID}" />
                                                                                <input type="hidden" name="nama_pemeriksaan[${uniqueID}]" value="${namaPemeriksaanPreparatBasah}" />
                                                                                <input type="hidden" name="judul[${uniqueID}]" value="${judulPreparatBasah}" />
                                                                                <input type="hidden" name="parameter_name[${uniqueID}]" value="${param.nama}" />
                                                                                <input type="hidden" name="metode[${uniqueID}]" value="${param.metode ?? ''}" />
                                                                                <input type="hidden" name="nilai_rujukan[${uniqueID}]" value="${param.nilai_rujukan ?? '-'}" />
                                                                                <input type="hidden" name="department[${uniqueID}]" value="${e.data_departement.nama_department}" />
                                                                            </td>
                                                                            <td class="col-2">
                                                                                ${param.tipe_inputan === 'Text' ? `
                                                                                    <input type="text" name="hasil[${uniqueID}]" class="form-control manualInput w-60 p-0 text-center" required disabled value="${obxValues.hasilUtama || ''}" />
                                                                                ` : `
                                                                                    <select name="hasil[${uniqueID}]" class="form-select manualInput w-60 p-0" required disabled>
                                                                                        ${param.opsi_output ? param.opsi_output.split(';').map(opt => `
                                                                                            <option value="${opt.trim()}" ${obxValues.hasilUtama === opt.trim() ? 'selected' : ''}>${opt.trim()}</option>
                                                                                        `).join('') : '<option value="">Pilih...</option>'}
                                                                                    </select>
                                                                                `}
                                                                            </td>
                                                                            <td class="col-1">
                                                                                <button type="button" class="btn btn-outline-secondary btn-sm switch-btn" data-index="${paramIdx}" data-switch-index="0">
                                                                                    <i class="ti ti-switch-2"></i>
                                                                                </button>
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
                                                                            <td class="col-3 flag-cell"></td>
                                                                            <td>
                                                                                <input type="hidden" name="satuan[${uniqueID}]" value="${param.satuan || ''}" readonly />
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
                                                            const judulFeses = e.pasiens.find(p => p.data_pemeriksaan?.judul)?.data_pemeriksaan?.judul || 'Feses';
                                                            const namaPemeriksaanFeses = fesesPemeriksaan ? fesesPemeriksaan.data_pemeriksaan.nama_pemeriksaan : 'Feses';
                                                            
                                                            let html = '';
                                                            
                                                            if (judulFeses) {
                                                                html += `
                                                                    <tr class="feses-title-header">
                                                                        <td colspan="8" class="fw-bold text-secondary ps-3" 
                                                                            style="background-color: #f8f9fa; border-left: 4px solid #ffc107; padding: 10px;">
                                                                            ${judulFeses}
                                                                        </td>
                                                                    </tr>
                                                                `;
                                                            }

                                                            html += FesesParams.map((param, paramIdx) => {
                                                                const obxValues = getObxValues(param.nama);
                                                                const rowId = `feses_${idx}_${paramIdx}`;
                                                                const normalValues = getNormalValues(param, data_pasien.jenis_kelamin);
                                                                const uniqueID = generateParameterUID('Feses', param.nama, paramIdx);

                                                                const label = param.display_name || param.nama || '-';

                                                                return `
                                                                    <tr data-id="${rowId}" data-parameter="${param.nama}" data-uid="${uniqueID}" class="feses-row">
                                                                        <td class="col-2 ps-4" style="border-left: 2px solid #e9ecef;">
                                                                            <strong>${label}</strong>
                                                                            ${param.nilai_rujukan !== '-' && param.nilai_rujukan !== '' ? 
                                                                                `<small class="text-muted d-block">${param.nilai_rujukan ?? ''}</small>` : ''}

                                                                            <input type="hidden" name="uid[]" value="${uniqueID}" />
                                                                            <input type="hidden" name="nama_pemeriksaan[${uniqueID}]" value="${namaPemeriksaanFeses}" />
                                                                            <input type="hidden" name="judul[${uniqueID}]" value="${judulFeses}" />
                                                                            <input type="hidden" name="parameter_name[${uniqueID}]" value="${param.nama}" />
                                                                            <input type="hidden" name="metode[${uniqueID}]" value="${param.metode ?? ''}" />
                                                                            <input type="hidden" name="nilai_rujukan[${uniqueID}]" value="${param.nilai_rujukan ?? '-'}" />
                                                                            <input type="hidden" name="department[${uniqueID}]" value="${e.data_departement.nama_department}" />
                                                                        </td>

                                                                        <td class="col-2">
                                                                            ${param.tipe_inputan === 'Text' ? `
                                                                                <input type="text" name="hasil[${uniqueID}]" 
                                                                                    class="form-control manualInput w-60 p-0 text-center" 
                                                                                    disabled required value="${obxValues.hasilUtama || param.default || ''}" />
                                                                            ` : `
                                                                                <select name="hasil[${uniqueID}]" class="form-select manualInput w-60 p-0" required disabled>
                                                                                    ${param.opsi_output ? param.opsi_output.split(';').map(opt => `
                                                                                        <option value="${opt.trim()}" ${(obxValues.hasilUtama || param.default) === opt.trim() ? 'selected' : ''}>
                                                                                            ${opt.trim()}
                                                                                        </option>
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
                                                                                <input type="text" name="duplo_d1[${uniqueID}]" class="form-control d1 w-60 p-0 text-center" disabled value="${obxValues.duplo_d1 || ''}" />
                                                                            ` : `
                                                                                <select name="duplo_d1[${uniqueID}]" class="form-select d1 w-60 p-0" disabled>
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
                                                                                <input type="text" name="duplo_d2[${uniqueID}]" class="form-control d2 w-60 p-0 text-center" disabled value="${obxValues.duplo_d2 || ''}" />
                                                                            ` : `
                                                                                <select name="duplo_d2[${uniqueID}]" class="form-select d2 w-60 p-0" disabled>
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
                                                                                <input type="text" name="duplo_d3[${uniqueID}]" class="form-control d3 w-50 p-0 text-center" disabled value="${obxValues.duplo_d3 || ''}" />
                                                                            ` : `
                                                                                <select name="duplo_d3[${uniqueID}]" class="form-select d3 w-50 p-0" disabled>
                                                                                    ${param.opsi_output ? param.opsi_output.split(';').map(opt => `
                                                                                        <option value="${opt.trim()}" ${obxValues.duplo_d3 === opt.trim() ? 'selected' : ''}>
                                                                                            ${opt.trim()}
                                                                                        </option>
                                                                                    `).join('') : '<option value="">Pilih...</option>'}
                                                                                </select>
                                                                            `}
                                                                        </td>

                                                                        <td class="col-3 flag-cell"></td>

                                                                        <td>
                                                                            <input type="hidden" name="satuan[${uniqueID}]" class="form-control w-100 p-0" value="${param.satuan || ''}" readonly />
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
                                                        
                                                            function getNilaiRujukanDisplay(nilaiRujukan, jenisKelamin) {
                                                                if (!nilaiRujukan) return '';
                                                                const parts = nilaiRujukan.split(' ');
                                                                let prefix = jenisKelamin.toLowerCase().startsWith('l') ? 'L.' : 'P.';
                                                                let match = parts.find(part => part.startsWith(prefix));
                                                                return match ? `${match.replace(prefix, '')}` : '';
                                                            }
                                                            
                                                            
                                                            if (!window.currentActiveLab) {
                                                                window.currentActiveLab = null;
                                                            }
                                                            
                                                            
                                                            window.saveTempData = function(noLab, forceAll = false) {
                                                                if (!noLab) {
                                                                    return;
                                                                }
                                                                
                                                                const data = [];
                                                                
                                                                document.querySelectorAll('[data-id][data-parameter]').forEach(row => {
                                                                    // Cari semua kemungkinan input hasil
                                                                    const hasilInput = row.querySelector('.hasil-input');
                                                                    const hasilSelect = row.querySelector('.hasil-select');
                                                                    const manualInput = row.querySelector('.manualInput'); // Tambahan untuk menangkap semua .manualInput
                                                                    const d1 = row.querySelector('.d1');
                                                                    const d2 = row.querySelector('.d2');
                                                                    const d3 = row.querySelector('.d3');
                                                                    
                                                                    // Ambil nilai hasil dari input yang visible
                                                                    let hasil = '';
                                                                    if (hasilInput && hasilInput.style.display !== 'none') {
                                                                        hasil = hasilInput.value || '';
                                                                    } else if (hasilSelect && hasilSelect.style.display !== 'none') {
                                                                        hasil = hasilSelect.value || '';
                                                                    } else if (manualInput && manualInput.style.display !== 'none') {
                                                                        hasil = manualInput.value || '';
                                                                    }
                                                                    
                                                                    const d1Val = d1?.value || '';
                                                                    const d2Val = d2?.value || '';
                                                                    const d3Val = d3?.value || '';
                                                                    
                                                                    // Simpan jika ada data terisi
                                                                    if (forceAll || hasil || d1Val || d2Val || d3Val) {
                                                                        const rowData = {
                                                                            id: row.getAttribute('data-id'),
                                                                            parameter: row.getAttribute('data-parameter'),
                                                                            hasil: hasil,
                                                                            duplo_d1: d1Val,
                                                                            duplo_d2: d2Val,
                                                                            duplo_d3: d3Val
                                                                        };
                                                                        data.push(rowData);
                                                                    }
                                                                });
                                                                
                                                                if (data.length > 0) {
                                                                    sessionStorage.setItem(`temp_lab_${noLab}`, JSON.stringify(data));
                                                                    // console.log(`Saved ${data.length} rows for ${noLab}`);
                                                                }
                                                            };
                                                            
                                                            
                                                            window.loadTempData = function(noLab) {
                                                                if (!noLab) {
                                                                    return;
                                                                }
                                                                
                                                                const saved = sessionStorage.getItem(`temp_lab_${noLab}`);
                                                                if (!saved) {
                                                                    return;
                                                                }
                                                                
                                                                try {
                                                                    const data = JSON.parse(saved);
                                                                    
                                                                    setTimeout(() => {
                                                                        let loadedCount = 0;
                                                                        
                                                                        // Buat map dari row yang ada saat ini
                                                                        const currentRows = new Map();
                                                                        document.querySelectorAll('[data-id][data-parameter]').forEach(row => {
                                                                            const key = `${row.getAttribute('data-id')}-${row.getAttribute('data-parameter')}`;
                                                                            currentRows.set(key, row);
                                                                        });
                                                                        
                                                                        // Load data ke setiap row
                                                                        data.forEach((savedRow) => {
                                                                            const key = `${savedRow.id}-${savedRow.parameter}`;
                                                                            const row = currentRows.get(key);
                                                                            
                                                                            if (!row) {
                                                                                return;
                                                                            }
                                                                            
                                                                            // Cari semua kemungkinan input hasil
                                                                            const hasilInput = row.querySelector('.hasil-input');
                                                                            const hasilSelect = row.querySelector('.hasil-select');
                                                                            const manualInput = row.querySelector('.manualInput');
                                                                            
                                                                            // Load hasil ke input yang visible
                                                                            if (hasilInput && hasilInput.style.display !== 'none' && savedRow.hasil !== '') {
                                                                                hasilInput.value = savedRow.hasil;
                                                                                loadedCount++;
                                                                                hasilInput.dispatchEvent(new Event('input', { bubbles: true }));
                                                                            }
                                                                            if (hasilSelect && hasilSelect.style.display !== 'none' && savedRow.hasil !== '') {
                                                                                hasilSelect.value = savedRow.hasil;
                                                                                loadedCount++;
                                                                                hasilSelect.dispatchEvent(new Event('change', { bubbles: true }));
                                                                            }
                                                                            if (manualInput && manualInput.style.display !== 'none' && savedRow.hasil !== '') {
                                                                                manualInput.value = savedRow.hasil;
                                                                                loadedCount++;
                                                                                
                                                                                // Trigger event yang sesuai dengan tipe input
                                                                                if (manualInput.tagName === 'SELECT') {
                                                                                    manualInput.dispatchEvent(new Event('change', { bubbles: true }));
                                                                                } else {
                                                                                    manualInput.dispatchEvent(new Event('input', { bubbles: true }));
                                                                                }
                                                                            }
                                                                            
                                                                            // Load duplo values
                                                                            const d1 = row.querySelector('.d1');
                                                                            const d2 = row.querySelector('.d2');
                                                                            const d3 = row.querySelector('.d3');
                                                                            
                                                                            if (d1 && savedRow.duplo_d1 !== '') {
                                                                                d1.value = savedRow.duplo_d1;
                                                                                if (d1.tagName === 'SELECT') {
                                                                                    d1.dispatchEvent(new Event('change', { bubbles: true }));
                                                                                }
                                                                            }
                                                                            if (d2 && savedRow.duplo_d2 !== '') {
                                                                                d2.value = savedRow.duplo_d2;
                                                                                if (d2.tagName === 'SELECT') {
                                                                                    d2.dispatchEvent(new Event('change', { bubbles: true }));
                                                                                }
                                                                            }
                                                                            if (d3 && savedRow.duplo_d3 !== '') {
                                                                                d3.value = savedRow.duplo_d3;
                                                                                if (d3.tagName === 'SELECT') {
                                                                                    d3.dispatchEvent(new Event('change', { bubbles: true }));
                                                                                }
                                                                            }
                                                                        });
                                                                        
                                                                        if (loadedCount > 0) {
                                                                            // console.log(`Loaded ${loadedCount} values for ${noLab}`);
                                                                        }
                                                                    }, 300);
                                                                } catch (error) {
                                                                    console.error('Error loading temp data:', error);
                                                                }
                                                            };
                                                            
                                                            if (!window.autoSaveSetupDone) {
                                                                let autoSaveTimer;
                                                                
                                                                $(document).on('input change', '.hasil-input, .hasil-select, .manualInput, .d1, .d2, .d3', function(e) {
                                                                    if (!window.currentActiveLab) {
                                                                        return;
                                                                    }
                                                                    
                                                                    clearTimeout(autoSaveTimer);
                                                                    autoSaveTimer = setTimeout(() => {
                                                                        window.saveTempData(window.currentActiveLab);
                                                                    }, 600);
                                                                });
                                                                
                                                                window.autoSaveSetupDone = true;
                                                                // console.log('Auto-save setup complete for input and select fields');
                                                            }
                                                            
                                                            window.clearTempData = function(noLab) {
                                                                if (!noLab) return;
                                                                sessionStorage.removeItem(`temp_lab_${noLab}`);
                                                            };
                                                            
                                                            window.clearAllTempData = function() {
                                                                const keys = Object.keys(sessionStorage);
                                                                let count = 0;
                                                                keys.forEach(key => {
                                                                    if (key.startsWith('temp_lab_')) {
                                                                        sessionStorage.removeItem(key);
                                                                        count++;
                                                                    }
                                                                });
                                                            };
                                                            
                                                            window.viewAllTempData = function() {
                                                                const keys = Object.keys(sessionStorage);
                                                                const tempData = {};
                                                                keys.forEach(key => {
                                                                    if (key.startsWith('temp_lab_')) {
                                                                        const noLab = key.replace('temp_lab_', '');
                                                                        const data = JSON.parse(sessionStorage.getItem(key));
                                                                        const filledParams = data.filter(d => d.hasil || d.duplo_d1 || d.duplo_d2 || d.duplo_d3);
                                                                        tempData[noLab] = `${filledParams.length}/${data.length} terisi`;
                                                                    }
                                                                });
                                                                return tempData;
                                                            };
                                                            
                                                            
                                                            let html = '';
                                                            let lastJudul = null;
                                                            
                                                            // Tampilkan setiap parameter dengan header judulnya masing-masing
                                                            e.pasiens.forEach((p, pIdx) => {
                                                                const judul = p.data_pemeriksaan?.judul;
                                                                
                                                                // Tampilkan header judul untuk setiap parameter (jika ada judul)
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
                                                                
                                                                // Tampilkan parameter dengan indentasi jika ada judul
                                                                const obxValues = getObxValues(p.data_pemeriksaan.nama_parameter);
                                                                const rowId = p.data_pemeriksaan.id;
                                                                
                                                                const initialFlag = getInitialFlagContent(
                                                                    obxValues.hasilUtama, 
                                                                    p.data_pemeriksaan.nama_parameter, 
                                                                    false,
                                                                    false, 
                                                                    p.data_pemeriksaan.nilai_rujukan,
                                                                    data_pasien.jenis_kelamin
                                                                );
                                                                const uniqueID = generateParameterUID(p.data_pemeriksaan.nama_pemeriksaan, p.data_pemeriksaan.nama_parameter, pIdx);
                                                                
                                                                const nilaiRujukanDisplay = getNilaiRujukanDisplay(
                                                                    p.data_pemeriksaan.nilai_rujukan,
                                                                    data_pasien.jenis_kelamin
                                                                );
                                                                
                                                                // Tentukan apakah ada header judul
                                                                const hasHeader = judul && judul !== p.data_pemeriksaan.nama_pemeriksaan;
                                                                
                                                                html += `
                                                                    <tr data-id="${rowId}" data-parameter="${p.data_pemeriksaan.nama_parameter}" data-uid="${uniqueID}">
                                                                        <td class="col-2 ${hasHeader ? 'ps-4' : ''}" ${hasHeader ? 'style="border-left: 2px solid #e9ecef;"' : ''}>
                                                                            <strong>${hasHeader ? p.data_pemeriksaan.nama_parameter : p.data_pemeriksaan.nama_pemeriksaan}</strong>
                                                                            ${nilaiRujukanDisplay ? `<br><small class="text-muted">${nilaiRujukanDisplay}</small>` : ''}
                                                                            <input type="hidden" name="uid[${uniqueID}]" value="${uniqueID}" />
                                                                            <input type="hidden" name="nama_pemeriksaan[${uniqueID}]" 
                                                                                value="${p.data_pemeriksaan.nama_pemeriksaan}" />
                                                                            <input type="hidden" name="judul[${uniqueID}]" value="${judul || ''}" />
                                                                            <input type="hidden" name="parameter_name[${uniqueID}]" 
                                                                                value="${p.data_pemeriksaan.nama_parameter}" />
                                                                            <input type="hidden" name="nilai_rujukan[${uniqueID}]" value="${p.data_pemeriksaan.nilai_rujukan || ''}" />
                                                                            <input type="hidden" name="department[${uniqueID}]" value="${e.data_departement.nama_department}" />
                                                                            <input type="hidden" name="metode[${uniqueID}]" value="${p.data_pemeriksaan.metode ?? ''}" />
                                                                        </td>
                                                                        <td class="col-2">
                                                                            <!-- Input Text -->
                                                                            <input 
                                                                                type="text" 
                                                                                name="hasil[${uniqueID}]" 
                                                                                class="form-control manualInput w-60 p-0 hasil-input text-center" 
                                                                                value="${obxValues.hasilUtama || ''}" 
                                                                                disabled  required
                                                                                style="display: ${p.data_pemeriksaan.tipe_inputan === 'Text' ? 'block' : 'none'}" 
                                                                            />
                                                                            <!-- Select Dropdown -->
                                                                            <select 
                                                                                name="hasil[${uniqueID}]" 
                                                                                class="form-select manualInput w-60 p-0 hasil-select" 
                                                                                disabled required
                                                                                style="display: ${p.data_pemeriksaan.tipe_inputan === 'Dropdown' ? 'block' : 'none'}"
                                                                            >
                                                                            <option value="" selected hidden>Pilih...</option>
                                                                                ${p.data_pemeriksaan.tipe_inputan === 'Dropdown' && p.data_pemeriksaan.opsi_output ? 
                                                                                    p.data_pemeriksaan.opsi_output.split(';').map(opt => `
                                                                                        <option value="${opt.trim()}" ${obxValues.hasilUtama === opt.trim() ? 'selected' : ''}>
                                                                                            ${opt.trim()}
                                                                                        </option>
                                                                                    `).join('') 
                                                                                    : '<option value="">Pilih...</option>'
                                                                                }
                                                                            </select>
                                                                        </td>
                                                                        <td class="col-1">
                                                                            <button type="button" class="btn btn-outline-secondary btn-sm switch-btn" 
                                                                                    data-index="${pIdx}" data-switch-index="0">
                                                                                <i class="ti ti-switch-2"></i>
                                                                            </button>
                                                                        </td>
                                                                        <td class="col-2 duplo d1-column text-center" style="display: none;">
                                                                            ${
                                                                                p.data_pemeriksaan.tipe_inputan === 'Dropdown' && p.data_pemeriksaan.opsi_output ?
                                                                                `
                                                                                <select name="duplo_d1[${uniqueID}]" class="form-select d1 w-60 p-0" disabled>
                                                                                    <option value="" selected hidden>Pilih...</option>
                                                                                    ${p.data_pemeriksaan.opsi_output.split(';').map(opt => `
                                                                                        <option value="${opt.trim()}" ${obxValues.duplo_d1 === opt.trim() ? 'selected' : ''}>
                                                                                            ${opt.trim()}
                                                                                        </option>
                                                                                    `).join('')}
                                                                                </select>
                                                                                `
                                                                                :
                                                                                `
                                                                                <input type="number" name="duplo_d1[${uniqueID}]" 
                                                                                    class="form-control d1 w-60 p-0 text-center" 
                                                                                    disabled value="${obxValues.duplo_d1 || ''}" />
                                                                                `
                                                                            }
                                                                        </td>
                                                                        <td class="col-2 duplo d2-column" style="display: none;">
                                                                            ${
                                                                                p.data_pemeriksaan.tipe_inputan === 'Dropdown' && p.data_pemeriksaan.opsi_output ?
                                                                                `
                                                                                <select name="duplo_d2[${uniqueID}]" class="form-select d2 w-60 p-0" disabled>
                                                                                    <option value="" selected hidden>Pilih...</option>
                                                                                    ${p.data_pemeriksaan.opsi_output.split(';').map(opt => `
                                                                                        <option value="${opt.trim()}" ${obxValues.duplo_d2 === opt.trim() ? 'selected' : ''}>
                                                                                            ${opt.trim()}
                                                                                        </option>
                                                                                    `).join('')}
                                                                                </select>
                                                                                `
                                                                                :
                                                                                `
                                                                                <input type="number" name="duplo_d2[${uniqueID}]" 
                                                                                    class="form-control d2 w-60 p-0 text-center" 
                                                                                    disabled value="${obxValues.duplo_d2 || ''}" />
                                                                                `
                                                                            }
                                                                        </td>
                                                                        <td class="col-2 duplo d3-column" style="display: none;">
                                                                            ${
                                                                                p.data_pemeriksaan.tipe_inputan === 'Dropdown' && p.data_pemeriksaan.opsi_output ?
                                                                                `
                                                                                <select name="duplo_d3[${uniqueID}]" class="form-select d3 w-50 p-0" disabled>
                                                                                    <option value="" selected hidden>Pilih...</option>
                                                                                    ${p.data_pemeriksaan.opsi_output.split(';').map(opt => `
                                                                                        <option value="${opt.trim()}" ${obxValues.duplo_d3 === opt.trim() ? 'selected' : ''}>
                                                                                            ${opt.trim()}
                                                                                        </option>
                                                                                    `).join('')}
                                                                                </select>
                                                                                `
                                                                                :
                                                                                `
                                                                                <input type="number" name="duplo_d3[${uniqueID}]" 
                                                                                    class="form-control d3 w-50 p-0 text-center" 
                                                                                    disabled value="${obxValues.duplo_d3 || ''}" />
                                                                                `
                                                                            }
                                                                        </td>
                                                                        <td class="col-3 flag-cell">
                                                                            ${initialFlag}
                                                                            <input type="hidden" name="flag[${uniqueID}]" value="${initialFlag.replace(/<[^>]*>?/gm, '')}" />
                                                                        </td>
                                                                        <td>
                                                                            <input type="hidden" name="satuan[${uniqueID}]" class="form-control w-100 p-0" 
                                                                                value="${p.data_pemeriksaan.nilai_satuan || ''}" readonly />
                                                                            ${p.data_pemeriksaan.nilai_satuan || ''}
                                                                        </td>
                                                                    </tr>
                                                                `;
                                                            });
                                                            
                                                            // Setup auto-save dan load data setelah HTML di-render
                                                            setTimeout(() => {
                                                                const currentNoLab = data_pasien.no_lab;
                                                                
                                                                
                                                                // PENTING: Simpan data pasien sebelumnya jika ada DAN berbeda
                                                                if (window.currentActiveLab && window.currentActiveLab !== currentNoLab) {
                                                                    window.saveTempData(window.currentActiveLab);
                                                                }
                                                                
                                                                // Update current active lab KE PASIEN BARU
                                                                window.currentActiveLab = currentNoLab;
                                                                
                                                                // Load temp data untuk pasien saat ini jika ada
                                                                window.loadTempData(currentNoLab);
                                                                
                                                            }, 250);
                                                            
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
                                            placeholder="Masukkan catatan pemeriksaan..."></textarea>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-12 mb-3 mt-2">
                                    <button type="button" id="verifikasiHasilBtn" 
                                            class="btn btn-outline-info btn-block w-100">Verifikasi Hasil</button>
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <button type="button" id="verifikasiDokterBtn" 
                                            class="btn btn-outline-primary w-100">Verifikasi Dokter PK</button>
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
                            .text-primary {
                                color: #007bff !important;
                            }
                            .text-danger {
                                color: #dc3545 !important;
                            }
                            .hematologi-row small.text-muted,
                            .widal-row small.text-muted,
                            .urine-row small.text-muted {
                                font-size: 0.75rem;
                                margin-top: 2px;
                            }
                        </style>
                        `;

                        setTimeout(() => {
                            // Referensi elemen-elemen yang diperlukan
                            const verifikasiHasilBtn = document.getElementById('verifikasiHasilBtn');
                            const verifikasiDokterBtn = document.getElementById('verifikasiDokterBtn');
                            const manualButton = document.getElementById('manualButton');
                            const duploButton = document.getElementById('duploButton');
                            let currentDuploStage = 0;
                            const masterSwitchBtn = document.getElementById('masterSwitchBtn');
                            let masterSwitchState = 0;

                            if (masterSwitchBtn) {
                                masterSwitchBtn.addEventListener('click', () => {
                                    switchAllParameters();
                                });
                            }

                            // Update fungsi updateFlag untuk mendukung hematologi, urine dan jenis kelamin
                            function updateFlag(value, flagCell, parameter = null) {
                                const numValue = parseFloat(value);
                                const row = flagCell.closest('tr');
                                const isHematologi = row && row.classList.contains('hematologi-row');
                                const isWidal = row && row.classList.contains('widal-row');
                                const isUrine = row && row.classList.contains('urine-row');
                                const uid = row?.getAttribute('data-uid'); // TAMBAHKAN INI

                                let flagText = '';
                                let showStar = false;

                                if (isWidal) {
                                    flagCell.innerHTML = `<input type="hidden" name="flag[${uid}]" value="" />`;
                                    return;
                                }

                                if (!isNaN(numValue) && value !== '') {
                                    if (isHematologi && parameter) {
                                        const paramData = hematologiParams.find(p => p.nama === parameter);
                                        if (paramData) {
                                            const normalValues = getNormalValues(paramData, data_pasien.jenis_kelamin);

                                            if (numValue < normalValues.min) {
                                                flagText = 'Low';
                                            } else if (numValue > normalValues.max) {
                                                flagText = 'High';
                                            } else {
                                                flagText = 'Normal';
                                            }
                                            
                                            showStar = checkStarThresholdHematologi(numValue, parameter, data_pasien.jenis_kelamin);
                                        }
                                    } else if (isUrine && parameter) {
                                        const paramData = UrineParams.find(p => p.nama === parameter);
                                        if (paramData && paramData.normal_min_l !== '-' && paramData.normal_max_l !== '-') {
                                            const normalValues = getNormalValues(paramData, data_pasien.jenis_kelamin);

                                            if (numValue < normalValues.min) {
                                                flagText = 'Low';
                                            } else if (numValue > normalValues.max) {
                                                flagText = 'High';
                                            } else {
                                                flagText = 'Normal';
                                            }
                                            
                                            showStar = checkStarThresholdUrine(numValue, parameter, data_pasien.jenis_kelamin);
                                        }
                                    } else {
                                        // Umum (non-hematologi/urine)
                                        const nilaiRujukanInput = row.querySelector('input[name^="nilai_rujukan"]');
                                        const nilaiRujukan = nilaiRujukanInput ? nilaiRujukanInput.value : null;

                                        if (nilaiRujukan && data_pasien.jenis_kelamin) {
                                            let normalRange = null;
                                            let genderCode = '';

                                            if (data_pasien.jenis_kelamin.toLowerCase().includes('laki') || data_pasien.jenis_kelamin === 'L') {
                                                genderCode = 'L';
                                            } else if (data_pasien.jenis_kelamin.toLowerCase().includes('perempuan') || data_pasien.jenis_kelamin === 'P') {
                                                genderCode = 'P';
                                            }

                                            if (genderCode) {
                                                const cleanNilaiRujukan = nilaiRujukan.replace(/\([^)]*\)/, '').trim();
                                                const parts = cleanNilaiRujukan.split(' ');
                                                let targetRange = null;

                                                for (const part of parts) {
                                                    if (genderCode === 'L' && part.startsWith('L.')) {
                                                        targetRange = part.substring(2);
                                                        break;
                                                    } else if (genderCode === 'P' && part.startsWith('P.')) {
                                                        targetRange = part.substring(2);
                                                        break;
                                                    }
                                                }

                                                if (targetRange) {
                                                    if (targetRange.startsWith('<')) {
                                                        const maxValue = parseFloat(targetRange.substring(1).replace(',', '.'));
                                                        if (!isNaN(maxValue)) {
                                                            normalRange = { min: 0, max: maxValue };
                                                        }
                                                    } else if (targetRange.startsWith('>')) {
                                                        const minValue = parseFloat(targetRange.substring(1).replace(',', '.'));
                                                        if (!isNaN(minValue)) {
                                                            normalRange = { min: minValue, max: Infinity };
                                                        }
                                                    } else {
                                                        const rangeParts = targetRange.split('-');
                                                        if (rangeParts.length === 2) {
                                                            const min = parseFloat(rangeParts[0].replace(',', '.'));
                                                            const max = parseFloat(rangeParts[1].replace(',', '.'));
                                                            if (!isNaN(min) && !isNaN(max)) {
                                                                normalRange = { min, max };
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                            if (normalRange) {
                                                if (numValue < normalRange.min) {
                                                    flagText = 'Low';
                                                } else if (numValue > normalRange.max) {
                                                    flagText = 'High';
                                                } else {
                                                    flagText = 'Normal';
                                                }
                                                
                                                showStar = checkStarThreshold(numValue, nilaiRujukan, genderCode);
                                            }
                                        }
                                    }
                                }

                                // Render ulang dengan UID yang benar
                                if (flagText) {
                                    let icon = '';
                                    if (flagText === 'Low') {
                                        icon = '<i class="ti ti-arrow-down text-primary"></i>';
                                    } else if (flagText === 'High') {
                                        icon = '<i class="ti ti-arrow-up text-danger"></i>';
                                    } else if (flagText === 'Normal') {
                                        icon = '<i class="ti ti-check text-success"></i>';
                                    }

                                    const starSymbol = showStar ? '*' : '';
                                    const flagWithStar = `${flagText}${starSymbol}`;
                                    
                                    flagCell.innerHTML = `
                                        ${icon} ${flagWithStar}
                                        <input type="hidden" name="flag[${uid}]" class="flag-value" value="${flagWithStar}">
                                    `;
                                    
                                    // console.log(`Flag set to: ${flagWithStar} for UID: ${uid}, parameter: ${parameter}`);
                                } else {
                                    flagCell.innerHTML = `
                                        <input type="hidden" name="flag[${uid}]" class="flag-value" value="">
                                    `;
                                }
                            }

                            function setupFlagEventListeners() {
                                // Hapus event listener lama
                                const allInputs = document.querySelectorAll('.hasil-input, .hasil-select, .manualInput, .d1, .d2, .d3');
                                allInputs.forEach(input => {
                                    input.removeEventListener('input', inputHandler);
                                    input.removeEventListener('change', inputHandler);
                                });

                                // Tambahkan event listener untuk SEMUA input hasil yang visible
                                const hasilInputs = document.querySelectorAll('.hasil-input, .hasil-select, .manualInput');
                                hasilInputs.forEach(input => {
                                    // Cek apakah input visible
                                    if (input.style.display !== 'none') {
                                        if (input.tagName === 'SELECT') {
                                            input.addEventListener('change', inputHandler);
                                        } else {
                                            input.addEventListener('input', inputHandler);
                                        }
                                    }
                                });
                                
                            }


                            function inputHandler() {
                                const row = this.closest('tr');
                                const flagCell = row.querySelector('.flag-cell');
                                const parameter = row.dataset.parameter;

                                // Pastikan ini adalah input HASIL yang visible
                                if (this.classList.contains('manualInput') || 
                                    this.classList.contains('hasil-input') || 
                                    this.classList.contains('hasil-select')) {
                                    
                                    // Hanya update flag jika input ini visible
                                    if (this.style.display !== 'none') {
                                        updateFlag(this.value, flagCell, parameter);
                                        // console.log(`Flag updated for ${parameter}: ${this.value}`);
                                    }
                                }
                            }

                            function hideAllDuploColumns() {
                                document.querySelectorAll('.d1-column, .d2-column, .d3-column').forEach(col => {
                                    col.style.display = 'none';
                                });
                                document.querySelectorAll('.d1, .d2, .d3').forEach(input => {
                                    input.disabled = true;
                                });
                            }

                            hideAllDuploColumns();

                            function logDuploValues() {
                                const d1Values = Array.from(document.querySelectorAll('.d1')).map(input => input.value).filter(Boolean);
                                const d2Values = Array.from(document.querySelectorAll('.d2')).map(input => input.value).filter(Boolean);
                                const d3Values = Array.from(document.querySelectorAll('.d3')).map(input => input.value).filter(Boolean);
                                // console.log('D1 Values:', d1Values);
                                // console.log('D2 Values:', d2Values);
                                // console.log('D3 Values:', d3Values);
                            }

                            if (duploButton) {
                                duploButton.addEventListener('click', () => {
                                    const d1Columns = document.querySelectorAll('.d1-column');
                                    const d2Columns = document.querySelectorAll('.d2-column');
                                    const d3Columns = document.querySelectorAll('.d3-column');
                                    const d1Inputs = document.querySelectorAll('.d1');
                                    const d2Inputs = document.querySelectorAll('.d2');
                                    const d3Inputs = document.querySelectorAll('.d3');

                                    switch (currentDuploStage) {
                                        case 0:
                                            // console.log("Menampilkan kolom D1");
                                            d1Columns.forEach(col => col.style.display = 'table-cell');
                                            d1Inputs.forEach(input => {
                                                input.disabled = false;
                                            });
                                            currentDuploStage = 1;
                                            break;
                                        case 1:
                                            // console.log("Menampilkan kolom D2");
                                            d2Columns.forEach(col => col.style.display = 'table-cell');
                                            d2Inputs.forEach(input => {
                                                input.disabled = false;
                                            });
                                            currentDuploStage = 2;
                                            break;
                                        case 2:
                                            // console.log("Menampilkan kolom D3");
                                            d3Columns.forEach(col => col.style.display = 'table-cell');
                                            d3Inputs.forEach(input => {
                                                input.disabled = false;
                                            });
                                            currentDuploStage = 3;
                                            break;
                                        default:
                                            // console.log("Semua kolom duplo sudah aktif.");
                                            break;
                                    }
                                    setupFlagEventListeners();
                                    // console.log("Current duplo stage SESUDAH:", currentDuploStage);
                                    logDuploValues();

                                    if (verifikasiHasilBtn) verifikasiHasilBtn.disabled = false;
                                    if (verifikasiDokterBtn) verifikasiDokterBtn.disabled = false;
                                });
                            }

                            // Setup initial flag event listeners
                            setupFlagEventListeners();

                            function switchAllParameters() {
                                // Tentukan target kolom berdasarkan state saat ini
                                let sourceClass, targetClass;
                                
                                switch (masterSwitchState) {
                                    case 0: // dari hasil ke d1
                                        if (currentDuploStage >= 1) {
                                            sourceClass = 'manualInput';
                                            targetClass = 'd1';
                                            masterSwitchState = 1;
                                        } else {
                                            // console.log('D1 belum aktif');
                                            return;
                                        }
                                        break;
                                        
                                    case 1: // dari d1 - cek apakah bisa ke d2 atau kembali ke hasil
                                        if (currentDuploStage >= 2) {
                                            // Jika D2 tersedia, lanjut ke D2
                                            sourceClass = 'manualInput';
                                            targetClass = 'd2';
                                            masterSwitchState = 2;
                                        } else {
                                            // Jika D2 tidak tersedia, kembali ke hasil
                                            sourceClass = 'd1';
                                            targetClass = 'manualInput';
                                            masterSwitchState = 0;
                                        }
                                        break;
                                        
                                    case 2: // dari d2 - cek apakah bisa ke d3 atau kembali ke hasil
                                        if (currentDuploStage >= 3) {
                                            // Jika D3 tersedia, lanjut ke D3
                                            sourceClass = 'manualInput';
                                            targetClass = 'd3';
                                            masterSwitchState = 3;
                                        } else {
                                            // Jika D3 tidak tersedia, kembali ke hasil
                                            sourceClass = 'd2';
                                            targetClass = 'manualInput';
                                            masterSwitchState = 0;
                                        }
                                        break;
                                        
                                    case 3: // dari d3 kembali ke hasil
                                        sourceClass = 'd3';
                                        targetClass = 'manualInput';
                                        masterSwitchState = 0;
                                        break;
                                }

                                // Lakukan switching untuk semua parameter
                                performMasterSwitch(sourceClass, targetClass);
                                
                                // Update visual indicator
                                updateMasterSwitchIndicator();
                            }

                            function performMasterSwitch(sourceClass, targetClass) {
                                const allRows = document.querySelectorAll('tr[data-parameter]');
                                
                                allRows.forEach(row => {
                                    const sourceInput = row.querySelector(`.${sourceClass}`);
                                    const targetInput = row.querySelector(`.${targetClass}`);
                                    
                                    if (sourceInput && targetInput) {
                                        // Simpan nilai sumber
                                        const sourceValue = sourceInput.value;
                                        
                                        // Tukar nilai
                                        sourceInput.value = targetInput.value;
                                        targetInput.value = sourceValue;
                                        
                                        // Update flag untuk input yang aktif (yang ditampilkan di kolom HASIL)
                                        const flagCell = row.querySelector('.flag-cell');
                                        const parameter = row.dataset.parameter;
                                        
                                        // Tentukan input mana yang sekarang aktif di kolom HASIL
                                        const currentActiveInput = row.querySelector('.manualInput');
                                        if (currentActiveInput && flagCell) {
                                            updateFlag(currentActiveInput.value, flagCell, parameter);
                                        }
                                    }
                                });
                                
                                // console.log(`Switched all parameters from ${sourceClass} to ${targetClass}`);
                            }

                            function updateMasterSwitchIndicator() {
                                const icon = masterSwitchBtn.querySelector('i');
                                const button = masterSwitchBtn;
                                
                                // Update icon dan tooltip berdasarkan state
                                switch (masterSwitchState) {
                                    case 0:
                                        icon.className = 'ti ti-switch-horizontal';
                                        if (currentDuploStage >= 1) {
                                            button.title = 'Currently showing: HASIL - Click to switch to D1';
                                        } else {
                                            button.title = 'No duplo stages available';
                                        }
                                        button.classList.remove('btn-outline-success', 'btn-outline-warning', 'btn-outline-danger');
                                        button.classList.add('btn-outline-primary');
                                        break;
                                    case 1:
                                        icon.className = 'ti ti-switch-horizontal text-success';
                                        if (currentDuploStage >= 2) {
                                            button.title = 'Currently showing: D1 - Click to switch to D2';
                                        } else {
                                            button.title = 'Currently showing: D1 - Click to switch back to HASIL';
                                        }
                                        button.classList.remove('btn-outline-primary', 'btn-outline-warning', 'btn-outline-danger');
                                        button.classList.add('btn-outline-success');
                                        break;
                                    case 2:
                                        icon.className = 'ti ti-switch-horizontal text-warning';
                                        if (currentDuploStage >= 3) {
                                            button.title = 'Currently showing: D2 - Click to switch to D3';
                                        } else {
                                            button.title = 'Currently showing: D2 - Click to switch back to HASIL';
                                        }
                                        button.classList.remove('btn-outline-primary', 'btn-outline-success', 'btn-outline-danger');
                                        button.classList.add('btn-outline-warning');
                                        break;
                                    case 3:
                                        icon.className = 'ti ti-switch-horizontal text-danger';
                                        button.title = 'Currently showing: D3 - Click to switch back to HASIL';
                                        button.classList.remove('btn-outline-primary', 'btn-outline-success', 'btn-outline-warning');
                                        button.classList.add('btn-outline-danger');
                                        break;
                                }
                            }

                            // Alternative: Jika Anda ingin sistem yang lebih sederhana (hanya toggle antara HASIL dan duplo stage tertinggi)
                            function switchAllParametersSimple() {
                                let sourceClass, targetClass;
                                
                                if (masterSwitchState === 0) {
                                    // Dari HASIL ke duplo stage tertinggi yang tersedia
                                    if (currentDuploStage >= 3) {
                                        sourceClass = 'manualInput';
                                        targetClass = 'd3';
                                        masterSwitchState = 3;
                                    } else if (currentDuploStage >= 2) {
                                        sourceClass = 'manualInput';
                                        targetClass = 'd2';
                                        masterSwitchState = 2;
                                    } else if (currentDuploStage >= 1) {
                                        sourceClass = 'manualInput';
                                        targetClass = 'd1';
                                        masterSwitchState = 1;
                                    } else {
                                        // console.log('Belum ada duplo stage yang aktif');
                                        return;
                                    }
                                } else {
                                    // Dari duplo stage manapun kembali ke HASIL
                                    switch (masterSwitchState) {
                                        case 1:
                                            sourceClass = 'd1';
                                            break;
                                        case 2:
                                            sourceClass = 'd2';
                                            break;
                                        case 3:
                                            sourceClass = 'd3';
                                            break;
                                    }
                                    targetClass = 'manualInput';
                                    masterSwitchState = 0;
                                }
                                
                                // Lakukan switching untuk semua parameter
                                performMasterSwitch(sourceClass, targetClass);
                                
                                // Update visual indicator
                                updateMasterSwitchIndicator();
                            }

                            // Initialize master switch indicator
                            updateMasterSwitchIndicator();

                            // Modifikasi fungsi existing untuk reset master switch ketika duplo direset
                            function resetMasterSwitch() {
                                masterSwitchState = 0;
                                updateMasterSwitchIndicator();
                            }

                            function validateAllInputs() {
                                let isValid = true;
                                let emptyFields = [];
                                let emptyCount = 0;

                                // Cek semua row pemeriksaan
                                document.querySelectorAll('tr[data-parameter]').forEach(row => {
                                    const parameter = row.getAttribute('data-parameter');
                                    const uid = row.getAttribute('data-uid');
                                    
                                    // Ambil input yang visible (aktif)
                                    const hasilInput = row.querySelector('.hasil-input');
                                    const hasilSelect = row.querySelector('.hasil-select');
                                    const manualInput = row.querySelector('.manualInput');
                                    
                                    let activeInput = null;
                                    let isEmpty = false;
                                    
                                    // Tentukan input mana yang aktif
                                    if (hasilInput && hasilInput.style.display !== 'none') {
                                        activeInput = hasilInput;
                                        isEmpty = !hasilInput.value || hasilInput.value.trim() === '';
                                    } else if (hasilSelect && hasilSelect.style.display !== 'none') {
                                        activeInput = hasilSelect;
                                        isEmpty = !hasilSelect.value || hasilSelect.value === '';
                                    } else if (manualInput && manualInput.style.display !== 'none') {
                                        activeInput = manualInput;
                                        if (manualInput.tagName === 'SELECT') {
                                            isEmpty = !manualInput.value || manualInput.value === '';
                                        } else {
                                            isEmpty = !manualInput.value || manualInput.value.trim() === '';
                                        }
                                    }
                                    
                                    // Jika ada input yang kosong
                                    if (isEmpty && activeInput) {
                                        isValid = false;
                                        emptyCount++;
                                        
                                        // Highlight field yang kosong
                                        activeInput.classList.add('is-invalid');
                                        activeInput.style.borderColor = '#dc3545';
                                        activeInput.style.borderWidth = '2px';
                                        
                                        // Simpan info parameter yang kosong
                                        const parameterName = row.querySelector('td strong')?.textContent || parameter;
                                        emptyFields.push(parameterName);
                                        
                                        // Scroll ke field pertama yang kosong
                                        if (emptyCount === 1) {
                                            activeInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                        }
                                    } else if (activeInput) {
                                        // Remove highlight jika sudah terisi
                                        activeInput.classList.remove('is-invalid');
                                        activeInput.style.borderColor = '';
                                        activeInput.style.borderWidth = '';
                                    }
                                });
                                
                                return { isValid, emptyFields, emptyCount };
                            }

                            // Fungsi untuk remove highlight saat user mulai mengisi
                            function setupInputValidation() {
                                document.querySelectorAll('.hasil-input, .hasil-select, .manualInput').forEach(input => {
                                    input.addEventListener('input', function() {
                                        if (this.value && this.value.trim() !== '') {
                                            this.classList.remove('is-invalid');
                                            this.style.borderColor = '';
                                            this.style.borderWidth = '';
                                        }
                                    });
                                    
                                    input.addEventListener('change', function() {
                                        if (this.value && this.value.trim() !== '') {
                                            this.classList.remove('is-invalid');
                                            this.style.borderColor = '';
                                            this.style.borderWidth = '';
                                        }
                                    });
                                });
                            }

                            // Panggil setup validation
                            setupInputValidation();

                            // Event listener untuk tombol verifikasi
                            if (verifikasiHasilBtn) {
                                verifikasiHasilBtn.addEventListener('click', (e) => {
                                    e.preventDefault();
                                    
                                    // Validasi semua input
                                    const validation = validateAllInputs();
                                    
                                    if (!validation.isValid) {
                                        // Tampilkan pesan error dengan daftar field yang kosong
                                        let errorMessage = `Terdapat ${validation.emptyCount} parameter yang belum diisi:\n\n`;
                                        
                                        // Batasi tampilan maksimal 10 field
                                        const displayFields = validation.emptyFields.slice(0, 10);
                                        errorMessage += displayFields.map((field, index) => `${index + 1}. ${field}`).join('\n');
                                        
                                        if (validation.emptyFields.length > 10) {
                                            errorMessage += `\n... dan ${validation.emptyFields.length - 10} parameter lainnya`;
                                        }
                                        
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Data Belum Lengkap!',
                                            text: errorMessage,
                                            confirmButtonText: 'OK, Saya Akan Melengkapi',
                                            confirmButtonColor: '#dc3545',
                                            customClass: {
                                                popup: 'swal-wide'
                                            }
                                        });
                                        
                                        return false;
                                    }
                                    
                                    // Jika validasi berhasil, tampilkan konfirmasi
                                    Swal.fire({
                                        title: 'Konfirmasi Verifikasi Hasil',
                                        text: `Apakah Anda yakin data ${validation.emptyCount === 0 ? 'semua' : ''} parameter sudah benar?`,
                                        icon: 'question',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#6c757d',
                                        confirmButtonText: 'Ya, Verifikasi!',
                                        cancelButtonText: 'Cek Kembali'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            document.getElementById('worklistForm').action = "{{ route('worklist.store') }}";
                                            document.getElementById('worklistForm').submit();
                                        }
                                    });
                                });
                            }

                            if (verifikasiDokterBtn) {
                                verifikasiDokterBtn.addEventListener('click', (e) => {
                                    e.preventDefault();
                                    
                                    // Validasi semua input
                                    const validation = validateAllInputs();
                                    
                                    if (!validation.isValid) {
                                        // Tampilkan pesan error
                                        let errorMessage = `Terdapat ${validation.emptyCount} parameter yang belum diisi:\n\n`;
                                        
                                        const displayFields = validation.emptyFields.slice(0, 10);
                                        errorMessage += displayFields.map((field, index) => `${index + 1}. ${field}`).join('\n');
                                        
                                        if (validation.emptyFields.length > 10) {
                                            errorMessage += `\n... dan ${validation.emptyFields.length - 10} parameter lainnya`;
                                        }
                                        
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Data Belum Lengkap!',
                                            text: errorMessage,
                                            confirmButtonText: 'OK, Saya Akan Melengkapi',
                                            confirmButtonColor: '#dc3545',
                                            customClass: {
                                                popup: 'swal-wide'
                                            }
                                        });
                                        
                                        return false;
                                    }
                                    
                                    // Jika validasi berhasil
                                    Swal.fire({
                                        title: 'Konfirmasi Verifikasi',
                                        html: `
                                            <p>Apakah Anda yakin ingin memverifikasi ke Dokter PK?</p>
                                            <p class="text-muted small">Semua ${validation.emptyCount === 0 ? Object.keys(validation).length : 'parameter'} telah terisi</p>
                                        `,
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Ya, verifikasi!',
                                        cancelButtonText: 'Batal'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            document.getElementById('worklistForm').action = `worklist/checkin/${data_pasien.id}`;
                                            document.getElementById('worklistForm').submit();
                                        }
                                    });
                                });
                            }

                            // Tombol manual input
                            if (manualButton) {
                                manualButton.addEventListener('click', () => {
                                    document.querySelectorAll('.manualInput').forEach(el => {
                                    if (el.style.display !== 'none') {
                                            el.disabled = false;
                                        }
                                    });

                                    // document.querySelectorAll('.d1, .d2, .d3').forEach(input => {
                                    //     input.disabled = true;
                                    // });

                                    if (verifikasiHasilBtn) verifikasiHasilBtn.disabled = false;
                                    if (verifikasiDokterBtn) verifikasiDokterBtn.disabled = false;
                                });
                            }

                            // Tombol switch - Updated untuk menangani select dan input
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
            let accordionContent = '';

            // ========== Inspection Details ==========
            accordionContent += `<h5 class="title mt-3">Inspection Details</h5><hr><div class="row">`;
            data_pemeriksaan_pasien.forEach(e => {
                accordionContent += `
                    <input type="hidden" name="no_lab" value="${e.no_lab}">
                    <div class="col-12 col-md-6" id="${e.id_departement}">
                        <h6>${e.data_departement.nama_department}</h6>
                        <ol>
                `;
                e.pasiens.forEach(p => {
                    accordionContent += `<li>${p.data_pemeriksaan.nama_pemeriksaan}</li>`;
                });
                accordionContent += `</ol><hr></div>`;
            });
            accordionContent += `</div>`;

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
            // Filter hanya yang memiliki data di scollection
            let collectionWithData = collectionSpecimens.filter(e => {
                return scollection.some(item => 
                    item.no_lab === e.laravel_through_key &&
                    item.tabung === e.tabung &&
                    item.kode === e.kode
                );
            });

            if (collectionWithData.length > 0) {
                accordionContent += `<h5 class="title mt-3">Spesiment Collection</h5><hr>`;
                accordionContent += `<div class="accordion" id="accordionCollection">`;
                collectionWithData.forEach(e => {
                    accordionContent += generateAccordionHTML(e, scollection, shandling, "collection");
                });
                accordionContent += `</div>`;
            }

            // ========== Spesimen Handlings ==========
            let handlingSpecimens = spesimen.filter(e => e.spesiment === "Spesiment Handlings");
            // Filter hanya yang memiliki data di shandling
            let handlingWithData = handlingSpecimens.filter(e => {
                return shandling.some(item => 
                    item.no_lab === e.laravel_through_key &&
                    item.tabung === e.tabung &&
                    item.kode === e.kode
                );
            });

            if (handlingWithData.length > 0) {
                accordionContent += `<h5 class="title mt-3">Spesiment Handlings</h5><hr>`;
                accordionContent += `<div class="accordion" id="accordionHandling">`;
                handlingWithData.forEach(e => {
                    accordionContent += generateAccordionHTML(e, scollection, shandling, "handling");
                });
                accordionContent += `</div>`;
            }

            // ========== Info jika hanya ada 1 data spesimen ==========
            const totalSpecimensWithData = collectionWithData.length + handlingWithData.length;
            if (totalSpecimensWithData === 1) {
                let specimenInfo = '';
                if (collectionWithData.length === 1) {
                    const spec = collectionWithData[0];
                    specimenInfo = `Spesiment Collection - Tabung ${spec.tabung} (${spec.kode})`;
                } else if (handlingWithData.length === 1) {
                    const spec = handlingWithData[0];
                    specimenInfo = `Spesiment Handlings - Tabung ${spec.tabung} (${spec.kode})`;
                }
                accordionContent += `
                    <div class="alert alert-info mt-3">
                        <i class="fas fa-info-circle"></i> Hanya terdapat 1 data spesimen: <strong>${specimenInfo}</strong>
                    </div>
                `;
            }

            // ========== Notes Doctor & Analyst ==========
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
            accordion.innerHTML = accordionContent;
        }


        // ===================================
        // versi generateAccordionHTML terbaru
        // ===================================
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
                            // FIX: Handle both CLOTH-ACTIVATOR and CLOT-ACTIVATOR
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
        });
    </script>
  <script>
document.addEventListener('DOMContentLoaded', function() {
    let imageCounter = 0;
    let uploadedImages = [];
    let currentNoLab = '';
    let currentZoomLevel = 1;
    let currentCarouselIndex = 0;
    
    // Variables untuk drag/pan
    let isDragging = false;
    let startX = 0;
    let startY = 0;
    let translateX = 0;
    let translateY = 0;
    let currentImg = null;

    const imagesModal = document.getElementById('imagesModal');
    const carouselModal = new bootstrap.Modal(document.getElementById('imageCarouselModal'));
    
    // Event saat modal dibuka
    imagesModal.addEventListener('shown.bs.modal', function() {
        const nolabInput = document.querySelector('input[name="no_lab"]');
        if (nolabInput) {
            currentNoLab = nolabInput.value;
            document.getElementById('currentNoLab').value = currentNoLab;
            loadExistingImages(currentNoLab);
        }
        
        if (imageCounter === 0) {
            addImageUploadForm();
        }
    });

    imagesModal.addEventListener('hidden.bs.modal', function() {
        resetModal();
    });

    // Load existing images
    function loadExistingImages(nolab) {
        fetch(`/api/get-images/${nolab}`)
            .then(response => response.json())
            .then(res => {
                if (res.status === 'success' && res.data.length > 0) {
                    uploadedImages = res.data.map(img => ({
                        id: img.id,
                        nolab: img.nolab,
                        preview: `/${img.image}`,
                        description: img.description || '',
                        isExisting: true
                    }));
                    updatePreviewContainer();
                    updateBadge(uploadedImages.length);
                    document.getElementById('uploadedImagesPreview').style.display = 'block';
                } else {
                    uploadedImages = [];
                    document.getElementById('uploadedImagesPreview').style.display = 'none';
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Add form upload
    function addImageUploadForm() {
        imageCounter++;
        const formId = `imageForm_${imageCounter}`;
        
        const formHTML = `
            <div class="card mb-3" id="${formId}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Image #${imageCounter}</h6>
                        <button type="button" class="btn btn-danger btn-sm remove-image-form" data-form-id="${formId}">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Pilih Image</label>
                        <input type="file" class="form-control image-input" accept="image/*">
                        <small class="text-muted d-block mt-1">
                            <i class="bi bi-info-circle"></i> Gambar akan dikompres otomatis (Max 2MB)
                        </small>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Keterangan (Optional)</label>
                        <input type="text" class="form-control image-description" placeholder="Masukkan keterangan">
                    </div>
                    <div class="preview-area" style="display: none;">
                        <img src="" class="img-thumbnail preview-img" style="max-height: 200px;">
                    </div>
                </div>
            </div>
        `;
        
        document.getElementById('imageUploadContainer').insertAdjacentHTML('beforeend', formHTML);
        
        const newInput = document.querySelector(`#${formId} .image-input`);
        newInput.addEventListener('change', function(e) {
            previewImage(e.target, formId);
        });
        
        const removeBtn = document.querySelector(`#${formId} .remove-image-form`);
        removeBtn.addEventListener('click', function() {
            removeImageForm(formId);
        });
    }

    function previewImage(input, formId) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const form = document.getElementById(formId);
            const previewArea = form.querySelector('.preview-area');
            const previewImg = form.querySelector('.preview-img');
            
            // Compress image before preview
            compressImage(file, 0.7, 1920, 1080).then(compressedFile => {
                // Replace original file with compressed file
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(compressedFile);
                input.files = dataTransfer.files;
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewArea.style.display = 'block';
                };
                reader.readAsDataURL(compressedFile);
            }).catch(error => {
                console.error('Error compressing image:', error);
                // Fallback to original if compression fails
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewArea.style.display = 'block';
                };
                reader.readAsDataURL(file);
            });
        }
    }
    
    // ============================================================
    //                  IMAGE COMPRESSION FUNCTION
    // ============================================================
    function compressImage(file, quality = 0.7, maxWidth = 1920, maxHeight = 1080) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const img = new Image();
                
                img.onload = function() {
                    const canvas = document.createElement('canvas');
                    let width = img.width;
                    let height = img.height;
                    
                    // Calculate new dimensions
                    if (width > maxWidth || height > maxHeight) {
                        const ratio = Math.min(maxWidth / width, maxHeight / height);
                        width = width * ratio;
                        height = height * ratio;
                    }
                    
                    canvas.width = width;
                    canvas.height = height;
                    
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);
                    
                    // Convert canvas to blob
                    canvas.toBlob((blob) => {
                        if (blob) {
                            // Create new File object
                            const compressedFile = new File([blob], file.name, {
                                type: 'image/jpeg',
                                lastModified: Date.now()
                            });
                            
                            resolve(compressedFile);
                        } else {
                            reject(new Error('Canvas to Blob conversion failed'));
                        }
                    }, 'image/jpeg', quality);
                };
                
                img.onerror = function() {
                    reject(new Error('Image load error'));
                };
                
                img.src = e.target.result;
            };
            
            reader.onerror = function() {
                reject(new Error('FileReader error'));
            };
            
            reader.readAsDataURL(file);
        });
    }

    function removeImageForm(formId) {
        document.getElementById(formId)?.remove();
    }

    document.getElementById('addMoreImageBtn').addEventListener('click', addImageUploadForm);

    // Upload images
    document.getElementById('saveImagesBtn').addEventListener('click', function() {
        const forms = document.querySelectorAll('#imageUploadContainer .card');
        const formData = new FormData();
        const nolab = document.getElementById('currentNoLab').value;
        
        if (!nolab) {
            Swal.fire('Error', 'No Lab tidak ditemukan!', 'error');
            return;
        }
        
        let validImages = 0;
        formData.append('nolab', nolab);

        forms.forEach((form, index) => {
            const fileInput = form.querySelector('.image-input');
            const description = form.querySelector('.image-description').value;
            
            if (fileInput.files && fileInput.files[0]) {
                formData.append(`images[${index}]`, fileInput.files[0]);
                formData.append(`descriptions[${index}]`, description);
                validImages++;
            }
        });

        if (validImages === 0) {
            Swal.fire('Warning', 'Pilih minimal 1 image!', 'warning');
            return;
        }

        Swal.fire({
            title: 'Uploading...',
            html: `Sedang mengupload ${validImages} image(s)`,
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });
        
        fetch('/analyst/worklist/upload-images', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                data.data.forEach(img => {
                    uploadedImages.push({
                        id: img.id,
                        nolab: img.nolab,
                        preview: `/${img.image}`,
                        description: img.description || '',
                        isExisting: true
                    });
                });
                
                updatePreviewContainer();
                updateBadge(uploadedImages.length);
                document.getElementById('uploadedImagesPreview').style.display = 'block';
                document.getElementById('imageUploadContainer').innerHTML = '';
                imageCounter = 0;
                
                Swal.fire('Success!', `${validImages} image(s) berhasil diupload`, 'success');
            } else {
                Swal.fire('Error', data.message || 'Upload gagal', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Terjadi kesalahan', 'error');
        });
    });

    // Update preview container dengan carousel trigger
    function updatePreviewContainer() {
        const container = document.getElementById('previewContainer');
        container.innerHTML = '';
        
        uploadedImages.forEach((img, index) => {
            const col = document.createElement('div');
            col.className = 'col-md-4 mb-3';
            col.innerHTML = `
                <div class="card preview-image-card" onclick="openCarousel(${index})">
                    <div class="image-number-badge">${index + 1}</div>
                    <img src="${img.preview}" class="card-img-top" style="height: 150px; object-fit: cover;">
                    <div class="image-overlay">
                        <i class="bi bi-eye-fill"></i>
                    </div>
                    <div class="card-body p-2">
                        <small class="text-muted d-block">${img.description || 'No description'}</small>
                        <button class="btn btn-danger btn-sm w-100 mt-1" onclick="event.stopPropagation(); confirmDeleteImage(${index}, ${img.id})">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(col);
        });
    }

    // Open carousel modal
    window.openCarousel = function(startIndex) {
        currentCarouselIndex = startIndex;
        buildCarousel();
        carouselModal.show();
        
        const carousel = bootstrap.Carousel.getInstance(document.getElementById('imageCarousel')) || 
                        new bootstrap.Carousel(document.getElementById('imageCarousel'));
        carousel.to(startIndex);
    };

    // Build carousel
    function buildCarousel() {
        const carouselInner = document.getElementById('carouselInner');
        const indicators = document.getElementById('carouselIndicators');
        
        carouselInner.innerHTML = '';
        indicators.innerHTML = '';
        
        uploadedImages.forEach((img, index) => {
            const item = document.createElement('div');
            item.className = `carousel-item ${index === currentCarouselIndex ? 'active' : ''}`;
            item.innerHTML = `
                <img src="${img.preview}" class="d-block" data-index="${index}">
                ${img.description ? `<div class="image-description-box">${img.description}</div>` : ''}
            `;
            carouselInner.appendChild(item);
            
            const indicator = document.createElement('button');
            indicator.type = 'button';
            indicator.setAttribute('data-bs-target', '#imageCarousel');
            indicator.setAttribute('data-bs-slide-to', index);
            if (index === currentCarouselIndex) indicator.className = 'active';
            indicators.appendChild(indicator);
        });
        
        // Add drag event listeners to all images
        document.querySelectorAll('.carousel-item img').forEach(img => {
            img.addEventListener('mousedown', handleMouseDown);
            img.addEventListener('mousemove', handleMouseMove);
            img.addEventListener('mouseup', handleMouseUp);
            img.addEventListener('mouseleave', handleMouseUp);
            img.addEventListener('click', toggleZoom);
            
            // Touch events for mobile
            img.addEventListener('touchstart', handleTouchStart);
            img.addEventListener('touchmove', handleTouchMove);
            img.addEventListener('touchend', handleTouchEnd);
        });
        
        updateImageCounter();
    }

    // Update counter
    function updateImageCounter() {
        document.getElementById('imageCounter').textContent = 
            `${currentCarouselIndex + 1} / ${uploadedImages.length}`;
    }

    // Carousel slide event
    document.getElementById('imageCarousel')?.addEventListener('slid.bs.carousel', function(e) {
        currentCarouselIndex = e.to;
        updateImageCounter();
        resetZoom();
        
        // Reset drag position saat pindah slide
        translateX = 0;
        translateY = 0;
        isDragging = false;
        currentImg = null;
    });

    // Zoom functions
    window.toggleZoom = function(event) {
        const img = event.target;
        
        // Jika sudah zoom, toggle off
        if (img.classList.contains('zoomed')) {
            img.classList.remove('zoomed');
            currentZoomLevel = 1;
            translateX = 0;
            translateY = 0;
            img.style.transform = 'scale(1)';
        } else {
            // Zoom in
            img.classList.add('zoomed');
            currentZoomLevel = 2;
            img.style.transform = `scale(${currentZoomLevel}) translate(${translateX}px, ${translateY}px)`;
        }
    };

    window.zoomIn = function() {
        const activeImg = document.querySelector('.carousel-item.active img');
        if (!activeImg) return;
        
        currentZoomLevel = Math.min(currentZoomLevel + 0.5, 4);
        activeImg.classList.add('zoomed');
        updateTransform(activeImg);
    };

    window.zoomOut = function() {
        const activeImg = document.querySelector('.carousel-item.active img');
        if (!activeImg) return;
        
        currentZoomLevel = Math.max(currentZoomLevel - 0.5, 1);
        
        if (currentZoomLevel === 1) {
            activeImg.classList.remove('zoomed');
            translateX = 0;
            translateY = 0;
        }
        
        updateTransform(activeImg);
    };

    window.resetZoom = function() {
        const activeImg = document.querySelector('.carousel-item.active img');
        if (!activeImg) return;
        
        currentZoomLevel = 1;
        translateX = 0;
        translateY = 0;
        activeImg.classList.remove('zoomed');
        activeImg.style.transform = 'scale(1)';
    };
    
    function updateTransform(img) {
        img.style.transform = `scale(${currentZoomLevel}) translate(${translateX}px, ${translateY}px)`;
    }
    
    // ============================================================
    //                  DRAG/PAN FUNCTIONALITY
    // ============================================================
    
    function handleMouseDown(e) {
        const img = e.target;
        if (!img.classList.contains('zoomed')) return;
        
        isDragging = true;
        currentImg = img;
        startX = e.clientX - translateX;
        startY = e.clientY - translateY;
        
        // Disable carousel controls saat drag
        document.querySelectorAll('.carousel-control-prev, .carousel-control-next').forEach(btn => {
            btn.style.pointerEvents = 'none';
        });
    }
    
    function handleMouseMove(e) {
        if (!isDragging || !currentImg) return;
        
        e.preventDefault();
        
        translateX = e.clientX - startX;
        translateY = e.clientY - startY;
        
        updateTransform(currentImg);
    }
    
    function handleMouseUp() {
        if (isDragging) {
            isDragging = false;
            currentImg = null;
            
            // Re-enable carousel controls
            document.querySelectorAll('.carousel-control-prev, .carousel-control-next').forEach(btn => {
                btn.style.pointerEvents = 'auto';
            });
        }
    }
    
    // Touch events for mobile
    function handleTouchStart(e) {
        const img = e.target;
        if (!img.classList.contains('zoomed')) return;
        
        isDragging = true;
        currentImg = img;
        const touch = e.touches[0];
        startX = touch.clientX - translateX;
        startY = touch.clientY - translateY;
    }
    
    function handleTouchMove(e) {
        if (!isDragging || !currentImg) return;
        
        e.preventDefault();
        
        const touch = e.touches[0];
        translateX = touch.clientX - startX;
        translateY = touch.clientY - startY;
        
        updateTransform(currentImg);
    }
    
    function handleTouchEnd() {
        isDragging = false;
        currentImg = null;
    }

    // ============================================================
    //                  DOWNLOAD FUNCTIONALITY
    // ============================================================
    window.downloadCurrentImage = function() {
        const currentImg = uploadedImages[currentCarouselIndex];
        if (!currentImg) return;
        
        const link = document.createElement('a');
        link.href = currentImg.preview;
        link.download = `${currentNoLab}_image_${currentCarouselIndex + 1}.jpg`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        // Show notification
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
        Toast.fire({
            icon: 'success',
            title: 'Image berhasil diunduh'
        });
    };

    // ============================================================
    //                  PRINT FUNCTIONALITY
    // ============================================================
    window.printCurrentImage = function() {
        const currentImg = uploadedImages[currentCarouselIndex];
        if (!currentImg) return;
        
        // Create print window
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Print Image - ${currentNoLab}</title>
                <style>
                    @media print {
                        @page {
                            margin: 0.5cm;
                            size: auto;
                        }
                        body {
                            margin: 0;
                            padding: 20px;
                        }
                    }
                    body {
                        font-family: Arial, sans-serif;
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        padding: 20px;
                    }
                    .header {
                        text-align: center;
                        margin-bottom: 20px;
                        width: 100%;
                    }
                    .header h2 {
                        margin: 5px 0;
                        color: #333;
                    }
                    .image-container {
                        max-width: 100%;
                        text-align: center;
                    }
                    img {
                        max-width: 100%;
                        height: auto;
                        border: 1px solid #ddd;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    }
                    .description {
                        margin-top: 15px;
                        padding: 10px;
                        background: #f8f9fa;
                        border-radius: 5px;
                        text-align: center;
                        max-width: 800px;
                    }
                    .footer {
                        margin-top: 20px;
                        font-size: 12px;
                        color: #666;
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                <div class="header">
                    <h2>Lab Image</h2>
                    <p><strong>No Lab:</strong> ${currentNoLab}</p>
                    <p><strong>Image:</strong> ${currentCarouselIndex + 1} of ${uploadedImages.length}</p>
                </div>
                <div class="image-container">
                    <img src="${currentImg.preview}" alt="Lab Image">
                </div>
                ${currentImg.description ? `
                    <div class="description">
                        <strong>Keterangan:</strong><br>
                        ${currentImg.description}
                    </div>
                ` : ''}
                <div class="footer">
                    <p>Printed on ${new Date().toLocaleString('id-ID')}</p>
                </div>
            </body>
            </html>
        `);
        
        // Wait for image to load then print
        printWindow.document.close();
        printWindow.onload = function() {
            setTimeout(() => {
                printWindow.print();
                // Close window after printing (optional)
                // printWindow.close();
            }, 250);
        };
    };

    // Delete current image in carousel
    document.getElementById('deleteCurrentImage')?.addEventListener('click', function() {
        const currentImg = uploadedImages[currentCarouselIndex];
        confirmDeleteImage(currentCarouselIndex, currentImg.id);
    });

    // Confirm delete
    window.confirmDeleteImage = function(index, imageId) {
        Swal.fire({
            title: 'Yakin hapus image?',
            text: "Image tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteImage(index, imageId);
            }
        });
    };

    function deleteImage(index, imageId) {
        Swal.fire({
            title: 'Menghapus...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });
        
        fetch(`/analyst/worklist/delete-image/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                uploadedImages.splice(index, 1);
                updatePreviewContainer();
                updateBadge(uploadedImages.length);
                
                if (uploadedImages.length === 0) {
                    document.getElementById('uploadedImagesPreview').style.display = 'none';
                    carouselModal.hide();
                } else {
                    buildCarousel();
                    if (currentCarouselIndex >= uploadedImages.length) {
                        currentCarouselIndex = uploadedImages.length - 1;
                    }
                }
                
                Swal.fire('Terhapus!', 'Image berhasil dihapus', 'success');
            } else {
                Swal.fire('Error', 'Gagal menghapus image', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Terjadi kesalahan', 'error');
        });
    }

    function updateBadge(count) {
        const badge = document.getElementById('imageCountBadge');
        if (badge) {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'inline-block' : 'none';
        }
    }

    function resetModal() {
        document.getElementById('imageUploadContainer').innerHTML = '';
        imageCounter = 0;
    }
});
</script>

<style>
.preview-area {
    margin-top: 10px;
    text-align: center;
}

.image-input {
    cursor: pointer;
}

#imageUploadContainer .card {
    border-left: 3px solid #0d6efd;
}

#previewContainer .card {
    transition: transform 0.2s;
}

#previewContainer .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

#uploadedImagesPreview {
    border-top: 2px solid #dee2e6;
    padding-top: 15px;
}
/* Force SweetAlert2 to be on top of everything */
.swal2-container {
    z-index: 999999 !important;
}

.swal-high-zindex {
    z-index: 999999 !important;
}

/* Override Bootstrap modal z-index if needed */
.modal {
    z-index: 1050 !important;
}

.modal-backdrop {
    z-index: 1040 !important;
}

/* Ensure SweetAlert backdrop is also high */
div:where(.swal2-container) {
    z-index: 999999 !important;
}
.image-carousel-modal .modal-dialog {
            max-width: 90%;
            height: 90vh;
        }
        
        .image-carousel-modal .modal-content {
            height: 100%;
        }
        
        .image-carousel-modal .carousel-inner {
            height: calc(100% - 120px);
        }
        
        .image-carousel-modal .carousel-item {
            height: 100%;
        }
        
        .image-carousel-modal .carousel-item img {
            max-height: 70vh;
            width: auto;
            max-width: 100%;
            object-fit: contain;
            margin: 0 auto;
            cursor: zoom-in;
            transition: transform 0.3s ease;
            user-select: none;
        }
        
        .image-carousel-modal .carousel-item img.zoomed {
            cursor: grab;
            transform: scale(2);
        }
        
        .image-carousel-modal .carousel-item img.zoomed:active {
            cursor: grabbing;
        }
        
        .carousel-item {
            overflow: hidden;
        }
        
        .carousel-control-prev,
        .carousel-control-next {
            width: 5%;
        }
        
        .carousel-indicators {
            bottom: -40px;
        }
        
        .image-counter {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            z-index: 10;
            font-size: 14px;
        }
        
        .image-description-box {
            position: absolute;
            bottom: 50px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            max-width: 80%;
            text-align: center;
        }
        
        .zoom-controls {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 10;
        }
        
        .zoom-controls button {
            margin: 0 5px;
        }

        /* Preview Grid Styles */
        .preview-image-card {
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .preview-image-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }
        
        .preview-image-card img {
            transition: transform 0.3s ease;
        }
        
        .preview-image-card:hover img {
            transform: scale(1.1);
        }
        
        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .preview-image-card:hover .image-overlay {
            opacity: 1;
        }
        
        .image-overlay i {
            color: white;
            font-size: 40px;
        }
        
        .image-number-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            z-index: 1;
        }
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: brightness(0) saturate(0) invert(50%);
        }

</style>
@endpush