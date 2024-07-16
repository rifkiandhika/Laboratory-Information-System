<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dokter extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function pasien()
    {
        return $this->hasMany(pasien::class, 'kode_dokter', 'id');
    }

    public function poli(){
        return $this->belongsTo(Poli::class, 'id_poli', 'id');
    }

}
