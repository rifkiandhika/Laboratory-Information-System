<?php

namespace App\Models;

use App\Models\pasien;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class historyPasien extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_lab',
        'proses',
        'tempat',
        'waktu_proses',
        'note'
    ];

    protected $table = 'history_pasiens';
    protected $guarded = [];

    public function pasien()
    {
        return $this->belongsTo(pasien::class, 'no_lab', 'no_lab');
    }
}
