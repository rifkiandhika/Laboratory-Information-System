@extends('layouts.admin')
<title>Manajemen Device</title>
@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Manajemen Device Whitelist</h4>
            <p class="text-muted mb-0">Kelola device yang dapat login dari lokasi klinik</p>
        </div>
        <div>
            @if($pendingCount > 0)
                <span class="badge bg-warning fs-6">
                    <i class="ti ti-clock"></i> {{ $pendingCount }} Menunggu Approval
                </span>
            @endif
        </div>
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

    <!-- Filter Tabs -->
    <div class="card mb-3">
        <div class="card-body">
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ $status === 'all' ? 'active' : '' }}" href="{{ route('admin.devices.index', ['status' => 'all']) }}">
                        Semua ({{ \App\Models\WhitelistedDevice::count() }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $status === 'pending' ? 'active' : '' }}" href="{{ route('admin.devices.index', ['status' => 'pending']) }}">
                        <i class="ti ti-clock"></i> Pending ({{ $pendingCount }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $status === 'approved' ? 'active' : '' }}" href="{{ route('admin.devices.index', ['status' => 'approved']) }}">
                        <i class="ti ti-check"></i> Approved ({{ \App\Models\WhitelistedDevice::where('status', 'approved')->count() }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $status === 'rejected' ? 'active' : '' }}" href="{{ route('admin.devices.index', ['status' => 'rejected']) }}">
                        <i class="ti ti-x"></i> Rejected ({{ \App\Models\WhitelistedDevice::where('status', 'rejected')->count() }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $status === 'revoked' ? 'active' : '' }}" href="{{ route('admin.devices.index', ['status' => 'revoked']) }}">
                        <i class="ti ti-ban"></i> Revoked ({{ \App\Models\WhitelistedDevice::where('status', 'revoked')->count() }})
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Bulk Actions (untuk pending) -->
    @if($status === 'pending' && $devices->count() > 0)
    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('admin.devices.bulk-approve') }}" method="POST" id="bulkForm">
                @csrf
                <div class="d-flex align-items-center gap-2">
                    <input type="checkbox" id="selectAll" class="form-check-input">
                    <label for="selectAll" class="form-check-label">Pilih Semua</label>
                    <button type="submit" class="btn btn-success btn-sm ms-3" id="bulkApproveBtn" disabled>
                        <i class="ti ti-check me-1"></i>Approve Selected
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Devices Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            @if($status === 'pending')
                                <th width="30"><input type="checkbox" class="form-check-input" id="selectAllTable"></th>
                            @endif
                            <th>#</th>
                            <th>Device Info</th>
                            <th>Klinik</th>
                            <th>IP Address</th>
                            <th>Status</th>
                            <th>Registered By</th>
                            <th>Registered At</th>
                            <th>Last Used</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($devices as $device)
                        <tr>
                            @if($status === 'pending')
                                <td>
                                    <input type="checkbox" class="form-check-input device-checkbox" name="device_ids[]" value="{{ $device->id }}" form="bulkForm">
                                </td>
                            @endif
                            <td>{{ $devices->firstItem() + $loop->index }}</td>
                            <td>
                                <div>
                                    <i class="ti ti-{{ strpos($device->device_name, 'PC') !== false || strpos($device->device_name, 'Mac') !== false ? 'device-desktop' : 'device-mobile' }} text-primary me-1"></i>
                                    <strong>{{ $device->device_name }}</strong>
                                </div>
                                <small class="text-muted">
                                    <code>{{ substr($device->device_fingerprint, 0, 20) }}...</code>
                                </small>
                            </td>
                            <td>
                                @if($device->clinic)
                                    <span class="badge bg-label-primary">{{ $device->clinic->name }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td><code>{{ $device->ip_address }}</code></td>
                            <td>
                                @switch($device->status)
                                    @case('pending')
                                        <span class="badge bg-warning">
                                            <i class="ti ti-clock"></i> Pending
                                        </span>
                                        @break
                                    @case('approved')
                                        <span class="badge bg-success">
                                            <i class="ti ti-check"></i> Approved
                                        </span>
                                        @break
                                    @case('rejected')
                                        <span class="badge bg-danger">
                                            <i class="ti ti-x"></i> Rejected
                                        </span>
                                        @break
                                    @case('revoked')
                                        <span class="badge bg-dark">
                                            <i class="ti ti-ban"></i> Revoked
                                        </span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                @if($device->registeredBy)
                                    {{ $device->registeredBy->name }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <small>{{ $device->registered_at?->format('d M Y') }}<br>{{ $device->registered_at?->format('H:i') }}</small>
                            </td>
                            <td>
                                @if($device->last_used_at)
                                    <small>{{ $device->last_used_at->diffForHumans() }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-icon" type="button" data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if($device->status === 'pending')
                                            <li>
                                                <form action="{{ route('admin.devices.approve', $device->id) }}" method="POST">
                                                    @csrf
                                                    <button class="dropdown-item text-success">
                                                        <i class="ti ti-check me-2"></i>Approve
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $device->id }}">
                                                    <i class="ti ti-x me-2"></i>Reject
                                                </a>
                                            </li>
                                        @endif
                                        
                                        @if($device->status === 'approved')
                                            <li>
                                                <form action="{{ route('admin.devices.revoke', $device->id) }}" method="POST" onsubmit="return confirm('Cabut akses device ini?')">
                                                    @csrf
                                                    <button class="dropdown-item text-warning">
                                                        <i class="ti ti-ban me-2"></i>Revoke Access
                                                    </button>
                                                </form>
                                            </li>
                                        @endif

                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#detailModal{{ $device->id }}">
                                                <i class="ti ti-info-circle me-2"></i>Detail
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.devices.destroy', $device->id) }}" method="POST" onsubmit="return confirm('Hapus device ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item text-danger">
                                                    <i class="ti ti-trash me-2"></i>Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Reject Modal -->
                                <div class="modal fade" id="rejectModal{{ $device->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.devices.reject', $device->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Reject Device</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Tolak registrasi device: <strong>{{ $device->device_name }}</strong>?</p>
                                                    <div class="mb-3">
                                                        <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" name="rejection_reason" rows="3" required placeholder="Contoh: Device tidak terdaftar dalam sistem klinik"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Reject</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detail Modal -->
                                <div class="modal fade" id="detailModal{{ $device->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Device Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <th width="200">Device Name:</th>
                                                        <td>{{ $device->device_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Fingerprint:</th>
                                                        <td><code>{{ $device->device_fingerprint }}</code></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Klinik:</th>
                                                        <td>{{ $device->clinic?->name ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>IP Address:</th>
                                                        <td><code>{{ $device->ip_address }}</code></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Status:</th>
                                                        <td>
                                                            <span class="badge bg-{{ $device->status === 'approved' ? 'success' : ($device->status === 'pending' ? 'warning' : 'danger') }}">
                                                                {{ ucfirst($device->status) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Registered By:</th>
                                                        <td>{{ $device->registeredBy?->name ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Registered At:</th>
                                                        <td>{{ $device->registered_at?->format('d M Y H:i:s') }}</td>
                                                    </tr>
                                                    @if($device->approved_at)
                                                    <tr>
                                                        <th>Approved By:</th>
                                                        <td>{{ $device->approvedBy?->name ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Approved At:</th>
                                                        <td>{{ $device->approved_at?->format('d M Y H:i:s') }}</td>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <th>Last Used:</th>
                                                        <td>{{ $device->last_used_at ? $device->last_used_at->format('d M Y H:i:s') . ' (' . $device->last_used_at->diffForHumans() . ')' : '-' }}</td>
                                                    </tr>
                                                    @if($device->registration_notes)
                                                    <tr>
                                                        <th>Notes:</th>
                                                        <td>{{ $device->registration_notes }}</td>
                                                    </tr>
                                                    @endif
                                                    @if($device->rejection_reason)
                                                    <tr>
                                                        <th>Rejection Reason:</th>
                                                        <td class="text-danger">{{ $device->rejection_reason }}</td>
                                                    </tr>
                                                    @endif
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ $status === 'pending' ? 10 : 9 }}" class="text-center py-5">
                                <i class="ti ti-inbox fs-1 text-muted"></i>
                                <p class="text-muted mt-2">Tidak ada device dengan status {{ $status === 'all' ? '' : $status }}</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $devices->appends(['status' => $status])->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Select all checkboxes
    document.getElementById('selectAllTable')?.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.device-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
        toggleBulkButton();
    });

    // Toggle bulk approve button
    function toggleBulkButton() {
        const checkedBoxes = document.querySelectorAll('.device-checkbox:checked');
        const bulkBtn = document.getElementById('bulkApproveBtn');
        if (bulkBtn) {
            bulkBtn.disabled = checkedBoxes.length === 0;
        }
    }

    document.querySelectorAll('.device-checkbox').forEach(cb => {
        cb.addEventListener('change', toggleBulkButton);
    });
</script>
@endpush
@endsection