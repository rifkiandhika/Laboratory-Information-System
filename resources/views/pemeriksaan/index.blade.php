<title>Pemeriksaan</title>
@extends('layouts.admin')
@section('content')
    <section>
        <div class="content" id="scroll-content">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex mb-3">
                    <h1 class="h3 mb-0 text-gray-600">Inspection Data</h1>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <div class="d-flex justify-content-between">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        + Add Inspection
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Add Inspection</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('pemeriksaan.store') }}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="namaparameter">
                                                            <label for="nama-parameter"><b>Parameter Name</b></label>
                                                            <input class="form-control" placeholder="HDL-CHOL"
                                                                type="text" name="nama_parameter">
                                                        </div>
                                                        <div class="nama-pemeriksaan">
                                                            <label for="nama-pemeriksaan"><b>Inspection Name</b></label>
                                                            <input class="form-control" placeholder="Gula Darah"
                                                                type="text" name="nama_pemeriksaan">
                                                        </div>
                                                        <div class="id-department">
                                                            <label for="id-department"><b>Department</b></label>
                                                            <select name="id_departement" id=""
                                                                class="form-control">
                                                                <option value="" hidden>Department</option>
                                                                @foreach ($departments as $Department)
                                                                    <option class="form-control"
                                                                        value="{{ $Department->id }}">
                                                                        {{ $Department->nama_department }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="harga">
                                                            <label for="harga"><b>Price</b></label>
                                                            <input class="form-control" placeholder="35.000" type="number"
                                                                name="harga">
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
                                                <th scope="col">Parameter Name</th>
                                                <th scope="col">Inspection Name</th>
                                                <th scope="col">Department</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 14px">
                                            @foreach ($pemeriksaans as $Pemeriksaan)
                                                <tr>
                                                    <td>{{ $Pemeriksaan->id }}</td>
                                                    <td>{{ $Pemeriksaan->nama_parameter }}</td>
                                                    <td>{{ $Pemeriksaan->nama_pemeriksaan }}</td>
                                                    <td>{{ $Pemeriksaan->department->nama_department }}</td>
                                                    <td>{{ $Pemeriksaan->harga }}</td>
                                                    <td>
                                                        <button class="btn btn-success btn-edit"
                                                            data-id="{{ $Pemeriksaan->id }}"
                                                            data-parameter="{{ $Pemeriksaan->nama_parameter }}"
                                                            data-pemeriksaan="{{ $Pemeriksaan->nama_pemeriksaan }}"
                                                            data-department="{{ $Pemeriksaan->department->id }}"
                                                            data-harga="{{ $Pemeriksaan->harga }}"><i
                                                                class="bi bi-pencil-square"></i>
                                                            Edit</button>
                                                        {{-- Delete --}}
                                                        <form id="delete-form-{{ $Pemeriksaan->id }}"
                                                            action="{{ route('pemeriksaan.destroy', $Pemeriksaan->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <button class="btn btn-danger"
                                                            onclick="confirmDelete({{ $Pemeriksaan->id }})"><i
                                                                class="bi bi-trash"></i> Delete</button>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{-- Edit Dokter --}}
                                    <div class="modal fade" id="editPemeriksaan" tabindex="-1" role="dialog"
                                        aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel">Inspection Edit</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="editFormPemeriksaan" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="namaparameter">
                                                            <label for="nama-parameter"><b>Parameter Name</b></label>
                                                            <input class="form-control" type="text" id="Parameter"
                                                                name="nama_parameter" required>
                                                        </div>
                                                        <div class="namapemeriksaan">
                                                            <label for="nama-pemeriksaan"><b>Inspection Name</b></label>
                                                            <input class="form-control" id="Pemeriksaan" type="text"
                                                                name="nama_pemeriksaan" required>
                                                        </div>
                                                        <div class="department">
                                                            <label for="department"><b>Department</b></label>
                                                            <select name="id_departement" id="department"
                                                                class="form-control">
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
                                                        <div class="harga">
                                                            <label for="harga"><b>Price</b></label>
                                                            <input class="form-control" id="Harga" type="number"
                                                                name="harga" required>
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
                var parameter = $(this).data('parameter');
                var pemeriksaan = $(this).data('pemeriksaan');
                var department = $(this).data('department');
                var harga = $(this).data('harga');

                // set the values modal
                $('#Parameter').val(parameter);
                $('#Pemeriksaan').val(pemeriksaan);
                $('#department').val(department);
                $('#Harga').val(harga);

                // Form edit 
                $('#editFormPemeriksaan').attr('action', '/pemeriksaan/' + id);

                // show the modal
                $('#editPemeriksaan').modal('show');
            });
        })
    </script>
@endpush
