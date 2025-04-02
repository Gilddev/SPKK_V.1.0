@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4 mt-4">Laporan Penilaian Kinerja</h2>

    <form action="{{ route('admin.laporan.cetak') }}" method="GET" target="_blank">
        <div class="row">
            <div class="col-md-5">
                <label for="bulan">Bulan:</label>
                <select name="bulan" id="bulan" class="form-control">
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div>

            <div class="col-md-5">
                <label for="tahun">Tahun:</label>
                <select name="tahun" id="tahun" class="form-control">
                    @for ($i = date('Y'); $i >= 2025; $i--)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="col-md-2">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary btn-block">Cetak Laporan</button>
            </div>
        </div>
    </form>
</div>
@endsection
