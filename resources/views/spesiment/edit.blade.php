@extends('layouts.admin')
@section('title')
Edit Spesiment
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
            <h1 class="h3 mb-0 text-gray-600">Edit Spesiment</h1>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="card-body">
                            <form action="{{ route('spesiments.update', $spesiments->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <h4>Edit Spesiment</h4>
                                    <hr>
                                    <label for="id_departement">Departement</label>
                                    <select class="form-control" name="id_departement" id="department" required>
                                        <option value="" hidden>Select Department</option>
                                        @foreach ($departments as $Department)
                                            <option class="form-control"
                                                value="{{ $Department->id }}" {{ $spesiments->id_departement == $Department->id ? 'selected' : '' }}>
                                                {{ $Department->nama_department }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group">
                                    <label for="spesiment">Spesiment</label>
                                    <input type="text" name="spesiment" id="spesiment" class="form-control" value="{{ $spesiments->spesiment }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="spesiment">Spesiment</label>
                                    <input type="text" name="tabung" id="tabung" class="form-control" value="{{ $spesiments->tabung }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="note">Note</label>
                                    <textarea name="note" id="note" class="form-control">{{ $spesiments->note }}</textarea>
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
                                                    <th>Gambar</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($spesiments->details as $x => $detail)
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="nama_parameter[]" class="form-control" value="{{ $detail->nama_parameter }}" required>
                                                        </td>
                                                        <td>
                                                            <input type="file" name="gambar[]" class="form-control" >
                                                            <br>
                                                            @if($detail->gambar)
                                                                <img src="{{ asset('gambar/' . $detail->gambar) }}" width="15" alt="Gambar Detail">
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-success btn-add"><i class="bi bi-plus-lg"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
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