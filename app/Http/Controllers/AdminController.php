<?php

namespace App\Http\Controllers;

use App\Models\dokter;
use Illuminate\Http\Request;
use app\Models\User;

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
}
