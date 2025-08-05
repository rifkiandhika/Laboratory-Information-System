<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class spesimentHandling extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function department()
    {
        return $this->belongsTo(Department::class, 'id_departement', 'id');
    }

    public function spesimentCollection()
    {
        return $this->belongsTo(spesimentCollection::class, 'no_lab', 'no_lab');
    }
    public function details()
    {
        return $this->hasMany(DetailSpesiment::class, 'id', 'serum');
    }
}
