<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pemeriksaan_pasien extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan_pasiens';
    protected $guarded = ['id'];
    protected $fillable = ['no_lab', 'pemeriksaan', 'harga', 'id_parameter', 'id_departement', 'nama_parameter'];

    public function pemeriksaan(){
        return $this->belongsTo(Pemeriksaan::class, 'id_departement', 'id');
    }

    public function dokter(){
        return $this->belongsTo(dokter::class, 'nama_dokter', 'id');
    }

    public function data_departement(){
        return $this->hasMany(Department::class, 'id', 'id_departement');
    }

    public function data_pemeriksaan(){
        return $this->hasMany(Pemeriksaan::class, 'id', 'id_parameter');
    }
}
