<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ClinicLocation;
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
        // Validasi basic
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        // Attempt login
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $request->session()->regenerate();

            // SEMUA USER (termasuk superadmin) harus validasi device
            $validationResult = $this->validateLocationOrDevice($request, $user);

            if (!$validationResult['success']) {
                // Catat log gagal
                $this->logLogin($user, $request, false, $validationResult['message']);

                Log::warning('Login blocked - device/location not whitelisted', [
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'is_superadmin' => $this->isSuperAdmin($user),
                    'reason' => $validationResult['message']
                ]);

                Auth::logout();
                return back()->withErrors([
                    'username' => $validationResult['message']
                ])->onlyInput('username');
            }

            // Update last_used_at untuk whitelisted device
            if ($request->device_fingerprint) {
                WhitelistedDevice::where('device_fingerprint', $request->device_fingerprint)
                    ->update(['last_used_at' => now('Asia/Jakarta')]);
            }

            // Catat log login sukses
            $this->logLogin($user, $request, true);

            Log::info('User logged in successfully', [
                'user_id' => $user->id,
                'username' => $user->username,
                'is_superadmin' => $this->isSuperAdmin($user),
                'location_method' => $validationResult['method'] ?? 'unknown'
            ]);

            // Redirect berdasarkan role
            if ($this->isAdmin($user) || $this->isSuperAdmin($user)) {
                return redirect()->route('admin.dashboard')->with('success', 'Login berhasil!');
            }

            return redirect()->intended('dashboard')->with('success', 'Login berhasil!');
        }

        // Login gagal - credentials salah
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
     * Check device status
     */
    public function checkDevice(Request $request)
    {
        $deviceFingerprint = $request->device_fingerprint;
        $realIp = $this->getRealIpAddress($request);

        Log::info('Checking device status', [
            'fingerprint' => $deviceFingerprint,
            'ip' => $realIp
        ]);

        // Cek apakah device sudah terdaftar
        $device = WhitelistedDevice::where('device_fingerprint', $deviceFingerprint)->first();

        if ($device) {
            // Device SUDAH pernah didaftarkan
            return response()->json([
                'whitelisted' => $device->status === 'approved',
                'status' => $device->status,
                'message' => $this->getDeviceStatusMessage($device->status),
                'clinic_location' => $device->clinicLocation,
                'device_name' => $device->device_name,
                'registered_at' => $device->registered_at,
                'ip_address' => $device->ip_address
            ]);
        }

        // Device BELUM terdaftar sama sekali
        return response()->json([
            'whitelisted' => false,
            'status' => 'not_registered',
            'message' => 'Device belum terdaftar di sistem',
            'current_ip' => $realIp
        ]);
    }

    /**
     * Register new device
     */
    public function registerDevice(Request $request)
    {
        $deviceFingerprint = $request->device_fingerprint;
        $realIp = $this->getRealIpAddress($request);

        Log::info('Device registration attempt', [
            'fingerprint' => $deviceFingerprint,
            'ip' => $realIp
        ]);

        // ===== CRITICAL: CEK DEVICE SUDAH ADA ATAU BELUM =====
        $existingDevice = WhitelistedDevice::where('device_fingerprint', $deviceFingerprint)->first();

        if ($existingDevice) {
            // Device SUDAH pernah didaftarkan
            Log::info('Device registration blocked - already exists', [
                'device_id' => $existingDevice->id,
                'status' => $existingDevice->status,
                'fingerprint' => $deviceFingerprint
            ]);

            $messages = [
                'pending' => 'Device ini sudah didaftarkan dan sedang menunggu approval dari admin.',
                'approved' => 'Device ini sudah terdaftar dan disetujui.',
                'rejected' => 'Device ini ditolak oleh admin. Silakan hubungi admin untuk informasi lebih lanjut.'
            ];

            return response()->json([
                'success' => false,
                'already_registered' => true,
                'status' => $existingDevice->status,
                'message' => $messages[$existingDevice->status] ?? 'Device sudah terdaftar.',
                'device_id' => $existingDevice->id,
                'clinic_location' => $existingDevice->clinicLocation,
                'registered_at' => $existingDevice->registered_at
            ]);
        }

        // ===== CEK IP TERDAFTAR DI CLINIC LOCATION =====
        $clinicLocation = ClinicLocation::where('ip_address', $realIp)
            ->where('is_active', true)
            ->first();

        if (!$clinicLocation) {
            Log::warning('Device registration failed - IP not allowed', [
                'fingerprint' => $deviceFingerprint,
                'ip' => $realIp
            ]);

            return response()->json([
                'success' => false,
                'already_registered' => false,
                'error_code' => 'IP_NOT_ALLOWED',
                'message' => 'IP Address (' . $realIp . ') tidak terdaftar di sistem. Silakan hubungi admin untuk mendaftarkan IP ini terlebih dahulu.',
                'current_ip' => $realIp
            ]);
        }

        // ===== CREATE DEVICE BARU =====
        try {
            $device = WhitelistedDevice::create([
                'clinic_location_id' => $clinicLocation->id,
                'device_fingerprint' => $deviceFingerprint,
                'device_name' => $this->getDeviceName($request),
                'ip_address' => $realIp,
                'status' => 'pending',
                'is_active' => true,
                'registered_at' => now('Asia/Jakarta'),
                'last_used_at' => null
            ]);

            Log::info('Device registered successfully', [
                'device_id' => $device->id,
                'fingerprint' => $deviceFingerprint,
                'clinic' => $clinicLocation->name,
                'ip' => $realIp
            ]);

            return response()->json([
                'success' => true,
                'already_registered' => false,
                'status' => 'pending',
                'message' => 'Device berhasil didaftarkan untuk ' . $clinicLocation->name . '. Menunggu approval dari admin.',
                'device_id' => $device->id,
                'clinic_location' => $clinicLocation,
                'current_ip' => $realIp
            ]);
        } catch (\Exception $e) {
            Log::error('Device registration error', [
                'error' => $e->getMessage(),
                'fingerprint' => $deviceFingerprint,
                'ip' => $realIp
            ]);

            return response()->json([
                'success' => false,
                'already_registered' => false,
                'error_code' => 'REGISTRATION_ERROR',
                'message' => 'Terjadi kesalahan saat mendaftarkan device. Silakan coba lagi atau hubungi admin.',
            ], 500);
        }
    }

    /**
     * Validasi lokasi atau device whitelist
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
            'message' => 'Device belum terdaftar atau belum disetujui. Silakan hubungi admin untuk mendaftarkan atau approve device Anda.'
        ];
    }

    /**
     * Helper untuk mencatat log login
     */
    private function logLogin($user, Request $request, $allowed = true, $reason = null)
    {
        LocationLoginLog::create([
            'user_id' => $user->id,
            'clinic_location_id' => 1,
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
     * Get device status message
     */
    private function getDeviceStatusMessage($status)
    {
        $messages = [
            'pending' => 'Device menunggu approval dari admin',
            'approved' => 'Device sudah disetujui',
            'rejected' => 'Device ditolak oleh admin',
        ];

        return $messages[$status] ?? 'Status tidak diketahui';
    }

    /**
     * Get device name from user agent
     */
    private function getDeviceName(Request $request)
    {
        $userAgent = $request->userAgent();

        // Detect device type
        if (preg_match('/mobile|android|iphone|ipad|ipod/i', $userAgent)) {
            if (preg_match('/android/i', $userAgent)) {
                return 'Android Mobile Device';
            } elseif (preg_match('/iphone/i', $userAgent)) {
                return 'iPhone';
            } elseif (preg_match('/ipad/i', $userAgent)) {
                return 'iPad';
            }
            return 'Mobile Device';
        }

        // Detect browser
        if (preg_match('/chrome/i', $userAgent)) {
            return 'Desktop - Chrome Browser';
        } elseif (preg_match('/firefox/i', $userAgent)) {
            return 'Desktop - Firefox Browser';
        } elseif (preg_match('/safari/i', $userAgent)) {
            return 'Desktop - Safari Browser';
        } elseif (preg_match('/edge/i', $userAgent)) {
            return 'Desktop - Edge Browser';
        }

        return 'Desktop/Laptop';
    }

    /**
     * Get real IP address considering proxies
     */
    private function getRealIpAddress(Request $request)
    {
        $headers = [
            'HTTP_CF_CONNECTING_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_REAL_IP',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'HTTP_CLIENT_IP',
            'REMOTE_ADDR'
        ];

        foreach ($headers as $header) {
            if ($request->server($header)) {
                $ip = $request->server($header);

                if (strpos($ip, ',') !== false) {
                    $ips = explode(',', $ip);
                    $ip = trim($ips[0]);
                }

                return $ip;
            }
        }

        return $request->ip();
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
