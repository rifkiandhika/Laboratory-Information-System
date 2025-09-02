<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McuPackageDetail extends Model
{
    use HasFactory;

    protected $table = 'mcu_package_details';
    protected $guarded = [];

    public function mcuPackage()
    {
        return $this->belongsTo(McuPackage::class);
    }

    public function detailDepartment()
    {
        return $this->belongsTo(DetailDepartment::class);
    }
}
