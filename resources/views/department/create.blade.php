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
                                                    <th>Kode</th>
                                                    <th>Parameter</th>
                                                    <th>Pemeriksaan</th>
                                                    <th>Tarif</th>
                                                    <th>Komponen Tarif</th>
                                                    <th>Nilai Rujukan</th>
                                                    <th>Satuan</th>
                                                    <th>Tipe Inputan Hasil</th>
                                                    <th>Opsi Output an Hasil</th>
                                                    <th>Metode</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="col-2">
                                                        <label for="otomatis">Otomatis <span class="text-danger">*</span></label>
                                                        <input type="text" name="kode[]" class="form-control" id="kode" required disabled>
                                                        <!-- Hidden input untuk mengirim nilai kode -->
                                                        <input type="hidden" name="kode_hidden[]" id="kode_hidden">
                                                    </td>                                                    
                                                    <td class="col-2">
                                                        <input type="text" name="nama_parameter[]" class="form-control" required>
                                                    </td>
                                                    <td class="col-2">
                                                        <input type="text" name="nama_pemeriksaan[]" class="form-control" required>
                                                    </td>
                                                    <td class="col-2">
                                                        <input type="number" name="harga[]" class="form-control" required>
                                                    </td>
                                                    <td class="col-3">
                                                        <label for="jasa_sarana">JASA SARANA:</label>
                                                        <input type="text" name="jasa_sarana[]" class="form-control" required>
                                                        <label for="jasa_pelayanan">JASA PELAYANAN:</label>
                                                        <input type="text" name="jasa_pelayanan[]" class="form-control" required>
                                                        <label for="jasa_dokter">JASA DOKTER:</label>
                                                        <input type="text" name="jasa_dokter[]" class="form-control" >
                                                        <label for="jasa_bidan">JASA BIDAN:</label>
                                                        <input type="text" name="jasa_bidan[]" class="form-control" >
                                                        <label for="jasa_perawat">JASA PERAWAT:</label>
                                                        <input type="text" name="jasa_perawat[]" class="form-control" >
                                                    </td>
                                                    <td class="col-1">
                                                        <input type="text" name="nilai_rujukan[]" class="form-control" required>
                                                    </td>
                                                    <td class="col-1">
                                                        <input type="text" name="nilai_satuan[]" class="form-control" required>
                                                    </td>
                                                    <td class="col-1">
                                                        <input type="text" name="tipe_inputan[]" class="form-control" required>
                                                    </td>
                                                    <td class="col-1">
                                                        <input type="text" name="opsi_output[]" class="form-control" required>
                                                    </td>
                                                    <td class="col-1">
                                                        <input type="text" name="urutan[]" class="form-control" required>
                                                    </td>
                                                    <td class="col-3">
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
                                <div class="text-end">
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
                    <td class="col-2">
                        <label for="otomatis">Otomatis <span class="text-danger">*</span></label>
                        <input type="text" name="kode[]" class="form-control kode" required disabled>
                        <!-- Hidden input untuk mengirim nilai kode -->
                        <input type="hidden" name="kode_hidden[]" class="kode_hidden">
                    </td>                                                    
                    <td class="col-2">
                        <input type="text" name="nama_parameter[]" class="form-control" required>
                    </td>
                    <td class="col-2">
                        <input type="text" name="nama_pemeriksaan[]" class="form-control" required>
                    </td>
                    <td class="col-2">
                        <input type="number" name="harga[]" class="form-control" required>
                    </td>
                    <td class="col-3">
                        <label for="jasa_sarana">JASA SARANA:</label>
                        <input type="text" name="jasa_sarana[]" class="form-control" required>
                        <label for="jasa_pelayanan">JASA PELAYANAN:</label>
                        <input type="text" name="jasa_pelayanan[]" class="form-control" required>
                        <label for="jasa_dokter">JASA DOKTER:</label>
                        <input type="text" name="jasa_dokter[]" class="form-control" >
                        <label for="jasa_bidan">JASA BIDAN:</label>
                        <input type="text" name="jasa_bidan[]" class="form-control" >
                        <label for="jasa_perawat">JASA PERAWAT:</label>
                        <input type="text" name="jasa_perawat[]" class="form-control" >
                    </td>
                    <td class="col-1">
                        <input type="text" name="nilai_rujukan[]" class="form-control" required>
                    </td>
                    <td class="col-1">
                        <input type="text" name="nilai_satuan[]" class="form-control" required>
                    </td>
                    <td class="col-1">
                        <input type="text" name="tipe_inputan[]" class="form-control" required>
                    </td>
                    <td class="col-1">
                        <input type="text" name="opsi_output[]" class="form-control" required>
                    </td>
                    <td class="col-1">
                        <input type="text" name="urutan[]" class="form-control" required>
                    </td>
                    <td class="col-3">
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