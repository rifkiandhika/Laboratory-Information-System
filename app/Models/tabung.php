<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tabung extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_tabung',
        'nama_tabung',
    ];
}
