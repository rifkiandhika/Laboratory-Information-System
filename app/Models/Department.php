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
        return $this->hasMany(Spesiment::class);
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
}
