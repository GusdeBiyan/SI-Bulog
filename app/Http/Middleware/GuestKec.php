<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestKec
{
    public function handle(Request $request, Closure $next)
    {
        $id_user_kec = session('id');
        $email = session('email');
        // Periksa apakah session 'username' telah diatur
        // if (session()->has('email')) {
        //     // Jika session 'username' telah diatur, lanjutkan permintaan

        //     return back();
        // } else {
        //     // Jika session 'username' tidak diatur, arahkan pengguna ke halaman login
        //     return $next($request);
        // }

        if ($id_user_kec && $email) {
            // Jika session 'id_user_kec' dan 'email' telah diatur, lanjutkan permintaan

            return back();
        } else {
            // Jika salah satu session tidak diatur, arahkan pengguna ke halaman login
            return $next($request);
        }
    }
}
