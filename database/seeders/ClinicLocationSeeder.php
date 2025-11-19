<?php

namespace Database\Seeders;

use App\Models\AllowedIpRange;
use App\Models\ClinicLocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClinicLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Buat klinik pertama
        $clinic1 = ClinicLocation::create([
            'name' => 'Klinik Sehat Utama',
            'latitude' => -6.2884705,  // GANTI dengan koordinat klinik Anda
            'longitude' => 106.7467396, // GANTI dengan koordinat klinik Anda
            'radius' => 500, // 500 meter
            'is_active' => true
        ]);

        // Buat klinik kedua (optional)
        $clinic2 = ClinicLocation::create([
            'name' => 'Klinik Sehat Cabang',
            'latitude' => -6.2951200,
            'longitude' => 106.7528400,
            'radius' => 300, // 300 meter
            'is_active' => true
        ]);

        // ==========================================
        // IP RANGES UNTUK KLINIK 1
        // ==========================================

        // WiFi Kantor Klinik
        AllowedIpRange::create([
            'clinic_location_id' => $clinic1->id,
            'ip_range' => '192.168.1.',
            'description' => 'WiFi Kantor Klinik Utama',
            'is_active' => true
        ]);

        // LAN Klinik
        AllowedIpRange::create([
            'clinic_location_id' => $clinic1->id,
            'ip_range' => '10.0.0.',
            'description' => 'LAN Klinik Utama',
            'is_active' => true
        ]);

        // VPN Klinik (jika ada)
        AllowedIpRange::create([
            'clinic_location_id' => $clinic1->id,
            'ip_range' => '172.16.0.',
            'description' => 'VPN Klinik Utama',
            'is_active' => true
        ]);

        // ==========================================
        // IP RANGES UNTUK KLINIK 2
        // ==========================================

        AllowedIpRange::create([
            'clinic_location_id' => $clinic2->id,
            'ip_range' => '192.168.2.',
            'description' => 'WiFi Kantor Cabang',
            'is_active' => true
        ]);

        AllowedIpRange::create([
            'clinic_location_id' => $clinic2->id,
            'ip_range' => '10.10.0.',
            'description' => 'LAN Cabang',
            'is_active' => true
        ]);



        // Localhost IPv4
        AllowedIpRange::create([
            'clinic_location_id' => $clinic1->id,
            'ip_range' => '127.0.0.1',
            'description' => '⚠️ Localhost Development (HAPUS DI PRODUCTION!)',
            'is_active' => true
        ]);

        // Localhost IPv6
        AllowedIpRange::create([
            'clinic_location_id' => $clinic1->id,
            'ip_range' => '::1',
            'description' => '⚠️ IPv6 Localhost (HAPUS DI PRODUCTION!)',
            'is_active' => true
        ]);
    }
}
