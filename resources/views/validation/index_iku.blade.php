@extends('layouts.validator')

@section('content')
<div class="container mt-3">
    <h2>Penilaian Indikator Kinerja Utama</h2>

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
        <a href="" class="btn btn-secondary">Reset</a>
    </form>
    
    {{-- <table class="table table-bordered">
        <thead>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Aksi</th>
        </thead>
        <tbody>
            @foreach ($dataKaryawan as $d)
            <tr>
                <td>{{ $d->name }}</td>
                <td>{{ $d->jabatan->nama_jabatan }}</td>
                <td>
                    @if ($d->uploadIku->count() > 0)
                        <a href="{{ route('validation.show_iku', $d->id) }}" class="btn btn-primary">Nilai</a>
                    @else
                        <span class="text-muted">Belum ada Inputan</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table> --}}

    @foreach($dataKaryawan as $unit => $karyawanList)
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
                            <th>Jabatan</th>
                            <th>Unit</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($karyawanList as $karyawan)
                            {{-- @if ($karyawan->dataKaryawan) --}}
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $karyawan->name }}</td>
                                    <td>{{ $karyawan->jabatan->nama_jabatan }}</td>
                                    <td>{{ $karyawan->unit->nama_unit }}</td>
                                    <td>
                                        @if ($karyawan->uploadIki->count() > 0)
                                            <a href="{{ route('validation.show_iku', $karyawan->id) }}" class="btn btn-primary">Nilai</a>
                                        @else
                                            <span class="text-muted">Belum ada Inputan</span>
                                        @endif
                                    </td>
                                </tr>
                            {{-- @endif --}}
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach

</div>
@endsection