<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\pasien;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class pasienseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++){
            $tanggal = date('dmy');
            $urutan = pasien::where('no_lab', 'like', 'LAB'.$tanggal.'%')->count()+1;
            $urutan = sprintf("%03d", $urutan);
            $no_lab = 'LAB'.$tanggal.$urutan;
            $nik = rand(0, 9);
            $cito =rand(0, 1);

            DB::table('pasiens')->insert([
                'no_lab' => $no_lab,
                'no_rm' => Str::random(4),
                'cito' => $cito,
                'nik' =>  $nik,
                'jenis_pelayanan' =>  $nik,
                'nama' =>  Str::random(10),
                'lahir' =>  Carbon::parse('2000-01-01'),
                'jenis_kelamin' =>  'Laki-Laki',
                'no_telp' =>  '089637885692',
                'kode_dokter' =>  Str::random(5),
                'diagnosa' =>  'radak stress stress stress',
                'alamat' =>  Str::random(20),

            ]);
        }
        for ($i = 0; $i < 20; $i++){
            $tanggal = date('dmy');
            $urutan = pasien::where('no_lab', 'like', 'LAB'.$tanggal.'%')->count()+1;
            $urutan = sprintf("%03d", $urutan);
            $no_lab = 'LAB'.$tanggal.$urutan;
            $nik = rand(0, 9);
            $cito =rand(0, 1);

            DB::table('pasiens')->insert([
                'no_lab' => $no_lab,
                'no_rm' => Str::random(4),
                'cito' => $cito,
                'nik' =>  $nik,
                'jenis_pelayanan' =>  $nik,
                'nama' =>  Str::random(10),
                'lahir' =>  Carbon::parse('2000-01-01'),
                'jenis_kelamin' =>  'Laki-Laki',
                'no_telp' =>  '089637885692',
                'status' =>  'Telah Dikirim ke Lab',
                'kode_dokter' =>  Str::random(5),
                'diagnosa' =>  'radak stress stress stress',
                'alamat' =>  Str::random(20),

            ]);
        }
    }
}
