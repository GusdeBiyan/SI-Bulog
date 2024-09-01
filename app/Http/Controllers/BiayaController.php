<?php

namespace App\Http\Controllers;

use App\Models\Biaya;
use Illuminate\Http\Request;
use App\Models\Gudang;
use App\Models\Kecamatan;
use App\Models\UserKec;

class BiayaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data_gudang = Gudang::all();
        $data_kecamatan = Kecamatan::all();
        $biaya = Biaya::with('gudang', 'kecamatan')->get();

        return view('data-biaya.index', compact('biaya', 'data_gudang', 'data_kecamatan'));
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
        $data = $request->validate([
            'id_gudang' => 'required',
            'id_kecamatan' => 'required',
            'jarak' => 'required|numeric|not_start_with_zero',
            'biaya_pengiriman' => 'required|numeric|not_start_with_zero',
        ]);


        Biaya::create($data);
        // Tampilkan data yang diposting
        session()->flash('toast_message', 'Data berhasil ditambahkan'); // Simpan pesan dalam session
        session()->flash('toast_icon', 'success'); // Simpan ikon dalam session

        return redirect()->route('data-biaya.index'); // Redirect ke halaman tujuan
    }

    /**
     * Display the specified resource.
     */
    public function show(Biaya $biaya)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Biaya $biaya)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  string $id)
    {
        $data = $request->validate([
            'id_gudang_edit' => 'required|numeric',
            'id_kecamatan_edit' => 'required|numeric',
            'jarak_edit' => 'required|numeric | not_start_with_zero',
            'biaya_pengiriman_edit' => 'required|numeric| not_start_with_zero',
        ]);


        Biaya::where('id', $id)->update([
            'id_gudang' => $request->id_gudang_edit,
            'id_kecamatan' => $request->id_kecamatan_edit,
            'jarak' => $request->jarak_edit,
            'biaya_pengiriman' => $request->biaya_pengiriman_edit,
        ]);

        // Biaya::where('id', $id)->update($data);

        session()->flash('toast_message', 'Data berhasil diubah'); // Simpan pesan dalam session
        session()->flash('toast_icon', 'success'); // Simpan ikon dalam session

        return redirect()->route('data-biaya.index'); // Redirect ke halaman tujuan

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        // Cari data yang akan dihapus berdasarkan ID
        $data = Biaya::find($id);

        // Jika data tidak ditemukan, kembalikan respon dengan status 404 (Not Found)
        if (!$data) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        // Lakukan penghapusan data
        $data->delete();

        session()->flash('toast_message', 'Data berhasil dihapus'); // Simpan pesan dalam session
        session()->flash('toast_icon', 'success'); // Simpan ikon dalam session

        return redirect()->route('data-biaya.index');
    }
}
