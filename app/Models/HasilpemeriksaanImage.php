<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilpemeriksaanImage extends Model
{
    use HasFactory;
    protected $table = 'hasil_pemeriksaan_images';
    protected $guarded = [];

    public function dataPasien()
    {
        return $this->belongsTo(pasien::class, 'nolab', 'no_lab');
    }
}
