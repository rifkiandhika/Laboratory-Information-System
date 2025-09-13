<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            'dashboard',
            'loket-pasien',
            'loket-data-pasien',
            'loket-report',
            'analyst-collection',
            'analyst-spesiment',
            'analyst-worklist',
            'analyst-result',
            'analyst-qc',
            'analyst-list-qc',
            'doctor',
            'department',
            'spesiments',
            'mcu',
            'dokter',
            'poli',
            'role-permissions',
        ];

        $features = ['create', 'read', 'update', 'delete'];

        // khusus dashboard hanya read
        if (!Permission::where('name', 'read_dashboard')->exists()) {
            Permission::create(['name' => 'read_dashboard']);
        }

        foreach ($modules as $module) {
            foreach ($features as $feature) {
                $permName = "{$feature}_{$module}";
                if (!Permission::where('name', $permName)->exists()) {
                    Permission::create(['name' => $permName]);
                }
            }
        }

        // Superadmin
        if (!Role::where('name', 'Superadmin')->exists()) {
            $superadmin = Role::create(['name' => 'Superadmin']);
            $superadmin->givePermissionTo(Permission::pluck('name'));
        }

        // contoh role lain
        if (!Role::where('name', 'Loket')->exists()) {
            $loket = Role::create(['name' => 'Loket']);
            $loket->givePermissionTo([
                'read_loket-pasien',
                'create_loket-pasien',
                'read_loket-data-pasien',
                'read_loket-report',
            ]);
        }

        if (!Role::where('name', 'Analyst')->exists()) {
            $analyst = Role::create(['name' => 'Analyst']);
            $analyst->givePermissionTo([
                'read_analyst-collection',
                'read_analyst-spesiment',
                'read_analyst-worklist',
                'update_analyst-result',
                'read_analyst-qc',
                'read_analyst-list-qc',
            ]);
        }

        if (!Role::where('name', 'Doctor')->exists()) {
            $doctor = Role::create(['name' => 'Doctor']);
            $doctor->givePermissionTo([
                'read_doctor',
                'update_doctor',
            ]);
        }
    }
}
