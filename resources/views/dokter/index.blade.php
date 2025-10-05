<title>Dokter</title>
@extends('layouts.admin')
@section('content')
<section>
    <div class="content" id="scroll-content">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex mb-3">
                <div class="row">
                    <h1 class="h3 mb-0 text-gray-600">Data</h1>
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
                                    + Tambah
                                </button>

                                <!-- Modal Add -->
                                <div class="modal fade" id="exampleModal" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Dokter / Pengirim</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('dokter.store') }}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label><b>Code</b></label>
                                                        <input class="form-control" placeholder="D01094" type="text"
                                                            name="kode_dokter" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><b>NIP/NIK</b></label>
                                                        <input class="form-control" placeholder="355102" type="text"
                                                            name="nip" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><b>Name</b></label>
                                                        <input class="form-control" placeholder="Abdul Mughni"
                                                            type="text" name="nama_dokter" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><b>Room</b></label>
                                                        <select name="id_poli" class="form-control" required>
                                                            <option value="" hidden>Room</option>
                                                            @foreach ($polis as $Poli)
                                                                <option value="{{ $Poli->id }}">
                                                                    {{ $Poli->nama_poli }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><b>Poli</b></label>
                                                        <input class="form-control" type="text" placeholder="KIA"
                                                            name="poli" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><b>Jabatan</b></label>
                                                        <select class="form-control" name="jabatan" id="Jabatan" required>
                                                            <option value="" selected hidden>Pilih Jabatan</option>
                                                            <option value="dokter">Dokter</option>
                                                            <option value="bidan">Bidan</option>
                                                            <option value="perawat">Perawat</option>
                                                            <option value="pelayanan">Pelayanan</option>
                                                            <option value="sarana">Sarana</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><b>Phone Number</b></label>
                                                        <input class="form-control" placeholder="08xxxxxx"
                                                            type="number" name="no_telp" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><b>Email</b></label>
                                                        <input class="form-control" placeholder="dokter@gmail.com"
                                                            type="email" name="email" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><b>Status</b></label>
                                                        <select name="status" class="form-control" required>
                                                            <option value="" selected hidden>Choose..</option>
                                                            <option value="internal">Internal</option>
                                                            <option value="external">External</option>
                                                        </select>
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
                                <!-- End Modal Add -->
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="myTable">
                                    <thead style="font-size: 12px;">
                                        <tr>
                                            <th scope="col">No.</th>
                                            <th scope="col">Code</th>
                                            <th scope="col">Nip/Nik</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Room</th>
                                            <th scope="col">Poli</th>
                                            <th scope="col">Jabatan</th>
                                            <th scope="col">Phone Number</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 14px">
                                        @php $counter = 1; @endphp
                                        @foreach ($dokters as $dokter)
                                            <tr>
                                                <td>{{ $counter }}</td>
                                                <td>{{ $dokter->kode_dokter }}</td>
                                                <td>{{ $dokter->nip }}</td>
                                                <td>{{ $dokter->nama_dokter }}</td>
                                                <td>{{ $dokter->polis->nama_poli }}</td>
                                                <td>{{ $dokter->poli }}</td>
                                                <td>{{ $dokter->jabatan }}</td>
                                                <td>{{ $dokter->no_telp }}</td>
                                                <td>{{ $dokter->email }}</td>
                                                <td>{{ $dokter->status }}</td>
                                                <td>
                                                    <button class="btn btn-success btn-edit"
                                                        data-id="{{ $dokter->id }}"
                                                        data-kode="{{ $dokter->kode_dokter }}"
                                                        data-nama="{{ $dokter->nama_dokter }}"
                                                        data-room="{{ $dokter->polis->id }}"
                                                        data-poli="{{ $dokter->poli }}"
                                                        data-nip="{{ $dokter->nip }}"
                                                        data-telp="{{ $dokter->no_telp }}"
                                                        data-email="{{ $dokter->email }}"
                                                        data-status="{{ $dokter->status }}"
                                                        data-jabatan="{{ $dokter->jabatan }}">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </button>

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
                                            @php $counter++; @endphp
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Modal Edit -->
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
                                                    <div class="form-group">
                                                        <label><b>Doctor Code</b></label>
                                                        <input class="form-control" type="text" id="kodedokter"
                                                            name="kode_dokter" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><b>NIP/NIK</b></label>
                                                        <input class="form-control" id="Nip" type="text"
                                                            name="nip" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><b>Doctor Name</b></label>
                                                        <input class="form-control" id="namadokter" type="text"
                                                            name="nama_dokter" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><b>Room</b></label>
                                                        <select name="id_poli" id="Room" class="form-control" required>
                                                            <option value="" hidden></option>
                                                            @foreach ($polis as $Poli)
                                                                <option value="{{ $Poli->id }}">
                                                                    {{ $Poli->nama_poli }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><b>Poli</b></label>
                                                        <input class="form-control" id="Poli" type="text"
                                                            name="poli" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><b>Jabatan</b></label>
                                                        <select class="form-control" name="jabatan" id="Jabatan" required>
                                                            <option value="" hidden>Pilih Jabatan</option>
                                                            <option value="dokter">Dokter</option>
                                                            <option value="bidan">Bidan</option>
                                                            <option value="perawat">Perawat</option>
                                                            <option value="pelayanan">Pelayanan</option>
                                                            <option value="sarana">Sarana</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><b>Phone Number</b></label>
                                                        <input class="form-control" id="telp" type="number"
                                                            name="no_telp" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><b>Email</b></label>
                                                        <input class="form-control" id="email" type="email"
                                                            name="email" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><b>Status</b></label>
                                                        <select class="form-control" name="status" id="EditStatus" required>
                                                            <option value="" hidden>Choose..</option>
                                                            <option value="internal">Internal</option>
                                                            <option value="external">External</option>
                                                        </select>
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
                                <!-- End Modal Edit -->
                            </div>
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
    $(function() {
        $('.btn-edit').on('click', function() {
            let id = $(this).data('id');
            let kode = $(this).data('kode');
            let nama = $(this).data('nama');
            let poli = $(this).data('poli');
            let room = $(this).data('room');
            let nip = $(this).data('nip');
            let telp = $(this).data('telp');
            let email = $(this).data('email');
            let status = $(this).data('status');
            let jabatan = $(this).data('jabatan');

            // Set nilai ke form edit
            $('#kodedokter').val(kode);
            $('#Nip').val(nip);
            $('#namadokter').val(nama);
            $('#Room').val(room);
            $('#Poli').val(poli);
            $('#telp').val(telp);
            $('#email').val(email);
            $('#EditStatus').val(status);
            $('#Jabatan').val(jabatan);

            // Update action form
            $('#editFormdokter').attr('action', '/dokter/' + id);

            // Show modal
            $('#editDokter').modal('show');
        });
    })
</script>
@endpush
