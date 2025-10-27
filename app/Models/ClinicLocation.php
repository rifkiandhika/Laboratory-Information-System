<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicLocation extends Model
{
    use HasFactory;

    protected $table = 'clinic_locations';
    protected $guarded = [];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'is_active' => 'boolean',
    ];

    /**
     * Hitung jarak menggunakan formula Haversine
     */
    public function calculateDistance($userLat, $userLon)
    {
        $earthRadius = 6371000;

        $latFrom = deg2rad($this->latitude);
        $lonFrom = deg2rad($this->longitude);
        $latTo = deg2rad($userLat);
        $lonTo = deg2rad($userLon);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos($latFrom) * cos($latTo) *
            sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * Check apakah koordinat dalam radius
     */
    public function isWithinRadius($userLat, $userLon)
    {
        $distance = $this->calculateDistance($userLat, $userLon);
        return $distance <= $this->radius;
    }
}
