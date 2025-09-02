<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function pemeriksaan()
    {
        return $this->hasMany(Pemeriksaan::class, 'id_departement');
    }

    public function spesiment()
    {
        return $this->hasMany(Spesiment::class, 'id_departement');
    }

    public function detailDepartments()
    {
        return $this->hasMany(DetailDepartment::class, 'department_id');
    }


    public static function boot()
    {
        parent::boot();

        static::deleting(function ($department) {
            $department->pemeriksaan()->delete();
        });
    }

    public function qualityControls()
    {
        return $this->hasMany(Qc::class, 'department_id');
    }

    // Scope untuk active department
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    // Method untuk check apakah department hematologi
    public function isHematology()
    {
        return stripos($this->nama_department, 'hematologi') !== false;
    }
}
