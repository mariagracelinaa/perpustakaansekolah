@extends('layouts.gentelella')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form role="form" method="POST" action="{{url('/ubah-profil-admin')}}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Nama</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" id="name" value="{{$data[0]->name}}">
                            </div>              
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Alamat Email</label>
                            <div class="col-md-6">
                                <input class="form-control" type="email" name="email" id="email" value="{{$data[0]->email}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Kata Sandi Lama</label>
                            <div class="col-md-6">
                                <input class="form-control" type="password" name="password_old" id="password_old">
                            </div>

                            @error('old-password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Kata Sandi Baru</label>
                            <div class="col-md-6">
                                <input class="form-control" type="password" name="password_new" id="password_new">
                            </div>

                            @error('new-password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Ubah') }}
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="{{$data[0]->id}}">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection