@extends('layouts.admin')
<title>Manajemen IP Range</title>
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Manajemen IP Range</h4>
            <p class="text-muted mb-0">Kelola IP address yang diizinkan untuk registrasi device</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addIpRangeModal">
            <i class="ti ti-plus me-1"></i>Tambah IP Range
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ti ti-x me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- IP Ranges by Clinic -->
    @foreach($clinics as $clinic)
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="ti ti-building-hospital me-2"></i>{{ $clinic->name }}
                <span class="badge bg-label-info ms-2">
                    {{ $clinic->allowedIpRanges->count() }} IP Range(s)
                </span>
            </h5>
        </div>
        <div class="card-body">
            @php
                $clinicRanges = $ipRanges->where('clinic_location_id', $clinic->id);
            @endphp

            @if($clinicRanges->isEmpty())
                <div class="text-center py-3">
                    <i class="ti ti-info-circle text-muted fs-3"></i>
                    <p class="text-muted mt-2 mb-0">Belum ada IP range untuk klinik ini</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-sm" id="myTable">
                        <thead>
                            <tr>
                                <th>IP Range</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Dibuat</th>
                                <th width="100">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clinicRanges as $range)
                            <tr>
                                <td><code class="fs-6">{{ $range->ip_range }}</code></td>
                                <td>{{ $range->description ?? '-' }}</td>
                                <td>
                                    <form action="{{ route('admin.ip-ranges.toggle', $range->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-{{ $range->is_active ? 'success' : 'secondary' }}">
                                            <i class="ti ti-{{ $range->is_active ? 'check' : 'x' }}"></i>
                                            {{ $range->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </form>
                                </td>
                                <td><small>{{ $range->created_at->format('d M Y H:i') }}</small></td>
                                <td>
                                    <form action="{{ route('admin.ip-ranges.destroy', $range->id) }}" method="POST" onsubmit="return confirm('Hapus IP range ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-icon btn-danger" title="Delete">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    @endforeach

    <!-- Info Box -->
    <div class="card bg-label-info">
        <div class="card-body">
            <h6><i class="ti ti-info-circle me-2"></i>Format IP Range yang Didukung:</h6>
            <ul class="mb-0">
                <li><code>192.168.1.</code> - Prefix matching (semua IP yang dimulai dengan 192.168.1.)</li>
                <li><code>192.168.1.0/24</code> - CIDR notation (192.168.1.0 - 192.168.1.255)</li>
                <li><code>10.0.0.</code> - Private network prefix</li>
                <li><code>127.0.0.1</code> - Exact IP match</li>
            </ul>
            <hr>
            <p class="mb-0"><strong>Contoh Penggunaan:</strong></p>
            <ul class="mb-0">
                <li>Jika klinik menggunakan WiFi dengan IP range 192.168.1.x, masukkan <code>192.168.1.</code></li>
                <li>Untuk LAN dengan subnet 10.0.0.0/24, masukkan <code>10.0.0.0/24</code></li>
                <li>Untuk testing localhost, masukkan <code>127.0.0.1</code></li>
            </ul>
        </div>
    </div>
</div>

<!-- Add IP Range Modal -->
<div class="modal fade" id="addIpRangeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.ip-ranges.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah IP Range</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Klinik <span class="text-danger">*</span></label>
                        <select class="form-select" name="clinic_location_id" required>
                            <option value="">Pilih Klinik</option>
                            @foreach($clinics as $clinic)
                                <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">IP Range <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="ip_range" required placeholder="192.168.1. atau 192.168.1.0/24">
                        <small class="text-muted">Format: prefix (192.168.1.) atau CIDR (192.168.1.0/24) atau exact IP (192.168.1.100)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <input type="text" class="form-control" name="description" placeholder="Contoh: WiFi Kantor Klinik">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" checked id="isActive">
                        <label class="form-check-label" for="isActive">
                            Aktifkan IP Range ini
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection