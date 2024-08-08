<title>Tambah Pasien</title>
@extends('layouts.admin')

@section('title', 'Tambah Pasien')

@section('content')
<section>
    <div class="content">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex  mt-3">
                <h1 class="h3 mb-0 text-gray-600">Add New Patient</h1>
            </div>
            <!-- Content Row -->
            <div class="row mt-3">
                <!-- Form Area -->
                <div class="col-xl-12 col-lg-12">
                    <div class="card shadow mb-4">

                        <!-- Card Body -->
                        <div class="card-body">
                            <form action="{{ route('pasien.store') }}" method="post">
                                @csrf
                                <div class="d-flex justify-content-between">
                                    <p class="h5">Patient Data</p>
                                    <div class="row" style="margin-top: -5px;">
                                        <label for="staticEmail" class="col-sm-4 col-form-label">No LAB :</label>
                                        <div class="col-lg">
                                            <input type="text" readonly class="form-control-plaintext font-bold"
                                                id="no-lab" name="nolab" value="{{ $no_lab }}">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-row">
                                    <div class="form-group col-12">
                                        <label for="basic-url">Cito</label>
                                        <div class="form-check">
                                            <input style="cursor: pointer" class="form-check-input child-pemeriksaan-hematologi" type="checkbox"
                                                name="cito" value="1" id="cito">
                                            <label class="form-check-label" for="cito">
                                                Patient Cito
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="basic-url">No RM</label>
                                        <div class="input-group mb-6">
                                            <input type="number" class="form-control" name="norm" aria-label=""
                                                placeholder="Masukan No RM">
                                        </div>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="basic-url">Nomor Induk Kewarganegaraan</label>
                                        <div class="input-group mb-6">
                                            <input type="number" class="form-control" name="nik" aria-label=""
                                                placeholder="Add NIK">
                                        </div>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="basic-url">Full Name</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="nama" aria-label=""
                                                placeholder="Add Full Name">
                                        </div>
                                    </div>
                                    <div class="form-group col-12">
                                        <!-- <label for="name" class="">Date</label> -->
                                        <label for="startDate">Date Of Birth</label>
                                        <input id="startDate" class="form-control" type="date" name="tanggallahir" />
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="exampleFormControlSelect1">Gender</label>
                                        <select class="form-select" id="exampleFormControlSelect1" name="jeniskelamin">
                                            <option selected>Select Gender</option>
                                            <option value="Laki²">Laki²</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="phonenumber">Phone Number</label>
                                            <input type="number" class="form-control" name="notelepon" placeholder="Add Phone Number">
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="exampleFormControlSelect1">Doctor</label>
                                        <select class="form-select" id="exampleFormControlSelect1" name="dokter">
                                            <option selected hidden>Choose</option>
                                            {{-- <option value="1">Permintaan Sendiri</option> --}}
                                            @foreach ($dokters as $dokter)
                                                <option value="{{ $dokter->kode_dokter }}">{{ $dokter->nama_dokter }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="name">Room</label>
                                        <input type="text " class="form-control"
                                            name="asal_ruangan" placeholder="Add Room">
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="name">Diagnosis</label>
                                        <select name="diagnosa" id="diagnosa" class="form-control diagnosa">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Full Address</label>
                                        <textarea class="form-control ml-1" cols="119" rows="2" id="alamat" name="alamat"></textarea>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="basic-url">Kind Of Service</label>
                                        <div class="row">
                                            <div class="ml-4">
                                                <input style="cursor: pointer" class="form-check-input child-pemeriksaan-hematologi" type="radio"
                                                    name="jenispelayanan" value="umum" id="umum" checked>
                                                <label class="form-check-label" for="umum">
                                                    Umum
                                                </label>
                                            </div>
                                            <div class=" ml-4">
                                                <input style="cursor: pointer" class="form-check-input child-pemeriksaan-hematologi"
                                                    type="radio" name="jenispelayanan" value="bpjs" id="bpjs">
                                                <label class="form-check-label" for="bpjs">
                                                    BPJS
                                                </label>
                                            </div>
                                            <div class="ml-4">
                                                <input style="cursor: pointer" class="form-check-input child-pemeriksaan-hematologi"
                                                    type="radio" name="jenispelayanan" value="asuransi"
                                                    id="asuransi">
                                                <label class="form-check-label" for="asuransi">
                                                    Asuransi
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="h5">Choose Inspection</p>
                                <hr>
                                <div class="row">
                                    @foreach ($departments as $departement)
                                        <div class="col-xl-3">
                                            <!-- Parent Pemeriksaan -->
                                            <div class="parent-pemeriksaan" id="parent-pemeriksaan">
                                                <div class="heading heading-color btn-block  mb-3">
                                                    <strong>{{ $departement->nama_department }}</strong>
                                                </div>
                                                <!-- Child pemeriksaan -->
                                                <div class="child-pemeriksaan" id="child-pemeriksaan-hematologi">
                                                    @foreach ($departement->detailDepartments as $x => $pemeriksaan)
                                                        <div class="form-check">
                                                            <input style="cursor: pointer" class="form-check-input child-pemeriksaan"
                                                                type="checkbox" name="pemeriksaan[]"
                                                                value="{{ $pemeriksaan->id }}"
                                                                id="{{ $pemeriksaan->id_departement . '-' . $x }}"
                                                                onclick="checkpemeriksaan({{ $pemeriksaan->harga }})"
                                                                data-harga="{{ $pemeriksaan->harga }}">
                                                            <label class="form-check-label"
                                                                for="{{ $pemeriksaan->id_departement . '-' . $x }}">
                                                                {{ $pemeriksaan->nama_pemeriksaan }}
                                                                Rp.{{ number_format($pemeriksaan->harga, 0, ',', '.') }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                    @endforeach
                                </div>
                                <hr>
                                <div class="row pemeriksaan">
                                    <div class="col-5 d-flex">
                                        <label for="staticEmail" class="col-form-label">Total Price : <b>Rp.</b> </label>
                                        <div class="">
                                            <input type="text" class="form-control-plaintext font-bold"
                                                name="hargapemeriksaan" id="harga-pemeriksaan" value="0" readonly>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class=" text-end">
                                    <input class="btn btn-outline-primary" type="submit" value="Submit">
                                    <input class="btn btn-outline-danger" type="reset" value="Reset">   
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
{{-- <script>
    $(document).ready(function() {
        $('#diagnosa').select2({
            placeholder: 'Pilih Diagnosa',
            ajax: {
                url: '{{ route('geticd10') }}',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                    results:  $.map(data, function (item) {
                        return {
                        text: item.code + ' - ' + item.name_id,
                        id: item.code
                        }
                    })
                    };
                },
                cache: true
            }
        });
    });
</script> --}}


    <!-- Tambah form lain -->
    {{-- <script type="text/javascript">
$(document).ready(function(){

    var html = '<div class="form-group col-12 col-md-12 row mt-2" id="tambah-field-lain"><input type="text" class="form-control col-md-11" value="" id="" name="pemeriksaan-lain-lain[]" placeholder="Ketik Tambahan"><div class="col-md-1"><input type="button" class="btn btn-danger" value="-" id="remove"></div>';

    var x = 1;

    $("#add-lain").click(function(){
        $("#child-pemeriksaan-lain").append(html);
    });

    $("#child-pemeriksaan-lain").on('click','#remove',function(){
        $(this).closest('#tambah-field-lain').remove();
    });

});
</script> --}}
    <!-- End Tambah form lain -->
    {{-- <script>
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('get-icd10') }}",
                method: 'GET',
                success: function(data) {
                    var select = $('#icd10-select');
                    data.forEach(function(item) {
                        select.append('<option value="' + item.id + '">' + item.code + ' - ' +
                            item.description + '</option>');
                    });
                }
            });
        });
    </script> --}}


@push('script')

    <!-- hitung harga otomatis saat memilih checkbox mengambil harga dari database -->
    <script type="text/javascript">
        function checkpemeriksaan(lab) {
            var total = 0;
            var harga = 0;
            var harga_pemeriksaan = document.getElementById('harga-pemeriksaan');
            var checkboxes = document.getElementsByClassName('child-pemeriksaan');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked == true) {
                    harga = checkboxes[i].getAttribute('data-harga');
                    total = parseInt(total) + parseInt(harga);
                }
            }

            //mengubah format angka ke rupiah
            var reverse = total.toString().split('').reverse().join(''),
                ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');

            harga_pemeriksaan.value = ribuan;
        }

        $(document).ready(function(){
            $("#diagnosa").select2({
                placeholder: 'Pilih Diagnosa',
                minimumInputLength: 3,
                ajax: {
                    url: '{{ url("/api/get-data-diagnosa") }}',
                    data: function(params){
                        let data = {
                            keyword: params.term
                        };

                        return data;
                    },
                    processResults: function(data){
                        if(data.status == 'fail') return false;
                        
                        let res = data.data.map((e) => ({id: e.str, text: e.text}));
                    
                        return {
                            results: res
                        };
                    }
                }
            });
        });
    </script>
@endpush