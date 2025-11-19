<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhitelistedDevice extends Model
{
    use HasFactory;
    protected $table = 'whitelisted_devices';
    protected $guarded = [];
    protected $casts = [
        'is_active' => 'boolean',
        'registered_at' => 'datetime',
        'approved_at' => 'datetime',
        'last_used_at' => 'datetime'
    ];

    public function clinic()
    {
        return $this->belongsTo(ClinicLocation::class, 'clinic_location_id');
    }

    public function registeredBy()
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved')->where('is_active', true);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
