<?php

namespace App\Services;

use App\Models\ClinicLocation;
use App\Models\LocationLoginLog;
use Illuminate\Support\Facades\Log;

class LocationVerificationService
{
    /**
     * Verifikasi lokasi user
     */
    public function verifyLocation($latitude, $longitude, $accuracy = null)
    {
        try {
            // Validasi koordinat
            if (!$this->isValidCoordinate($latitude, $longitude)) {
                return [
                    'allowed' => false,
                    'reason' => 'Koordinat tidak valid',
                    'distance' => null,
                    'clinic' => null
                ];
            }

            // Deteksi mock location (basic)
            if ($this->isMockLocation($accuracy)) {
                return [
                    'allowed' => false,
                    'reason' => 'Mock location terdeteksi',
                    'distance' => null,
                    'clinic' => null
                ];
            }

            // Cari klinik terdekat yang aktif
            $nearestClinic = $this->findNearestClinic($latitude, $longitude);

            if (!$nearestClinic) {
                return [
                    'allowed' => false,
                    'reason' => 'Tidak ada klinik terdaftar di area ini',
                    'distance' => null,
                    'clinic' => null
                ];
            }

            $distance = $nearestClinic->calculateDistance($latitude, $longitude);
            $isWithinRadius = $distance <= $nearestClinic->radius;

            return [
                'allowed' => $isWithinRadius,
                'reason' => $isWithinRadius
                    ? 'Lokasi valid'
                    : "Anda berada " . round($distance) . " meter dari {$nearestClinic->name}. Harus dalam radius {$nearestClinic->radius}m",
                'distance' => round($distance, 2),
                'clinic' => $nearestClinic,
                'accuracy' => $accuracy
            ];
        } catch (\Exception $e) {
            Log::error('Location verification error: ' . $e->getMessage());

            return [
                'allowed' => false,
                'reason' => 'Error verifikasi lokasi',
                'distance' => null,
                'clinic' => null
            ];
        }
    }

    /**
     * Validasi koordinat
     */
    private function isValidCoordinate($latitude, $longitude)
    {
        return $latitude >= -90 && $latitude <= 90 &&
            $longitude >= -180 && $longitude <= 180;
    }

    /**
     * Deteksi mock location (basic check)
     */
    private function isMockLocation($accuracy)
    {
        // GPS accuracy < 1 meter biasanya mock location
        if ($accuracy !== null && $accuracy < 1) {
            return true;
        }

        return false;
    }

    /**
     * Cari klinik terdekat
     */
    private function findNearestClinic($latitude, $longitude)
    {
        $clinics = ClinicLocation::where('is_active', true)->get();

        if ($clinics->isEmpty()) {
            return null;
        }

        // Cari yang paling dekat
        $nearest = null;
        $minDistance = PHP_FLOAT_MAX;

        foreach ($clinics as $clinic) {
            $distance = $clinic->calculateDistance($latitude, $longitude);
            if ($distance < $minDistance) {
                $minDistance = $distance;
                $nearest = $clinic;
            }
        }

        return $nearest;
    }

    /**
     * Log aktivitas login
     */
    public function logLoginAttempt($userId, $verificationResult, $request)
    {
        LocationLoginLog::create([
            'user_id' => $userId,
            'clinic_location_id' => $verificationResult['clinic']->id ?? null,
            'user_latitude' => request()->input('latitude'),
            'user_longitude' => request()->input('longitude'),
            'distance' => $verificationResult['distance'],
            'accuracy' => $verificationResult['accuracy'] ?? null,
            'login_allowed' => $verificationResult['allowed'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'failure_reason' => $verificationResult['allowed'] ? null : $verificationResult['reason'],
            'attempted_at' => now()
        ]);
    }
}
