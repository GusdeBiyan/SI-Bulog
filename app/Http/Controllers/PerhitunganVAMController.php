<?php

namespace App\Http\Controllers;

use App\Models\PerhitunganVAM;
use Illuminate\Http\Request;
use App\Models\Biaya;
use App\Models\Gudang;
use App\Models\Kecamatan;


class PerhitunganVAMController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $gudang = Gudang::all();
        $kecamatan = Kecamatan::all();
        $biaya = biaya::all();
        return view('optimasi-biaya.index', compact('gudang', 'kecamatan', 'biaya'));
        // dd($biaya);
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
    public function show(PerhitunganVAM $perhitunganVAM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerhitunganVAM $perhitunganVAM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PerhitunganVAM $perhitunganVAM)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerhitunganVAM $perhitunganVAM)
    {
        //
    }
}
