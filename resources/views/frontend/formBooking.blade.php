@extends('layouts.front')

@section('content')
<div class="right_col" role="main" style="margin-top: 50px">
    <div class="container" style="max-width: 70%">
        <form role="form" method="POST" action="{{url('/pesanan-catat')}}">
            @csrf
            <input type="hidden" name="id" value="{{Auth::user()->id}}">
            <input type="hidden" name="biblios_id" value="{{$id}}">
            <div class="form-group">
                <label>Judul Buku</label>
                <input type="text" name="title" id="title" rows="2" class="form-control" style="width: 100%" value="{{ $title[0]->title }}" readonly>
                
            </div>
            <div class="form-group">
                <label>Alasan Pemesanan</label>
                <textarea name="desc" id="desc" rows="3" class="form-control" style="width: 100%"></textarea>
            </div>
            <div class="form-group" style="text-align: right">
                <button type="submit" class="btn btn-primary" style="width:150px; margin-top: 10px; border-radius: 15px;">Pesan</button>
            </div>
        </form>
    </div>
</div>
@endsection