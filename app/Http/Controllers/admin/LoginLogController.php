<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ClinicLocation;
use App\Models\LocationLoginLog;
use App\Models\User;
use Illuminate\Http\Request;

class LoginLogController extends Controller
{
    public function index(Request $request)
    {
        $today = now()->format('Y-m-d');
        $query = LocationLoginLog::with(['user', 'clinic'])
            ->orderByRaw("DATE(attempted_at) = ? DESC", [$today])
            ->orderBy('attempted_at', 'desc');

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('attempted_at', $request->date);
        }

        // Filter by clinic
        if ($request->filled('clinic_id')) {
            $query->where('clinic_location_id', $request->clinic_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'success') {
                $query->where('login_allowed', true);
            } elseif ($request->status === 'failed') {
                $query->where('login_allowed', false);
            }
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $logs = $query->get();
        $clinics = ClinicLocation::all();
        $users = User::orderBy('name')->get();

        // Statistics
        $stats = [
            'total' => LocationLoginLog::count(),
            'today' => LocationLoginLog::today()->count(),
            'success_today' => LocationLoginLog::today()->success()->count(),
            'failed_today' => LocationLoginLog::today()->failed()->count(),
        ];

        return view('admin.login-logs.index', compact('logs', 'clinics', 'users', 'stats'));
    }
}
