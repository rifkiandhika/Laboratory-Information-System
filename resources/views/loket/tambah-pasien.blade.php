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
                                                id="no-lab" name="no_lab" value="{{ $no_lab }}">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="form-group col-6">
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
                                        <label for="basic-url" class="fw-bold">Tanggal Order</label>
                                        <div class="input-group mb-6">
                                            <input 
                                                type="datetime-local" 
                                                class="form-control" 
                                                name="tanggal_masuk"
                                                value="{{ old('tanggal_masuk', now()->format('Y-m-d\TH:i')) }}">
                                        </div>
                                    </div>
                                    
                                    <div class="col-6 col-md-6">
                                        <label for="basic-url" class="fw-bold">Nomor Induk Kewarganegaraan</label>
                                        <div class="input-group mb-6">
                                            <select id="nik" name="nik" class="form-control" style="width: 100%;">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6 col-md-6">
                                        <label for="basic-url" class="fw-bold">No RM</label>
                                        <div class="input-group mb-6">
                                            <input type="text" class="form-control" id="norm" name="norm" aria-label="" placeholder="Masukan No RM">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="basic-url" class="fw-bold">Full Name <strong class="text-danger">*</strong></label>
                                        <div class="input-group mb-6">
                                            <input type="text" class="form-control" id="nama" name="nama" aria-label=""
                                                placeholder="Add Full Name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-6">
                                        <!-- <label for="name" class="">Date</label> -->
                                        <label for="startDate" class="fw-bold">Date Of Birth<strong class="text-danger"> *</strong></label>
                                        <input class="form-control" type="date" id="tanggallahir" name="tanggallahir" required />
                                    </div>
                                    <div class="col-md-6 mb-6">
                                        <label for="exampleFormControlSelect1" class="fw-bold">Gender<strong class="text-danger"> *</strong></label>
                                        <select class="form-select" id="jeniskelamin" name="jeniskelamin">
                                            <option selected>Choose Gender</option>
                                            <option value="Laki-Laki">Laki-Laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-6">
                                        <label for="phonenumber" class="fw-bold">Phone Number<strong class="text-danger"> *</strong></label>
                                            <input type="number" class="form-control" id="notelepon" name="notelepon" placeholder="Add Phone Number" required>
                                    </div>
                                    
                                    <div class="col-md-6 mb-6">
                                        <label for="alamat" class="fw-bold">Full Address <strong class="text-danger"> *</strong></label>
                                        <textarea class="form-control ml-1" cols="119" rows="1" id="alamat" name="alamat" placeholder="Enter Address"></textarea>
                                    </div>
                                                                  
                                   <div class="col-md-6 mb-6">
                                        <label for="doctorSelect" class="fw-bold">Doctor Internal <span class="text-muted">(pilih dokter terlebih dahulu)</span></label>
                                        <select class="form-select" id="doctorSelect" name="dokter_internal">
                                            <option value="" hidden>Choose Internal Doctor...</option>
                                            @foreach ($dokterInternal as $dokter)
                                                <option value="{{ $dokter->nama_dokter }}" data-dokter-id="{{ $dokter->id }}">
                                                    {{ $dokter->nama_dokter }} ({{ $dokter->jabatan }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-6">
                                        <label for="externalDoctorSelect" class="fw-bold">Doctor External <span class="text-muted">(pilih dokter terlebih dahulu)</span></label>
                                        <select class="form-select" id="externalDoctorSelect" name="dokter_external">
                                            <option value="" hidden>Choose External Doctor...</option>
                                            @foreach ($dokterExternal as $dokter)
                                                <option value="{{ $dokter->nama_dokter }}" data-dokter-id="{{ $dokter->id }}">
                                                    {{ $dokter->nama_dokter }} ({{ $dokter->jabatan }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-6">
                                        <label for="asal_ruangan" class="fw-bold">Room <span class="text-muted" id="roomHint">(otomatis terisi)</span></label>
                                        
                                        <!-- Input readonly (default) -->
                                        <input type="text" 
                                            class="form-control" 
                                            id="asal_ruangan_input" 
                                            name="asal_ruangan" 
                                            readonly 
                                            placeholder="Pilih dokter terlebih dahulu">
                                        
                                        <!-- Dropdown (hidden by default) -->
                                        <select class="form-select" 
                                                id="asal_ruangan_select" 
                                                name="asal_ruangan_select" 
                                                style="display: none;">
                                            <option value="" hidden>Pilih salah satu ruangan...</option>
                                        </select>
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
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <select id="mcuSelect" name="mcu_package_id" class="form-select">
                                            <option value="" hidden>-- Pilih Paket MCU --</option>
                                            @foreach($mcuPackages as $mcu)
                                                <option value="{{ $mcu->id }}"
                                                        data-harga-normal="{{ $mcu->harga_normal }}"
                                                        data-harga-final="{{ $mcu->harga_final }}"
                                                        data-diskon="{{ $mcu->diskon }}"
                                                        data-pemeriksaan='@json($mcu->detailDepartments->pluck("id")->toArray())'>
                                                    {{ $mcu->nama_paket }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4" id="mcuHarga" style="display:none ;">
                                        <span>
                                            Harga: 
                                            <del class="text-danger" id="mcuHargaNormal"></del> 
                                            <b class="text-success" id="mcuHargaFinal"></b>
                                        </span>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" id="cancelMcuBtn" class="btn btn-outline-danger" style="display:none;">
                                            Batal MCU
                                        </button>
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
                                    @php
                                        // Kelompokkan departments berdasarkan nama_department untuk menghindari duplikasi
                                        $groupedDepartments = $departments->groupBy('nama_department');
                                    @endphp

                                    @foreach ($groupedDepartments as $namaDepartment => $deptGroup)
                                        @php
                                            // Ambil department pertama dari grup untuk mendapatkan data department
                                            $departement = $deptGroup->first();
                                            // Gabungkan semua detailDepartments dari department yang sama
                                            $allDetails = $deptGroup->flatMap(function($dept) {
                                                return $dept->detailDepartments;
                                            });
                                        @endphp
                                        
                                        <div class="col-xl-3 inspection-item">
                                            <div class="parent-pemeriksaan">
                                                <div class="heading heading-color btn-block mb-3">
                                                    <strong>{{ $namaDepartment }}</strong>
                                                </div>

                                                @if($departement->statusdep === 'single')
                                                    {{-- SINGLE → langsung pakai judul --}}
                                                    @foreach ($allDetails as $pemeriksaan)
                                                        @if ($pemeriksaan->status === 'active')
                                                            <div class="form-check">
                                                                <input style="cursor: pointer"
                                                                    class="form-check-input child-pemeriksaan"
                                                                    type="checkbox"
                                                                    name="pemeriksaan[]"
                                                                    value="{{ $pemeriksaan->id }}"
                                                                    id="pemeriksaan-{{ $pemeriksaan->id_departement }}-{{ $pemeriksaan->id }}"
                                                                    onclick="checkpemeriksaan({{ $pemeriksaan->harga }})"
                                                                    data-harga="{{ $pemeriksaan->harga }}">
                                                                <label class="form-check-label"
                                                                    for="pemeriksaan-{{ $pemeriksaan->id_departement }}-{{ $pemeriksaan->id }}">
                                                                    {{ $pemeriksaan->judul }}
                                                                    Rp.{{ number_format($pemeriksaan->harga, 0, ',', '.') }}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endforeach

                                                @elseif($departement->statusdep === 'multi')
                                                    {{-- MULTI → group by judul, tampilkan nama_pemeriksaan --}}
                                                    @php
                                                        $grouped = $allDetails
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
                                                                        data-harga="{{ $pemeriksaan->harga }}">
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
document.addEventListener('DOMContentLoaded', function() {
    
    const roomByDokter = @json($roomByDokter ?? []);
    
    const doctorSelectInternal = document.getElementById('doctorSelect');
    const doctorSelectExternal = document.getElementById('externalDoctorSelect');
    const asalRuanganInput = document.getElementById('asal_ruangan_input');
    const asalRuanganSelect = document.getElementById('asal_ruangan_select');
    const roomHint = document.getElementById('roomHint');
    
    console.log('Room by dokter:', roomByDokter);
    
    
    function showInput() {
        asalRuanganInput.style.display = 'block';
        asalRuanganSelect.style.display = 'none';
        asalRuanganInput.removeAttribute('name');
        asalRuanganInput.setAttribute('name', 'asal_ruangan');
        asalRuanganSelect.removeAttribute('name');
    }
    
    function showSelect() {
        asalRuanganInput.style.display = 'none';
        asalRuanganSelect.style.display = 'block';
        asalRuanganSelect.removeAttribute('name');
        asalRuanganSelect.setAttribute('name', 'asal_ruangan');
        asalRuanganInput.removeAttribute('name');
    }
    
    function resetRoom() {
        asalRuanganInput.value = '';
        asalRuanganSelect.innerHTML = '<option value="" hidden>Pilih salah satu ruangan...</option>';
        showInput();
        roomHint.textContent = '(otomatis terisi)';
    }
    
    
    doctorSelectInternal.addEventListener('change', function() {
        
        doctorSelectExternal.value = '';
        
        const selectedOption = this.options[this.selectedIndex];
        const dokterId = selectedOption.getAttribute('data-dokter-id');
        
        if (!dokterId || dokterId === '') {
            resetRoom();
            return;
        }
        
        
        if (roomByDokter[dokterId]) {
            const dokterData = roomByDokter[dokterId];
            const ruanganList = dokterData.ruangan;
            
            if (ruanganList && ruanganList.length > 0) {
                if (ruanganList.length === 1) {
                    
                    showInput();
                    asalRuanganInput.value = ruanganList[0];
                    roomHint.textContent = '(otomatis terisi)';
                    
                    if (typeof toastr !== 'undefined') {
                        toastr.success(`Ruangan "${ruanganList[0]}" otomatis terisi`, 'Info');
                    }
                } else {
                    
                    showSelect();
                    roomHint.textContent = '(pilih salah satu)';
                    
                    
                    asalRuanganSelect.innerHTML = '<option value="" hidden>Pilih salah satu ruangan...</option>';
                    
                    ruanganList.forEach(function(namaRuangan) {
                        const option = document.createElement('option');
                        option.value = namaRuangan;
                        option.textContent = namaRuangan;
                        asalRuanganSelect.appendChild(option);
                    });
                    
                    if (typeof toastr !== 'undefined') {
                        toastr.info(`Dokter bertugas di ${ruanganList.length} ruangan. Silakan pilih salah satu.`, 'Pilih Ruangan');
                    }
                }
            } else {
                showInput();
                asalRuanganInput.value = 'Tidak ada ruangan terdaftar';
                roomHint.textContent = '(tidak ada data)';
                
                if (typeof toastr !== 'undefined') {
                    toastr.warning('Dokter ini belum memiliki ruangan terdaftar', 'Perhatian');
                }
            }
        } else {
            resetRoom();
        }
    });
    
    
    doctorSelectExternal.addEventListener('change', function() {
        
        doctorSelectInternal.value = '';
        
        const selectedOption = this.options[this.selectedIndex];
        const dokterId = selectedOption.getAttribute('data-dokter-id');
        
        if (!dokterId || dokterId === '') {
            resetRoom();
            return;
        }
        
        
        if (roomByDokter[dokterId]) {
            const dokterData = roomByDokter[dokterId];
            
            if (dokterData.status === 'external') {
                showInput();
                asalRuanganInput.value = 'External / Luar RS';
                roomHint.textContent = '(dokter external)';
                
                if (typeof toastr !== 'undefined') {
                    toastr.info('Dokter external dipilih', 'Info');
                }
            }
        }
    });
    
    
    doctorSelectInternal.addEventListener('focus', function() {
        if (this.value === '') {
            resetRoom();
        }
    });
    
    doctorSelectExternal.addEventListener('focus', function() {
        if (this.value === '') {
            resetRoom();
        }
    });
});
</script>
<script>
$(document).ready(function() {
    console.log('Memulai inisialisasi Select2 NIK...');
    
    // Pastikan element ada
    if ($('#nik').length === 0) {
        console.error('Element #nik tidak ditemukan!');
        return;
    }
    
    // Inisialisasi Select2 untuk NIK
    $("#nik").select2({
        placeholder: 'Ketik NIK, Nama, atau No RM (min 3 karakter)',
        allowClear: true,
        minimumInputLength: 3,
        tags: true, // Izinkan input manual
        language: {
            inputTooShort: function() {
                return "Ketik minimal 3 karakter";
            },
            searching: function() {
                return "Mencari data pasien...";
            },
            noResults: function() {
                return "Data tidak ditemukan. Tekan Enter untuk input NIK baru";
            }
        },
        createTag: function(params) {
            var term = $.trim(params.term);
            
            // Izinkan semua input angka (tidak harus 16 digit saat mengetik)
            if (!/^\d+$/.test(term)) {
                return null; // Hanya tolak jika bukan angka
            }
            
            // Tampilkan sebagai NIK baru
            if (term.length >= 3) {
                return {
                    id: term,
                    text: term + ' (NIK Baru)',
                    newTag: true
                };
            }
            
            return null;
        },
        ajax: {
            url: '/api/data-pasien',
            dataType: 'json',
            delay: 300,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: function(params) {
                console.log('Mengirim keyword:', params.term);
                return {
                    keyword: params.term
                };
            },
            processResults: function(data) {
                console.log('Data diterima dari server:', data);
                
                if (data.status !== 'success') {
                    console.log('Status bukan success');
                    return { results: [] };
                }
                
                if (!data.data || data.data.length === 0) {
                    console.log('Tidak ada data pasien ditemukan');
                    return { results: [] };
                }
                
                let results = data.data.map(function(pasien) {
                    return {
                        id: pasien.nik,
                        text: pasien.nik + ' - ' + pasien.nama + ' (RM: ' + pasien.no_rm + ')',
                        pasienData: pasien
                    };
                });
                
                console.log('Results yang akan ditampilkan:', results);
                return { results: results };
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                console.error('Status:', status);
                console.error('Response:', xhr.responseText);
            },
            cache: true
        }
    });
    
    // Event ketika NIK dipilih dari dropdown
    $("#nik").on('select2:select', function(e) {
        var data = e.params.data;
        console.log('Data dipilih:', data);
        
        // Jika ini NIK baru (input manual)
        if (data.newTag) {
            console.log('NIK Baru - Input Manual');
            clearFormFields();
            
            // Optional: Tampilkan notifikasi
            if (typeof toastr !== 'undefined') {
                toastr.info('Silakan isi data pasien baru', 'NIK Baru');
            }
            return;
        }
        
        // Jika ini pasien lama dari database
        if (data.pasienData) {
            console.log('Pasien ditemukan, mengisi form...');
            fillFormWithPasienData(data.pasienData);
            
            // Optional: Tampilkan notifikasi
            if (typeof toastr !== 'undefined') {
                toastr.success('Data pasien berhasil dimuat', 'Pasien Ditemukan');
            }
        }
    });
    
    // Event ketika NIK di-clear
    $("#nik").on('select2:clear', function() {
        console.log('NIK di-clear, mengosongkan form');
        clearFormFields();
    });
    
    // Fungsi untuk mengisi form dengan data pasien
    function fillFormWithPasienData(pasien) {
        console.log('Mengisi form dengan data:', pasien);
        
        // Isi semua field
        $('#norm').val(pasien.no_rm || '');
        $('#nama').val(pasien.nama || '');
        $('#tanggallahir').val(pasien.lahir || '');
        $('#jeniskelamin').val(pasien.jenis_kelamin || 'Choose Gender');
        $('#notelepon').val(pasien.no_telp || '');
        $('#alamat').val(pasien.alamat || '');
        
        // Disable field yang tidak boleh diubah untuk pasien lama
        $('#norm').prop('readonly', true);
        $('#nama').prop('readonly', true);
        $('#tanggallahir').prop('readonly', true);
        $('#jeniskelamin').prop('readonly', true);
        $('#notelepon').prop('readonly', true);
        $('#alamat').prop('readonly', true);
        
        console.log('Form berhasil diisi');
    }
    
    // Fungsi untuk mengosongkan form
    function clearFormFields() {
        console.log('Mengosongkan form');
        
        $('#norm').val('');
        $('#nama').val('');
        $('#tanggallahir').val('');
        $('#jeniskelamin').val('Choose Gender');
        $('#notelepon').val('');
        $('#alamat').val('');
        
        // Enable semua field untuk pasien baru
        $('#norm').prop('readonly', false);
        $('#nama').prop('readonly', false);
        $('#tanggallahir').prop('readonly', false);
        $('#jeniskelamin').prop('disabled', false);
        $('#notelepon').prop('readonly', false);
        $('#alamat').prop('readonly', false);
    }
    
    console.log('Select2 NIK berhasil diinisialisasi');
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const mcuSelect = document.getElementById('mcuSelect');
    const noLabInput = document.getElementById('no-lab');
    const mcuHargaDiv = document.getElementById('mcuHarga');
    const hargaNormalEl = document.getElementById('mcuHargaNormal');
    const hargaFinalEl = document.getElementById('mcuHargaFinal');
    const hargaPemeriksaanEl = document.getElementById('harga-pemeriksaan');
    const cancelMcuBtn = document.getElementById('cancelMcuBtn');
    const checkboxes = document.querySelectorAll('.child-pemeriksaan');
    

    const formatRupiah = (num) => "Rp." + Number(num).toLocaleString('id-ID');

    // Saat pilih paket MCU
    mcuSelect.addEventListener('change', function () {
        let selected = this.options[this.selectedIndex];

        if (!selected.value) {
            // reset semua kalau tidak ada paket
            mcuHargaDiv.style.display = 'none';
            cancelMcuBtn.style.display = 'none';
            hargaPemeriksaanEl.value = "0";
            hargaNormalEl.textContent = "";
            hargaFinalEl.textContent = "";
            checkboxes.forEach(cb => {
                cb.checked = false;
                cb.disabled = false;
            });
            return;
        }

        // Kalau pilih paket MCU
        noLabInput.value = noLabInput.value.replace(/^LAB/, 'MCU');
        cancelMcuBtn.style.display = 'inline-block';

        let hargaNormal = parseInt(selected.getAttribute('data-harga-normal')) || 0;
        let hargaFinal = parseInt(selected.getAttribute('data-harga-final')) || 0;
        let diskon = selected.getAttribute('data-diskon') || 0;
        let pemeriksaanIds = JSON.parse(selected.getAttribute('data-pemeriksaan')) || [];

        // Tampilkan harga
        mcuHargaDiv.style.display = 'block';
        hargaNormalEl.textContent = formatRupiah(hargaNormal);
        hargaFinalEl.textContent = formatRupiah(hargaFinal) + ` (-${diskon}%)`;
        hargaPemeriksaanEl.value = hargaFinal.toLocaleString('id-ID');

        // Reset dan disable semua checkbox
        checkboxes.forEach(cb => {
            cb.checked = false;
            cb.disabled = true;
        });

        // Centang pemeriksaan sesuai paket MCU
        pemeriksaanIds.forEach(id => {
            let cb = document.querySelector(`.child-pemeriksaan[value="${id}"]`);
            if (cb) {
                cb.checked = true;
                cb.disabled = false; // hanya yang dipilih tetap aktif
            }
        });
    });

    // Saat klik tombol batal MCU
    cancelMcuBtn.addEventListener('click', function () {
        // Reset dropdown ke default
        mcuSelect.value = "";
        mcuSelect.dispatchEvent(new Event('change')); // trigger ulang supaya logika reset jalan

        // Reset prefix no-lab dari MCU ke LAB
        noLabInput.value = noLabInput.value.replace(/^MCU/, 'LAB');
    });

    // ✅ Tambahkan ini supaya kondisi awal langsung sesuai (tombol batal hidden)
    mcuSelect.dispatchEvent(new Event('change'));
});
</script>


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
document.addEventListener('DOMContentLoaded', function () {
  const asalRuangan = document.getElementById('asal_ruangan');

  // Simpan daftar poli internal & external dalam array
  const poliInternal = [
    @foreach ($poliInternal as $poli)
      "{{ $poli->nama_poli }}",
    @endforeach
  ];

  const poliExternal = [
    @foreach ($poliExternal as $poli)
      "{{ $poli->nama_poli }}",
    @endforeach
  ];

  // Saat value berubah
  asalRuangan.addEventListener('change', function () {
    if (this.value === 'lainnya') {
      // Hapus semua opsi lama
      asalRuangan.innerHTML = '<option value="" hidden>Choose...</option>';

      // Tambahkan poli external
      poliExternal.forEach(nama => {
        const opt = document.createElement('option');
        opt.value = nama;
        opt.textContent = nama;
        asalRuangan.appendChild(opt);
      });

      // Tambahkan opsi "Kembali ke internal"
      const kembali = document.createElement('option');
      kembali.value = 'kembali';
      kembali.textContent = '← Kembali ke Internal';
      asalRuangan.appendChild(kembali);
    }

    // Jika user ingin kembali ke internal
    if (this.value === 'kembali') {
      asalRuangan.innerHTML = '<option value="" hidden>Choose...</option>';
      poliInternal.forEach(nama => {
        const opt = document.createElement('option');
        opt.value = nama;
        opt.textContent = nama;
        asalRuangan.appendChild(opt);
      });
      const lainnya = document.createElement('option');
      lainnya.value = 'lainnya';
      lainnya.textContent = 'Lainnya...';
      asalRuangan.appendChild(lainnya);
    }
  });
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