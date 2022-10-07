@extends('layouts.gentelella')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form id="edit_user" role="form" method="POST" action="{{url('/aksi-ubah-data')}}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Nama</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" id="name" value="{{$data->name}}">
                            </div>              
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">NISN/NIY</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nisn/niy" id="nisn/niy" value="{{ $data->role === "murid" ? $data->nisn : $data->niy }}">
                            </div> 
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Sebagai</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="role" id="role" value="{{ $data->role === "murid" ? "Murid" : "Guru/Staf" }}" readonly>
                            </div> 
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Kelas</label>
                            <div class="col-md-6">
                                @if ($data->class_id == NULL)
                                    <input type="text" class="form-control" name="class_id" id="class_id" value="-" readonly> 
                                @else
                                    <select class="form-control" name="class_id">
                                        @foreach ($class as $c)
                                            @if ($data->class_id == $c->id)
                                                <option value="{{$c->id}}" selected>{{$c->name}}</option>
                                            @else
                                                <option value="{{$c->id}}">{{$c->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Alamat Email</label>
                            <div class="col-md-6">
                                <input class="form-control" type="email" name="email" id="email" value="{{$data->email}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Kata Sandi Baru</label>
                            <div class="col-md-6">
                                <input class="form-control" type="password" name="password_new" id="password_new">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Ubah') }}
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="{{$data->id}}">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




    
@endsection