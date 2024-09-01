<?php

namespace App\Http\Controllers;

use App\Models\UserKec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserKecController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('data-permintaan.login');
    }

    public function authentication(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        // Cari entri berdasarkan email dari tabel Permintaan
        $user = UserKec::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Jika entri ditemukan dan password cocok
            // Simpan email pengguna ke dalam sesi
            session(['id' => $user->id]);
            session(['id_kecamatan' => $user->id_kecamatan]);
            session(['email' => $user->email]);
            session(['username' => $user->username]);
            session(['nama_penanggung_jawab' => $user->nama_penanggung_jawab]);
            // $id_user_kec = session('id');
            // $email = session('email');
            session()->flash('toast_message', 'Login Berhasil'); // Simpan pesan dalam session
            session()->flash('toast_icon', 'success'); // Simpan ikon dalam session

            return redirect('/data-permintaan');
        } else {
            session()->flash('toast_message', 'Login Gagal, periksa kembali username dan password'); // Simpan pesan dalam session
            session()->flash('toast_icon', 'error'); // Simpan ikon dalam session
            return back();
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('email');
        // Hapus session 'username'

        session()->flash('toast_message', 'logout Berhasil'); // Simpan pesan dalam session
        session()->flash('toast_icon', 'success'); // Simpan ikon dalam session

        return redirect('/login-kec'); // Mengarahkan kembali ke halaman login
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     $data_user = UserKec::all();
    //     $data_kecamatan = Kecamatan::all();

    //     // Ambil ID pengguna yang login dari sesi
    //     $id_user_kec = session('id');
    //     $id_kecamatan = session('id_kecamatan');
    //     $username = session('username');


    //     // Query data permintaan berdasarkan ID pengguna yang login
    //     $data_permintaan = Permintaan::with('kecamatan', 'userKec')->where('id', $id_user_kec)->get();

    //     return view('data-permintaan.create', compact('data_permintaan', 'data_user', 'data_kecamatan'));
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $data = $request->validate([
    //         'id_user_ked' => 'required',
    //         'id_kecamatan' => 'required',
    //         'data_permintaan' => 'required',
    //         'Jumlah_permintaan_beras' => 'required|numeric',
    //         'Jumlah_rts' => 'required|numeric',
    //     ]);

    //     dd($data);
    //     // Permintaan::create($data);
    //     // // Tampilkan data yang diposting
    //     // session()->flash('toast_message', 'Data berhasil ditambahkan'); // Simpan pesan dalam session
    //     // session()->flash('toast_icon', 'success'); // Simpan ikon dalam session

    //     // return redirect()->route('data-permintaan.create'); // Redirect ke halaman tujuan
    // }

    /**
     * Display the specified resource.
     */
    public function show(UserKec $userKec)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserKec $userKec)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserKec $userKec)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserKec $userKec)
    {
        //
    }
}
