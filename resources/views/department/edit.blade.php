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
                                                    <th class="col-2">Kode</th>
                                                    <th class="col-1">Parameter</th>
                                                    <th class="col-1">Pemeriksaan</th>
                                                    <th class="col-2">Tarif</th>
                                                    <th class="col-1">Komponen Tarif</th>
                                                    <th class="col-1">Nilai Rujukan</th>
                                                    <th class="col-1">Satuan</th>
                                                    <th class="col-1">Tipe Input</th>
                                                    <th class="col-1">Opsi Output</th>
                                                    <th class="col-1">Metode</th>
                                                    <th class="col-1">Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($departments->detailDepartments as $x => $detail)
                                                    <tr>
                                                        <td>
                                                            <label for="otomatis">Otomatis <span class="text-danger">*</span></label>
                                                            <input type="text" name="kode[]" class="form-control" value="{{ $detail->kode }}" disabled>
                                                            <input type="hidden" name="id_detail[{{ $x }}]" value="{{ $detail->id }}">
                                                            <input type="hidden" name="kode_hidden[{{ $x }}]" value="{{ $detail->kode }}" class="form-control" readonly>
                                                        
                                                        </td>
                                                        <td>
                                                            <input type="text" name="nama_parameter[{{ $x }}]" class="form-control" value="{{ $detail->nama_parameter }}" required>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="nama_pemeriksaan[{{ $x }}]" class="form-control" value="{{ $detail->nama_pemeriksaan }}" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="harga[{{ $x }}]" class="form-control" value="{{ $detail->harga }}" required>
                                                        </td>
                                                        <td>
                                                            <label for="jasa_sarana">JASA SARANA:</label>
                                                            <input type="text" name="jasa_sarana[{{ $x }}]" class="form-control" value="{{ $detail->jasa_sarana }}" required>
                                                            <label for="jasa_pelayanan">JASA PELAYANAN:</label>
                                                            <input type="text" name="jasa_pelayanan[{{ $x }}]" class="form-control" value="{{ $detail->jasa_pelayanan }}" required>
                                                            <label for="jasa_dokter">JASA DOKTER:</label>
                                                            <input type="text" name="jasa_dokter[{{ $x }}]" class="form-control" value="{{ $detail->jasa_dokter }}">
                                                            <label for="jasa_bidan">JASA BIDAN:</label>
                                                            <input type="text" name="jasa_bidan[{{ $x }}]" class="form-control" value="{{ $detail->jasa_bidan }}">
                                                            <label for="jasa_perawat">JASA PERAWAT:</label>
                                                            <input type="text" name="jasa_perawat[{{ $x }}]" class="form-control" value="{{ $detail->jasa_perawat }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="nilai_rujukan[{{ $x }}]" class="form-control" value="{{ $detail->nilai_rujukan }}" required>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="nilai_satuan[{{ $x }}]" class="form-control" value="{{ $detail->nilai_satuan }}" required>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="tipe_inputan[{{ $x }}]" class="form-control" value="{{ $detail->tipe_inputan }}" required>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="opsi_output[{{ $x }}]" class="form-control" value="{{ $detail->opsi_output }}" required>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="urutan[{{ $x }}]" class="form-control" value="{{ $detail->urutan }}" required>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="checkbox" name="status[{{ $x }}]" value="active"
                                                                class="form-check-input"
                                                                {{ $detail->status === 'active' ? 'checked' : '' }}>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-success btn-add"><i class="ti ti-plus"></i></button>
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
                        <label for="otomatis">Otomatis <span class="text-danger">*</span></label>
                        <input type="text" name="kode[]" class="form-control kode" required disabled>
                        <!-- Hidden input untuk mengirim nilai kode -->
                        <input type="hidden" name="kode_hidden[]" class="kode_hidden">
                    </td>                                                    
                    <td>
                        <input type="text" name="nama_parameter[]" class="form-control" required>
                    </td>
                    <td>
                        <input type="text" name="nama_pemeriksaan[]" class="form-control" required>
                    </td>
                    <td>
                        <input type="number" name="harga[]" class="form-control" required>
                    </td>
                    <td>
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
                    <td>
                        <input type="text" name="nilai_rujukan[]" class="form-control" required>
                    </td>
                    <td>
                        <input type="text" name="nilai_satuan[]" class="form-control" required>
                    </td>
                    <td>
                        <input type="text" name="tipe_inputan[]" class="form-control" required>
                    </td>
                    <td>
                        <input type="text" name="opsi_output[]" class="form-control" required>
                    </td>
                    <td>
                        <input type="text" name="urutan[]" class="form-control" required>
                    </td>
                    <td class="text-center">
                    <input type="checkbox" name="status[]" value="active" class="form-check-input">
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