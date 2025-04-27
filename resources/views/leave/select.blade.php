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
                        <h1>Leave Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">Leave</li>
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
                            {{ __('Individual Leave Details') }}
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{route('rpt-leave.show')}}" target="_blank">
                                @csrf

                                <div class="form-group row">
                                    <label for="Course" class="col-md-2 col-form-label text-md-right">{{ __('Employee') }}</label>
                                    <div class="col-md-10">
                                        <select name="employee" id="employee" class="form-control js-select" required>
                                            <option value=""></option>
                                            @foreach($employee as $data)
                                            <option value="{{$data->id}}">{{$data->employee_id.' - '.$data->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Course" class="col-md-2 col-form-label text-md-right">{{ __('Start Date') }}</label>
                                    <div class="col-md-10">
                                        <input type="date" id="start" name="start" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Course" class="col-md-2 col-form-label text-md-right">{{ __('End Date') }}</label>
                                    <div class="col-md-10">
                                        <input type="date" id="end" name="end" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-success text-white">
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
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    @include('layouts.footer')
</div>

@endsection
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.js-select').select2();
});
</script>