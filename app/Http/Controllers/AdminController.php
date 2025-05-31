<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Unit;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard(){
        return view('roleadmin.dashboard');
    }

    // function USERS ==================================================================================================================================================================================================================

    public function userIndex(){
        $users = User::with('jabatan','unit')->paginate(20);
        $units = Unit::all();
        $jabatans = Jabatan::all();
        return view('roleadmin.users.index', compact('users', 'units', 'jabatans'));
    }

    public function userShow(){
        //
    }

    public function userCreate(){
        $users = User::with('jabatan','unit')->get();
        $units = Unit::all();
        $jabatans = Jabatan::all();
        return view('roleadmin.users.create', compact('users', 'jabatans', 'units'));
    }

    public function userStore(Request $request){
        // dd($request->all());

        $request->validate([
            'nik'=>'required',
            'name'=>'required',
            'username'=>'required',
            'password'=>'required',
            'role'=>'required',
            'jabatan_id'=>'required',
            'unit_id'=>'required'
        ]);

        try {
            User::create([
                'nik'=>$request->nik,
                'name'=>$request->name,
                'username'=>$request->username,
                'password'=>bcrypt($request->password),
                'role'=>$request->role,
                'jabatan_id'=>$request->jabatan_id,
                'unit_id'=>$request->unit_id
            ]);
            return redirect()->back()->with('success', 'User berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'User gagal ditambahkan');
        }
        
    }

    public function userEdit($id){
        $users = User::findOrFail($id);
        $jabatans = Jabatan::all();
        $units = Unit::all();
        return view('roleadmin.users.edit', compact('users', 'jabatans', 'units'));
    }

    public function userUpdate(Request $request, $id){
        $user = User::findOrFail($id);

        $request->validate([
            'nik' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'role' => 'required|in:admin,validator,karyawan',
            'jabatan_id' => 'nullable|exists:jabatans,id',
            'unit_id' => 'nullable|exists:units,id',
        ]);

        try {
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
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function userDelete($id){
        $users = User::find($id);

        if (!$users) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }
        try {
            $users->delete();
            return redirect()->back()->with('success', 'User berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    // function UNITS ==================================================================================================================================================================================================================

    public function unitIndex(){
        $units = Unit::all();
        return view('roleadmin.units.index', compact( 'units'));
    }

    public function unitShow(){
        //
    }

    public function unitCreate(){
        $units = Unit::all();
        return view('roleadmin.units.create', compact('units'));
    }

    public function unitStore(Request $request){
        // dd($request->all());

        $request->validate([
            'kode_unit'=>'required',
            'nama_unit'=>'required',
        ]);

        try {
            Unit::create([
                'kode_unit'=>$request->kode_unit,
                'nama_unit'=>$request->nama_unit,
            ]);
            return redirect()->back()->with('success', 'Unit berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function unitEdit($id){
        $units = Unit::findOrFail($id);
        return view('roleadmin.units.edit', compact('units'));
    }

    public function unitUpdate(Request $request, $id){
        $unit = Unit::findOrFail($id);

        $request->validate([
            'kode_unit'=>'required',
            'nama_unit'=>'required',
        ]);

        try {
            $unit->kode_unit = $request->kode_unit;
            $unit->nama_unit = $request->nama_unit;

            $unit->save();

            return redirect()->back()->with('success', 'Unit berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function unitDelete($id){
        $unit = Unit::find($id);

        if (!$unit) {
            return redirect()->back()->with('error', 'Unit tidak ditemukan');
        }
        try {
            $unit->delete();
            return redirect()->back()->with('success', 'Unit berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    // function JABATANS ===============================================================================================================================================================================================================

    public function jabatanIndex(){
        $jabatans = Jabatan::all();
        return view('roleadmin.jabatans.index', compact('jabatans'));
    }

    public function jabatanShow(){
        //
    }

    public function jabatanCreate(){
        $jabatans = Jabatan::all();
        return view('roleadmin.jabatans.create', compact('jabatans'));
    }

    public function jabatanStore(Request $request){
        // dd($request->all());

        $request->validate([
            'nama_jabatan'=>'required',
        ]);

        try {
            Jabatan::create([
                'nama_jabatan'=>$request->nama_jabatan,
            ]);
            return redirect()->back()->with('success', 'Unit berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function jabatanEdit($id){
        $jabatans = Jabatan::findOrFail($id);
        return view('roleadmin.jabatans.edit', compact( 'jabatans'));
    }

    public function jabatanUpdate(Request $request, $id){
        $jabatan = Jabatan::findOrFail($id);

        $request->validate([
            'nama_jabatan'=>'required',
        ]);

        try {
            $jabatan->nama_jabatan = $request->nama_jabatan;

            $jabatan->save();

            return redirect()->back()->with('success', 'Jabatan berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function jabatanDelete($id){
        $jabatan = Jabatan::find($id);

        if (!$jabatan) {
            return redirect()->back()->with('error', 'Jabatan tidak ditemukan');
        }
        try {
            $jabatan->delete();
            return redirect()->back()->with('success', 'Jabatan berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    // function LAINNYA ===============================================================================================================================================================================================================

    // fungsi menampilkan laporan
    public function indexLaporan(){
        return view('roleadmin.laporan');
    }

    // fungsi filter laporan berdasarkan bulan dan tahun
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

    // fungsi cetak laporan
    public function cetakLaporan(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $rekapPenilaian = User::with(['rekapPenilaian' => function ($query) use ($bulan, $tahun) {
            $query->whereMonth('created_at', $bulan)->whereYear('created_at', $tahun);
        }])
        ->whereHas('unit') // Pastikan user memiliki unit kerja
        ->get()
        ->groupBy('unit.nama_unit'); // Mengelompokkan berdasarkan unit kerja

        return view('roleadmin.laporan_cetak', compact('rekapPenilaian', 'bulan', 'tahun'));
    }
}
