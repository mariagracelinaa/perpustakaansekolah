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
                                            {{-- <div class="input-icons">
                                                <i class="fa fa-search icon"></i>
                                            <input type="text" class="input-field" id="search" name="search" placeholder="Cari Judul Buku" style="width:250px; height:40px;" >
                                            </div> --}}
                                        </div><br>
                                        <div class="row g-4" id="book_list">
                                            @foreach ( $data as $d)
                                                <input type="hidden" id="ddc" name="ddc" value="{{$d->ddc}}">
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

    $("#search").keyup(function() {
        var search = $('#search').val();
        var ddc = $('#ddc').val();

        $.ajax({
            type:'POST',
            url:'{{url("/koleksi-buku-kategori-filter")}}',
            data:{
                '_token': '<?php echo csrf_token() ?>',
                'search': search,
                'ddc' : ddc,
                },
            success:function(data) {
                $('#book_list').html('');
                $.each(data.data, function(key, value) {
                    $("#book_list").append(
                        "<a href='/detail-buku/"+ value.id +"' class='col-lg-3 col-md-6 wow fadeInUp' data-wow-delay='0.1s'><div class='team-item bg-light'><div class='overflow-hidden'><img class='img-fluid' src='images/"+value.image+"' id='cover-book'></div><div class='text-center p-4'><h5 class='mb-0'>" + value.title + "</h5></div></div></a>");
                });
            }
        });
    });
</script>
@endsection