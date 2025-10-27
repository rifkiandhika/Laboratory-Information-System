<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationLoginLog extends Model
{
    use HasFactory;

    protected $table = 'location_login_logs';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clinicLocation()
    {
        return $this->belongsTo(ClinicLocation::class);
    }
}
