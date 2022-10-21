@extends('layouts.front')

@section('content')
<div class="right_col" role="main" style="margin-top: 50px">
    <div class="container" style="max-width: 70%">
        <form role="form" method="POST" action="{{url('/masuk-perpustakaan-catat')}}">
            @csrf
            <input type="hidden" name="id" value="{{Auth::user()->id}}">
            <div class="form-group">
              <label>Nama</label>
              <input type="text" class="form-control" name="nisn/niy" value="{{ Auth::user()->name }}" readonly>
            </div>
            <div class="form-group">
                <label>Keperluan di perpustakaan</label>
                <textarea name="desc" id="desc" rows="2" class="form-control @error('desc') is-invalid @enderror" style="width: 100%"></textarea>

                @error('desc')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group" style="text-align: right">
                <button type="submit" class="btn btn-primary" style="width:150px; margin-top: 10px; border-radius: 15px;">Tambah</button>
            </div>
        </form>
    </div>
</div>
@endsection