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
                        <div class="mySuggestDesktop" style="margin-top: 20px;">
                            <table class="table">
                                <thead>
                                    <th style="text-align: center">Cover</th>
                                    <th style="text-align: center" colspan="2">Informasi Buku</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="width:350px; height:400px" rowspan="14"><img src="{{asset('images/'.$data->image)}}" width="100%"></td>
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
                                        <td style="width: 15%">Tahun terbit </td>
                                        <td> : {{$data->publish_year}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%">Tahun pengadaan pertama </td>
                                        <td> : {{$data->first_purchase}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%">Sinopsis </td>
                                        <td> : {!! nl2br(e($data->synopsis)) !!} </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%">Kelas DDC </td>
                                        <td> : {{$data->ddc}}</td>
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
                                        <td> : {{$data->location}}</td>
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
                                                <ul class="nav navbar-right panel_toolbox">
                                                    <a href="/pesan-buku/{{$data->id}}" class="btn btn-primary"><i class="fa fa-plus"></i> Pesan Buku</a>
                                                </ul>
                                            @endif
                                            <div class="clearfix"></div>
                                            </div>
                                                <div class="x_content">
                                                    <div class="row">
                                                        <table class="table" style="margin-top:20px; width:100%; border:0,5px solid black">
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
                        {{-- <div class="col-sm-12 mySuggestPhone" style="margin: 20px">
                            @if(!$data->isEmpty())
                                <div class="card-body table-responsive" >
                                    @foreach ($data as $d)
                                        <div class="card shadow p-3 mb-5 bg-white rounded" style="width: 100%; margin-bottom: 20px">
                                            <div class="card-body">
                                            <h5 class="card-title">{{$d->title}}</h5>
                                            <h6 class="card-subtitle mb-2 text-muted">
                                                @if($d->status == 'sudah kembali')
                                                    Sudah Kembali
                                                @elseif($d->status == 'belum kembali')
                                                    Belum Kembali
                                                @endif
                                            </h6>
                                            @if ( date('Y-m-d') > $d->due_date && $d->status == 'belum kembali')
                                                <p style="color: red">Tanggal Batas Kembali: {{ Carbon\Carbon::parse($d->due_date)->format('d F Y') }}</p>
                                            @else
                                                <p>Tanggal Batas Kembali: {{ Carbon\Carbon::parse($d->due_date)->format('d F Y') }}</p>
                                            @endif

                                            @if ( date('Y-m-d') <= $d->due_date && $d->status == 'belum kembali')
                                                <a onclick="bookExtensionUser({{$d->id}},'{{$d->register_num}}')" class="card-link">Perpanjang</a>
                                            @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <h2 style="text-align: center">Tidak Ada data usulan</h2>
                            @endif
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
@endsection