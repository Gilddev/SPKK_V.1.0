<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Unit;
use App\Models\UploadIku;
use App\Models\Upload;
use App\Models\User;
use App\Models\IndikatorKinerjaUtama;
use App\Models\IndikatorKinerjaIndividu;
use App\Models\PenilaianIku;
use App\Models\PenilaianIki;
use App\Models\RekapPenilaianIku;
use App\Http\Controllers\RekapPenilaianController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\redirect;

class ValidationController extends Controller
{
    public function index_iku(){
        $dataKaryawan = User::with('jabatan', 'unit','uploadIku')
                    -> where('role', 'karyawan')
                    -> get(); // ambil semua data karyawan dengan role karyawan beserta relasi jabatan dan unit (metode chaining query)
         
        $unit = Unit::all();
        $jabatan = Jabatan::all();
        return view('validation.index_iku', compact('dataKaryawan', 'unit', 'jabatan'));
    }

    public function index_iki(){
        $dataKaryawan = User::with('jabatan', 'unit', 'uploadIki')
                    -> where('role', 'karyawan')
                    -> get(); // ambil semua data karyawan dengan role karyawan beserta relasi jabatan dan unit (metode chaining query)
        
        $unit = Unit::all();
        $jabatan = Jabatan::all();
        return view('validation.index_iki', compact('dataKaryawan', 'unit', 'jabatan'));
    }

    public function filter_iku(Request $request)
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

    public function show_iku($id){    
        // Ambil data karyawan
        $karyawan = User::findOrFail($id);

        // Ambil semua indikator
        $indikator = IndikatorKinerjaUtama::all();

        // Ambil semua file yang diupload oleh karyawan ini
        $uploads = UploadIku::where('id', $id)->get();

        $penilaian = PenilaianIku::where('id', $id)->get();

        return view('validation.assessment_iku', compact('karyawan', 'indikator', 'uploads', 'penilaian'));
        // return view('validation.assessment_iku', compact('karyawan', 'indikator', 'uploads'));
    }

    public function show_iki($id){    
        // Ambil data karyawan
        $karyawan = User::findOrFail($id);

        // Ambil semua indikator
        $indikator = IndikatorKinerjaIndividu::where('unit_id', $karyawan->unit_id)->get();

        // Ambil semua file yang diupload oleh karyawan ini
        $uploads = Upload::where('id', $id)->get();

        $penilaian = PenilaianIki::where('id', $id)->get();

        return view('validation.assessment_iki', compact('karyawan', 'indikator', 'uploads','penilaian'));
    }

    public function preview_iku($upload_iku_id){
        $upload = UploadIku::findOrFail($upload_iku_id);

        // Cek apakah file benar-benar ada
        if (!Storage::disk('public')->exists($upload->file_path)) {
            abort(404, 'File tidak ditemukan');
        }
        // return response()->file(Storage::url($upload->file_path));
        return response()->file(storage_path('app/public/' . $upload->file_path));
    }

    public function preview_iki($upload_id){
        $upload = Upload::findOrFail($upload_id);

        // Cek apakah file benar-benar ada
        if (!Storage::disk('public')->exists($upload->file_path)) {
            abort(404, 'File tidak ditemukan');
        }
        // return response()->file(Storage::url($upload->file_path));
        return response()->file(storage_path('app/public/' . $upload->file_path));
    }

    public function storePenilaian_iku(Request $request)
    {
        // Validasi data yang dikirim
        $request->validate([
            'karyawan_id' => 'required|exists:users,id',
            'iku_id'      => 'required|exists:indikator_kinerja_utamas,iku_id',
            'status'      => 'required|in:valid'
        ]);

        // Simpan data ke tabel penilaian_ikus
        // Jika penilaian sudah ada untuk indikator dan karyawan yang sama, Anda bisa menolak atau mengupdate data
        $existing = PenilaianIku::where('iku_id', $request->iku_id)
                    ->where('id', $request->karyawan_id) // 'id' di sini menyimpan ID karyawan yang dinilai
                    ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Penilaian untuk indikator ini sudah ada.');
        }

        PenilaianIku::create([
            'id' => $request->karyawan_id, 
            'iku_id' => $request->iku_id,
            'status' => 'valid',
        ]);

        // dd($request->karyawan_id);

        // Panggil fungsi update rekap
        (new RekapPenilaianController)->updateRekapPenilaian($request->karyawan_id);

        return back()->with('success', 'Penilaian berhasil disimpan.');
    }

    public function storePenilaian_iki(Request $request)
    {
        // Validasi data yang dikirim
        $request->validate([
            'karyawan_id' => 'required|exists:users,id',
            'indikator_id'=> 'required|exists:indikator_kinerja_individus,indikator_id',
            'status'      => 'required|in:valid'
        ]);

        // Simpan data ke tabel penilaian_ikus
        // Jika penilaian sudah ada untuk indikator dan karyawan yang sama, Anda bisa menolak atau mengupdate data
        $existing = PenilaianIki::where('indikator_id', $request->indikator_id)
                    ->where('id', $request->karyawan_id) // 'id' di sini menyimpan ID karyawan yang dinilai
                    ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Penilaian untuk indikator ini sudah ada.');
        }

        PenilaianIki::create([
            'id' => $request->karyawan_id, 
            'indikator_id' => $request->indikator_id,
            'status' => 'valid',
        ]);

        // Panggil fungsi update rekap
        (new RekapPenilaianController)->updateRekapPenilaian($request->karyawan_id);

        return back()->with('success', 'Penilaian berhasil disimpan.');
    }

    public function deletePenilaian_iku($penilaian_iku_id)
    {
        // Ambil data indikator yang akan dihapus
        $penilaian = PenilaianIku::where('penilaian_iku_id', $penilaian_iku_id)->first();
    
        // Cek apakah data ditemukan
        if (!$penilaian) {
            return back()->with('error', 'Penilaian tidak ditemukan.');
        }
    
        // Simpan ID karyawan untuk update rekap setelah penghapusan
        $idKaryawan = $penilaian->id; // ID karyawan, bukan ID indikator
    
        // Hapus hanya satu indikator
        PenilaianIku::where('penilaian_iku_id', $penilaian_iku_id)->delete();
    
        // Perbarui rekap setelah menghapus
        $this->updateRekapPenilaian($idKaryawan);
    
        return back()->with('success', 'Penilaian berhasil dibatalkan.');
    }
    
    public function deletePenilaian_iki($id)
    {
        // Ambil data penilaian sebelum dihapus untuk mendapatkan ID karyawan
        $penilaian = PenilaianIki::where('penilaian_iki_id', $id)->first();

        if (!$penilaian) {
            return back()->with('error', 'Data penilaian tidak ditemukan.');
        }

        // Simpan ID karyawan sebelum menghapus data
        $karyawanId = $penilaian->id;

        // Hapus data penilaian
        PenilaianIki::where('penilaian_iki_id', $id)->delete();

        // Perbarui data rekap penilaian setelah penghapusan
        $this->updateRekapPenilaian($karyawanId);

        return back()->with('success', 'Penilaian berhasil dibatalkan.');
    }

    public function updateRekapPenilaian($idKaryawan)
    {
        $user = User::findOrFail($idKaryawan);

        // Hitung ulang indikator yang tersisa
        $totalIKU = IndikatorKinerjaUtama::count();
        $totalIKI = IndikatorKinerjaIndividu::where('unit_id', $user->unit_id)->count();
        $totalIndikator = $totalIKU + $totalIKI;

        // Hitung jumlah valid indikator yang MASIH ADA setelah penghapusan
        $jumlahValidIKU = PenilaianIku::where('id', $idKaryawan)->where('status', 'valid')->count();
        $jumlahValidIKI = PenilaianIki::where('id', $idKaryawan)->where('status', 'valid')->count();
        
        $jumlahValid = $jumlahValidIKU + $jumlahValidIKI;
        $persentaseValid = ($totalIndikator > 0) ? ($jumlahValid / $totalIndikator) * 100 : 0;

        // Simpan hasil perhitungan
        RekapPenilaianIku::updateOrCreate(
            ['id' => $idKaryawan], // ID karyawan
            [
                'total_iku' => $totalIKU,
                'total_iki' => $totalIKI,
                'jumlah_valid' => $jumlahValid,
                'persentase_valid' => $persentaseValid
            ]
        );
    }
}
