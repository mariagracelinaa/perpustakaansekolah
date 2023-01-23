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
                        <div style="margin-top: 20px;">
                            <table style="border-collapse: separate; border-spacing: 10px;">
                                <tbody>
                                    <tr>
                                        <td style="width:350px; height:400px; vertical-align:top;" rowspan="15"><img src="{{asset('images/'.$data->image)}}" width="100%"></td>
                                        <td>Judul </td>
                                        <td> : {{$data->title}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%">Rating </td>
                                        <td> : <span class="bi bi-star-fill" style="color: yellow"></span> {{number_format($rating, 2, '.', '')}}/5</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%">Jumlah Terpinjam </td>
                                        <td> : {{$count_borrow[0]->count}} kali</td>
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
                            <br>
                            <div class="container"> 
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 ">
                                        <div class="x_panel">
                                            <div class="x_title">
                                            <h2 style="text-align: center">Review</small></h2>
                                            @if (!Auth::user())
                                                <p style="color: red">Anda dapat melakukan review buku ini dengan masuk menggunakan akun terlebih dahulu</p> 
                                            @else
                                                {{-- <ul class="nav navbar-right panel_toolbox">
                                                    <a href="#modalCreate" data-toggle="modal" class="btn btn-primary"  onclick=""><i class="fa fa-" aria-hidden="true"></i> Tulis Review</a>
                                                </ul> --}}
                                                {{-- Form start --}}
                                                <form role="form" method="POST" id="add_rating" action="/tambah-review">
                                                    @csrf
                                                    <div class="form-body">
                                                        <div class="rating-css">
                                                            <div class="star-icon">
                                                                @if ($book_rating_user != NULL)
                                                                    @if($book_rating_user->rate == 1)
                                                                        <input type="radio" value="1" name="book_rating" id="rate1" checked>
                                                                        <label for="rate1" class="fa fa-star"></label>
                                                                        <input type="radio" value="2" name="book_rating" id="rate2">
                                                                        <label for="rate2" class="fa fa-star"></label>
                                                                        <input type="radio" value="3" name="book_rating" id="rate3">
                                                                        <label for="rate3" class="fa fa-star"></label>
                                                                        <input type="radio" value="4" name="book_rating" id="rate4">
                                                                        <label for="rate4" class="fa fa-star"></label>
                                                                        <input type="radio" value="5" name="book_rating" id="rate5">
                                                                        <label for="rate5" class="fa fa-star"></label> 
                                                                    @elseif($book_rating_user->rate == 2)
                                                                        <input type="radio" value="1" name="book_rating" id="rate1">
                                                                        <label for="rate1" class="fa fa-star"></label>
                                                                        <input type="radio" value="2" name="book_rating" id="rate2" checked>
                                                                        <label for="rate2" class="fa fa-star"></label>
                                                                        <input type="radio" value="3" name="book_rating" id="rate3">
                                                                        <label for="rate3" class="fa fa-star"></label>
                                                                        <input type="radio" value="4" name="book_rating" id="rate4">
                                                                        <label for="rate4" class="fa fa-star"></label>
                                                                        <input type="radio" value="5" name="book_rating" id="rate5">
                                                                        <label for="rate5" class="fa fa-star"></label>
                                                                    @elseif($book_rating_user->rate == 3)
                                                                        <input type="radio" value="1" name="book_rating" id="rate1">
                                                                        <label for="rate1" class="fa fa-star"></label>
                                                                        <input type="radio" value="2" name="book_rating" id="rate2">
                                                                        <label for="rate2" class="fa fa-star"></label>
                                                                        <input type="radio" value="3" name="book_rating" id="rate3" checked>
                                                                        <label for="rate3" class="fa fa-star"></label>
                                                                        <input type="radio" value="4" name="book_rating" id="rate4">
                                                                        <label for="rate4" class="fa fa-star"></label>
                                                                        <input type="radio" value="5" name="book_rating" id="rate5">
                                                                        <label for="rate5" class="fa fa-star"></label>
                                                                    @elseif($book_rating_user->rate == 4)
                                                                        <input type="radio" value="1" name="book_rating" id="rate1">
                                                                        <label for="rate1" class="fa fa-star"></label>
                                                                        <input type="radio" value="2" name="book_rating" id="rate2">
                                                                        <label for="rate2" class="fa fa-star"></label>
                                                                        <input type="radio" value="3" name="book_rating" id="rate3">
                                                                        <label for="rate3" class="fa fa-star"></label>
                                                                        <input type="radio" value="4" name="book_rating" id="rate4" checked>
                                                                        <label for="rate4" class="fa fa-star"></label>
                                                                        <input type="radio" value="5" name="book_rating" id="rate5">
                                                                        <label for="rate5" class="fa fa-star"></label>
                                                                    @elseif($book_rating_user->rate == 5)
                                                                        <input type="radio" value="1" name="book_rating" id="rate1">
                                                                        <label for="rate1" class="fa fa-star"></label>
                                                                        <input type="radio" value="2" name="book_rating" id="rate2">
                                                                        <label for="rate2" class="fa fa-star"></label>
                                                                        <input type="radio" value="3" name="book_rating" id="rate3">
                                                                        <label for="rate3" class="fa fa-star"></label>
                                                                        <input type="radio" value="4" name="book_rating" id="rate4">
                                                                        <label for="rate4" class="fa fa-star"></label>
                                                                        <input type="radio" value="5" name="book_rating" id="rate5" checked>
                                                                        <label for="rate5" class="fa fa-star"></label>
                                                                    @endif
                                                                @else
                                                                    <input type="radio" value="1" name="book_rating" id="rate1" checked>
                                                                    <label for="rate1" class="fa fa-star"></label>
                                                                    <input type="radio" value="2" name="book_rating" id="rate2">
                                                                    <label for="rate2" class="fa fa-star"></label>
                                                                    <input type="radio" value="3" name="book_rating" id="rate3">
                                                                    <label for="rate3" class="fa fa-star"></label>
                                                                    <input type="radio" value="4" name="book_rating" id="rate4">
                                                                    <label for="rate4" class="fa fa-star"></label>
                                                                    <input type="radio" value="5" name="book_rating" id="rate5">
                                                                    <label for="rate5" class="fa fa-star"></label>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Komentar</label>
                                                            @if ($book_rating_user != NULL)
                                                                <textarea name="comment" id="comment" placeholder="Masukkan komentar Anda" rows="3" class="form-control" style="width: 100%">{{$book_rating_user->comment}}</textarea>
                                                            @else
                                                                <textarea name="comment" id="comment" placeholder="Masukkan komentar Anda" rows="3" class="form-control" style="width: 100%"></textarea>
                                                            @endif
                                                        </div>
                                                        <div class="form-group" style="text-align: right">
                                                            <button type="submit" class="btn btn-primary" style="width:150px; margin-top: 10px; border-radius: 15px;">Simpan Review</button>
                                                        </div>
                                                        <input type="hidden" id="biblios_id" name="biblios_id" value="{{$data->id}}">
                                                        <input type="hidden" id="users_id" name="users_id" value="{{Auth::user()->id}}">
                                                    </div>
                                                </form>
                                                {{-- Form end --}}
                                            @endif
                                            <div class="clearfix"></div>
                                            </div>
                                                <div class="x_content">
                                                    <div class="row">
                                                        @foreach($review as $r)
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    {{$r->name}}
                                                                </div>
                                                                <div class="card-body">
                                                                <h5 class="card-title">
                                                                    @for ($i = 0; $i < $r->rate; $i++)
                                                                        <i class="bi bi-star-fill" style="color: rgb(241, 241, 0)"></i>
                                                                    @endfor
                                                                </h5>
                                                                <p class="card-text">{{$r->comment}}</p>
                                                                <small class="card-text">{{ Carbon\Carbon::parse($r->date)->isoFormat('D MMMM Y HH:mm:ss') }}</small>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <br>
                                                    @if (!$review->isEmpty())
                                                        <div style="text-align: right">
                                                            <a href="">>> Lihat Review Lainnya</a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Phone view --}}
                        {{-- <div class="displayPhone" style="margin: 20px;">
                            <table style="border-collapse: separate; border-spacing: 10px;">
                                <tr>
                                    <td style="width:150px; height:200px; vertical-align:top;" colspan="2"><img src="{{asset('images/'.$data->image)}}" width="100%"></td>
                                </tr>
                                <tr>
                                    <td style="width: 15%">Judul </td>
                                    <td> : {{$data->title}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 15%">Rating </td>
                                    <td> : <span class="bi bi-star-fill" style="color: yellow"></span> {{$rating}}/5</td>
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
                            <div class="container" class="displayPhone"> 
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
                            <br>
                            <div class="container" class="displayPhone"> 
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 ">
                                        <div class="x_panel">
                                            <div class="x_title">
                                            <h2 style="text-align: center">Review</small></h2>
                                            @if (!Auth::user())
                                                <p style="color: red">Anda dapat melakukan review buku ini dengan masuk menggunakan akun terlebih dahulu</p> 
                                            @endif
                                            <div class="clearfix"></div>
                                            </div>
                                                <div class="x_content">
                                                    <div class="row">
                                                        @foreach($review as $r)
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    {{$r->name}}
                                                                </div>
                                                                <div class="card-body">
                                                                <h5 class="card-title">
                                                                    @for ($i = 0; $i < $r->rate; $i++)
                                                                        <i class="bi bi-star-fill" style="color: rgb(241, 241, 0)"></i>
                                                                    @endfor
                                                                </h5>
                                                                <p class="card-text">{{$r->comment}}</p>
                                                                <small class="card-text">{{ Carbon\Carbon::parse($r->date)->isoFormat('D MMMM Y HH:mm:ss') }}</small>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div style="text-align: right">
                                                        <a href="">>> Lihat Review Lainnya</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal start Add--}}
<div class="modal fade" id="modalCreate" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" >
            {{-- Form start --}}
            <form role="form" method="POST" id="add_rating">
                <div class="modal-header">
                    <button type="button" class="close" 
                    data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Tambah Rating</h4>
                </div>
                <div class="modal-body">
                @csrf
                    <div class="form-body">
                        <div class="rating-css">
                            <div class="star-icon">
                                <input type="radio" value="1" name="book_rating" id="rate1">
                                <label for="rate1" class="fa fa-star"></label>
                                <input type="radio" value="2" name="book_rating" id="rate2">
                                <label for="rate2" class="fa fa-star"></label>
                                <input type="radio" value="3" name="book_rating" id="rate3">
                                <label for="rate3" class="fa fa-star"></label>
                                <input type="radio" value="4" name="book_rating" id="rate4">
                                <label for="rate4" class="fa fa-star"></label>
                                <input type="radio" value="5" name="book_rating" id="rate5">
                                <label for="rate5" class="fa fa-star"></label>
                            </div>
                        </div>
                    </div>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" onclick="">Simpan</button>
                </div>
            </form>
            {{-- Form end --}}
        </div>    
    </div>
</div>
{{-- end modal --}}
@endsection