<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class user extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'UserAnalyst',
            'username' => 'analyst',
            'title' => 'analyst',
            'email' => 'analyst@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'analyst',
        ]);
        DB::table('users')->insert([
            'name' => 'UserLoket',
            'username' => 'loket',
            'title' => 'loket',
            'email' => 'loket@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'loket',
        ]);
        DB::table('users')->insert([
            'name' => 'UserAdmin',
            'username' => 'admin',
            'title' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);


    }
}
