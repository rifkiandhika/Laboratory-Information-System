<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        //jika user belum login, maka akan diarahkan ke halaman login
        if (! $request->expectsJson()) {
            return route('login.index');
        }elseif (Auth::user()->role == 'loket') {
            return route('loket.index');
        }elseif (Auth::user()->role == 'analyst') {
            return route('analyst.index');
        }elseif (Auth::user()->role == 'demo') {
            return route('loket.index');
        }
        elseif (Auth::user()->role == 'admin') {
            return route('admin.dashboard');
        }
    }
}
