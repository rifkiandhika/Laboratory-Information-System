<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailDepartment extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = ['department_id', 'kode', 'nama_parameter', 'nama_pemeriksaan', 'harga', 'nilai_statik', 'nilai_satuan'];
    protected $table = 'detail_departments';

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
