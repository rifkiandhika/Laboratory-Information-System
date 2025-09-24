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
                        </div>
                    </div>
                </div>

            </div>
    </section>

@endsection
{{-- @section('modal')
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">History Sampling</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body py-0" style="max-height: 700px; overflow-y: auto;">
       <hr>
           <form action="#" class="row">
              <div class="detail_pemeriksaan col-12">
                  <div class="d-flex justify-content-between">
                      <p class="h6 text-gray-800">Detail Sampling</p>
                      <p class="h6 text-gray-600">Senin, 12 Jan 2023 / 19.50</p>
                  </div>
                  <hr>
                  <div class="row">
                   <div class="col-lg-5">
                    <div class="d-flex justify-content-between">
                      <p class="h6 text-gray-800 col-12 ml-0">Darah Lengkap</p>
                      <p class="h6 text-gray-800 col-12">Tabung K3 EDTA</p>
                    </div>
                    <div class="sub-detail"">
                      <p class="text-gray-600 offset-md-3">Leukosit</p>
                      <p class="text-gray-600 offset-md-3" style="margin-top: -10px;">Eritrosit</p>
                      <p class="text-gray-600 offset-md-3" style="margin-top: -10px;">Hemoglobin</p>
                      <p class="text-gray-600 offset-md-3" style="margin-top: -10px;">more...</p>
                    </div>
                    <div class="d-flex justify-content-between">
                      <p class="h6 text-gray-800 col-12">Creatinin</p>
                      <p class="h6 text-gray-800 col-12">Tabung Merah</p>
                    </div>
                    <div class="sub-detail"">
                      <p class="text-gray-600 offset-md-3">Leukosit</p>
                      <p class="text-gray-600 offset-md-3" style="margin-top: -10px;">Eritrosit</p>
                      <p class="text-gray-600 offset-md-3" style="margin-top: -10px;">Hemoglobin</p>
                      <p class="text-gray-600 offset-md-3" style="margin-top: -10px;">more...</p>
                     </div>
                     <div class="d-flex justify-content-between">
                      <p class="h6 text-gray-800 col-12">Urea (Bun)</p>
                      <p class="h6 text-gray-800 col-12">Tabung Hijau</p>
                     </div>
                     <div class="sub-detail"">
                     </div>
                   </div>
                  </div>
                  <div class="row mt-2">
                   <div class="form-group col-12">
                      <label for="exampleFormControlTextarea1">Note</label>
                      <textarea class="form-control txt-area" style="resize: none; height: 130px; outline: none; border: none;" id="note-2" rows="3" name="note-2" placeholder="Kimia Klinik tidak dapat diambil sampel dikarenakan pembuluh darah kembut kembut" readonly></textarea>
                   </div>
                  </div>
                  <div class="d-flex justify-content-between">
                   <p class="h6 text-gray-800 mt-3">Spesimen Collection</p>
                   <p class="h6 text-gray-600 mt-3">Senin, 12 Jan 2023 / 20.00</p>
                  </div>
                  <hr>
                  <div class="row">
                      <div class="akordion col-12">
                          <div class="akordion-content">
                              <header>
                                  <span class="judul-ak">Tabung K3 EDTA</span>
                                  <i class="bx bx-plus" style="color: #D0BFFF;"></i>
                              </header>
                              <div class="deskripsi-ak">
                                  <div class="d-flex justify-content-around text-center">
                                      <div class="sampling-bar">
                                          <h2>Low</h2>
                                          <div class="prog-sampling" style="background: #FF6868;">
                                          <div class="low"></div>
                                          </div>
                                          <input type="radio" name="prog" value="low">
                                      </div>
                                      <div class="sampling-bar">
                                          <h2>Normal</h2>
                                          <div class="prog-sampling" style="margin-left: 12px; background:#FFBB64;">
                                          <div class="normal"></div>
                                          </div>
                                          <input type="radio" name="prog" value="normal">
                                      </div>
                                      <div class="sampling-bar">
                                          <h2>High</h2>
                                          <div class="prog-sampling" style="background: #8fd48e;">
                                          <div class="high"></div>
                                          </div>
                                          <input type="radio" name="prog" value="high">
                                      </div>
                                      <div class="row">
                                          <div class="form-group col-12">
                                          <label for="exampleFormControlTextarea1">Note</label>
                                          <textarea class="form-control txt-area" style="resize: none; height: 160px;" id="note-1" rows="3" name="note-2" placeholder="tulis note disini"></textarea>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="akordion-content">
                              <header>
                                  <span class="judul-ak">Tabung Clot Act</span>
                                  <i class="bx bx-plus" style="color: #FF8080;"></i>
                              </header>
                              <div class="deskripsi-ak">
                                  <div class="d-flex justify-content-around text-center">
                                      <div class="sampling-bar">
                                          <h2>Low</h2>
                                          <div class="prog-sampling" style="background: #FF6868;">
                                          <div class="low"></div>
                                          </div>
                                          <input type="radio" name="prog" value="low">
                                      </div>
                                      <div class="sampling-bar">
                                          <h2>Normal</h2>
                                          <div class="prog-sampling" style="margin-left: 12px; background:#FFBB64;">
                                          <div class="normal"></div>
                                          </div>
                                          <input type="radio" name="prog" value="normal">
                                      </div>
                                      <div class="sampling-bar">
                                          <h2>High</h2>
                                          <div class="prog-sampling" style="background: #8fd48e;">
                                          <div class="high"></div>
                                          </div>
                                          <input type="radio" name="prog" value="high">
                                      </div>
                                      <div class="row">
                                          <div class="form-group col-12">
                                          <label for="exampleFormControlTextarea1">Note</label>
                                          <textarea class="form-control txt-area" style="resize: none; height: 160px;" id="note-1" rows="3" name="note-2" placeholder="tulis note disini"></textarea>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="akordion-content">
                              <header>
                                  <span class="judul-ak">Tabung Urine</span>
                                  <i class="bx bx-plus" style="color: #F2BED1;"></i>
                              </header>
                              <div class="deskripsi-ak">
                                  <div class="d-flex justify-content-around text-center">
                                      <div class="sampling-bar">
                                          <h2>Low</h2>
                                          <div class="prog-sampling" style="background: #FF6868;">
                                          <div class="low"></div>
                                          </div>
                                          <input type="radio" name="prog" value="low">
                                      </div>
                                      <div class="sampling-bar">
                                          <h2>Normal</h2>
                                          <div class="prog-sampling" style="margin-left: 12px; background:#FFBB64;">
                                          <div class="normal"></div>
                                          </div>
                                          <input type="radio" name="prog" value="normal">
                                      </div>
                                      <div class="sampling-bar">
                                          <h2>High</h2>
                                          <div class="prog-sampling" style="background: #8fd48e;">
                                          <div class="high"></div>
                                          </div>
                                          <input type="radio" name="prog" value="high">
                                      </div>
                                      <div class="row">
                                          <div class="form-group col-12">
                                          <label for="exampleFormControlTextarea1">Note</label>
                                          <textarea class="form-control txt-area" style="resize: none; height: 160px;" id="note-1" rows="3" name="note-2" placeholder="tulis note disini"></textarea>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="akordion-content">
                              <header>
                                  <span class="judul-ak">Litium Heparin</span>
                                  <i class="bx bx-plus" style="color: #A1EEBD;"></i>
                              </header>
                              <div class="deskripsi-ak">
                                  <div class="d-flex justify-content-around text-center">
                                      <div class="sampling-bar">
                                          <h2>Low</h2>
                                          <div class="prog-sampling" style="background: #FF6868;">
                                          <div class="low"></div>
                                          </div>
                                          <input type="radio" name="prog" value="low">
                                      </div>
                                      <div class="sampling-bar">
                                          <h2>Normal</h2>
                                          <div class="prog-sampling" style="margin-left: 12px; background:#FFBB64;">
                                          <div class="normal"></div>
                                          </div>
                                          <input type="radio" name="prog" value="normal">
                                      </div>
                                      <div class="sampling-bar">
                                          <h2>High</h2>
                                          <div class="prog-sampling" style="background: #8fd48e;">
                                          <div class="high"></div>
                                          </div>
                                          <input type="radio" name="prog" value="high">
                                      </div>
                                      <div class="row">
                                          <div class="form-group col-12">
                                          <label for="exampleFormControlTextarea1">Note</label>
                                          <textarea class="form-control txt-area" style="resize: none; height: 160px;" id="note-1" rows="3" name="note-2" placeholder="tulis note disini"></textarea>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      </div>
                      <hr>
                      <div class="d-flex justify-content-between">
                          <p class="h6 text-gray-800 mt-3">Spesimen Handling</p>
                          <p class="h6 text-gray-600 mt-3">Senin, 12 Jan 2023 / 20.50</p>
                      </div>
                      <hr>
                      <div class="row">
                          <div class="akordion col-12">
                              <div class="akordion-content">
                                  <header>
                                      <span class="judul-ak">Tabung K3 EDTA</span>
                                      <i class="bx bx-plus" style="color: #D0BFFF;"></i>
                                  </header>
                                  <div class="deskripsi-ak">
                                      <p class="h6 font-weight-bold text-center">Serum</p>
                                          <div class="d-flex justify-content-around text-center">
                                              <div class="sampling-bar">
                                                  <h2>Normal</h2>
                                                  <div class="serum my-2">
                                                  <img src="../image/Group 150.png" alt="">
                                                  </div>
                                                  <input type="radio" name="serum" value="normal">
                                              </div>
                                              <div class="sampling-bar">
                                                  <h2>Hemolytic</h2>
                                                  <div class="serum my-2">
                                                  <img src="../image/Group 151.png" alt="">
                                                  </div>
                                                  <input type="radio" name="serum" value="hemolytic">
                                              </div>
                                              <div class="sampling-bar">
                                                  <h2>Iteric</h2>
                                                  <div class="serum my-2">
                                                  <img src="../image/Group 152.png" alt="">
                                                  </div>
                                                  <input type="radio" name="serum" value="iteric">
                                              </div>
                                              <div class="sampling-bar">
                                                  <h2>Lipemic</h2>
                                                  <div class="serum my-2">
                                                  <img src="../image/Group 153.png" alt="">
                                                  </div>
                                                  <input type="radio" name="serum" value="lipemic">
                                              </div>
                                          </div>
                                      <div class="row">
                                          <div class="form-group col-12">
                                              <label for="exampleFormControlTextarea1">Note</label>
                                              <textarea class="form-control txt-area" style="resize: none; height: 100px;" id="note-1" rows="3" name="note-2" placeholder="tulis note disini"></textarea>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          <div class="akordion-content">
                          <header>
                              <span class="judul-ak">Tabung Clot Act</span>
                              <i class="bx bx-plus" style="color: #FF8080;"></i>
                          </header>
                          <div class="akordion-content">
                          <header>
                              <span class="judul-ak">Tabung Urine</span>
                              <i class="bx bx-plus" style="color: #F2BED1;"></i>
                          </header>
                          <div class="deskripsi-ak">
                              <p class="h6 font-weight-bold text-center">Serum</p>
                              <div class="d-flex justify-content-around text-center">
                              <div class="sampling-bar">
                                  <h2>Normal</h2>
                                  <div class="serum mb-2">
                                  <img src="../image/Group 150.png" alt="">
                                  </div>
                                  <input type="radio" name="serum" value="normal">
                              </div>
                              <div class="sampling-bar">
                                  <h2>Hemolytic</h2>
                                  <div class="serum my-2">
                                  <img src="../image/Group 151.png" alt="">
                                  </div>
                                  <input type="radio" name="serum" value="hemolytic">
                              </div>
                              <div class="sampling-bar">
                                  <h2>Iteric</h2>
                                  <div class="serum my-2">
                                  <img src="../image/Group 152.png" alt="">
                                  </div>
                                  <input type="radio" name="serum" value="iteric">
                              </div>
                              <div class="sampling-bar">
                                  <h2>Lipemic</h2>
                                  <div class="serum my-2">
                                  <img src="../image/Group 153.png" alt="">
                                  </div>
                                  <input type="radio" name="serum" value="lipemic">
                              </div>
                              </div>
                              <div class="row">
                              <div class="form-group col-12">
                                  <label for="exampleFormControlTextarea1">Note</label>
                                  <textarea class="form-control txt-area" style="resize: none; height: 100px;" id="note-1" rows="3" name="note-2" placeholder="tulis note disini"></textarea>
                              </div>
                              </div>
                          </div>
                          </div>
                          <div class="akordion-content">
                          <header>
                              <span class="judul-ak">Litium Heparin</span>
                              <i class="bx bx-plus" style="color: #A1EEBD;"></i>
                          </header>
                          <div class="deskripsi-ak">
                              <p class="h6 font-weight-bold text-center">Serum</p>
                              <div class="d-flex justify-content-around text-center">
                              <div class="sampling-bar">
                                  <h2>Normal</h2>
                                  <div class="serum my-2">
                                  <img src="../image/Group 150.png" alt="">
                                  </div>
                                  <input type="radio" name="serum" value="normal">
                              </div>
                              <div class="sampling-bar">
                                  <h2>Hemolytic</h2>
                                  <div class="serum my-2">
                                  <img src="../image/Group 151.png" alt="">
                                  </div>
                                  <input type="radio" name="serum" value="hemolytic">
                              </div>
                              <div class="sampling-bar">
                                  <h2>Iteric</h2>
                                  <div class="serum my-2">
                                  <img src="../image/Group 152.png" alt="">
                                  </div>
                                  <input type="radio" name="serum" value="iteric">
                              </div>
                              <div class="sampling-bar">
                                  <h2>Lipemic</h2>
                                  <div class="serum my-2">
                                  <img src="../image/Group 153.png" alt="">
                                  </div>
                                  <input type="radio" name="serum" value="lipemic">
                              </div>
                              </div>
                              <div class="row">
                              <div class="form-group col-12">
                                  <label for="exampleFormControlTextarea1">Note</label>
                                  <textarea class="form-control txt-area" style="resize: none; height: 100px;" id="note-1" rows="3" name="note-2" placeholder="tulis note disini"></textarea>
                              </div>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                      <div class="flex-row">
                          <p class="h6 text-gray-800 my-3">Tanggal Verifikasi</p>
                          <div class="form-group col-sm-12 px-1">
                              <label for="exampleFormControlTextarea1">Note</label>
                              <textarea class="form-control txt-area" style="resize: none; height: 100px;" id="note-1" rows="3" name="note-2" placeholder="tulis note disini"></textarea>
                          </div>
                          <p class="h6 font-weight-bold text-center mt-3">Analyst</p>
                      </div>
                      <div class="flex-row">
                          <p class="h6 text-gray-800 my-3">Senin, 12 Jan 2023 / 22.00</p>
                          <div class="form-group col-sm-12 px-1">
                              <label for="exampleFormControlTextarea1">Note</label>
                              <textarea class="form-control txt-area" style="resize: none; height: 100px;" id="note-1" rows="3" name="note-2" placeholder="tulis note disini"></textarea>
                          </div>
                          <p class="h6 font-weight-bold text-center mt-3">Dokter PK</p>
                      </div>
                    </div>
                  </div>
              </form>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
          </div>
      </div>
    </div>
  </div>
</div>
@endsection --}}

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
                            <form id="delete-form-${data_pasien.id}" action="analyst/worklist/${data_pasien.id}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button class="btn btn-outline-danger w-100" onclick="confirmDelete(${data_pasien.id})">Delete</button>
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

                        // Tambahkan const WidalParams di bawah hematologiParams
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
                                tipe_inputan: 'Dropdown',
                                opsi_output: 'Negatif;1/80;1/160;1/320;1/640' 
                            }
                        ];

                        // TAMBAHAN: Definisi UrineParams
                        // const UrineParams = [
                        //     {
                        //         nama: 'Warna',
                        //         display_name: 'Warna',
                        //         satuan: '-',
                        //         normal_min_l: '-',
                        //         normal_max_l: '-',
                        //         normal_min_p: '-',
                        //         normal_max_p: '-',
                        //         nilai_rujukan_l: '-',
                        //         nilai_rujukan_p: '-',
                        //         tipe_inputan: 'Dropdown',
                        //         opsi_output: 'Kuning;Kuning Pucat;Kuning Tua;Kuning kecokelatan;Orange;Merah;Coklat',
                        //         default: 'Kuning'
                        //     },
                        //     {
                        //         nama: 'Kekeruhan',
                        //         display_name: 'Kekeruhan',
                        //         satuan: '-',
                        //         normal_min_l: '-',
                        //         normal_max_l: '-',
                        //         normal_min_p: '-',
                        //         normal_max_p: '-',
                        //         nilai_rujukan_l: '-',
                        //         nilai_rujukan_p: '-',
                        //         tipe_inputan: 'Dropdown',
                        //         opsi_output: 'Jernih;Agak Keruh;Keruh;Sangat keruh',
                        //         default: 'Jernih'
                        //     },
                        //     {
                        //         nama: 'Berat Jenis',
                        //         display_name: 'Berat Jenis',
                        //         satuan: '-',
                        //         normal_min_l: 1.003,
                        //         normal_max_l: 1.035,
                        //         normal_min_p: 1.003,
                        //         normal_max_p: 1.035,
                        //         nilai_rujukan_l: '1,003-1,035',
                        //         nilai_rujukan_p: '1,003-1,035',
                        //         tipe_inputan: 'Dropdown',
                        //         opsi_output: '<1.005;1.005;1.010;1.015;1.020;1.025;1.030',
                        //         default: '1.015'
                        //     },
                        //     {
                        //         nama: 'PH',
                        //         display_name: 'pH',
                        //         satuan: '-',
                        //         normal_min_l: 4.5,
                        //         normal_max_l: 8.0,
                        //         normal_min_p: 4.5,
                        //         normal_max_p: 8.0,
                        //         nilai_rujukan_l: '4,5-8,0',
                        //         nilai_rujukan_p: '4,5-8,0',
                        //         tipe_inputan: 'Dropdown',
                        //         opsi_output: '4.5;5.0;5.5;6.0;6.5;7.0;7.5;8.0;8.5;9.0',
                        //         default: '6.0'
                        //     },
                        //     {
                        //         nama: 'Leukosit',
                        //         display_name: 'Leukosit',
                        //         satuan: '-',
                        //         normal_min_l: '-',
                        //         normal_max_l: '-',
                        //         normal_min_p: '-',
                        //         normal_max_p: '-',
                        //         nilai_rujukan_l: '-',
                        //         nilai_rujukan_p: '-',
                        //         tipe_inputan: 'Dropdown',
                        //         opsi_output: 'Negatif;Positif;Positif(+);Positif(++);Positif(+++)',
                        //         default: 'Negatif'
                        //     },
                        //     {
                        //         nama: 'Nitrit',
                        //         display_name: 'Nitrit',
                        //         satuan: '-',
                        //         normal_min_l: '-',
                        //         normal_max_l: '-',
                        //         normal_min_p: '-',
                        //         normal_max_p: '-',
                        //         nilai_rujukan_l: '-',
                        //         nilai_rujukan_p: '-',
                        //         tipe_inputan: 'Dropdown',
                        //         opsi_output: 'Negatif;Positif(+);Positif(++);Positif(+++)',
                        //         default: 'Negatif'
                        //     },
                        //     {
                        //         nama: 'Protein',
                        //         display_name: 'Protein',
                        //         satuan: '-',
                        //         normal_min_l: '-',
                        //         normal_max_l: '-',
                        //         normal_min_p: '-',
                        //         normal_max_p: '-',
                        //         nilai_rujukan_l: '-',
                        //         nilai_rujukan_p: '-',
                        //         tipe_inputan: 'Dropdown',
                        //         opsi_output: 'Negatif;Positif(+);Positif(++);Positif(+++)',
                        //         default: 'Negatif'
                        //     },
                        //     {
                        //         nama: 'Glukosa',
                        //         display_name: 'Glukosa',
                        //         satuan: '-',
                        //         normal_min_l: '-',
                        //         normal_max_l: '-',
                        //         normal_min_p: '-',
                        //         normal_max_p: '-',
                        //         nilai_rujukan_l: '-',
                        //         nilai_rujukan_p: '-',
                        //         tipe_inputan: 'Dropdown',
                        //         opsi_output: 'Negatif;Positif(+);Positif(++);Positif(+++)',
                        //         default: 'Negatif'
                        //     },
                        //     {
                        //         nama: 'Keton',
                        //         display_name: 'Keton',
                        //         satuan: '-',
                        //         normal_min_l: '-',
                        //         normal_max_l: '-',
                        //         normal_min_p: '-',
                        //         normal_max_p: '-',
                        //         nilai_rujukan_l: '-',
                        //         nilai_rujukan_p: '-',
                        //         tipe_inputan: 'Dropdown',
                        //         opsi_output: 'Negatif;Positif(+);Positif(++);Positif(+++)',
                        //         default: 'Negatif'
                        //     },
                        //     {
                        //         nama: 'Urobilinogen',
                        //         display_name: 'Urobilinogen',
                        //         satuan: '-',
                        //         normal_min_l: '-',
                        //         normal_max_l: '-',
                        //         normal_min_p: '-',
                        //         normal_max_p: '-',
                        //         nilai_rujukan_l: '-',
                        //         nilai_rujukan_p: '-',
                        //         tipe_inputan: 'Dropdown',
                        //         opsi_output: 'Negatif;Positif(+);Positif(++);Positif(+++)',
                        //         default: 'Negatif'
                        //     },
                        //     {
                        //         nama: 'Bilirubin',
                        //         display_name: 'Bilirubin',
                        //         satuan: '-',
                        //         normal_min_l: '-',
                        //         normal_max_l: '-',
                        //         normal_min_p: '-',
                        //         normal_max_p: '-',
                        //         nilai_rujukan_l: '-',
                        //         nilai_rujukan_p: '-',
                        //         tipe_inputan: 'Dropdown',
                        //         opsi_output: 'Negatif;Positif(+);Positif(++);Positif(+++)',
                        //         default: 'Negatif'
                        //     },
                        //     {
                        //         nama: 'Blood',
                        //         display_name: 'Blood',
                        //         satuan: '-',
                        //         normal_min_l: '-',
                        //         normal_max_l: '-',
                        //         normal_min_p: '-',
                        //         normal_max_p: '-',
                        //         nilai_rujukan_l: '-',
                        //         nilai_rujukan_p: '-',
                        //         tipe_inputan: 'Dropdown',
                        //         opsi_output: 'Negatif;Positif(+);Positif(++);Positif(+++)',
                        //         default: 'Negatif'
                        //     },
                        //     {
                        //         nama: 'Eritrosit',
                        //         display_name: '- Eritrosit',
                        //         satuan: '',
                        //         normal_min_l: 0,
                        //         normal_max_l: 2,
                        //         normal_min_p: 0,
                        //         normal_max_p: 2,
                        //         nilai_rujukan_l: '0-2',
                        //         nilai_rujukan_p: '0-2',
                        //         tipe_inputan: 'Text',
                        //         opsi_output: '',
                        //         default: 'Negatif'
                        //     },
                        //     {
                        //         nama: 'Leukosit_sedimen',
                        //         display_name: '- Leukosit',
                        //         satuan: '',
                        //         normal_min_l: 0,
                        //         normal_max_l: 5,
                        //         normal_min_p: 0,
                        //         normal_max_p: 5,
                        //         nilai_rujukan_l: '0-5',
                        //         nilai_rujukan_p: '0-5',
                        //         tipe_inputan: 'Text',
                        //         opsi_output: '',
                        //         default: 'Negatif'
                        //     },
                        //     {
                        //         nama: 'Epithel',
                        //         display_name: '- Epithel',
                        //         satuan: '-',
                        //         normal_min_l: '-',
                        //         normal_max_l: '-',
                        //         normal_min_p: '-',
                        //         normal_max_p: '-',
                        //         nilai_rujukan_l: 'Tidak ada - Sedikit',
                        //         nilai_rujukan_p: 'Tidak ada - Sedikit',
                        //         tipe_inputan: 'Text',
                        //         opsi_output: 'Tidak ada;Sedikit;Sedang;Banyak',
                        //         default: 'Negatif'
                        //     },
                        //     {
                        //         nama: 'Silinder',
                        //         display_name: '- Silinder',
                        //         satuan: '-',
                        //         normal_min_l: '-',
                        //         normal_max_l: '-',
                        //         normal_min_p: '-',
                        //         normal_max_p: '-',
                        //         nilai_rujukan_l: 'Tidak ada',
                        //         nilai_rujukan_p: 'Tidak ada',
                        //         tipe_inputan: 'Dropdown',
                        //         opsi_output: 'Negatif;Positif;Positif(+);Positif(++);Positif(+++);Positif(++++)',
                        //         default: 'Negatif'
                        //     },
                        //     {
                        //         nama: 'Kristal',
                        //         display_name: '- Kristal',
                        //         satuan: '-',
                        //         normal_min_l: '-',
                        //         normal_max_l: '-',
                        //         normal_min_p: '-',
                        //         normal_max_p: '-',
                        //         nilai_rujukan_l: 'Tidak ada',
                        //         nilai_rujukan_p: 'Tidak ada',
                        //         tipe_inputan: 'Dropdown',
                        //         opsi_output: 'Tidak ada;Asam urat;Kalsium oksalat;Fosfat amorf;Lainnya',
                        //         default: 'Negatif'
                        //     },
                        //     {
                        //         nama: 'Bakteri',
                        //         display_name: '- Bakteri',
                        //         satuan: '-',
                        //         normal_min_l: '-',
                        //         normal_max_l: '-',
                        //         normal_min_p: '-',
                        //         normal_max_p: '-',
                        //         nilai_rujukan_l: 'Tidak ada',
                        //         nilai_rujukan_p: 'Tidak ada',
                        //         tipe_inputan: 'Dropdown',
                        //         opsi_output: 'Negatif;Positif;Positif(+);Positif(++);Positif(+++);Positif(++++)',
                        //         default: 'Negatif'
                        //     },
                        //     {
                        //         nama: 'Jamur',
                        //         display_name: '- Jamur',
                        //         satuan: '-',
                        //         normal_min_l: '-',
                        //         normal_max_l: '-',
                        //         normal_min_p: '-',
                        //         normal_max_p: '-',
                        //         nilai_rujukan_l: 'Tidak ada',
                        //         nilai_rujukan_p: 'Tidak ada',
                        //         tipe_inputan: 'Dropdown',
                        //         opsi_output: 'Negatif;Positif;Positif(+);Positif(++);Positif(+++)',
                        //         default: 'Negatif'
                        //     },
                        //     {
                        //         nama: 'Lain-lain',
                        //         display_name: '- Lain-lain',
                        //         satuan: '-',
                        //         normal_min_l: '',
                        //         normal_max_l: '',
                        //         normal_min_p: '',
                        //         normal_max_p: '',
                        //         nilai_rujukan_l: '',
                        //         nilai_rujukan_p: '',
                        //         tipe_inputan: 'Text',
                        //         opsi_output: '',
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

                        // Create a comprehensive map of OBX data from obrs relationship
                      // Build map yang lebih robust: simpan objek, gunakan ?? untuk menjaga 0, dan filter image jika perlu
                        const obxMap = {};

                        data_pasien.obrs.forEach(obr => {
                        if (!Array.isArray(obr.obx)) return;
                        obr.obx.forEach(obx => {
                            const name = (obx.identifier_name || '').toLowerCase().trim();
                            const value = obx.identifier_value ?? obx.observation_value ?? ''; // <-- pake ?? bukan ||
                            // skip jika kosong
                            if (value === '' || value === null || value === undefined) return;

                            // optional: ignore large image/base64 entries supaya tidak menggeser index numeric
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

                        function getObxValues(parameterName) {
                            const key = (parameterName || '').toLowerCase().trim();
                            const obxItems = [];

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

                            // console.log('DEBUG', parameterName, obxItems); // ⬅ lihat semua nilai yang masuk

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
                                'WBC': { L: '3.0;15.0', P: '3.0;15.0' },           // threshold low: 3.0, high: 15.0
                                'LYM#': { L: '0.8;5.0', P: '0.8;5.0' },            // threshold low: 0.8, high: 5.0
                                'MID#': { L: '0.1;1.0', P: '0.1;1.0' },            // threshold low: 0.1, high: 1.0
                                'GRAN#': { L: '1.5;8.0', P: '1.5;8.0' },           // threshold low: 1.5, high: 8.0
                                'LYM%': { L: '15;45', P: '15;45' },                 // threshold low: 15%, high: 45%
                                'MID%': { L: '2;20', P: '2;20' },                   // threshold low: 2%, high: 20%
                                'GRAN%': { L: '45;80', P: '45;80' },                // threshold low: 45%, high: 80%
                                'RBC': { L: '3.5;7.0', P: '2.5;6.5' },             // threshold low: 3.5/2.5, high: 7.0/6.5
                                'HGB': { L: '12.0;18.0', P: '10.0;16.0' },         // threshold low: 12.0/10.0, high: 18.0/16.0
                                'HCT': { L: '30;50', P: '30;50' },                  // threshold low: 30%, high: 50%
                                'MCV': { L: '75;105', P: '75;105' },                // threshold low: 75 fL, high: 105 fL
                                'MCH': { L: '25;35', P: '25;35' },                  // threshold low: 25 pg, high: 35 pg
                                'MCHC': { L: '30;38', P: '30;38' },                 // threshold low: 30 g/dL, high: 38 g/dL
                                'RDW-CV': { L: '10.0;16.0', P: '10.0;16.0' },      // threshold low: 10.0%, high: 16.0%
                                'RDW-SD': { L: '35;50', P: '35;50' },               // threshold low: 35 fL, high: 50 fL
                                'PLT': { L: '100;450', P: '100;450' },              // threshold low: 100, high: 450
                                'MPV': { L: '6;12', P: '6;12' },                    // threshold low: 6 fL, high: 12 fL
                                'PDW': { L: '8;20', P: '8;20' },                    // threshold low: 8 fL, high: 20 fL
                                'PCT': { L: '0.10;0.60', P: '0.10;0.60' },         // threshold low: 0.10%, high: 0.60%
                                'P-LCC': { L: '25;100', P: '25;100' },              // threshold low: 25, high: 100
                                'P-LCR': { L: '10;50', P: '10;50' }                 // threshold low: 10%, high: 50%
                            };
                            
                            if (!hematologiThreshold[parameter]) return false;
                            
                            let genderCode = '';
                            if (jenisKelamin.toLowerCase().includes('laki') || jenisKelamin === 'L') {
                                genderCode = 'L';
                            } else if (jenisKelamin.toLowerCase().includes('perempuan') || jenisKelamin === 'P') {
                                genderCode = 'P';
                            }
                            
                            if (!genderCode || !hematologiThreshold[parameter][genderCode]) return false;
                            
                            const thresholdValues = hematologiThreshold[parameter][genderCode].split(';');
                            const lowThreshold = parseFloat(thresholdValues[0]);
                            const highThreshold = parseFloat(thresholdValues[1]);
                            
                            // Return true jika nilai di bawah low threshold atau di atas high threshold
                            return nilaiHasil < lowThreshold || nilaiHasil > highThreshold;
                        }

                        // Fungsi untuk mengecek threshold bintang urine
                        function checkStarThresholdUrine(nilaiHasil, parameter, jenisKelamin) {
                            // Definisi threshold untuk parameter urine (format: low;high)
                            const urineThreshold = {
                                'Berat Jenis': { L: '1.005;1.040', P: '1.005;1.040' },  // threshold low: 1.005, high: 1.040
                                'PH': { L: '5.0;8.5', P: '5.0;8.5' }                    // threshold low: 5.0, high: 8.5
                            };
                            
                            if (!urineThreshold[parameter]) return false;
                            
                            let genderCode = '';
                            if (jenisKelamin.toLowerCase().includes('laki') || jenisKelamin === 'L') {
                                genderCode = 'L';
                            } else if (jenisKelamin.toLowerCase().includes('perempuan') || jenisKelamin === 'P') {
                                genderCode = 'P';
                            }
                            
                            if (!genderCode || !urineThreshold[parameter][genderCode]) return false;
                            
                            const thresholdValues = urineThreshold[parameter][genderCode].split(';');
                            const lowThreshold = parseFloat(thresholdValues[0]);
                            const highThreshold = parseFloat(thresholdValues[1]);
                            
                            // Return true jika nilai di bawah low threshold atau di atas high threshold
                            return nilaiHasil < lowThreshold || nilaiHasil > highThreshold;
                        }

                        function checkStarThreshold(nilaiHasil, nilaiRujukan, jenisKelamin) {
                            if (!nilaiRujukan || !jenisKelamin) return false;
                            
                            // Cari nilai dalam kurung, contoh: (L.30;220 P.30;220)
                            const thresholdMatch = nilaiRujukan.match(/\(([^)]+)\)/);
                            if (!thresholdMatch) return false;
                            
                            const thresholdString = thresholdMatch[1]; // Ambil isi dalam kurung
                            const parts = thresholdString.split(' ');
                            
                            let genderCode = '';
                            if (jenisKelamin.toLowerCase().includes('laki') || jenisKelamin === 'L') {
                                genderCode = 'L';
                            } else if (jenisKelamin.toLowerCase().includes('perempuan') || jenisKelamin === 'P') {
                                genderCode = 'P';
                            }
                            
                            if (!genderCode) return false;
                            
                            // Cari threshold untuk jenis kelamin yang sesuai
                            for (const part of parts) {
                                if (part.startsWith(genderCode + '.')) {
                                    const thresholdData = part.substring(2); // Hapus prefix "L." atau "P."
                                    
                                    // Cek apakah menggunakan format low;high
                                    if (thresholdData.includes(';')) {
                                        const thresholdValues = thresholdData.split(';');
                                        const lowThreshold = parseFloat(thresholdValues[0].replace(',', '.'));
                                        const highThreshold = parseFloat(thresholdValues[1].replace(',', '.'));
                                        
                                        if (!isNaN(lowThreshold) && !isNaN(highThreshold)) {
                                            // Return true jika nilai di bawah low threshold atau di atas high threshold
                                            return nilaiHasil < lowThreshold || nilaiHasil > highThreshold;
                                        }
                                    } else {
                                        // Format lama, hanya low threshold
                                        const thresholdValue = parseFloat(thresholdData.replace(',', '.'));
                                        if (!isNaN(thresholdValue)) {
                                            // Return true jika nilai hasil di bawah threshold
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
                                                            const isHematologi = p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('hematologi');
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
                                                            const isMikrobiologi = p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('microbiologi');
                                                            return isMikrobiologi;
                                                            // console.log('Nama pemeriksaan:', p.data_pemeriksaan.nama_pemeriksaan.toLowerCase());
                                                        });
                                                        
                                                        if (hasHematologi) {
                                                            // Jika ada hematologi, tampilkan parameter hematologi lengkap
                                                            const hematologiPemeriksaan = e.pasiens.find(p => 
                                                                p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('hematologi')
                                                            );
                                                            const judulHematologi = e.pasiens.find(p => p.data_pemeriksaan?.judul)?.data_pemeriksaan?.judul || '';
                                                            const namaPemeriksaanHematologi = hematologiPemeriksaan ? hematologiPemeriksaan.data_pemeriksaan.nama_pemeriksaan : 'Hematologi Lengkap';
                                                            
                                                            let html = '';
                                                            
                                                            // Tampilkan header judul jika ada
                                                            if (judulHematologi) {
                                                                html += `
                                                                    <tr class="hematologi-title-header">
                                                                        <td colspan="8" class="fw-bold text-primary ps-3" style="background-color: #e3f2fd; border-left: 4px solid #2196f3; padding: 10px;">
                                                                            ${judulHematologi}
                                                                        </td>
                                                                    </tr>
                                                                `;
                                                            }
                                                            
                                                            // Tampilkan semua parameter dengan indentasi
                                                            html += hematologiParams.map((param, paramIdx) => {
                                                                const obxValues = getObxValues(param.nama);
                                                                const rowId = `hematologi_${idx}_${paramIdx}`;
                                                                const initialFlag = getInitialFlagContent(obxValues.hasilUtama, param.nama, true, false);
                                                                const normalValues = getNormalValues(param, data_pasien.jenis_kelamin);
                                                                
                                                                return `
                                                                    <tr data-id="${rowId}" data-parameter="${param.nama}" class="hematologi-row">
                                                                        <td class="col-2 ${judulHematologi ? 'ps-4' : ''}" ${judulHematologi ? 'style="border-left: 2px solid #e9ecef;"' : ''}>
                                                                            <strong>${param.display_name}</strong>
                                                                            <small class="text-muted d-block">${normalValues.display}</small>
                                                                            <input type="hidden" name="nama_pemeriksaan[]" value="${namaPemeriksaanHematologi}" />
                                                                            ${judulHematologi ? `<input type="hidden" name="judul[]" value="${judulHematologi}" />` : ''}
                                                                            <input type="hidden" name="parameter_name[]" value="${param.nama}" />
                                                                            <input type="hidden" name="nilai_rujukan[]" value="${normalValues.rujukan}" />
                                                                            <input type="hidden" name="department[]" value="${e.data_departement.nama_department}" />
                                                                        </td>
                                                                        <td class="col-2">
                                                                            <input type="number" name="hasil[]" 
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
                                                                            <input type="number" name="duplo_d1[]" 
                                                                                class="form-control d1 w-60 p-0 text-center" 
                                                                                disabled value="${obxValues.duplo_d1 || ''}" step="0.01" />
                                                                        </td>
                                                                        <td class="col-2 duplo d2-column" style="display: none;">
                                                                            <input type="number" name="duplo_d2[]" 
                                                                                class="form-control d2 w-60 p-0 text-center" 
                                                                                disabled value="${obxValues.duplo_d2 || ''}" step="0.01" />
                                                                        </td>
                                                                        <td class="col-2 duplo d3-column" style="display: none;">
                                                                            <input type="number" name="duplo_d3[]" 
                                                                                class="form-control d3 w-50 p-0 text-center" 
                                                                                disabled value="${obxValues.duplo_d3 || ''}" step="0.01" />
                                                                        </td>
                                                                        <td class="col-3 flag-cell">
                                                                            ${initialFlag}
                                                                            <input type="hidden" name="flag[]" value="${initialFlag.replace(/<[^>]*>?/gm, '')}" />
                                                                        </td>
                                                                        <td>
                                                                            <input type="hidden" name="satuan[]" class="form-control w-100 p-0" 
                                                                                value="${param.satuan}" readonly />
                                                                            ${param.satuan}
                                                                        </td>
                                                                    </tr>
                                                                `;
                                                            }).join('');
                                                            
                                                            return html;

                                                        } else if (hasWidal) {
                                                            // Jika ada widal, tampilkan parameter widal lengkap
                                                            const widalPemeriksaan = e.pasiens.find(p => 
                                                                p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('widal')
                                                            );
                                                            const judulWidal = e.pasiens.find(p => p.data_pemeriksaan?.judul)?.data_pemeriksaan?.judul || '';
                                                            const namaPemeriksaanWidal = widalPemeriksaan ? widalPemeriksaan.data_pemeriksaan.nama_pemeriksaan : 'Widal';
                                                            
                                                            let html = '';
                                                            
                                                            // Tampilkan header judul jika ada
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
                                                                const normalValues = getNormalValues(param, data_pasien.jenis_kelamin);
                                                                
                                                                return `
                                                                    <tr data-id="${rowId}" data-parameter="${param.nama}" class="widal-row">
                                                                        <td class="col-2 ${judulWidal ? 'ps-4' : ''}" ${judulWidal ? 'style="border-left: 2px solid #e9ecef;"' : ''}>
                                                                            <strong>${param.display_name}</strong>
                                                                            <small class="text-muted d-block">${normalValues.display}</small>
                                                                            <input type="hidden" name="nama_pemeriksaan[]" value="${namaPemeriksaanWidal}" />
                                                                            ${judulWidal ? `<input type="hidden" name="judul[]" value="${judulWidal}" />` : ''}
                                                                            <input type="hidden" name="parameter_name[]" value="${param.nama}" />
                                                                            <input type="hidden" name="nilai_rujukan[]" value="${normalValues.rujukan}" />
                                                                            <input type="hidden" name="department[]" value="${e.data_departement.nama_department}" />
                                                                        </td>
                                                                        <td class="col-2">
                                                                            <select name="hasil[]" 
                                                                                class="form-select manualInput w-60 p-0" 
                                                                                disabled>
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
                                                                        <td class="col-2 duplo d1-column text-center" style="display: none;">
                                                                            <select name="duplo_d1[]" class="form-select d1 w-60 p-0" disabled>
                                                                                ${param.opsi_output.split(';').map(opt => `
                                                                                    <option value="${opt.trim()}" ${obxValues.duplo_d1 === opt.trim() ? 'selected' : ''}>
                                                                                        ${opt.trim()}
                                                                                    </option>
                                                                                `).join('')}
                                                                            </select>
                                                                        </td>
                                                                        <td class="col-2 duplo d2-column" style="display: none;">
                                                                            <select name="duplo_d2[]" class="form-select d2 w-60 p-0" disabled>
                                                                                ${param.opsi_output.split(';').map(opt => `
                                                                                    <option value="${opt.trim()}" ${obxValues.duplo_d2 === opt.trim() ? 'selected' : ''}>
                                                                                        ${opt.trim()}
                                                                                    </option>
                                                                                `).join('')}
                                                                            </select>
                                                                        </td>
                                                                        <td class="col-2 duplo d3-column" style="display: none;">
                                                                            <select name="duplo_d3[]" class="form-select d3 w-50 p-0" disabled>
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
                                                                            <input type="hidden" name="satuan[]" class="form-control w-100 p-0" 
                                                                                value="${param.satuan}" readonly />
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
                                                            
                                                            // Tampilkan header judul jika ada
                                                            if (judulUrine) {
                                                                html += `
                                                                    <tr class="urine-title-header">
                                                                        <td colspan="8" class="fw-bold text-info ps-3" style="background-color: #e1f5fe; border-left: 4px solid #00bcd4; padding: 10px;">
                                                                            ${judulUrine}
                                                                        </td>
                                                                    </tr>
                                                                `;
                                                            }
                                                            
                                                            // Tampilkan semua parameter dengan indentasi
                                                            html += UrineParams.map((param, paramIdx) => {
                                                                const obxValues = getObxValues(param.nama);
                                                                const rowId = `urine_${idx}_${paramIdx}`;
                                                                const initialFlag = getInitialFlagContent(obxValues.hasilUtama, param.nama, false, true, null, data_pasien.jenis_kelamin);
                                                                const normalValues = getNormalValues(param, data_pasien.jenis_kelamin);
                                                                
                                                                return `
                                                                    <tr data-id="${rowId}" data-parameter="${param.nama}" class="urine-row">
                                                                        <td class="col-2 ${judulUrine ? 'ps-4' : ''}" ${judulUrine ? 'style="border-left: 2px solid #e9ecef;"' : ''}>
                                                                            <strong>${param.display_name}</strong>
                                                                            ${normalValues.rujukan !== '-' && normalValues.rujukan !== '' ? `<small class="text-muted d-block">${normalValues.rujukan ?? ''}</small>` : ''}
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
                                                                                <select name="hasil[]" 
                                                                                    class="form-select manualInput w-60 p-0" 
                                                                                    disabled>
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
                                                                        <td class="col-2 duplo d1-column text-center" style="display: none;">
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
                                                                        <td class="col-2 duplo d2-column" style="display: none;">
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
                                                                        <td class="col-2 duplo d3-column" style="display: none;">
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
                                                                            ${initialFlag}
                                                                            <input type="hidden" name="flag[]" value="${initialFlag.replace(/<[^>]*>?/gm, '')}" />
                                                                        </td>
                                                                        <td>
                                                                            <input type="hidden" name="satuan[]" class="form-control w-100 p-0" 
                                                                                value="${param.satuan}" readonly />
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
                                                            
                                                            // Tampilkan header judul hanya sekali di atas
                                                            if (judulMikrobiologi) {
                                                                html += `
                                                                    <tr class="mikrobiologi-title-header">
                                                                        <td colspan="8" class="fw-bold text-secondary ps-3" style="background-color: #f8f9fa; border-left: 4px solid #28a745; padding: 10px;">
                                                                            ${judulMikrobiologi}
                                                                        </td>
                                                                    </tr>
                                                                `;
                                                            }
                                                            
                                                            // Tampilkan semua parameter dengan indentasi
                                                            html += MicrobiologiParams.map((param, paramIdx) => {
                                                                // Cari data hasil untuk parameter ini
                                                                const obxValues = getObxValues(param.nama);
                                                                const rowId = `mikrobiologi_${idx}_${paramIdx}`;
                                                                const normalValues = getNormalValues(param, data_pasien.jenis_kelamin);
                                                                
                                                                return `
                                                                    <tr data-id="${rowId}" data-parameter="${param.nama}" class="mikrobiologi-row">
                                                                        <td class="col-2 ps-4" style="border-left: 2px solid #e9ecef;">
                                                                            <strong>${param.display_name}</strong>
                                                                            ${param.nilai_rujukan !== '-' && param.nilai_rujukan !== '' ? 
                                                                                `<small class="text-muted d-block">${param.nilai_rujukan ?? ''}</small>` : ''}
                                                                            <input type="hidden" name="nama_pemeriksaan[]" value="${namaPemeriksaanMikrobiologi}" />
                                                                            <input type="hidden" name="judul[]" value="${judulMikrobiologi}" />
                                                                            <input type="hidden" name="parameter_name[]" value="${param.nama}" />
                                                                            <input type="hidden" name="nilai_rujukan[]" value="${param.nilai_rujukan ?? '-'}" />
                                                                            <input type="hidden" name="department[]" value="${e.data_departement.nama_department}" />
                                                                        </td>
                                                                        <td class="col-2">
                                                                            ${param.tipe_inputan === 'Text' ? `
                                                                                <input type="text" name="hasil[]" 
                                                                                    class="form-control manualInput w-60 p-0 text-center" 
                                                                                    disabled value="${obxValues.hasilUtama || ''}" />
                                                                            ` : `
                                                                                <select name="hasil[]" 
                                                                                    class="form-select manualInput w-60 p-0" 
                                                                                    disabled>
                                                                                    ${param.opsi_output ? param.opsi_output.split(';').map(opt => `
                                                                                        <option value="${opt.trim()}" ${obxValues.hasilUtama === opt.trim() ? 'selected' : ''}>
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
                                                                            <!-- Untuk mikrobiologi, flag bisa disesuaikan berdasarkan kebutuhan -->
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
                                                        }
                                                        else {
                                                            // Untuk pemeriksaan individual/lainnya - setiap parameter dengan judulnya masing-masing
                                                            // Fungsi untuk display nilai rujukan
                                                            function getNilaiRujukanDisplay(nilaiRujukan, jenisKelamin) {
                                                                if (!nilaiRujukan) return '';
                                                                const parts = nilaiRujukan.split(' ');
                                                                let prefix = jenisKelamin.toLowerCase().startsWith('l') ? 'L.' : 'P.';
                                                                let match = parts.find(part => part.startsWith(prefix));
                                                                return match ? `${match.replace(prefix, '')}` : '';
                                                            }
                                                            
                                                            let html = '';
                                                            
                                                            // Tampilkan setiap parameter dengan header judulnya masing-masing
                                                            e.pasiens.forEach((p, pIdx) => {
                                                                const judul = p.data_pemeriksaan?.judul;
                                                                
                                                                // Tampilkan header judul untuk setiap parameter (jika ada judul)
                                                                if (judul && judul !== p.data_pemeriksaan.nama_pemeriksaan) {
                                                                    html += `
                                                                        <tr class="individual-title-header">
                                                                            <td colspan="8" class="fw-bold text-dark ps-3" style="background-color: #f1f3f4; border-left: 4px solid #6c757d; padding: 10px;">
                                                                                ${judul}
                                                                            </td>
                                                                        </tr>
                                                                    `;
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
                                                                
                                                                const nilaiRujukanDisplay = getNilaiRujukanDisplay(
                                                                    p.data_pemeriksaan.nilai_rujukan,
                                                                    data_pasien.jenis_kelamin
                                                                );
                                                                
                                                                // Tentukan apakah ada header judul
                                                                const hasHeader = judul && judul !== p.data_pemeriksaan.nama_pemeriksaan;

                                                                // console.log('initialFlag RAW:', initialFlag);
                                                                // console.log('initialFlag contains *:', initialFlag.includes('*'));
                                                                
                                                                html += `
                                                                    <tr data-id="${rowId}" data-parameter="${p.data_pemeriksaan.nama_parameter}">
                                                                        <td class="col-2 ${hasHeader ? 'ps-4' : ''}" ${hasHeader ? 'style="border-left: 2px solid #e9ecef;"' : ''}>
                                                                            <strong>${hasHeader ? p.data_pemeriksaan.nama_parameter : p.data_pemeriksaan.nama_pemeriksaan}</strong>
                                                                            ${nilaiRujukanDisplay ? `<br><small class="text-muted">${nilaiRujukanDisplay}</small>` : ''}
                                                                            <input type="hidden" name="nama_pemeriksaan[]" 
                                                                                value="${p.data_pemeriksaan.nama_pemeriksaan}" />
                                                                            <input type="hidden" name="judul[]" value="${judul || ''}" />
                                                                            <input type="hidden" name="parameter_name[]" 
                                                                                value="${p.data_pemeriksaan.nama_parameter}" />
                                                                            <input type="hidden" name="nilai_rujukan[]" value="${p.data_pemeriksaan.nilai_rujukan || ''}" />
                                                                            <input type="hidden" name="department[]" value="${e.data_departement.nama_department}" />
                                                                        </td>
                                                                        <td class="col-2">
                                                                            <!-- Input Text -->
                                                                            <input 
                                                                                type="text" 
                                                                                name="hasil[]" 
                                                                                class="form-control manualInput w-60 p-0 hasil-input text-center" 
                                                                                value="${obxValues.hasilUtama || ''}" 
                                                                                disabled 
                                                                                style="display: ${p.data_pemeriksaan.tipe_inputan === 'Text' ? 'block' : 'none'}" 
                                                                            />
                                                                            <!-- Select Dropdown -->
                                                                            <select 
                                                                                name="hasil[]" 
                                                                                class="form-select manualInput w-60 p-0 hasil-select" 
                                                                                disabled 
                                                                                style="display: ${p.data_pemeriksaan.tipe_inputan === 'Dropdown' ? 'block' : 'none'}"
                                                                            >
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
                                                                                <select name="duplo_d1[]" class="form-select d1 w-60 p-0" disabled>
                                                                                    ${p.data_pemeriksaan.opsi_output.split(';').map(opt => `
                                                                                        <option value="${opt.trim()}" ${obxValues.duplo_d1 === opt.trim() ? 'selected' : ''}>
                                                                                            ${opt.trim()}
                                                                                        </option>
                                                                                    `).join('')}
                                                                                </select>
                                                                                `
                                                                                :
                                                                                `
                                                                                <input type="number" name="duplo_d1[]" 
                                                                                    class="form-control d1 w-60 p-0 text-center" 
                                                                                    disabled value="${obxValues.duplo_d1 || ''}" />
                                                                                `
                                                                            }
                                                                        </td>
                                                                        <td class="col-2 duplo d2-column" style="display: none;">
                                                                            ${
                                                                                p.data_pemeriksaan.tipe_inputan === 'Dropdown' && p.data_pemeriksaan.opsi_output ?
                                                                                `
                                                                                <select name="duplo_d2[]" class="form-select d2 w-60 p-0" disabled>
                                                                                    ${p.data_pemeriksaan.opsi_output.split(';').map(opt => `
                                                                                        <option value="${opt.trim()}" ${obxValues.duplo_d2 === opt.trim() ? 'selected' : ''}>
                                                                                            ${opt.trim()}
                                                                                        </option>
                                                                                    `).join('')}
                                                                                </select>
                                                                                `
                                                                                :
                                                                                `
                                                                                <input type="number" name="duplo_d2[]" 
                                                                                    class="form-control d2 w-60 p-0 text-center" 
                                                                                    disabled value="${obxValues.duplo_d2 || ''}" />
                                                                                `
                                                                            }
                                                                        </td>
                                                                        <td class="col-2 duplo d3-column" style="display: none;">
                                                                            ${
                                                                                p.data_pemeriksaan.tipe_inputan === 'Dropdown' && p.data_pemeriksaan.opsi_output ?
                                                                                `
                                                                                <select name="duplo_d3[]" class="form-select d3 w-50 p-0" disabled>
                                                                                    ${p.data_pemeriksaan.opsi_output.split(';').map(opt => `
                                                                                        <option value="${opt.trim()}" ${obxValues.duplo_d3 === opt.trim() ? 'selected' : ''}>
                                                                                            ${opt.trim()}
                                                                                        </option>
                                                                                    `).join('')}
                                                                                </select>
                                                                                `
                                                                                :
                                                                                `
                                                                                <input type="number" name="duplo_d3[]" 
                                                                                    class="form-control d3 w-50 p-0 text-center" 
                                                                                    disabled value="${obxValues.duplo_d3 || ''}" />
                                                                                `
                                                                            }
                                                                        </td>
                                                                        <td class="col-3 flag-cell">
                                                                            ${initialFlag}
                                                                            
                                                                                <input type="hidden" name="flag[]" value="${initialFlag.replace(/<[^>]*>?/gm, '')}" />

                                                                        </td>
                                                                        <td>
                                                                            <input type="hidden" name="satuan[]" class="form-control w-100 p-0" 
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

                                let flagText = ''; // untuk simpan teks flag (Normal / Low / High)
                                let showStar = false; // untuk menentukan apakah perlu bintang

                                if (isWidal) {
                                    // Widal tidak ada flag
                                    flagCell.innerHTML = `<input type="hidden" name="flag[]" value="" />`;
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
                                            
                                            // Cek threshold bintang untuk hematologi
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
                                            
                                            // Cek threshold bintang untuk urine
                                            showStar = checkStarThresholdUrine(numValue, parameter, data_pasien.jenis_kelamin);
                                        }
                                    } else {
                                        // Umum (non-hematologi/urine)
                                        const nilaiRujukanInput = row.querySelector('input[name="nilai_rujukan[]"]');
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
                                                // Hapus bagian dalam kurung untuk parsing normal range
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
                                                
                                                // Cek apakah perlu bintang untuk kasus umum
                                                showStar = checkStarThreshold(numValue, nilaiRujukan, genderCode);
                                            }
                                        }
                                    }
                                }

                                // Render ulang isi cell dengan flag + hidden input
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
                                        <input type="hidden" name="flag[]" value="${flagWithStar}">
                                    `;
                                } else {
                                    flagCell.innerHTML = `
                                        <input type="hidden" name="flag[]" value="">
                                    `;
                                }
                            }

                            function setupFlagEventListeners() {
                                // Hapus event listener dari semua input terlebih dahulu
                                const allInputs = document.querySelectorAll('.manualInput, .d1, .d2, .d3');
                                allInputs.forEach(input => {
                                    input.removeEventListener('input', inputHandler);
                                    input.removeEventListener('change', inputHandler);
                                });

                                // HANYA tambahkan event listener untuk field HASIL (.manualInput)
                                const hasilInputs = document.querySelectorAll('.manualInput');
                                hasilInputs.forEach(input => {
                                    input.addEventListener('input', inputHandler);
                                    input.addEventListener('change', inputHandler); // Untuk select elements
                                });
                                
                                console.log(`Setup flag event listeners ONLY for ${hasilInputs.length} HASIL inputs`);
                            }


                            function inputHandler() {
                                const row = this.closest('tr');
                                const flagCell = row.querySelector('.flag-cell');
                                const parameter = row.dataset.parameter;

                                // Pastikan ini adalah input HASIL
                                if (this.classList.contains('manualInput')) {
                                    updateFlag(this.value, flagCell, parameter);
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
                                case 1: // dari d1 ke d2
                                    if (currentDuploStage >= 2) {
                                        sourceClass = 'd1';
                                        targetClass = 'd2';
                                        masterSwitchState = 2;
                                    } else {
                                        // console.log('D2 belum aktif');
                                        return;
                                    }
                                    break;
                                case 2: // dari d2 ke d3
                                    if (currentDuploStage >= 3) {
                                        sourceClass = 'd2';
                                        targetClass = 'd3';
                                        masterSwitchState = 3;
                                    } else {
                                        // console.log('D3 belum aktif');
                                        return;
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
                                    button.title = 'Currently showing: HASIL - Click to switch to D1';
                                    button.classList.remove('btn-outline-success', 'btn-outline-warning', 'btn-outline-danger');
                                    button.classList.add('btn-outline-primary');
                                    break;
                                case 1:
                                    icon.className = 'ti ti-switch-horizontal text-success';
                                    button.title = 'Currently showing: D1 - Click to switch to D2';
                                    button.classList.remove('btn-outline-primary', 'btn-outline-warning', 'btn-outline-danger');
                                    button.classList.add('btn-outline-success');
                                    break;
                                case 2:
                                    icon.className = 'ti ti-switch-horizontal text-warning';
                                    button.title = 'Currently showing: D2 - Click to switch to D3';
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

                        // Initialize master switch indicator
                        updateMasterSwitchIndicator();

                        // Modifikasi fungsi existing untuk reset master switch ketika duplo direset
                        function resetMasterSwitch() {
                            masterSwitchState = 0;
                            updateMasterSwitchIndicator();
                        }

                            // Event listener untuk tombol verifikasi
                            if (verifikasiHasilBtn) {
                                verifikasiHasilBtn.addEventListener('click', () => {
                                    document.getElementById('worklistForm').action = "{{ route('worklist.store') }}";
                                    document.getElementById('worklistForm').submit();
                                });
                            }

                            if (verifikasiDokterBtn) {
                                verifikasiDokterBtn.addEventListener('click', (e) => {
                                    e.preventDefault(); // supaya langsung tidak submit

                                    Swal.fire({
                                        title: 'Konfirmasi Verifikasi',
                                        text: "Apakah Anda yakin ingin memverifikasi ke Dokter PK?",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Ya, verifikasi!',
                                        cancelButtonText: 'Batal'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // Jika user klik "Ya"
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

                                    document.querySelectorAll('.d1, .d2, .d3').forEach(input => {
                                        input.disabled = true;
                                    });

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
@endpush