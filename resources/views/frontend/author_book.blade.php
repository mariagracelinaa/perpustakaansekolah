@extends('layouts.front')
@section('content')
<div class="container" style="margin-top: 50px; width: 70%; justify-content: center;"> 
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title" style="margin-left: 20px">
                    <h2>Penulis : {{$author[0]->name}} <span class="bi bi-star-fill" style="color: yellow"></span> {{number_format($rating, 1, '.', '')}}/5</small></h2>
                    @if (!Auth::user())
                        <p style="color: red">Anda dapat melakukan rating penulis dengan masuk menggunakan akun terlebih dahulu</p> 
                    @else
                        <form role="form" method="POST" id="add_rating" action="/tambah-rating">
                            @csrf
                            <div class="form-body">
                                <div class="rating-css">
                                    <div class="star-icon">
                                        @if ($author_rating_user != NULL)
                                            @if($author_rating_user->rate == 1)
                                                <input type="radio" value="1" name="author_rating" id="rate1" checked>
                                                <label for="rate1" class="fa fa-star"></label>
                                                <input type="radio" value="2" name="author_rating" id="rate2">
                                                <label for="rate2" class="fa fa-star"></label>
                                                <input type="radio" value="3" name="author_rating" id="rate3">
                                                <label for="rate3" class="fa fa-star"></label>
                                                <input type="radio" value="4" name="author_rating" id="rate4">
                                                <label for="rate4" class="fa fa-star"></label>
                                                <input type="radio" value="5" name="author_rating" id="rate5">
                                                <label for="rate5" class="fa fa-star"></label> 
                                            @elseif($author_rating_user->rate == 2)
                                                <input type="radio" value="1" name="author_rating" id="rate1">
                                                <label for="rate1" class="fa fa-star"></label>
                                                <input type="radio" value="2" name="author_rating" id="rate2" checked>
                                                <label for="rate2" class="fa fa-star"></label>
                                                <input type="radio" value="3" name="author_rating" id="rate3">
                                                <label for="rate3" class="fa fa-star"></label>
                                                <input type="radio" value="4" name="author_rating" id="rate4">
                                                <label for="rate4" class="fa fa-star"></label>
                                                <input type="radio" value="5" name="author_rating" id="rate5">
                                                <label for="rate5" class="fa fa-star"></label>
                                            @elseif($author_rating_user->rate == 3)
                                                <input type="radio" value="1" name="author_rating" id="rate1">
                                                <label for="rate1" class="fa fa-star"></label>
                                                <input type="radio" value="2" name="author_rating" id="rate2">
                                                <label for="rate2" class="fa fa-star"></label>
                                                <input type="radio" value="3" name="author_rating" id="rate3" checked>
                                                <label for="rate3" class="fa fa-star"></label>
                                                <input type="radio" value="4" name="author_rating" id="rate4">
                                                <label for="rate4" class="fa fa-star"></label>
                                                <input type="radio" value="5" name="author_rating" id="rate5">
                                                <label for="rate5" class="fa fa-star"></label>
                                            @elseif($author_rating_user->rate == 4)
                                                <input type="radio" value="1" name="author_rating" id="rate1">
                                                <label for="rate1" class="fa fa-star"></label>
                                                <input type="radio" value="2" name="author_rating" id="rate2">
                                                <label for="rate2" class="fa fa-star"></label>
                                                <input type="radio" value="3" name="author_rating" id="rate3">
                                                <label for="rate3" class="fa fa-star"></label>
                                                <input type="radio" value="4" name="author_rating" id="rate4" checked>
                                                <label for="rate4" class="fa fa-star"></label>
                                                <input type="radio" value="5" name="author_rating" id="rate5">
                                                <label for="rate5" class="fa fa-star"></label>
                                            @elseif($author_rating_user->rate == 5)
                                                <input type="radio" value="1" name="author_rating" id="rate1">
                                                <label for="rate1" class="fa fa-star"></label>
                                                <input type="radio" value="2" name="author_rating" id="rate2">
                                                <label for="rate2" class="fa fa-star"></label>
                                                <input type="radio" value="3" name="author_rating" id="rate3">
                                                <label for="rate3" class="fa fa-star"></label>
                                                <input type="radio" value="4" name="author_rating" id="rate4">
                                                <label for="rate4" class="fa fa-star"></label>
                                                <input type="radio" value="5" name="author_rating" id="rate5" checked>
                                                <label for="rate5" class="fa fa-star"></label>
                                            @endif
                                        @else
                                            <input type="radio" value="1" name="author_rating" id="rate1" checked>
                                            <label for="rate1" class="fa fa-star"></label>
                                            <input type="radio" value="2" name="author_rating" id="rate2">
                                            <label for="rate2" class="fa fa-star"></label>
                                            <input type="radio" value="3" name="author_rating" id="rate3">
                                            <label for="rate3" class="fa fa-star"></label>
                                            <input type="radio" value="4" name="author_rating" id="rate4">
                                            <label for="rate4" class="fa fa-star"></label>
                                            <input type="radio" value="5" name="author_rating" id="rate5">
                                            <label for="rate5" class="fa fa-star"></label>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group" style="text-align: right">
                                    <button type="submit" class="btn btn-primary" style="width:150px; margin-top: 10px; border-radius: 15px;">Simpan Rating</button>
                                </div>
                                <input type="hidden" id="authors_id" name="authors_id" value="{{$author[0]->id}}">
                                <input type="hidden" id="users_id" name="users_id" value="{{Auth::user()->id}}">
                            </div>
                        </form>
                        {{-- Form end --}}
                    @endif
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
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
                                        @foreach ($list_book as $lb)
                                            <tr class='row-click' data-href='/detail-buku/{{$lb->id}}'>
                                                <td>{{$i++}}</td>
                                                <td style="width:150px; height:200px"><img src="{{asset('images/'.$lb->image)}}" width="100%"></td>
                                                <td>
                                                    <h2>{{$lb->title}}</h2>
                                                    <h6>{{$lb->isbn}}</h6>
                                                    <h6>{{$lb->publish_year}}</h6>
                                                    <h6>{{$lb->classification}}</h6>
                                                </td>
                                            </tr>
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
@endsection

@section('javascript')
<script>
    $(".row-click").click(function() {
        window.location = $(this).data("href");
    });
</script>
@endsection