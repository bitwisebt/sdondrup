@extends('layouts.app')
@section('content')
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    @include('layouts.header')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    @include('layouts.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">Update Profile</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-body">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-7">
                                <div class="card">
                                    <div class="card-header p-3 mb-2 text-dark">
                                        <h3 class="card-title">Profile</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-3">
                                                @if($profile->image_path==null)
                                                <img src="{{asset('assets/dist/img/profile.png')}}" style="width:150px; height:150px; float:left; border-radius:10%; margin-right:25px">
                                                @else
                                                <img src="{{ URL::to('/') }}/{{ $profile->image_path }}" style="width:150px; height:150px; float:left; border-radius:10%; margin-right:25px">
                                                @endif
                                            </div>
                                            <div class="col-9">
                                                <form method="POST" action="{{ route('profile.update', $profile->id) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group row">
                                                        <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Name') }}</label>
                                                        <div class="col-md-8">
                                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $profile->name }}" required autocomplete="off" placeholder="Name of User">
                                                            @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="form-group row">
                                                        <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('Email') }}</label>
                                                        <div class="col-md-8">
                                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $profile->email }}" required autocomplete="off" placeholder="Email Address">
                                                            @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <br>

                                                    <div class="form-group row">
                                                        <label for="contact" class="col-md-3 col-form-label text-md-right">{{ __('Image') }}</label>
                                                        <div class="col-md-8">
                                                            <input type="file" class="col-md-6 form-control" name="profile">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="form-group row mb-0">
                                                        <div class="col-md-8 offset-md-5">
                                                            <button type="submit" class="btn btn-success">
                                                                {{ __('Update') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
    </div>
    @include('layouts.footer')
</div>
@endsection