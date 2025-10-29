@extends('layouts.admin')
<title>Login History</title>
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Login History & Logs</h4>
            <p class="text-muted mb-0">Monitor semua attempt login ke sistem</p>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-label-primary">
                <div class="card-body py-3">
                    <h6 class="mb-1">Total Logs</h6>
                    <h4 class="mb-0">{{ number_format($stats['total']) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-label-info">
                <div class="card-body py-3">
                    <h6 class="mb-1">Login Hari Ini</h6>
                    <h4 class="mb-0">{{ $stats['today'] }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-label-success">
                <div class="card-body py-3">
                    <h6 class="mb-1">Berhasil Hari Ini</h6>
                    <h4 class="mb-0">{{ $stats['success_today'] }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-label-danger">
                <div class="card-body py-3">
                    <h6 class="mb-1">Gagal Hari Ini</h6>
                    <h4 class="mb-0">{{ $stats['failed_today'] }}</h4>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filter -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" class="form-control" name="date" value="{{ request('date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Klinik</label>
                    <select class="form-select" name="clinic_id">
                        <option value="">Semua Klinik</option>
                        @foreach($clinics as $clinic)
                            <option value="{{ $clinic->id }}" {{ request('clinic_id') == $clinic->id ? 'selected' : '' }}>
                                {{ $clinic->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="">Semua</option>
                        <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-search me-1"></i>Filter
                        </button>
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <a href="{{ route('admin.login-logs') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-refresh me-1"></i>Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Logs Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="myTable">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>User</th>
                            <th>Clinic</th>
                            <th>Location</th>
                            <th>Distance</th>
                            <th>Accuracy</th>
                            <th>IP Address</th>
                            <th>Status</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td>
                                <small>{{ $log->attempted_at->format('d M Y') }}</small><br>
                                <strong>{{ $log->attempted_at->format('H:i:s') }}</strong>
                            </td>
                            <td>
                                @if($log->user)
                                    <strong>{{ $log->user->name }}</strong><br>
                                    <small class="text-muted">{{ $log->user->username ?? $log->user->email }}</small>
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
                            <td>
                                <small>
                                    <i class="ti ti-map-pin text-primary"></i>
                                    {{ number_format($log->user_latitude, 6) }}, {{ number_format($log->user_longitude, 6) }}
                                </small>
                            </td>
                            <td>
                                <span class="badge bg-label-{{ $log->distance <= 500 ? 'success' : 'warning' }}">
                                    {{ round($log->distance) }}m
                                </span>
                            </td>
                            <td>
                                @if($log->accuracy)
                                    <small>±{{ round($log->accuracy) }}m</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td><code>{{ $log->ip_address }}</code></td>
                            <td>
                                @if($log->login_allowed)
                                    <span class="badge bg-success">
                                        <i class="ti ti-check"></i> Success
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="ti ti-x"></i> Failed
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($log->failure_reason)
                                    <small class="text-danger" title="{{ $log->failure_reason }}">
                                        {{ Str::limit($log->failure_reason, 50) }}
                                    </small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <i class="ti ti-inbox text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-2 mb-0">Tidak ada data log</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $logs->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection