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
                        <h1>Leave Configuration</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">New Leave Configuration</li>
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
                     {{ __('New Leave Configuration') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{route('leave-config.store')}}">
                        @csrf
                        
                        <div class="form-group row">
                            <label for="leave" class="col-md-4 col-form-label text-md-right">{{ __('Leave') }}</label>
                            <div class="col-md-8">
                                <input id="leave" type="text" class="form-control" name="leave" value="{{ old('leave') }}" required autocomplete="false" placeholder="Leave Type" autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="leave" class="col-md-4 col-form-label text-md-right">{{ __('Entitle') }}</label>
                            <div class="col-md-8">
                                <input id="entitle" type="number" class="form-control" name="entitle" value="{{ old('entitle') }}" required placeholder="Entitle">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="leave" class="col-md-4 col-form-label text-md-right">{{ __('Max') }}</label>
                            <div class="col-md-8">
                                <input id="max" type="text" class="form-control" name="max" value="{{ old('max') }}" required  placeholder="Maximum Leave">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="leave" class="col-md-4 col-form-label text-md-right">{{ __('Applies to') }}</label>
                            <div class="col-md-8">
                                <select name="flag" id="lag" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="A">All</option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
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
