<?php

namespace App\Http\Controllers;

use App\Models\IndikatorKinerjaUtama;
// use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndikatorKinerjaUtamaController extends Controller
{
    public function index()
    {
        // $indikator = IndikatorKinerjaUtama::with('unit')->get();
        // return view('rolevalidator.index', compact('indikator'));
    }

    public function create()
    {
        // $units = Unit::all();
        // return view('indikator.create', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'deskripsi_indikator' => 'required|string|max:255',
            'indikator_keberhasilan' => 'required|string|max:255',
            'parameter' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
            'berulang' => 'required'
        ]);
        dd($request);

        IndikatorKinerjaUtama::create([
            'deskripsi_indikator' => $request->deskripsi_indikator,
            'indikator_keberhasilan' => $request->indikator_keberhasilan,
            'parameter' => $request->parameter,
            'berulang' => $request->berulang,
            'id' => Auth::id(),
        ]);

        return redirect()->route('indikator.index')->with('success', 'Indikator berhasil ditambahkan.');
    }
}