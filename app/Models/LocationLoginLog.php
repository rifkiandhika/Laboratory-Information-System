<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class LocationLoginLog extends Model
{
    use HasFactory;

    protected $table = 'location_login_logs';
    protected $guarded = [];
    protected $casts = [
        'attempted_at' => 'datetime', // ✅ agar bisa pakai ->format()
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clinicLocation()
    {
        return $this->belongsTo(ClinicLocation::class);
    }

    public function clinic()
    {
        return $this->belongsTo(ClinicLocation::class, 'clinic_location_id');
    }

    // Filter log untuk hari ini
    public function scopeToday($query)
    {
        return $query->whereDate('attempted_at', Carbon::now('Asia/Jakarta')->toDateString());
    }

    // Filter login yang sukses
    public function scopeSuccess(Builder $query)
    {
        return $query->where('login_allowed', true);
    }

    // Filter login yang gagal
    public function scopeFailed(Builder $query)
    {
        return $query->where('login_allowed', false);
    }
}
