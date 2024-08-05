@extends('layouts.admin')
@section('title')
Spesiment
@endsection

@section('content')
<section>
    <div class="content" id="scroll-content">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex mb-3">
                <h1 class="h3 mb-0 text-gray-600">Spesiment Data</h1>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="d-flex justify-content-between">
                                <!-- Button trigger modal -->
                                {{-- <button type="button"  class="btn btn-outline-primary">
                                    + Add Spesiment
                                </button> --}}
                                <a class="btn btn-outline-primary" href="{{ route('spesiments.create') }}">+ Add Spesiment</a>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-scroll " style="width: 100%;  max-height: 550px;">
                                <table class="table table-striped table-bordered w-100 d-block d-md-table "
                                    id="myTable">
                                    <thead style="font-size: 12px;">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Department</th>
                                            <th scope="col">Spesiment</th>
                                            <th scope="col">Tabung</th>
                                            <th scope="col">Detail</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 14px">
                                        @foreach ($spesiments as $x => $Spesiment)
                                            <tr>
                                                <td>{{ $x + 1 }}</td>
                                                <td>{{ $Spesiment->department->nama_department}}</td>
                                                <td>{{ $Spesiment->spesiment }}</td>
                                                <td>{{ $Spesiment->tabung }}</td>
                                                <td>
                                                    <ul>
                                                        @foreach($Spesiment->details as $detail)
                                                            <li>{{ $detail->nama_parameter }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>
                                                        <a class="btn btn-success" href="{{ route('spesiments.edit', $Spesiment->id) }}">
                                                        <i
                                                            class="bi bi-pencil-square"></i>
                                                        Edit</a>

                                                    {{-- Delete --}}
                                                    <form id="delete-form-{{ $Spesiment->id }}"
                                                        action="{{ route('spesiments.destroy', $Spesiment->id) }}" method="POST"
                                                        style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <button class="btn btn-danger"
                                                        onclick="confirmDelete({{ $Spesiment->id }})"><i
                                                            class="bi bi-trash"></i> Delete</button>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal fade" id="editSpesiment" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Spesiment Edit</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="editFormSpesiment" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="spesiment">Department</label>
                                                    <select class="form-control" name="id_departement" id="Department">
                                                        <option value="" hidden></option>
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
                                                    <input class="form-control" type="text" name="spesiment" id="Spesiment">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>



</section>
@endsection
