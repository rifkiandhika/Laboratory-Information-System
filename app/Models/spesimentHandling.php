<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class spesimentHandling extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_lab',
        'tabung',
        'serum',
        'status',
        'tanggal'
    ];
}
