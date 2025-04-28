<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class msh extends Model
{
    use HasFactory;
    protected $table = "mshes";
    protected $guarded = [];
}
