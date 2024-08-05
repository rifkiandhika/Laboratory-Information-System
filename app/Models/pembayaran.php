<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans';
    protected $guarded = [];
    // protected $fillable = ['id_pembayaran', 'id_petugas', 'nisn', 'tgl_bayar', 'bulan_dibayar', 'tahun_dibayar', 'id_spp', 'jumlah_bayar'];

    public function pasien()
    {
        return $this->belongsTo(pasien::class, 'no_lab', 'no_lab');
    }
}
