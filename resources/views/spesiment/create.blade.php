@extends('layouts.admin')
@section('title')
Tambah Spesiment
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
            <h1 class="h3 mb-0 text-gray-600">Create Spesiment</h1>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="card-body">
                            <form action="{{ route('spesiments.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <h4>Spesiment</h4>
                                    <hr>
                                    <label for="id_departement">Departement</label>
                                    <select name="id_departement" id="department" class="form-control">
                                        <option value="" hidden selected>
                                        </option>
                                        @foreach ($departments as $Department)
                                            <option class="form-control"
                                                value="{{ $Department->id }}">
                                                {{ $Department->nama_department }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group">
                                    <label for="spesiment">Spesiment</label>
                                    <input type="text" name="spesiment" id="spesiment" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="tabung">Tabung</label>
                                    <input type="text" name="tabung" id="tabung" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="note">Note</label>
                                    <textarea name="note" id="note" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <hr>
                                    <h4>Detail Spesiment</h4>
                                    <hr>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="tableDetail">
                                            <thead>
                                                <tr>
                                                    <th>Parameter</th>
                                                    <th>Image</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="text" name="nama_parameter[]" class="form-control" required>
                                                    </td>
                                                    <td>
                                                        <input type="file" name="gambar[]" class="form-control" required>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-success btn-add"><i class="bi bi-plus-lg"></i></button>
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
// document.getElementById('add-detail-field').addEventListener('click', function() {
//     var newField = document.createElement('div');
//     newField.classList.add('detail-field');
//     newField.innerHTML = 
//                         `<label class="mt-4">Nama Parameter</label>` +
//                         '<input type="text" name="nama_parameter[]" class="form-control mb-4" required>' +                        
//                          '<input type="file" name="gambar[]" class="form-control" required>';
//     document.getElementById('detail-fields').appendChild(newField);
// });
function btnFunction(){
    $(".btn-add").unbind('click').bind('click', function(){
        let row = ` <tr>        
                        <td>
                            <input type="text" name="nama_parameter[]" class="form-control" required>
                        </td>
                        <td>
                            <input type="file" name="gambar[]" class="form-control" required>
                        </td>
                        <td>
                            <button type="button" class="btn btn-success btn-add"><i class="bi bi-plus-lg"></i></button>
                            <button type="button" class="btn btn-danger btn-remove"><i class="bi bi-dash-lg"></i></button>
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