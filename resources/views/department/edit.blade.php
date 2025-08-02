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
                                                                    <label for="otomatis">Code<span class="text-danger">*</span></label>
                                                                    <input type="text" name="kode[]" class="form-control" value="{{ $detail->kode }}" >
                                                                    <input type="hidden" name="id_detail[{{ $x }}]" value="{{ $detail->id }}">
                                                                    <input type="hidden" name="kode_hidden[{{ $x }}]" value="{{ $detail->kode }}" class="form-control" >

                                                                    <label class="mt-2">Nama Parameter</label>
                                                                    <input type="text" name="nama_parameter[{{ $x }}]" class="form-control" value="{{ $detail->nama_parameter }}" required>

                                                                    <label class="mt-2">Nama Pemeriksaan</label>
                                                                    <input type="text" name="nama_pemeriksaan[{{ $x }}]" class="form-control" value="{{ $detail->nama_pemeriksaan }}" required>

                                                                    <label class="mt-2">Harga</label>
                                                                    <input type="number" name="harga[{{ $x }}]" class="form-control" value="{{ $detail->harga }}" required>

                                                                    <label class="mt-2">Nilai Rujukan (L.13,3-17 P.11,7-15,7)</label>
                                                                    <input type="text" name="nilai_rujukan[{{ $x }}]" class="form-control" value="{{ $detail->nilai_rujukan }}" required>

                                                                    <label class="mt-2">Nilai Satuan</label>
                                                                    <input type="text" name="nilai_satuan[{{ $x }}]" class="form-control" value="{{ $detail->nilai_satuan }}" required>
                                                                </div>

                                                                <!-- Kolom Kanan -->
                                                                <div class="col-md-6">
                                                                    <label>JASA SARANA:</label>
                                                                    <input type="text" name="jasa_sarana[{{ $x }}]" class="form-control" value="{{ $detail->jasa_sarana }}" required>

                                                                    <label class="mt-2">JASA PELAYANAN:</label>
                                                                    <input type="text" name="jasa_pelayanan[{{ $x }}]" class="form-control" value="{{ $detail->jasa_pelayanan }}" required>

                                                                    <label class="mt-2">JASA DOKTER:</label>
                                                                    <input type="text" name="jasa_dokter[{{ $x }}]" class="form-control" value="{{ $detail->jasa_dokter }}">

                                                                    <label class="mt-2">JASA BIDAN:</label>
                                                                    <input type="text" name="jasa_bidan[{{ $x }}]" class="form-control" value="{{ $detail->jasa_bidan }}">

                                                                    <label class="mt-2">JASA PERAWAT:</label>
                                                                    <input type="text" name="jasa_perawat[{{ $x }}]" class="form-control" value="{{ $detail->jasa_perawat }}">

                                                                   @php
                                                                        $isDropdown = $detail->tipe_inputan === 'Dropdown';
                                                                    @endphp

                                                                    <label class="mt-2">Tipe Inputan</label>
                                                                    <select name="tipe_inputan[{{ $x }}]" class="form-select tipe-inputan" data-index="{{ $x }}" required>
                                                                        <option value="" hidden>Pilih tipe inputan</option>
                                                                        <option value="Text" {{ $detail->tipe_inputan == 'Text' ? 'selected' : '' }}>Text</option>
                                                                        <option value="Dropdown" {{ $detail->tipe_inputan == 'Dropdown' ? 'selected' : '' }}>Dropdown</option>
                                                                    </select>

                                                                    <div class="opsi-output-wrapper mt-2" id="opsi-wrapper-{{ $x }}" style="{{ $isDropdown ? '' : 'display: none;' }}">
                                                                        <label>Opsi Output</label>
                                                                        <input type="text" name="opsi_output[{{ $x }}]" class="form-control" value="{{ $detail->opsi_output }}" {{ $isDropdown ? 'required' : '' }}>
                                                                    </div>

                                                                    <div class="urutan-wrapper mt-2" id="urutan-wrapper-{{ $x }}" style="{{ $isDropdown ? '' : 'display: none;' }}">
                                                                        <label>Urutan</label>
                                                                        <input type="text" name="urutan[{{ $x }}]" class="form-control" value="{{ $detail->urutan }}" {{ $isDropdown ? 'required' : '' }}>
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
                                                        <td>
                                                            <div class="mt-3 text-center">
                                                                <button type="button" class="btn btn-success btn-add"><i class="ti ti-plus"></i></button>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi untuk menghasilkan kode otomatis, misalnya berdasarkan tanggal
        function generateKode(row) {
            let date = new Date();
            let year = date.getFullYear();
            let month = ('0' + (date.getMonth() + 1)).slice(-2); // Menambahkan 0 di depan jika bulan < 10
            let day = ('0' + date.getDate()).slice(-2); // Menambahkan 0 di depan jika hari < 10

            // Membuat format kode seperti: KODE-YYYYMMDD
            let kode = `${year}${month}${day}`;

            // Cari input dalam row dan set nilai otomatis ke input kode dan kode_hidden
            let kodeInput = row.querySelector('.kode');
            let hiddenKodeInput = row.querySelector('.kode_hidden');

            if (kodeInput && hiddenKodeInput) {
                kodeInput.value = kode;
                hiddenKodeInput.value = kode;
            }
        }

        function btnFunction() {
            $(".btn-add").unbind('click').bind('click', function(){
                let row = ` <tr>
                    <td>
                        <div class="row">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <label for="otomatis">Code <span class="text-danger">*</span></label>
                                <input type="text" name="kode[]" class="form-control" id="kode" required>
                                <input type="hidden" name="kode_hidden[]" id="kode_hidden">

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
                                <select name="tipe_inputan[]" class="form-select" id="" required>
                                    <option value="" selected hidden>Choose</option>
                                    <option value="Text">Text</option>
                                    <option value="Dropdown">Dropdown</option>
                                </select>

                                <label class="mt-2">Opsi Output</label>
                                <input type="text" name="opsi_output[]" class="form-control" required>

                                <label class="mt-2">Urutan</label>
                                <input type="text" name="urutan[]" class="form-control" required>
                            </div>
                        </div>
                    </td>
                    <td class="text-center align-middle" style="min-width: 180px;">
                        <div class="d-flex justify-content-center align-items-center mb-1" style="gap: 8px; white-space: nowrap;">
                            <label class="mb-0" style="font-size: 14px;">Active to loket?</label>
                            <input type="hidden" name="status" value="deactive">
                            <input type="checkbox" name="status" value="active" class="form-check-input align-middle" {{ old('status') === 'active' ? 'checked' : '' }}>
                        </div>
                        <div class="d-flex justify-content-center align-items-center" style="gap: 8px; white-space: nowrap;">
                            <label class="mb-0" style="font-size: 14px;">Active Barcode?</label>
                            <input type="hidden" name="barcode[]" value="deactive">
                            <input type="checkbox" name="barcode[]" value="active" class="form-check-input align-middle" {{ old('barcode') === 'active' ? 'checked' : '' }}>
                        </div>
                        <div class="d-flex justify-content-center align-items-center" style="gap: 8px; white-space: nowrap;">
                            <label class="mb-0" style="font-size: 14px;">Check to Collection?</label>
                            <input type="hidden" name="permission" value="deactive">
                            <input type="checkbox" name="permission" value="active" class="form-check-input align-middle" {{ old('permission') === 'active' ? 'checked' : '' }}>
                        </div>
                        <div class="d-flex justify-content-center align-items-center" style="gap: 8px; white-space: nowrap;">
                            <label class="mb-0" style="font-size: 14px;">Check to Handling?</label>
                            <input type="hidden" name="handling[]" value="deactive">
                            <input type="checkbox" name="handling[]" value="active" class="form-check-input align-middle" {{ old('handling') === 'active' ? 'checked' : '' }}>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-success btn-add"><i class="ti ti-plus"></i></button>
                    </td>
                </tr>`;

                // Tambahkan baris baru ke dalam tabel
                $("#tableDetail > tbody:last-child").append(row);

                // Panggil generateKode() pada row yang baru saja ditambahkan
                let newRow = $("#tableDetail > tbody:last-child tr:last-child")[0];
                generateKode(newRow);

                // Panggil btnFunction() lagi agar fungsi tetap aktif pada tombol add/remove
                btnFunction();
            });

            // Event untuk menghapus baris
            $(".btn-remove").unbind('click').bind('click', function(){
                $(this).closest('tr').remove();
            });
        }

        // Panggil fungsi btnFunction ketika halaman dimuat
        btnFunction();

        // function Dropdown
        document.querySelectorAll('.tipe-inputan').forEach(function(select) {
            select.addEventListener('change', function () {
                const index = this.getAttribute('data-index');
                const opsiWrapper = document.getElementById(`opsi-wrapper-${index}`);
                const urutanWrapper = document.getElementById(`urutan-wrapper-${index}`);

                const opsiInput = opsiWrapper.querySelector('input');
                const urutanInput = urutanWrapper.querySelector('input');

                if (this.value === 'Dropdown') {
                    opsiWrapper.style.display = 'block';
                    urutanWrapper.style.display = 'block';
                    opsiInput.required = true;
                    urutanInput.required = true;
                } else {
                    opsiWrapper.style.display = 'none';
                    urutanWrapper.style.display = 'none';
                    opsiInput.required = false;
                    urutanInput.required = false;
                }
            });
        });
    });
</script>


@endpush