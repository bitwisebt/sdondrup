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
                        <h1>Account Type</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">Account Type</li>
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
                                        <h3 class="card-title">New Account</h3>
                                    </div>

                                    <div class="card-body">
                                        <form method="POST" action="{{route('account-type.create')}}">
                                            @csrf
                                            <div class="form-group row">
                                                <label for="category" class="col-md-3 col-form-label text-md-right">{{ __('Category') }}</label>
                                                <div class="col-md-9">
                                                    <select name="group" id="group" class="form-control" required>
                                                        <option value="">Select</option>
                                                        @foreach($category as $data)
                                                        <option value="{{$data->id}}" {{old('group')==$data->id?'selected':''}}>{{$data->group}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('group')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <br>
                                            <div class="form-group row">
                                                <label for="category" class="col-md-3 col-form-label text-md-right">{{ __('Account Name') }}</label>
                                                <div class="col-md-9">
                                                    <input id="account_name" type="text" class="form-control @error('account_name') is-invalid @enderror" name="account_name" value="{{ old('account_name') }}" required placeholder="Account Name">
                                                    @error('account_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <br>
                                            
                                            <div class="form-group row mb-0">
                                                <div class="col-md-8 offset-md-5">
                                                    <button type="submit" class="btn btn-success">
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