<title>Permission</title>
@extends('layouts.admin')

@section('content')
    <section>
        <div class="content" id="scroll-content">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex mb-3">
                    <h1 class="h3 mb-0 text-gray-600">Permission</h1>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <div class="d-flex justify-content-between">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        + Tambah Permission
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Permission</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('permission.store') }}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="permission">
                                                            <label for="permission"><b>Permission</b></label>
                                                            <input class="form-control"
                                                                placeholder="update master-data/tags" type="text"
                                                                name="name">
                                                        </div>
                                                        <div class="guard">
                                                            <label for="guard"><b>Guard Name</b></label>
                                                            <input class="form-control" placeholder="Web" type="text"
                                                                name="guard_name">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-scroll " style="width: 100%;  max-height: 550px;">
                                    <table class="table table-striped table-bordered w-100 d-block d-md-table "
                                        id="myTable">
                                        <thead style="font-size: 12px;">
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Permission</th>
                                                <th scope="col">Guard Name</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 14px">
                                            @foreach ($permissions as $permission)
                                                <tr>
                                                    <td>{{ $permission->id }}</td>
                                                    <td>{{ $permission->name }}</td>
                                                    <td>{{ $permission->guard_name }}</td>
                                                    <td>
                                                        <button class="btn btn-success btn-edit"
                                                            data-id="{{ $permission->id }}"
                                                            data-name="{{ $permission->name }}"
                                                            data-guard="{{ $permission->guard_name }}"><i
                                                                class="bi bi-pencil-square"></i>
                                                            Edit</button>

                                                        {{-- Delete --}}
                                                        <form id="delete-form-{{ $permission->id }}"
                                                            action="{{ route('permission.destroy', $permission->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <button class="btn btn-danger"
                                                            onclick="confirmDelete({{ $permission->id }})"><i
                                                                class="bi bi-trash"></i> Delete</button>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal fade" id="editPermission" tabindex="-1" role="dialog"
                                    aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Edit Permission</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form id="editFormPermission" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="NamaPermission">Permission</label>
                                                        <input type="text" class="form-control" id="NamaPermission"
                                                            name="name" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="guardname">Guard Name</label>
                                                        <input type="text" class="form-control" id="GuardName"
                                                            name="guard_name" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
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
                var guard = $(this).data('guard');

                // set the values modal
                $('#NamaPermission').val(name);
                $('#GuardName').val(guard);

                // Form edit 
                $('#editFormPermission').attr('action', '/permission/' + id);

                // show the modal
                $('#editPermission').modal('show');
            });
        })
    </script>
@endpush
