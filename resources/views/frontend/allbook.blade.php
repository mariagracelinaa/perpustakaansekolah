@extends('layouts.front')
@section('content')
<div class="container container_width" style="margin-top: 50px;"> 
    <div class="row" >
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title displayDesktop" style="text-align: center">
                    <h2>Koleksi Buku</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        {{-- desktop view --}}
                        <div class="col-sm-12 displayDesktop" style="margin-top: 20px;">
                            <div class="card-body table-responsive">
                                <table id="custometable" class="table">
                                    <thead>
                                        <th>No</th>
                                        <th>Cover</th>
                                        <th>Informasi Buku</th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($data as $d)
                                            <tr class='row-click' data-href='/detail-buku/{{$d->id}}'>
                                                <td>{{$i++}}</td>
                                                <td style="width:150px; height:200px"><img src="{{asset('images/'.$d->image)}}" width="100%"></td>
                                                <td>
                                                    <h2>{{$d->title}}</h2>
                                                    <h6>{{$d->isbn}}</h6>
                                                    <h6>{{$d->publish_year}}</h6>
                                                    <h6>{{$d->classification}}</h6>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Phone view --}}
                        <div class="col-sm-12 displayPhone" style="margin: 20px">
                            @if(!$data->isEmpty())
                                <!-- Book Start -->
                                <div class="container-xxl py-5">
                                    <div class="container">
                                        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                                            <h6 class="section-title bg-white text-center text-primary px-3">Koleksi</h6>
                                            <h1 class="mb-5">Koleksi Buku</h1>
                                        </div>
                                        <div class="row g-4">
                                            @foreach ( $data as $d)
                                                <a href="/detail-buku/{{$d->id}}" class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                                    <div class="team-item bg-light">
                                                        <div class="overflow-hidden">
                                                            <img class="img-fluid" src="{{asset('images/'.$d->image)}}" id="cover-book">
                                                        </div>
                                                        <div class="text-center p-4">
                                                            <h5 class="mb-0">{{$d->title}}</h5>
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
<script>
    $(".row-click").click(function() {
        window.location = $(this).data("href");
    });
</script>
@endsection