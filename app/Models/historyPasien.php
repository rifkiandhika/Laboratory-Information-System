<?php

namespace App\Models;

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
}
