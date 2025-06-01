<?php

namespace App\Http\Controllers;

use App\Models\Iki;
use App\Models\Iku;
use App\Models\RekapPenilaian;
use App\Models\User;
use App\Models\Unit;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;


class ValidatorController extends Controller
{

    public function dashboard(){
        // Ambil total karyawan dan validator
        $totalKaryawan = User::where('role', 'karyawan')->count();
        $totalValidator = User::where('role', 'validator')->count();

        // Ambil 5 karyawan dengan persentase kinerja tertinggi
        $top5Karyawan = RekapPenilaian::join('users', 'rekap_penilaians.user_id', '=', 'users.id')
            ->select('users.name', 'rekap_penilaians.persentase_kinerja')
            ->orderBy('persentase_kinerja', 'desc')
            ->limit(5)
            ->get();

        // Ambil 5 karyawan dengan persentase kinerja terendah
        $bottom5Karyawan = RekapPenilaian::join('users', 'rekap_penilaians.user_id', '=', 'users.id')
            ->select('users.name', 'rekap_penilaians.persentase_kinerja')
            ->orderBy('persentase_kinerja', 'asc')
            ->limit(5)
            ->get();

        return view('rolevalidator.dashboard', compact('totalKaryawan', 'totalValidator', 'top5Karyawan', 'bottom5Karyawan'));
    }

    // function IKI ===============================================================================================================================================================================================================

    public function ikiIndex(){
        $indikators = Iki::with('unit')->get();
        $units = Unit::all();
        return view('rolevalidator.ikis.index', compact('indikators', 'units'));
    }

    public function ikiShow(){
        //
    }

    public function ikiCreate(){
        $units = Unit::all();
        return view('rolevalidator.ikis.create', compact('units'));
    }

    public function ikiStore(Request $request){
        // dd($request->all());

        $request->validate([
            'deskripsi_indikator' => 'required|string|max:255',
            'indikator_keberhasilan' => 'required|string|max:255',
            'parameter' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
        ]);

        $unit = Unit::findOrFail($request->unit_id);

        // # Cara Pertama
        $jumlahIki = Iki::where('unit_id', $unit->id)->count();
        $kodeIki = $unit->kode_unit . '-' . ($jumlahIki + 1);

        // # Cara Kedua
        // Ambil kode_iki terakhir untuk unit ini
        // $lastIki = Iki::where('unit_id', $unit->id)
        //     ->where('kode_iki', 'like', $unit->kode_unit . '-%')
        //     ->orderByDesc('id')
        //     ->first();

        // if ($lastIki) {
        //     // Ambil angka dari kode_iki terakhir, contoh: "IT-3" => ambil 3
        //     $lastNumber = (int) str_replace($unit->kode_unit . '-', '', $lastIki->kode_iki);
        //     $nextNumber = $lastNumber + 1;
        // } else {
        //     $nextNumber = 1;
        // }

        // $kodeIki = $unit->kode_unit . '-' . $nextNumber;

        // # Cara Ketiga
        // $last = $unit->last_kode_iki ?? 0;
        // $next = $last + 1;
        // $kodeIki = $unit->kode_unit . '-' . $next;

        try {
            Iki::create([
                'kode_iki' => $kodeIki,
                'deskripsi_indikator' => $request->deskripsi_indikator,
                'indikator_keberhasilan' => $request->indikator_keberhasilan,
                'parameter' => $request->parameter,
                'unit_id' => $request->unit_id,
            ]);

            // Update angka terakhir
            // $unit->update(['last_kode_iki' => $next]);

            return redirect()->back()->with('success', 'Indikator berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        } 
    }

    public function ikiEdit($id){
        $indikators = Iki::findOrFail($id);
        $units = Unit::all(); // Ambil semua unit untuk pilihan dropdown

        return view('rolevalidator.ikis.edit', compact('indikators', 'units'));
    }

    public function ikiUpdate(Request $request, $id){
        $request->validate([
            'deskripsi_indikator' => 'required|string|max:255',
            'indikator_keberhasilan' => 'required|string|max:255',
            'parameter' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id'
        ]);

        try {
            $indikator = Iki::findOrFail($id);
            $indikator->update([
                'deskripsi_indikator' => $request->deskripsi_indikator,
                'indikator_keberhasilan' => $request->indikator_keberhasilan,
                'parameter' => $request->parameter,
                'unit_id' => $request->unit_id
            ]);

            return redirect()->back()->with('success', 'Indikator berhasil diperbarui!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }
    
    public function ikiDelete($id){
        try {
            $indikator = Iki::findOrFail($id);
            $indikator->delete();

            return redirect()->back()->with('success', 'Indikator berhasil dihapus!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
        
    }

    // function IKU ===============================================================================================================================================================================================================

    public function ikuIndex(){
        $indikators = Iku::all();
        return view('rolevalidator.ikus.index', compact('indikators'));
    }

    public function ikuShow(){
        //
    }

    public function ikuCreate(){
        return view('rolevalidator.ikus.create');
    }

    public function ikuStore(Request $request){
        // dd($request->all());

        $request->validate([
            'deskripsi_indikator' => 'required|string|max:255',
            'indikator_keberhasilan' => 'required|string|max:255',
            'parameter' => 'required|string|max:255',
            'berulang' => 'required'
        ]);

        try {
            Iku::create([
                'deskripsi_indikator' => $request->deskripsi_indikator,
                'indikator_keberhasilan' => $request->indikator_keberhasilan,
                'parameter' => $request->parameter,
                'berulang' => $request->berulang,
            ]);

            return redirect()->back()->with('success', 'Indikator berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function ikuEdit($id){
        $indikators = Iku::findOrFail($id);

        return view('rolevalidator.ikus.edit', compact('indikators'));
    }

    public function ikuUpdate(Request $request, $id){
        // dd($request->all());

        $request->validate([
            'deskripsi_indikator' => 'required|string|max:255',
            'indikator_keberhasilan' => 'required|string|max:255',
            'parameter' => 'required|string|max:255',
            'berulang' => 'required'
        ]);

        try {
            $indikator = Iku::findOrFail($id);
            $indikator->update([
                'deskripsi_indikator' => $request->deskripsi_indikator,
                'indikator_keberhasilan' => $request->indikator_keberhasilan,
                'parameter' => $request->parameter,
                'berulang' => $request->berulang,
            ]);
    
            return redirect()->back()->with('success', 'Indikator berhasil diperbarui!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function ikuDelete($id){
        try {
            $indikator = Iku::findOrFail($id);
            $indikator->delete();

            return redirect()->back()->with('success', 'Indikator berhasil dihapus!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }
    
    public function laporan(){
        $users = User::with('jabatan','unit')->get();
        $units = Unit::all();
        $jabatans = Jabatan::all();
        
        // Ambil data rekap penilaian karyawan berdasarkan unit
        $rekapPenilaian = User::where('role', 'karyawan') // Hanya karyawan
            ->with(['rekapPenilaian', 'unit']) // Ambil relasi dengan rekap penilaian dan unit kerja
            ->get()
            ->groupBy('unit.nama_unit'); // Kelompokkan berdasarkan unit kerja
        
        return view('rolevalidator.laporan', compact('users', 'units', 'jabatans', 'rekapPenilaian'));
    }

    public function filterRekap(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        // Query untuk filter berdasarkan bulan & tahun
        $rekapPenilaian = User::with(['rekapPenilaian' => function ($query) use ($bulan, $tahun) {
            if ($bulan) {
                $query->whereMonth('created_at', $bulan);
            }
            if ($tahun) {
                $query->whereYear('created_at', $tahun);
            }
        }])->where('role', 'karyawan')->get()->groupBy('unit.nama_unit');

        return view('rolevalidator.laporan', compact('rekapPenilaian', 'bulan', 'tahun'));
    }

    // Fungsi menampilkan chart
    public function grafikKinerja()
    {
        // Ambil total karyawan
        $totalKaryawan = User::count();

        // Ambil data persentase kinerja setiap karyawan
        $karyawanData = RekapPenilaian::join('users', 'rekap_penilaians.user_id', '=', 'users.id')
            ->select('users.name', 'rekap_penilaians.persentase_kinerja')
            ->orderBy('persentase_kinerja', 'desc')
            ->get();

        return view('rolevalidator.dashboard', compact('totalKaryawan', 'karyawanData'));
    }
    //------------------------------------------------------------------------------------------------------------
    
    // fungsi export ke excel
    public function excel(){
        $now = Carbon::now()->locale('id')->isoFormat('dddd-DD-MM-YYYY-HH_mm');
        $filename = 'spkk-' . $now . '.xlsx';

        return Excel::download(new UsersExport, $filename);
    }
}


