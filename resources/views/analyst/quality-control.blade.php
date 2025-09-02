@extends('layouts.admin')
@section('title', 'Quality Control')
@section('content')

<link rel="stylesheet" href="{{ asset('css/timeline.css') }}">

<div class="content" id="scroll-content">
    <div class="container-fluid">
        <div class="d-sm-flex mt-3">
            <h1 class="h3 mb-0 text-gray-600">Quality Control</h1>
        </div>

        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="py-3 d-flex flex-row align-items-center justify-content-between">
                        <!-- Tombol buka modal -->
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#qcModal">
                            <i class='bx bx-plus'></i> + Add QC
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped" id="qcTable">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Department</th>
                                    <th scope="col" class="col-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departments as $x => $item)
                                    <tr>
                                        <td>{{ $x + 1 }}</td>
                                        <td>{{ $item->nama_department }}</td>
                                        <td>
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('Qc.edit', $item->id) }}" class="btn btn-outline-info">
                                                <i class="ti ti-pencil"></i>
                                            </a>

                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="ti ti-trash"></i>
                                            </button>
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

<!-- Modal -->
<div class="modal fade" id="qcModal" tabindex="-1" aria-labelledby="qcModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="qcForm">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="qcModalLabel">Add Quality Control</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="department_id" class="form-label">Select Department</label>
                    <select name="department_id" id="department_id" class="form-select" required>
                        <option value="">-- Choose Department --</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->nama_department }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="errorMsg" class="text-danger small"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
  </div>
</div>

@endsection

@push('script')
<script>
$(document).ready(function() {

    $('#qcForm').on('submit', function(e){
        e.preventDefault();

        $.ajax({
            url: "{{ route('Qc.store') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(response){
                if(response.success){
                    // Tambahkan baris baru ke tabel
                    let rowCount = $('#qcTable tbody tr').length + 1;
                    $('#qcTable tbody').append(`
                        <tr>
                            <td>${rowCount}</td>
                            <td>${response.data.department_name}</td>
                            <td>
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    `);

                    // Reset form & tutup modal
                    $('#qcForm')[0].reset();
                    $('#qcModal').modal('hide');
                }
            },
            error: function(xhr){
                let errors = xhr.responseJSON.errors;
                let errorMsg = '';
                if(errors){
                    Object.keys(errors).forEach(key => {
                        errorMsg += errors[key][0] + "<br>";
                    });
                }
                $('#errorMsg').html(errorMsg);
            }
        });
    });

});
</script>
@endpush
