<title>Poli</title>
@extends('layouts.admin')
@section('content')
    <section>
        <div class="content" id="scroll-content">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex mb-3">
                    <h1 class="h3 mb-0 text-gray-600">Data Poli</h1>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <div class="d-flex justify-content-between">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        + Tambah Poli
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Poli</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('poli.store') }}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="poli">
                                                            <label for="poli"><b>Nama Poli</b></label>
                                                            <input class="form-control" placeholder="Poli Gigi"
                                                                type="text" name="nama_poli">
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
                                                <th scope="col">Poli</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 14px">
                                            @foreach ($polis as $Poli)
                                                <tr>
                                                    <td>{{ $Poli->id }}</td>
                                                    <td>{{ $Poli->nama_poli }}</td>
                                                    <td>
                                                        <button class="btn btn-success btn-edit"
                                                            data-id="{{ $Poli->id }}"
                                                            data-name="{{ $Poli->nama_poli }}"><i
                                                                class="bi bi-pencil-square"></i>
                                                            Edit</button>

                                                        {{-- Delete --}}
                                                        <form id="delete-form-{{ $Poli->id }}"
                                                            action="{{ route('poli.destroy', $Poli->id) }}" method="POST"
                                                            style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <button class="btn btn-danger"
                                                            onclick="confirmDelete({{ $Poli->id }})"><i
                                                                class="bi bi-trash"></i> Delete</button>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal fade" id="editPoli" tabindex="-1" role="dialog"
                                    aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Edit Poli</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form id="editFormPoli" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="NamaPoli">Poli</label>
                                                        <input type="text" class="form-control" id="NamaPoli"
                                                            name="nama_poli" required>
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

                // set the values modal
                $('#NamaPoli').val(name);

                // Form edit 
                $('#editFormPoli').attr('action', '/poli/' + id);

                // show the modal
                $('#editPoli').modal('show');
            });
        })
    </script>
@endpush
