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
                        <h1>Proficiency Test</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">New Test</li>
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
                            {{ __('New Test') }}
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{route('test.store')}}">
                                @csrf

                                <div class="form-group row">
                                    <label for="Test" class="col-md-4 col-form-label text-md-right">{{ __('Test') }}</label>
                                    <div class="col-md-8">
                                        <input id="sht_name" type="text" class="form-control" name="sht_name" value="{{ old('sht_name') }}" required autocomplete="false" placeholder="Short Name" autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Test_name" class="col-md-4 col-form-label text-md-right">{{ __('Full Form') }}</label>
                                    <div class="col-md-8">
                                        <input id="full_name" type="text" class="form-control" name="full_name" value="{{ old('full_name') }}" required autocomplete="false" placeholder="Full Name">
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