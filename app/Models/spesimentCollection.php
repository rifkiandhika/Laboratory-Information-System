<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class spesimentCollection extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_lab',
        'tabung',
        'kapasitas',
        'status',
        'tanggal'
    ];
}
