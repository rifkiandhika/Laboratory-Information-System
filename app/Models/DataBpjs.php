<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataBpjs extends Model
{
    use HasFactory;
    protected $table = 'data_bpjs';
    protected $guarded = [];

    public function datapasien()
    {
        return $this->belongsTo(DataPasien::class, 'data_pasiens_id');
    }
}
