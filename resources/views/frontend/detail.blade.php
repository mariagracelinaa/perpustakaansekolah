@extends('layouts.front')
@section('content')
<div class="container" style="margin-top: 50px"> 
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2 style="text-align: center">Detail Buku</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        {{-- desktop view --}}
                        <div style="margin-top: 20px;" class="displayDesktop">
                            <table style="border-collapse: separate; border-spacing: 10px;">
                                <tbody>
                                    <tr>
                                        <td style="width:350px; height:400px; vertical-align:top;" rowspan="13"><img src="{{asset('images/'.$data->image)}}" width="100%"></td>
                                        <td>Judul </td>
                                        <td> : {{$data->title}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%">ISBN </td>
                                        <td> : {{$data->isbn}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%">Penerbit </td>
                                        <td> : {{$data->publishers->name}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%">Kota Terbit </td>
                                        <td> : {{$data->publishers->city}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%">Penulis</td>
                                        <td> : 
                                            @php
                                                $z = 1;
                                            @endphp
                                            @foreach($author_name as $an)
                                                @if($z == 1)
                                                    {{$an}}
                                                @else
                                                    , {{$an}}
                                                @endif
                                            @php
                                                $z++;
                                            @endphp
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%;">Tahun terbit</td>
                                        <td> : {{$data->publish_year}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%">Tahun pengadaan pertama </td>
                                        <td> : {{$data->first_purchase}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%">Kategori </td>
                                        <td> : {{ucfirst($data->categories->name)}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%">Nomor Panggil </td>
                                        <td> : {{$data->classification}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%">Edisi </td>
                                        <td> : {{$data->edition}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%">Jumlah halaman </td>
                                        <td> : {{$data->page}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%">Tinggi buku </td>
                                        <td> : {{$data->book_height}} cm</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%">Lokasi buku </td>
                                        <td> : {{ucfirst($data->location)}}</td>
                                    </tr>
                                    <tr>
                                        <td align="justify" style="width: 15%;" colspan="3">
                                            Sinopsis : <br>
                                            {!! nl2br(e($data->synopsis)) !!}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <div class="container"> 
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 ">
                                        <div class="x_panel">
                                            <div class="x_title">
                                            <h2 style="text-align: center">Daftar Item Buku</small></h2>
                                            @if ($count[0]->count == 0)
                                                @if (Auth::user())
                                                    <ul class="nav navbar-right panel_toolbox">
                                                        <a href="/pesan-buku/{{$data->id}}" class="btn btn-primary"><i class="fa fa-plus"></i> Pesan Buku</a>
                                                    </ul>
                                                @else
                                                    <p style="color: red">Anda dapat melakukan pemesanan buku ini dengan masuk menggunakan akun terlebih dahulu</p>
                                                @endif
                                            @endif
                                            <div class="clearfix"></div>
                                            </div>
                                                <div class="x_content">
                                                    <div class="row">
                                                        <table class="table-detail-book" style="margin-top:20px; width:100%; border:1px solid black">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width:40%; text-align:center">Nomor registrasi buku</th>
                                                                    <th style="width:60%; text-align:center">Status</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($items as $item)
                                                                        @if($item->is_deleted == 0)
                                                                            <tr>
                                                                                <td>{{$item->register_num}}</td>
                                                                                @if($item->status == "tersedia")
                                                                                    <td style="background-color: rgb(113, 255, 113)">
                                                                                        Tersedia
                                                                                    </td>
                                                                                @else
                                                                                    <td style="background-color: rgb(255, 64, 64)">
                                                                                        Sedang Dipinjam
                                                                                    </td>
                                                                                @endif
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>

                        {{-- Phone view --}}
                        <div class="displayPhone" style="margin: 20px;">
                            <table style="border-collapse: separate; border-spacing: 10px;">
                                <tr>
                                    <td style="width:150px; height:200px; vertical-align:top;" colspan="2"><img src="{{asset('images/'.$data->image)}}" width="100%"></td>
                                </tr>
                                <tr>
                                    <td style="width: 15%">Judul </td>
                                    <td> : {{$data->title}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 15%">ISBN </td>
                                    <td> : {{$data->isbn}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 15%">Penerbit </td>
                                    <td> : {{$data->publishers->name}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 15%">Kota Terbit </td>
                                    <td> : {{$data->publishers->city}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 15%">Penulis</td>
                                    <td> : 
                                        @php
                                            $z = 1;
                                        @endphp
                                        @foreach($author_name as $an)
                                            @if($z == 1)
                                                {{$an}}
                                            @else
                                                , {{$an}}
                                            @endif
                                        @php
                                            $z++;
                                        @endphp
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 15%;">Tahun terbit</td>
                                    <td> : {{$data->publish_year}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 15%">Tahun pengadaan pertama </td>
                                    <td> : {{$data->first_purchase}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 15%">Kategori </td>
                                    <td> : {{ucfirst($data->categories->name)}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 15%">Nomor Panggil </td>
                                    <td> : {{$data->classification}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 15%">Edisi </td>
                                    <td> : {{$data->edition}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 15%">Jumlah halaman </td>
                                    <td> : {{$data->page}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 15%">Tinggi buku </td>
                                    <td> : {{$data->book_height}} cm</td>
                                </tr>
                                <tr>
                                    <td style="width: 15%">Lokasi buku </td>
                                    <td> : {{ucfirst($data->location)}}</td>
                                </tr>
                                
                                <tr>
                                    <td align="justify" style="width: 15%;" colspan="2">
                                        Sinopsis : <br>
                                        {!! nl2br(e($data->synopsis)) !!}
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <div class="container"> 
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 ">
                                        <div class="x_panel">
                                            <div class="x_title">
                                            <h2 style="text-align: center">Daftar Item Buku</small></h2>
                                            @if ($count[0]->count == 0)
                                                @if (Auth::user())
                                                    <ul class="nav navbar-right panel_toolbox">
                                                        <a href="/pesan-buku/{{$data->id}}" class="btn btn-primary"><i class="fa fa-plus"></i> Pesan Buku</a>
                                                    </ul>
                                                @else
                                                    <p style="color: red">Anda dapat melakukan pemesanan buku ini dengan masuk menggunakan akun terlebih dahulu</p>
                                                @endif
                                            @endif
                                            <div class="clearfix"></div>
                                            </div>
                                                <div class="x_content">
                                                    <div class="row">
                                                        <table class="table-detail-book" style="margin-top:20px; width:100%; border:1px solid black">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width:40%; text-align:center">Nomor registrasi buku</th>
                                                                    <th style="width:60%; text-align:center">Status</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($items as $item)
                                                                        @if($item->is_deleted == 0)
                                                                            <tr>
                                                                                <td>{{$item->register_num}}</td>
                                                                                @if($item->status == "tersedia")
                                                                                    <td style="background-color: rgb(113, 255, 113)">
                                                                                        Tersedia
                                                                                    </td>
                                                                                @else
                                                                                    <td style="background-color: rgb(255, 64, 64)">
                                                                                        Sedang Dipinjam
                                                                                    </td>
                                                                                @endif
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                </tbody>
                                                        </table>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection