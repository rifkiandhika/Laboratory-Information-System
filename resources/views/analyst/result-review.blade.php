@extends('master')
@section('title', 'Result Review')
@section('content')
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
                  <form class="form-inline">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success btn-sm my-2 my-sm-0" type="submit">Search</button>
                  </form>
                </div>
                <div class="table-scroll table-pasien" style="overflow-y: scroll; max-height: 595px;">
                <table class="table table-striped tabel-pasien" style="font-size: 12px;">
                  <thead>
                    <tr>
                      <th scope="col">No</th>
                      <th scope="col">Tanggal Order</th>
                      <th scope="col">No RM</th>
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
                    <tr>
                      <th scope="row">1</th>
                      <td>12-12-12/ 13.30</td>
                      <td>01.01.02</td>
                      <td>LAB123442</td>
                      <td>Jeff Hardi</td>
                      <td>KIA</td>
                      <td><i class='bx bxs-bell-ring mt-2 ml-1 text-danger' style="font-size: 23px;"></i></td>
                      <td>20 tahun</td>
                      <td>Jl. Latar Candi Indonesia Barat 1312</td>
                      <td><span class="badge bg-danger text-white">Belum Dilayani</span></td>
                      <td class="">
                        <button href="#" class="btn btn-sm btn-outline-warning mr-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Sample History</button>
                        <button href="#" class="btn btn-sm btn-outline-primary ">Print Result</button>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">2</th>
                      <td>12-12-12/ 13.30</td>
                      <td>01.01.04</td>
                      <td>LAB123432</td>
                      <td>Dediyanto Iskandar</td>
                      <td>Umum</td>
                      <td><i class='bx bxs-bell-ring mt-2 ml-1 text-secondary' style="font-size: 23px;"></i></td>
                      <td>34 tahun</td>
                      <td>Jl. Latar Candi Indonesia Barat 1312</td>
                      <td><span class="badge bg-danger text-white">Belum Dilayani</span></td>
                      <td class="">
                        <button href="#" class="btn btn-sm btn-outline-warning mr-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Sample History</button>
                        <button href="#" class="btn btn-sm btn-outline-primary ">Print Result</button>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">3</th>
                      <td>12-12-12/ 13.30</td>
                      <td>01.01.04</td>
                      <td>LAB123421</td>
                      <td>Undertaker</td>
                      <td>IGD</td>
                      <td><i class='bx bxs-bell-ring mt-2 ml-1 text-secondary' style="font-size: 23px;"></i></td>
                      <td>31 tahun</td>
                      <td>Jl. Latar Candi Indonesia Barat 1312</td>
                      <td><span class="badge bg-danger text-white">Belum Dilayani</span></td>
                      <td class="">
                        <button href="#" class="btn btn-sm btn-outline-warning mr-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Sample History</button>
                        <button href="#" class="btn btn-sm btn-outline-primary ">Print Result</button>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">4</th>
                      <td>12-12-12/ 13.30</td>
                      <td>01.01.02</td>
                      <td>LAB123442</td>
                      <td>John China</td>
                      <td>Mawar</td>
                      <td><i class='bx bxs-bell-ring mt-2 ml-1 text-danger' style="font-size: 23px;"></i></td>
                      <td>44 tahun</td>
                      <td>Jl. Latar Candi Indonesia Barat 1312</td>
                      <td><span class="badge bg-danger text-white">Belum Dilayani</span></td>
                      <td class="">
                        <button href="#" class="btn btn-sm btn-outline-warning mr-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Sample History</button>
                        <button href="#" class="btn btn-sm btn-outline-primary ">Print Result</button>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">5</th>
                      <td>12-12-12/ 13.30</td>
                      <td>01.01.04</td>
                      <td>LAB123421</td>
                      <td>Undertaker</td>
                      <td>IGD</td>
                      <td><i class='bx bxs-bell-ring mt-2 ml-1 text-secondary' style="font-size: 23px;"></i></td>
                      <td>31 tahun</td>
                      <td>Jl. Latar Candi Indonesia Barat 1312</td>
                      <td><span class="badge bg-danger text-white">Belum Dilayani</span></td>
                      <td class="">
                        <button href="#" class="btn btn-sm btn-outline-warning mr-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Sample History</button>
                        <button href="#" class="btn btn-sm btn-outline-primary ">Print Result</button>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">6</th>
                      <td>12-12-12/ 13.30</td>
                      <td>01.01.04</td>
                      <td>LAB123421</td>
                      <td>Undertaker</td>
                      <td>IGD</td>
                      <td><i class='bx bxs-bell-ring mt-2 ml-1 text-secondary' style="font-size: 23px;"></i></td>
                      <td>31 tahun</td>
                      <td>Jl. Latar Candi Indonesia Barat 1312</td>
                      <td><span class="badge bg-danger text-white">Belum Dilayani</span></td>
                      <td class="">
                        <button href="#" class="btn btn-sm btn-outline-warning mr-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Sample History</button>
                        <button href="#" class="btn btn-sm btn-outline-primary ">Print Result</button>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">7</th>
                      <td>12-12-12/ 13.30</td>
                      <td>01.01.04</td>
                      <td>LAB123421</td>
                      <td>Undertaker</td>
                      <td>IGD</td>
                      <td><i class='bx bxs-bell-ring mt-2 ml-1 text-secondary' style="font-size: 23px;"></i></td>
                      <td>31 tahun</td>
                      <td>Jl. Latar Candi Indonesia Barat 1312</td>
                      <td><span class="badge bg-danger text-white">Belum Dilayani</span></td>
                      <td class="">
                        <button href="#" class="btn btn-sm btn-outline-warning mr-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Sample History</button>
                        <button href="#" class="btn btn-sm btn-outline-primary ">Print Result</button>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">8</th>
                      <td>12-12-12/ 13.30</td>
                      <td>01.01.04</td>
                      <td>LAB123421</td>
                      <td>Undertaker</td>
                      <td>IGD</td>
                      <td><i class='bx bxs-bell-ring mt-2 ml-1 text-secondary' style="font-size: 23px;"></i></td>
                      <td>31 tahun</td>
                      <td>Jl. Latar Candi Indonesia Barat 1312</td>
                      <td><span class="badge bg-warning text-white">Diproses</span></td>
                      <td class="">
                        <button href="#" class="btn btn-sm btn-outline-warning mr-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Sample History</button>
                        <button href="#" class="btn btn-sm btn-outline-primary ">Print Result</button>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">9</th>
                      <td>12-12-12/ 13.30</td>
                      <td>01.01.04</td>
                      <td>LAB123421</td>
                      <td>Undertaker</td>
                      <td>IGD</td>
                      <td><i class='bx bxs-bell-ring mt-2 ml-1 text-secondary' style="font-size: 23px;"></i></td>
                      <td>31 tahun</td>
                      <td>Jl. Latar Candi Indonesia Barat 1312</td>
                      <td><span class="badge bg-success text-white">Dilayani</span></td>
                      <td class="">
                        <button href="#" class="btn btn-sm btn-outline-warning mr-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Sample History</button>
                        <button href="#" class="btn btn-sm btn-outline-primary ">Print Result</button>
                      </td>
                    </tr>
                  </tbody>
                  </table>
                </div>
              </div>
          </div>
      </div>
      </div>
    </div>

  </div>
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
