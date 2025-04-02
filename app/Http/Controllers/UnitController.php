<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allunit = Unit::all();
        return view('unit.index', compact('allunit'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('unit.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // buat validasi
        $validatedData = $request->validate([
            'nama_unit' => 'required|max:20',
        ]);

        // simpan data
        Unit::create($validatedData);

        // redirect ke index unit
        return redirect()->route('unit.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        return view('unt.show', compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        return view('unit.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
         // buat validasi
         $validatedData = $request->validate([
            'nama_unit' => 'required|max:20',
        ]);

        // update data
        $unit->update($validatedData);

        // redirect ke index unit
        return redirect()->route('unit.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
        
        // redirect ke index unit
        return redirect()->route('unit.index');
    }
}
