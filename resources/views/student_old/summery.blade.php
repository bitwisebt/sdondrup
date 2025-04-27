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
                        <h1>Registration Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">Report</li>
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
                            {{ __('Student Summary by Stage') }}
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{route('student-registration.summary')}}" target="_blank">
                                @csrf

                                <div class="form-group row">
                                    <label for="Course" class="col-md-3 col-form-label text-md-right">{{ __('University: ') }}</label>
                                    <div class="col-md-9">
                                        <select name="university" id="university" class="form-control" required>
                                            <option value="">Select</option>
                                            <option value="A">All</option>
                                            @foreach($university as $data)
                                            <option value="{{$data->id}}">{{$data->university}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Course" class="col-md-3 col-form-label text-md-right">{{ __('Stage: ') }}</label>
                                    <div class="col-md-9">
                                        <select name="status" id="status" class="form-control" required>
                                            <option value="">Select</option>
                                            @foreach($status as $st)
                                            <option value="{{$st->id}}">{{$st->status}}</option>
                                            @endforeach
                                        </select>
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