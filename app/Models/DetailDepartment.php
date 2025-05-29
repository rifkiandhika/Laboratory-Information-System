<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailDepartment extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'detail_departments';

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
