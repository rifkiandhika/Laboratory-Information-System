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
        return $this->hasMany(Pasien::class, 'kode_dokter', 'kode_dokter');
    }

    public function polis()
    {
        return $this->belongsTo(Poli::class, 'id_poli', 'id');
    }
}
