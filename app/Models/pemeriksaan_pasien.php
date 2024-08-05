<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PDO;

class pemeriksaan_pasien extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan_pasiens';
    protected $guarded = ['id'];
    protected $fillable = ['no_lab', 'pemeriksaan', 'harga', 'id_parameter', 'id_departement', 'nama_parameter'];

    public function pemeriksaan()
    {
        return $this->belongsTo(DetailDepartment::class, 'id_departement', 'id');
    }

    public function dokter()
    {
        return $this->belongsTo(dokter::class, 'nama_dokter', 'id');
    }

    public function data_departement()
    {
        return $this->belongsTo(Department::class, 'id_departement');
    }

    public function data_pemeriksaan()
    {
        return $this->belongsTo(DetailDepartment::class, 'id_parameter');
    }

    public function pasiens()
    {
        return $this->hasMany(pemeriksaan_pasien::class, 'id_departement', 'id_departement');
    }



    public function data_spesiment()
    {
        return $this->hasMany(Spesiment::class, 'id_departement', 'id_departement');
    }
}
