@extends('layouts.validator')

@section('content')
<div class="container">
    <div class="mt-3 m-3 text-center">Selamat datang di halaman validator. Pilih menu di navbar untuk mengelola sistem.</div>

    <form action="{{ route('validator.filter_table') }}" method="GET" class="mb-3 d-flex gap-2">
        <!-- Dropdown Bulan -->
        <select name="bulan" class="form-control w-auto">
            <option value="">Pilih Bulan</option>
            @foreach(range(1, 12) as $m)
                <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                    {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                </option>
            @endforeach
        </select>
    
        <!-- Dropdown Tahun -->
        <select name="tahun" class="form-control w-auto">
            <option value="">Pilih Tahun</option>
            @foreach(range(date('Y'), date('Y')) as $y)
                <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endforeach
        </select>
    
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('validator.index') }}" class="btn btn-secondary">Reset</a>
    </form>    

    @foreach($rekapPenilaian as $unit => $karyawanList)
        <div class="card mb-4">
            <div class="card-header">
                <h5>{{ $unit }}</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th>Total IKU</th>
                            <th>Total IKI</th>
                            <th>Jumlah Valid</th>
                            <th>Persentase Kinerja</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach($karyawanList as $karyawan)
                            @if ($karyawan->rekapPenilaian)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $karyawan->name }}</td>
                                    <td>{{ $karyawan->rekapPenilaian->total_iku ?? 0 }}</td>
                                    <td>{{ $karyawan->rekapPenilaian->total_iki ?? 0 }}</td>
                                    <td>{{ $karyawan->rekapPenilaian->jumlah_valid ?? 0 }}</td>
                                    <td>{{ $karyawan->rekapPenilaian->persentase_valid ?? 0 }}%</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>
@endsection