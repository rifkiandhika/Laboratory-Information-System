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
        return $this->hasMany(pasien::class, 'kode_dokter', 'nama_dokter');
        // foreignKey (di pasien), ownerKey (di dokter)
    }

    public function getAllPolis()
    {
        $poliIds = json_decode($this->id_poli, true);
        if (is_array($poliIds) && !empty($poliIds)) {
            return Poli::whereIn('id', $poliIds)->get();
        }
        return collect();
    }

    public function getPoliNamesAttribute()
    {
        $poliIds = json_decode($this->id_poli, true);
        if (is_array($poliIds) && !empty($poliIds)) {
            return Poli::whereIn('id', $poliIds)
                ->pluck('nama_poli')
                ->implode(', ');
        }
        return '-';
    }

    public function getPoliIdsArrayAttribute()
    {
        $poliIds = json_decode($this->id_poli, true);
        return is_array($poliIds) ? $poliIds : [];
    }
}
