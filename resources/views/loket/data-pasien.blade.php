<title>Data|Pasien</title>
@extends('layouts.admin')

@section('title', 'Data Pasien')

@section('content')
    <div class="content" id="scroll-content">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex  my-3">
                <h1 class="h3 mb-0 text-gray-600">Patient Data</h1>
            </div>

            <!-- Content Row -->
            <div class="row">

                <!-- Area Chart -->
                <div class="col-xl-12 col-lg-12">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold" style="color: #96B6C5;">Patient Data</h6>
                        </div>
                        <!-- Card Body -->

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="myTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">No.RM</th>
                                            <th scope="col">NIK</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Date Of Birth</th>
                                            <th scope="col">Gender</th>
                                            <th scope="col">Phone Number</th>
                                            <th scope="col">Address</th>
                                            <th scope="col" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data_pasien as $x => $dp)
                                            <tr>
                                                <th scope="row">{{ $x + 1 }}</th>
                                                {{-- <th scope="row">{{ $dp->id }}</th> --}}
                                                <td>{{ $dp->no_rm }}</td>
                                                <td>{{ $dp->nik }}</td>
                                                <td>{{ $dp->nama }}</td>
                                                <td>
                                                    @php
                                                        //mengubah format tanggal
                                                        $tanggal = $dp->lahir;
                                                        $tanggal = date('d-m-Y', strtotime($tanggal));

                                                        //menghitung umur
                                                        $lahir = new DateTime($dp->lahir);
                                                        $today = new DateTime();
                                                        $umur = $today->diff($lahir);
                                                        $umur = $umur->y;

                                                        echo $tanggal . ' / ' . $umur . ' tahun ';
                                                    @endphp
                                                </td>
                                                <td>{{ $dp->jenis_kelamin }}</td>
                                                <td>{{ $dp->no_telp }}</td>
                                                <td>{{ $dp->alamat }}</td>
                                                <td><button data-bs-toggle="modal" data-bs-target="#editDataPasien"
                                                        class="btn btn-info btn-edit text-white"
                                                        data-id="{{ $dp->id }}"><i class="bi bi-clipboard "></i>
                                                    </button></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal fade" id="editdataPasien" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Patient Edit</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="editFormPasien" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="Nik">Nik</label>
                                                    <input type="text" class="form-control" id="Nik" name="nik"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input type="text" class="form-control" id="Name" name="nama"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tanggallahir">Date Of Birth</label>
                                                    <input id="startDate" type="date" class="form-control" name="lahir"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Gender">Gender</label>
                                                    <select id="Gender" name="jenis_kelamin" class="form-control">
                                                        <option value="" selected disabled hidden>Pilih Jenis Kelamin
                                                        </option>
                                                        <option value="Laki²">Laki²</option>
                                                        <option value="Perempuan">Perempuan</option>
                                                    </select>
                                                    {{-- <input type="text" class="form-control" id="Gender"
                                                        name="jenis_kelamin" required> --}}
                                                </div>
                                                <div class="form-group">
                                                    <label for="phone">Phone Number</label>
                                                    <input type="text" class="form-control" id="Phone" name="no_telp"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="address">Address</label>
                                                    <input type="text" class="form-control" id="Address" name="alamat"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
@push('script')
    <script>
        $(function() {
            $('.btn-edit').on('click', function() {
                // let data = $(this).data('content');
                // var nik = $(this).data('nik');
                // var name = $(this).data('name');
                // var tanggal = $(this).data('tanggal');
                // var gender = $(this).data('gender');
                // var phone = $(this).data('telp');
                // var address = $(this).data('address');

                const id = this.getAttribute('data-id');
                // console.log(id);
                $('#editFormPasien').attr('action', "{{ url('/loket/data-pasien') }}/" + id);


                fetch(`/api/get-data-pasien/${id}`).then(response => {
                    if (!response.ok) {
                        throw new Error("HTTP error " + response.status);
                    }
                    return response.json();
                }).then(res => {
                    if (res.status === 'success') {
                        const {
                            nik,
                            nama,
                            lahir,
                            jenis_kelamin,
                            no_telp,
                            alamat
                        } = res.data;

                        $('#Nik').val(nik);
                        $('#Name').val(nama);
                        $('#startDate').val(lahir);
                        $('#Gender').val(jenis_kelamin);
                        $('#Phone').val(no_telp);
                        $('#Address').val(alamat);
                    }
                });

                // Form edit 
                // .catch(error => {
                //     console.error('Error fetching data:', error);
                // });

                // show the modal
                // $('#editDataPasien').modal('show');
            });
        })
    </script>
@endpush


<!-- Modal 1-->
{{-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Patient Detail</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 700px; overflow-y: auto;">
                    <form action="#" method="post">
                        <div class="d-flex justify-content-between">
                            <p class="h5">Patient Data</p>
                            <div class="row" style="margin-top: -5px;">
                                <label for="staticEmail" class="col-sm-4 col-form-label">No LAB</label>
                                <div class="col-lg">
                                    <input type="text" readonly class="form-control-plaintext font-weight-bold"
                                        id="staticEmail" value=": LAB623452">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="pasien col-xl-6 mb-3">
                                <p class="h5 text-gray-800 mb-2">Pasien</p>
                                <hr>
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">Cito</label>
                                    <div class="col-sm-7">
                                        <i class='bx bxs-bell-ring mt-2 ml-1 text-danger' style="font-size: 23px;"></i>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">No LAB</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                            value=": 0341">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">No RM</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                            value=": 012345">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">NIK</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                            value=": 312423424">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">Nama</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                            value=": John China">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">Gender</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                            value=": Tidak Disebutkan">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">Umur</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                            value=": 20 tahun">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">Alamat</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                            value=": Porong">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">Telp</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                            value=": 08123532123">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">Jenis Pasien</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                            value=": BPJS">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">Ruangan</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                            value=": Abu Thalib">
                                    </div>
                                </div>
                            </div>
                            <div class="dokter col-xl-6 mb-3">
                                <p class="h5 text-gray-800">Dokter</p>
                                <hr>
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">Nama Dokter</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                            value=": Dr. Bande">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">Ruangan</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                            value=": Abu Thalib">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">Telp</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                            value=": 0812313">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">Email</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                            value=": gmail.com">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label">Diagnosa</label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                            value=": mati suri">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="px-2 d-flex justify-content-between">
                            <p class="h5">Tracking History Pasien</p>
                            <p class="h6 font-weight-bold">12 Agustus 2023</p>
                        </div>
                        <div class="row px-3 main-progress" style="flex-direction: column;">
                            <ul>
                                <li>
                                    <i class="iconscout uil uil-pen "></i>
                                    <div class="progression one aktif">
                                        <p>✖</p>
                                        <i class="uil uil-check"></i>
                                    </div>
                                    <div class="keterangan">
                                        <p class="text-ket">Order</p>
                                        <p class="clock">13.00</p>
                                    </div>
                                </li>
                                <li>
                                    <i class="iconscout uil uil-bill"></i>
                                    <div class="progression two">
                                        <p>✖</p>
                                        <i class="uil uil-check"></i>
                                    </div>
                                    <div class="keterangan">
                                        <p class="text-ket">Payment</p>
                                        <p class="clock">13.15</p>
                                    </div>
                                </li>
                                <li>
                                    <i class="iconscout uil uil-syringe"></i>
                                    <div class="progression three">
                                        <p>✖</p>
                                        <i class="uil uil-check"></i>
                                    </div>
                                    <div class="keterangan">
                                        <p class="text-ket">Sampling</p>
                                        <p class="clock">13.25</p>
                                    </div>
                                </li>
                                <li>
                                    <i class="iconscout uil uil-file-plus-alt"></i>
                                    <div class="progression">
                                        <p>✖</p>
                                        <i class="uil uil-check"></i>
                                    </div>
                                    <div class="keterangan">
                                        <p class="text-ket">+ Parameter</p>
                                        <p class="clock">13.25</p>
                                    </div>
                                </li>
                                <li>
                                    <i class="iconscout uil uil-sync"></i>
                                    <div class="progression three">
                                        <p>✖</p>
                                        <i class="uil uil-check"></i>
                                    </div>
                                    <div class="keterangan">
                                        <p class="text-ket">Resampling</p>
                                        <p class="clock">13.25</p>
                                    </div>
                                </li>
                                <li>
                                    <i class="iconscout uil uil-clipboard-alt"></i>
                                    <div class="progression four">
                                        <p>✖</p>
                                        <i class="uil uil-check"></i>
                                    </div>
                                    <div class="keterangan">
                                        <p class="text-ket">S Collection</p>
                                        <p class="clock">13.30</p>
                                    </div>
                                </li>
                                <li>
                                    <i class="iconscout uil uil-microscope"></i>
                                    <div class="progression five">
                                        <p>✖</p>
                                        <i class="uil uil-check"></i>
                                    </div>
                                    <div class="keterangan">
                                        <p class="text-ket">S Handling</p>
                                        <p class="clock">13.50</p>
                                    </div>
                                </li>
                                <li>
                                    <i class="iconscout uil uil-receipt"></i>
                                    <div class="progression six">
                                        <p>✖</p>
                                        <i class="uil uil-check"></i>
                                    </div>
                                    <div class="keterangan">
                                        <p class="text-ket">Result</p>
                                        <p class="clock">14.15</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <hr>
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
                                            <td><input type="text" class="col-5 input-detail justify-content-center"
                                                    readonly value="123"></td>
                                            <td><input type="text" class="col-5 input-detail" readonly value="123">
                                            </td>
                                            <td><input type="text" class="col-5 input-detail" readonly value="123">
                                            </td>
                                            <td></td>
                                            <td class="text-center">%</td>
                                            <td class="text-center">1-10</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Eritrosit</td>
                                            <td><input type="text" class="col-5 input-detail" readonly value="123">
                                            </td>
                                            <td><input type="text" class="col-5 input-detail" readonly value="123">
                                            </td>
                                            <td><input type="text" class="col-5 input-detail" readonly value="123">
                                            </td>
                                            <td></td>
                                            <td class="text-center">%</td>
                                            <td class="text-center">1-10</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Hemoglobin</td>
                                            <td><input type="text" class="col-5 input-detail" readonly value="123">
                                            </td>
                                            <td><input type="text" class="col-5 input-detail" readonly value="123">
                                            </td>
                                            <td><input type="text" class="col-5 input-detail" readonly value="123">
                                            </td>
                                            <td></td>
                                            <td class="text-center">%</td>
                                            <td class="text-center">1-10</td>
                                        </tr>
                                        <tr class="mt-2">
                                            <th scope="row">Kimia Klinik</th>
                                        </tr>
                                        <tr class="">
                                            <td scope="row" class="col-4">Creatinin</td>
                                            <td><input type="text" class="col-5 input-detail justify-content-center"
                                                    readonly value="123"></td>
                                            <td><input type="text" class="col-5 input-detail" readonly value="123">
                                            </td>
                                            <td><input type="text" class="col-5 input-detail" readonly value="123">
                                            </td>
                                            <td></td>
                                            <td class="text-center">mg/dL</td>
                                            <td class="text-center">1-10</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">Urea (Bun)</td>
                                            <td><input type="text" class="col-5 input-detail" readonly value="123">
                                            </td>
                                            <td><input type="text" class="col-5 input-detail" readonly value="123">
                                            </td>
                                            <td><input type="text" class="col-5 input-detail" readonly value="123">
                                            </td>
                                            <td></td>
                                            <td class="text-center">mg/dL</td>
                                            <td class="text-center">1-10</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Preview Pasien -->
    <script>
        function previewPasien(nolab) {
            var y = document.getElementById("preview-pasien-close");
            console.log(nolab);

            //mengambil data pasien dari database
            fetch('/api/previewpasien/' + nolab)
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
                    if (data.data_pasien.status == "Belum Dilayani") {
                        status.innerHTML =
                            `<div class="ribbon-shape-dgr"><p class="mt-3 text-white">Belum Dilayani</p></div>`;
                    } else if (data.data_pasien.status == "Telah Dikirim ke Lab") {
                        status.innerHTML =
                            `<div class="ribbon-shape-scs"><p class="mt-3 text-white">Telah Dikirim</p></div>`;
                    } else if (data.data_pasien.status == "Diproses") {
                        status.innerHTML =
                            `<div class="ribbon-shape-wrn"><p class="mt-3 text-white">Diproses</p></div>`;
                    }

                    //ubah format tanggal created_at
                    var date = new Date(data.data_pasien.tanggal_masuk);
                    var year = date.getFullYear();
                    var month = date.getMonth() + 1;
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

                    var tanggal_pemeriksaan = day + ', ' + dt + '-' + month + '-' + year + ' ' + date.getHours() + ':' +
                        date.getMinutes();

                    //tampilkan tanggal pemeriksaan
                    tanggal.innerHTML = `<p class="h6 font-weight-normal mt-1">` + tanggal_pemeriksaan + `</p>`;

                    //megnhitung umur dari tanggal lahir
                    var dob = new Date(data.data_pasien.lahir);
                    var today = new Date();
                    var age = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));

                    var diagnosa = data.icd10.filter(function(el) {
                        return el.code == data.data_pasien.diagnosa;
                    });

                    //perulangan untuk menampilkan pemeriksaan yang di pilih
                    var departement = "";
                    var pemeriksaan = "";

                    for (let i = 0; i < data.id_departement_pasien.length; i++) {
                        departement += `<p class="h6 text-gray-800">`
                        //buat perintah where untuk mencari id_departement
                        for (let j = 0; j < data.data_departement.length; j++) {
                            if (data.data_departement[j].id_departement == data.id_departement_pasien[i].id_departement)
                                departement += data.data_departement[j].nama_departement;
                        }
                        departement += `</p>
                                    <div class="sub-detail p-2">`
                        for (let k = 0; k < data.data_pemeriksaan_pasien.length; k++) {
                            if (data.data_pemeriksaan_pasien[k].id_departement == data.id_departement_pasien[i]
                                .id_departement) {
                                for (let l = 0; l < data.data_pemeriksaan.length; l++) {
                                    if (data.data_pemeriksaan_pasien[k].nama_parameter == data.data_pemeriksaan[l]
                                        .nama_parameter) {
                                        departement += `<p class="text-gray-600 offset-md-3">` + data.data_pemeriksaan[
                                            l].nama_pemeriksaan + `</p>`;
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

                    var html =
                        `<div class="container-preview">
                                <form action="#" class="row table-preview" style="overflow-y: scroll; max-height: 515px;">
                                <div class="pasien col-xl-6 col-lg-12 col-sm-12 mb-3">
                                    <p class="h5 text-gray-800 mb-2">Pasien</p>
                                    <hr>
                                    <div class="row">
                                        <label for="staticEmail" class="col-sm-5 col-form-label">Cito</label>
                                        <div class="col-sm-7">
                                            <i class='bx bxs-bell-ring mt-2 ml-1 text-danger' style="font-size: 23px;"></i>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="staticEmail" class="col-sm-5 col-form-label">No LAB</label>
                                        <div class="col-sm-7">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ` +
                        data.data_pasien.no_lab +
                        `">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="staticEmail" class="col-sm-5 col-form-label">No RM</label>
                                        <div class="col-sm-7">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ` +
                        data
                        .data_pasien.no_rm +
                        `">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="staticEmail" class="col-sm-5 col-form-label">NIK</label>
                                        <div class="col-sm-7">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ` +
                        data
                        .data_pasien.nik +
                        `">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="staticEmail" class="col-sm-5 col-form-label">Nama</label>
                                        <div class="col-sm-7">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ` +
                        data
                        .data_pasien.nama +
                        `">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="staticEmail" class="col-sm-5 col-form-label">Gender</label>
                                        <div class="col-sm-7">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ` +
                        data
                        .data_pasien.jenis_kelamin +
                        `">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="staticEmail" class="col-sm-5 col-form-label">Umur</label>
                                        <div class="col-sm-7">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ` +
                        age +
                        ` tahun">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="staticEmail" class="col-sm-5 col-form-label">Alamat</label>
                                        <div class="col-sm-7">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ` +
                        data.data_pasien.alamat +
                        `">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="staticEmail" class="col-sm-5 col-form-label">Telp</label>
                                        <div class="col-sm-7">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ` +
                        data.data_pasien.no_telp +
                        `">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="staticEmail" class="col-sm-5 col-form-label">Jenis Pasien</label>
                                        <div class="col-sm-7">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ` +
                        data.data_pasien.jenis_pelayanan +
                        `">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="staticEmail" class="col-sm-5 col-form-label">Ruangan</label>
                                        <div class="col-sm-7">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ` +
                        data.data_pasien.asal_ruangan +
                        `">
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
                                        <label for="staticEmail" class="col-sm-5 col-form-label">Diagnosa</label>
                                        <div class="col-sm-7">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": ` +
                        diagnosa[0].name_id + `">
                                        </div>
                                    </div>
                                </div>
                                <div class="detail_pemeriksaan col-12 ">
                                    <p class="h5 text-gray-800 mb-2">Detail Pemeriksaan</p>
                                    <hr>
                                    <div class="row">
                                    <div class="col-md-6">`

                    html += departement;

                    html +=
                        `</div>
                                    </div>
                                </div>
                                </form>
                                <hr class="sidebar-divider">
                                <div class="mt-4 text-right small">
                                    <button class="btn btn-sm btn-outline-dark font-weight-normal mx-2">Print Result</button>
                                    <button class="btn btn-sm btn-outline-teal font-weight-normal mx-2" data-bs-toggle="modal" data-bs-target="#exampleModalScrollable" onclick="barcode('` +
                        data.data_pasien.no_lab + `')">Cetak Barcode</button>
                                    <button class="btn btn-sm btn-outline-info font-weight-normal mx-2" data-bs-toggle="modal" data-bs-target="#exampleModal">View Detail</button>
                                </div>
                            </div>`

                    document.getElementById("preview-pasien-open").innerHTML = html;


                })
                .catch(error => ('Error:', error));

        }
    </script> --}}

{{-- <script>
    const one = document.querySelector('.one');
    const two = document.querySelector('.two');
    const three = document.querySelector('.three');
    const four = document.querySelector('.four');
    const five = document.querySelector('.five');
    const six = document.querySelector('.six');

    one.onclick = function(){
        one.classList.add('aktif');
        two.classList.remove('aktif');
        three.classList.remove('aktif');
        four.classList.remove('aktif');
        five.classList.remove('aktif');
        six.classList.remove('aktif');
    }
    two.onclick = function(){
        one.classList.add('aktif');
        two.classList.add('aktif');
        three.classList.remove('aktif');
        four.classList.remove('aktif');
        five.classList.remove('aktif');
        six.classList.remove('aktif');
    }
    three.onclick = function(){
        one.classList.add('aktif');
        two.classList.add('aktif');
        three.classList.add('aktif');
        four.classList.remove('aktif');
        five.classList.remove('aktif');
        six.classList.remove('aktif');
    }
    four.onclick = function(){
        one.classList.add('aktif');
        two.classList.add('aktif');
        three.classList.add('aktif');
        four.classList.add('aktif');
        five.classList.remove('aktif');
        six.classList.remove('aktif');
    }
    five.onclick = function(){
        one.classList.add('aktif');
        two.classList.add('aktif');
        three.classList.add('aktif');
        four.classList.add('aktif');
        five.classList.add('aktif');
        six.classList.remove('aktif');
    }
    six.onclick = function(){
        one.classList.add('aktif');
        two.classList.add('aktif');
        three.classList.add('aktif');
        four.classList.add('aktif');
        five.classList.add('aktif');
        six.classList.add('aktif');
    }

</script> --}}
