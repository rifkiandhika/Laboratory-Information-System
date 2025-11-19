@extends('layouts.admin')
<title>Dashboard Monitoring</title>
@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Dashboard Monitoring</h4>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-label-warning h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="ti ti-clock display-6"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0">{{ $stats['pending_devices'] }}</h3>
                            <p class="mb-0">Pending Approval</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card bg-label-success h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="ti ti-check display-6"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0">{{ $stats['approved_devices'] }}</h3>
                            <p class="mb-0">Approved Devices</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card bg-label-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="ti ti-building-hospital display-6"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0">{{ $stats['active_clinics'] }}</h3>
                            <p class="mb-0">Active Clinics</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card bg-label-info h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="ti ti-login display-6"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0">{{ $stats['today_logins'] }}</h3>
                            <p class="mb-0 small">Login Hari Ini</p>
                            @if($stats['today_failed'] > 0)
                                <small class="text-danger">{{ $stats['today_failed'] }} gagal</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Login Attempts & Pending Devices -->
    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="mb-0"><i class="ti ti-history me-2"></i>Login Attempts (Today)</h5>
                    <a href="{{ route('admin.login-logs') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>User</th>
                                    <th>Clinic</th>
                                    <th>Distance</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentLogs as $log)
                                <tr>
                                    <td><small>{{ $log->attempted_at->format('H:i:s') }}</small></td>
                                    <td>
                                        @if($log->user)
                                            <strong>{{ $log->user->name }}</strong>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($log->clinic)
                                            <span class="badge bg-label-primary">{{ $log->clinic->name }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ round($log->distance) }}m</td>
                                    <td>
                                        @if($log->login_allowed)
                                            <span class="badge bg-success"><i class="ti ti-check"></i></span>
                                        @else
                                            <span class="badge bg-danger" title="{{ $log->failure_reason }}">
                                                <i class="ti ti-x"></i>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">
                                        Belum ada login attempt hari ini
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="ti ti-device-mobile me-2"></i>Pending Device Requests</h5>
                    @if($stats['pending_devices'] > 0)
                        <span class="badge bg-warning">{{ $stats['pending_devices'] }}</span>
                    @endif
                </div>
                <div class="card-body">
                    @if($pendingDevices->isEmpty())
                        <div class="text-center py-4">
                            <i class="ti ti-check text-success" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2 mb-0">Tidak ada pending request</p>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($pendingDevices as $device)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">
                                            <i class="ti ti-{{ strpos($device->device_name, 'PC') !== false ? 'device-desktop' : 'device-mobile' }}"></i>
                                            {{ $device->device_name }}
                                        </h6>
                                        <small class="text-muted d-block">
                                            <i class="ti ti-building-hospital"></i> {{ $device->clinic->name }}
                                        </small>
                                        <small class="text-muted d-block">
                                            <i class="ti ti-network"></i> {{ $device->ip_address }}
                                        </small>
                                        <small class="text-muted">
                                            <i class="ti ti-clock"></i> {{ $device->registered_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <div class="flex-shrink-0 ms-2">
                                        <form action="{{ route('admin.devices.approve', $device->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm btn-success" title="Approve">
                                                <i class="ti ti-check"></i>
                                            </button>
                                        </form>
                                        <button class="btn btn-sm btn-danger" title="Reject" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#rejectModal{{ $device->id }}">
                                            <i class="ti ti-x"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Reject Modal -->
                            <div class="modal fade" id="rejectModal{{ $device->id }}" tabindex="-1">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.devices.reject', $device->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h6 class="modal-title">Reject Device</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Alasan Penolakan</label>
                                                    <textarea class="form-control" name="rejection_reason" rows="3" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        @if($stats['pending_devices'] > 5)
                        <div class="text-center mt-3">
                            <a href="{{ route('admin.devices.index', ['status' => 'pending']) }}" class="btn btn-sm btn-outline-primary">
                                View All Pending ({{ $stats['pending_devices'] }})
                            </a>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection