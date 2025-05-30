<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spesiment extends Model
{
    use HasFactory;
    protected $guarded = [];
    // protected $fillable = ['id_departement', 'spesiment', 'note'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'id_departement');
    }

    public function details()
    {
        return $this->hasMany(DetailSpesiment::class);
    }
}
