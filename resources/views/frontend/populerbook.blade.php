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

    table, th, td {
        border: 1px solid;
    }
</style>
@section('content')
<div class="container container_width" style="margin-top: 50px;"> 
    <div class="row" >
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12" style="margin: 20px">
                            <div class="container-xxl py-5">
                                <div class="container">
                                    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                                        <h6 class="section-title bg-white text-center text-primary px-3">Koleksi</h6>
                                        <h1 class="mb-5">Buku Populer</h1>
                                    </div><br>
                                    <div class="row g-4" id="book_list">
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ( $data as $d)
                                            <a href="/detail-buku/{{$d->id}}" class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s" style="text-decoration: none">
                                                <div class="team-item bg-light">
                                                    <div class="overflow-hidden">
                                                        <p style="color: black; text-decoration: none; text-align: center; padding-top: 5px;margin: 0; font-size: 15pt; font-weight: bold">{{$i++}}</p>
                                                        <img class="img-fluid" src="{{asset('images/'.$d->image)}}" id="cover-book">
                                                    </div>
                                                    <div class="text-center p-4">
                                                        <h5 class="mb-0">{{$d->title}}</h5>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
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