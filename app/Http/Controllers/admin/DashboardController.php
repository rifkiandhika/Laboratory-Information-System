<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ClinicLocation;
use App\Models\LocationLoginLog;
use App\Models\WhitelistedDevice;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pending_devices' => WhitelistedDevice::pending()->count(),
            'approved_devices' => WhitelistedDevice::approved()->count(),
            'active_clinics' => ClinicLocation::where('is_active', true)->count(),
            'today_logins' => LocationLoginLog::today()->success()->count(),
            'today_failed' => LocationLoginLog::today()->failed()->count(),
        ];

        $recentLogs = LocationLoginLog::with(['user', 'clinic'])
            ->today()
            ->latest('attempted_at')
            ->limit(10)
            ->get();

        $pendingDevices = WhitelistedDevice::with('clinic')
            ->pending()
            ->latest('created_at')
            ->limit(5)
            ->get();

        return view('admin.dashboardmon', compact('stats', 'recentLogs', 'pendingDevices'));
    }
}
