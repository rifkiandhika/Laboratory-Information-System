<title>Dokter</title>
@extends('layouts.admin')
@section('content')
    <section>
        <div class="content" id="scroll-content">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex mb-3">
                    <div class="row">
                        <h1 class="h3 mb-0 text-gray-600">Doctor Data</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <div class="d-flex justify-content-between">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        + Add Doctor
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Doctor</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('dokter.store') }}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="kodedokter">
                                                            <label for="kode-dokter"><b>Doctor Code</b></label>
                                                            <input class="form-control" placeholder="D01094" type="text"
                                                                name="kode_dokter">
                                                        </div>
                                                        <div class="namadokter">
                                                            <label for="nama-dokter"><b>Doctor Name</b></label>
                                                            <input class="form-control" placeholder="Abdul Mughni"
                                                                type="text" name="nama_dokter">
                                                        </div>
                                                        <div class="poli">
                                                            <label for="poli"><b>Poli</b></label>
                                                            <select name="id_poli" id="" class="form-control">
                                                                <option value="" hidden>Poli</option>
                                                                @foreach ($polis as $Poli)
                                                                    <option class="form-control"
                                                                        value="{{ $Poli->id }}">
                                                                        {{ $Poli->nama_poli }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="no-telp">
                                                            <label for="telp"><b>Phone Number</b></label>
                                                            <input class="form-control" placeholder="08xxxxxx"
                                                                type="number" name="no_telp">
                                                        </div>
                                                        <div class="email">
                                                            <label for="email"><b>Email</b></label>
                                                            <input class="form-control" placeholder="dokter@gmail.com"
                                                                type="email" name="email">
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
                                <div class="table-responsive">
                                    <table class="table-striped " id="myTable">
                                        <thead style="font-size: 12px;">
                                            <tr>
                                                <th scope="col">No.</th>
                                                <th scope="col">Doctor Code</th>
                                                <th scope="col">Doctor Name</th>
                                                <th scope="col">Poli</th>
                                                <th scope="col">Phone Number</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 14px">
                                            @foreach ($dokters as $dokter)
                                                <tr>
                                                    <td>{{ $dokter->id }}</td>
                                                    <td>{{ $dokter->kode_dokter }}</td>
                                                    <td>{{ $dokter->nama_dokter }}</td>
                                                    <td>{{ $dokter->poli->nama_poli }}</td>
                                                    <td>{{ $dokter->no_telp }}</td>
                                                    <td>{{ $dokter->email }}</td>
                                                    <td>
                                                        <button class="btn btn-success btn-edit"
                                                            data-id="{{ $dokter->id }}"
                                                            data-kode="{{ $dokter->kode_dokter }}"
                                                            data-nama="{{ $dokter->nama_dokter }}"
                                                            data-poli="{{ $dokter->poli->id }}"
                                                            data-telp="{{ $dokter->no_telp }}"
                                                            data-email="{{ $dokter->email }}"><i
                                                                class="bi bi-pencil-square"></i>
                                                            Edit</button>
                                                        {{-- Delete --}}
                                                        <form id="delete-form-{{ $dokter->id }}"
                                                            action="{{ route('dokter.destroy', $dokter->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <button class="btn btn-danger"
                                                            onclick="confirmDelete({{ $dokter->id }})"><i
                                                                class="bi bi-trash"></i> Delete</button>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{-- Edit Dokter --}}
                                    <div class="modal fade" id="editDokter" tabindex="-1" role="dialog"
                                        aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel">Doctor Edit</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="editFormdokter" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="kodedokter">
                                                            <label for="kodedokter"><b>Doctor Code</b></label>
                                                            <input class="form-control" type="text" id="kodedokter"
                                                                name="kode_dokter" required>
                                                        </div>
                                                        <div class="namadokter">
                                                            <label for="namadokter"><b>Doctor Name</b></label>
                                                            <input class="form-control" id="namadokter" type="text"
                                                                name="nama_dokter" required>
                                                        </div>
                                                        <div class="poli">
                                                            <label for="poli"><b>Poli</b></label>
                                                            <select name="id_poli" id="poli" class="form-control">
                                                                <option value="" hidden selected>
                                                                </option>
                                                                @foreach ($polis as $Poli)
                                                                    <option class="form-control"
                                                                        value="{{ $Poli->id }}">
                                                                        {{ $Poli->nama_poli }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                        <div class="no-telp">
                                                            <label for="poli"><b>Phone Number</b></label>
                                                            <input class="form-control" id="telp" type="number"
                                                                name="no_telp" required>
                                                        </div>
                                                        <div class="email">
                                                            <label for="email"><b>Email</b></label>
                                                            <input class="form-control" id="email" type="email"
                                                                name="email" required>
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


    </section>
@endsection

@push('script')
    <script>
        $(function() {
            $('.btn-edit').on('click', function() {
                var id = $(this).data('id');
                var kode = $(this).data('kode');
                var nama = $(this).data('nama');
                var poli = $(this).data('poli');
                var telp = $(this).data('telp');
                var email = $(this).data('email');

                // set the values modal
                $('#kodedokter').val(kode);
                $('#namadokter').val(nama);
                $('#poli').val(poli);
                $('#telp').val(telp);
                $('#email').val(email);

                // Form edit 
                $('#editFormdokter').attr('action', '/dokter/' + id);

                // show the modal
                $('#editDokter').modal('show');
            });
        })
    </script>
@endpush
