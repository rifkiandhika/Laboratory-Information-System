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
                                        data_pemeriksaan_pasien);

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
            const obxMap = {};

            // Process data from obrs->obx relationship
            data_pasien.obrs.forEach(obr => {
                if (Array.isArray(obr.obx)) {
                    obr.obx.forEach(obxItem => {
                        const key = (obxItem.identifier_name || '').toLowerCase().trim();
                        if (!obxMap[key]) obxMap[key] = [];
                        obxMap[key].push(obxItem.identifier_value);
                    });
                }
            });

            // Fallback: Also check direct obx relationship if exists
            if (data_pasien.obx && Array.isArray(data_pasien.obx)) {
                data_pasien.obx.forEach(obxItem => {
                    const paramName = obxItem.identifier_name;
                    if (!obxMap[paramName]) {
                        obxMap[paramName] = [];
                    }
                    if (obxItem.identifier_value || obxItem.observation_value) {
                        obxMap[paramName].push(obxItem.identifier_value || obxItem.observation_value);
                    }
                });
            }

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

                return {
                    duplo_d1: obxItems[1] ?? '',
                    duplo_d2: obxItems[2] ?? '',
                    duplo_d3: obxItems[3] ?? '',
                    hasilUtama: obxItems[0] ?? ''
                };
            }

            function getInitialFlagContent(value, parameter = null, isHematologi = false, nilaiRujukan = null, jenisKelamin = null) {
            const nilaiHasil = parseFloat(value);
            let flagIcon = '';

            if (!isNaN(nilaiHasil) && value !== '') {
                if (isHematologi && parameter) {
                    // range normal untuk parameter hematologi berdasarkan jenis kelamin
                    const paramData = hematologiParams.find(p => p.nama === parameter);
                    if (paramData) {
                        const normalValues = getNormalValues(paramData, jenisKelamin);
                        
                        if (nilaiHasil < normalValues.min) {
                            flagIcon = `<i class="ti ti-arrow-down text-primary"></i> Low`;
                        } else if (nilaiHasil > normalValues.max) {
                            flagIcon = `<i class="ti ti-arrow-up text-danger"></i> High`;
                        } else {
                            flagIcon = `<i class="ti ti-check text-success"></i> Normal`;
                        }
                    }
                } else {
                    // Flag logic untuk non-hematologi berdasarkan nilai rujukan dari database
                    if (nilaiRujukan && jenisKelamin) {
                        const normalRange = parseNilaiRujukan(nilaiRujukan, jenisKelamin);
                        
                        if (normalRange) {
                            if (nilaiHasil < normalRange.min) {
                                flagIcon = `<i class="ti ti-arrow-down text-primary"></i> Low`;
                            } else if (nilaiHasil > normalRange.max) {
                                flagIcon = `<i class="ti ti-arrow-up text-danger"></i> High`;
                            } else {
                                flagIcon = `<i class="ti ti-check text-success"></i> Normal`;
                            }
                        }
                    }
                }
            }
            
            return flagIcon;
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
            
            // Format: L.120-200 P.120-200 atau L.3,4-7,0 P.2,4-6,0
            const parts = nilaiRujukan.split(' ');
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
                                    <th class="col-1"></th>
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
                                            
                                            if (hasHematologi) {
                                                // Jika ada hematologi, tampilkan parameter hematologi lengkap
                                                const hematologiPemeriksaan = e.pasiens.find(p => 
                                                    p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('hematologi')
                                                );
                                                const namaPemeriksaanHematologi = hematologiPemeriksaan ? hematologiPemeriksaan.data_pemeriksaan.nama_pemeriksaan : 'Hematologi Lengkap';
                                                
                                                return hematologiParams.map((param, paramIdx) => {
                                                    // Cari data hasil untuk parameter ini
                                                    const obxValues = getObxValues(param.nama);
                                                    const rowId = `hematologi_${idx}_${paramIdx}`;
                                                    const initialFlag = getInitialFlagContent(obxValues.hasilUtama, param.nama, true);
                                                    const normalValues = getNormalValues(param, data_pasien.jenis_kelamin);
                                                    
                                                    return `
                                            <tr data-id="${rowId}" data-parameter="${param.nama}" class="hematologi-row">
                                                <td class="col-2">
                                                    <strong>${param.display_name}</strong>
                                                    <small class="text-muted d-block">${normalValues.display}</small>
                                                    <input type="hidden" name="nama_pemeriksaan[]" value="${namaPemeriksaanHematologi}" />
                                                    <input type="hidden" name="parameter_name[]" value="${param.nama}" />
                                                    <input type="hidden" name="nilai_rujukan[]" value="${normalValues.rujukan}" />
                                                    <input type="hidden" name="department[]" value="${e.data_departement.nama_department}" />
                                                </td>
                                                <td class="col-2">
                                                    <input type="number" name="hasil[]" 
                                                        class="form-control manualInput w-60 p-0 text-center" 
                                                        disabled value="${obxValues.hasilUtama || ''}" 
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
                                                </td>
                                                <td>
                                                    <input type="hidden" name="satuan[]" class="form-control w-100 p-0" 
                                                        value="${param.satuan}" readonly />
                                                    ${param.satuan}
                                                </td>
                                            </tr>
                                            `;
                                                }).join('');
                                            } else if (hasWidal) {
                                                // Jika ada widal, tampilkan parameter widal lengkap
                                                const widalPemeriksaan = e.pasiens.find(p => 
                                                    p.data_pemeriksaan.nama_pemeriksaan.toLowerCase().includes('widal')
                                                );
                                                const namaPemeriksaanWidal = widalPemeriksaan ? widalPemeriksaan.data_pemeriksaan.nama_pemeriksaan : 'Widal';
                                                
                                                return WidalParams.map((param, paramIdx) => {
                                                    // Cari data hasil untuk parameter ini
                                                    const obxValues = getObxValues(param.nama);
                                                    const rowId = `widal_${idx}_${paramIdx}`;
                                                    const normalValues = getNormalValues(param, data_pasien.jenis_kelamin);
                                                    
                                                    return `
                                            <tr data-id="${rowId}" data-parameter="${param.nama}" class="widal-row">
                                                <td class="col-2">
                                                    <strong>${param.display_name}</strong>
                                                    <small class="text-muted d-block">${normalValues.display}</small>
                                                    <input type="hidden" name="nama_pemeriksaan[]" value="${namaPemeriksaanWidal}" />
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
                                            } else {
                                                return e.pasiens.map((p, pIdx) => {
                                                const obxValues = getObxValues(p.data_pemeriksaan.nama_parameter);
                                                const rowId = p.data_pemeriksaan.id;
                                                
                                                // Debug: cek nilai yang diterima
                                                // console.log('Parameter:', p.data_pemeriksaan.nama_parameter);
                                                // console.log('Nilai Rujukan:', p.data_pemeriksaan.nilai_rujukan);
                                                // console.log('Jenis Kelamin:', data_pasien.jenis_kelamin);
                                                
                                                // Perbaikan: Tambahkan parameter nilai_rujukan dan jenis_kelamin
                                                const initialFlag = getInitialFlagContent(
                                                    obxValues.hasilUtama, 
                                                    p.data_pemeriksaan.nama_parameter, 
                                                    false, 
                                                    p.data_pemeriksaan.nilai_rujukan,
                                                    data_pasien.jenis_kelamin
                                                );
                                                
                                                // Dapatkan display nilai rujukan
                                                function getNilaiRujukanDisplay(nilaiRujukan, jenisKelamin) {
                                                    if (!nilaiRujukan) return '';

                                                    // Pisahkan berdasarkan spasi, contoh: ['L.120-200', 'P.120-200']
                                                    const parts = nilaiRujukan.split(' ');

                                                    // Temukan bagian yang sesuai dengan jenis kelamin
                                                    let prefix = jenisKelamin.toLowerCase().startsWith('l') ? 'L.' : 'P.';
                                                    let match = parts.find(part => part.startsWith(prefix));

                                                    return match ? `${match.replace(prefix, '')}` : '';
                                                }

                                                const nilaiRujukanDisplay = getNilaiRujukanDisplay(
                                                    p.data_pemeriksaan.nilai_rujukan,
                                                    data_pasien.jenis_kelamin
                                                );

                                                // console.log(getNilaiRujukanDisplay('L.120-200 P.120-200', 'Laki-laki')); 

                                                // console.log('Nilai Rujukan:', p.data_pemeriksaan.nilai_rujukan);

                                                
                                                // console.log('Nilai Rujukan Display:', nilaiRujukanDisplay);
                                                
                                                return `
                                                    <tr data-id="${rowId}" data-parameter="${p.data_pemeriksaan.nama_parameter}">
                                                        <td class="col-2">
                                                            <strong>${p.data_pemeriksaan.nama_pemeriksaan}</strong>
                                                            ${nilaiRujukanDisplay ? `<br><small class="text-muted">${nilaiRujukanDisplay}</small>` : ''}
                                                            <input type="hidden" name="nama_pemeriksaan[]" 
                                                                value="${p.data_pemeriksaan.nama_pemeriksaan}" />
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
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="satuan[]" class="form-control w-100 p-0" 
                                                                value="${p.data_pemeriksaan.nilai_satuan || ''}" readonly />
                                                            ${p.data_pemeriksaan.nilai_satuan || ''}
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
                        <label>Note</label>
                        <textarea class="form-control" name="note" cols="3" rows="3" 
                                placeholder="Masukkan catatan pemeriksaan...">${hasil.length > 0 && hasil[0].note ? hasil[0].note : ''}</textarea>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-12 mb-3 mt-2">
                        <button type="button" id="verifikasiHasilBtn" 
                                class="btn btn-outline-info btn-block w-100" disabled>Verifikasi Hasil</button>
                    </div>
                    <div class="col-lg-12 mt-2">
                        <button type="button" id="verifikasiDokterBtn" 
                                class="btn btn-outline-primary w-100" disabled>Verifikasi Dokter PK</button>
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
                .widal-row small.text-muted {
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

                // Update fungsi updateFlag untuk mendukung hematologi dengan jenis kelamin
                function updateFlag(value, flagCell, parameter = null) {
                // console.log('updateFlag called with:', { value, parameter });
                
                const numValue = parseFloat(value);
                const row = flagCell.closest('tr');
                const isHematologi = row && row.classList.contains('hematologi-row');
                const isWidal = row && row.classList.contains('widal-row');

                // console.log('Parsed numValue:', numValue);
                // console.log('Is hematologi:', isHematologi);
                // console.log('Is widal:', isWidal);

                if (isWidal) {
                    // Untuk widal, tidak ada flag normal/abnormal
                    flagCell.innerHTML = '';
                    return;
                }

                if (!isNaN(numValue) && value !== '') {
                    if (isHematologi && parameter) {
                        // Cari range normal untuk parameter hematologi berdasarkan jenis kelamin
                        const paramData = hematologiParams.find(p => p.nama === parameter);
                        if (paramData) {
                            const normalValues = getNormalValues(paramData, data_pasien.jenis_kelamin);
                            
                            if (numValue < normalValues.min) {
                                flagCell.innerHTML = '<i class="ti ti-arrow-down text-primary"></i> Low';
                            } else if (numValue > normalValues.max) {
                                flagCell.innerHTML = '<i class="ti ti-arrow-up text-danger"></i> High';
                            } else {
                                flagCell.innerHTML = '<i class="ti ti-check text-success"></i> Normal';
                            }
                        }
                    } else {
                        // Flag logic untuk non-hematologi - inline parsing untuk memastikan fungsi bisa diakses
                        const nilaiRujukanInput = row.querySelector('input[name="nilai_rujukan[]"]');
                        const nilaiRujukan = nilaiRujukanInput ? nilaiRujukanInput.value : null;
                        
                        // console.log('Nilai rujukan found:', nilaiRujukan);
                        // console.log('Jenis kelamin:', data_pasien.jenis_kelamin);
                        
                        if (nilaiRujukan && data_pasien.jenis_kelamin) {
                            // Inline parsing untuk memastikan bisa diakses
                            let normalRange = null;
                            
                            // Konversi jenis kelamin
                            let genderCode = '';
                            if (data_pasien.jenis_kelamin.toLowerCase().includes('laki') || data_pasien.jenis_kelamin === 'L') {
                                genderCode = 'L';
                            } else if (data_pasien.jenis_kelamin.toLowerCase().includes('perempuan') || data_pasien.jenis_kelamin === 'P') {
                                genderCode = 'P';
                            }
                            
                            // console.log('Gender code:', genderCode);
                            
                            if (genderCode) {
                                // Parse nilai rujukan
                                const parts = nilaiRujukan.split(' ');
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
                                
                                console.log('Target range:', targetRange);
                                
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
                            
                            console.log('Normal range calculated:', normalRange);
                            
                            if (normalRange) {
                                if (numValue < normalRange.min) {
                                    // console.log('Setting flag: Low');
                                    flagCell.innerHTML = '<i class="ti ti-arrow-down text-primary"></i> Low';
                                } else if (numValue > normalRange.max) {
                                    // console.log('Setting flag: High');
                                    flagCell.innerHTML = '<i class="ti ti-arrow-up text-danger"></i> High';
                                } else {
                                    console.log('Setting flag: Normal');
                                    flagCell.innerHTML = '<i class="ti ti-check text-success"></i> Normal';
                                }
                            } else {
                                // console.log('Normal range is null, clearing flag');
                                flagCell.innerHTML = '';
                            }
                        } else {
                            // console.log('Missing nilai rujukan or jenis kelamin, clearing flag');
                            flagCell.innerHTML = '';
                        }
                    }
                } else {
                    // console.log('Invalid number or empty value, clearing flag');
                    flagCell.innerHTML = '';
                }
            }

                function setupFlagEventListeners() {
                    const allInputs = document.querySelectorAll('.manualInput, .d1, .d2, .d3');
                    allInputs.forEach(input => {
                        input.removeEventListener('input', inputHandler);
                        input.removeEventListener('change', inputHandler);
                        input.addEventListener('input', inputHandler);
                        input.addEventListener('change', inputHandler); // Untuk select elements
                    });
                    // console.log(`Setup flag event listeners for ${allInputs.length} inputs`);
                }

                function inputHandler() {
                    const row = this.closest('tr');
                    const flagCell = row.querySelector('.flag-cell');
                    const parameter = row.dataset.parameter;

                    updateFlag(this.value, flagCell, parameter);
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
                                console.log("Menampilkan kolom D1");
                                d1Columns.forEach(col => col.style.display = 'table-cell');
                                d1Inputs.forEach(input => {
                                    input.disabled = false;
                                });
                                currentDuploStage = 1;
                                break;
                            case 1:
                                console.log("Menampilkan kolom D2");
                                d2Columns.forEach(col => col.style.display = 'table-cell');
                                d2Inputs.forEach(input => {
                                    input.disabled = false;
                                });
                                currentDuploStage = 2;
                                break;
                            case 2:
                                console.log("Menampilkan kolom D3");
                                d3Columns.forEach(col => col.style.display = 'table-cell');
                                d3Inputs.forEach(input => {
                                    input.disabled = false;
                                });
                                currentDuploStage = 3;
                                break;
                            default:
                                console.log("Semua kolom duplo sudah aktif.");
                                break;
                        }
                        setupFlagEventListeners();
                        console.log("Current duplo stage SESUDAH:", currentDuploStage);
                        logDuploValues();

                        if (verifikasiHasilBtn) verifikasiHasilBtn.disabled = false;
                        if (verifikasiDokterBtn) verifikasiDokterBtn.disabled = false;
                    });
                }

                // Setup initial flag event listeners
                setupFlagEventListeners();

                // Event listener untuk tombol verifikasi
                if (verifikasiHasilBtn) {
                    verifikasiHasilBtn.addEventListener('click', () => {
                        document.getElementById('worklistForm').action = "{{ route('worklist.store') }}";
                        document.getElementById('worklistForm').submit();
                    });
                }

                if (verifikasiDokterBtn) {
                    verifikasiDokterBtn.addEventListener('click', () => {
                        document.getElementById('worklistForm').action = `worklist/checkin/${data_pasien.id}`;
                        document.getElementById('worklistForm').submit();
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




        function populateModal(spesimen, scollection, shandling, history, data_pemeriksaan_pasien) {
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
            // console.log('=== Processing Specimen ===');
            // console.log('Tabung:', e.tabung);
            // console.log('Laravel through key:', e.laravel_through_key);
            
            let details = '';
            let detailsData = [];
            let kapasitas, serumh, serum, serumc, clotact;
            let processTime = '';

            const checkInSpesimen = history.find(h => h.status === 'Check in spesiment');
            let noteFromCollection = null;
            let noteFromHandling = null;

            if (e.tabung === 'K3-EDTA') {
                const collectionItem = scollection.find(item => item.no_lab === e.laravel_through_key && item.tabung === 'K3-EDTA');
                if (collectionItem) {
                    detailsData = collectionItem.details ? collectionItem.details.filter(detail =>
                        e.details.some(spesimenDetail => spesimenDetail.id === detail.id)
                    ) : [];
                    kapasitas = collectionItem.kapasitas;
                    noteFromCollection = collectionItem.note;
                }
            } else if (e.tabung === 'CLOTH-ACTIVATOR') {
                // console.log('--- DEBUGGING CLOTH-ACTIVATOR ---');
                // Coba cari dengan nama CLOTH-ACTIVATOR dulu
                let collectionItem = scollection.find(item =>
                    item.no_lab === e.laravel_through_key && item.tabung === 'CLOTH-ACTIVATOR'
                );
                
                // Jika tidak ada, cari dengan nama EDTA (karena di database kemungkinan tersimpan sebagai EDTA)
                if (!collectionItem) {
                    // console.log('CLOTH-ACTIVATOR not found, trying EDTA...');
                    collectionItem = scollection.find(item =>
                        item.no_lab === e.laravel_through_key && item.tabung === 'EDTA'
                    );
                }
                
                // console.log('CLOTH-ACTIVATOR collectionItem:', collectionItem);
                
                if (collectionItem) {
                    detailsData = collectionItem.details ? collectionItem.details.filter(detail =>
                        e.details.some(spesimenDetail => spesimenDetail.id === detail.id)
                    ) : [];
                    serumh = collectionItem.serumh;
                    noteFromCollection = collectionItem.note;
                    
                    // console.log('CLOTH-ACTIVATOR serumh value:', serumh, 'type:', typeof serumh);
                    // console.log('CLOTH-ACTIVATOR noteFromCollection:', noteFromCollection);
                    // console.log('CLOTH-ACTIVATOR detailsData:', detailsData);
                } else {
                    // console.log('CLOTH-ACTIVATOR collectionItem not found');
                }
            } else if (e.tabung === 'CLOTH-ACT') {
                // console.log('--- DEBUGGING CLOTH-ACT ---');
                // console.log('Searching for scollection with no_lab:', e.laravel_through_key);
                // console.log('All scollection items:', scollection);
                
                // Coba cari dengan nama CLOTH-ACT
                let collectionItem = scollection.find(item => 
                    item.no_lab === e.laravel_through_key && item.tabung === 'CLOTH-ACT'
                );
                
                // console.log('CLOTH-ACT with tabung filter:', collectionItem);
                
                // Jika tidak ditemukan, coba cari tanpa filter tabung dan ambil yang punya clotact
                if (!collectionItem) {
                    // console.log('CLOTH-ACT not found with tabung filter, trying without filter...');
                    const allItems = scollection.filter(item => item.no_lab === e.laravel_through_key);
                    // console.log('All items with matching no_lab:', allItems);
                    
                    // Cari item yang punya field clotact
                    collectionItem = allItems.find(item => item.clotact);
                    // console.log('Found item with clotact:', collectionItem);
                }
                
                if (collectionItem) {
                    // Jika details ada, filter berdasarkan specimen details
                    if (collectionItem.details && collectionItem.details.length > 0) {
                        detailsData = collectionItem.details.filter(detail =>
                            e.details.some(spesimenDetail => spesimenDetail.id === detail.id)
                        );
                    } else {
                        // Fallback: jika collection.details kosong, gunakan semua details dari specimen
                        // console.log('CLOTH-ACT collectionItem.details is empty, using specimen details as fallback');
                        detailsData = e.details;
                    }
                    
                    clotact = collectionItem.clotact;
                    noteFromCollection = collectionItem.note;
                    
                    // console.log('CLOTH-ACT clotact value:', clotact, 'type:', typeof clotact);
                    // console.log('CLOTH-ACT noteFromCollection:', noteFromCollection);
                    // console.log('CLOTH-ACT detailsData:', detailsData);
                } else {
                    // console.log('CLOTH-ACT collectionItem NOT FOUND after all attempts');
                }
            } else if (e.tabung === 'CLOT-ACT') {
                const handlingItem = shandling.find(item => item.no_lab === e.laravel_through_key && item.tabung === 'CLOT-ACT');
                if (handlingItem) {
                    detailsData = handlingItem.details ? handlingItem.details.filter(detail =>
                        e.details.some(spesimenDetail => spesimenDetail.id === detail.id)
                    ) : [];
                    serum = handlingItem.serum;
                    noteFromHandling = handlingItem.note;
                }
            } else if (e.tabung === 'CLOT-') {
                const handlingItem = shandling.find(item => item.no_lab === e.laravel_through_key && item.tabung === 'CLOT');
                if (handlingItem) {
                    detailsData = handlingItem.details ? handlingItem.details.filter(detail =>
                        e.details.some(spesimenDetail => spesimenDetail.id === detail.id)
                    ) : [];
                    serum = handlingItem.serum;
                    noteFromHandling = handlingItem.note;
                }
            }

            if (e.details && e.details.length > 0) {
                details = `<div class="detail-container col-12 col-md-6">`;
                e.details.forEach(detail => {
                    // console.log('--- Processing Detail ---');
                    // console.log('Detail ID:', detail.id, 'type:', typeof detail.id);
                    
                    const imageUrl = `/gambar/${detail.gambar}`;
                    let isChecked = '';
                    let isDisabled = 'disabled';

                    // Untuk CLOTH-ACT, gunakan fallback logic jika detailsData kosong tapi ada clotact
                    let matchedDetail = detailsData.find(d => d.id === detail.id);
                    let shouldCheck = false;
                    
                    // console.log('Matched detail for', e.tabung, ':', matchedDetail);
                    
                    // Perbaikan logic: untuk CLOTH-ACT, jika ada clotact maka enable checking
                    if (matchedDetail || (e.tabung === 'CLOTH-ACT' && clotact)) {
                        // console.log(`Checking conditions for ${e.tabung}...`);
                        
                        if (e.tabung === 'K3-EDTA' && parseInt(kapasitas) === detail.id) {
                            shouldCheck = true;
                            // console.log('K3-EDTA should be checked');
                        } else if (e.tabung === 'CLOTH-ACTIVATOR' && parseInt(serumh) === detail.id) {
                            shouldCheck = true;
                            // console.log(`CLOTH-ACTIVATOR should be checked - serumh: ${serumh}, detail.id: ${detail.id}`);
                        } else if (e.tabung === 'CLOTH-ACT' && parseInt(clotact) === detail.id) {
                            shouldCheck = true;
                            // console.log(`CLOTH-ACT should be checked - clotact: ${clotact}, detail.id: ${detail.id}`);
                        } else if (e.tabung === 'CLOT-ACT' && parseInt(serum) === detail.id) {
                            shouldCheck = true;
                            // console.log('CLOT-ACT should be checked');
                        } else if (e.tabung === 'CLOT-' && parseInt(serum) === detail.id) {
                            shouldCheck = true;
                            // console.log('CLOT- should be checked');
                        }

                        if (shouldCheck) {
                            isChecked = 'checked';
                            isDisabled = '';
                            // console.log(`${e.tabung} final state: CHECKED`);
                        }
                    } else {
                        // console.log(`${e.tabung} - no match found or no required value`);
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
            } else if (e.tabung === 'CLOTH-ACTIVATOR') {
                subtext = '<div class="subtext">Serum</div>';
            } else if (e.tabung === 'CLOTH-ACT') {
                subtext = '<div class="subtext">Serum</div>';
            } else if (e.tabung === 'CLOT-ACT') {
                title = '<h5 class="title mt-3">Spesiment Handlings</h5> <hr>';
                subtext = '<div class="subtext">Serum</div>';
            }

            let note = '';
            if (e.tabung === 'K3-EDTA' || e.tabung === 'CLOTH-ACTIVATOR' || e.tabung === 'CLOTH-ACT' || e.tabung === 'CLOT-ACT' || e.tabung === 'CLOT-') {
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
                                `<textarea class="form-control" name="note[]" row="3" placeholder="${noteFromCollection || 'No note available'}" ${noteFromCollection ? '' : 'disabled'} disabled></textarea>` : ''}
                            ${e.tabung === 'CLOTH-ACTIVATOR' ? 
                                `<textarea class="form-control" name="note[]" row="3" placeholder="${noteFromCollection || 'No note available'}" ${noteFromCollection ? '' : 'disabled'} disabled></textarea>` : ''}
                            ${e.tabung === 'CLOTH-ACT' ? 
                                `<textarea class="form-control" name="note[]" row="3" placeholder="${noteFromCollection || 'No note available'}" ${noteFromCollection ? '' : 'disabled'}></textarea>` : ''}
                            ${e.tabung === 'CLOT-ACT' ? 
                                `<textarea class="form-control" name="note[]" row="3" placeholder="${noteFromHandling || 'No note available'}" ${noteFromHandling ? '' : 'disabled'}></textarea>` : ''}
                            ${e.tabung === 'CLOT-' ? 
                                `<textarea class="form-control" name="note[]" row="3" placeholder="${noteFromHandling || 'No note available'}" ${noteFromHandling ? '' : 'disabled'}></textarea>` : ''}
                        </div>
                    </div>
                </div>
            </div>
        `;

            // console.log('=== End Processing Specimen ===\n');
        });

            if (historyItem && historyItem.note) {
                accordionContent += `
            <div class="col-lg-12">
                <label class="fw-bold mt-2">Note</label>
                <textarea id="noteTextarea" class="form-control" row="3" placeholder="${historyItem.note}" disabled></textarea>
            </div>
        `;
            }

            accordion.innerHTML = accordionContent;
        }

        });
        });
    </script>

    <script></script>



    <script src="{{ asset('../js/ak.js') }}"></script>
@endpush