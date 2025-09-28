<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPemeriksaan extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'hasil_pemeriksaans';
    protected $fillable = ['no_lab', 'no_rm', 'nama', 'ruangan', 'nama_dokter', 'department', 'nama_pemeriksaan', 'hasil', 'range', 'flag', 'satuan', 'duplo_d1', 'duplo_d2', 'duplo_d3', 'note', 'duplo_dx', 'judul', 'is_switched'];

    public function pasien()
    {
        return $this->belongsTo(pasien::class, 'no_lab', 'no_lab');
    }
}
