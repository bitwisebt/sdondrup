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
                        <h1>Ledger</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">Update Ledger</li>
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
                                        <h3 class="card-title">Update Ledger</h3>
                                    </div>

                                    <div class="card-body">
                                        <form method="POST" action="{{route('ledger.update',$ledger->id)}}">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group row">
                                                <label for="Ledger" class="col-md-4 col-form-label text-md-right">{{ __('Account Type') }}</label>
                                                <div class="col-md-8">
                                                    <select name="account_type" id="account_type" class="form-control" required>
                                                        <option value="">Select</option>
                                                        @foreach($account as $data)
                                                        <option value="{{$data->id}}" {{$ledger->account_type_id==$data->id?'selected':''}}>{{$data->account_type}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="Ledger" class="col-md-4 col-form-label text-md-right">{{ __('Ledger') }}</label>
                                                <div class="col-md-8">
                                                    <input id="ledger" type="text" class="form-control" name="ledger" value="{{ $ledger->account_name }}" required autocomplete="false" placeholder="Ledger Name">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="Ledger" class="col-md-4 col-form-label text-md-right">{{ __('Balance') }}</label>
                                                <div class="col-md-8">
                                                    <input id="balance" type="text" class="form-control" name="balance" value="{{ $ledger->balance }}" required onclick="this.select();">
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