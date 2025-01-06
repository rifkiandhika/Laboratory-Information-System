@extends('layouts.admin')
@section('title')
Dashboard|Spesiment
@endsection
@section('content')
<style>
    <style>
    ::-webkit-scrollbar {
        width: 5px; 
    }
    ::-webkit-scrollbar-thumb {
        background: lightgray;
        border-radius: 10px;
    }
    .scrollbox{
        overflow: auto;
    }
        .subtext {
            text-align: center;
            font-size: 1.2rem;
            margin-bottom: 1rem;
            font-weight: bold;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .detail-container {
            display: flex;
            gap: 20px; /* Space between items */
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100px; /* Adjust width as needed */
        }

        .detail-text {
            text-align: center;
            margin-bottom: 5px;
        }

        .detail-image-container {
            text-align: center;
        }

        .detail-image {
            display: block;
            margin-bottom: 5px;
        }

        .detail-radio-container {
            text-align: center;
        }

        .detail-radio {
            margin-top: 5px;
        }
</style>
</style>
<section>
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class=" mt-3">
                <h1 class="h3 mb-0 ml-2 text-gray-600">Dashboard Laboratorium</h1>
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
                    <div class="card card-border-shadow-primary h-100">
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
                    <div class="card card-border-shadow-warning h-100">
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
                    <div class="card card-border-shadow-success h-100">
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
                    <div class="card card-border-shadow-info h-100">
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
                                <a href="#" id="konfirmasiallselecteddata" type="button" class="btn btn-outline-primary mb-2 mt-2 " >Check In</a>
                            </div>
                        </div>
                        <div class="card-body card-datatable">
                            <div class="table-responsive" style="width: 100%;">
                                <table class="table table-striped w-100 d-block d-md-table" id="myTable">
                                    @php
                                        $no=1;
                                    @endphp
                                    <thead >

                                        <th class="sorting_disabled"><input style="font-size: 20px; cursor: pointer;clear:" type="checkbox" name="" id="select_all_ids" class="form-check-input" ></th>
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

                                                <td><input style="font-size: 20px; cursor: pointer;" type="checkbox" name="ids" id="checkbox" class="form-check-input checkbox_ids" value="{{ $data1->id }}"></td>
                                                @else
                                                <td style="visibility: hidden">{{ $no++ }}</td>
                                                @endif

                                            <td>
                                                <i class='ti ti-bell-filled {{ $data1->cito == '1' ? 'text-danger' : 'text-secondary' }}' style="font-size: 23px;"></i>

                                            </td>
                                                <td scope="row">{{ $data1->no_rm }}</td>
                                                <td scope="row">{{ $data1->no_lab }}</td>
                                                <td scope="row">{{ $data1->nama }}</td>
                                                {{-- <td>{!! DNS1D::getBarcodeHTML('$ '. $data1->no_lab, 'C39') !!}</td> --}}
                                                <td>
                                                    @if($data1->status == 'Telah Dikirim ke Lab')
                                                        <span class="badge bg-warning text-white">Sent to lab</span>
                                                    @elseif($data1->status == 'Disetujui oleh analis lab')
                                                        <span class="badge bg-success text-white">Approved of analyst</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary btn-preview" data-id={{ $data1->id }} data-bs-target="#modalSpesimen"
                                                        data-bs-toggle="modal" ><i class="ti ti-temperature"></i></button>
    
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
        <div class="modal fade" id="modalSpesimen" tabindex="-1" role="dialog"aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sampleHistoryModalLabel">Detail Inspection Patient</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style=" max-height: 600px; overflow-y: auto" id="pembayaran-pasien">
                        <form action="{{ route('analyst.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div>
                                <h5>Inspection Details</h5>
                                <hr>
                                <div id="patientDoctorInfo"></div>
                                <div id="detailSpesiment">
                                    {{-- <input type="hidden" name="no_lab" value="{{ $dataPasien->no_lab }}"> --}}
                                </div>
                                </div>
                            </div>
                            <br>
                            <div class="modal-footer">
                                <button class="btn btn-success btn-verify" id="verification" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>

                 </div>
            </div>
        </div>


</section>

@endsection
@push('script')
<script>
    $(function() {
        let detailSpesiment = document.getElementById('detailSpesiment');
        $('.btn-preview').on('click', function() {
            const id = this.getAttribute('data-id');

            fetch(`/api/get-data-pasien/${id}`).then(response => {
                if (!response.ok) {
                    throw new Error("HTTP error" + response.status);
                }
                return response.json();
            }).then(res => {
                if (res.status === 'success') {
                    data_pasien = res.data;
                    data_pemeriksaan_pasien = res.data.dpp;
                    let status = data_pasien.status;
                    
                    // Menyembunyikan atau menampilkan bagian verifikasi
                    if (status == 'Spesiment') {
                        $('#verification').attr('style', `display:none`);
                    } else {
                        $('#verification').attr('style', `display:inherit`);
                    }

                    console.log(data_pasien);
                    console.log(data_pemeriksaan_pasien);

                    // HTML untuk informasi pasien dan dokter yang diambil dari res.data
                    let patientDoctorHTML = `
                    <div class="modal-body" style="max-height: 700px;">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                Pasien
                                <hr>
                                <table class="table table-borderless">
                                    <tr>
                                        <th scope="row">No.Lab</th>
                                        <td>
                                            <div class="flex-container">
                                                :  <span class="ms-2" id="Nolab">${res.data.no_lab}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Cito</th>
                                        <td>
                                            <div class="flex-container">
                                                <span class="label">:</span>
                                                <i class="ti ti-bell-filled" id="Cito">${res.data.cito ? 'Cito' : ''}</i>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>NIK</th>
                                        <td>
                                            <div class="flex-container">
                                              :  <span id="Nik">${res.data.nik}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nama</th>
                                        <td>
                                            <div class="flex-container">
                                               : <span id="Nama">${res.data.nama}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <td>
                                            <div class="flex-container">
                                              : <span id="Gender">${res.data.jenis_kelamin}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>
                                            <div class="flex-container">
                                               : <span id="Alamat">${res.data.alamat}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>No. Telepon</th>
                                        <td>
                                            <div class="flex-container">
                                               : <span id="Telp">${res.data.no_telp}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Pelayanan</th>
                                        <td>
                                            <div class="flex-container">
                                               : <span id="JenisPelayanan">${res.data.jenis_pelayanan}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Ruangan</th>
                                        <td>
                                            <div class="flex-container">
                                               : <span id="Ruangan">${res.data.asal_ruangan}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                    </div>`;

                    // Masukkan HTML informasi pasien dan dokter ke dalam modal
                    $('#patientDoctorInfo').html(patientDoctorHTML);

                    // Mulai menghasilkan detail Spesiment
                    let detailContent = '<div class="row">';
                    let Tabung = {};

                    data_pemeriksaan_pasien.forEach((e, i) => {
                        detailContent += `          <input type="hidden" name="no_lab" value="${e.no_lab}">
                                                    <div class="col-12 col-md-6" id="${e.id_departement}">
                                                    <h6>${e.data_departement.nama_department}</h6>
                                                    <ol>`;
                        e.pasiens.forEach(e => {
                            detailContent += `<li>${e.data_pemeriksaan.nama_pemeriksaan}</li>`;
                            if (!Tabung[e.spesiment]) {
                                Tabung[e.spesiment] = [];
                            }
                            Tabung[e.spesiment] += `<li>${e.data_pemeriksaan.nama_pemeriksaan}</li>`;
                        });
                        detailContent += `</ol><hr></div>`;
                    });
                    detailContent += '</div>';

                    Object.keys(Tabung).forEach(spesiment => {
                        res.data.spesiment.forEach((e, i) => {
                            let details = '';
                            if (e.details && e.details.length > 0) {
                                details = `<div class="detail-container col-12 col-md-6">`;
                                e.details.forEach(detail => {
                                    const imageUrl = `/gambar/${detail.gambar}`;
                                    const isChecked = (e.tabung === 'EDTA' && detail.nama_parameter === 'Normal') ||
                                                      (e.tabung === 'K3' && detail.nama_parameter === 'Normal') ? 'checked' : '';

                                    details +=  
                                    `<div class="detail-item">
                                        <div class="detail-text">${detail.nama_parameter}</div>
                                        <div class="detail-image-container">
                                            <img src="${imageUrl}" alt="${detail.nama_parameter}" width="35" class="detail-image"/>    
                                        </div>
                                        <div class="detail-radio-container">
                                            ${e.tabung === 'EDTA' ? `<input type="radio" name="kapasitas[]" value="${detail.id}" class="detail.radio" ${isChecked}/>` : ''}
                                            ${e.tabung === 'K3' ? `<input type="radio" name="serumh[]" value="${detail.id}" class="detail.radio" ${isChecked}/>` : ''}  
                                        </div>
                                    </div>`;
                                });
                                details += `</div>`;
                            }

                            let title = '';
                            let subtext = '';
                            if (e.tabung === 'EDTA') {
                                title = '<h5 class="title">Pengambilan Spesimen</h5> <hr>';
                            }

                            let note = '';
                            if (e.tabung === 'EDTA' || e.tabung === 'K3') {
                                note = '<p class="mb-0"><strong>Note</strong></p>';
                            }

                            detailContent += `${title}
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
                                                ${e.tabung === 'EDTA' ? `<textarea class="form-control" name="note[]" row="3" placeholder="Tulis catatan disini"></textarea>` : ''}
                                                ${e.tabung === 'K3' ? `<textarea class="form-control" name="note[]" row="3" placeholder="Tulis catatan disini"></textarea>` : ''}
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                        });
                    });

                    // Masukkan detail spesimen ke dalam modal
                    detailSpesiment.innerHTML = detailContent;
                    console.log(detailContent);
                }
            });
        });
    });
</script>


{{-- <script>
    $(function() {
        let detailSpesiment = document.getElementById('detailSpesiment');
        $('.btn-preview').on('click', function() {
            const id = this.getAttribute('data-id');

            fetch(`/api/get-data-pasien/${id}`).then(response => {
                if (!response.ok) {
                    throw new Error("HTTP error" + response.status);
                }
                return response.json();
            }).then(res => {
                if (res.status === 'success') {
                    data_pasien = res.data;
                    data_pemeriksaan_pasien = res.data.dpp;
                    let status = data_pasien.status;
                     if(status == 'Spesiment'){
                                 $('#verification').attr('style',`display:none`);
                             }
                             else{
                                 $('#verification').attr('style',`display:inherit`);
                             }

                    console.log(data_pasien);
                    console.log(data_pemeriksaan_pasien);
                    // if (!data_pasien.dokter) {
                    // console.error('Data dokter null');
                    // return;
                    // }

                    let detailContent = '<div class="row">';
                    let Tabung = {};

                    data_pemeriksaan_pasien.forEach((e, i) => {
                        // console.log(e.data);
                        detailContent += `          <input type="hidden" name="no_lab" value="${e.no_lab}">
                                                    <div class="col-12 col-md-6" id="${e.id_departement}">
                                                    <h6>${e.data_departement.nama_department}</h6>
                                                    <ol>`;
                        e.pasiens.forEach(e => {
                            detailContent += `<li>${e.data_pemeriksaan.nama_pemeriksaan}</li>`;
                            if(!Tabung[e.spesiment]) {
                                Tabung[e.spesiment] = [];
                            }
                            Tabung[e.spesiment] += `<li>${e.data_pemeriksaan.nama_pemeriksaan}</li>`;  
                        });
                        detailContent += `</ol><hr></div>`;
                    });
                    detailContent += '</div>';

                    Object.keys(Tabung).forEach(spesiment => {

                      res.data.spesiment.forEach((e, i) => {
                                let details = '';
                        
                                if (e.details && e.details.length > 0){
                                    details = `<div class="detail-container col-12 col-md-6">`;
                                    e.details.forEach(detail => {
                                        const imageUrl = `/gambar/${detail.gambar}`;
                                        const isChecked = (e.tabung === 'EDTA' && detail.nama_parameter === 'Normal' ) ||
                                                            (e.tabung === 'K3' && detail.nama_parameter === 'Normal' ) ? 'checked' : '';

                                        // const approvedDetail = res.data.approvedDetails.find(d => d.id === detail.id);
                                        // const approvedChecked = approvedDetail ? 'checked' : '';
                                        // const approvedNote = approvedDetail ? approvedDetail.note : '';

                                        details +=  
                                        `<div class="detail-item">
                                            <div class="detail-text">${detail.nama_parameter}</div>
                                            <div class="detail-image-container">
                                                <img src="${imageUrl}" alt="${detail.nama_parameter}" width="35" class="detail-image"/>    
                                            </div>
                                            <div class="detail-radio-container">
                                                ${e.tabung === 'EDTA' ? `<input type="radio" name="kapasitas[]" value="${detail.id}" class="detail.radio" ${isChecked}/>` : ''}
                                                ${e.tabung === 'K3' ? `<input type="radio" name="serumh[]" value="${detail.id}" class="detail.radio" ${isChecked}/>` : ''  }  
                                            </div>
                                        </div>`;
                                    });
                                    details += `</div>`
                                }

                                let title = '';
                                let subtext = '';

                                if (e.tabung === 'EDTA') {
                                    title = '<h5 class="title">Spesiment Collection</h5> <hr>';
                                }else

                                if (e.tabung === 'K3') {
                                }else

                                if (e.tabung === 'CLOT-ACT') {
                                    title = '<h5 class="title mt-3">Spesiment Handlings</h5> <hr>';
                                    subtext = '<div class="subtext">Serum</div>';
                                }

                                let note = '';
                                if (e.tabung === 'EDTA' || e.tabung === 'CLOT-ACT' || e.tabung === 'K3') {
                                    note = '<p class="mb-0"><strong>Note</strong></p>';
                                }
                                
                                detailContent += `${title}
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
                                                    ${e.tabung === 'K3' ? `<textarea class="form-control" name="note[]" row="3" placeholder="Write a note here"></textarea>` : ''}
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        </div>`;
                             });
                     
                    });
                    
                    detailSpesiment.innerHTML = detailContent;
                    console.log(detailContent);
                }
            });
        });
    })
</script> --}}

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
                let detailDashboard = document.getElementById('detailDashboard');
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
                            $('#Dokter').text(dokter != null ? dokter.nama_dokter : '-');
                            $('#Ruangandok').text(asal_ruangan);
                            $('#Telpdok').text(dokter != null ? dokter.no_telp : '-');
                            $('#Email').text(dokter != null ? dokter.email : '-');
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
                            detailDashboard.innerHTML = detailContent;
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
