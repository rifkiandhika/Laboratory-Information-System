@extends('layouts.admin')
@section('content')
    <section>
        <div class="content" id="scroll-content">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex mb-3">
                    <h1 class="h3 mb-0 text-gray-600">Dokter</h1>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <div class="d-flex justify-content-between">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        + Tambah Dokter
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Dokter</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="/tambah-dokter" method="post"></form>
                                                <div class="modal-body">
                                                    <div class="kodedokter">
                                                        <label for="kode-dokter"><b>Kode Dokter</b></label>
                                                        <input class="form-control" type="text" name="kode_dokter">
                                                    </div>
                                                    <div class="namadokter">
                                                        <label for="nama-dokter"><b>Nama Dokter</b></label>
                                                        <input class="form-control" type="text" name="nama_dokter">
                                                    </div>
                                                    <div class="poli">
                                                        <label for="poli"><b>Poli</b></label>
                                                        <input class="form-control" type="text" name="poli">
                                                    </div>
                                                    <div class="no-telp">
                                                        <label for="poli"><b>No.Telfon</b></label>
                                                        <input class="form-control" type="number" name="no_telp">
                                                    </div>
                                                    <div class="email">
                                                        <label for="email"><b>Email</b></label>
                                                        <input class="form-control" type="email" name="email">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                    <button type="button" class="btn btn-primary">Tambah</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-scroll table-pasien" style="width: 100%;  max-height: 550px;">
                                    <table class="table table-striped table-bordered w-100 d-block d-md-table"
                                        id="myTable">
                                        <thead style="font-size: 12px;">
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Kode Dokter</th>
                                                <th scope="col">Nama Dokter</th>
                                                <th scope="col">Poli</th>
                                                <th scope="col">No.Telfon</th>
                                                <th scope="col">Email</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 14px">
                                            @foreach ($dokters as $dokter)
                                                <tr>
                                                    <th scope="row">{{ $dokter->id }}</th>
                                                    <td>{{ $dokter->name }}</td>
                                                    <td>{{ $dokter->username }}</td>
                                                    <td>{{ $dokter->email }}</td>
                                                    <td>{{ $dokter->role }}</td>
                                                    <td>
                                                        <span class="badge bg-info">admin</span>
                                                        <span class="badge bg-primary">loket</span>
                                                        <span class="badge bg-warning">lab</span>
                                                        <span class="badge bg-success">dokter</span>
                                                    </td>
                                                    <td>{{ $dokter->created_at }}</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script src="{{ asset('js/time.js') }}"></script>

    </section>
@endsection
