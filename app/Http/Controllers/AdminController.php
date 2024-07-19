<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\dokter;
use App\Models\departement;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $users = User::all();
        return view("admin/dashboard", compact('users'));
    }

    public function dokter(){
        $dokters = dokter::all();
        return view("admin.dokter", compact('dokters'));
    }
    public function department(){
        $data=departement::all();
        return view('admin.departement.departemen',compact('data'));
    }
    public function insert_department(Request $request){
        $request->validate([
            'nama_departemen' => 'required|unique:departements,nama_departemen'
        ]);
        departement::create($request->all());
        toast('Data Berhasil Ditambahkan','success');
        return  back();
    }
}
