@extends('master')
@section('title', 'Analyst Handling')

@section('content')
<div class="content" id="scroll-content">
    <div class="container-fluid">
      <!-- Page Heading -->
      <div class="d-sm-flex  mt-3">
        <h1 class="h3 mb-0 text-gray-600">Spesimen Handling</h1>
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
                <form action="{{ route('spesiment.checkin') }}" method="post">
                    @csrf
                    <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="form-inline">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                            {{-- <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button> --}}
                        </div>
                        <div class="tombol d-flex justify-content-between">
                        <!-- <button class="btn btn-sm btn-outline-secondary ml-2" id="check-all">Check All</button> -->
                        <button type="submit" class="btn btn-sm btn-outline-info" id="check-in" hidden>Check In</button>
                        <div class="checkbox-rect ml-3 mt-2">
                            <input type="checkbox" id="checkbox-rect1" name="check">
                            <label for="checkbox-rect1">Check All</label>
                        </div>
                        </div>
                    </div>
                    <div class="table-scroll table-pasien" style="width: 100%; overflow-y: scroll; max-height: 600px;">
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
                                @if ($dpc->status == "Check in")
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
                                @if($dpc->status == "Check in")
                                    <span class="badge bg-danger text-white">Belum Diproses</span>
                                @elseif($dpc->status == "Spesiment")
                                    <span class="badge bg-warning text-white">Disetujui</span>
                                @endif
                            </td>
                            <td class="d-flex action-tombol">
                                @if ($dpc->status == "Check in")
                                <a href="#" tooltip="Preview"><i class="fa-solid fa-file mx-1 mt-2" id="open-pasien" data-lab="{{ $dpc->no_lab }}" onclick="previewPasien('{{ $dpc->no_lab }}')"></i></a>
                                @else
                                <a href="#"></a>
                                @endif
                                <a href="#" tooltip="Tambah Parameter"><i class="fas fa-plus mx-1 mt-2"></i></a>
                                <a href="#" tooltip="Cetak Barcode"><i class="fas fa-barcode mx-1 mt-2"></i></a>
                                <a href="#" tooltip="Resample"><i class="fas fa-syringe mx-1 mt-2"></i></a>
                                <a href="#" tooltip="Hapus Data" flow="left"><i class="fas fa-trash mx-1 mt-2"></i></a>
                            </td>
                            </tr>
                            @endforeach
                            @foreach ($dataPasien as $dp)
                            <tr>
                                @if ($dp->status == "Check in")
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
                                @if($dp->status == "Check in")
                                    <span class="badge bg-danger text-white">Belum Diproses</span>
                                @elseif($dp->status == "Spesiment")
                                    <span class="badge bg-warning text-white">Disetujui</span>
                                @endif
                            </td>
                            <td class="d-flex action-tombol">
                                @if ($dp->status == "Check in")
                                <a href="#" tooltip="Preview"><i class="fa-solid fa-file mx-1 mt-2" id="open-pasien" data-lab="{{ $dp->no_lab }}" onclick="previewPasien('{{ $dp->no_lab }}')"></i></a>
                                @else
                                <a href="#"></a>
                                @endif
                                <a href="#" tooltip="Tambah Parameter"><i class="fas fa-plus mx-1 mt-2" onclick="mengambilData()"></i></a>
                                <a href="#" tooltip="Cetak Barcode"><i class="fas fa-barcode mx-1 mt-2"></i></a>
                                <a href="#" tooltip="Resample"><i class="fas fa-syringe mx-1 mt-2"></i></a>
                                <a href="#" tooltip="Hapus Data" flow="left"><i class="fas fa-trash mx-1 mt-2"></i></a>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </form>
                </div>
            </div>
        </div>

        <!-- Preview -->
        <div class="col-xl-5 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold" style="color: #96B6C5;">Preview Pasien</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body p-4">
                    <div class="text-right" id="tanggal-pemeriksaan">
                        <!-- Tanggal -->
                    </div>
                    <hr>
                    <div class="preview-pasien-close" id="preview-pasien-close" style="background-color: #e3e6f0">
                        <p class="text-center">Pilih Pasien</p>
                    </div>
                    <div class="preview-pasien-open" id="preview-pasien-open">
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
  </div>


<!-- Preview Pasien -->
<script>
    function previewPasien(nolab) {
        var y = document.getElementById("preview-pasien-close");

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
                if(data.data_pasien.status == "Belum Dilayani"){
                    status.innerHTML = `<div class="ribbon-shape-dgr"><p class="mt-3 text-white">Belum Dilayani</p></div>`;
                }else if(data.data_pasien.status == "Telah Dikirim ke Lab"){
                    status.innerHTML = `<div class="ribbon-shape-scs"><p class="mt-3 text-white">Telah Dikirim</p></div>`;
                }else if(data.data_pasien.status == "Diproses"){
                    status.innerHTML = `<div class="ribbon-shape-wrn"><p class="mt-3 text-white">Diproses</p></div>`;
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

                var spesCollection = "";
                var spesHandling = "";

                let jumlahDepartement = [];

                console.log(data.data_departement);

                for (let i = 0; i < data.id_departement_pasien.length; i++) {
                    departement += `<p class="h6 text-gray-800">`
                    //buat perintah where untuk mencari id_departement
                    for (let j = 0; j < data.data_departement.length; j++) {
                        if(data.data_departement[j].id_departement == data.id_departement_pasien[i].id_departement){
                            console.log(data.data_departement[j].id_departement);
                            jumlahDepartement.push(data.data_departement[j].id_departement);
                            departement += data.data_departement[j].nama_departement;
                        }
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

                //memanyimpan kode tabung
                let kodeTabung = []

                for(let i = 0; i < jumlahDepartement.length; i++){
                    for(let j = 0; j < data.data_departement.length; j++){
                        if(jumlahDepartement[i] == data.data_departement[j].id_departement){
                            kodeTabung.push(data.data_departement[j].kode_tabung)
                        }
                    }
                }

                //menghapus kode tabung yang duplikat
                kodeTabung = [...new Set(kodeTabung)];


                //menamplikan spesimen collection
                for(let i = 0; i < kodeTabung.length; i++){
                    for(let j = 0; j < data.dataTabung.length; j++){
                        if(kodeTabung[i] == data.dataTabung[j].kode_tabung){
                            spesCollection += `<div class="akordion col-12">
                                                <div class="akordion-content akordion-collection">
                                                    <header>
                                                    <span class="judul-ak">Tabung `+ data.dataTabung[j].nama_tabung +`</span>
                                                    <i class="bx bx-plus" style="color: #D0BFFF;"></i>
                                                    </header>
                                                    <div class="deskripsi-ak">
                                                    <div class="d-flex justify-content-around text-center">
                                                        <input type="text" name="tabung[]" value="`+ data.dataTabung[j].kode_tabung +`" hidden>
                                                        <div class="sampling-bar">
                                                        <h2>Low</h2>
                                                        <div class="prog-sampling" style="background: #FF6868;">
                                                            <div class="low"></div>
                                                        </div>
                                                        <input type="radio" name="kapasitas_`+ data.dataTabung[j].kode_tabung +`" id="form-kapasitas" value="low" readonly>
                                                        </div>
                                                        <div class="sampling-bar">
                                                        <h2>Normal</h2>
                                                        <div class="prog-sampling" style="margin-left: 12px; background:#FFBB64;">
                                                            <div class="normal"></div>
                                                        </div>
                                                        <input type="radio" name="kapasitas_`+ data.dataTabung[j].kode_tabung +`" id="form-kapasitas" value="normal">
                                                        </div>
                                                        <div class="sampling-bar">
                                                        <h2>High</h2>
                                                        <div class="prog-sampling" style="background: #8fd48e;">
                                                            <div class="high"></div>
                                                        </div>
                                                        <input type="radio" name="kapasitas_`+ data.dataTabung[j].kode_tabung +`" id="form-kapasitas" value="high">
                                                        </div>
                                                        <div class="row">
                                                        <div class="form-group col-12">
                                                            <label for="exampleFormControlTextarea1">Note</label>
                                                            <textarea class="form-control txt-area" name="note_kapasitas_`+ data.dataTabung[j].kode_tabung +`" id="form-kapasitas" style="resize: none; height: 160px;" id="note-1" rows="3" name="note-2" placeholder="tulis note disini"></textarea>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>`
                        }
                    }
                }

                //menamplikan spesimen collection
                for(let i = 0; i < kodeTabung.length; i++){
                    for(let j = 0; j < data.dataTabung.length; j++){
                        if(kodeTabung[i] == data.dataTabung[j].kode_tabung){
                            spesHandling += `<div class="akordion-content akordion-handling">
                                                <header>
                                                <span class="judul-ak">Tabung `+ data.dataTabung[j].nama_tabung +`</span>
                                                <i class="bx bx-plus" style="color: #D0BFFF;"></i>
                                                </header>
                                                <div class="deskripsi-ak">
                                                <p class="h6 font-weight-bold text-center">Serum</p>
                                                <div class="d-flex justify-content-around text-center">
                                                    <div class="sampling-bar">
                                                    <h2>Normal</h2>
                                                    <div class="serum my-2">
                                                        <img src="{{ asset('../image/Group 150.png') }}" alt="">
                                                    </div>
                                                    <input type="radio" name="serum_`+ data.dataTabung[j].kode_tabung +`" id="form-serum" value="normal" disabled>
                                                    </div>
                                                    <div class="sampling-bar">
                                                    <h2>Hemolytic</h2>
                                                    <div class="serum my-2">
                                                        <img src="{{ asset('../image/Group 151.png') }}" alt="">
                                                    </div>
                                                    <input type="radio" name="serum_`+ data.dataTabung[j].kode_tabung +`" id="form-serum" value="hemolytic" disabled>
                                                    </div>
                                                    <div class="sampling-bar">
                                                    <h2>Iteric</h2>
                                                    <div class="serum my-2">
                                                        <img src="{{ asset('../image/Group 152.png') }}" alt="">
                                                    </div>
                                                    <input type="radio" name="serum_`+ data.dataTabung[j].kode_tabung +`" id="form-serum" value="iteric" disabled>
                                                    </div>
                                                    <div class="sampling-bar">
                                                    <h2>Lipemic</h2>
                                                    <div class="serum my-2">
                                                        <img src="{{ asset('../image/Group 153.png') }}" alt="">
                                                    </div>
                                                    <input type="radio" name="serum_`+ data.dataTabung[j].kode_tabung +`" id="form-serum" value="lipemic" disabled>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-12">
                                                    <label for="exampleFormControlTextarea1">Note</label>
                                                    <textarea class="form-control txt-area" name="note_serum_`+ data.dataTabung[j].kode_tabung +`" id="form-serum" style="resize: none; height: 100px;" id="note-1" rows="3" name="note-2" placeholder="tulis note disini" disabled></textarea>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>`
                        }
                    }
                }



                var citoMerah = `<label for="staticEmail" class="col-sm-5 col-form-label">Cito</label>
                                <div class="col-sm-7">
                                    <i class='bx bxs-bell-ring mt-2 ml-1 text-danger' style="font-size: 23px;"></i>
                                </div>`;
                var citoGray = `<label for="staticEmail" class="col-sm-5 col-form-label">Cito</label>
                                <div class="col-sm-7">
                                    <i class='bx bxs-bell-ring mt-2 ml-1 text-secondary' style="font-size: 23px;"></i>
                                </div>`;

                var html = `<form action="{{ route('spesiment.post') }}" method="POST">
                                <div class="detail_pemeriksaan col-12">
                                <p class="h5 text-gray-800">Detail Pemeriksaan</p>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-5">`
                                html += departement;

                                html += `</div>
                                </div>
                                <div class="row mt-2">
                                    <div class="form-group col-12">
                                    <label for="exampleFormControlTextarea1">Note</label>
                                    <textarea class="form-control txt-area" style="resize: none; height: 130px; outline: none; border: none;" id="note-2" rows="3" name="note-2" readonly>`+ data.history_pasien[0].note +`</textarea>
                                    </div>
                                </div>

                                <!-- Collection -->
                                    @csrf
                                    <div class="d-flex justify-content-between">
                                        <p class="h5 text-gray-800 mt-3">Spesimen Collection</p>
                                        <a class="btn btn-sm btn-outline-success mt-2" id="btn-collection" style="height: 40px;" onclick="ambilTanggalCollection()">Approve</a>
                                    </div>
                                    <hr>
                                    <div class="row">
                                    <label for="staticEmail" class="col-md-2 col-sm-3 col-form-label">Tanggal : </label>
                                        <div class="col-md-10 col-sm-9">
                                            <input type="text" readonly class="form-control-plaintext" name="tanggal_collection" id="staticEmail" value="Belum Di Approve">
                                        </div>
                                    </div>
                                    <div class="row">
                                    <input type="text" name="no_lab" value="`+ data.data_pasien.no_lab +`" hidden>`

                                    html += spesCollection;

                                    html += `</div>
                                    <hr>

                                    <!-- Handling -->
                                    <div class="d-flex justify-content-between">
                                        <p class="h5 text-gray-800 mt-3">Spesimen Handling</p>
                                        <a class="btn btn-sm btn-outline-success mt-2" id="btn-handling" style="height: 40px;" onclick="ambilTanggalHandling()" hidden>Approve</a>
                                    </div>
                                    <hr>
                                    <div class="row">
                                    <label for="staticEmail" class="col-md-2 col-sm-3 col-form-label">Tanggal</label>
                                        <div class="col-md-10 col-sm-9">
                                            <input type="text" readonly class="form-control-plaintext" name="tanggal_handling" id="staticEmail" value="Belum Di Approve">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="akordion col-12">`
                                        html += spesHandling;

                                        html += `</div>
                                    </div>
                                    </div>
                                    <hr class="sidebar-divider">
                                    <div class="mt-4 text-right small">
                                    <button type="submit" class="btn btn-sm btn-outline-success font-weight-normal mx-2" id="btn-submit-spesiment" disabled>Approve</button>`
                                    // <button class="btn btn-sm btn-outline-danger font-weight-normal mx-2">Cancel</button>
                                    html += `<button class="btn btn-sm btn-outline-info font-weight-normal mx-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah Pemeriksaan</button>
                                </form>
                            </div>`

                document.getElementById("preview-pasien-open").innerHTML = html;


            })
            .catch(error => ('Error:', error));

    }

</script>

<script>
    function ambilTanggalCollection(){
        var date = new Date();
        var year = date.getFullYear();
        var month = date.getMonth()+1;
        var dt = date.getDate();

        if (dt < 10) {
            dt = '0' + dt;
        }
        if (month < 10) {
            month = '0' + month;
        }

        var tanggal_collection = dt+'-' + month + '-'+year+' '+date.getHours()+':'+date.getMinutes();

        document.getElementsByName("tanggal_collection")[0].value = tanggal_collection;

        //menghilangkan hidden pada button handling
        document.getElementById("btn-handling").hidden = false;

        //menghilangkan hidden pada button collection
        document.getElementById("btn-collection").hidden = true;

        //enable semua id form handling
        var elements = document.querySelectorAll('[name*="serum"]');
        for (let i = 0; i < elements.length; i++) {
            elements[i].disabled = false;
        }

        //mencari radio button yang tidak dipilih dengan name kapasitas
        var elements = document.querySelectorAll('[name*="kapasitas"]');
        for (let i = 0; i < elements.length; i++) {
            if(elements[i].checked == false){
                elements[i].hidden = true;
            }
        }

        //disable textarea note collection
        var elements = document.querySelectorAll('[name*="note_kapasitas"]');
        for (let i = 0; i < elements.length; i++) {
            elements[i].readOnly = true;
        }

    }

    function ambilTanggalHandling(){
        var date = new Date();
        var year = date.getFullYear();
        var month = date.getMonth()+1;
        var dt = date.getDate();

        if (dt < 10) {
            dt = '0' + dt;
        }
        if (month < 10) {
            month = '0' + month;
        }

        var tanggal_handling = dt+'-' + month + '-'+year+' '+date.getHours()+':'+date.getMinutes();

        document.getElementsByName("tanggal_handling")[0].value = tanggal_handling;

        //menghilangkan hidden pada button handling
        document.getElementById("btn-handling").hidden = true;

        //enable button submit spesiment
        document.getElementById("btn-submit-spesiment").disabled = false;

        //mencari radio button yang tidak dipilih dengan name serum
        var elements = document.querySelectorAll('[name*="serum"]');
        for (let i = 0; i < elements.length; i++) {
            if(elements[i].checked == false){
                elements[i].hidden = true;
            }
        }

        //disable textarea note handling
        var elements = document.querySelectorAll('[name*="note_serum"]');
        for (let i = 0; i < elements.length; i++) {
            elements[i].readOnly = true;
        }
    }
</script>

{{-- <script>
    function mengambilData(){
        //mengambil data di element input text dengan name tabung sesuai dengan jumlah input text tabung
        const elements = document.querySelectorAll('[name*="tabung"]');
        const count = elements.length;

        let tabung = []

        for(let i = 0; i < count; i++){
            tabung.push(document.getElementsByName("tabung")[i].value)
        }


        console.log(tabung);
    }
</script> --}}

{{-- <script>
    $(document).ready(function() {
        $('#submit-collection').on('click', function() {
            var tabungCollection = document.getElementById('tabung').value;

            //mengambil data di element input text dengan name tabung sesuai dengan jumlah input text tabung
            const elements = document.querySelectorAll('[name*="tabung"]');
            const count = elements.length;

            let tabung = []

            for(let i = 0; i < count; i++){
                var data = {
                    no_lab: document.getElementsByName("no_lab")[0].value,
                    tabung: document.getElementsByName("tabung")[i].value,
                    kapasitas: document.getElementsByName("kapasitas-" + document.getElementsByName("tabung")[i].value).value,
                };

                console.log(data);

            }

        });
    });
</script> --}}

{{-- <script>
    function postCollection(){
            //mengambil data di element input text dengan name tabung sesuai dengan jumlah input text tabung
            const elements = document.querySelectorAll('[name*="tabung"]');
            const count = elements.length;

            var form = document.getElementById("form-collection");

            let tabung = []

            for(let i = 0; i < count; i++){
                var namaTabung = document.getElementsByName("tabung")[i].value;
                var data = {
                    no_lab: document.getElementsByName("no_lab")[0].value,
                    tabung: document.getElementsByName("tabung")[i].value,
                    kapasitas: document.querySelector('input[name="kapasitas-'+ document.getElementsByName("tabung")[i].value +'"]:checked').value,
                    note: document.getElementsByName("note-" + document.getElementsByName("tabung")[i].value)[0].value,
                };

                $.ajax({
                    url: '/api/collection/post',
                    type: 'get',
                    data: data,
                    success: function (data) {
                        alert(data.data);
                    }
                });

            }
    }
</script> --}}

{{-- <script>
    //event ketika element a dengan id submit-collection di klik
    document.getElementById("submit-collection").addEventListener("click", function(event){
        event.preventDefault();
        createUser();
    });
    // JavaScript
    function createUser() {
        //mengambil data di element input text dengan name tabung sesuai dengan jumlah input text tabung
        const elements = document.querySelectorAll('[name*="tabung"]');
        const count = elements.length;

        var form = document.getElementById("form-collection");

        for(let i = 0; i < count; i++){
            var namaTabung = document.getElementsByName("tabung")[i].value;

            const no_lab = document.getElementsByName("no_lab")[0].value;
            const tabung = document.getElementsByName("tabung")[i].value;
            const kapasitas = document.querySelector('input[name="kapasitas-'+ document.getElementsByName("tabung")[i].value +'"]:checked').value;
            const note = document.getElementsByName("note-" + document.getElementsByName("tabung")[i].value)[0].value;

            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Buat objek data
            const data = {
                no_lab,
                tabung,
                kapasitas,
                note,
            };

            //kirim data menggunakan ajax
            $.ajax({
                url: '{{ route('collection.post') }}',
                type: 'POST',
                data,
                header: {
                    'X-CSRF-TOKEN': csrfToken,
                },
                success: function(data) {
                    // Tampilkan data baru
                    alert(data.no_lab + ' telah dibuat.');
                },
                error: function(error) {
                    // Tampilkan pesan error
                    alert(error.responseJSON.message);
                },
            });
        }
    }

</script> --}}

<script src="{{ asset('js/check-all.js') }}"></script>
<script src="{{ asset('js/time.js') }}"></script>
@endsection

@section('modal')

@endsection
