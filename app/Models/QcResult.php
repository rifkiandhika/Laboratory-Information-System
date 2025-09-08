<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class QcResult extends Model
{
    use HasFactory;

    protected $table = 'qc_results';

    protected $guarded = [];

    protected $casts = [
        'test_date' => 'date',
        'd1' => 'decimal:2',
        'd2' => 'decimal:2',
        'd3' => 'decimal:2',
        'd4' => 'decimal:2',
        'd5' => 'decimal:2',
        'result' => 'decimal:2'
    ];

    // Relationship dengan QC
    public function qc()
    {
        return $this->belongsTo(Qc::class, 'qc_id');
    }

    // Relationship dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope untuk filter berdasarkan parameter
    public function scopeByParameter($query, $parameter)
    {
        return $query->where('parameter', $parameter);
    }

    // Scope untuk filter berdasarkan tanggal
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('test_date', [$startDate, $endDate]);
    }

    // Scope untuk filter berdasarkan flag
    public function scopeByFlag($query, $flag)
    {
        return $query->where('flag', $flag);
    }

    // Accessor untuk menghitung rata-rata D1-D5
    public function getAverageAttribute()
    {
        $values = collect([$this->d1, $this->d2, $this->d3, $this->d4, $this->d5])
            ->filter(function ($value) {
                return !is_null($value) && $value > 0;
            });

        return $values->count() > 0 ? $values->avg() : 0;
    }

    // Method untuk menentukan flag berdasarkan parameter QC
    public function calculateFlag()
    {
        $parameter = $this->qc->detailLots()
            ->where('parameter', $this->parameter)
            ->first();

        if (!$parameter) {
            return 'Unknown';
        }

        $mean = $parameter->mean;
        $range = $parameter->range;
        $result = $this->result;

        if (!$mean || !$range || !$result) {
            return 'Unknown';
        }

        $diff = abs($result - $mean);
        $sdValue = $diff / $range;

        if ($sdValue <= 1) {
            return 'Normal';
        } elseif ($sdValue <= 2) {
            return $result > $mean ? 'High' : 'Low';
        } else {
            return 'Critical';
        }
    }

    // Method untuk mendapatkan symbol flag
    public function getFlagSymbol()
    {
        switch (strtolower($this->flag)) {
            case 'normal':
                return '○';
            case 'low':
                return '↓';
            case 'high':
                return '↑';
            case 'critical':
                return '⚠';
            default:
                return '-';
        }
    }

    public function getTestDateAttribute($value)
    {
        if (!$value) return null;

        // Return format YYYY-MM-DD saja, tanpa waktu
        return Carbon::parse($value)->format('Y-m-d');
    }

    // Atau jika ingin tetap full datetime tapi dengan timezone lokal
    public function getTestDateFormattedAttribute()
    {
        if (!$this->test_date) return null;

        return Carbon::parse($this->attributes['test_date'])
            ->setTimezone(config('app.timezone', 'Asia/Jakarta'))
            ->format('Y-m-d H:i:s');
    }
}
