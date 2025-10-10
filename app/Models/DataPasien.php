<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPasien extends Model
{
    use HasFactory;

    protected $table = 'data_pasiens';
    protected $guarded = [];

    public function dataBpjs()
    {
        return $this->hasOne(DataBpjs::class, 'data_pasiens_id', 'id');
    }

    public function dataAsuransi()
    {
        return $this->hasMany(DataAsuransi::class, 'data_pasiens_id', 'id');
    }
}
