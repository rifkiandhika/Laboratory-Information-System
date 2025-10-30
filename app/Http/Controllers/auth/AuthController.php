<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LocationLoginLog;
use App\Models\WhitelistedDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Show login page
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('login.index');
    }

    /**
     * Process login
     */
    public function proses(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $request->session()->regenerate();


            $validationResult = $this->validateLocationOrDevice($request, $user);

            if (!$validationResult['success']) {
                $this->logLogin($user, $request, false, $validationResult['message']);
                Auth::logout();

                return back()->withErrors([
                    'username' => $validationResult['message']
                ])->onlyInput('username');
            }


            if ($request->device_fingerprint) {
                WhitelistedDevice::where('device_fingerprint', $request->device_fingerprint)
                    ->update(['last_used_at' => now('Asia/Jakarta')]);
            }


            $this->logLogin($user, $request, true);

            Log::info('User logged in successfully', [
                'user_id' => $user->id,
                'username' => $user->username,
                'location_method' => $validationResult['method'] ?? 'unknown'
            ]);

            return $this->isAdmin($user)
                ? redirect()->route('admin.dashboard')->with('success', 'Login berhasil!')
                : redirect()->intended('dashboard')->with('success', 'Login berhasil!');
        }


        Log::warning('Failed login attempt', [
            'username' => $request->username,
            'ip' => $request->ip(),
        ]);

        LocationLoginLog::create([
            'user_id' => null,
            'clinic_location_id' => 1,
            'user_latitude' => $request->latitude ?? 0,
            'user_longitude' => $request->longitude ?? 0,
            'distance' => 0,
            'accuracy' => 0,
            'login_allowed' => false,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'failure_reason' => 'Username atau password salah',
            'attempted_at' => now('Asia/Jakarta')
        ]);

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }


    /**
     * Validasi lokasi atau device whitelist untuk user biasa
     */
    private function validateLocationOrDevice(Request $request, $user)
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent();


        $device = WhitelistedDevice::where('ip_address', $ip)->first();

        if (!$device) {

            WhitelistedDevice::create([
                'ip_address' => $ip,
                'device_name' => gethostbyaddr($ip) ?: 'Unknown Device',
                'user_agent' => $userAgent,
                'status' => 'pending',
                'is_active' => true,
            ]);

            return [
                'success' => false,
                'message' => 'Device baru terdeteksi dan sedang menunggu approval admin.'
            ];
        }

        if ($device->status !== 'approved') {
            return [
                'success' => false,
                'message' => 'Device Anda masih menunggu approval admin.'
            ];
        }


        return [
            'success' => true,
            'method' => 'whitelist'
        ];
    }


    /**
     * Helper untuk mencatat log login
     */
    private function logLogin($user, Request $request, $allowed = true, $reason = null)
    {
        LocationLoginLog::create([
            'user_id' => $user->id,
            'clinic_location_id' => 1, // isi sesuai kebutuhan
            'user_latitude' => $request->latitude ?? 0,
            'user_longitude' => $request->longitude ?? 0,
            'distance' => 0,
            'accuracy' => 0,
            'login_allowed' => $allowed,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'failure_reason' => $reason,
            'attempted_at' => now('Asia/Jakarta')
        ]);
    }

    /**
     * Check if user is superadmin
     */
    private function isSuperAdmin($user)
    {
        if (isset($user->is_superadmin) && $user->is_superadmin) return true;
        if (isset($user->role) && strtolower($user->role) === 'superadmin') return true;
        if (method_exists($user, 'hasRole') && $user->hasRole('superadmin')) return true;

        return false;
    }

    /**
     * Check if user is admin
     */
    private function isAdmin($user)
    {
        if (isset($user->is_admin) && $user->is_admin) return true;
        if (isset($user->role) && in_array(strtolower($user->role), ['superadmin'])) return true;
        if (method_exists($user, 'hasRole') && ($user->hasRole('superadmin'))) return true;

        return false;
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $user = Auth::user();

        Log::info('User logged out', [
            'user_id' => $user->id ?? null,
            'username' => $user->username ?? null,
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.index')->with('success', 'Logout berhasil!');
    }
}
