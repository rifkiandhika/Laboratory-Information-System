<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class obx extends Model
{
    use HasFactory;
    protected $table = "obxes";
    protected $guarded = [];

    public function pasien()
    {
        return $this->belongsTo(pasien::class, 'tanggal', 'tanggal');
    }
}
