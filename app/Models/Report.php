<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Report extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'reports';

    protected $fillable = [
        'nolab',
        'department',
        'id_parameter',
        'payment_method',
        'nama_parameter',
        'quantity',
        'price',
        'total',
        'tanggal',
        'nama_dokter',
        'mcu_package_id',
        'dokter_external'
    ];
    public function detailDepartment()
    {
        return $this->belongsTo(DetailDepartment::class, 'id_parameter');
    }
    public function departments()
    {
        return $this->belongsTo(Department::class, 'department', 'id');
    }
    public function mcuPackage()
    {
        return $this->belongsTo(McuPackage::class, 'mcu_package_id');
    }
}
