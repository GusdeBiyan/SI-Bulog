<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.login');
    }

    public function authentication(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {

            // $user = Auth::user();

            // // Simpan username pengguna ke dalam sesi
            // // session(['username' => $user->username]);
            session()->flash('toast_message', 'Login Berhasil'); // Simpan pesan dalam session
            session()->flash('toast_icon', 'success'); // Simpan ikon dalam session

            return redirect('/dashboard');
            // dd(session()->all());
        } else {
            session()->flash('toast_message', 'Login Gagal, periksa kembali username dan passsword'); // Simpan pesan dalam session
            session()->flash('toast_icon', 'error'); // Simpan ikon dalam session
            return back();
        }
    }


    public function logout(Request $request)
    {
        Auth::logout(); // Menghapus sesi pengguna

        $request->session()->invalidate(); // Menghapus sesi yang sudah valid
        $request->session()->regenerateToken(); // Mereset token sesi


        session()->flash('toast_message', 'logout Berhasil'); // Simpan pesan dalam session
        session()->flash('toast_icon', 'success'); // Simpan ikon dalam session

        return redirect('/login-admin'); // Mengarahkan kembali ke halaman login
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $auth)
    {
        //
    }
}
