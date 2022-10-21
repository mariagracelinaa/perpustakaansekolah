@extends('layouts.front')

@section('content')
<div class="right_col" role="main" style="margin-top: 50px">
    <div class="container" style="max-width: 70%">
        <form role="form" method="POST" action="{{url('/editPassword')}}">
            @csrf
            <input type="hidden" name="id" value="{{$data->id}}">
            <div class="form-group">
              <label>NISN/NIY</label>
              <input type="text" class="form-control" name="nisn/niy" value="{{ $data->role === "murid" ? $data->nisn : $data->niy }}" readonly>
            </div>
            <div class="form-group">
                <label>Nama</label>
                <input type="text" class="form-control" name="name" value="{{$data->name}}" readonly>
            </div>
            <div class="form-group">
                <label>Alamat Email</label>
                <input type="text" class="form-control" name="email" value="{{$data->email}}" readonly>
              </div>
            <div class="form-group">
                <label>Kata Sandi Lama</label>
                <input type="password" class="form-control @error('old-password') is-invalid @enderror" name="old-password" placeholder="********">

                @error('old-password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label>Kata Sandi Baru</label>
                <input type="password" class="form-control @error('new-password') is-invalid @enderror" name="new-password" placeholder="********">

                @error('new-password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group" style="text-align: right">
                <button type="submit" class="btn btn-primary" style="width:150px; margin-top: 10px; border-radius: 15px;">Ubah</button>
            </div>
        </form>
    </div>
</div>
@endsection