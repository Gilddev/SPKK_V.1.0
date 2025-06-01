<?php

namespace App\Http\Controllers;

use App\Models\Iki;
use App\Models\Iku;
use App\Models\Jabatan;
use App\Models\Unit;
use App\Models\UploadIku;
use App\Models\Upload;
use App\Models\User;
use App\Models\PenilaianIku;
use App\Models\PenilaianIki;
use App\Models\RekapPenilaianIku;
use App\Http\Controllers\RekapPenilaianController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\redirect;
use App\Models\RekapPenilaian;
use App\Models\UploadIki;

class ValidationController extends Controller
{
    public function index_iku(){
        $dataKaryawan = User::with('jabatan', 'unit','uploadIku')
                    -> where('role', 'karyawan')
                    -> get() // ambil semua data karyawan dengan role karyawan beserta relasi jabatan dan unit (metode chaining query)
                    ->groupBy('unit.nama_unit'); // Kelompokkan berdasarkan unit kerja
         
        $unit = Unit::all();
        $jabatan = Jabatan::all();
        return view('validation.index_iku', compact('dataKaryawan', 'unit', 'jabatan'));
    }

    public function index_iki(){
        $dataKaryawan = User::with('jabatan', 'unit', 'uploadIki')
                    -> where('role', 'karyawan')
                    -> get() // ambil semua data karyawan dengan role karyawan beserta relasi jabatan dan unit (metode chaining query)
                    ->groupBy('unit.nama_unit'); // Kelompokkan berdasarkan unit kerja
                    
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

        return view('rolevalidator.laporan', compact('rekapPenilaian', 'bulan', 'tahun'));
    }

    public function show_iku($id){    
        // Ambil data karyawan
        $karyawan = User::findOrFail($id);

        // Ambil semua indikator
        $indikator = Iku::all();

        // Ambil semua file yang diupload oleh karyawan ini
        $uploads = UploadIku::where('user_id', $id)->get();

        $penilaian = PenilaianIku::where('user_id', $id)->get();

        return view('validation.assessment_iku', compact('karyawan', 'indikator', 'uploads', 'penilaian'));
        // return view('validation.assessment_iku', compact('karyawan', 'indikator', 'uploads'));
    }

    public function show_iki($id){    
        // Ambil data karyawan
        $karyawan = User::findOrFail($id);

        // Ambil semua indikator dengan kriteria
        $indikator = Iki::where('unit_id', $karyawan->unit_id)->get();

        // Ambil semua file yang diupload oleh karyawan ini
        $uploads = UploadIki::where('user_id', $id)->get();

        $penilaian = PenilaianIki::where('user_id', $id)->get();

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
        $upload = UploadIki::findOrFail($upload_id);

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
            'user_id' => 'required|exists:users,id',
            'iku_id'=> 'required',
            'status'      => 'required|in:valid'
        ]);

        // Simpan data ke tabel penilaian_ikus
        // Jika penilaian sudah ada untuk indikator dan karyawan yang sama, Anda bisa menolak atau mengupdate data
        $existing = PenilaianIku::where('iku_id', $request->iku_id)
                    ->where('user_id', $request->user_id) // 'id' di sini menyimpan ID karyawan yang dinilai
                    ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Penilaian untuk indikator ini sudah ada.');
        }

        PenilaianIku::create([
            'user_id' => $request->user_id, 
            'iku_id' => $request->iku_id,
            'status' => 'valid',
        ]);

        // dd($request->karyawan_id);

        // Panggil fungsi update rekap
        (new RekapPenilaianController)->updateRekapPenilaian($request->user_id);

        return back()->with('success', 'Penilaian berhasil disimpan.');
    }

    public function storePenilaian_iki(Request $request)
    {
        // Validasi data yang dikirim
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'iki_id'=> 'required',
            'status'      => 'required|in:valid'
        ]);

        // Simpan data ke tabel penilaian_ikus
        // Jika penilaian sudah ada untuk indikator dan karyawan yang sama, Anda bisa menolak atau mengupdate data
        $existing = PenilaianIki::where('iki_id', $request->iki_id)
                    ->where('user_id', $request->user_id) // 'id' di sini menyimpan ID karyawan yang dinilai
                    ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Penilaian untuk indikator ini sudah ada.');
        }

        PenilaianIki::create([
            'user_id' => $request->user_id, 
            'iki_id' => $request->iki_id,
            'status' => 'valid',
        ]);

        // Panggil fungsi update rekap
        (new RekapPenilaianController)->updateRekapPenilaian($request->user_id);

        return back()->with('success', 'Penilaian berhasil disimpan.');
    }

    public function deletePenilaian_iku($id)
    {
        // Ambil data indikator yang akan dihapus
        $penilaian = PenilaianIku::where('iku_id', $id)->first();
    
        // Cek apakah data ditemukan
        if (!$penilaian) {
            return back()->with('error', 'Penilaian tidak ditemukan.');
        }
    
        // Simpan ID karyawan untuk update rekap setelah penghapusan
        $idKaryawan = $penilaian->user_id; // ID karyawan, bukan ID indikator
    
        // Hapus hanya satu indikator
        PenilaianIku::where('iku_id', $id)->delete();
    
        // Perbarui rekap setelah menghapus
        $this->updateRekapPenilaian($idKaryawan);
    
        return back()->with('success', 'Penilaian berhasil dibatalkan.');
    }
    
    public function deletePenilaian_iki($id)
    {
        // Ambil data penilaian sebelum dihapus untuk mendapatkan ID karyawan
        $penilaian = PenilaianIki::where('iki_id', $id)->first();

        if (!$penilaian) {
            return back()->with('error', 'Data penilaian tidak ditemukan.');
        }

        // Simpan ID karyawan sebelum menghapus data
        $idKaryawan = $penilaian->user_id;

        // Hapus data penilaian
        PenilaianIki::where('iki_id', $id)->delete();

        // Perbarui data rekap penilaian setelah penghapusan
        $this->updateRekapPenilaian($idKaryawan);

        return back()->with('success', 'Penilaian berhasil dibatalkan.');
    }

    public function updateRekapPenilaian($idKaryawan)
    {
        $user = User::findOrFail($idKaryawan);

        // Ambil tahun dan bulan saat ini
        $tahun = now()->format('Y'); // contoh: 2025
        $bulan = now()->format('m'); // contoh: 05
        $periode = $tahun . $bulan;  // hasil: 202505

        // Hitung ulang indikator yang tersisa
        $totalIKU = Iku::count();
        $totalIKI = Iki::where('unit_id', $user->unit_id)->count();

        // Hitung jumlah valid indikator yang MASIH ADA setelah penghapusan
        $jumlahValidIKU = PenilaianIku::where('user_id', $idKaryawan)->where('status', 'valid')->count();
        $jumlahValidIKI = PenilaianIki::where('user_id', $idKaryawan)->where('status', 'valid')->count();
        
        // Perhitungan persentase valid masing-masing
        $persentaseValidIKU = ($totalIKU > 0) ? ($jumlahValidIKU / $totalIKU) * 100 : 0;
        $persentaseValidIKI = ($totalIKI > 0) ? ($jumlahValidIKI / $totalIKI) * 100 : 0;

        // Bobot Penilaian
        $bobotIKU = 0.2; // 20%
        $bobotIKI = 0.8; // 80%

        // Perhitungan Persentase Kinerja Gabungan
        $persentaseKinerja = ($persentaseValidIKU * $bobotIKU) + ($persentaseValidIKI * $bobotIKI);;

        // Simpan hasil perhitungan
        RekapPenilaian::updateOrCreate(
            ['user_id' => $idKaryawan], // ID karyawan
            [
                'periode_rekap' => $periode,
                'total_iku' => $totalIKU,
                'total_iki' => $totalIKI,
                'jumlah_valid_iku' => $jumlahValidIKU,
                'jumlah_valid_iki' => $jumlahValidIKI,
                'persentase_valid_iku' => $persentaseValidIKU,
                'persentase_valid_iki' => $persentaseValidIKI,
                'persentase_kinerja' => $persentaseKinerja
            ]
        );
    }
}
