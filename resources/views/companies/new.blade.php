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
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            {{ __('New Company') }}
                        </div>

                        <div class="card-body">
                            <form action="{{ route('new.store') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label for="station" class="col-md-2 col-form-label text-md-right">Name</label>
                                    <div class="col-md-10">
                                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required placeholder="Company Name" autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="station" class="col-md-2 col-form-label text-md-right">Phone#</label>
                                    <div class="col-md-4">
                                        <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" required placeholder="Phone Number">
                                    </div>
                                    <label for="station" class="col-md-2 col-form-label text-md-right">Email</label>
                                    <div class="col-md-4">
                                        <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="station" class="col-md-2 col-form-label text-md-right">Address</label>
                                    <div class="col-md-10">
                                        <textarea name="address" id="address" class="form-control">
                                        {{ old('address') }}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="station" class="col-md-2 col-form-label text-md-right">Bank Name</label>
                                    <div class="col-md-4">
                                        <input id="bank_name" type="text" class="form-control" name="bank_name" value="{{ old('bank_name') }}" required placeholder="Name of Bank">
                                    </div>
                                    <label for="station" class="col-md-2 col-form-label text-md-right">Branch Name</label>
                                    <div class="col-md-4">
                                        <input id="branch_name" type="text" class="form-control" name="branch_name" value="{{ old('branch_name') }}" required placeholder="Branch Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="station" class="col-md-2 col-form-label text-md-right">Account No.</label>
                                    <div class="col-md-4">
                                        <input id="account_number" type="number" class="form-control" name="account_number" value="{{ old('account_number') }}" required placeholder="Account No.">
                                    </div>
                                    <label for="station" class="col-md-2 col-form-label text-md-right">BSB Number</label>
                                    <div class="col-md-4">
                                        <input id="bsb_number" type="text" class="form-control" name="bsb_number" value="{{ old('bsb_number') }}" placeholder="BSB Number">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="station" class="col-md-2 col-form-label text-md-right">Account Name</label>
                                    <div class="col-md-4">
                                        <input id="account_name" type="text" class="form-control" name="account_name" value="{{ old('account_name') }}" required placeholder="Name of A/C">
                                    </div>
                                    <label for="station" class="col-md-2 col-form-label text-md-right">Tax Number</label>
                                    <div class="col-md-4">
                                        <input id="tax_number" type="text" class="form-control" name="tax_number" value="{{ old('tax_number') }}" placeholder="TFN/ABN/Tax No.">
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