<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAsuransi extends Model
{
    use HasFactory;
    protected $table = 'data_asuransis';
    protected $guarded = [];

    public function datapasien()
    {
        return $this->belongsTo(DataPasien::class, 'data_pasiens_id');
    }
}
