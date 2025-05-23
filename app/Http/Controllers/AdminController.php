<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    function index(){
        $users = User::with('jabatan','unit')->get();
        $units = Unit::all();
        $jabatans = Jabatan::all();
        
        // Ambil data rekap penilaian karyawan berdasarkan unit
        $rekapPenilaian = User::where('role', 'karyawan') // Hanya karyawan
        ->with(['rekapPenilaian', 'unit']) // Ambil relasi dengan rekap penilaian dan unit kerja
        ->get()
        ->groupBy('unit.nama_unit'); // Kelompokkan berdasarkan unit kerja
        
        return view('roleadmin.index', compact('users', 'units', 'jabatans', 'rekapPenilaian'));
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

        return view('roleadmin.index', compact('rekapPenilaian', 'bulan', 'tahun'));
    }       

    // menampilkan semua data user pada halaman tabel users
    function table(){
        $users = User::with('jabatan','unit')->paginate(20);
        $units = Unit::all();
        $jabatans = Jabatan::all();
        return view('roleadmin.table', compact('users', 'units', 'jabatans'));
    }

    // Menampilkan halaman tambah user
    public function create()
    {
        $users = User::with('jabatan','unit')->get();
        $units = Unit::all();
        $jabatans = Jabatan::all();
        return view('roleadmin.create', compact('users', 'jabatans', 'units'));
    }

    // Menyimpan data user baru
    public function store(Request $request){

        // dd($request->all());

        $request->validate([
            'name'=>'required',
            'username'=>'required',
            'password'=>'required',
            'role'=>'required',
            'jabatan_id'=>'required|exists:jabatans,jabatan_id',
            'unit_id'=>'required|exists:units,unit_id'
        ]);
        User::create([
            'name'=>$request->name,
            'username'=>$request->username,
            'password'=>bcrypt($request->password),
            'role'=>$request->role,
            'jabatan_id'=>$request->jabatan_id,
            'unit_id'=>$request->unit_id
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan');
    }

    // Menampilkan fungsi edit data user
    public function edit($id){
        $users = User::findOrFail($id); // Ambil user berdasarkan ID
        $jabatans = Jabatan::all(); // Ambil semua jabatan
        $units = Unit::all(); // Ambil semua unit

        return view('roleadmin.edit', compact('users', 'jabatans', 'units'));
    }

    // fungsi untuk menyimpan perubahan / update
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nik' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'role' => 'required|in:admin,validator,karyawan',
            'jabatan_id' => 'nullable|exists:jabatans,jabatan_id',
            'unit_id' => 'nullable|exists:units,unit_id',
        ]);

        // Update data user
        $user->nik = $request->nik;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->role = $request->role;
        $user->jabatan_id = $request->jabatan_id;
        $user->unit_id = $request->unit_id;

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'User berhasil diperbarui');
    }

    // fungsi untuk menghapus data user
    public function destroy($id)
    {
        $users = User::find($id);

        if (!$users) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        try {
            $users->delete();
            return redirect()->back()->with('success', 'User berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // fungsi menampilkan laporan
    public function indexLaporan(){
        return view('roleadmin.laporan');
    }
    // fungsi cetak laporan
    public function cetakLaporan(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $rekapPenilaian = User::with(['rekapPenilaian' => function ($query) use ($bulan, $tahun) {
            $query->whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahun);
        }])
        ->whereHas('unit') // Pastikan user memiliki unit kerja
        ->get()
        ->groupBy('unit.nama_unit'); // Mengelompokkan berdasarkan unit kerja

        return view('roleadmin.laporan_cetak', compact('rekapPenilaian', 'bulan', 'tahun'));
    }
}
