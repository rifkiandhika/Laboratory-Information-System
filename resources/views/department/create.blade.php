@extends('layouts.admin')
@section('title')
Add Department
@endsection

@section('content')
@if($errors->any())
    @foreach($errors->all() as $error)
    <div class="alert alert-danger">
    {{ $error }}
    </div>
    @endforeach
@endif
<section>
    <div class="container-fluid">
        {{-- Page Heading --}}
        <div class="d-sm-flex mb-3">
            <h1 class="h3 mb-0 text-gray-600">Create Department</h1>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="card-body">
                            <form action="{{ route('department.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <h4>Department</h4>
                                    <hr>
                                    <label for="id_departement">Departement</label>
                                    <input type="text" class="form-control" name="nama_department" id="" required>

                                </div>
                                <div class="form-group">
                                    <hr>
                                    <h4>Detail Department</h4>
                                    <hr>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="tableDetail">
                                            <thead>
                                                <tr>
                                                    <th class="col-11">Data Detail</th>
                                                    <th class="col-2">Status</th>
                                                    <th class="col-2">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                     <td>
                                                        <div class="row">
                                                            <!-- Kolom Kiri -->
                                                            <div class="col-md-6">
                                                                <label for="Code">Code <span class="text-danger">*</span></label>
                                                                <input type="text" name="kode[]" class="form-control" id="kode" required>
                                                                <input type="hidden" name="kode_hidden[]" id="kode_hidden">

                                                                <label class="mt-2">Nama Parameter <span class="text-danger">*</span></label>
                                                                <input type="text" name="nama_parameter[]" class="form-control" required>

                                                                <label class="mt-2">Nama Pemeriksaan <span class="text-danger">*</span></label>
                                                                <input type="text" name="nama_pemeriksaan[]" class="form-control" required>

                                                                <label class="mt-2">Harga <span class="text-danger">*</span></label>
                                                                <input type="number" name="harga[]" class="form-control" required>

                                                                <label class="mt-2">Nilai Rujukan (L.13,3-17 P.11,7-15,7)<span class="text-danger">*</span></label>
                                                                <input type="text" name="nilai_rujukan[]" class="form-control" required>

                                                                <label class="mt-2">Nilai Satuan <span class="text-danger">*</span></label>
                                                                <input type="text" name="nilai_satuan[]" class="form-control" required>
                                                            </div>

                                                            <!-- Kolom Kanan -->
                                                            <div class="col-md-6">
                                                                <label>JASA SARANA: <span class="text-danger">*</span></label>
                                                                <input type="number" name="jasa_sarana[]" class="form-control" required>

                                                                <label class="mt-2">JASA PELAYANAN: <span class="text-danger">*</span></label>
                                                                <input type="number" name="jasa_pelayanan[]" class="form-control" required>

                                                                <label class="mt-2">JASA DOKTER:</label>
                                                                <input type="number" name="jasa_dokter[]" class="form-control">

                                                                <label class="mt-2">JASA BIDAN:</label>
                                                                <input type="number" name="jasa_bidan[]" class="form-control">

                                                                <label class="mt-2">JASA PERAWAT:</label>
                                                                <input type="number" name="jasa_perawat[]" class="form-control">

                                                                <label class="mt-2">Tipe Inputan</label>
                                                                <select name="tipe_inputan[]" class="form-select tipe-inputan">
                                                                    <option value="" selected hidden>Choose</option>
                                                                    <option value="Text">Text</option>
                                                                    <option value="Dropdown">Dropdown</option>
                                                                </select>

                                                                <div class="opsi-output-wrapper mt-2" style="display: none;">
                                                                    <label>Opsi Output</label>
                                                                    <input type="text" name="opsi_output[]" class="form-control">
                                                                </div>

                                                                <div class="urutan-wrapper mt-2" style="display: none;">
                                                                    <label>Urutan <span class="text-danger">*</span></label>
                                                                    <input type="text" name="urutan[]" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center align-middle" style="min-width: 180px;">
                                                        <div class="d-flex justify-content-center align-items-center mb-1" style="gap: 8px; white-space: nowrap;">
                                                            <label class="mb-0" style="font-size: 14px;">Active to loket?</label>
                                                            <input type="hidden" name="status[]" value="deactive" class="status-hidden">
                                                            <input type="checkbox" value="active" class="form-check-input align-middle status-checkbox" 
                                                                {{ (old('status') && in_array('active', old('status'))) ? 'checked' : '' }}>
                                                        </div>
                                                        <br>
                                                        <div class="d-flex justify-content-center align-items-center" style="gap: 8px; white-space: nowrap;">
                                                            <label class="mb-0" style="font-size: 14px;">Active Barcode?</label>
                                                            <input type="hidden" name="barcode[]" value="deactive" class="permission-hidden">
                                                            <input type="checkbox" value="active" class="form-check-input align-middle permission-checkbox" 
                                                                {{ (old('barcode') && in_array('active', old('barcode'))) ? 'checked' : '' }}>
                                                        </div>
                                                        <br>
                                                        <div class="d-flex justify-content-center align-items-center" style="gap: 8px; white-space: nowrap;">
                                                            <label class="mb-0" style="font-size: 14px;">Check to Collection?</label>
                                                            <input type="hidden" name="permission[]" value="deactive" class="permission-hidden">
                                                            <input type="checkbox" value="active" class="form-check-input align-middle permission-checkbox" 
                                                                {{ (old('permission') && in_array('active', old('permission'))) ? 'checked' : '' }}>
                                                        </div>
                                                        <br>
                                                        <div class="d-flex justify-content-center align-items-center" style="gap: 8px; white-space: nowrap;">
                                                            <label class="mb-0" style="font-size: 14px;">Check to Handling?</label>
                                                            <input type="hidden" name="handling[]" value="deactive" class="permission-hidden">
                                                            <input type="checkbox" value="active" class="form-check-input align-middle permission-checkbox" 
                                                                {{ (old('handling') && in_array('active', old('handling'))) ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-success btn-add"><i class="ti ti-plus"></i></button>
                                                    </td>
                                                </tr>                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    {{-- <div id="detail-fields">
                                        <div class="detail-field">
                                            <label for="parameter">Nama Parameter</label>
                                            <input type="text" name="nama_parameter[]" class="form-control" required>
                                            <br>
                                            <input type="file" name="gambar[]" class="form-control" required>
                                        </div>
                                    </div>
                                    <br>
                                    <button type="button" id="add-detail-field" class="btn btn-secondary">Add Another Detail</button> --}}
                                </div>
                                <div class="text-end mt-2">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
document.addEventListener('DOMContentLoaded', function() {
    // Handle status checkboxes
    document.querySelectorAll('.status-checkbox').forEach(function(checkbox, index) {
        checkbox.addEventListener('change', function() {
            const hiddenInput = document.querySelectorAll('.status-hidden')[index];
            if (this.checked) {
                hiddenInput.value = 'active';
            } else {
                hiddenInput.value = 'deactive';
            }
        });
        
        // Set initial state
        if (checkbox.checked) {
            document.querySelectorAll('.status-hidden')[index].value = 'active';
        }
    });
    
    // Handle permission checkboxes
    document.querySelectorAll('.permission-checkbox').forEach(function(checkbox, index) {
        checkbox.addEventListener('change', function() {
            const hiddenInput = document.querySelectorAll('.permission-hidden')[index];
            if (this.checked) {
                hiddenInput.value = 'active';
            } else {
                hiddenInput.value = 'deactive';
            }
        });
        
        // Set initial state
        if (checkbox.checked) {
            document.querySelectorAll('.permission-hidden')[index].value = 'active';
        }
    });
        const tipeSelect = document.querySelector('.tipe-inputan');
        const opsiWrapper = document.querySelector('.opsi-output-wrapper');
        const urutanWrapper = document.querySelector('.urutan-wrapper');

        tipeSelect.addEventListener('change', function () {
            if (this.value === 'Dropdown') {
                opsiWrapper.style.display = 'block';
                urutanWrapper.style.display = 'block';
                // Optionally make them required
                opsiWrapper.querySelector('input').required = true;
                urutanWrapper.querySelector('input').required = true;
            } else {
                opsiWrapper.style.display = 'none';
                urutanWrapper.style.display = 'none';
                opsiWrapper.querySelector('input').required = false;
                urutanWrapper.querySelector('input').required = false;
            }
        });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {


    // Fungsi utama untuk add/remove baris
    function btnFunction() {
        $(".btn-add").unbind('click').bind('click', function () {
            let row = `
            <tr>
                <td>
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <label for="otomatis">Code <span class="text-danger">*</span></label>
                            <input type="text" name="kode[]" class="form-control kode" required>
                            <input type="hidden" name="kode_hidden[]" class="kode_hidden">

                            <label class="mt-2">Nama Parameter</label>
                            <input type="text" name="nama_parameter[]" class="form-control" required>

                            <label class="mt-2">Nama Pemeriksaan</label>
                            <input type="text" name="nama_pemeriksaan[]" class="form-control" required>

                            <label class="mt-2">Harga</label>
                            <input type="number" name="harga[]" class="form-control" required>

                            <label class="mt-2">Nilai Rujukan (L.13,3-17 P.11,7-15,7)</label>
                            <input type="text" name="nilai_rujukan[]" class="form-control" required>

                            <label class="mt-2">Nilai Satuan</label>
                            <input type="text" name="nilai_satuan[]" class="form-control" required>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <label>JASA SARANA:</label>
                            <input type="number" name="jasa_sarana[]" class="form-control" required>

                            <label class="mt-2">JASA PELAYANAN:</label>
                            <input type="number" name="jasa_pelayanan[]" class="form-control" required>

                            <label class="mt-2">JASA DOKTER:</label>
                            <input type="number" name="jasa_dokter[]" class="form-control">

                            <label class="mt-2">JASA BIDAN:</label>
                            <input type="number" name="jasa_bidan[]" class="form-control">

                            <label class="mt-2">JASA PERAWAT:</label>
                            <input type="number" name="jasa_perawat[]" class="form-control">

                            <label class="mt-2">Tipe Inputan</label>
                            <select name="tipe_inputan[]" class="form-select tipe-inputan">
                                <option value="" hidden>Pilih tipe inputan</option>
                                <option value="Text">Text</option>
                                <option value="Dropdown">Dropdown</option>
                            </select>

                            <div class="opsi-output-wrapper mt-2" style="display: none;">
                                <label>Opsi Output</label>
                                <input type="text" name="opsi_output[]" class="form-control">
                            </div>

                            <div class="urutan-wrapper mt-2" style="display: none;">
                                <label>Urutan</label>
                                <input type="text" name="urutan[]" class="form-control">
                            </div>
                        </div>
                    </div>
                </td>
                <td class="text-center align-middle" style="min-width: 180px;">
                    <div class="d-flex justify-content-center align-items-center mb-1" style="gap: 8px; white-space: nowrap;">
                        <label class="mb-0" style="font-size: 14px;">Active to loket?</label>
                        <input type="hidden" name="status[]" value="deactive">
                        <input type="checkbox" name="status[]" value="active" class="form-check-input align-middle">
                    </div>
                    <br>
                    <div class="d-flex justify-content-center align-items-center" style="gap: 8px; white-space: nowrap;">
                        <label class="mb-0" style="font-size: 14px;">Active Barcode?</label>
                        <input type="hidden" name="barcode[]" value="deactive">
                        <input type="checkbox" name="barcode[]" value="active" class="form-check-input align-middle">
                    </div>
                    <br>
                    <div class="d-flex justify-content-center align-items-center" style="gap: 8px; white-space: nowrap;">
                        <label class="mb-0" style="font-size: 14px;">Check to Collection?</label>
                        <input type="hidden" name="permission[]" value="deactive">
                        <input type="checkbox" name="permission[]" value="active" class="form-check-input align-middle">
                    </div>
                    <br>
                    <div class="d-flex justify-content-center align-items-center" style="gap: 8px; white-space: nowrap;">
                        <label class="mb-0" style="font-size: 14px;">Check to Handling?</label>
                        <input type="hidden" name="handling[]" value="deactive">
                        <input type="checkbox" name="handling[]" value="active" class="form-check-input align-middle">
                    </div>
                </td>
                <td>
                    <button type="button" class="btn btn-success btn-add"><i class="ti ti-plus"></i></button>
                    <button type="button" class="btn btn-danger btn-remove"><i class="ti ti-trash"></i></button>
                </td>
            </tr>`;

            $("#tableDetail > tbody:last-child").append(row);
            let newRow = $("#tableDetail > tbody:last-child tr:last-child")[0];
            generateKode(newRow);
            setupDropdownListeners();
            btnFunction();
        });

        $(".btn-remove").unbind('click').bind('click', function () {
            $(this).closest('tr').remove();
        });
    }

    // Fungsi untuk menyesuaikan tampilan dropdown dinamis
    function setupDropdownListeners() {
        document.querySelectorAll('.tipe-inputan').forEach(function (select) {
            select.removeEventListener('change', handleDropdownChange); // mencegah duplikat listener
            select.addEventListener('change', handleDropdownChange);
        });
    }

    // Fungsi yang dijalankan ketika tipe inputan berubah
    function handleDropdownChange() {
        const wrapper = this.closest('.col-md-6');
        const opsiWrapper = wrapper.querySelector('.opsi-output-wrapper');
        const urutanWrapper = wrapper.querySelector('.urutan-wrapper');

        if (this.value === 'Dropdown') {
            opsiWrapper.style.display = 'block';
            urutanWrapper.style.display = 'block';
        } else {
            opsiWrapper.style.display = 'none';
            urutanWrapper.style.display = 'none';
        }
    }

    // Inisialisasi saat pertama kali halaman dimuat
    btnFunction();
    setupDropdownListeners();
});
</script>

    
@endpush