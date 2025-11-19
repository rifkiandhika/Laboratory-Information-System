@extends('layouts.admin')

@section('title', 'Edit Patient')

@section('content')
<section>
    <div class="content">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex  mt-3">
                <h1 class="h3 mb-0 text-gray-600">Edit Data Patient</h1>
            </div>
            <!-- Content Row -->
            <div class="row mt-3">
                <!-- Form Area -->
                <div class="col-xl-12 col-lg-12">
                    <div class="card shadow mb-4">

                        <!-- Card Body -->
                        <div class="card-body">
                            <form action="{{ route('pasien.updatedata', $data_pasien->id) }}" method="post">
                                @csrf
                                @method('PUT')

                                <div class="d-flex justify-content-between">
                                    <p class="h5">Patient Data</p>
                                    <div class="row" style="margin-top: -5px;">
                                        <label for="staticEmail" class="col-sm-4 col-form-label fw-bold">No LAB :</label>
                                        <div class="col-lg">
                                            <input type="text" readonly class="form-control-plaintext fw-bold"
                                                name="nolab" value="{{ $data_pasien->no_lab }}">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="basic-url" class="fw-bold">Cito</label>
                                        <div class="form-check">
                                            <input style="cursor: pointer" class="form-check-input child-pemeriksaan-hematologi" type="checkbox"
                                                name="cito" value="1" id="cito" {{ $data_pasien->cito == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold" for="cito">
                                                Patient Cito
                                            </label>
                                        </div>
                                    </div>
                                    {{-- <div class="col-6 col-md-6">
                                        <label for="basic-url" class="fw-bold">Tanggal Order</label>
                                        <div class="input-group mb-6">
                                            <input 
                                                type="datetime-local" 
                                                class="form-control" 
                                                name="tanggal_masuk"
                                                value="{{ old('tanggal_masuk', $data_pasien->tanggal_masuk ? \Carbon\Carbon::parse($data_pasien->tanggal_masuk)->format('Y-m-d\TH:i') : '') }}">
                                        </div>
                                    </div> --}}
                                    <div class="col-6 col-md-6">
                                        <label for="basic-url" class="fw-bold">No RM</label>
                                        <div class="input-group mb-6">
                                            <input type="number" class="form-control" name="norm" aria-label=""
                                                placeholder="Masukan No RM" value="{{ $data_pasien->no_rm }}">
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-6">
                                        <label for="basic-url" class="fw-bold">Nomor Induk Kewarganegaraan</label>
                                        <div class="input-group mb-6">
                                            <input type="number" class="form-control" name="nik" aria-label=""
                                                placeholder="Add NIK" value="{{ $data_pasien->nik }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="basic-url" class="fw-bold">Full Name</label>
                                        <div class="input-group mb-6">
                                            <input type="text" class="form-control" name="nama" aria-label=""
                                                placeholder="Add Full Name" value="{{ $data_pasien->nama }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-6">
                                        <!-- <label for="name" class="">Date</label> -->
                                        <label for="startDate" class="fw-bold">Date Of Birth</label>
                                        <input id="startDate" class="form-control" type="date" name="tanggallahir" value="{{ $data_pasien->lahir }}"/>
                                    </div>
                                    <div class="col-md-6 mb-6">
                                        <label for="exampleFormControlSelect1" class="fw-bold">Gender</label>
                                        <select class="form-select" id="exampleFormControlSelect1" name="jeniskelamin">
                                            <option selected hidden>{{ $data_pasien->jenis_kelamin }}</option>
                                            <option value="Laki²">Laki²</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-6">
                                        <label for="phonenumber" class="fw-bold">Phone Number</label>
                                            <input type="number" class="form-control" name="notelepon" placeholder="Add Phone Number" value="{{ $data_pasien->no_telp }}">
                                    </div>
                                    <div class="col-md-6 mb-6">
                                        <label for="doctorSelect" class="fw-bold">Doctor Internal / Pengirim</label>
                                        <select class="form-select" id="doctorSelect" name="dokter_internal">
                                            <option value="" hidden>Choose...</option>
                                            @foreach ($dokterInternal as $dokter)
                                                <option value="{{ $dokter->nama_dokter }}"
                                                    {{ $data_pasien->dokter_internal == $dokter->nama_dokter ? 'selected' : '' }}>
                                                    {{ $dokter->nama_dokter }} ({{ $dokter->jabatan }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-6">
                                        <label for="externalDoctorSelect" class="fw-bold">Doctor External / Pengirim</label>
                                        <select class="form-select" id="externalDoctorSelect" name="dokter_external">
                                            <option value="" hidden>Choose...</option>
                                            @foreach ($dokterExternal as $dokter)
                                                <option value="{{ $dokter->nama_dokter }}"
                                                    {{ $data_pasien->dokter_external == $dokter->nama_dokter ? 'selected' : '' }}>
                                                    {{ $dokter->nama_dokter }} ({{ $dokter->jabatan }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-6">
                                        <label for="asal_ruangan" class="fw-bold">Room</label>
                                        <select class="form-select" id="asal_ruangan" name="asal_ruangan">
                                            <option value="" hidden>Choose...</option>
                                            @foreach ($poliInternal as $poli)
                                                <option value="{{ $poli->nama_poli }}"
                                                    {{ $data_pasien->asal_ruangan == $poli->nama_poli ? 'selected' : '' }}>
                                                    {{ $poli->nama_poli }}
                                                </option>
                                            @endforeach
                                            <option value="lainnya" {{ $data_pasien->asal_ruangan && !in_array($data_pasien->asal_ruangan, $poliInternal->pluck('nama_poli')->toArray()) ? 'selected' : '' }}>
                                                Lainnya...
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-6">
                                        <label for="name" class="fw-bold">Diagnosis</label>
                                        <select name="diagnosa" id="diagnosa" class="form-control diagnosa">
                                            <option selected hidden>{{ $data_pasien->diagnosa }}</option>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-6">
                                        <label for="name" class="fw-bold">Diagnosis</label>
                                        <input type="text" name="diagnosa" class="form-control" value="{{ $data_pasien->diagnosa }}" placeholder="Add Diagnosis">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="alamat" class="fw-bold">Full Address</label>
                                        <textarea class="form-control ml-1" cols="119" rows="1" id="alamat" name="alamat">{{ $data_pasien->alamat }}</textarea>
                                    </div>
                                    <div class="col-md-6 mb-6" id="noPasienField" style="display:none;">
                                        <label for="no.transaksi" class="fw-bold">No.Transaksi</label>
                                        <input type="number" class="form-control" name="no_pasien" 
                                            placeholder="e.g. 245483165"
                                            value="{{ $data_pasien->pembayaran->first()?->no_pasien }}">
                                    </div>
                                    <div class="col-md-6 mb-6" id="noAsuransi" style="display:none;">
                                        <label for="no.asuransi" class="fw-bold">No.Asuransi</label>
                                        <input type="number" class="form-control" name="no_pasien" 
                                            placeholder="e.g. 245483165"
                                            value="{{ $data_pasien->pembayaran->first()?->no_pasien }}">
                                    </div>
                                    <div class="col-md-6 mb-6" id="AsuransiPemjamin" style="display:none;">
                                        <label for="penjamin" class="fw-bold">Penjamin</label>
                                        <input type="penjamin" class="form-control" name="penjamin" 
                                            placeholder="e.g. Penjamin"
                                            value="{{ $data_pasien->pembayaran->first()?->no_pasien }}">
                                    </div>
                                    <div class="col-md-6 mb-6" id="noBPJS" style="display:none;">
                                        <label for="no.bpjs" class="fw-bold">No.BPJS</label>
                                        <input type="number" class="form-control" name="no_pasien" 
                                            placeholder="e.g. 245483165"
                                            value="{{ $data_pasien->pembayaran->first()?->no_pasien }}">
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="basic-url">Kind Of Service</label>
                                        <div class="row">
                                            <div class="ml-4 mb-2">
                                                <input style="cursor: pointer" class="form-check-input child-pemeriksaan-hematologi" type="radio"
                                                    name="jenispelayanan" value="umum" id="umum" {{ $data_pasien->jenis_pelayanan == 'umum' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="umum">
                                                    Umum
                                                </label>
                                            </div>
                                            <div class=" ml-4 mb-2">
                                                <input style="cursor: pointer" class="form-check-input child-pemeriksaan-hematologi"
                                                    type="radio" name="jenispelayanan" value="bpjs" id="bpjs" {{ $data_pasien->jenis_pelayanan == 'bpjs' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="bpjs">
                                                    BPJS
                                                </label>
                                            </div>
                                            <div class="ml-4">
                                                <input style="cursor: pointer" class="form-check-input child-pemeriksaan-hematologi"
                                                    type="radio" name="jenispelayanan" value="asuransi"
                                                    id="asuransi" {{ $data_pasien->jenis_pelayanan == 'asuransi' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="asuransi">
                                                    Asuransi
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-8">
                                        <h5>Choose Inspection</h5>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="searchInspection" class="form-control mb-3" placeholder="Search...">
                                    </div>
                                </div>
                                <hr>

                                {{-- Tampilkan peringatan jika status Result Review atau Diselesaikan --}}
                                @if(isset($data_pasien) && in_array($data_pasien->status, ['Result Review', 'diselesaikan']))
                                    <div class="alert alert-warning" role="alert">
                                        <i class="ti ti-alert-circle me-2"></i>
                                        <strong>Perhatian!</strong> Pemeriksaan tidak dapat diubah karena data pemeriksaan pasien sudah <strong>disimpan</strong>.
                                    </div>
                                @endif
                                <div class="row" id="inspectionList">
                                    @foreach ($departments as $departement)
                                        <div class="col-xl-3 inspection-item">
                                            <div class="parent-pemeriksaan">
                                                <div class="heading heading-color btn-block mb-3">
                                                    <strong>{{ $departement->nama_department }}</strong>
                                                </div>

                                                @php
                                                    $isDisabled = isset($data_pasien) && in_array($data_pasien->status, ['Result Review', 'diselesaikan']);
                                                @endphp

                                                @if($departement->statusdep === 'single')
                                                    {{-- SINGLE → langsung pakai judul --}}
                                                    @foreach ($departement->detailDepartments as $pemeriksaan)
                                                        @if ($pemeriksaan->status === 'active')
                                                            <div class="form-check">
                                                                <input style="cursor: pointer"
                                                                    class="form-check-input child-pemeriksaan"
                                                                    type="checkbox"
                                                                    name="pemeriksaan[]"
                                                                    value="{{ $pemeriksaan->id }}"
                                                                    id="pemeriksaan-{{ $pemeriksaan->id_departement }}-{{ $pemeriksaan->id }}"
                                                                    onclick="checkpemeriksaan({{ $pemeriksaan->harga }})"
                                                                    data-harga="{{ $pemeriksaan->harga }}"
                                                                    {{ in_array($pemeriksaan->id, $selectedInspections) ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="pemeriksaan-{{ $pemeriksaan->id_departement }}-{{ $pemeriksaan->id }}">
                                                                    {{ $pemeriksaan->judul }}
                                                                    Rp.{{ number_format($pemeriksaan->harga, 0, ',', '.') }}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endforeach

                                                @elseif($departement->statusdep === 'multi')
                                                    {{-- MULTI → group by judul --}}
                                                    @php
                                                        $grouped = $departement->detailDepartments
                                                            ->where('status', 'active')
                                                            ->groupBy('judul');
                                                    @endphp

                                                    @foreach ($grouped as $judul => $listPemeriksaan)
                                                        <div class="mb-2">
                                                            <div style="margin-left: 12px">
                                                                <strong>{{ $judul }}</strong>
                                                            </div>
                                                            @foreach ($listPemeriksaan as $pemeriksaan)
                                                                <div class="form-check ms-3">
                                                                    <input style="cursor: pointer"
                                                                        class="form-check-input child-pemeriksaan"
                                                                        type="checkbox"
                                                                        name="pemeriksaan[]"
                                                                        value="{{ $pemeriksaan->id }}"
                                                                        id="pemeriksaan-{{ $pemeriksaan->id_departement }}-{{ $pemeriksaan->id }}"
                                                                        onclick="checkpemeriksaan({{ $pemeriksaan->harga }})"
                                                                        data-harga="{{ $pemeriksaan->harga }}"
                                                                        {{ in_array($pemeriksaan->id, $selectedInspections) ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="pemeriksaan-{{ $pemeriksaan->id_departement }}-{{ $pemeriksaan->id }}">
                                                                        {{ $pemeriksaan->nama_pemeriksaan }}
                                                                        Rp.{{ number_format($pemeriksaan->harga, 0, ',', '.') }}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endforeach
                                                @endif
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
                                    <button class="btn btn-outline-primary" type="submit">Submit</button>   
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
@push('script')

<script>
$(document).ready(function() {
    @if(isset($data_pasien) && in_array($data_pasien->status, ['Result Review', 'diselesaikan']))
        // Disable semua checkbox pemeriksaan
        $('.child-pemeriksaan').prop('disabled', true);
        $('.child-pemeriksaan').css('cursor', 'not-allowed');
        $('.form-check-label').addClass('text-muted');
        
        // Disable search input juga (opsional)
        $('#searchInspection').prop('disabled', true);
        $('#searchInspection').attr('placeholder', 'Pencarian dinonaktifkan');
    @endif
    
    // Hitung total harga saat pertama kali load
    calculateTotalPrice();
});

// Fungsi untuk menghitung total harga
function calculateTotalPrice() {
    let totalHarga = 0;
    $('.child-pemeriksaan:checked').each(function() {
        totalHarga += parseFloat($(this).data('harga')) || 0;
    });
    $('#harga-pemeriksaan').val(totalHarga.toLocaleString('id-ID'));
}

// Override fungsi checkpemeriksaan
function checkpemeriksaan(harga) {
    @if(isset($data_pasien) && in_array($data_pasien->status, ['Result Review', 'Diselesaikan']))
        // Jangan lakukan apa-apa jika status locked
        return false;
    @else
        // Hitung ulang total harga
        calculateTotalPrice();
    @endif
}
</script>

    <script>
        $(document).ready(function() {
        $('#searchInspection').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            
            // Loop through the list of departments
            $('#inspectionList .parent-pemeriksaan').each(function() {
                var found = false;

                // Check each pemeriksaan within the department
                $(this).find('.form-check-label').each(function() {
                    var text = $(this).text().toLowerCase();
                    if (text.includes(value)) {
                        found = true;
                        $(this).closest('.form-check').show();
                    } else {
                        $(this).closest('.form-check').hide();
                    }
                });

                // If no pemeriksaan is found within the department, hide the department
                if (found) {
                    $(this).closest('.col-xl-3').show();
                } else {
                    $(this).closest('.col-xl-3').hide();
                }
            });
        });
    });

    </script>

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
        document.addEventListener("DOMContentLoaded", function() {
            checkpemeriksaan();
        });

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
   <script>
document.addEventListener("DOMContentLoaded", function () {
    const pembayaran = @json($data_pasien->pembayaran->first());

    // Ambil semua field
    const noPasienField   = document.getElementById("noPasienField");
    const noAsuransi      = document.getElementById("noAsuransi");
    const AsuransiPemjamin = document.getElementById("AsuransiPemjamin");
    const noBPJS          = document.getElementById("noBPJS");

    // Reset semua dulu
    [noPasienField, noAsuransi, AsuransiPemjamin, noBPJS].forEach(el => {
        if (el) el.style.display = "none";
    });

    if (pembayaran) {
        switch (pembayaran.metode_pembayaran) {
            case "umum":
                noPasienField.style.display = "block";
                break;
            case "asuransi":
                noAsuransi.style.display = "block";
                AsuransiPemjamin.style.display = "block";
                break;
            case "bpjs":
                noBPJS.style.display = "block";
                break;
        }
    }
});
</script>

@endpush