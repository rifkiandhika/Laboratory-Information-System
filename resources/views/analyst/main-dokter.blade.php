@extends('master')
@section('title', 'Dashboard Dokter')
@section('content')
<style>
  .radio-container {
            display: flex;
            justify-content: space-around;
            align-items: flex-end;
        }

        .radio-container div {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .bar {
            width: 40px;
            height: 100px;
            margin-bottom: 5px;
            background-color: #e0e0e0;
            position: relative;
            border-radius: 4px;
        }

        .bar.low::before {
            content: '';
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 30%;
            background-color: #ff6b6b;
            border-radius: 4px 4px 0 0;
        }

        .bar.normal::before {
            content: '';
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 60%;
            background-color: #f6d55c;
            border-radius: 4px 4px 0 0;
        }

        .bar.high::before {
            content: '';
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 70%;
            background-color: #4ecdc4;
            border-radius: 4px 4px 0 0;
        }

        .accordion .card-header {
            padding: 0.75rem 1.25rem;
        }

        .accordion .btn {
            text-align: left;
            width: 100%;
        }
</style>
<div class="content" id="scroll-content">
    <div class="container-fluid">
      <!-- Page Heading -->
      <div class="d-sm-flex  mt-3">
        <h1 class="h3 mb-0 text-gray-600">Dashboard</h1>
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
                  <input type="checkbox" id="checkbox-rect1" name="check-it">
                  <label for="checkbox-rect1">Select All</label>
                </div>
              </div>
              <div class="table-scroll table-pasien" style="width: 100%; overflow-y: scroll; max-height: 650px;">
                <table class="table table-striped tabel-pasien" style="font-size: 12px;">
                  <thead>
                    <tr>
                      <th scope="col"><i class="bx bx-check" style="font-size: 18px;"></i></th>
                      <th scope="col">No LAB</th>
                      <th scope="col">Nama</th>
                      <th scope="col">Cito</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row"><input type="checkbox" name="pilih" style="margin-top: 3px;"></th>
                      <td>LAB01234</td>
                      <td>John China</td>
                      <td><i class='bx bxs-bell-ring text-danger' style="font-size: 20px;"></i></td>
                    </tr>
                    <tr>
                      <th scope="row"><input type="checkbox" name="pilih" style="margin-top: 3px;"></th>
                      <td>LAB01234</td>
                      <td>John China</td>
                      <td><i class='bx bxs-bell-ring text-danger' style="font-size: 20px;"></i></td>
                    </tr>
                    <tr>
                      <th scope="row"><input type="checkbox" name="pilih" style="margin-top: 3px;"></th>
                      <td>LAB01234</td>
                      <td>John China</td>
                      <td><i class='bx bxs-bell-ring text-danger' style="font-size: 20px;"></i></td>
                    </tr>
                    <tr>
                      <th scope="row"><input type="checkbox" name="pilih" style="margin-top: 3px;"></th>
                      <td>LAB01234</td>
                      <td>John China</td>
                      <td><i class='bx bxs-bell-ring text-danger' style="font-size: 20px;"></i></td>
                    </tr>
                    <tr>
                      <th scope="row"><input type="checkbox" name="pilih" style="margin-top: 3px;"></th>
                      <td>LAB01234</td>
                      <td>John China</td>
                      <td><i class='bx bxs-bell-ring text-secondary' style="font-size: 20px;"></i></td>
                    </tr>
                    <tr>
                      <th scope="row"><input type="checkbox" name="pilih" style="margin-top: 3px;"></th>
                      <td>LAB01234</td>
                      <td>John China</td>
                      <td><i class='bx bxs-bell-ring text-danger' style="font-size: 20px;"></i></td>
                    </tr>
                    <tr>
                      <th scope="row"><input type="checkbox" name="pilih" style="margin-top: 3px;"></th>
                      <td>LAB01234</td>
                      <td>John China</td>
                      <td><i class='bx bxs-bell-ring text-secondary' style="font-size: 20px;"></i></td>
                    </tr>
                    <tr>
                      <th scope="row"><input type="checkbox" name="pilih" style="margin-top: 3px;"></th>
                      <td>LAB01234</td>
                      <td>John China</td>
                      <td><i class='bx bxs-bell-ring text-secondary' style="font-size: 20px;"></i></td>
                    </tr>
                    <tr>
                      <th scope="row"><input type="checkbox" name="pilih" style="margin-top: 3px;"></th>
                      <td>LAB01234</td>
                      <td>John China</td>
                      <td><i class='bx bxs-bell-ring text-secondary' style="font-size: 20px;"></i></td>
                    </tr>
                    <tr>
                      <th scope="row"><input type="checkbox" name="pilih" style="margin-top: 3px;"></th>
                      <td>LAB01234</td>
                      <td>John China</td>
                      <td><i class='bx bxs-bell-ring text-secondary' style="font-size: 20px;"></i></td>
                    </tr>
                    <tr>
                      <th scope="row"><input type="checkbox" name="pilih" style="margin-top: 3px;"></th>
                      <td>LAB01234</td>
                      <td>John China</td>
                      <td><i class='bx bxs-bell-ring text-secondary' style="font-size: 20px;"></i></td>
                    </tr>
                    <tr>
                      <th scope="row"><input type="checkbox" name="pilih" style="margin-top: 3px;"></th>
                      <td>LAB01234</td>
                      <td>John China</td>
                      <td><i class='bx bxs-bell-ring text-secondary' style="font-size: 20px;"></i></td>
                    </tr>
                    <tr>
                      <th scope="row"><input type="checkbox" name="pilih" style="margin-top: 3px;"></th>
                      <td>LAB01234</td>
                      <td>John China</td>
                      <td><i class='bx bxs-bell-ring text-secondary' style="font-size: 20px;"></i></td>
                    </tr>
                  </tbody>
                  </table>
                </div>
            </div>
          </div>
        </div>

        <div class="col-xl-9 col-lg-9">
          <div class="card shadow mb-4">
            <div class="card-body table-pasien" style="width: 100%; overflow-y: scroll; max-height: 770px;">
              <div class="d-flex justify-content-between mx-3">
                <div class="">
                  <div class="row" style="margin-bottom: -5px;">
                    <label for="staticEmail" class="col-sm-5 col-form-label font-weight-bold">Cito</label>
                    <div class="col-lg-6"">
                      <i class='bx bxs-bell-ring mt-2 ml-1 text-danger' style="font-size: 23px;"></i>
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: -10px;">
                    <label for="staticEmail" class="col-sm-5 col-form-label font-weight-bold">No LAB</label>
                    <div class="col-lg-6"">
                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": 0341">
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: -10px;">
                    <label for="staticEmail" class="col-sm-5 col-form-label font-weight-bold">No RM</label>
                    <div class="col-lg-6"">
                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": 12345">
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: -10px;">
                    <label for="staticEmail" class="col-sm-5 col-form-label font-weight-bold">Nama</label>
                    <div class="col-lg-6"">
                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": John China">
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: -10px;">
                    <label for="staticEmail" class="col-sm-5 col-form-label font-weight-bold">Ruangan</label>
                    <div class="col-lg-6"">
                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": Abu Thalib">
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: -10px;">
                    <label for="staticEmail" class="col-lg-5 col-form-label font-weight-bold">Tanggal Lahir Usia</label>
                    <div class="col-lg-6">
                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": 19-12-1966, 46th">
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
              </div>
              <hr>
              <div class="row">
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
              </div>
              <div class="row">
                <div class="table-scroll table-pasien p-3" style="width: 100%;">
                  <table class="table" style="font-size: 14px;">
                    <thead>
                      <tr>
                        <th scope="col">Parameter</th>
                        <th scope="col">Hasil</th>
                        <th scope="col">D 1</th>
                        <th scope="col">D 2</th>
                        <th scope="col">Flag</th>
                        <th scope="col">Satuan</th>
                        <th scope="col">Range</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="mt-2">
                        <th scope="row">Darah Lengkap</th>
                      </tr>
                      <tr class="">
                        <td scope="row" class="col-4">Leukosit</td>
                        <td><input type="text" class="col-5 input-detail justify-content-center" readonly value="123"></td>
                        <td><input type="text" class="col-5 input-detail" readonly value="123"></td>
                        <td><input type="text" class="col-5 input-detail" readonly value="123"></td>
                        <td></td>
                        <td class="text-center">%</td>
                        <td class="text-center">1-10</td>
                      </tr>
                      <tr>
                        <td scope="row">Eritrosit</td>
                        <td><input type="text" class="col-5 input-detail" readonly value="123"></td>
                        <td><input type="text" class="col-5 input-detail" readonly value="123"></td>
                        <td><input type="text" class="col-5 input-detail" readonly value="123"></td>
                        <td></td>
                        <td class="text-center">%</td>
                        <td class="text-center">1-10</td>
                      </tr>
                      <tr>
                        <td scope="row">Hemoglobin</td>
                        <td><input type="text" class="col-5 input-detail" readonly value="123"></td>
                        <td><input type="text" class="col-5 input-detail" readonly value="123"></td>
                        <td><input type="text" class="col-5 input-detail" readonly value="123"></td>
                        <td></td>
                        <td class="text-center">%</td>
                        <td class="text-center">1-10</td>
                      </tr>
                      <tr class="mt-2">
                        <th scope="row">Kimia Klinik</th>
                      </tr>
                      <tr class="">
                        <td scope="row" class="col-4">Creatinin</td>
                        <td><input type="text" class="col-5 input-detail justify-content-center" readonly value="123"></td>
                        <td><input type="text" class="col-5 input-detail" readonly value="123"></td>
                        <td><input type="text" class="col-5 input-detail" readonly value="123"></td>
                        <td></td>
                        <td class="text-center">mg/dL</td>
                        <td class="text-center">1-10</td>
                      </tr>
                      <tr>
                        <td scope="row">Urea (Bun)</td>
                        <td><input type="text" class="col-5 input-detail" readonly value="123"></td>
                        <td><input type="text" class="col-5 input-detail" readonly value="123"></td>
                        <td><input type="text" class="col-5 input-detail" readonly value="123"></td>
                        <td></td>
                        <td class="text-center">mg/dL</td>
                        <td class="text-center">1-10</td>
                      </tr>
                      <tr class="mt-2">
                        <th scope="row">Kimia Klinik</th>
                      </tr>
                      <tr class="">
                        <td scope="row" class="col-4">Creatinin</td>
                        <td><input type="text" class="col-5 input-detail justify-content-center" readonly value="123"></td>
                        <td><input type="text" class="col-5 input-detail" readonly value="123"></td>
                        <td><input type="text" class="col-5 input-detail" readonly value="123"></td>
                        <td></td>
                        <td class="text-center">mg/dL</td>
                        <td class="text-center">1-10</td>
                      </tr>
                      <tr>
                        <td scope="row">Urea (Bun)</td>
                        <td><input type="text" class="col-5 input-detail" readonly value="123"></td>
                        <td><input type="text" class="col-5 input-detail" readonly value="123"></td>
                        <td><input type="text" class="col-5 input-detail" readonly value="123"></td>
                        <td></td>
                        <td class="text-center">mg/dL</td>
                        <td class="text-center">1-10</td>
                      </tr>
                    </tbody>
                    </table>
                  </div>
              </div>
              <div class="row mt-3">
                <div class="col-lg-6">
                  <button type="button" class="btn btn-outline-teal btn-block">Back To Analyst</button>
                </div>
                <div class="col-lg-6">
                  <button type="button" class="btn btn-outline-primary btn-block">Verifikasi Dokter PK</button>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
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
  </script>
@endsection
@section('modal')
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

  <script src="{{ asset('../js/ak.js') }}"></script>
@endsection
