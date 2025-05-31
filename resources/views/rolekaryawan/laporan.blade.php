@extends('layouts.karyawan')
@section('content')
    <div class="container">
        <h2 class="mb-4 mt-4">Laporan Penilaian Kinerja</h2>

        <div class="row">
            <div class="col">
                <p>Nama : {{ $user->name }}</p>
                <p>Unit : {{ $userUnit->nama_unit}}</p>
                <p>Jabatan : {{ $userJabatan->nama_jabatan }}</p>
            </div>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Periode</th>
                        <th>Total IKI</th>
                        <th>Total IKU</th>
                        <th>Jumlah Valid IKI</th>
                        <th>Jumlah Valid IKU</th>
                        <th>Persentase Valid IKI</th>
                        <th>Persentase Valid IKU</th>
                        <th>Persentase Kinerja</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rekap as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->periode_rekap }}</td>
                        <td>{{ $item->total_iki }}</td>
                        <td>{{ $item->total_iku }}</td>
                        <td>{{ $item->jumlah_valid_iki }}</td>
                        <td>{{ $item->jumlah_valid_iku }}</td>
                        <td>{{ $item->persentase_valid_iki }}%</td>
                        <td>{{ $item->persentase_valid_iku }}%</td>
                        <td><strong>{{ $item->persentase_kinerja }}%</strong></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">Belum ada data rekap penilaian.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection