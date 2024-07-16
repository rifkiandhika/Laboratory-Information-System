<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pasien extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'pasiens';

    public function data_pemeriksaan_pasien(){
        return $this->hasMany(pemeriksaan_pasien::class, 'no_lab', 'no_lab');
    }
    public function dokter(){
        return $this->belongsTo(dokter::class, 'kode_dokter', 'id');
    }
}
