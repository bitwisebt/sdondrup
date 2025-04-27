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
                        <h1>Add Training</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">New Training</li>
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
                            {{ __('Training Details') }}
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{route('training.store')}}">
                                @csrf

                                <div class="form-group row">
                                    <label for="leave" class="col-md-2 col-form-label text-md-right">{{ __('Level') }}</label>
                                    <div class="col-md-6">
                                        <select name="level" id="level" class="form-control" required>
                                            <option value="">Select</option>
                                            <option value="Certificate">Certificate</option>
                                            <option value="Diploma">Diploma</option>
                                            <option value="Bachelor/Master Degree">Bachelor/Master Degree</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="leave" class="col-md-2 col-form-label text-md-right">{{ __('Title') }}</label>
                                    <div class="col-md-10">
                                        <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" required placeholder="Training Title">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="leave" class="col-md-2 col-form-label text-md-right">{{ __('Institute') }}</label>
                                    <div class="col-md-10">
                                        <input id="institute" type="text" class="form-control" name="institute" value="{{ old('institute') }}" required placeholder="Name of Institute/organization">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="leave" class="col-md-2 col-form-label text-md-right">{{ __('Start') }}</label>
                                    <div class="col-md-5">
                                        <input id="start" type="date" class="form-control" name="start" value="{{ date('Ymd') }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="leave" class="col-md-2 col-form-label text-md-right">{{ __('End') }}</label>
                                    <div class="col-md-5">
                                        <input id="end" type="date" class="form-control" name="end" value="{{ date('Ymd') }}" required>
                                    </div>
                                </div>
                                <input type="hidden" id="id" name="id" value="{{$id}}">
                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-2">
                                        <button type="submit" id="submit" class="btn btn-success text-white">
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
