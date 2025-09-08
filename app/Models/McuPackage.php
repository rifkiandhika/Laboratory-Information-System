<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McuPackage extends Model
{
    use HasFactory;
    protected $table = 'mcu_packages';
    protected $guarded = [];
    protected $casts = [
        'harga_normal' => 'decimal:2',
        'diskon' => 'decimal:2',
        'harga_final' => 'decimal:2',
    ];

    // Relationship dengan detail pemeriksaan
    public function mcuPackageDetails()
    {
        return $this->hasMany(McuPackageDetail::class);
    }

    public function mcuDetails()
    {
        return $this->hasMany(McuPackageDetail::class, 'mcu_package_id');
    }

    // Relationship dengan detail departments melalui pivot
    public function detailDepartments()
    {
        return $this->belongsToMany(DetailDepartment::class, 'mcu_package_details', 'mcu_package_id', 'detail_department_id');
    }

    // Hitung harga normal otomatis
    public function calculateNormalPrice()
    {
        return $this->detailDepartments->sum('harga');
    }

    // Hitung harga final setelah diskon
    public function calculateFinalPrice()
    {
        $normal = $this->harga_normal;
        $discount = ($this->diskon / 100) * $normal;
        return $normal - $discount;
    }
}
