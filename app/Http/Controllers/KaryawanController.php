<?php

namespace App\Http\Controllers;

use App\Models\Iki;
use App\Models\Iku;
use App\Models\Jabatan;
use App\Models\RekapPenilaian;
use App\Models\Unit;
use App\Models\UploadIku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UploadIki;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class KaryawanController extends Controller
{
    public function dashboard(){
        return view('rolekaryawan.dashboard');
    }

    public function laporan(){
        $userId = Auth::id();
        $user = Auth::user();
        $userUnit = Auth::user()->unit;
        $userJabatan = Auth::user()->jabatan;
        $rekap = RekapPenilaian::where('user_id', $userId)
            ->orderByDesc('periode_rekap')
            ->get();

        return view('rolekaryawan.laporan', compact('userId', 'rekap', 'user', 'userUnit', 'userJabatan'));
    }
    
    public function table()
    {
        $indikatorsIki = Iki::where('unit_id', Auth::user()->unit_id)->get();
        $indikatorsIku = Iku::all();
        return view('rolekaryawan.table', compact('indikatorsIki', 'indikatorsIku'));
    }
    
    public function setting(){
        return view('rolekaryawan.setting');
    }
    // ----------------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function upload_Iki()
    {
        // Ambil unit_id karyawan yang sedang login
        $unitId = Auth::user()->unit_id;

        // Ambil indikator yang sesuai dengan unit karyawan
        $indikators = Iki::where('unit_id', $unitId)->get();

        // Ambil semua file yang sudah diupload
        $uploads = UploadIki::where('user_id', Auth::id())
                    ->with('iki')
                    ->get();

        return view('rolekaryawan.upload_iki', compact('indikators', 'uploads'));
    }

    public function store_Iki(Request $request)
    {
        // dd($request->all()); 

        $request->validate([
            'iki_id' => 'required',
            'file' => 'required|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $userId = Auth::user()->id;
        $userName = Auth::user()->name;
        $unitId = Auth::user()->unit_id;
        $indikator = Iki::find($request->iki_id);
        
        if (!$indikator) {
            return back()->with('error', 'Indikator tidak ditemukan.');
        }
        
        // Ambil tahun dan bulan saat ini
        $tahun = now()->format('Y'); // contoh: 2025
        $bulan = now()->format('m'); // contoh: 05
        $periode = $tahun . $bulan;  // hasil: 202505

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension(); // Ambil ekstensi file
    
            // Format nama file: id indikator-unit-tanggal-waktu-userID.ext
            $fileName = 'iki' . '-' . strtolower(str_replace(' ', '_', $indikator->unit->nama_unit)) . '-' . 
                        $userName . '-' . 
                        strtolower(str_replace(' ', '_', $indikator->id)) . '-' . 
                        now()->format('Y-m-d-H-i-s') . '.' . 
                        $extension;
    
            // Simpan ke storage Laravel (storage/app/public/uploads)
            $filePath = $file->storeAs("uploads/iki/{$tahun}/{$bulan}/{$unitId}/{$userId}", $fileName, 'public');

        UploadIki::create([
            'periode_penilaian' => $periode,
            'unit_id' => $unitId,
            'user_id' => Auth::id(),
            'iki_id' => $request->iki_id,
            'file_path' => $filePath,
        ]);

        return redirect()->back()->with('success', 'File berhasil diupload');
        }
        return redirect()->back()->with('error', 'Gagal mengupload file');
    }

    // Fungsi untuk menampilkan preview
    public function preview_Iki($id)
    {
        $upload = UploadIki::findOrFail($id);

        // Cek apakah file benar-benar ada
        if (!Storage::disk('public')->exists($upload->file_path)) {
            abort(404, 'File tidak ditemukan');
        }
        return response()->file(storage_path('app/public/' . $upload->file_path));
        // return response()->file(storage_path($upload->file_path));
    }

    // Fungsi untuk menghapus file
    public function destroy_Iki($id)
    {
        $upload = UploadIki::findOrFail($id);

        // Hapus file dari storage
        Storage::disk('public')->delete($upload->file_path);

        // Hapus record dari database
        $upload->delete();

        return back()->with('success', 'File berhasil dihapus.');
    }

    // ----------------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function upload_Iku()
    {

        // Ambil unit_id karyawan yang sedang login
        $unitId = Auth::user()->unit_id;

        // Ambil indikator
        $indikators = Iku::all();

        // Ambil semua file yang sudah diupload
        $uploads = UploadIku::where('user_id', Auth::id())
                    ->with('iku')
                    ->get();

        return view('rolekaryawan.upload_iku', compact('indikators', 'uploads'));
    }

    // Fungsi untuk menyimpan
    public function store_Iku(Request $request)
    {
        // dd($request->all()); 

        $request->validate([
            'iku_id' => 'required',
            'file' => 'required|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $userId = Auth::user()->id;
        $userName = Auth::user()->name;
        $unitId = Auth::user()->unit_id;
        $indikator = Iku::find($request->iku_id);

        if (!$indikator) {
            return back()->with('error', 'Indikator tidak ditemukan.');
        }

        // Ambil tahun dan bulan saat ini
        $tahun = now()->format('Y'); // contoh: 2025
        $bulan = now()->format('m'); // contoh: 05
        $periode = $tahun . $bulan;  // hasil: 202505
    
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension(); // Ambil ekstensi file

            // Format nama file: id indikator-unit-tanggal-waktu-userID.ext
            $fileName = 'iku' . '-' . 
                        $userName . '-' . 
                        strtolower(str_replace(' ', '_', $indikator->id)) . '-' . 
                        now()->format('Y-m-d-H-i-s') . '.' . 
                        $extension;
    
            // Simpan ke storage Laravel (storage/app/public/uploads)
            $filePath = $file->storeAs("uploads/iku/{$tahun}/{$bulan}/{$unitId}/{$userId}", $fileName, 'public');

            try {
                UploadIku::create([
                    'periode_penilaian' => $periode,
                    'user_id' => Auth::id(),
                    'iku_id' => $request->iku_id,
                    'file_path' => $filePath,
                ]);

                return redirect()->back()->with('success', 'File berhasil diupload');
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
            }
        
        }
        return redirect()->back()->with('error', 'Gagal mengupload file');
    }

    // Fungsi untuk menampilkan preview
    public function preview_Iku($id)
    {
        $upload = UploadIku::findOrFail($id);

        // Cek apakah file benar-benar ada
        if (!Storage::disk('public')->exists($upload->file_path)) {
            abort(404, 'File tidak ditemukan');
        }
        // return response()->file(Storage::url($upload->file_path));
        return response()->file(storage_path('app/public/' . $upload->file_path));
        // return response()->file(storage_path($upload->file_path));
    }

    // Fungsi untuk menghapus file
    public function destroy_Iku($id)
    {
        $upload = UploadIku::findOrFail($id);

        // Hapus file dari storage
        Storage::disk('public')->delete($upload->file_path);

        // Hapus record dari database
        $upload->delete();

        return back()->with('success', 'File berhasil dihapus.');
    }
}
