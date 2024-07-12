<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\User;

class AdminController extends Controller
{
    public function index(){
        $users = User::all();
        return view("admin/dashboard", compact('users'));
    }
}
