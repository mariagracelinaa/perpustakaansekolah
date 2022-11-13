<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Formulir Absensi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="/" class="navbar-brand d-flex align-items-center px-4 px-lg-5" style="background-color: rgb(49, 79, 250)">
            <h2 class="m-0 text-primary"><img src="https://sma-carolus-sby.tarakanita.sch.id/images/default/logo-region/51.png" height="50px"></h2>
        </a>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="{{url('/absensi-perpustakaan')}}" class="nav-item nav-link">Absensi menggunakan email</a>
                <a href="{{url('/absensi-qr-perpustakaan')}}" class="nav-item nav-link">Absensi menggunakan QR</a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    {{-- Alert Start --}}
    @if(session('status'))  
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <strong>Sukses!</strong> {{session('status')}}
            {{Session::forget('status') }}
        </div>
                    
    @elseif(session('error')) 
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <strong>Gagal!</strong> {{session('error')}}
            {{Session::forget('error') }}
        </div>
    @endif
    {{-- Alert End --}}

    <div class="right_col" role="main" style="margin-top: 50px">
        <div class="container" style="max-width: 70%">
            <form role="form" method="POST" action="{{url('/absensi-perpustakaan-catat')}}">
                @csrf
                <div class="form-group">
                    <label>Alamat Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Masukkan alamat email yang terdaftar di sistem perpustakaan" value="{{ old('email') }}">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Kata Sandi</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="********" name="password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Keperluan di perpustakaan</label>
                    <textarea name="desc" id="desc" rows="5" class="form-control @error('desc') is-invalid @enderror" style="width: 100%">{{ old('desc') }}</textarea>
            
                    @error('desc')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group" style="text-align: right">
                    <button type="submit" class="btn btn-primary" style="width:150px; margin-top: 10px; border-radius: 15px;">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>