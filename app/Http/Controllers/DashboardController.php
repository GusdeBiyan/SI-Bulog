<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use Illuminate\Http\Request;
use App\Models\Distribusi;
use App\Models\Kecamatan;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil total biaya dari data dengan status 'Selesai'
        $biayas = Distribusi::where('status', 'Selesai')->get();

        $distribusi_selesai =
            Distribusi::where('status', 'Selesai')->get()->count();

        // Inisialisasi total biaya
        $totalBiaya = 0;

        // Loop melalui setiap data biaya
        foreach ($biayas as $biaya) {
            // Bersihkan format dengan menghapus titik dan konversi ke angka
            $biayaAngka = (int) str_replace('.', '', $biaya->biaya);

            // Tambahkan ke total biaya
            $totalBiaya += $biayaAngka;
        }



        // Mengirimkan total biaya ke tampilan sebagai variabel
        return view('index', compact('totalBiaya', 'distribusi_selesai'));
    }

    public function chartData()
    {
        $kecamatans = Kecamatan::all();

        return response()->json($kecamatans);
    }

    public function grafikData()
    { // Ambil data biaya dari database dengan status 'selesai', diurutkan berdasarkan created_at secara ascending
        $biayas = Distribusi::where('status', 'Selesai')->orderBy('created_at', 'asc')->get();

        // Inisialisasi array untuk menyimpan data total biaya per bulan
        $totalBiayaPerBulan = [];

        // Loop melalui data biaya dan tambahkan biaya ke bulan yang sesuai dalam array
        foreach ($biayas as $biaya) {
            $bulan = $biaya->created_at->format('M'); // Ubah format tanggal menjadi format bulan (Jan, Feb, dll.)
            $biayaPerBulan = $biaya->biaya;

            // Ubah biaya menjadi tipe data numerik jika diperlukan
            $biayaPerBulanNumeric = is_numeric($biayaPerBulan) ? $biayaPerBulan : str_replace('.', '', $biayaPerBulan);

            // Jika bulan belum ada dalam array totalBiayaPerBulan, tambahkan entri baru
            if (!isset($totalBiayaPerBulan[$bulan])) {
                $totalBiayaPerBulan[$bulan] = $biayaPerBulanNumeric;
            } else {
                // Jika bulan sudah ada dalam array totalBiayaPerBulan, tambahkan biaya ke bulan yang sama
                $totalBiayaPerBulan[$bulan] += $biayaPerBulanNumeric;
            }
        }

        // Kirim respons JSON dengan data total biaya per bulan
        return response()->json($totalBiayaPerBulan);
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
    public function show(Dashboard $dashboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dashboard $dashboard)
    {
        //
    }
}
