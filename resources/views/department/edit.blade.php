@extends('layouts.admin')
@section('title')
Edit Department
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
            <h1 class="h3 mb-0 text-gray-600">Edit Departement</h1>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="card-body">
                            <form action="{{ route('department.update', $departments->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <h4>Edit Department</h4>
                                    <hr>
                                    <label for="id_departement">Departement</label>
                                    <input type="text" name="nama_department" id="department" class="form-control" value="{{ $departments->nama_department }}">
                                    <div>
                                        <select name="statusdep" class="form-select mt-5" id="statusdep">
                                            <option value="" disabled hidden>Choose..</option>
                                            <option value="single" {{ $departments->statusdep == 'single' ? 'selected' : '' }}>Single</option>
                                            <option value="multi" {{ $departments->statusdep == 'multi' ? 'selected' : '' }}>Multi</option>
                                        </select>
                                    </div>

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
                                                    <th class="col-2">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($departments->detailDepartments as $x => $detail)
                                                    <tr>
                                                        <td>
                                                            <div class="row">
                                                                <!-- Kolom Kiri -->
                                                                <div class="col-md-6">
                                                                    <label for="otomatis">Code <span class="text-danger">*</span></label>
                                                                    <input type="text" name="kode[]" class="form-control" value="{{ $detail->kode }}" placeholder="e.g. 240562548">
                                                                    <input type="hidden" name="id_detail[{{ $x }}]" value="{{ $detail->id }}">
                                                                    <input type="hidden" name="kode_hidden[{{ $x }}]" value="{{ $detail->kode }}" class="form-control">

                                                                    <label class="mt-2">Judul</label>
                                                                    <input type="text" name="judul[{{ $x }}]" class="form-control" value="{{ $detail->judul }}" placeholder="e.g. Darah Lengkap">

                                                                    <label class="mt-2">Nama Parameter <span class="text-danger">*</span></label>
                                                                    <input type="text" name="nama_parameter[{{ $x }}]" class="form-control" value="{{ $detail->nama_parameter }}" placeholder="e.g. Hematologi" required>

                                                                    <label class="mt-2">Nama Pemeriksaan <span class="text-danger">*</span></label>
                                                                    <input type="text" name="nama_pemeriksaan[{{ $x }}]" class="form-control" value="{{ $detail->nama_pemeriksaan }}" placeholder="e.g. Hematologi" required>

                                                                    <label class="mt-2">Harga <span class="text-danger">*</span></label>
                                                                    <input type="number" name="harga[{{ $x }}]" class="form-control" value="{{ $detail->harga }}" placeholder="e.g. 65000" required>

                                                                    <label class="mt-2">Nilai Rujukan (L.13,3-17 P.11,7-15,7 nilai-kritis->(L.30;120 P.30;120)) <span class="text-danger">*</span></label>
                                                                    <input type="text" name="nilai_rujukan[{{ $x }}]" class="form-control" value="{{ $detail->nilai_rujukan }}" placeholder="e.g. L.13,3-17 P.11,7-15,7" required>

                                                                    <label class="mt-2">Nilai Satuan <span class="text-danger">*</span></label>
                                                                    <input type="text" name="nilai_satuan[{{ $x }}]" class="form-control" value="{{ $detail->nilai_satuan }}" placeholder="e.g. % mg/dL" required>
                                                                </div>

                                                                <!-- Kolom Kanan -->
                                                                <div class="col-md-6">
                                                                    <label>JASA SARANA:</label>
                                                                    <input type="text" name="jasa_sarana[{{ $x }}]" class="form-control" value="{{ $detail->jasa_sarana }}" placeholder="0">

                                                                    <label class="mt-2">JASA PELAYANAN:</label>
                                                                    <input type="text" name="jasa_pelayanan[{{ $x }}]" class="form-control" value="{{ $detail->jasa_pelayanan }}" placeholder="0">

                                                                    <label class="mt-2">JASA DOKTER:</label>
                                                                    <input type="text" name="jasa_dokter[{{ $x }}]" class="form-control" value="{{ $detail->jasa_dokter }}" placeholder="0">

                                                                    <label class="mt-2">JASA BIDAN:</label>
                                                                    <input type="text" name="jasa_bidan[{{ $x }}]" class="form-control" value="{{ $detail->jasa_bidan }}" placeholder="0">

                                                                    <label class="mt-2">JASA PERAWAT:</label>
                                                                    <input type="text" name="jasa_perawat[{{ $x }}]" class="form-control" value="{{ $detail->jasa_perawat }}" placeholder="0">

                                                                    @php
                                                                        $isDropdown = $detail->tipe_inputan === 'Dropdown';
                                                                    @endphp

                                                                    <label class="mt-2">Tipe Inputan <span class="text-danger">*</span></label>
                                                                    <select name="tipe_inputan[{{ $x }}]" class="form-select tipe-inputan" data-index="{{ $x }}">
                                                                        <option value="" hidden>Choose</option>
                                                                        <option value="Text" {{ $detail->tipe_inputan == 'Text' ? 'selected' : '' }}>Text</option>
                                                                        <option value="Dropdown" {{ $detail->tipe_inputan == 'Dropdown' ? 'selected' : '' }}>Dropdown</option>
                                                                    </select>

                                                                    <div class="opsi-output-wrapper mt-2" id="opsi-wrapper-{{ $x }}" style="{{ $isDropdown ? '' : 'display: none;' }}">
                                                                        <label>Opsi Output</label>
                                                                        <input type="text" name="opsi_output[{{ $x }}]" class="form-control" value="{{ $detail->opsi_output }}" placeholder="e.g. Positive, Negative">
                                                                    </div>

                                                                    <div class="urutan-wrapper mt-2" id="urutan-wrapper-{{ $x }}" style="{{ $isDropdown ? '' : 'display: none;' }}">
                                                                        <label>Urutan</label>
                                                                        <input type="text" name="urutan[{{ $x }}]" class="form-control" value="{{ $detail->urutan }}" placeholder="e.g. 1">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <!-- Checkbox di tengah -->
                                                        <td class="text-center align-middle" style="min-width: 180px;">
                                                        <!-- Active to Loket -->
                                                        <div class="d-flex justify-content-center align-items-center mb-1" style="gap: 8px; white-space: nowrap;">
                                                            <label class="mb-0" style="font-size: 14px;">Active to loket?</label>
                                                            <input type="hidden" name="status_hidden[{{ $x }}]" value="deactive">
                                                            <input type="checkbox"
                                                                name="status[{{ $x }}]"
                                                                value="active"
                                                                class="form-check-input align-middle"
                                                                {{ $detail->status === 'active' ? 'checked' : '' }}>
                                                        </div>
                                                        <br>
                                                        {{-- Active Barcode --}}
                                                        <div class="d-flex justify-content-center align-items-center mb-1" style="gap: 8px; white-space: nowrap;">
                                                            <label class="mb-0" style="font-size: 14px;">Active Barcode?</label>
                                                            <input type="hidden" name="barcode_hidden[{{ $x }}]" value="deactive">
                                                            <input type="checkbox"
                                                                name="barcode[{{ $x }}]"
                                                                value="active"
                                                                class="form-check-input align-middle"
                                                                {{ $detail->barcode === 'active' ? 'checked' : '' }}>
                                                        </div>
                                                        <br>
                                                        <!-- Check to Collection -->
                                                        <div class="d-flex justify-content-center align-items-center" style="gap: 8px; white-space: nowrap;">
                                                            <label class="mb-0" style="font-size: 14px;">Check to Collection?</label>
                                                            <input type="hidden" name="permission_hidden[{{ $x }}]" value="deactive">
                                                            <input type="checkbox"
                                                                name="permission[{{ $x }}]"
                                                                value="active"
                                                                class="form-check-input align-middle"
                                                                {{ $detail->permission === 'active' ? 'checked' : '' }}>
                                                        </div>
                                                        <br>
                                                        <!-- Check to Handling -->
                                                        <div class="d-flex justify-content-center align-items-center" style="gap: 8px; white-space: nowrap;">
                                                            <label class="mb-0" style="font-size: 14px;">Check to Handling?</label>
                                                            <input type="hidden" name="handling_hidden[{{ $x }}]" value="deactive">
                                                            <input type="checkbox"
                                                                name="handling[{{ $x }}]"
                                                                value="active"
                                                                class="form-check-input align-middle"
                                                                {{ $detail->handling === 'active' ? 'checked' : '' }}>
                                                        </div>
                                                    </td>

                                                            <!-- Tombol tambah -->
                                                        <td class="text-center align-middle">
                                                            <div class="d-flex flex-column gap-2">
                                                                <!-- Button Add (hanya tampil di baris terakhir) -->
                                                                @if($loop->last)
                                                                    <button type="button" class="btn btn-success btn-add">
                                                                        <i class="ti ti-plus"></i>
                                                                    </button>
                                                                @endif
                                                                
                                                                <!-- Button Delete (tampil di semua baris, kecuali jika hanya ada 1 data) -->
                                                                @if(count($departments->detailDepartments) > 1)
                                                                    <button type="button" class="btn btn-danger btn-delete-existing" 
                                                                            data-detail-id="{{ $detail->id }}"
                                                                            data-detail-name="{{ $detail->nama_parameter }}">
                                                                        <i class="ti ti-trash"></i>
                                                                    </button>
                                                                    <!-- Hidden input untuk menandai data yang akan dihapus -->
                                                                    <input type="hidden" name="delete_detail[]" value="" class="delete-marker">
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
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
document.addEventListener('DOMContentLoaded', function () {
    // ===== HANDLER CHECKBOX =====
    function setupCheckboxHandlers() {
        // Handler untuk data existing
        document.querySelectorAll('input[name^="status["], input[name^="barcode["], input[name^="permission["], input[name^="handling["]').forEach(function(checkbox) {
            if (checkbox.type === 'checkbox') {
                const name = checkbox.name;
                const matches = name.match(/(\w+)\[(\d+)\]/);
                
                if (matches) {
                    const fieldName = matches[1];
                    const index = matches[2];
                    const hiddenInput = document.querySelector(`input[name="${fieldName}_hidden[${index}]"]`);
                    
                    checkbox.addEventListener('change', function() {
                        if (hiddenInput) {
                            hiddenInput.value = this.checked ? 'active' : 'deactive';
                        }
                    });
                    
                    // Set initial state
                    if (hiddenInput) {
                        hiddenInput.value = checkbox.checked ? 'active' : 'deactive';
                    }
                }
            }
        });
        
        // Handler untuk data baru
        document.querySelectorAll('tr').forEach(function(row, index) {
            if (row.querySelector('input[name="status[]"]')) {
                // Handler untuk status
                const statusCheckbox = row.querySelector('input[name="status[]"]');
                const statusHidden = row.querySelector('input[name="status_hidden[]"]');
                
                if (statusCheckbox && statusHidden) {
                    statusCheckbox.addEventListener('change', function() {
                        statusHidden.value = this.checked ? 'active' : 'deactive';
                    });
                    
                    // Set initial state
                    statusHidden.value = statusCheckbox.checked ? 'active' : 'deactive';
                }
                
                // Handler untuk barcode
                const barcodeCheckbox = row.querySelector('input[name="barcode[]"]');
                const barcodeHidden = row.querySelector('input[name="barcode_hidden[]"]');
                
                if (barcodeCheckbox && barcodeHidden) {
                    barcodeCheckbox.addEventListener('change', function() {
                        barcodeHidden.value = this.checked ? 'active' : 'deactive';
                    });
                    
                    // Set initial state
                    barcodeHidden.value = barcodeCheckbox.checked ? 'active' : 'deactive';
                }
                
                // Handler untuk permission
                const permissionCheckbox = row.querySelector('input[name="permission[]"]');
                const permissionHidden = row.querySelector('input[name="permission_hidden[]"]');
                
                if (permissionCheckbox && permissionHidden) {
                    permissionCheckbox.addEventListener('change', function() {
                        permissionHidden.value = this.checked ? 'active' : 'deactive';
                    });
                    
                    // Set initial state
                    permissionHidden.value = permissionCheckbox.checked ? 'active' : 'deactive';
                }
                
                // Handler untuk handling
                const handlingCheckbox = row.querySelector('input[name="handling[]"]');
                const handlingHidden = row.querySelector('input[name="handling_hidden[]"]');
                
                if (handlingCheckbox && handlingHidden) {
                    handlingCheckbox.addEventListener('change', function() {
                        handlingHidden.value = this.checked ? 'active' : 'deactive';
                    });
                    
                    // Set initial state
                    handlingHidden.value = handlingCheckbox.checked ? 'active' : 'deactive';
                }
            }
        });
    }

    // ===== HANDLER BUTTON DELETE EXISTING DATA =====
    function setupDeleteHandlers() {
        document.querySelectorAll('.btn-delete-existing').forEach(function(button) {
            button.addEventListener('click', function() {
                const detailId = this.getAttribute('data-detail-id');
                const detailName = this.getAttribute('data-detail-name');
                const row = this.closest('tr');
                
                // SweetAlert konfirmasi
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    html: `Apakah Anda yakin ingin menghapus data:<br><strong>"${detailName}"</strong>?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '<i class="ti ti-trash"></i> Ya, Hapus!',
                    cancelButtonText: '<i class="ti ti-x"></i> Batal',
                    customClass: {
                        confirmButton: 'btn btn-danger mx-2',
                        cancelButton: 'btn btn-secondary mx-2'
                    },
                    buttonsStyling: false,
                    focusCancel: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Sembunyikan baris dengan animasi
                        row.style.transition = 'all 0.3s ease';
                        row.style.opacity = '0.5';
                        row.style.backgroundColor = '#ffebee';
                        
                        setTimeout(() => {
                            row.style.display = 'none';
                        }, 300);
                        
                        // Set marker untuk dihapus di backend
                        const deleteMarker = row.querySelector('.delete-marker');
                        if (deleteMarker) {
                            deleteMarker.value = detailId;
                        }
                        
                        // Update visibility button delete jika hanya tersisa 1 data
                        updateDeleteButtonVisibility();
                        
                        // Toast notification
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            text: 'Data akan dihapus setelah Anda klik Submit',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    }
                });
            });
        });
    }

    // ===== UPDATE VISIBILITY BUTTON DELETE =====
    function updateDeleteButtonVisibility() {
        const visibleRows = document.querySelectorAll('#tableDetail tbody tr').length;
        const hiddenRows = document.querySelectorAll('#tableDetail tbody tr[style*="display: none"]').length;
        const remainingRows = visibleRows - hiddenRows;
        
        // Jika hanya tersisa 1 baris, sembunyikan semua button delete
        if (remainingRows <= 1) {
            document.querySelectorAll('.btn-delete-existing, .btn-remove').forEach(function(btn) {
                btn.style.display = 'none';
            });
        } else {
            document.querySelectorAll('.btn-delete-existing, .btn-remove').forEach(function(btn) {
                btn.style.display = 'block';
            });
        }
    }

    // ===== HANDLER ADD/REMOVE DYNAMIC ROWS =====
    function btnFunction() {
        $(".btn-add").unbind('click').bind('click', function () {
            let row = `
            <tr>
                <td>
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <label for="otomatis">Code <span class="text-danger">*</span></label>
                            <input type="text" name="kode[]" class="form-control kode" placeholder="e.g. 240562548" required>

                            <label class="mt-2">Judul</label>
                            <input type="text" name="judul[]" class="form-control" placeholder="e.g. Darah Lengkap">

                            <label class="mt-2">Nama Parameter <span class="text-danger">*</span></label>
                            <input type="text" name="nama_parameter[]" class="form-control" placeholder="e.g. Hematologi" required>

                            <label class="mt-2">Nama Pemeriksaan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pemeriksaan[]" class="form-control" placeholder="e.g. Hematologi" required>

                            <label class="mt-2">Harga <span class="text-danger">*</span></label>
                            <input type="number" name="harga[]" class="form-control" placeholder="e.g. 65000" required>

                            <label class="mt-2">Nilai Rujukan (L.13,3-17 P.11,7-15,7 nilai-kritis->(L.30;120 P.30;120)) <span class="text-danger">*</span></label>
                            <input type="text" name="nilai_rujukan[]" class="form-control" placeholder="e.g. L.13,3-17 P.11,7-15,7" required>

                            <label class="mt-2">Nilai Satuan <span class="text-danger">*</span></label>
                            <input type="text" name="nilai_satuan[]" class="form-control" placeholder="e.g. % mg/dL" required>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <label>JASA SARANA:</label>
                            <input type="number" name="jasa_sarana[]" class="form-control" placeholder="0">

                            <label class="mt-2">JASA PELAYANAN:</label>
                            <input type="number" name="jasa_pelayanan[]" class="form-control" placeholder="0">

                            <label class="mt-2">JASA DOKTER:</label>
                            <input type="number" name="jasa_dokter[]" class="form-control" placeholder="0">

                            <label class="mt-2">JASA BIDAN:</label>
                            <input type="number" name="jasa_bidan[]" class="form-control" placeholder="0">

                            <label class="mt-2">JASA PERAWAT:</label>
                            <input type="number" name="jasa_perawat[]" class="form-control" placeholder="0">

                            <label class="mt-2">Tipe Inputan <span class="text-danger">*</span></label>
                            <select name="tipe_inputan[]" class="form-select tipe-inputan">
                                <option value="" hidden>Choose</option>
                                <option value="Text">Text</option>
                                <option value="Dropdown">Dropdown</option>
                            </select>

                            <div class="opsi-output-wrapper mt-2" style="display: none;">
                                <label>Opsi Output</label>
                                <input type="text" name="opsi_output[]" class="form-control" placeholder="e.g. Positive, Negative">
                            </div>

                            <div class="urutan-wrapper mt-2" style="display: none;">
                                <label>Urutan</label>
                                <input type="text" name="urutan[]" class="form-control" placeholder="e.g. 1">
                            </div>
                        </div>
                    </div>
                </td>
                <td class="text-center align-middle" style="min-width: 180px;">
                    <div class="d-flex justify-content-center align-items-center mb-1" style="gap: 8px; white-space: nowrap;">
                        <label class="mb-0" style="font-size: 14px;">Active to loket?</label>
                        <input type="hidden" name="status_hidden[]" value="deactive">
                        <input type="checkbox" name="status[]" value="active" class="form-check-input align-middle">
                    </div>
                    <br>
                    <div class="d-flex justify-content-center align-items-center" style="gap: 8px; white-space: nowrap;">
                        <label class="mb-0" style="font-size: 14px;">Active Barcode?</label>
                        <input type="hidden" name="barcode_hidden[]" value="deactive">
                        <input type="checkbox" name="barcode[]" value="active" class="form-check-input align-middle">
                    </div>
                    <br>
                    <div class="d-flex justify-content-center align-items-center" style="gap: 8px; white-space: nowrap;">
                        <label class="mb-0" style="font-size: 14px;">Check to Collection?</label>
                        <input type="hidden" name="permission_hidden[]" value="deactive">
                        <input type="checkbox" name="permission[]" value="active" class="form-check-input align-middle">
                    </div>
                    <br>
                    <div class="d-flex justify-content-center align-items-center" style="gap: 8px; white-space: nowrap;">
                        <label class="mb-0" style="font-size: 14px;">Check to Handling?</label>
                        <input type="hidden" name="handling_hidden[]" value="deactive">
                        <input type="checkbox" name="handling[]" value="active" class="form-check-input align-middle">
                    </div>
                </td>
                <td class="text-center align-middle">
                    <div class="d-flex flex-column gap-2">
                        <button type="button" class="btn btn-success btn-add"><i class="ti ti-plus"></i></button>
                        <button type="button" class="btn btn-danger btn-remove"><i class="ti ti-trash"></i></button>
                    </div>
                </td>
            </tr>`;

            $("#tableDetail > tbody:last-child").append(row);
            
            // Re-setup handlers setelah menambah row baru
            setupDropdownListeners();
            setupCheckboxHandlers();
            updateDeleteButtonVisibility();
            btnFunction();
        });

        $(document).on('click', '.btn-remove', function() {
            $(this).closest('tr').remove();
            updateDeleteButtonVisibility();
        });
    }

    // ===== HANDLER DROPDOWN =====
    function setupDropdownListeners() {
        document.querySelectorAll('.tipe-inputan').forEach(function (select) {
            select.removeEventListener('change', handleDropdownChange);
            select.addEventListener('change', handleDropdownChange);
        });
    }

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

    // ===== HANDLER SUBMIT FORM CONFIRMATION =====
    function setupSubmitConfirmation() {
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const deletedItems = document.querySelectorAll('.delete-marker[value!=""]');
                
                if (deletedItems.length > 0) {
                    e.preventDefault();
                    
                    Swal.fire({
                        title: 'Konfirmasi Simpan',
                        html: `Anda akan menyimpan perubahan termasuk menghapus <strong>${deletedItems.length}</strong> data.<br>Apakah Anda yakin?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="ti ti-device-floppy"></i> Ya, Simpan!',
                        cancelButtonText: '<i class="ti ti-x"></i> Batal',
                        customClass: {
                            confirmButton: 'btn btn-success mx-2',
                            cancelButton: 'btn btn-secondary mx-2'
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading
                            Swal.fire({
                                title: 'Menyimpan...',
                                text: 'Mohon tunggu sebentar',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                            
                            // Submit form
                            form.submit();
                        }
                    });
                }
            });
        }
    }

    // ===== INISIALISASI =====
    btnFunction();
    setupDropdownListeners();
    setupCheckboxHandlers();
    setupDeleteHandlers();
    setupSubmitConfirmation();
    updateDeleteButtonVisibility();
});
</script>
@endpush