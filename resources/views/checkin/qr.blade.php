<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Formulir Absensi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <meta name="csrf-token" content="{{ csrf_token() }}" />
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
            <div id="reader" width="400px">

            </div>
            <input type="hidden" id="myemail" name="myemail">
        </div>
    </div>
</body>
</html>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    jQuery(document).ready(function() { 
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
    });
    function onScanSuccess(decodedText, decodedResult) {
        // handle the scanned code as you like, for example:
        // console.log(`Code matched = ${decodedText}`, decodedResult);

        $('#myemail').val(decodedText);
        // Simpan hasil baca qr code ke variabel email buat dikirim ke controller
        let email = decodedText;
        html5QrcodeScanner.clear().then(_ => {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{url('/scan-qr')}}",
                type : "POST",
                data : {
                    _methode : "POST",
                    _token : CSRF_TOKEN,
                    email : email
                },
                success: function (response) {
                    location.reload();
                }
            });
        }).catch(error => {
            alert('Terjadi Kesalahan');
        });
    }

    function onScanFailure(error) {
    // handle scan failure, usually better to ignore and keep scanning.
    // for example:
        // console.warn(`Code scan error = ${error}`);
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    { fps: 10, qrbox: {width: 250, height: 250} },
    /* verbose= */ false);
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>