<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Tambah Karyawan</title>
</head>
<body>
    <div class="container">
        <h1>Tambah Karyawan</h1>
        <div class="nav">
            <ul>
                <li><a href="/unit">Unit</a></li>
            </ul>
        </div>
        <h3>Unit</h3>
        <a href="{{ route('unit.create' )}}" class="btn">Tambah</a>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Unit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- --}}
            </tbody>
        </table>
        <div class="footer">&copy; 2025 Agil D Sulistyo</div>
    </div>
</body>
</html>