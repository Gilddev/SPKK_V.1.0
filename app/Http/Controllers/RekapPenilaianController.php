<?php

namespace App\Http\Controllers;

use App\Models\IndikatorKinerjaUtama;
use App\Models\IndikatorKinerjaIndividu;
use App\Models\PenilaianIku;
use App\Models\PenilaianIki;
use App\Models\RekapPenilaianIku;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\redirect;

class RekapPenilaianController extends Controller
{
    public function updateRekapPenilaian($id)
    {
        $user = User::findOrFail($id);

        // Hitung total indikator yang harus diisi oleh karyawan ini
        $totalIKU = IndikatorKinerjaUtama::count(); // Semua karyawan wajib mengisi IKU
        $totalIKI = IndikatorKinerjaIndividu::where('unit_id', $user->unit_id)->count(); // Berdasarkan unit kerja

        // Hitung jumlah valid untuk IKU dan IKI
        $jumlahValidIKU = PenilaianIku::where('id', $id)->where('status', 'valid')->count();
        $jumlahValidIKI = PenilaianIki::where('id', $id)->where('status', 'valid')->count();

        // Perhitungan persentase valid masing-masing
        $persentaseValidIKU = ($totalIKU > 0) ? ($jumlahValidIKU / $totalIKU) * 100 : 0;
        $persentaseValidIKI = ($totalIKI > 0) ? ($jumlahValidIKI / $totalIKI) * 100 : 0;

        // Bobot Penilaian
        $bobotIKU = 0.2; // 20%
        $bobotIKI = 0.8; // 80%

        // Perhitungan Persentase Kinerja Gabungan
        $persentaseKinerja = ($persentaseValidIKU * $bobotIKU) + ($persentaseValidIKI * $bobotIKI);

        // Simpan atau update rekap penilaian
        RekapPenilaianIku::updateOrCreate(
            ['id' => $id], // Berdasarkan ID Karyawan
            [
                'total_iku' => $totalIKU,
                'total_iki' => $totalIKI,
                'jumlah_valid_iku' => $jumlahValidIKU,
                'jumlah_valid_iki' => $jumlahValidIKI,
                'persentase_valid_iku' => $persentaseValidIKU,
                'persentase_valid_iki' => $persentaseValidIKI,
                'persentase_kinerja' => $persentaseKinerja
            ]
        );

        return redirect()->back()->with('success', 'Rekap penilaian berhasil diperbarui!');
    }
}
