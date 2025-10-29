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


        $ip = $request->ip();
        $whitelistedIp = WhitelistedDevice::where('ip_address', $ip)
            ->where('status', 'approved')
            ->where('is_active', true)
            ->first();

        if (!$whitelistedIp) {

            LocationLoginLog::create([
                'user_id' => null,
                'clinic_location_id' => 1,
                'user_latitude' => $request->latitude ?? -7.983908,
                'user_longitude' => $request->longitude ?? 112.621391,
                'distance' => 0,
                'accuracy' => 0,
                'login_allowed' => false,
                'ip_address' => $ip,
                'user_agent' => $request->userAgent(),
                'failure_reason' => 'IP address tidak terdaftar',
                'attempted_at' => now('Asia/Jakarta'),
            ]);

            Log::warning('Login ditolak karena IP belum terdaftar', [
                'ip' => $ip,
                'username' => $request->username,
            ]);

            return back()->withErrors([
                'username' => 'Login ditolak! IP address ini belum terdaftar. Silakan hubungi admin.',
            ])->onlyInput('username');
        }


        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $request->session()->regenerate();


            $whitelistedIp->update(['last_used_at' => now('Asia/Jakarta')]);

            // Catat log sukses
            $this->logLogin($user, $request, true, 'Login via IP terdaftar');

            Log::info('User berhasil login via IP terdaftar', [
                'user_id' => $user->id,
                'username' => $user->username,
                'ip' => $ip,
            ]);


            if ($this->isAdmin($user)) {
                return redirect()->route('admin.dashboard')->with('success', 'Login berhasil!');
            }

            return redirect()->intended('dashboard')->with('success', 'Login berhasil!');
        }


        LocationLoginLog::create([
            'user_id' => null,
            'clinic_location_id' => 1,
            'user_latitude' => $request->latitude ?? -7.983908,
            'user_longitude' => $request->longitude ?? 112.621391,
            'distance' => 0,
            'accuracy' => 0,
            'login_allowed' => false,
            'ip_address' => $ip,
            'user_agent' => $request->userAgent(),
            'failure_reason' => 'Username atau password salah',
            'attempted_at' => now('Asia/Jakarta')
        ]);

        Log::warning('Gagal login - username/password salah', [
            'ip' => $ip,
            'username' => $request->username,
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
        // Jika device fingerprint sudah approved
        if ($request->device_fingerprint) {
            $device = WhitelistedDevice::where('device_fingerprint', $request->device_fingerprint)
                ->where('status', 'approved')
                ->where('is_active', true)
                ->first();

            if ($device) {
                Log::info('Login allowed via whitelisted device', [
                    'user_id' => $user->id,
                    'device' => $device->device_name
                ]);

                return [
                    'success' => true,
                    'method' => 'whitelist'
                ];
            }
        }

        // Jika pakai lokasi GPS (latitude & longitude dikirim)
        if ($request->has('latitude') && $request->has('longitude')) {
            return [
                'success' => true,
                'method' => 'gps'
            ];
        }

        return [
            'success' => false,
            'message' => 'Device belum terdaftar atau lokasi tidak valid. Silakan hubungi admin untuk mendaftarkan device Anda.'
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
