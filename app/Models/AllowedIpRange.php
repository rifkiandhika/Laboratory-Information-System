<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllowedIpRange extends Model
{
    use HasFactory;
    protected $table = 'allowed_ip_ranges';
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function clinic()
    {
        return $this->belongsTo(ClinicLocation::class, 'clinic_location_id');
    }

    /**
     * Check if given IP matches this range
     */
    public function matchesIp($ip)
    {

        if (strpos($ip, $this->ip_range) === 0) {
            return true;
        }


        if (strpos($this->ip_range, '/') !== false) {
            return $this->ipInRange($ip, $this->ip_range);
        }

        return false;
    }

    private function ipInRange($ip, $range)
    {
        list($subnet, $bits) = explode('/', $range);
        $ip = ip2long($ip);
        $subnet = ip2long($subnet);
        $mask = -1 << (32 - $bits);
        $subnet &= $mask;
        return ($ip & $mask) == $subnet;
    }
}
