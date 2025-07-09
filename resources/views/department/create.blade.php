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

                                                                <label class="mt-2">Nilai Rujukan <span class="text-danger">*</span></label>
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

                                                                <label class="mt-2">Tipe Inputan <span class="text-danger">*</span></label>
                                                                <input type="text" name="tipe_inputan[]" class="form-control" required>

                                                                <label class="mt-2">Opsi Output <span class="text-danger">*</span></label>
                                                                <input type="text" name="opsi_output[]" class="form-control" required>

                                                                <label class="mt-2">Urutan <span class="text-danger">*</span></label>
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
                                                            <label class="mb-0" style="font-size: 14px;">Check to Collection?</label>
                                                            <input type="hidden" name="permission" value="deactive">
                                                            <input type="checkbox" name="permission" value="active" class="form-check-input align-middle" {{ old('permission') === 'active' ? 'checked' : '' }}>
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
    let kodeInput = document.getElementById('kode');
    let hiddenKodeInput = document.getElementById('kode_hidden');

    // Fungsi untuk menghasilkan kode otomatis, misalnya berdasarkan tanggal
    function generateKode() {
        let date = new Date();
        let year = date.getFullYear();
        let month = ('0' + (date.getMonth() + 1)).slice(-2); // Menambahkan 0 di depan jika bulan < 10
        let day = ('0' + date.getDate()).slice(-2); // Menambahkan 0 di depan jika hari < 10

        // Membuat format kode seperti: KODE-YYYYMMDD
        let kode = `${year}${month}${day}`;

        // Set nilai pada input disabled dan hidden
        kodeInput.value = kode;
        hiddenKodeInput.value = kode;
    }

    // Panggil fungsi generateKode ketika halaman dimuat
    generateKode();
});

</script><script>
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
                                <input type="text" name="kode[]" class="form-control" id="kode" required >
                                <input type="hidden" name="kode_hidden[]" id="kode_hidden">

                                <label class="mt-2">Nama Parameter</label>
                                <input type="text" name="nama_parameter[]" class="form-control" required>

                                <label class="mt-2">Nama Pemeriksaan</label>
                                <input type="text" name="nama_pemeriksaan[]" class="form-control" required>

                                <label class="mt-2">Harga</label>
                                <input type="number" name="harga[]" class="form-control" required>

                                <label class="mt-2">Nilai Rujukan</label>
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
                                <input type="text" name="tipe_inputan[]" class="form-control" required>

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
                            <label class="mb-0" style="font-size: 14px;">Check to Collection?</label>
                            <input type="hidden" name="permission" value="deactive">
                            <input type="checkbox" name="permission" value="active" class="form-check-input align-middle" {{ old('permission') === 'active' ? 'checked' : '' }}>
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
    });
</script>

    
@endpush