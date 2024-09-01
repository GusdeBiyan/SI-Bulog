<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomMiddleware
{
    public function handle(Request $request, Closure $next)
    {

        $user = Auth::user();


        // Lakukan pengecekan atau operasi lain sesuai kebutuhan
        if ($user) {
            // Pengguna terautentikasi, lanjutkan permintaan
            return $next($request);
        } else {
            // Pengguna tidak terautentikasi, lakukan sesuatu (misalnya, redirect atau kembalikan respon)
            return back();
        }
    }
}
