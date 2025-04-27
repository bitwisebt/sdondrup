@extends('layouts.app')
@section('content')
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    @include('layouts.header')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    @include('layouts.sidebar1')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Company</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">Select Company</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            {{ __('Select Company') }}
                        </div>

                        <div class="card-body">
                            <div class="col-md-8">
                                <a class="btn btn-sm btn-phoenix-info me-1 fs--2 " href="{{route('new.company')}}"><span class="fas fa-plus text-success"></span> New Company</a>
                            </div>
                            <form action="{{ route('company.set') }}" method="POST">
                                @csrf
                                <select name="company" id="company" class="form-control">
                                    <option value="">Select company from the list</option>
                                    @foreach ($companies as $data)
                                    <option value="{{ $data->id }}" {{ session('CompanyID') == $data->id ? 'selected' : '' }}>
                                        {{ $data->name }}
                                    </option>
                                    @endforeach
                                </select>

                                <br>
                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-5">
                                        <button type="submit" class="btn btn-info text-white">
                                            {{ __('SET') }}
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