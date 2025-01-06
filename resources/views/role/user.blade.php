<title>User</title>
@extends('layouts.admin')

@section('content')
    <section>
        <div class="content" id="scroll-content">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex mb-3">
                    <h1 class="h3 mb-0 text-gray-600">User</h1>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <div class="d-flex justify-content-between">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        + Tambah User
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('user.store') }}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="role">
                                                            <label for="poli"><b>Role</b></label>
                                                            <input class="form-control" placeholder="Superadmin"
                                                                type="text" name="name">
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
                                                <th scope="col">Role</th>
                                                <th scope="col">Guard Name</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 14px">
                                            @foreach ($roles as $role)
                                                <tr>
                                                    <td>{{ $role->id }}</td>
                                                    <td>{{ $role->name }}</td>
                                                    <td>{{ $role->guard_name }}</td>
                                                    <td>
                                                        <button class="btn btn-success btn-edit"
                                                            data-id="{{ $role->id }}" data-name="{{ $role->name }}"
                                                            data-guard="{{ $role->guard_name }}"><i
                                                                class="bi bi-pencil-square"></i>
                                                            Edit</button>

                                                        {{-- Delete --}}
                                                        <form id="delete-form-{{ $role->id }}"
                                                            action="{{ route('role.destroy', $role->id) }}" method="POST"
                                                            style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <button class="btn btn-danger"
                                                            onclick="confirmDelete({{ $role->id }})"><i
                                                                class="bi bi-trash"></i> Delete</button>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal fade" id="editRole" tabindex="-1" role="dialog"
                                    aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Edit Role</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form id="editFormRole" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="NamaRole">Role</label>
                                                        <input type="text" class="form-control" id="NamaRole"
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
                $('#NamaRole').val(name);
                $('#GuardName').val(guard);

                // Form edit 
                $('#editFormRole').attr('action', '/role/' + id);

                // show the modal
                $('#editRole').modal('show');
            });
        })
    </script>
@endpush
