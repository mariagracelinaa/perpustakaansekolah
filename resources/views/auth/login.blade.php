@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-sm-6 text-black">

        <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">

            <form style="width: 25rem;" method="POST" action="{{ route('login') }}">
                @csrf
                <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Masuk</h3>
                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example18">{{ __('Alamat Email') }}</label><span style="color: red"> *</span>
                    <input id="email" type="email" id="form2Example18" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required oninvalid="this.setCustomValidity('Alamat email tidak boleh kosong')" oninput="setCustomValidity('')" autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    
                </div>
                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example18">{{ __('Kata Sandi') }}</label><span style="color: red"> *</span>
                    <input id="password" type="password" id="form2Example18" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required oninvalid="this.setCustomValidity('Kata sandi tidak boleh kosong')" oninput="setCustomValidity('')" autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    
                </div>
                <div class="pt-1 mb-4">
                    <button class="btn btn-info btn-lg btn-block" type="submit">{{ __('Masuk') }}</button>
                </div>
            </form>
        </div>

      </div>
      <div class="col-sm-6 px-0 d-none d-sm-block">
        <img src="{{asset('images/carolus_login.jpg')}}"
          alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
      </div>
    </div>
  </div>
@endsection
