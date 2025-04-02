<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenilaianIKU;
use App\Models\PenilaianIKI;
use App\Models\User;

class PenilaianController extends Controller
{
    // public function index() {
    //     $karyawan = User::where('role', 'karyawan')->get();
    //     return view('validasi.index', compact('karyawan'));
    // }

    // public function show($id) {
    //     $karyawan = User::findOrFail($id);
    //     $penilaian_iku = PenilaianIKU::where('karyawan_id', $id)->with('iku')->get();
    //     $penilaian_iki = PenilaianIKI::where('karyawan_id', $id)->with('iki')->get();
    //     // dd($karyawan, $penilaian_iku, $penilaian_iki);
    //     return view('validasi.show', compact('karyawan', 'penilaian_iku', 'penilaian_iki'));
    // }

    // public function update(Request $request, $iki_id) {
    //     $request->validate([
    //         'status' => 'required|in:valid,tidak valid',
    //         'catatan' => 'nullable|string'
    //     ]);

    //     if (PenilaianIKU::where('id', $iki_id)->exists()) {
    //         $penilaian = PenilaianIKU::findOrFail($iki_id);
    //     } elseif (PenilaianIKI::where('id', $iki_id)->exists()) {
    //         $penilaian = PenilaianIKI::findOrFail($iki_id);
    //     } else {
    //         return redirect()->back()->with('error', 'Data tidak ditemukan!');
    //     }

    //     $penilaian->update([
    //         'status' => $request->status,
    //         'catatan' => $request->catatan,
    //     ]);

    //     return redirect()->back()->with('success', 'Penilaian berhasil disimpan.');
    // }
}
