<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSpesiment extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = ['spesiment_id', 'nama_parameter', 'gambar'];
    protected $table = 'details';

    public function spesiment()
    {
        return $this->belongsTo(Spesiment::class);
    }
}
