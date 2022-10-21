@extends('layouts.front')

@section('content')
<div class="right_col" role="main" style="margin-top: 50px">
    <div class="container" style="max-width: 70%">
        <form role="form" method="POST" action="{{url('/usulan-catat')}}">
            @csrf
            <input type="hidden" name="id" value="{{Auth::user()->id}}">
            <div class="form-group">
                <label>Judul Buku</label>
                <input type="text" name="title" id="title" rows="2" class="form-control @error('title') is-invalid @enderror" style="width: 100%" value="{{ old('title') }}" autofocus>
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label>Nama Penulis</label>
                <input type="text" name="author" id="author" rows="2" class="form-control @error('author') is-invalid @enderror" style="width: 100%" value="{{ old('author') }}" autofocus>
                @error('author')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label>Penerbit</label>
                <input type="text" name="publisher" id="publisher" rows="2" class="form-control @error('publisher') is-invalid @enderror" style="width: 100%" value="{{ old('publisher') }}" autofocus>
                @error('publisher')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label>Alasan Pengusulan</label>
                <textarea name="desc" id="desc" rows="2" class="form-control" style="width: 100%"></textarea>
            </div>
            <div class="form-group" style="text-align: right">
                <button type="submit" class="btn btn-primary" style="width:150px; margin-top: 10px; border-radius: 15px;">Tambah</button>
            </div>
        </form>
    </div>
</div>
@endsection