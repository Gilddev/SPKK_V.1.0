<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>Halaman Login | SPKK</title>
    {{-- i take the style of login from https://mdbootstrap.com/docs/standard/extended/login/ --}}
</head>
<body>
    {{-- <div class="container py-5">
        <div class="w-50 center border rounded px-3 py-3 mx-auto my-auto ">
            <h1 class="text-center">Login SPKK</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" value="{{ old('username') }}" name="username" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="mb-3 d-grid">
                    <button name="submit" type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div> 
    </div> --}}

    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col col-xl-10">
            <div class="shadow card" style="border-radius: 1rem;">
              <div class="row g-0">
                <div class="col-md-6 col-lg-5 d-none d-md-block">
                  <img src="{{ asset('images/img1.jpg') }}" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem; width: 700px; height: 600px; object-fit: cover;" />
                </div>
                <div class="col-md-6 col-lg-7 d-flex align-items-center">
                  <div class="card-body p-4 p-lg-5 text-black">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
    
                    <form action="" method="POST">
                        @csrf
                        <div class="d-flex align-items-center mb-3 pb-1">
                            <img src="{{ asset('images/logo-rs.png') }}" alt="" style="width: 32px; height: 32px; margin-right: 8px" class="pr-5">
                            <span class="h1 fw-bold mb-0">SPKK</span>
                        </div>
                        
                        <h5>Sistem Penilaian Kinerja Karyawan</h5>
        
                        <p class="fs-6">Silahkan Login untuk mengakses Akun Anda</p>

                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="form2Example17">Username</label>
                            <input type="text" value="{{ old('username') }}" name="username" class="form-control" />
                        </div>

                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="form2Example27">Password</label>
                            <input type="password" name="password" class="form-control" />
                        </div>

                        <div class="d-grid gap-3">
                            <button name="submit" class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
                            <p class="text-center fw-light">Tim IT RS Sitti Khadijah Gorontalo 2025</p>
                        </div>
                        
                        {{-- <a class="small text-muted" href="#!">Forgot password?</a> --}}
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

</body>
</html>