<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\User;

class ExportController extends Controller
{
    public function exportPdf(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $rekapPenilaian = User::with(['rekapPenilaian' => function ($query) use ($bulan, $tahun) {
            $query->whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahun);
        }])
        ->whereHas('unit')
        ->get()
        ->groupBy('unit.name');

        $pdf = Pdf::loadView('laporan.export-pdf', compact('rekapPenilaian', 'bulan', 'tahun'));
        return $pdf->download('Laporan_Penilaian_'.$bulan.'_'.$tahun.'.pdf');
    }
}
