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
                            <li class="breadcrumb-item active">Update University</li>
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
                                        <h3 class="card-title">Update University</h3>
                                    </div>

                                    <div class="card-body">
                                        <form method="POST" action="{{route('university.update',$university->id)}}">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group row">
                                                <label for="University_name" class="col-md-4 col-form-label text-md-right">{{ __('University') }}</label>
                                                <div class="col-md-8">
                                                    <input id="university" type="text" class="form-control" name="university" value="{{ $university->university }}" required autocomplete="false" placeholder="University Name">
                                                </div>
                                            
                                            <label for="station" class="col-md-4 col-form-label text-md-right">Phone#</label>
                                    <div class="col-md-8">
                                        <input id="contact_number" type="text" class="form-control" name="contact_number" value="{{ $university->phone }}" required placeholder="Phone/mobile Number">
                                    </div>
                                    <label for="station" class="col-md-4 col-form-label text-md-right">Email</label>
                                    <div class="col-md-8">
                                        <input id="email" type="text" class="form-control" name="email" value="{{ $university->email }}" required placeholder="Email">
                                    </div>
                                    <label for="station" class="col-md-4 col-form-label text-md-right">Address</label>
                                    <div class="col-md-8">
                                        <input id="address" type="text" class="form-control" name="address" value="{{ $university->address }}" required placeholder="Address">
                                    </div>
                                </div>

                                            <div class="form-group row mb-0">
                                                <div class="col-md-8 offset-md-4">
                                                    <button type="submit" class="btn btn-info text-white">
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

                <br>
                <!-- /.card -->
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    @include('layouts.footer')
</div>
@endsection