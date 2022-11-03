@extends('layouts.front')
<style>
    .input-icons i {
            position: absolute;
        }
          
        .input-icons {
            width: 100%;
            margin-bottom: 10px;
        }
          
        .icon {
            padding: 10px;
            min-width: 40px;
        }
    .input-field {
            width: 100%;
            padding: 10px;
            text-align: center;
        }
</style>
@section('content')
<div class="container container_width" style="margin-top: 50px;"> 
    <div class="row" >
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_content">
                    <div class="row">
                        {{-- Phone view --}}
                        <div class="col-sm-12" style="margin: 20px">
                            @if(!$data[0]->isEmpty())
                                <!-- Book Start -->
                                <div class="container-xxl py-5">
                                    <div class="container">
                                        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                                            <h6 class="section-title bg-white text-center text-primary px-3">Koleksi</h6>
                                            <h1 class="mb-5">Rekomendasi Buku</h1>
                                            {{-- <div class="input-icons">
                                                <i class="fa fa-search icon"></i>
                                            <input type="text" class="input-field" id="search" name="search" placeholder="Cari Judul Buku" style="width:250px; height:40px;" >
                                            </div> --}}
                                        </div><br>
                                        <div class="row g-4" id="book_list">
                                            @foreach ( $data as $d)
                                                <a href="/detail-buku/{{$d[0]->id}}" class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                                    <div class="team-item bg-light">
                                                        <div class="overflow-hidden">
                                                            <img class="img-fluid" src="{{asset('images/'.$d[0]->image)}}" id="cover-book">
                                                        </div>
                                                        <div class="text-center p-4">
                                                            <h5 class="mb-0">{{$d[0]->title}}</h5>
                                                            {{-- <small>Penulis</small> --}}
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!-- Book End -->
                            @else
                                <h2 style="text-align: center">Tidak Ada data buku</h2>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')

@endsection