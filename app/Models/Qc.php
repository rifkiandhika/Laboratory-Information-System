<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qc extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'quality_controls';


    public function detailLots()
    {
        return $this->hasMany(DetailLot::class, 'quality_control_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    // Accessor untuk format level
    public function getLevelAttribute($value)
    {
        return ucfirst($value);
    }

    // Mutator untuk level
    public function setLevelAttribute($value)
    {
        $this->attributes['level'] = strtolower($value);
    }

    // Scope untuk filter by department
    public function scopeByDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    // Scope untuk search
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('no_lot', 'like', "%{$search}%")
                ->orWhere('name_control', 'like', "%{$search}%");
        });
    }

    // Scope untuk level
    public function scopeLevel($query, $level)
    {
        return $query->where('level', strtolower($level));
    }

    // Method untuk check apakah LOT sudah expired
    public function isExpired()
    {
        return $this->exp_date < now();
    }

    // Method untuk get status LOT
    public function getStatus()
    {
        if ($this->isExpired()) {
            return 'expired';
        }

        if ($this->last_qc && $this->last_qc->diffInDays(now()) > 30) {
            return 'needs_qc';
        }

        return 'active';
    }

    // Method untuk format tanggal untuk display
    public function getFormattedExpDateAttribute()
    {
        return $this->exp_date ? $this->exp_date->format('d/m/Y') : '-';
    }

    public function getFormattedUseQcAttribute()
    {
        return $this->use_qc ? $this->use_qc->format('d/m/Y') : '-';
    }

    public function getFormattedLastQcAttribute()
    {
        return $this->last_qc ? $this->last_qc->format('d/m/Y') : '-';
    }
}
