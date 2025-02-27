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
                                        <label for="staticEmail" class="col-sm-4 col-form-label fw-bold">No LAB :</label>
                                        <div class="col-lg">
                                            <input type="text" readonly class="form-control-plaintext fw-bold"
                                                id="no-lab" name="nolab" value="{{ $no_lab }}">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="basic-url" class="fw-bold">Cito</label>
                                        <div class="form-check">
                                            <input style="cursor: pointer" class="form-check-input child-pemeriksaan-hematologi" type="checkbox"
                                                name="cito" value="1" id="cito">
                                            <label class="form-check-label fw-bold" for="cito">
                                                Patient Cito
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-6">
                                        <label for="basic-url" class="fw-bold">No RM</label>
                                        <div class="input-group mb-6">
                                            <input type="number" class="form-control" name="norm" aria-label=""
                                                placeholder="Masukan No RM">
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-6">
                                        <label for="basic-url" class="fw-bold">Nomor Induk Kewarganegaraan</label>
                                        <div class="input-group mb-6">
                                            <input type="number" class="form-control" name="nik" aria-label=""
                                                placeholder="Add NIK">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="basic-url" class="fw-bold">Full Name <strong class="text-danger">*</strong></label>
                                        <div class="input-group mb-6">
                                            <input type="text" class="form-control" name="nama" aria-label=""
                                                placeholder="Add Full Name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-6">
                                        <!-- <label for="name" class="">Date</label> -->
                                        <label for="startDate" class="fw-bold">Date Of Birth<strong class="text-danger"> *</strong></label>
                                        <input id="startDate" class="form-control" type="date" name="tanggallahir" required />
                                    </div>
                                    <div class="col-md-6 mb-6">
                                        <label for="exampleFormControlSelect1" class="fw-bold">Gender<strong class="text-danger"> *</strong></label>
                                        <select class="form-select" id="exampleFormControlSelect1" name="jeniskelamin">
                                            <option selected>Choose Gender</option>
                                            <option value="Laki²">Laki²</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-6">
                                        <label for="phonenumber" class="fw-bold">Phone Number<strong class="text-danger"> *</strong></label>
                                            <input type="number" class="form-control" name="notelepon" placeholder="Add Phone Number" required>
                                    </div>
                                    <div class="col-md-6 mb-6">
                                        <label for="doctorSelect" class="fw-bold">Doctor</label>
                                        <select class="form-select" id="doctorSelect" name="dokter_internal">
                                            <option hidden>Choose Doctor</option>
                                            @foreach ($dokters as $dokter)
                                                <option value="{{ $dokter->nama_dokter }}">{{ $dokter->nama_dokter }}</option>
                                            @endforeach
                                            <option value="external">Lainnya...</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6 mb-6" id="externalDoctorContainer" style="display: none;">
                                        <label for="external_doctor" class="fw-bold">External Doctor</label>
                                        <input type="text" class="form-control" id="external_doctor" name="dokter_external" placeholder="Masukkan nama dokter">
                                    </div>
                                                                        
                                    <div class="col-md-6 mb-6">
                                        <label for="name" class="fw-bold">Room</label>
                                        <input type="text " class="form-control"
                                            name="asal_ruangan" placeholder="Add Room">
                                    </div>
                                    <div class="col-md-6 mb-6">
                                        <label for="name" class="fw-bold">Diagnosis</label>
                                        <select name="diagnosa" id="diagnosa" class="form-control diagnosa">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-6">
                                        <label for="name" class="fw-bold">Diagnosis</label>
                                        <input type="text" name="diagnosa" class="form-control" placeholder="Choose Diagnosis">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="alamat" class="fw-bold">Full Address <strong class="text-danger"> *</strong></label>
                                        <textarea class="form-control ml-1" cols="119" rows="1" id="alamat" name="alamat" placeholder="Enter Address"></textarea>
                                    </div>
                                    <div class="col-md-6 mb-6">
                                        <label for="basic-url">Kind Of Service</label>
                                        <div class="row">
                                            <div class="ml-4 mb-2">
                                                <input style="cursor: pointer" class="form-check-input child-pemeriksaan-hematologi" type="radio"
                                                    name="jenispelayanan" value="umum" id="umum" checked>
                                                <label class="form-check-label" for="umum">
                                                    Umum
                                                </label>
                                            </div>
                                            <div class=" ml-4 mb-2">
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
                                <div class="row" id="inspectionList">
                                    @foreach ($departments as $departement)
                                        <div class="col-xl-3 inspection-item">
                                            <!-- Parent Pemeriksaan -->
                                            <div class="parent-pemeriksaan">
                                                <div class="heading heading-color btn-block mb-3">
                                                    <strong>{{ $departement->nama_department }}</strong>
                                                </div>
                                                <!-- Child pemeriksaan -->
                                                <div class="child-pemeriksaan">
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
                                    <button class="btn btn-outline-primary oneclick" type="submit">Submit</button>
                                    <button class="btn btn-outline-danger" type="reset">Reset</button>   
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
<script>
    // Menambahkan event listener saat dokumen sudah siap
document.addEventListener('DOMContentLoaded', function() {
    // 1. One-click submit: mencegah button submit diklik lebih dari sekali
    const form = document.querySelector('form');
    const submitButton = document.querySelector('.oneclick');
    
    if (form && submitButton) {
        form.addEventListener('submit', function(event) {
            // Nonaktifkan tombol setelah diklik
            submitButton.disabled = true;
            submitButton.classList.add('disabled');
            submitButton.innerHTML = '<span>Memproses...</span>';
            
            // Memeriksa duplikasi pemeriksaan sebelum submit
            if (!checkDuplicateExams()) {
                event.preventDefault();
                submitButton.disabled = false;
                submitButton.classList.remove('disabled');
                submitButton.innerHTML = 'Submit';
                alert('Ditemukan pemeriksaan duplikat. Silakan periksa kembali pilihan Anda.');
            }
        });
    }
    
    // 2. Fungsi untuk memeriksa duplikasi pemeriksaan
    function checkDuplicateExams() {
        // Kumpulkan semua pemeriksaan yang dipilih
        const selectedExams = [];
        const checkboxes = document.getElementsByClassName('child-pemeriksaan');
        
        for (let i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked && checkboxes[i].type === 'checkbox') {
                // Ambil nama pemeriksaan dari label
                const label = checkboxes[i].nextElementSibling;
                if (label && label.tagName === 'LABEL') {
                    const examName = label.textContent.trim().split('Rp.')[0].trim();
                    
                    // Cek apakah nama pemeriksaan sudah ada dalam array
                    if (selectedExams.includes(examName)) {
                        return false; // Ditemukan duplikat
                    }
                    
                    selectedExams.push(examName);
                }
            }
        }
        
        return true; // Tidak ada duplikat
    }
    
    // 3. Perbaikan fungsi checkpemeriksaan
    window.checkpemeriksaan = function(lab) {
        var total = 0;
        var harga = 0;
        var harga_pemeriksaan = document.getElementById('harga-pemeriksaan');
        var checkboxes = document.getElementsByClassName('child-pemeriksaan');
        
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked == true && checkboxes[i].type === 'checkbox') {
                harga = checkboxes[i].getAttribute('data-harga');
                total = parseInt(total) + parseInt(harga);
            }
        }

        //mengubah format angka ke rupiah
        var reverse = total.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
        
        if (ribuan) {
            ribuan = ribuan.join('.').split('').reverse().join('');
            if (harga_pemeriksaan) {
                harga_pemeriksaan.value = ribuan;
            }
        }
    };
    
    // 4. Perbaikan juga untuk tombol reset
    const resetButton = document.querySelector('button[type="reset"]');
    if (resetButton) {
        resetButton.addEventListener('click', function() {
            // Reset tombol submit
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.classList.remove('disabled');
                submitButton.innerHTML = 'Submit';
            }
            
            // Reset harga pemeriksaan
            const harga_pemeriksaan = document.getElementById('harga-pemeriksaan');
            if (harga_pemeriksaan) {
                harga_pemeriksaan.value = '0';
            }
        });
    }
});
    </script>
<script>
    document.getElementById('doctorSelect').addEventListener('change', function () {
        var externalContainer = document.getElementById('externalDoctorContainer');
        var externalInput = document.getElementById('external_doctor');

        if (this.value === 'external') {
            externalContainer.style.display = 'block';
            externalInput.setAttribute('required', 'true'); // Buat wajib diisi jika memilih "Lainnya..."
        } else {
            externalContainer.style.display = 'none';
            externalInput.removeAttribute('required');
        }
    });
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