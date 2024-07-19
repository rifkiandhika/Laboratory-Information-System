@extends('layouts.admin')
@section('content')
<section>
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex ">
                <h1 class="h3 mb-0 text-gray-600">Dashboard Laboratorium</h1>
            </div>
            @php
                $no1=1;
                $no2=1;
                $no3=1;
            @endphp

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
                                    <div class="h3 mt-3 font-weight-bold text-gray-600">@if ($pasienharian->count() == null)0
                                        @elseif($pasienharian->count() !== 0)

                                     @foreach($pasienharian as $ph)
                                        {{ $no1++ }}
                                    @endforeach @endif</div>
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
                                    <div class="h3 mt-3 font-weight-bold text-gray-600">15</div>
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
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Pasien Telah Dilayani
                                    </div>
                                    <div class="h3 mt-3 font-weight-bold text-gray-600">@foreach ($dataPasien as $dp)
                                        @php
                                            $no3++
                                        @endphp
                                    @endforeach
                                @foreach ($dataPasienCito as $dpc)
                                        @php
                                            $no3++
                                        @endphp
                                @endforeach{{ $no3 }}</div>
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
                <div class="col-xl-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="d-flex justify-content-between">
                                <h6 class="m-0 font-weight-bold" style="color: #96B6C5;">Antrian Pasien</h6>
                                <a href="#" id="konfirmasiallselecteddata" type="button" class="btn btn-success mb-3 " >Check In <i class="bi bi-check2"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-scroll table-pasien" style="width: 100%;">
                                <table class="table table-striped table-bordered w-100 d-block d-md-table" id="myTable">
                                    @php
                                        $no=1;
                                    @endphp
                                    <thead >

                                        <th><input style="font-size: 20px;clear:" type="checkbox" name="" id="select_all_ids" class="form-check-input" ></th>
                                            <th scope="col">Cito</th>
                                            <th scope="col">No RM</th>
                                            <th scope="col">No Lab</th>
                                            <th scope="col">Nama</th>
                                            {{-- <th scope="col" style="max-width: min-content">Barcode</th> --}}
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>

                                    </thead>
                                    <tbody style="font-size: 14px">
                                        @foreach ($dataPasien as $data1)
                                            <tr id="voucher{{ $data1->id }}">
                                                @if ($data1->status == 'Disetujui oleh analis lab')

                                                <td><input style="font-size: 20px" type="checkbox" name="ids" id="checkbox" class="form-check-input checkbox_ids" value="{{ $data1->id }}"></td>
                                                @else
                                                <td style="visibility: hidden">{{ $no++ }}</td>
                                                @endif

                                            <td>
                                                <i class='bi bi-bell-fill {{ $data1->cito == '1' ? 'text-danger' : 'text-secondary' }}' style="font-size: 23px;color:red !important"></i>

                                            </td>
                                                <td scope="row">{{ $data1->no_rm }}</td>
                                                <td scope="row">{{ $data1->no_lab }}</td>
                                                <td scope="row">{{ $data1->nama }}</td>
                                                {{-- <td>{!! DNS1D::getBarcodeHTML('$ '. $data1->no_lab, 'C39') !!}</td> --}}
                                                <td>

                                                    @if ($data1->status == 'Disetujui oleh analis lab')
                                                    <span class="badge bg-success">{{ $data1->status }}</span>
                                                    @else
                                                    <span class="badge bg-warning">{{ $data1->status }}</span>

                                                    @endif
                                                </td>
                                                <td class="d-flex">
                                                    <button type="button" data-bs-target="#modalPreviewPasien"
                                                    data-bs-toggle="modal" class="btn btn-info btn-edit text-white "
                                                    data-id="{{ $data1->id }}"><i class='bi bi-eye'></i></button>
                                                  </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Preview Pasien --}}
    <div class="modal fade" id="modalPreviewPasien" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">Preview Patient</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="pembayaran-pasien" style="max-height: 700px;">
                <div class="row">
                    <div class="col-12 col-md-5">
                        Patient
                        <hr>
                        <table class="table table-borderless">
                            <tr>
                                <th scope="row">No.Lab</th>
                                <td>
                                    <div class="flex-container">
                                        <span class="label">:</span>
                                        <input type="text" class="form-control-plaintext input p-0"
                                            id="Nolab">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Cito</th>
                                <td>
                                    <div class="flex-container">
                                        <span class="label"></span>
                                        <i class="bi bi-bell-fill" id="Cito"></i>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>NIK</th>
                                <td>
                                    <div class="flex-container">
                                        <span class="label">:</span>
                                        <input type="text" class="form-control-plaintext input p-0"
                                            id="Nik">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>
                                    <div class="flex-container">
                                        <span class="label">:</span>
                                        <input type="text" class="form-control-plaintext input p-0"
                                            id="Nama">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td>
                                    <div class="flex-container">
                                        <span class="label">:</span>
                                        <input type="text" class="form-control-plaintext input p-0"
                                            id="Gender">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>
                                    <div class="">
                                        <span class="label">:</span>
                                        <input type="text" class="form-control-plaintext input p-0"
                                            id="Alamat">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Phone Number</th>
                                <td>
                                    <div class="flex-container">
                                        <span class="label">:</span>
                                        <input type="text" class="form-control-plaintext input p-0"
                                            id="Telp">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Service</th>
                                <td>
                                    <div class="flex-container">
                                        <span class="label">:</span>
                                        <input type="text" class="form-control-plaintext input p-0"
                                            id="JenisPelayanan">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Room</th>
                                <td>
                                    <div class="flex-container">
                                        <span class="label">:</span>
                                        <input type="text" class="form-control-plaintext input p-0"
                                            id="Ruangan">
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-12 col-md-6">
                        Doctor
                        <hr>
                        <table class="table table-borderless">
                            <tr>
                                <th>Doctor Name</th>
                                <td> : <span id="Dokter"></span></td>
                            </tr>
                            <tr>
                                <th>Room</th>
                                <td> : <span id="Ruangandok"></span></td>
                            </tr>
                            <tr>
                                <th>Phone Number</th>
                                <td> : <span id="Telpdok"></span></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td> : <span id="Email"></span></td>
                            </tr>
                            <tr>
                                <th>
                                    <p>Diagnosis</p>
                                </th>
                                <td>
                                    <textarea class="form-control" disabled name="diagnosa" id="Diagnosa" cols="15" rows="5"></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <form method="post" id="form">
                    @csrf
                    <label for="" id="notelabel">Note</label>
                    <textarea  class="form-control" placeholder="Note" name="note"  id="note" cols="30" rows="8"></textarea>
                    <input type="hidden" id="no_lab" name="no_lab" value="">
            </div>

                <div class="modal-footer">
                    <button class="btn btn-success" id="verification" type="submit">Verification</button>
                </div>
            </form>

        </div>
    </div>

</section>

@endsection
@push('script')
            <script>
            $(function(e){
            $("#select_all_ids").click(function(){
                $('.checkbox_ids').prop('checked',$(this).prop('checked'));
            });
            $('#konfirmasiallselecteddata').click(function(e){
                e.preventDefault();
                var all_ids = [];
                $('input:checkbox[name=ids]:checked').each(function(){
                    all_ids.push($(this).val());
                });

                $.ajax({
                    url:"{{ route('analyst.checkinall') }}",
                    method:"POST",
                    data:{
                        ids:all_ids,
                        _token:'{{csrf_token()}}'
                    },
                    success:function(response){
                        $.each(all_ids,function(key,val){
                            $('#voucher'+val).remove();
                        })
                        location. reload()

                    }
                })
            })
            });

            </script>
            <script>
            $(function() {
                // ngambil data dari id = detailPemeriksaan
                let detailPemeriksaan = document.getElementById('detailPemeriksaan');
                // button preview waktu di klik mendapatkan data sesuai id
                $('.btn-edit').on('click', function() {
                    // untuk mendapatkan data sesuai idnya
                    const id = this.getAttribute('data-id');

                    // Memanggil API
                    fetch(`/api/get-data-pasien/${id}`).then(response => {
                        if (!response.ok) {
                            throw new Error("HTTP error" + response.status);
                        }
                        return response.json();
                    }).then(res => {
                        if (res.status === 'success') {
                            const {
                                id,
                                cito,
                                no_lab,
                                nik,
                                nama,
                                jenis_kelamin,
                                no_telp,
                                alamat,
                                jenis_pelayanan,
                                asal_ruangan,
                                diagnosa,
                                status,
                            } = res.data;

                            dokter = res.data.dokter;
                            data_pemeriksaan_pasien = res.data.dpp;
                            if(status == 'Disetujui oleh analis lab'){
                                $('#verification').attr('style',`display:none`);
                                $('#note').attr('style',`display:none`);
                                $('#notelabel').attr('style',`display:none`);

                            }
                            else{
                                $('#verification').attr('style',`display:inherit`);
                            }

                            $('#form').attr('action',`approve/${id}`);
                            $('#no_lab').attr('value',no_lab);
                            $('#Cito').val(cito == 1 ? 'text-danger' : 'text-secondary');
                            $('#Nolab').val(no_lab);
                            $('#Nik').val(nik);
                            $('#Nama').val(nama);
                            $('#Gender').val(jenis_kelamin);
                            $('#Alamat').val(alamat);
                            $('#Telp').val(no_telp);
                            $('#JenisPelayanan').val(jenis_pelayanan);
                            $('#Ruangan').val(asal_ruangan);
                            const citoIcon = $('#Cito');
                            if (cito == '1') {
                                citoIcon.removeClass('text-secondary').addClass('text-danger');
                            } else {
                                citoIcon.removeClass('text-danger').addClass('text-secondary');
                            }
                            $('#Nolab').text(no_lab);
                            $('#Nik').text(nik);
                            $('#Nama').text(nama);
                            $('#Gender').text(jenis_kelamin);
                            $('#Alamat').text(alamat);
                            $('#Telp').text(no_telp);
                            $('#JenisPelayanan').text(jenis_pelayanan);
                            $('#Ruangan').text(asal_ruangan);
                            $('#Dokter').text(dokter.nama_dokter);
                            $('#Ruangandok').text(asal_ruangan);
                            $('#Telpdok').text(dokter.no_telp);
                            $('#Email').text(dokter.email);
                            $('#Diagnosa').val(diagnosa);

                            let old = 0;
                            let detailContent = '<div class="row">';
                            let subContent = [];
                                // memanggil data departement
                            data_pemeriksaan_pasien.forEach((e, i) => {
                                // console.log(e.data);
                                detailContent += `<div class="col-12 col-md-6" id="${e.id_departement}">
                                                            <h6>${e.data_departement.nama_department}</h6>
                                                            <ol>`;
                                e.pasiens.forEach((e, i) => {
                                    console.log(e.data_pemeriksaan);
                                    detailContent +=
                                        `<li>${e.data_pemeriksaan.nama_pemeriksaan}- Rp ${e.data_pemeriksaan.harga}</li>`;
                                });
                                detailContent += `</ol></div>`;
                            });
                            console.log(data_pemeriksaan_pasien);
                            detailContent += '</div>';
                            // console.log(detailContent);
                            // menampilkan data yang diambil dari API
                            detailPemeriksaan.innerHTML = detailContent;
                            // if (data_pemeriksaan_pasien.length > 0) {
                            //     const department = data_pemeriksaan_pasien[0].department;
                            //     $('#Department').text(department.nama_department);
                            // }

                        }
                    });
                    // Form edit
                    // $('#modalPreviewPasien').attr('action', '/poli/' + id);

                });
            })
            </script>
    <script src="{{ asset('js/time.js') }}"></script>
@endpush
