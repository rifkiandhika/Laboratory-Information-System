<title>Department</title>
@extends('layouts.admin')
@section('content')
    <section>
        <div class="content" id="scroll-content">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex mb-3">
                    <h1 class="h3 mb-0 text-gray-600">Department Data</h1>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <div class="d-flex justify-content-between">
                                    @if (session('error'))
                                        <p class="alert alert-danger">{{ session('error') }}</p>
                                    @endif

                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        + Add Department
                                    </button>


                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Department</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('department.store') }}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="department">
                                                            <label for="department"><b>Department</b></label>
                                                            <input class="form-control" placeholder="Hematologi"
                                                                type="text" name="nama_department" required>
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
                            <div class="card-body">
                                <div class="table-scroll table-pasien" style="width: 100%;  max-height: 550px;">
                                    <table class="table table-striped table-bordered w-100 d-block d-md-table "
                                        id="myTable">
                                        <thead style="font-size: 12px;">
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Department Action</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 14px">
                                            @foreach ($departments as $Department)
                                                <tr>
                                                    <td>{{ $Department->id }}</td>
                                                    <td>{{ $Department->nama_department }}</td>
                                                    <td>
                                                        {{-- Edit --}}
                                                        <button class="btn btn-success btn-edit"
                                                            data-id="{{ $Department->id }}"
                                                            data-name="{{ $Department->nama_department }}"><i
                                                                class="bi bi-pencil-square"></i>
                                                            Edit</button>
                                                        {{-- Delete --}}
                                                        <form id="delete-form-{{ $Department->id }}"
                                                            action="{{ route('department.destroy', $Department->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <button class="btn btn-danger"
                                                            onclick="confirmDelete({{ $Department->id }})"><i
                                                                class="bi bi-trash"></i> Delete</button>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{-- Edit Dokter --}}
                                    <div class="modal fade" id="editDepartment" tabindex="-1" role="dialog"
                                        aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel">Department Edit</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="editFormDepartment" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="Department">
                                                            <label for="Department"><b>Department</b></label>
                                                            <input class="form-control" type="text" id="Department"
                                                                name="nama_department" required>
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
                                    {{-- Edit Dokter --}}
                                </div>
                            </div>
                        </div>

                        <script src="{{ asset('js/time.js') }}"></script>


    </section>
@endsection
@push('script')
    <script>
        $(function() {
            $('.btn-edit').on('click', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');

                // set the values modal
                $('#Department').val(name);

                // Form edit 
                $('#editFormDepartment').attr('action', '/department/' + id);

                // show the modal
                $('#editDepartment').modal('show');
            });
        })
    </script>
@endpush
