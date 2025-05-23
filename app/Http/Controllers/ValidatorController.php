<?php

namespace App\Http\Controllers;

use App\Models\IndikatorKinerjaIndividu;
use App\Models\IndikatorKinerjaUtama;
use App\Models\RekapPenilaianIku;
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
    // fungsi menampilkan tampilan index/dashboard
    public function index(){
        // Ambil total karyawan dan validator
        $totalKaryawan = User::where('role', 'karyawan')->count();
        $totalValidator = User::where('role', 'validator')->count();

        // Ambil 5 karyawan dengan persentase kinerja tertinggi
        $top5Karyawan = RekapPenilaianIku::join('users', 'rekap_penilaian.id', '=', 'users.id')
            ->select('users.name', 'rekap_penilaian.persentase_kinerja')
            ->orderBy('persentase_kinerja', 'desc')
            ->limit(5)
            ->get();

        // Ambil 5 karyawan dengan persentase kinerja terendah
        $bottom5Karyawan = RekapPenilaianIku::join('users', 'rekap_penilaian.id', '=', 'users.id')
            ->select('users.name', 'rekap_penilaian.persentase_kinerja')
            ->orderBy('persentase_kinerja', 'asc')
            ->limit(5)
            ->get();

        return view('rolevalidator.index', compact('totalKaryawan', 'totalValidator', 'top5Karyawan', 'bottom5Karyawan'));
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

        return view('rolevalidator.index', compact('rekapPenilaian', 'bulan', 'tahun'));
    }

    function table_Iki(){
        $indikators = IndikatorKinerjaIndividu::with('unit')->get();
        $units = Unit::all();
        return view('rolevalidator.table_iki', compact('indikators', 'units'));
    }

    function table_Iku(){
        $indikators = IndikatorKinerjaUtama::all();
        return view('rolevalidator.table_iku', compact('indikators'));
    }

    // ----------------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function create_Iki()
    {
        $units = Unit::all();
        return view('rolevalidator.create_Iki', compact('units'));
    }

    public function store_Iki(Request $request)
    {

        // dd($request->all());

        $request->validate([
            'deskripsi_indikator' => 'required|string|max:255',
            'indikator_keberhasilan' => 'required|string|max:255',
            'parameter' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,unit_id',
        ]);

        IndikatorKinerjaIndividu::create([
            'deskripsi_indikator' => $request->deskripsi_indikator,
            'indikator_keberhasilan' => $request->indikator_keberhasilan,
            'parameter' => $request->parameter,
            'unit_id' => $request->unit_id,
            'id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Indikator berhasil ditambahkan');
    }

    // Tampilkan form edit
    public function edit_Iki($indikator_id)
    {
        $indikators = IndikatorKinerjaIndividu::findOrFail($indikator_id);
        $units = Unit::all(); // Ambil semua unit untuk pilihan dropdown

        return view('rolevalidator.edit_iki', compact('indikators', 'units'));
    }

    // Update indikator
    public function update_Iki(Request $request, $indikator_id)
    {
        $request->validate([
            'deskripsi_indikator' => 'required|string|max:255',
            'indikator_keberhasilan' => 'required|string|max:255',
            'parameter' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,unit_id'
        ]);

        $indikator = IndikatorKinerjaIndividu::findOrFail($indikator_id);
        $indikator->update([
            'deskripsi_indikator' => $request->deskripsi_indikator,
            'indikator_keberhasilan' => $request->indikator_keberhasilan,
            'parameter' => $request->parameter,
            'unit_id' => $request->unit_id
        ]);

        return redirect()->back()->with('success', 'Indikator berhasil diperbarui!');
    }

    // Hapus indikator
    public function destroy_Iki($indikator_id)
    {
        $indikator = IndikatorKinerjaIndividu::findOrFail($indikator_id);
        $indikator->delete();

        return redirect()->back()->with('success', 'Indikator berhasil dihapus!');
    }

    // ----------------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function create_Iku()
    {
        // $units = Unit::all();
        return view('rolevalidator.create_Iku');
    }

    public function store_Iku(Request $request)
    {

        // dd($request->all());

        $request->validate([
            'deskripsi_indikator' => 'required|string|max:255',
            'indikator_keberhasilan' => 'required|string|max:255',
            'parameter' => 'required|string|max:255',
            'berulang' => 'required'
        ]);

        IndikatorKinerjaUtama::create([
            'deskripsi_indikator' => $request->deskripsi_indikator,
            'indikator_keberhasilan' => $request->indikator_keberhasilan,
            'parameter' => $request->parameter,
            'berulang' => $request->berulang,
            'id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Indikator berhasil ditambahkan');
    }

    // Tampilkan form edit
    public function edit_Iku($iku_id)
    {
        $indikators = IndikatorKinerjaUtama::findOrFail($iku_id);
        // $units = Unit::all();

        return view('rolevalidator.edit_iku', compact('indikators'));
    }

    // Update indikator
    public function update_Iku(Request $request, $iku_id)
    {

        $request->validate([
            'deskripsi_indikator' => 'required|string|max:255',
            'indikator_keberhasilan' => 'required|string|max:255',
            'parameter' => 'required|string|max:255',
            'berulang' => 'required'
        ]);

        $indikator = IndikatorKinerjaUtama::findOrFail($iku_id);
        $indikator->update([
            'deskripsi_indikator' => $request->deskripsi_indikator,
            'indikator_keberhasilan' => $request->indikator_keberhasilan,
            'parameter' => $request->parameter,
            'berulang' => $request->berulang,
        ]);

        return redirect()->back()->with('success', 'Indikator berhasil diperbarui!');
    }

    // Hapus indikator
    public function destroy_Iku($iku_id)
    {
        $indikator = IndikatorKinerjaUtama::findOrFail($iku_id);
        $indikator->delete();

        return redirect()->back()->with('success', 'Indikator berhasil dihapus!');
    }

    // -------------------------------------------------------------------------------------------------------------

    // Fungsi menampilkan chart
    public function grafikKinerja()
    {
        // Ambil total karyawan
        $totalKaryawan = User::count();

        // Ambil data persentase kinerja setiap karyawan
        $karyawanData = RekapPenilaianIku::join('users', 'rekap_penilaian.id', '=', 'users.id')
            ->select('users.name', 'rekap_penilaian.persentase_kinerja')
            ->orderBy('persentase_kinerja', 'desc')
            ->get();

        return view('dashboard.grafik', compact('totalKaryawan', 'karyawanData'));
    }
    //------------------------------------------------------------------------------------------------------------
    
    // fungsi export ke excel
    public function excel(){
        $now = Carbon::now()->locale('id')->isoFormat('dddd-DD-MM-YYYY-HH_mm');
        $filename = 'spkk-' . $now . '.xlsx';

        return Excel::download(new UsersExport, $filename);
    }
}


