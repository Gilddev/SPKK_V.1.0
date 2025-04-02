@extends('layouts.karyawan')

@section('content')
<div class="container mt-3 mb-3">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h3>Upload Indikator Kinerja Utama</h3>
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
                {{-- <td>
                    @php
                        $filteredUploads = $uploads->where('iku_id', $d->iku_id);
                        // dd($uploads->all()); 
                    @endphp
    
                    @if($filteredUploads->isNotEmpty())
                        @foreach ($filteredUploads as $upload)
                            <a href="{{ route('karyawan.preview_Iku', $upload->upload_iku_id) }}" target="_blank">
                                <img src="{{ asset('storage/' . $upload->file_path) }}" width="100" height="100" style="object-fit: cover; border-radius: 8px;">
                            </a>
                            <form action="{{ route('karyawan.destroy_Iku', $upload->upload_iku_id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mt-2" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        @endforeach
                    @else
                        <span style="color: gray;">Belum ada file</span>
                    @endif
                </td> --}}

                <td>
                    @php
                        $filteredUploads = $uploads->where('iku_id', $d->iku_id);
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
                
                    @if ($filteredUploads->isNotEmpty())
                        @foreach ($filteredUploads as $upload)
                            @php
                                $filePath = $upload->file_path;
                                $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                                $isImage = in_array(strtolower($fileExtension), $imageExtensions);
                                $iconPath = $fileIcons[$fileExtension] ?? 'icons/default-file-icon.png';
                            @endphp
                
                            <a href="{{ route('karyawan.preview_Iku', $upload->upload_iku_id) }}" target="_blank">
                                @if ($isImage)
                                    <img src="{{ asset('storage/' . $filePath) }}" width="100" height="100" 
                                         style="object-fit: cover; border-radius: 8px;">
                                @else
                                    <img src="{{ asset($iconPath) }}" width="100" height="100" alt="File">
                                @endif
                            </a>
                
                            <form action="{{ route('karyawan.destroy_Iku', $upload->upload_iku_id) }}" method="POST" style="display: inline;">
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
                    <form action="{{ route('karyawan.upload_Iku') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="iku_id" value="{{ $d->iku_id }}">
                        <input type="file" name="file" class="form-control" required>
                        <button type="submit" class="btn btn-primary mt-2">Upload</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection