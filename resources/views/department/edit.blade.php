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
                                                    <th>Kode</th>
                                                    <th>Parameter</th>
                                                    <th>Pemeriksaan</th>
                                                    <th>Tarif</th>
                                                    <th>Komponen Tarif</th>
                                                    <th>Nilai Rujukan</th>
                                                    <th>Satuan</th>
                                                    <th>Tipe Inputan Hasil</th>
                                                    <th>Opsi Output Hasil</th>
                                                    <th>Urutan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($departments->detailDepartments as $x => $detail)
                                                    <tr>
                                                        <td class="col-2">
                                                            <label for="otomatis">Otomatis <span class="text-danger">*</span></label>
                                                            <input type="text" name="kode[]" class="form-control" value="{{ $detail->kode }}" disabled>
                                                            <!-- Hidden input untuk mengirim nilai kode -->
                                                            <input type="hidden" name="kode_hidden[]" value="{{ $detail->kode }}">
                                                        </td>
                                                        <td class="col-2">
                                                            <input type="text" name="nama_parameter[]" class="form-control" value="{{ $detail->nama_parameter }}" required>
                                                        </td>
                                                        <td class="col-2">
                                                            <input type="text" name="nama_pemeriksaan[]" class="form-control" value="{{ $detail->nama_pemeriksaan }}" required>
                                                        </td>
                                                        <td class="col-2">
                                                            <input type="number" name="harga[]" class="form-control" value="{{ $detail->harga }}" required>
                                                        </td>
                                                        <td class="col-3">
                                                            <label for="jasa_sarana">JASA SARANA:</label>
                                                            <input type="text" name="jasa_sarana[]" class="form-control" value="{{ $detail->jasa_sarana }}" required>
                                                            <label for="jasa_pelayanan">JASA PELAYANAN:</label>
                                                            <input type="text" name="jasa_pelayanan[]" class="form-control" value="{{ $detail->jasa_pelayanan }}" required>
                                                            <label for="jasa_dokter">JASA DOKTER:</label>
                                                            <input type="text" name="jasa_dokter[]" class="form-control" value="{{ $detail->jasa_dokter }}">
                                                            <label for="jasa_bidan">JASA BIDAN:</label>
                                                            <input type="text" name="jasa_bidan[]" class="form-control" value="{{ $detail->jasa_bidan }}">
                                                            <label for="jasa_perawat">JASA PERAWAT:</label>
                                                            <input type="text" name="jasa_perawat[]" class="form-control" value="{{ $detail->jasa_perawat }}">
                                                        </td>
                                                        <td class="col-1">
                                                            <input type="text" name="nilai_rujukan[]" class="form-control" value="{{ $detail->nilai_rujukan }}" required>
                                                        </td>
                                                        <td class="col-1">
                                                            <input type="text" name="nilai_satuan[]" class="form-control" value="{{ $detail->nilai_satuan }}" required>
                                                        </td>
                                                        <td class="col-1">
                                                            <input type="text" name="tipe_inputan[]" class="form-control" value="{{ $detail->tipe_inputan }}" required>
                                                        </td>
                                                        <td class="col-1">
                                                            <input type="text" name="opsi_output[]" class="form-control" value="{{ $detail->opsi_output }}" required>
                                                        </td>
                                                        <td class="col-1">
                                                            <input type="text" name="urutan[]" class="form-control" value="{{ $detail->urutan }}" required>
                                                        </td>
                                                        <td class="col-3">
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
        function btnFunction(){
        $(".btn-add").unbind('click').bind('click', function(){
            let row = ` <tr>        
                           <td>
                            <input type="text" name="kode[]" class="form-control" required>
                        </td>
                        <td>
                            <input type="text" name="nama_parameter[]" class="form-control" required>
                        </td>
                        <td>
                            <input type="text" name="nama_pemeriksaan[]" class="form-control" required>
                        </td>
                        <td>
                            <input type="text" name="harga[]" class="form-control" required>
                        </td>
                        <td>
                            <input type="text" name="nilai_statik[]" class="form-control" required>
                        </td>
                        <td>
                            <input type="text" name="nilai_satuan[]" class="form-control" required>
                        </td>
                        <td>
                            <button type="button" class="btn btn-success btn-add"><i class="ti ti-plus"></i></button>
                            <button type="button" class="btn btn-danger btn-remove"><i class="ti ti-minus"></i></button>
                        </td>
                        </tr>`;
            $("#tableDetail > tbody:last-child").append(row);

            btnFunction();
        });

        $(".btn-remove").unbind('click').bind('click', function(){
            $(this).closest('tr').remove();
        });
        }

        btnFunction();
    </script>

@endpush