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


    public function data_pemeriksaan_pasien()
    {
        return $this->hasMany(pemeriksaan_pasien::class, 'no_lab', 'no_lab');
    }

    public function dpp()
    {
        return $this->hasMany(pemeriksaan_pasien::class, 'no_lab', 'no_lab')->groupBy('id_departement');
    }

    public function spesiment()
    {
        return $this->hasManyThrough(Spesiment::class, pemeriksaan_pasien::class, 'no_lab', 'id_departement', 'no_lab', 'id_departement')->groupBy('id');
    }

    public function spesimentcollection()
    {
        return $this->hasMany(spesimentCollection::class, 'no_lab', 'no_lab');
    }
    public function spesimenthandling()
    {
        return $this->hasMany(spesimentHandling::class, 'no_lab', 'no_lab');
    }

    public function dokter()
    {
        return $this->belongsTo(dokter::class, 'kode_dokter', 'nama_dokter');
    }

    // public function dokters()
    // {
    //     // kolom 'kode_dokter' di tabel pasien dihubungkan dengan 'nama_dokter' di tabel dokters
    //     return $this->belongsTo(Dokter::class, 'kode_dokter', 'nama_dokter');
    // }

    public function history()
    {
        return $this->hasMany(historyPasien::class, 'no_lab', 'no_lab');
    }

    public function pembayaran()
    {
        return $this->hasMany(pembayaran::class, 'no_lab', 'no_lab');
    }

    public function hasil_pemeriksaan()
    {
        return $this->hasMany(HasilPemeriksaan::class, 'no_lab', 'no_lab');
    }
    public function data_pemeriksaan()
    {
        return $this->belongsTo(DetailDepartment::class, 'id_parameter');
    }
    public function pemeriksaan_pasien()
    {
        return $this->hasMany(pemeriksaan_pasien::class, 'no_lab', 'no_lab');
    }
    // public function obx()
    // {
    //     return $this->hasMany(obx::class, 'tanggal', 'tanggal');
    // }

    public function getObrsAttribute()
    {
        return obr::whereRaw("REPLACE(order_number, 'H-', '') = ?", [$this->no_lab])
            ->with(['obx']) // ambil obx sesuai relasi dari obr
            ->get();
    }

    public function age()
    {
        return Carbon::parse($this->attributes['lahir'])->age;
    }

    public function mcuPackage()
    {
        return $this->belongsTo(McuPackage::class, 'mcu_package_id');
    }
}
