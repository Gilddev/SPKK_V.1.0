<table>
    <thead>
        <tr>
            <th colspan="3" align="center">Data Persentase Kinerja</th>
        </tr>
        <tr>
            <th colspan="3"> cetak : {{ $date }}</th>
        </tr>
        <tr>
            {{-- <th>No</th>
            <th>Nama</th>
            <th>Total Iku</th>
            <th>Iku Valid</th>
            <th>Total Iki</th>
            <th>Iki Valid</th>
            <th>Persentase</th> --}}
            <th width="5" align="center">No</th>
            <th width="30" align="center">Nama</th>
            <th width="20" align="center">Role</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($user as $d)
            <tr>
                <td align="center">{{ $loop -> iteration }}</td>
                <td align="center">{{ $d -> name }}</td>
                <td align="center">{{ $d -> role }}</td>
            </tr>
        @endforeach
    </tbody>
</table>