<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Perpustakaan SMA Carolus</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{asset('assets/img/favicon.ico')}}" rel="icon">

    <!-- Bootstrap -->
    <link href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link href="{{asset('assets/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Datatables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('assets/lib/animate/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">

    <style>
        @media (min-width:800px){
            .mySuggestPhone  { display: none }
            .mySuggestDesktop {display: inline}
        }

        @media (max-width:799px){
            .mySuggestPhone  { display: inline;}
            .mySuggestDesktop { display: none;}
        }
    </style>
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="/" class="navbar-brand d-flex align-items-center px-4 px-lg-5" style="background-color: rgb(49, 79, 250)">
            <h2 class="m-0 text-primary"><img src="https://sma-carolus-sby.tarakanita.sch.id/images/default/logo-region/51.png" height="50px"></h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="/" class="nav-item nav-link">Beranda</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Layanan</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="" class="dropdown-item">Buku Baru</a>
                        <a href="" class="dropdown-item">Koleksi Buku</a>
                        <a href="" class="dropdown-item">Cari Rekomendasi Buku</a>
                    </div>
                </div>
                @if (Auth::user())
                    <a href="/form-masuk" class="nav-item nav-link">Buku Tamu</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-user" aria-hidden="true"></i> {{Auth::user()->name}}</a>
                        <div class="dropdown-menu fade-down m-0">
                            <a href="{{url('/daftar-pinjaman/'.Auth::user()->id)}}" class="dropdown-item">Pinjaman Saya</a>
                            <a href="/daftar-usulan" class="dropdown-item">Usulan Buku</a>
                            <a href="{{url('/profil/'.Auth::user()->id)}}" class="dropdown-item">Profil</a>
                            <a href="{{url('logout')}}" class="dropdown-item">Keluar</a>
                        </div>
                    </div>
                @endif
                @if (!Auth::user())
                    <a href="login" class="nav-item nav-link">Masuk</a>
                 @endif
            </div>
        </div>
    </nav>
    <!-- Navbar End -->
    
    {{-- Alert start --}}
    @if(session('status'))  
        <div class="alert alert-success alert-dismissible" role="alert">
        </button>
            <strong>Sukses!</strong> {{session('status')}}
        </div>
        
    @elseif(session('error')) 
        <div class="alert alert-danger alert-dismissible" role="alert">
        </button>
            <strong>Gagal!</strong> {{session('error')}}
        </div>
    @endif
    {{-- Alert End --}}

    @yield('content')
        

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                
                <div class="col-lg-4 col-md-6">
                    <h4 class="text-white mb-3">Hubungi Kami</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Jl. Jemur Andayani XXI No.7, Siwalankerto, Kec. Wonocolo, Kota SBY, Jawa Timur 60236</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>031 8491287</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>smasantocarolus.tarkisby@gmail.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href="https://www.instagram.com/carolusians/" target="_blank"><i class="fab fa-instagram" ></i></a>
                        <a class="btn btn-outline-light btn-social" href="https://www.youtube.com/channel/UCvPHJ9zsXgUjd0xH_u1KlkA/featured" target="_blank"><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href="https://twitter.com/carolusians?lang=en" target="_blank"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    
                </div>
                <div class="col-lg-3 col-md-6 right_col">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d779.5600523284986!2d112.73658038262931!3d-7.330805097962742!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fb0bf3b310c5%3A0xab72904037583fdb!2sSMA%20Santo%20Carolus!5e0!3m2!1sen!2sid!4v1666167843743!5m2!1sen!2sid" width="400" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="/">Perpustakaan SMA Carolus Surabaya</a>, All Right Reserved.

                        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                        {{-- Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a><br><br>
                        Distributed By <a class="border-bottom" href="https://themewagon.com">ThemeWagon</a> --}}
                    </div>
                    {{-- <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            <a href="">Home</a>
                            <a href="">Cookies</a>
                            <a href="">Help</a>
                            <a href="">FQAs</a>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('assets/lib/wow/wow.min.js')}}"></script>
    <script src="{{asset('assets/lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('assets/lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('assets/lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('assets/vendors/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Datatables -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

    <!-- Template Javascript -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script>
        $('#custometable').DataTable( {
            language: {
            url : '//cdn.datatables.net/plug-ins/1.12.1/i18n/id.json'
            },
            "lengthMenu" : [[10,25,50, -1], [10,25,50,"Semua"]],
            "ordering": false
        });
    </script>
    @yield('javascript')
</body>

</html>