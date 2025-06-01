@extends('layouts.validator')

@section('content')
<div class="container mt-3">

    {{-- @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif --}}

    <h2>Indikator Kinerja Utama</h2>
    <div class="mb-3">Nama : {{ $karyawan->name }}</div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Deskripsi Indikator</th>
                <th>File Upload</th>
                <th>Aksi</th>
                {{-- <th></th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($indikator as $index => $iku)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $iku->deskripsi_indikator }}</td>
                <td>
                    @php
                        $uploadedFile = $uploads->where('iku_id', $iku->id)->first();
                        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                        $fileIcons = [
                            'pdf' => 'icons/pdf-icon.png',
                            'doc' => 'icons/docx-icon.png',
                            'docx' => 'icons/docx-icon.png',
                            'xls' => 'icons/excel-icon.png',
                            'xlsx' => 'icons/excel-icon.png',
                            'ppt' => 'icons/ppt-icon.png',
                            'pptx' => 'icons/ppt-icon.png',
                        ];
                    @endphp
                
                    @if ($uploadedFile)
                        @php
                            $filePath = $uploadedFile->file_path;
                            $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                            $isImage = in_array(strtolower($fileExtension), $imageExtensions);
                            $iconPath = $fileIcons[$fileExtension] ?? 'icons/default-file-icon.png';

                            // Cek apakah penilaian sudah dilakukan oleh validator
                            $penilaianTersimpan = $penilaian->where('iku_id', $iku->id)->first();
                        @endphp
                
                        <a href="{{ route('validation.preview_iku', $uploadedFile->id) }}" target="_blank">
                            @if ($isImage)
                                <img src="{{ asset('storage/' . $filePath) }}" width="100" height="100" 
                                     style="object-fit: cover; border-radius: 8px;">
                            @else
                                <img src="{{ asset($iconPath) }}" width="100" height="100" alt="File">
                            @endif
                        </a>
                    @else
                        <span class="text-danger">Belum ada file</span>
                    @endif
                </td>

                <td>
                    @if ($uploadedFile) 
                        @if (!$penilaianTersimpan)
                            <!-- Jika belum ada penilaian, tampilkan tombol Valid -->
                            <form action="{{ route('validation.store_penilaian_iku') }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $karyawan->id }}">
                                <input type="hidden" name="iku_id" value="{{ $iku->id }}">
                                <input type="hidden" name="status" value="valid">
                                <button type="submit" class="btn btn-success">Valid</button>
                            </form>
                        @else
                            <!-- Jika sudah dinilai, tampilkan tombol Batal -->
                            {{-- <form action="{{ route('validation.delete_penilaian_iku', ['id' => $penilaianTersimpan->penilaian_iku_id, 'indikatorType' => 'iku']) }}" method="POST" style="display: inline;"> --}}
                            <form action="{{ route('validation.delete_penilaian_iku', $penilaianTersimpan->iku_id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Batal</button>
                            </form>
                            {{-- <a href="{{ route('validation.delete_penilaian_iku', ['id' => $karyawan->id, 'indikatorType' => 'iku']) }}" class="btn btn-danger">
                                Batal Validasi IKU
                            </a> --}}
                        @endif
                    @endif
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('validation.index_iku') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection