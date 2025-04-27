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
                        <h1>Billing Address</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">New Billing</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <center>
            @if ($errors->any())
            @foreach ($errors->all() as $error)
            <div class="text-danger">{{$error}}</div>
            @endforeach
            @endif
        </center>
        <!-- Main content -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            {{ __('New Billing to/Account Name') }}
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{route('vendor.store')}}">
                                @csrf
                                <div class="form-group row">
                                    <label for="station" class="col-md-2 col-form-label text-md-right">Bill To</label>
                                    <div class="col-md-8">
                                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required placeholder="Name of Billing Company/Account Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="station" class="col-md-2 col-form-label text-md-right">Address</label>
                                    <div class="col-md-8">
                                        <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" placeholder="Address">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="station" class="col-md-2 col-form-label text-md-right">Phone#</label>
                                    <div class="col-md-4">
                                        <input id="contact_number" type="text" class="form-control" name="contact_number" value="{{ old('contact_number') }}" placeholder="Phone/mobile Number">
                                    </div>
                                    <label for="station" class="col-md-2 col-form-label text-md-right">Email</label>
                                    <div class="col-md-4">
                                        <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-5">
                                        <button type="submit" class="btn btn-info text-white">
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
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>