<?php

namespace App\Http\Controllers;

use App\Models\Distribusi;
use App\Models\Gudang;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class DistribusiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $distribusi = Distribusi::all();
        // foreach ($distribusi as $item) {
        //     // Ambil ID gudang dari data distribusi
        //     $idGudang = $item->id_gudang;
        //     $idKecamatan = $item->id_kecamatan;

        //     // Cari nama gudang berdasarkan ID
        //     $gudang = Gudang::find($idGudang);
        //     $kecamatan = Kecamatan::find($idKecamatan);

        //     // Jika gudang ditemukan, tambahkan nama gudang ke data biaya
        //     if ($gudang) {
        //         $item->nama_gudang = $gudang->nama_gudang;
        //     } else {
        //         // Jika gudang tidak ditemukan, atur nama gudang menjadi null atau pesan yang sesuai
        //         $item->nama_gudang = 'Gudang tidak ditemukan';
        //     }

        //     // Jika kecamatan ditemukan, tambahkan nama kecamatan ke data biaya
        //     if ($kecamatan) {
        //         $item->nama_kecamatan = $kecamatan->nama_kecamatan;
        //     } else {
        //         // Jika kecamatan tidak ditemukan, atur nama kecamatan menjadi null atau pesan yang sesuai
        //         $item->nama_kecamatan = 'Kecamatan tidak ditemukan';
        //     }
        // }

        return view('data-distribusi.index', compact('distribusi'));
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
        // Inisialisasi array kosong untuk menyimpan semua data distribusi
        $allData = [];

        // Lakukan loop untuk mengambil data dari setiap formulir distribusi
        for ($i = 1; $request->has("gudang$i"); $i++) {
            $data = [
                'nama_gudang' => $request->input("gudang$i"),
                'nama_kecamatan' => $request->input("kecamatan$i"),
                'jumlah_beras' => $request->input("jumlah_beras$i"),
                'biaya' => $request->input("biaya$i"),
                'status' => $request->input("status$i"),
            ];

            // Tambahkan data ke array semua data
            $allData[] = $data;
        }

        // Loop untuk menyimpan data distribusi ke dalam database atau lakukan operasi sesuai kebutuhan
        foreach ($allData as $data) {
            Distribusi::create($data);
        }

        // Periksa semua data yang dikumpulkan
        session()->flash('toast_message', 'Data berhasil disimoan'); // Simpan pesan dalam session
        session()->flash('toast_icon', 'success'); // Simpan ikon dalam session

        return redirect()->route('data-distribusi.index'); // Redirect ke halaman tujuan
    }

    /**
     * Display the specified resource.
     */
    public function show(Distribusi $distribusi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Distribusi $distribusi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nama_gudang' => 'required',
            'nama_kecamatan' => 'required',
            'jumlah_beras' => 'required',
            'biaya' => 'required',
            'status' => 'required',
            'created_at' => 'required',
        ]);

        // dd($data);

        Distribusi::where('id', $id)->update($data);

        session()->flash('toast_message', 'Data berhasil diubah'); // Simpan pesan dalam session
        session()->flash('toast_icon', 'success'); // Simpan ikon dalam session

        return redirect()->route('data-distribusi.index'); // Redirect ke halaman tujuan
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Distribusi $distribusi)
    {
        //
    }

    public function delete(string $id)
    {
        // Cari data yang akan dihapus berdasarkan ID
        $data = Distribusi::find($id);

        // Jika data tidak ditemukan, kembalikan respon dengan status 404 (Not Found)
        if (!$data) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        // Lakukan penghapusan data
        $data->delete();

        session()->flash('toast_message', 'Data berhasil dihapus'); // Simpan pesan dalam session
        session()->flash('toast_icon', 'success'); // Simpan ikon dalam session

        return redirect()->route('data-distribusi.index'); // Redirect ke halaman tujuan
    }
}
