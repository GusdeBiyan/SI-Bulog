<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class GudangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gudang = Gudang::all();
        return view('data-gudang.index', compact('gudang'));
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
            'nama_gudang' => 'required|max:255 |min:8|regex:/^[^0-9]+$/',
            'lokasi' => 'required|max:255|min:3|regex:/^[^0-9]+$/',
            'kapasitas' => 'required|numeric|max:999999|not_start_with_zero',
        ]);

        Gudang::create($data);


        // Tampilkan data yang diposting
        session()->flash('toast_message', 'Data berhasil ditambahkan'); // Simpan pesan dalam session
        session()->flash('toast_icon', 'success'); // Simpan ikon dalam session

        return redirect()->route('data-gudang.index'); // Redirect ke halaman tujuan
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
            'nama_gudang_edit' => 'required|max:255 |min:8|regex:/^[^0-9]+$/',
            'lokasi_edit' => 'required|max:255|min:3|regex:/^[^0-9]+$/',
            'kapasitas_edit' => 'required|numeric|max:999999|not_start_with_zero',
        ]);

        // Gudang::where('id', $id)->update($data);
        Gudang::where('id', $id)->update([
            'nama_gudang' => $request->nama_gudang_edit,
            'lokasi' => $request->lokasi_edit,
            'kapasitas' => $request->kapasitas_edit,
        ]);


        session()->flash('toast_message', 'Data berhasil diubah'); // Simpan pesan dalam session
        session()->flash('toast_icon', 'success'); // Simpan ikon dalam session

        return redirect()->route('data-gudang.index'); // Redirect ke halaman tujuan
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $data = Gudang::find($id);

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

            return redirect()->route('data-gudang.index'); // Redirect ke halaman tujuan dengan pesan kesalahan
        }
    }
}
