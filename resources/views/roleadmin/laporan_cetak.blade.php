@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4 mt-4">Laporan Penilaian Kinerja</h2>
    <p>Bulan: {{ $bulan }}, Tahun: {{ $tahun }}</p>

    @foreach($rekapPenilaian as $unit => $karyawanList)
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h5>{{ $unit }}</h5> <!-- Menampilkan nama unit kerja -->
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>Total IKU</th>
                        <th>Total IKI</th>
                        <th>IKU Valid</th>
                        <th>IKI Valid</th>
                        <th>Persentase Valid</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach($karyawanList as $karyawan)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $karyawan->name }}</td>
                        <td>{{ $karyawan->rekapPenilaian->total_iku ?? 0 }}</td>
                        <td>{{ $karyawan->rekapPenilaian->total_iki ?? 0 }}</td>
                        <td>{{ $karyawan->rekapPenilaian->jumlah_valid_iku ?? 0 }}</td>
                        <td>{{ $karyawan->rekapPenilaian->jumlah_valid_iki ?? 0 }}</td>
                        <td>{{ $karyawan->rekapPenilaian->persentase_valid ?? 0 }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endforeach
</div>
@endsection
