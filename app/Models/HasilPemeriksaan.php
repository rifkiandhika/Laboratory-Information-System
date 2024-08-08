<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPemeriksaan extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'hasil_pemeriksaans';
    protected $fillable = ['no_lab', 'no_rm', 'nama', 'ruangan', 'nama_dokter', 'department', 'nama_pemeriksaan', 'hasil', 'range', 'flag', 'satuan'];

    public function pasien()
    {
        return $this->belongsTo(pasien::class, 'no_lab', 'no_lab');
    }
}
