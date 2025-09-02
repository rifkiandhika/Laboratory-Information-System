@extends('layouts.admin')
<title>MCU</title>
@section('content')
<section>
    <div class="content" id="scroll-content">
        <div class="container-fluid">
            <div class="d-sm-flex mb-3">
                <h1 class="h3 mb-0 text-gray-600">MCU Package Data</h1>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="d-flex justify-content-between">
                                @if (session('error'))
                                    <p class="alert alert-danger">{{ session('error') }}</p>
                                @endif
                                
                                <a class="btn btn-outline-primary" href="{{ route('mcu.create') }}">+ Add MCU Package</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered table-responsive w-100 d-block d-md-table" id="myTable">
                                <thead style="font-size: 12px;">
                                    <tr>
                                        <th>No</th>
                                        <th>Package Name</th>
                                        <th>Description</th>
                                        <th>Normal Price</th>
                                        <th>Discount (%)</th>
                                        <th>Final Price</th>
                                        <th>Pemeriksaan</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 14px">
                                    @php $counter = 1; @endphp
                                    @foreach ($mcuPackages as $package)
                                        <tr>
                                            <td>{{ $counter }}</td>
                                            <td>{{ $package->nama_paket }}</td>
                                            <td>{{ $package->deskripsi ?? '-' }}</td>
                                            <td>Rp.{{ number_format($package->harga_normal, 0, ',', '.') }}</td>
                                            <td>{{ $package->diskon }}%</td>
                                            <td>Rp.{{ number_format($package->harga_final, 0, ',', '.') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info" onclick="showPemeriksaan({{ $package->id }})">
                                                    View ({{ $package->detailDepartments->count() }})
                                                </button>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $package->status == 'active' ? 'success' : 'danger' }}">
                                                    {{ $package->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <a class="btn btn-success btn-sm" href="{{ route('mcu.edit', $package->id) }}">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                                <form id="delete-form-{{ $package->id }}" action="{{ route('mcu.destroy', $package->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $package->id }})">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                        @php $counter++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal untuk menampilkan detail pemeriksaan -->
<div class="modal fade" id="pemeriksaanModal" tabindex="-1" aria-labelledby="pemeriksaanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pemeriksaanModalLabel">Detail Pemeriksaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="pemeriksaanContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
function showPemeriksaan(packageId) {
    fetch(`/package-details/${packageId}`)
        .then(response => response.json())
        .then(data => {
            let content = '<div class="table-responsive"><table class="table table-sm">';
            content += '<thead><tr><th>Department</th><th>Pemeriksaan</th><th>Harga</th></tr></thead><tbody>';
            
            data.pemeriksaan.forEach(item => {
                content += `<tr>
                    <td>${item.department}</td>
                    <td>${item.nama_pemeriksaan}</td>
                    <td>Rp.${item.harga.toLocaleString('id-ID')}</td>
                </tr>`;
            });
            
            content += '</tbody></table></div>';
            content += `<div class="mt-3">
                <strong>Total Normal: Rp.${data.harga_normal.toLocaleString('id-ID')}</strong><br>
                <strong>Diskon: ${data.diskon}%</strong><br>
                <strong>Harga Final: Rp.${data.harga_final.toLocaleString('id-ID')}</strong>
            </div>`;
            
            document.getElementById('pemeriksaanContent').innerHTML = content;
            new bootstrap.Modal(document.getElementById('pemeriksaanModal')).show();
        })
        .catch(error => console.error('Error:', error));
}

function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endpush