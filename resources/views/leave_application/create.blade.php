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
                        <h1>Leave Application</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">New Leave</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            {{ __('New Leave') }}
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{route('leave-application.store')}}">
                                @csrf

                                <div class="form-group row">
                                    <label for="leave" class="col-md-2 col-form-label text-md-right">{{ __('Leave') }}</label>
                                    <div class="col-md-8">
                                        <select name="leave" id="leave" class="form-control" required>
                                            <option value="">Select</option>
                                            @foreach($leave as $lev)
                                            <option data-price="{{$lev->balance}}" value="{{$lev->id}}">{{$lev->leave}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="leave" class="col-md-2 col-form-label text-md-right">{{ __('Purpose') }}</label>
                                    <div class="col-md-8">
                                        <textarea name="purpose" id="purpose" class="form-control">{{old('purpose')}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="leave" class="col-md-2 col-form-label text-md-right">{{ __('From') }}</label>
                                    <div class="col-md-3">
                                        <input id="start" type="date" class="form-control" name="start" required>
                                    </div>
                                    <label for="leave" class="col-md-1 col-form-label text-md-right">{{ __('To') }}</label>
                                    <div class="col-md-4">
                                        <input id="end" type="date" class="form-control" name="end" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="leave" class="col-md-2 col-form-label text-md-right">{{ __('Days') }}</label>
                                    <div class="col-md-8">
                                        <input id="days" type="number" step="0.05" class="form-control" name="days" value="0">
                                    </div>
                                </div>
                                <input type="hidden" id="balance" name="balance">
                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-3">
                                        <button type="submit" id="submit" class="btn btn-success text-white">
                                            {{ __('Save') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-info">
                            {{ __('Leave Balance') }}
                        </div>

                        <div class="card-body">

                            <table class="table table-sm fs--1 mb-0" width="100%">
                                <tr>
                                    <th>Sl#</th>
                                    <th>Leave</th>
                                    <th>Balance</th>
                                </tr>
                                @foreach($balance as $bal)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$bal->Leave->leave}}</td>
                                    <td>{{$bal->balance}}</td>
                                </tr>
                                @endforeach
                            </table>

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
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#leave').on('change', function(e) {
            var balance = $(this).find('option:selected').data('price');
            document.getElementById("balance").value = balance;
            if(balance<1){
                alert('Invalid sufficient leave balance.');
                document.getElementById("submit").disabled = true;
                document.getElementById("purpose").focus();
            }else{
                document.getElementById("submit").disabled = false;
            }
        });
        $('#start').on('change', function(e) {
            var leave_type = document.getElementById("leave").value;

            if (leave_type == '') {
                alert('Please select Leave');
                document.getElementById("submit").disabled = true;
                document.getElementById("leave").focus();
            } else {
                document.getElementById("submit").disabled = false;
            }

        });
        $('#end').on('change', function(e) {
            console.log(e);
            var id = e.target.value;
            var start = document.getElementById("start").value;
            var balance = document.getElementById("balance").value;

            if (start > id) {
                alert('Invalid end date');
                document.getElementById("submit").disabled = true;
            } else {
                document.getElementById("submit").disabled = false;
            }
            var days = 0;
            days = Math.floor((Date.parse(id) - Date.parse(start)) / 86400000) + 1;
            if (days > balance) {
                alert('Number of days more than your leave balance');
                document.getElementById("days").value = '';
                document.getElementById("end").value = '';
                document.getElementById("submit").disabled = true;
            } else {
                document.getElementById("days").value = days;
                document.getElementById("submit").disabled = false;
            }

        });
    });
</script>