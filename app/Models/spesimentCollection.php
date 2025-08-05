<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class spesimentCollection extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function spesimentHandlings()
    {
        return $this->hasMany(spesimentHandling::class, 'no_lab', 'no_lab');
    }
    public function details()
    {
        return $this->hasMany(DetailSpesiment::class, 'spesiment_id', 'id');
    }
    public function getDetailsByCriteria()
    {
        return DetailSpesiment::where(function ($query) {
            $query->where('id', $this->kapasitas)->orWhere('id', $this->serumh);
        })->get();
    }
}
