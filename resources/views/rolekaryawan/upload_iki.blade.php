@extends('layouts.karyawan')

@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container mt-3 mb-3">
    <h3>Upload Indikator Kinerja Individu</h3>

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

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Deskripsi Indikator</th>
                <th>Preview</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($indikators as $d)
            <tr>
                <td>{{ $d->deskripsi_indikator }}</td>
                <!-- Filter file hanya yang sesuai dengan indikator -->
                <td>
                    @php
                        $filteredUploads = $uploads->where('indikator_id', $d->indikator_id);
                        // dd($uploads->all());
                    @endphp
    
                    @if($filteredUploads->isNotEmpty())
                        @foreach ($filteredUploads as $upload)
                            <a href="{{ route('karyawan.preview_Iki', $upload->upload_id) }}" target="_blank">
                                <img src="{{ asset('storage/' . $upload->file_path) }}" width="100" height="100" style="object-fit: cover; border-radius: 8px;">
                            </a>
                            <form action="{{ route('karyawan.destroy_Iki', $upload->upload_id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mt-2" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        @endforeach
                    @else
                        <span style="color: gray;">Belum ada file</span>
                    @endif
                </td>
    
                <td>
                    <form action="{{ route('karyawan.upload_Iki') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="indikator_id" value="{{ $d->indikator_id }}">

                        {{-- <label>Ambil File dari Perangkat</label> --}}
                        <input type="file" name="file" class="form-control" required>

                        <br>

                        {{-- <label>Ambil Foto dari Kamera</label>
                        <input type="file" name="camera_photo" class="form-control" accept="image/*" capture="environment"> --}}

                        <button type="submit" class="btn btn-primary mt-2">Upload</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection