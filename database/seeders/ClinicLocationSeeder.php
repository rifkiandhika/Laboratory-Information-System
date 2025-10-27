<?php

namespace Database\Seeders;

use App\Models\ClinicLocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClinicLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Klinik Utama Jakarta',
                'latitude' => -6.2088,   // Koordinat Jakarta
                'longitude' => 106.8456,
                'radius' => 100,         // Radius 100 meter
                'is_active' => true,
            ],
            [
                'name' => 'Klinik Bandung Sehat',
                'latitude' => -6.9175,   // Koordinat Bandung
                'longitude' => 107.6191,
                'radius' => 100,
                'is_active' => true,
            ],
            [
                'name' => 'Klinik Surabaya Medika',
                'latitude' => -7.2575,   // Koordinat Surabaya
                'longitude' => 112.7521,
                'radius' => 100,
                'is_active' => true,
            ],
        ];

        foreach ($locations as $loc) {
            ClinicLocation::updateOrCreate(
                ['name' => $loc['name']], // cari berdasarkan nama klinik
                $loc // update jika sudah ada
            );
        }
    }
}
