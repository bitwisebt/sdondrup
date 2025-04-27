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
                        <h1>Employee Type</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">Update Employee Type</li>
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
                                        <h3 class="card-title">Update Employee Type</h3>
                                    </div>
                                    <center>
                                        @if ($errors->any())
                                        @foreach ($errors->all() as $error)
                                        <div class="text-danger">{{$error}}</div>
                                        @endforeach
                                        @endif
                                    </center>
                                    @if (session('error'))
                                    <div class="col-sm-10">
                                        <div class="alert  alert-danger alert-dismissible fade show" role="alert">
                                            {{ session('error') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="card-body">
                                        <form method="POST" action="{{route('employee_type.update',$employee->id)}}">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group row">
                                                <label for="aa" class="col-md-4 col-form-label text-md-right">{{ __('Employee Type') }}</label>
                                                <div class="col-md-8">
                                                    <input id="type" type="text" class="form-control" name="type" value="{{ $employee->type }}" required autocomplete="false">
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

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    @include('layouts.footer')
</div>
@endsection