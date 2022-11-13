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
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
            </button>
            <strong>Sukses!</strong> {{session('status')}}
            {{Session::forget('status') }}
        </div>
                    
    @elseif(session('error')) 
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
            </button>
            <strong>Gagal!</strong> {{session('error')}}
            {{Session::forget('error') }}
        </div>
    @endif
    {{-- Alert End --}}

    <div class="right_col" role="main" style="margin-top: 50px">
        <div class="container" style="max-width: 70%">
            scan qr
        </div>
    </div>
</body>
</html>