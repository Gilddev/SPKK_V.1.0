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
    // public function updateRekapPenilaian($id)
    // {
    //     $user = User::findOrFail($id);

    //     // Hitung total indikator yang harus diisi oleh karyawan ini
    //     $totalIKU = IndikatorKinerjaUtama::count();
    //     $totalIKI = IndikatorKinerjaIndividu::where('unit_id', $user->unit_id)->count();
    //     $totalIndikator = $totalIKU + $totalIKI;

    //     // Hitung jumlah valid dan tidak valid
    //     $jumlahValid = PenilaianIku::where('id', $id)->where('status', 'valid')->count();
    //     // $jumlahTidakValid = PenilaianIku::where('id', $id)->where('status', 'tidak valid')->count();

    //     // Hitung persentase valid
    //     $persentaseValid = ($totalIndikator > 0) ? ($jumlahValid / $totalIndikator) * 100 : 0;

    //     // Simpan atau update rekap penilaian
    //     RekapPenilaianIku::updateOrCreate(
    //         ['id' => $id],
    //         [
    //             'total_iku' => $totalIKU,
    //             'total_iki' => $totalIKI,
    //             'jumlah_valid' => $jumlahValid,
    //             // 'jumlah_tidak_valid' => $jumlahTidakValid,
    //             'persentase_valid' => $persentaseValid
    //         ]
    //     );
    // }

    public function updateRekapPenilaian($id)
    {
        $user = User::findOrFail($id);

        // Hitung total indikator yang harus diisi oleh karyawan ini
        $totalIKU = IndikatorKinerjaUtama::count(); // Semua karyawan wajib mengisi IKU
        $totalIKI = IndikatorKinerjaIndividu::where('unit_id', $user->unit_id)->count(); // Hanya berdasarkan unit karyawan
        $totalIndikator = $totalIKU + $totalIKI; // Total indikator yang harus diisi oleh karyawan

        // Hitung jumlah valid untuk IKU dan IKI
        $jumlahValidIKU = PenilaianIku::where('id', $id)->where('status', 'valid')->count();
        $jumlahValidIKI = PenilaianIki::where('id', $id)->where('status', 'valid')->count();
        
        // Total valid IKU + IKI
        $jumlahValid = $jumlahValidIKU + $jumlahValidIKI;

        // Hitung persentase valid
        $persentaseValid = ($totalIndikator > 0) ? ($jumlahValid / $totalIndikator) * 100 : 0;

        // Simpan atau update rekap penilaian
        RekapPenilaianIku::updateOrCreate(
            ['id' => $id], // Berdasarkan ID Karyawan
            [
                'total_iku' => $totalIKU,
                'total_iki' => $totalIKI,
                'jumlah_valid' => $jumlahValid,
                'persentase_valid' => $persentaseValid
            ]
        );

        return redirect()->back()->with('success', 'Rekap penilaian berhasil diperbarui!');
    }
}
