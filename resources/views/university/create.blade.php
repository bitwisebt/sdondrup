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
                        <h1>University</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">New University</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                     {{ __('New University') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{route('university.store')}}">
                        @csrf
                        
                        <div class="form-group row">
                            <label for="University" class="col-md-4 col-form-label text-md-right">{{ __('University') }}</label>
                            <div class="col-md-8">
                                <input id="university" type="text" class="form-control" name="university" value="{{ old('university') }}" required autocomplete="false" placeholder="University Name" autofocus>
                            </div>
                                    <label for="station" class="col-md-4 col-form-label text-md-right">Phone#</label>
                                    <div class="col-md-8">
                                        <input id="contact_number" type="text" class="form-control" name="contact_number" value="{{ old('contact_number') }}" required placeholder="Phone/mobile Number">
                                    </div>
                                    <label for="station" class="col-md-4 col-form-label text-md-right">Email</label>
                                    <div class="col-md-8">
                                        <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Email">
                                    </div>
                                </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-success text-white">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    @include('layouts.footer')
</div>
@endsection
