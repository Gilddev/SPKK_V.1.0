<?php

namespace App\Http\Controllers;

use App\Models\IndikatorKinerjaIndividu;
use App\Models\IndikatorKinerjaUtama;
use App\Models\Unit;
use App\Models\UploadIku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Upload;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    function index(){ 
        return view('rolekaryawan.index');
    }

    public function table()
    {
        $indikators = IndikatorKinerjaIndividu::where('unit_id', Auth::user()->unit_id)->get();
        return view('rolekaryawan.table', compact('indikators'));
    }

    // ----------------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function upload_Iki()
    {

        // Ambil unit_id karyawan yang sedang login
        $unitId = Auth::user()->unit_id;

        // Ambil indikator yang sesuai dengan unit karyawan
        $indikators = IndikatorKinerjaIndividu::where('unit_id', $unitId)->get();

        // Ambil semua file yang sudah diupload
        // $uploads = Upload::with('indikator')->get();
        $uploads = Upload::where('id', auth::id())
                    ->with('indikator')
                    ->get();

        return view('rolekaryawan.upload_iki', compact('indikators', 'uploads'));
    }

    public function store_Iki(Request $request)
    {

        // dd($request->all()); 

        $request->validate([
            'indikator_id' => 'required|exists:indikator_kinerja_individus,indikator_id',
            'file' => 'required|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $userName = Auth::user()->name; // Ambil data user yang login
        $indikator = IndikatorKinerjaIndividu::find($request->indikator_id);

        if (!$indikator) {
            return back()->with('error', 'Indikator tidak ditemukan.');
        }
    
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension(); // Ambil ekstensi file
    
            // Format nama file: id indikator-unit-tanggal-waktu-userID.ext
            $fileName = strtolower(str_replace(' ', '_', $indikator->unit->nama_unit)) . '-' . 
                        $userName . '-' . 
                        strtolower(str_replace(' ', '_', $indikator->indikator_id)) . '-' . 
                        now()->format('Y-m-d-H-i-s') . '.' . 
                        $extension;
    
            // Simpan ke storage Laravel (storage/app/public/uploads)
            $filePath = $file->storeAs('uploads', $fileName, 'public');

        Upload::create([
            'id' => Auth::id(),
            'indikator_id' => $request->indikator_id,
            'file_path' => $filePath,
        ]);

        return redirect()->back()->with('success', 'File berhasil diupload');
        }
        return redirect()->back()->with('error', 'Gagal mengupload file');
    }

    // Fungsi untuk menampilkan preview
    public function preview_Iki($upload_id)
    {
        $upload = Upload::findOrFail($upload_id);

        // Cek apakah file benar-benar ada
        if (!Storage::disk('public')->exists($upload->file_path)) {
            abort(404, 'File tidak ditemukan');
        }
        return response()->file(storage_path('app/public/' . $upload->file_path));
        // return response()->file(storage_path($upload->file_path));
    }

    // Fungsi untuk menghapus file
    public function destroy_Iki($upload_id)
    {
        $upload = Upload::findOrFail($upload_id);

        // Hapus file dari storage
        // Storage::disk('public')->delete('uploads/' . $upload->file_path);
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

        // Ambil indikator yang sesuai dengan unit karyawan
        $indikators = IndikatorKinerjaUtama::all();

        // Ambil semua file yang sudah diupload
        // $uploads = Upload::with('indikator')->get();
        $uploads = UploadIku::where('id', auth::id())
                    ->with('indikator_utama')
                    ->get();

        return view('rolekaryawan.upload_iku', compact('indikators', 'uploads'));
    }

    // Fungsi untuk menyimpan
    public function store_Iku(Request $request)
    {

        // dd($request->all()); 

        $request->validate([
            'iku_id' => 'required|exists:indikator_kinerja_utamas,iku_id',
            'file' => 'required|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $userName = Auth::user()->name; // Ambil data user yang login
        $indikator = IndikatorKinerjaUtama::find($request->iku_id);

        if (!$indikator) {
            return back()->with('error', 'Indikator tidak ditemukan.');
        }
    
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension(); // Ambil ekstensi file
    
            // Format nama file: id indikator-unit-tanggal-waktu-userID.ext
            $fileName = $userName . '-' . 
                        strtolower(str_replace(' ', '_', $indikator->iku_id)) . '-' . 
                        now()->format('Y-m-d-H-i-s') . '.' . 
                        $extension;
    
            // Simpan ke storage Laravel (storage/app/public/uploads)
            $filePath = $file->storeAs('uploads', $fileName, 'public');

        UploadIku::create([
            'id' => Auth::id(),
            'iku_id' => $request->iku_id,
            'file_path' => $filePath,
        ]);

        return redirect()->back()->with('success', 'File berhasil diupload');
        }
        return redirect()->back()->with('error', 'Gagal mengupload file');
    }

    // Fungsi untuk menampilkan preview
    public function preview_Iku($upload_iku_id)
    {
        $upload = UploadIku::findOrFail($upload_iku_id);

        // Cek apakah file benar-benar ada
        if (!Storage::disk('public')->exists($upload->file_path)) {
            abort(404, 'File tidak ditemukan');
        }
        // return response()->file(Storage::url($upload->file_path));
        return response()->file(storage_path('app/public/' . $upload->file_path));
        // return response()->file(storage_path($upload->file_path));
    }

    // Fungsi untuk menghapus file
    public function destroy_Iku($upload_iku_id)
    {
        $upload = UploadIku::findOrFail($upload_iku_id);

        // Hapus file dari storage
        Storage::disk('public')->delete($upload->file_path);

        // Hapus record dari database
        $upload->delete();

        return back()->with('success', 'File berhasil dihapus.');
    }
}
