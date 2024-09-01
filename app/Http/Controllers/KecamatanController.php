<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class KecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kecamatan = Kecamatan::all();
        return view('data-kecamatan.index', compact('kecamatan'));
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
            'nama_kecamatan' => 'required',
            'kebutuhan_beras' => 'required|numeric|not_start_with_zero',
            'jumlah_penerima' => 'required|numeric|not_start_with_zero',
        ]);

        Kecamatan::create($data);
        // Tampilkan data yang diposting
        session()->flash('toast_message', 'Data berhasil ditambahkan'); // Simpan pesan dalam session
        session()->flash('toast_icon', 'success'); // Simpan ikon dalam session

        return redirect()->route('data-kecamatan.index'); // Redirect ke halaman tujuan

        // return redirect()->route('data-kecamatan.index')->with('success', 'Data berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nama_kecamatan_edit' => 'required',
            'kebutuhan_beras_edit' => 'required|numeric|not_start_with_zero',
            'jumlah_penerima_edit' => 'required|numeric|not_start_with_zero',
        ]);

        Kecamatan::where('id', $id)->update([
            'nama_kecamatan' => $request->nama_kecamatan_edit,
            'kebutuhan_beras' => $request->kebutuhan_beras_edit,
            'jumlah_penerima' => $request->jumlah_penerima_edit,
        ]);


        session()->flash('toast_message', 'Data berhasil diubah'); // Simpan pesan dalam session
        session()->flash('toast_icon', 'success'); // Simpan ikon dalam session

        return redirect()->route('data-kecamatan.index'); // Redirect ke halaman tujuan

        // dd($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $data = Kecamatan::find($id);

        // Jika data tidak ditemukan, kembalikan respon dengan status 404 (Not Found)
        if (!$data) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        try {
            // Lakukan penghapusan data
            $data->delete();

            session()->flash('toast_message', 'Data berhasil dihapus'); // Simpan pesan dalam session
            session()->flash('toast_icon', 'success'); // Simpan ikon dalam session

            return redirect()->route('data-gudang.index'); // Redirect ke halaman tujuan
        } catch (QueryException $e) {
            session()->flash('toast_message', 'Terdapat data terhubung, data tidak dapat dihapus'); // Simpan pesan dalam session
            session()->flash('toast_icon', 'error'); // Simpan ikon dalam session

            return redirect()->route('data-kecamatan.index'); // Redirect ke halaman tujuan dengan pesan kesalahan
        }
    }
}
