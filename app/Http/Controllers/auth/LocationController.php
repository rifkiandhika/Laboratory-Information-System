<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\AllowedIpRange;
use App\Models\ClinicLocation;
use App\Models\LocationLoginLog;
use App\Models\User;
use App\Models\WhitelistedDevice;
use App\Notifications\DeviceRegistrationRequested;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    /**
     * Cek apakah device sudah whitelisted dan approved
     */
    public function checkDevice(Request $request)
    {
        try {
            $deviceFingerprint = $request->device_fingerprint;

            if (!$deviceFingerprint) {
                return response()->json([
                    'whitelisted' => false,
                    'status' => 'no_fingerprint',
                    'message' => 'Device fingerprint tidak ditemukan'
                ]);
            }

            $device = WhitelistedDevice::with('clinic')
                ->where('device_fingerprint', $deviceFingerprint)
                ->where('status', 'approved')
                ->where('is_active', true)
                ->first();

            if ($device && $device->clinic) {
                // Update last used
                $device->update(['last_used_at' => now()]);

                Log::info('Device whitelisted found', [
                    'fingerprint' => substr($deviceFingerprint, 0, 10) . '...',
                    'device_name' => $device->device_name,
                    'clinic' => $device->clinic->name
                ]);

                return response()->json([
                    'whitelisted' => true,
                    'status' => 'approved',
                    'clinic_location' => [
                        'id' => $device->clinic->id,
                        'name' => $device->clinic->name,
                        'latitude' => $device->clinic->latitude,
                        'longitude' => $device->clinic->longitude
                    ]
                ]);
            }

            // Cek apakah pending approval
            $pendingDevice = WhitelistedDevice::where('device_fingerprint', $deviceFingerprint)
                ->where('status', 'pending')
                ->first();

            if ($pendingDevice) {
                return response()->json([
                    'whitelisted' => false,
                    'status' => 'pending',
                    'message' => 'Permintaan registrasi device Anda sedang menunggu approval admin.'
                ]);
            }

            // Cek apakah pernah ditolak
            $rejectedDevice = WhitelistedDevice::where('device_fingerprint', $deviceFingerprint)
                ->where('status', 'rejected')
                ->first();

            if ($rejectedDevice) {
                return response()->json([
                    'whitelisted' => false,
                    'status' => 'rejected',
                    'message' => 'Device ini pernah ditolak. Alasan: ' . ($rejectedDevice->rejection_reason ?? 'Tidak disebutkan')
                ]);
            }

            return response()->json([
                'whitelisted' => false,
                'status' => 'not_registered'
            ]);
        } catch (\Exception $e) {
            Log::error('Error checking device', [
                'error' => $e->getMessage(),
                'fingerprint' => $request->device_fingerprint ?? 'N/A'
            ]);

            return response()->json([
                'whitelisted' => false,
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengecek device'
            ], 500);
        }
    }

    /**
     * OPSI A + B: Registrasi device dengan validasi IP dan approval admin
     */
    public function registerDevice(Request $request)
    {
        try {
            $deviceFingerprint = $request->device_fingerprint;
            $userIP = $request->ip();

            if (!$deviceFingerprint) {
                return response()->json([
                    'success' => false,
                    'message' => 'Device fingerprint tidak ditemukan'
                ], 400);
            }

            Log::info('Device registration attempt', [
                'fingerprint' => substr($deviceFingerprint, 0, 10) . '...',
                'ip' => $userIP
            ]);

            // LAYER 1: CEK IP RANGE (OPSI A)
            $allowedClinic = $this->checkIpRange($userIP);

            if (!$allowedClinic) {
                Log::warning('Device registration blocked - IP not allowed', [
                    'ip' => $userIP,
                    'fingerprint' => substr($deviceFingerprint, 0, 10) . '...'
                ]);

                return response()->json([
                    'success' => false,
                    'message' => '❌ Registrasi device hanya dapat dilakukan dari network klinik yang terdaftar. IP Anda: ' . $userIP . '. Hubungi admin untuk registrasi manual.',
                    'error_code' => 'IP_NOT_ALLOWED'
                ], 403);
            }

            // LAYER 2: CEK APAKAH DEVICE SUDAH TERDAFTAR
            $existingDevice = WhitelistedDevice::where('device_fingerprint', $deviceFingerprint)->first();

            if ($existingDevice) {
                if ($existingDevice->status === 'pending') {
                    return response()->json([
                        'success' => false,
                        'message' => '⏳ Device ini sudah terdaftar dan menunggu approval admin.',
                        'status' => 'pending'
                    ]);
                }

                if ($existingDevice->status === 'approved') {
                    $existingDevice->update([
                        'is_active' => true,
                        'last_used_at' => now()
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Device ini sudah approved sebelumnya.',
                        'clinic_location' => [
                            'id' => $existingDevice->clinic->id,
                            'name' => $existingDevice->clinic->name,
                            'latitude' => $existingDevice->clinic->latitude,
                            'longitude' => $existingDevice->clinic->longitude
                        ]
                    ]);
                }

                if ($existingDevice->status === 'rejected') {
                    return response()->json([
                        'success' => false,
                        'message' => '❌ Device ini pernah ditolak oleh admin. Alasan: ' . ($existingDevice->rejection_reason ?? 'Tidak disebutkan'),
                        'status' => 'rejected'
                    ], 403);
                }
            }

            // LAYER 3: BUAT REGISTRASI BARU (STATUS PENDING - OPSI B)
            $device = WhitelistedDevice::create([
                'device_fingerprint' => $deviceFingerprint,
                'device_name' => $this->getDeviceName($request),
                'clinic_location_id' => $allowedClinic->id,
                'ip_address' => $userIP,
                'status' => 'pending',
                'is_active' => false,
                'registered_at' => now(),
                'registered_by' => Auth::id(),
                'registration_notes' => 'Auto-registration from IP: ' . $userIP
            ]);

            Log::info('Device registered successfully', [
                'device_id' => $device->id,
                'device_name' => $device->device_name,
                'clinic' => $allowedClinic->name,
                'ip' => $userIP
            ]);

            // Kirim notifikasi ke admin
            $this->notifyAdmins($device);

            return response()->json([
                'success' => false,
                'message' => '📝 Permintaan registrasi device berhasil dikirim. Menunggu approval dari admin. Anda akan mendapat notifikasi saat device disetujui.',
                'status' => 'pending',
                'device_id' => $device->id
            ]);
        } catch (\Exception $e) {
            Log::error('Error registering device', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mendaftarkan device: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verifikasi lokasi user dengan multi-clinic support
     */
    public function verifyLocation(Request $request)
    {
        try {
            $userLat = $request->latitude;
            $userLon = $request->longitude;
            $gpsAccuracy = $request->accuracy ?? 100;
            $deviceFingerprint = $request->device_fingerprint;
            $userIP = $request->ip();

            Log::info('Location verification attempt', [
                'latitude' => $userLat,
                'longitude' => $userLon,
                'accuracy' => $gpsAccuracy,
                'ip' => $userIP
            ]);

            // Validasi input
            if (!$userLat || !$userLon) {
                return response()->json([
                    'success' => false,
                    'message' => 'Koordinat lokasi tidak valid'
                ], 400);
            }

            // Get semua klinik aktif
            $clinics = ClinicLocation::where('is_active', true)->get();

            if ($clinics->isEmpty()) {
                $this->logLoginAttempt(null, $userLat, $userLon, 0, $gpsAccuracy, false, 'Tidak ada klinik aktif', $userIP, $request);

                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada klinik aktif dalam sistem.'
                ], 500);
            }

            // Cari klinik terdekat
            $nearestClinic = null;
            $minDistance = PHP_FLOAT_MAX;

            foreach ($clinics as $clinic) {
                $distance = $this->calculateDistance(
                    $userLat,
                    $userLon,
                    $clinic->latitude,
                    $clinic->longitude
                );

                if ($distance < $minDistance) {
                    $minDistance = $distance;
                    $nearestClinic = $clinic;
                }
            }

            // Tentukan toleransi berdasarkan akurasi GPS
            if ($gpsAccuracy > 200) {
                // Desktop/Laptop dengan WiFi GPS - beri toleransi besar
                $toleranceRadius = $nearestClinic->radius + 1000;
            } else {
                // Mobile dengan GPS akurat
                $toleranceRadius = $nearestClinic->radius + $gpsAccuracy;
            }

            // Cek apakah dalam radius
            $loginAllowed = $minDistance <= $toleranceRadius;
            $failureReason = null;

            if (!$loginAllowed) {
                $failureReason = "Jarak " . round($minDistance) . "m dari {$nearestClinic->name}. Maksimal: {$nearestClinic->radius}m (toleransi GPS: ±" . round($gpsAccuracy) . "m)";
            }

            // Log attempt
            $this->logLoginAttempt(
                null,
                $userLat,
                $userLon,
                $minDistance,
                $gpsAccuracy,
                $loginAllowed,
                $failureReason,
                $userIP,
                $request,
                $nearestClinic->id
            );

            if ($loginAllowed) {
                Log::info('Location verified successfully', [
                    'clinic' => $nearestClinic->name,
                    'distance' => round($minDistance),
                    'accuracy' => $gpsAccuracy
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Lokasi valid',
                    'data' => [
                        'clinic_id' => $nearestClinic->id,
                        'clinic_name' => $nearestClinic->name,
                        'distance' => $minDistance,
                        'accuracy' => $gpsAccuracy,
                        'max_radius' => $nearestClinic->radius
                    ]
                ]);
            }

            Log::warning('Location verification failed', [
                'clinic' => $nearestClinic->name,
                'distance' => round($minDistance),
                'max_radius' => $nearestClinic->radius,
                'reason' => $failureReason
            ]);

            return response()->json([
                'success' => false,
                'message' => $failureReason,
                'data' => [
                    'clinic_id' => $nearestClinic->id,
                    'clinic_name' => $nearestClinic->name,
                    'distance' => $minDistance,
                    'accuracy' => $gpsAccuracy,
                    'max_radius' => $nearestClinic->radius
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error verifying location', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memverifikasi lokasi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * CEK IP RANGE (OPSI A)
     */
    private function checkIpRange($ip)
    {
        try {
            $allowedRanges = AllowedIpRange::where('is_active', true)
                ->with('clinic')
                ->get();

            foreach ($allowedRanges as $range) {
                if ($range->matchesIp($ip)) {
                    Log::info('IP range matched', [
                        'ip' => $ip,
                        'range' => $range->ip_range,
                        'clinic' => $range->clinic->name
                    ]);
                    return $range->clinic;
                }
            }

            Log::warning('No IP range matched', [
                'ip' => $ip,
                'total_ranges' => $allowedRanges->count()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Error checking IP range', [
                'error' => $e->getMessage(),
                'ip' => $ip
            ]);
            return null;
        }
    }

    /**
     * Hitung jarak menggunakan Haversine Formula
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meter

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * Get device name from user agent
     */
    private function getDeviceName($request)
    {
        $userAgent = $request->userAgent();

        if (strpos($userAgent, 'Windows') !== false) return 'Windows PC';
        if (strpos($userAgent, 'Macintosh') !== false) return 'Mac';
        if (strpos($userAgent, 'Linux') !== false) return 'Linux PC';
        if (strpos($userAgent, 'Android') !== false) return 'Android';
        if (strpos($userAgent, 'iPhone') !== false) return 'iPhone';
        if (strpos($userAgent, 'iPad') !== false) return 'iPad';

        return 'Unknown Device';
    }

    /**
     * Log login attempt
     */
    private function logLoginAttempt($userId, $lat, $lon, $distance, $accuracy, $allowed, $failureReason, $ip, $request, $clinicId = null)
    {
        try {
            LocationLoginLog::create([
                'user_id' => $userId,
                'clinic_location_id' => $clinicId,
                'user_latitude' => $lat,
                'user_longitude' => $lon,
                'distance' => $distance,
                'accuracy' => $accuracy,
                'login_allowed' => $allowed,
                'ip_address' => $ip,
                'user_agent' => $request->userAgent(),
                'failure_reason' => $failureReason,
                'attempted_at' => now()
            ]);

            Log::info('Login attempt logged', [
                'user_id' => $userId,
                'clinic_id' => $clinicId,
                'distance' => round($distance),
                'allowed' => $allowed
            ]);
        } catch (\Exception $e) {
            Log::error('Error logging login attempt', [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Notify admins about new device registration
     */
    private function notifyAdmins($device)
    {
        try {
            $admins = User::where(function ($query) {
                $query->where('is_admin', true)
                    ->orWhere('role', 'admin');
            })->get();

            if ($admins->isEmpty()) {
                Log::warning('No admins found to notify');
                return;
            }

            foreach ($admins as $admin) {
                $admin->notify(new DeviceRegistrationRequested($device));
            }

            Log::info('Admins notified about device registration', [
                'device_id' => $device->id,
                'admins_count' => $admins->count()
            ]);
        } catch (\Exception $e) {
            // Silent fail - jangan sampai error notifikasi mengganggu flow registrasi
            Log::error('Failed to notify admins', [
                'error' => $e->getMessage(),
                'device_id' => $device->id ?? null
            ]);
        }
    }
}
