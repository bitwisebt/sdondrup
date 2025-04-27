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
                            <li class="breadcrumb-item active">Update Leave Configuration</li>
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
                                        <h3 class="card-title">Update Leave Configuration</h3>
                                    </div>

                                    <div class="card-body">
                                        <form method="POST" action="{{route('leave-config.update',$leave->id)}}">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group row">
                                                <label for="leave" class="col-md-4 col-form-label text-md-right">{{ __('Leave') }}</label>
                                                <div class="col-md-8">
                                                    <input id="leave" type="text" class="form-control" name="leave" value="{{ $leave->leave }}" required autocomplete="false" placeholder="Leave Configuration Name">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="leave" class="col-md-4 col-form-label text-md-right">{{ __('Entitle') }}</label>
                                                <div class="col-md-8">
                                                    <input id="entitle" type="number" class="form-control" name="entitle" value="{{ $leave->entitle }}" required placeholder="Entitle">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="leave" class="col-md-4 col-form-label text-md-right">{{ __('Max') }}</label>
                                                <div class="col-md-8">
                                                    <input id="max" type="text" class="form-control" name="max" value="{{ $leave->max }}" required placeholder="Maximum Leave">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="leave" class="col-md-4 col-form-label text-md-right">{{ __('Applies to') }}</label>
                                                <div class="col-md-8">
                                                    <select name="flag" id="lag" class="form-control" required>
                                                        <option value="">Select</option>
                                                        <option value="A" {{$leave->flag=='A'?'selected':''}}>All</option>
                                                        <option value="M" {{$leave->flag=='M'?'selected':''}}>Male</option>
                                                        <option value="F" {{$leave->flag=='F'?'selected':''}}>Female</option>
                                                    </select>
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