<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function dokters()
    {
        return $this->hasMany(dokter::class, 'id_poli');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($poli) {
            $poli->dokters()->delete();
        });
}
}
