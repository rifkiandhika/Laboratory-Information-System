@extends('layouts.admin')
@section('title', 'Worklist')

@section('content')
<link rel="stylesheet" href="{{ asset('css/timeline.css') }}">
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
                    <input style="cursor: pointer" class="form-check-input" type="checkbox" id="checkbox-rect1" name="check-it">
                    <label for="checkbox-rect1">Select All</label>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" style="font-size: 12px;">
                    <thead>
                        <tr>
                        <th scope="col"><i class="ti ti-checkbox" style="font-size: 18px;"></i></th>
                        <th scope="col">No LAB</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Cito</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $dataPasienCito as $dpc )
                            <tr>
                                
                                <th scope="row"><input class="form-check-input mt-2" style="font-size: 15px; cursor: pointer;" type="checkbox"  name="pilih"></th>
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
                        @foreach ( $dataPasien as $dp )
                            <tr>
                                <th scope="row"><input class="form-check-input mt-2" style="font-size: 15px; cursor: pointer;" type="checkbox"  name="pilih"></th>
                                <td><a href="#" class="preview" data-id={{ $dp->id }}>{{ $dp->no_lab }}</a></td>
                                <td>{{ $dp->nama }}</td>
                                <td>
                                    <td class="text-center">
                                        <i class='ti ti-bell-filled mt-2 ml-1 {{ $dp->cito == '1' ? 'text-danger' : 'text-secondary' }}'
                                            style="font-size: 23px;"></i>
                                    </td>
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
                    <div class="text-center bg-body-tertiary"><p>Pilih Pasien</p></div>
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

                        populateModal(spesimen, scollection, shandling, history, data_pemeriksaan_pasien);

                        const timelineItems = history.map(h => {
                            const waktu = new Date(h.waktu_proses);
                            const waktuFormatted = waktu.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                            return `
                                <div class="timeline-item w-100">
                                    <div class="timeline-item-marker">
                                        <div class="timeline-item-marker-text">${waktuFormatted}</div>
                                        <div class="timeline-item-marker-indicator clear text-white"><i class="ti ti-check"></i></div>
                                    </div>
                                    <div class="timeline-item-content">${h.proses}</div>
                                </div>
                            `;
                        }).join('');


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
                                    <label class="col-5 col-form-label font-bold">Cito</label>
                                    <div class="col-7">
                                    : <i class='ti ti-bell-filled text-danger' style="font-size: 23px;"></i>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label class="col-5 col-form-label font-bold">No LAB</label>
                                    <div class="col-7">
                                        <input type="text" readonly class="form-control-plaintext" value=": ${data_pasien.no_lab}">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label class="col-5 col-form-label font-bold">No RM</label>
                                    <div class="col-7">
                                        <input type="text" readonly class="form-control-plaintext" value=": ${data_pasien.no_rm}">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label class="col-5 col-form-label font-bold">Nama</label>
                                    <div class="col-7">
                                        <input type="text" readonly class="form-control-plaintext" value=": ${data_pasien.nama}">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label class="col-5 col-form-label font-bold">Ruangan</label>
                                    <div class="col-7">
                                        <input type="text" readonly class="form-control-plaintext" value=": ${data_pasien.asal_ruangan}">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label class="col-5 col-form-label font-bold">Tanggal Lahir Usia</label>
                                    <div class="col-7">
                                        <input type="text" readonly class="form-control-plaintext" value=": ${data_pasien.lahir} Tahun">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <label class="col-5 col-form-label font-bold">Dokter</label>
                                    <div class="col-7">
                                        <input type="text" readonly class="form-control-plaintext" value=": ${data_pasien.dokter.nama_dokter}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6 col-sm-12">
                                <!-- Right Column - Timeline -->
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

                        detailContent += getButtonContent(data_pasien);
                        detailContent += getTableContent(data_pemeriksaan_pasien, data_pasien, hasil);

                        previewDataPasien.innerHTML = detailContent;

                        // loader.style.display = 'none';
                        loader.hide();
                        
                        const manualButton = document.getElementById('manualButton');
                        const manualInput = document.querySelectorAll('#manualInput');

                        manualButton.addEventListener('click', () => {
                            manualInput.forEach(input => {
                                input.readOnly = false;
                                input.classList.remove('readonly-input');
                                input.focus(); // Optional: Focus on the first input
                            });
                        });
                        // Populate modal with accordion content
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
                        <div class="col-5 col-lg-3">
                            <button type="button" id="manualButton" class="btn btn-outline-secondary btn-block">Manual</button>
                        </div>
                        <div class="col-lg-3">
                            <button type="button" class="btn btn-outline-primary btn-block">Duplo</button>
                        </div>
                        <div class="col-lg-3">
                            <button type="button" class="btn btn-outline-info btn-block" data-bs-toggle="modal" data-bs-target="#sampleHistoryModal">Sample History</button>
                        </div>
                        <div class="col-lg-3">
                            <form id="delete-form-${data_pasien.id}"
                                action="analyst/worklist/${data_pasien.id}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                                                    
                            <button class="btn btn-outline-danger"
                                onclick="confirmDelete(${data_pasien.id})">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
                <hr>
            `;
        }

        function getTableContent(data_pemeriksaan_pasien, data_pasien, hasil) {
            return `
            <form action="{{ route('worklist.store') }}" method="POST">
                @csrf
                <input type="hidden" name="no_lab" value="${data_pasien.no_lab}">
                <input type="hidden" name="no_rm" value="${data_pasien.no_rm}">
                <input type="hidden" name="nama" value="${data_pasien.nama}">
                <input type="hidden" name="ruangan" value="${data_pasien.asal_ruangan}">
                <input type="hidden" name="nama_dokter" value="${data_pasien.dokter.nama_dokter}">

                <table class="table" id="worklistTable">
                    <thead>
                        <tr scope="row">
                            <th class="col-3">Parameter</th>
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
                                ${e.pasiens.map(p => {
                                    const hasilItem = hasil.find(item => item.nama_pemeriksaan === p.data_pemeriksaan.nama_pemeriksaan);
                                    const rowId = p.data_pemeriksaan.id;

                                 return `
                                <tr class="mt-2" data-id="${rowId}">
                                    <td>${p.data_pemeriksaan.nama_pemeriksaan}</td>
                                    <input type="hidden" name="nama_pemeriksaan[]" value="${p.data_pemeriksaan.nama_pemeriksaan}" />
                                    <td><input type="text" name="hasil[]" id="manualInput" class="form-control text-center w-50 p-0 readonly-input" value="${hasilItem ? hasilItem.hasil : ''}" readonly/></td>
                                    <td><input type="number" name="duplo" class="form-control w-50 p-0" readonly /></td>
                                    <td><input type="number" class="form-control w-50 p-0" readonly/></td>
                                    <td><input type="hidden" class="form-control w-50 p-0" readonly/></td>
                                    <td class="text-center"><input type="hidden" name="satuan[]" class="form-control w-50 p-0" value="${p.data_pemeriksaan.nilai_satuan}" readonly/>${p.data_pemeriksaan.nilai_satuan}</td>
                                    <td><input type="hidden" name="range[]" class="form-control w-50 p-0" value="1-10" readonly/>1-10</td>
                                </tr>
                                `;
                                }).join('')}
                            `).join('')}
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-lg-6">
                        <button type="submit" class="btn btn-outline-info btn-block">Verifikasi Hasil</button>
                    </div>
            </form>      
                    <div class="col-lg-6">
                        <form action="worklist/checkin/${data_pasien.id}" method="POST">
                            @csrf
                            <button type="submit" id="verifikasiDokterPKButton" class="btn btn-outline-primary btn-block">Verifikasi Dokter PK</button>
                        </form>
                    </div>
                </div>
            `;
        }

        function populateModal(spesimen, scollection, shandling, history, data_pemeriksaan_pasien) {
            const accordion = document.getElementById('sampleHistoryAccordion');
            let accordionContent = '';

            spesimen.forEach(e => {
                let details = '';
                let detailsData = [];
                let kapasitas, serumh, serum;
                let processTime = '';

                const checkInSpesimen = history.find(h => h.status === 'Check in spesiment');
                if (checkInSpesimen) {
                    processTime = checkInSpesimen.waktu_proses; // Assuming waktu_proses contains the process time
                }

                if (e.tabung === 'EDTA') {
                const collectionItem = scollection.find(item => item.no_lab === e.laravel_through_key);
                if (collectionItem) {
                    detailsData = collectionItem.details || [];
                    kapasitas = collectionItem.kapasitas;
                }
                }else if (e.tabung === 'CLOTH-ACT') {
                    const collectionItem = scollection.find(item => item.id === e.id);
                    if (collectionItem) {
                        detailsData = collectionItem.details || [];
                        serumh = collectionItem.serumh;
                    }

                }else if (e.tabung === 'CLOT-ACT') {
                    const handlingItem = shandling.find(item => item.no_lab === e.laravel_through_key);
                    if (handlingItem) {
                        detailsData = handlingItem.details || [];
                        serum = handlingItem.serum;
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
                            if (e.tabung === 'EDTA' && kapasitas == detail.id) {
                                isChecked = 'checked';
                                isDisabled = '';
                            } else if (e.tabung === 'CLOTH-ACT' && serumh == detail.id) {
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
                let detail = '';
                let subtext = '';
                if (e.tabung === 'EDTA') {
                    detail = `<h5 class="title">Detail Sampling</h5><hr>`
                    title = '<h5 class="title">Spesiment Collection</h5> <hr>';
                } else if (e.spesiment === 'Spesiment Collection') {
                    subtext = '<div class="subtext">Serum</div>';
                } else if (e.spesiment === 'Spesiment Handlings') {
                    title = '<h5>Spesiment Handlings</h5> <hr>';
                    subtext = '<div class="subtext">Serum</div>';
                }
                
                let note = '';
                if (e.tabung === 'EDTA' || e.tabung === 'CLOT-ACT', 'CLOTH-ACT') {
                        note = '<p class="mb-0"><strong>Note</strong></p>';
                    }
                accordionContent += `${detail} ${title}
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
                                    ${e.tabung === 'EDTA' ? `<textarea class="form-control" name="note[]" row="3" placeholder="Write a note here"></textarea>` : ''}
                                    ${e.tabung === 'CLOTH-ACT' ? `<textarea class="form-control" name="note[]" row="3" placeholder="Write a note here"></textarea>` : ''}
                                    ${e.tabung === 'CLOT-ACT' ? `<textarea class="form-control" name="note[]" row="3" placeholder="Write a note here"></textarea>` : ''}
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            accordion.innerHTML = accordionContent;

        }
    });
    });
</script>

<script>
    

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
