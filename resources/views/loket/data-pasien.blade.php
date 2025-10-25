<title>Data|Pasien</title>
@extends('layouts.admin')

@section('title', 'Data Pasien')

@section('content')
<div class="content" id="scroll-content">
  <div class="container-fluid">

    <div class="d-sm-flex my-3">
      <h1 class="h3 mb-0 text-gray-600">Patient Data</h1>
    </div>

    <div class="row">
      <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold" style="color: #96B6C5;">Patient Data</h6>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered" id="myTable">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Uid</th>
                    <th>No.RM</th>
                    <th>NIK</th>
                    <th>Name</th>
                    <th>Date Of Birth</th>
                    <th>Jenis Kelamin</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data_pasien as $x => $dp)
                  <tr>
                    <th>{{ $x + 1 }}</th>
                    <td>{{ $dp->uid }}</td>
                    <td>{{ $dp->no_rm }}</td>
                    <td>{{ $dp->nik }}</td>
                    <td>{{ $dp->nama }}</td>
                    <td>
                      @php
                        $tanggal = date('d-m-Y', strtotime($dp->lahir));
                        $lahir = new DateTime($dp->lahir);
                        $umur = (new DateTime())->diff($lahir)->y;
                        echo $tanggal . ' / ' . $umur . ' tahun';
                      @endphp
                    </td>
                    <td>{{ $dp->jenis_kelamin }}</td>
                    <td>{{ $dp->no_telp }}</td>
                    <td>{{ $dp->alamat }}</td>
                    <td class="text-center">
                      <a href="{{ route('data-pasien.show', $dp->id) }}" class="btn btn-outline-info">
                        <i class="ti ti-eye"></i>
                      </a>
                    </td>
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
</div>
@endsection

@push('script')
{{-- <script>
$(document).ready(function() {
    $('.btn-edit').on('click', function() {
        const id = $(this).data('id');
        $('#editFormPasien').attr('action', `/loket/data-pasien/${id}`);

        // Panggil route biasa, bukan API
        fetch(`/loket/data-pasien/${id}/edit`)
            .then(response => response.json())
            .then(res => {
                $('#Nik').val(res.nik);
                $('#Name').val(res.nama);
                $('#startDate').val(res.lahir);
                $('#Gender').val(res.jenis_kelamin);
                $('#Phone').val(res.no_telp);
                $('#Address').val(res.alamat);
            })
            .catch(err => console.error(err));
    });
});
</script> --}}
@endpush
