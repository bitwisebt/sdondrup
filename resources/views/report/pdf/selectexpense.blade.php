@extends('layouts.app')

@section('content')
@include('layouts.header')
@include('layouts.sidebar')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Report - Expenses</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/home">Home</a></li>
                        <li class="breadcrumb-item active">Report</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-11">
                    <div class="card">
                        <div class="card-header">
                            {{ __('Select Dates') }}
                        </div>
                        <div class="card-body">
                    <form method="POST" action="{{ route('rptexpense') }}" target="_blank">
                        @csrf
                        <div>
                            <div class="row mb-3">
                                <label for="name" class="col-md-2 col-form-label text-md-end">{{ __('Start Date') }}</label>
                                <div class="col-md-9">
                                    <input type="date" id="start" name="start" class="form-control" data-date-format="DD MMMM YYYY" name="date" required value="{{date('Y-m-d')}}" min="{{session('MinDate')}}" max="{{session('MaxDate')}}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="name" class="col-md-2 col-form-label text-md-end">{{ __('End Date') }}</label>
                                <div class="col-md-9">
                                    <input type="date" id="end" name="end" class="form-control" data-date-format="DD MMMM YYYY" name="date" required value="{{date('Y-m-d')}}" min="{{session('MinDate')}}" max="{{session('MaxDate')}}">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3 mb-0">
                            <div class="col-md-7 offset-md-5">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Show') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
@include('layouts.footer')

@endsection