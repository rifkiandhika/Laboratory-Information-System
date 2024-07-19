<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\dokter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class pasien extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'pasiens';

    public function data_pemeriksaan_pasien(){
        return $this->hasMany(pemeriksaan_pasien::class, 'no_lab', 'no_lab');
    }

    public function dpp(){
        return $this->hasMany(pemeriksaan_pasien::class, 'no_lab', 'no_lab')->groupBy('id_departement');
    }

    public function dokter()
    {
        return $this->belongsTo(dokter::class, 'kode_dokter', 'kode_dokter');
    }
    public function age()
    {
        return Carbon::parse($this->attributes['lahir'])->age;
    }

}
