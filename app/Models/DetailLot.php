<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailLot extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'detail_lots';

    public function qualityControl()
    {
        return $this->belongsTo(Qc::class, 'quality_control_id');
    }

    // Scope untuk filter by parameter
    public function scopeByParameter($query, $parameter)
    {
        return $query->where('parameter', $parameter);
    }

    // Scope untuk filter by QC
    public function scopeByQualityControl($query, $qcId)
    {
        return $query->where('quality_control_id', $qcId);
    }

    // Method untuk check apakah nilai dalam range
    public function isInRange($value)
    {
        return $value >= $this->bts_bawah && $value <= $this->bts_atas;
    }

    // Method untuk calculate CV (Coefficient of Variation)
    public function calculateCV()
    {
        if ($this->mean > 0) {
            return ($this->standart / $this->mean) * 100;
        }
        return 0;
    }

    // Method untuk format nilai
    public function getFormattedMeanAttribute()
    {
        return number_format($this->mean, 2);
    }

    public function getFormattedRangeAttribute()
    {
        return number_format($this->range, 2);
    }

    public function getFormattedBtsAtasAttribute()
    {
        return number_format($this->bts_atas, 2);
    }

    public function getFormattedBtsBawahAttribute()
    {
        return number_format($this->bts_bawah, 2);
    }

    public function getFormattedStandartAttribute()
    {
        return number_format($this->standart, 2);
    }
}
