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
                        <h1>Company Update</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">Update Company</li>
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
                            <div class="col-md-10">
                                <div class="card">
                                    <div class="card-header p-3 mb-2 text-dark">
                                        <h3 class="card-title">Update Company</h3>
                                    </div>

                                    <div class="card-body">
                                        <form method="POST" action="{{route('companies.update', $company)}}">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group row">
                                                <label for="station" class="col-md-2 col-form-label text-md-right">Name</label>
                                                <div class="col-md-10">
                                                    <input id="name" type="text" class="form-control" name="name" value="{{ $company->name }}" required placeholder="Company Name" autofocus>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="station" class="col-md-2 col-form-label text-md-right">Phone#</label>
                                                <div class="col-md-4">
                                                    <input id="phone" type="text" class="form-control" name="phone" value="{{ $company->phone }}" required placeholder="Phone Number">
                                                </div>
                                                <label for="station" class="col-md-2 col-form-label text-md-right">Email</label>
                                                <div class="col-md-4">
                                                    <input id="email" type="text" class="form-control" name="email" value="{{ $company->email }}" required placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="station" class="col-md-2 col-form-label text-md-right">Address</label>
                                                <div class="col-md-10">
                                                    <textarea name="address" id="address" class="form-control" rows="3" style="white-space: pre-line;">{{ trim($company->address) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="station" class="col-md-2 col-form-label text-md-right">Bank Name</label>
                                                <div class="col-md-4">
                                                    <input id="bank_name" type="text" class="form-control" name="bank_name" value="{{ $company->bank_name }}" required placeholder="Name of Bank">
                                                </div>
                                                <label for="station" class="col-md-2 col-form-label text-md-right">Branch Name</label>
                                                <div class="col-md-4">
                                                    <input id="branch_name" type="text" class="form-control" name="branch_name" value="{{ $company->branch_name }}" required placeholder="Branch Name">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="station" class="col-md-2 col-form-label text-md-right">Account No.</label>
                                                <div class="col-md-4">
                                                    <input id="account_number" type="number" class="form-control" name="account_number" value="{{ $company->account_number }}" required placeholder="Account No.">
                                                </div>
                                                <label for="station" class="col-md-2 col-form-label text-md-right">BSB Number</label>
                                                <div class="col-md-4">
                                                    <input id="bsb_number" type="text" class="form-control" name="bsb_number" value="{{ $company->bsb_number }}" placeholder="BSB Number">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="station" class="col-md-2 col-form-label text-md-right">Account Name</label>
                                                <div class="col-md-4">
                                                    <input id="account_name" type="text" class="form-control" name="account_name" value="{{ $company->account_name }}" required placeholder="Name of A/C">
                                                </div>
                                                <label for="station" class="col-md-2 col-form-label text-md-right">Tax Number</label>
                                                <div class="col-md-4">
                                                    <input id="tax_number" type="text" class="form-control" name="tax_number" value="{{ $company->tax_number }}" placeholder="TFN/ABN/Tax No.">
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