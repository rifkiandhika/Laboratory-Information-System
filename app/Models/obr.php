<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class obr extends Model
{
    use HasFactory;
    protected $table = "obrs";
    protected $guarded = [];

    public function obx()
    {
        return $this->hasMany(obx::class, 'message_control_id', 'message_control_id');
    }
}
