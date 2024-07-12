@extends('master')

@section('title', 'Dashboard Main Lab')

@section('content')
<div class="content" id="scroll-content">
    <div class="container-fluid">
      <!-- Page Heading -->
      <div class="d-sm-flex  mt-3">
        <h1 class="h3 mb-0 text-gray-600">Dashboard</h1>
      </div>

      <!-- Content Row -->
      <div class="row mt-3">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Pasien Masuk (Harian)</div>
                            <div class="h3 mt-3 font-weight-bold text-gray-600">150</div>
                        </div>
                        <div class="col-auto">
                            <i class="bx bx-chart fa-3x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pasien Belum Dilayani</div>
                            <div class="h3 mt-3 font-weight-bold text-gray-600">10</div>
                        </div>
                        <div class="col-auto">
                            <i class="bx bx-info-circle fa-3x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pasien Telah Dilayani
                            </div>
                            <div class="h3 mt-3 font-weight-bold text-gray-600">250</div>
                            <!-- <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="col-auto">
                            <i class="bx bxs-user-check fa-3x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-bottom-info shadow h-100 py-2">
                <div class="card-body d-flex justify-content-center align-items-center">
                    <div class="row no-gutters">
                        <p class="h1 font-weight-bold text-gray-800 mt-3" id="waktu">00:00:00</p>
                        <span id="timeformat" class="text-gray-500 ml-2">AM</span>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <!-- Content Row -->
      <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-7 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold" style="color: #96B6C5;">Antrian Pasien</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="d-flex justify-content-between mb-3 pr-3">
                    <form class="form-inline">
                      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                      <button class="btn btn-outline-success btn-sm my-2 my-sm-0" type="submit">Search</button>
                    </form>
                    <form action="{{ route('analyst.checkin') }}" method="post">
                    @csrf
                    <div class="tombol d-flex justify-content-between">
                      <!-- <button class="btn btn-sm btn-outline-secondary ml-2" id="check-all">Check All</button> -->
                      <button type="submit" class="btn btn-sm btn-outline-info" id="check-in" hidden>Check In</button>
                      <div class="checkbox-rect ml-3 mt-2">
                        <input type="checkbox" id="checkbox-rect1">
                        <label for="checkbox-rect1">Check All</label>
                      </div>
                    </div>
                  </div>
                  <div class="table-scroll table-pasien" style="width: 100%; overflow-y: scroll; max-height: 595px;">
                  <table class="table table-striped tabel-pasien" style="font-size: 12px;">
                    <thead>
                      <tr>
                        <th scope="col"><i class="bx bx-check" style="font-size: 18px;"></i></th>
                        <th scope="col">Tanggal Order</th>
                        <th scope="col">No RM</th>
                        <th scope="col">No LAB</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Asal Poli</th>
                        <th scope="col">Cito</th>
                        <th scope="col">Umur</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataPasienCito as $dpc)
                        <tr>
                            @if ($dpc->status == "Telah Dikirim ke Lab")
                                <th scope="row"></th>
                            @else
                                <th scope="row"><input type="checkbox" name="pilihan[]" class="pilih" onclick="hitung()" value="{{ $dpc->no_lab }}"></th>
                            @endif
                          <td>
                            @foreach ($dataHistory as $dh)
                                @if ($dh->no_lab == $dpc->no_lab)
                                    {{ date('d-m-Y', strtotime($dh->waktu_proses)) }}/{{ date('H:i', strtotime($dh->waktu_proses)) }}
                                @endif
                            @endforeach
                          </td>
                          <td>{{ $dpc->no_rm }}</td>
                          <td>{{ $dpc->no_lab }}</td>
                          <td>{{ $dpc->nama }}</td>
                          <td>{{ $dpc->asal_ruangan }}</td>
                          <td>
                            @if ($dpc->cito == 1)
                            <i class='bx bxs-bell-ring mt-2 ml-1 text-danger' style="font-size: 23px;"></i>
                            @else
                            <i class='bx bxs-bell-ring mt-2 ml-1 text-secondary' style="font-size: 23px;"></i>
                            @endif
                          </td>
                          <td>
                            {{ \Carbon\Carbon::parse($dpc->lahir)->age }} tahun
                          </td>
                          <td>
                            @if($dpc->status == "Telah Dikirim ke Lab")
                                <span class="badge bg-danger text-white">Belum Diproses</span>
                            @elseif($dpc->status == "Disetujui oleh analis lab")
                                <span class="badge bg-warning text-white">Disetujui</span>
                            @endif
                          </td>
                          <td class="d-flex">
                            <a href="#" class="btn btn-xs rounded-pill btn-outline-info mr-2" id="open-pasien" data-lab="{{ $dpc->no_lab }}" onclick="previewPasien('{{ $dpc->no_lab }}')">Preview</a>
                            <a href="#" class="btn btn-xs rounded-pill btn-outline-secondary">Barcode</a>
                          </td>
                        </tr>
                        @endforeach
                        @foreach ($dataPasien as $dp)
                        <tr>
                            @if ($dp->status == "Telah Dikirim ke Lab")
                                <th scope="row"></th>
                            @else
                                <th scope="row"><input type="checkbox" name="pilihan[]" class="pilih" onclick="hitung()" value="{{ $dp->no_lab }}"></th>
                            @endif
                          <td>
                            @foreach ($dataHistory as $dh)
                                @if ($dh->no_lab == $dp->no_lab)
                                    {{ date('d-m-Y', strtotime($dh->waktu_proses)) }}/{{ date('H:i', strtotime($dh->waktu_proses)) }}
                                @endif
                            @endforeach
                          </td>
                          <td>{{ $dp->no_rm }}</td>
                          <td>{{ $dp->no_lab }}</td>
                          <td>{{ $dp->nama }}</td>
                          <td>{{ $dp->asal_ruangan }}</td>
                          <td>
                            @if ($dp->cito == 1)
                            <i class='bx bxs-bell-ring mt-2 ml-1 text-danger' style="font-size: 23px;"></i>
                            @else
                            <i class='bx bxs-bell-ring mt-2 ml-1 text-secondary' style="font-size: 23px;"></i>
                            @endif
                          </td>
                          <td>
                            {{ \Carbon\Carbon::parse($dp->lahir)->age }} tahun
                          </td>
                          <td>
                            @if($dp->status == "Telah Dikirim ke Lab")
                                <span class="badge bg-danger text-white">Belum Diproses</span>
                            @elseif($dp->status == "Disetujui oleh analis lab")
                                <span class="badge bg-warning text-white">Disetujui</span>
                            @endif
                          </td>
                          <td class="d-flex">
                            <a href="#" class="btn btn-xs rounded-pill btn-outline-info mr-2" id="open-pasien" data-lab="{{ $dp->no_lab }}" onclick="previewPasien('{{ $dp->no_lab }}')">Preview</a>
                            <a href="#" class="btn btn-xs rounded-pill btn-outline-secondary">Barcode</a>
                          </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                  </div>
                </div>
            </form>
            </div>
        </div>

        <!-- Preview -->
        <div class="col-xl-5 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold" style="color: #96B6C5;">Preview Pasien</h6>
                    <div class="status" id="status">
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body p-4">
                    <div class="text-right">
                        <div class="text-right" id="tanggal-pemeriksaan">
                            <!-- Tanggal -->
                        </div>
                    </div>
                    <hr>
                    <div class="preview-pasien-close" id="preview-pasien-close" style="background-color: #e3e6f0">
                        <p class="text-center">Pilih Pasien</p>
                    </div>
                    <div class="preview-pasien-open" id="preview-pasien-open"><div class="container-preview">
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

  </div>

  <script>
    function previewPasien(nolab){
        console.log(nolab);
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

                //Status Pemeriksaan
                if(data.data_pasien.status == "Telah Dikirim ke Lab"){
                    status.innerHTML = `<div class="ribbon-shape-dgr"><p class="mt-3 text-white">Belum Dilayani</p></div>`;
                }else if(data.data_pasien.status == "Disetujui oleh analis lab"){
                    status.innerHTML = `<div class="ribbon-shape-wrn"><p class="mt-3 text-white">Disetujui</p></div>`;
                }

                //ubah format tanggal created_at
                var date = new Date(data.data_pasien.tanggal_masuk);
                var year = date.getFullYear();
                var month = date.getMonth()+1;
                var dt = date.getDate();

                //ambil nama hari
                var day = date.getDay();

                if (day == 0) {
                day = "Minggu";
                } else if (day == 1) {
                day = "Senin";
                } else if (day == 2) {
                day = "Selasa";
                } else if (day == 3) {
                day = "Rabu";
                } else if (day == 4) {
                day = "Kamis";
                } else if (day == 5) {
                day = "Jumat";
                } else if (day == 6) {
                day = "Sabtu";
                }

                if (dt < 10) {
                dt = '0' + dt;
                }
                if (month < 10) {
                month = '0' + month;
                }

                var tanggal_pemeriksaan = day+', '+dt+'-' + month + '-'+year+' '+date.getHours()+':'+date.getMinutes();

                //tampilkan tanggal pemeriksaan
                tanggal.innerHTML = `<p class="h6 font-weight-normal mt-1">`+ tanggal_pemeriksaan +`</p>`;

                //megnhitung umur dari tanggal lahir
                var dob = new Date(data.data_pasien.lahir);
                var today = new Date();
                var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));

                var diagnosa = data.icd10.filter(function (el) {
                    return el.code == data.data_pasien.diagnosa;
                });

                //perulangan untuk menampilkan pemeriksaan yang di pilih
                var departement = "";
                var pemeriksaan = "";

                for (let i = 0; i < data.id_departement_pasien.length; i++) {
                    departement += `<p class="h6 text-gray-800">`
                                    //buat perintah where untuk mencari id_departement
                                    for (let j = 0; j < data.data_departement.length; j++) {
                                        if(data.data_departement[j].id_departement == data.id_departement_pasien[i].id_departement)
                                            departement += data.data_departement[j].nama_departement;
                                    }
                                    departement += `</p>
                                    <div class="sub-detail p-2">`
                                        for (let k = 0; k < data.data_pemeriksaan_pasien.length; k++) {
                                            if(data.data_pemeriksaan_pasien[k].id_departement == data.id_departement_pasien[i].id_departement){
                                                for (let l = 0; l < data.data_pemeriksaan.length; l++) {
                                                    if(data.data_pemeriksaan_pasien[k].nama_parameter == data.data_pemeriksaan[l].nama_parameter){
                                                        departement += `<p class="text-gray-600 offset-md-3">`+ data.data_pemeriksaan[l].nama_pemeriksaan +`</p>`;
                                                    }
                                                }
                                            }
                                        }
                                    departement += `</div>`
                }


                var citoMerah = `<label for="staticEmail" class="col-sm-5 col-form-label">Cito</label>
                                <div class="col-sm-7">
                                    <i class='bx bxs-bell-ring mt-2 ml-1 text-danger' style="font-size: 23px;"></i>
                                </div>`;
                var citoGray = `<label for="staticEmail" class="col-sm-5 col-form-label">Cito</label>
                                <div class="col-sm-7">
                                    <i class='bx bxs-bell-ring mt-2 ml-1 text-secondary' style="font-size: 23px;"></i>
                                </div>`;

                var html = `
                        <form action="{{ route('analyst.approve') }}" method="POST" class="row table-preview" style="overflow-y: scroll; max-height: 515px;">
                            @csrf
                            <div class="pasien col-xl-6 col-lg-12 col-sm-12 mb-3">
                                <p class="h5 text-gray-800 mb-2">Pasien</p>
                                <hr>
                                <div class="row">`
                                if(data.data_pasien.cito == 1){
                                    html += citoMerah;
                                }else{
                                    html += citoGray;
                                }
                                html +=`</div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">No LAB</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": `+ data.data_pasien.no_lab +`">
                                </div>
                                </div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">No RM</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": `+ data.data_pasien.no_rm +`">
                                </div>
                                </div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">NIK</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": `+ data.data_pasien.nik +`">
                                </div>
                                </div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Nama</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": `+ data.data_pasien.nama +`">
                                </div>
                                </div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Gender</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": `+ data.data_pasien.jenis_kelamin +`">
                                </div>
                                </div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Umur</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": `+ age +` tahun">
                                </div>
                                </div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Alamat</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": `+ data.data_pasien.alamat +`">
                                </div>
                                </div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Telp</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": `+ data.data_pasien.no_telp +`">
                                </div>
                                </div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Jenis Pasien</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": `+ data.data_pasien.jenis_pelayanan +`">
                                </div>
                                </div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Ruangan</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": `+ data.data_pasien.asal_ruangan +`">
                                </div>
                                </div>
                            </div>
                            <div class="dokter col-xl-6 col-lg-12 col-sm-12 mb-3">
                                <p class="h5 text-gray-800">Dokter</p>
                                <hr>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Nama Dokter</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": Dr. Bande">
                                </div>
                                </div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Ruangan</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": Abu Thalib">
                                </div>
                                </div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Telp</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": 0812313">
                                </div>
                                </div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Email</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": gmail.com">
                                </div>
                                </div>
                                <div class="row">
                                <div class="form-group col-12">
                                    <label for="exampleFormControlTextarea1">Diagnosa :</label>
                                    <textarea class="form-control txt-area" style="resize: none; height: 160px;" id="note-1" rows="3" name="note-2" disabled>`+ diagnosa[0].name_id +`</textarea>
                                </div>
                                </div>
                            </div>
                            <div class="detail_pemeriksaan col-12 mt-2">
                                <div class="d-flex justify-content-between">
                                <p class="h5 text-gray-800 mb-2">Detail Pemeriksaan</p>
                                <p class="h6 font-weight-bold mt-1">Senin, 12 Aug 2020</p>
                                </div>
                                <hr>
                                <div class="row">
                                <div class="col-lg-6">`
                                html += departement;

                                html += `</div>
                                </div>
                                <div class="row mt-2">
                                <div class="form-group col-12">
                                    <label for="exampleFormControlTextarea1">Note</label>
                                    <input type="text" class="form-control" id="no-lab" name="no_lab" value="`+ data.data_pasien.no_lab +`" hidden>
                                    <textarea class="form-control txt-area" style="resize: none; height: 130px;" id="note-2" rows="3" name="note" placeholder="tulis note disini"></textarea>
                                </div>
                                </div>
                            </div>
                            </div>
                            <hr class="sidebar-divider">
                            <div class="mt-4 text-right small">
                                <button type="submit" class="btn btn-sm btn-outline-success font-weight-normal mx-2">Approve</button>
                                <button class="btn btn-sm btn-outline-danger font-weight-normal mx-2">Cancel</button>
                                <button class="btn btn-sm btn-outline-info font-weight-normal mx-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah Pemeriksaan</button>
                            </div>
                        </form>`

                document.getElementById("preview-pasien-open").innerHTML = html;


            })
            .catch(error => ('Error:', error));
    }
  </script>

  <script src="{{ asset('js/time.js') }}"></script>
  <script src="{{ asset('../js/check-all.js') }}"></script>
@endsection

@section('modal')
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Pemeriksaan</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form action="#">
          <div class="form-group col-12">
            <label for="exampleFormControlTextarea1">Note</label>
            <textarea class="form-control txt-area" style="resize: none; height: 130px;" id="note-2" rows="3" name="note-2" placeholder="tulis note disini"></textarea>
          </div>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-primary">Kirim ke Loket</button>
        </div>
        </form>
      </div>
    </div>
  </div>
@endsection
