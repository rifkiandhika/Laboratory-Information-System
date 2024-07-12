<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pemeriksaan_pasien extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan_pasiens';
    protected $guarded = ['id'];
    protected $fillable = ['no_lab', 'pemeriksaan', 'harga'];
}
