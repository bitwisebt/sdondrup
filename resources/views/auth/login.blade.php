@extends('layouts.app')

@section('content')
<center>
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <div class="text-danger">{{$error}}</div>
    @endforeach
    @endif
    </center>
<div class="container">
    <br>
<center><h5 style="color: #4dbd9d;">COMPANY <span><b style="color: #0c8079;">RESOURCE MANAGEMENT</b></span> SYSTEM</h5></center>
<br><br><br>
    <div class="d-flex justify-content-center">
        <div class="user_card">
            <div class="d-flex justify-content-center">
                
                <div class="brand_logo_container">
                    <img src="{{asset('assets/dist/img/fav_icon.png')}}" class="brand_logo" alt="Logo">
                </div>
            </div>
            <div class="d-flex justify-content-center form_container">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input id="email" type="email" class="form-control input_user" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input id="password" type="password" class="form-control input_pass" name="password" required autocomplete="current-password">
                    </div>
                    <!-- <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="custom-control-label text-white" for="customControlInline">Remember me</label>
                        </div>
                    </div> -->
                    <div class="d-flex justify-content-center mt-3 login_container">
                        <button type="submit" name="button" class="btn login_btn">Login</button>
                    </div>
                </form>
            </div>

            <div class="mt-4">
                <div class="d-flex justify-content-center links">
                    @if (Route::has('password.request'))
                    <a class="btn btn-link text-white" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<br>
@endsection