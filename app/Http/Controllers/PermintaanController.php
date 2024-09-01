<?php

namespace App\Http\Controllers;

use App\Models\Permintaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Kecamatan;
use App\Models\UserKec;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class PermintaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_user = UserKec::all();
        $data_kecamatan = Kecamatan::all();

        // Ambil ID pengguna yang login dari sesi
        $id_user_kec = session('id');
        $id_kecamatan = session('id_kecamatan');
        $username = session('username');


        // Query data permintaan berdasarkan ID pengguna yang login
        $permintaan = Permintaan::with('kecamatan', 'userKec')->where('id_user_kec', $id_user_kec)->get();

        return view('data-permintaan.create', compact('permintaan', 'data_user', 'data_kecamatan'));
    }





    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_user_kec' => 'required',
            'id_kecamatan' => 'required',
            'data_permintaan' => 'required|mimes:pdf',
            // 'data_permintaan' => 'required',
            'jumlah_permintaan_beras' => 'required|numeric|not_start_with_zero|max:9999999|min:100',
            'jumlah_rts' => 'required|numeric|not_start_with_zero|max:9999999|min:100',
        ]);



        $filePath = $request->file('data_permintaan')->store('uploads', 'public');

        Permintaan::create([
            'id_user_kec' => $request->id_user_kec,
            'id_kecamatan' => $request->id_kecamatan,
            'data_permintaan' => $filePath,
            'jumlah_permintaan_beras' => $request->jumlah_permintaan_beras,
            'jumlah_rts' => $request->jumlah_rts,

        ]);



        // dd($data);
        // Permintaan::create($data);
        // Tampilkan data yang diposting
        session()->flash('toast_message', 'Data berhasil ditambahkan'); // Simpan pesan dalam session
        session()->flash('toast_icon', 'success'); // Simpan ikon dalam session

        return back(); // Redirect ke halaman tujuan
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $data_kecamatan = Kecamatan::all();
        $data_user_kec = UserKec::all();
        $permintaan = Permintaan::with('userkec', 'kecamatan')->get();
        return view('data-permintaan.index', compact('permintaan', 'data_user_kec', 'data_kecamatan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permintaan $permintaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permintaan $permintaan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        // Cari data yang akan dihapus berdasarkan ID
        $data = Permintaan::find($id);

        // Jika data tidak ditemukan, kembalikan respon dengan status 404 (Not Found)
        if (!$data) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        // Lakukan penghapusan data
        if (Storage::exists('public/' . $data->data_permintaan)) {
            Storage::delete('public/' . $data->data_permintaan);
        }

        $data->delete();

        session()->flash('toast_message', 'Data berhasil dihapus'); // Simpan pesan dalam session
        session()->flash('toast_icon', 'success'); // Simpan ikon dalam session

        return back();
    }
}
