<title>Tambah Pasien</title>
@extends('layouts.admin')

@section('title', 'Tambah Pasien')

<link rel="stylesheet" href="{{ asset('bootstrap/css/sb-admin-2.css') }}">

@section('content')
    <div class="content">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex  mt-3">
                <h1 class="h3 mb-0 text-gray-600">Tambah Pasien Baru</h1>
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
                                    <p class="h5">Data Pasien</p>
                                    <div class="row" style="margin-top: -5px;">
                                        <label for="staticEmail" class="col-sm-4 col-form-label">No LAB :</label>
                                        <div class="col-lg">
                                            <input type="text" readonly class="form-control-plaintext font-weight-bold"
                                                id="no-lab" name="nolab" value="{{ $no_lab }}">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-row">
                                    <div class="form-group col-12 col-md-6">
                                        <label for="basic-url">Cito</label>
                                        <div class="form-check">
                                            <input class="form-check-input child-pemeriksaan-hematologi" type="checkbox"
                                                name="cito" value="1" id="cito">
                                            <label class="form-check-label" for="cito">
                                                Pasien Cito
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-12 col-md-6">
                                        <label for="basic-url">No RM</label>
                                        <div class="input-group mb-6">
                                            <input type="text" class="form-control" name="norm" aria-label=""
                                                placeholder="Masukan No RM">
                                        </div>
                                    </div>
                                    <div class="form-group col-12 col-md-6">
                                        <label for="basic-url">Nomor Induk Kewarganegaraan</label>
                                        <div class="input-group mb-6">
                                            <input type="number" class="form-control" name="nik" aria-label=""
                                                placeholder="Masukan NIK">
                                        </div>
                                    </div>
                                    <div class="form-group col-12 col-md-6">
                                        <label for="basic-url">Nama Lengkap</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="nama" aria-label=""
                                                placeholder="Masukkan Nama Lengkap">
                                        </div>
                                    </div>
                                    <div class="form-group col-12 col-md-6">
                                        <!-- <label for="name" class="">Date</label> -->
                                        <label for="startDate">Tanggal Lahir</label>
                                        <input id="startDate" class="form-control" type="date" name="tanggallahir" />
                                    </div>
                                    <div class="form-group col-12 col-md-6">
                                        <label for="exampleFormControlSelect1">Jenis Kelamin</label>
                                        <select class="form-control" id="exampleFormControlSelect1" name="jeniskelamin">
                                            <option selected>Pilih Jenis Kelamin</option>
                                            <option value="Laki - Laki">Laki - Laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-6">
                                        <label for="name">No Telepon / Hp</label>
                                        <input type="number " class="form-control" value="" id=""
                                            name="notelepon" placeholder="Masukan Nomor Telephone">
                                    </div>
                                    <div class="form-group col-12 col-md-6">
                                        <label for="exampleFormControlSelect1">Dokter Pengirim</label>
                                        <select class="form-control" id="exampleFormControlSelect1" name="dokter">
                                            <option selected hidden>Pilih</option>
                                            <option value="1">Permintaan Sendiri</option>
                                            @foreach ($dokters as $dokter)
                                                <option value="{{ $dokter->kode_dokter }}">{{ $dokter->nama_dokter }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-6">
                                        <label for="name">Diagnosa</label>
                                        <select name="diagnosa" id="diagnosa" class="form-control diagnosa">
                                            <option value="Demam Tifoid">Demam Tifoid</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-6">
                                        <label for="basic-url">Jenis Pelayanan</label>
                                        <div class="row">
                                            <div class="form-check ml-3">
                                                <input class="form-check-input child-pemeriksaan-hematologi" type="radio"
                                                    name="jenispelayanan" value="umum" id="umum" checked>
                                                <label class="form-check-label" for="umum">
                                                    Umum
                                                </label>
                                            </div>
                                            <div class="form-check ml-3">
                                                <input class="form-check-input child-pemeriksaan-hematologi"
                                                    type="radio" name="jenispelayanan" value="bpjs" id="bpjs">
                                                <label class="form-check-label" for="bpjs">
                                                    BPJS
                                                </label>
                                            </div>
                                            <div class="form-check ml-3">
                                                <input class="form-check-input child-pemeriksaan-hematologi"
                                                    type="radio" name="jenispelayanan" value="asuransi"
                                                    id="asuransi">
                                                <label class="form-check-label" for="asuransi">
                                                    Asuransi
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-12 col-md-6">
                                        <label for="alamat">Alamat Lengkap</label>
                                        <textarea class="form-control" style="resize: none; height: 70px" id="alamat" name="alamat"></textarea>
                                    </div>
                                </div>
                                <p class="h5">Pilih Pemeriksaan</p>
                                <div class="row">
                                    <div class="col-8 d-flex">
                                        <label for="staticEmail" class="col-form-label">Total Harga : <b>Rp.</b> </label>
                                        <div class="">
                                            <input type="text" class="form-control-plaintext font-weight-bold"
                                                name="hargapemeriksaan" id="harga-pemeriksaan" value="0" readonly>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="row">
                                            <input class="form-control mr-sm-2 mb-2" type="search" placeholder="Search"
                                                aria-label="Search" name="search">

                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row pemeriksaan">
                                    @foreach ($departments as $departement)
                                        <div class="col-xl-3">
                                            <!-- Parent Pemeriksaan -->
                                            <div class="parent-pemeriksaan" id="parent-pemeriksaan">
                                                <div class="heading heading-color btn-block  mb-3">
                                                    <strong>{{ $departement->nama_department }}</strong>
                                                </div>
                                                <!-- Child pemeriksaan -->
                                                <div class="child-pemeriksaan" id="child-pemeriksaan-hematologi">
                                                    @foreach ($departement->pemeriksaan as $x => $pemeriksaan)
                                                        <div class="form-check">
                                                            <input class="form-check-input child-pemeriksaan"
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
                                <div class="mt-4 text-right small">
                                    <input class="btn btn-primary" type="submit" value="Submit">
                                    <input class="btn btn-danger" type="reset" value="Reset">
                                    <input class="btn btn-secondary" type="submit" value="Cancel">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


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
    </script>

@endsection
