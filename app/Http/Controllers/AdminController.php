<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\dokter;
use App\Models\Department;
use App\Models\pasien;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $ph = pasien::whereDate('created_at', now())->count(); // Total pasien yang datang hari ini
        $tu = User::count();  // Total pengguna
        // $totalRequestParameters = RequestParameter::count();
        $users = User::all();
        return view("admin/dashboard", compact('users', 'ph', 'tu'));
    }

    public function dokter()
    {
        $dokters = dokter::all();
        return view("admin.dokter", compact('dokters'));
    }
    public function department()
    {
        $data = Department::all();
        return view('admin.departement.departemen', compact('data'));
    }
    public function insert_department(Request $request)
    {
        $request->validate([
            'nama_departemen' => 'required|unique:departements,nama_departemen'
        ]);
        Department::create($request->all());
        toast('Data Berhasil Ditambahkan', 'success');
        return  back();
    }
}
