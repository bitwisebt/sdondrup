@extends('layouts.app')

@section('content')
@include('layouts.header')
@include('layouts.sidebar')
<style>
    .centered {
        margin: 0 auto;
        /* This centers the div horizontally */
        text-align: center;
        /* This centers the content inside the div */
        width: 100%;
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Commission</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/home">Home</a></li>
                        <li class="breadcrumb-item active">Commission</li>
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
                            {{ __('New Commission Receipt') }}
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{route('commission.store')}}">
                                @csrf
                                <div class="form-group row">
                                    <label for="group" class="col-md-2 col-form-label text-md-right">{{ __('University') }}</label>
                                    <div class="col-md-8">
                                        <select name="university" id="university" class="form-control select2" required autofocus>
                                            <option value="">Select</option>
                                            @foreach($university as $data)
                                            <option value="{{$data->id}}" {{old('university')?'selected':''}}>{{$data->university}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="group" class="col-md-2 col-form-label text-md-right">{{ __('Invoice Date') }}</label>
                                    <div class="col-md-4">
                                        <input value="{{date('Y-m-d')}}" id="invoice_date" type="date" class="form-control" name="invoice_date" required>
                                    </div>
                                    <label for="group" class="col-md-2 col-form-label text-md-right">{{ __('Commission Type') }}</label>
                                    <div class="col-md-4">
                                        <select name="type" id="type" class="form-control select2" required autofocus>
                                            <option value="">Select</option>
                                            @foreach($type as $data)
                                            <option value="{{$data->id}}" {{old('type')?'selected':''}}>{{$data->type}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="group" class="col-md-2 col-form-label text-md-right">{{ __('Narration') }}</label>
                                    <div class="col-md-6">
                                        <textarea name="remarks" id="remarks" required class="form-control" placeholder="Invoice Details"></textarea>
                                    </div>
                                    <label for="group" class="col-md-2 col-form-label text-md-right">{{ __('Payment Status') }}</label>
                                    <div class="col-md-2">
                                        <select name="flag" id="flag" class="form-control" required>
                                            <option value="">Select</option>
                                            <option value="P" {{old('flag')=='B'?'selected':''}}>Pending</option>
                                            <option value="C" {{old('flag')=='C'?'selected':''}}>Received</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row" id="hide" hidden>
                                    <label for="group" class="col-md-2 col-form-label text-md-right">{{ __('Mode') }}</label>
                                    <div class="col-md-4">
                                        <select name="payment_mode" id="payment_mode" class="form-control">
                                            <option value="">Select</option>
                                            <option value="B" {{old('flag')=='B'?'selected':''}}>Bank</option>
                                            <option value="C" {{old('flag')=='C'?'selected':''}}>Cash</option>
                                            <option value="D" {{old('flag')=='D'?'selected':''}}>Cheque</option>
                                        </select>
                                    </div>
                                    <label for="group" class="col-md-2 col-form-label text-md-right">{{ __('Payment Date') }}</label>
                                    <div class="col-md-4">
                                        <input value="{{old('payment_date')}}" id="payment_date" type="date" class="form-control" name="payment_date">
                                    </div>
                                </div>
                                <hr>
                                <div class="centered">
                                    <small>Fees</small>
                                    <input type="number" name="setFee" id="setFee" class="form-control-sm" value="" />
                                    <small>Rate</small>
                                    <input type="number" name="setRate" id="setRate" class="form-control-sm" value="" />
                                    <a id="set" href="#" class=" btn btn-sm btn-success" onclick="myFunction()"><i class="fa fa-gears"></i> Set</a>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <div class="table-responsive">
                                        <table class="table table-sm" width="100%" id="tblItem">
                                            <thead>
                                                <tr style="margin-left:15px">
                                                    <th>Sl.</th>
                                                    <th>Student</th>
                                                    <th>Tution Fee</th>
                                                    <th>Commission%</th>
                                                    <th>Amount</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody class="addMoreProduct">
                                            </tbody>
                                        </table>
                                        <hr>
                                    </div>
                                    <br><br>
                                    <div class="table-responsive col-md-5 offset-md-7">
                                        <table class="noBorder table-sm justify-content-md-center">
                                            <tbody class="foot">
                                                <tr>
                                                    <td align="right"><small><b>Total</b></small></td>
                                                    <td>
                                                        <input id="total" type="number" readonly value="0" class="form-control" step="0.01" name="total">

                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>

                                    <hr>
                                    <div class="col-md-6 offset-md-5">
                                        <button type="submit" id="submit" class="btn btn-primary text-white">
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

<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> 
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
        $("#university").on('change', function(e) {
            console.log(e);
            var id = e.target.value;
            $.get('/json-university?id=' + id, function(data) {
                console.log(data);
                $("#tblItem tr>td").remove();
                $.each(data, function(index, ageproductObj) {
                    var noRows = ($('.tblItem tr').length - 0) + 1;
                    var tr = '<tr><td>' + noRows + '</td>' +
                        '<td><input id="id" type="hidden" required class="form-control id" name="id[]" value="' + ageproductObj.id + '"  style="width: 10px !important; min-width: 10px; max-width: 10px;">' +
                        '<input id="name" type="text" required class="form-control name" name="name[]" readonly value="' + ageproductObj.name + '">' +
                        '<td><input onClick="this.select();" id="fee" type="number" required step="0.01" class="form-control fee" name="fee[]" value="" autocomplete="off" style="width: 120px !important; min-width: 120px; max-width: 120px;"></td>' +
                        '<td><input onClick="this.select();" id="rate" type="number" required step="0.01" class="form-control rate" name="rate[]" value="" autocomplete="off" style="width: 120px !important; min-width: 120px; max-width: 120px;"></td>' +
                        '<td><input id="amount" type="text" class="form-control amount" name="amount[]" value="" readonly style="width: 90px !important; min-width: 90px; max-width: 90px;"></td>' +
                        '<td><a class="btn btn-sm btn-phoenix-info delete"><i class="fa fa-trash text-danger"></i></a></td> </tr>'
                    $('.addMoreProduct').append(tr);
                    $('addMoreProduct tr').last().find('td').first().focus();
                    totalAmount();
                    document.getElementById("set").disabled = false;
                    e.preventDefault();
                })
            });
            $('#addMoreProduct').find("tr:not(:first)").remove();
        });
        $("#type").on('change', function(e) {
            console.log(e);
            var id = e.target.value;
            var uid = document.getElementById("university").value;
            if (uid != '') {
                $.get('/json-commission?id=' + id + '&uid=' + uid, function(data) {
                    console.log(data);
                    $("#tblItem tr>td").remove();
                    $.each(data, function(index, ageproductObj) {
                        var noRows = ($('.tblItem tr').length - 0) + 1;
                        var tr = '<tr><td>' + noRows + '</td>' +
                            '<td><input id="id" type="hidden" required class="form-control id" name="id[]" value="' + ageproductObj.id + '"  style="width: 10px !important; min-width: 10px; max-width: 10px;">' +
                            '<input id="name" type="text" required class="form-control name" name="name[]" readonly value="' + ageproductObj.name + '">' +
                            '<td><input onClick="this.select();" id="fee" type="number" required step="0.01" class="form-control fee" name="fee[]" value="" autocomplete="off" style="width: 120px !important; min-width: 120px; max-width: 120px;"></td>' +
                            '<td><input onClick="this.select();" id="rate" type="number" required step="0.01" class="form-control rate" name="rate[]" value="" autocomplete="off" style="width: 120px !important; min-width: 120px; max-width: 120px;"></td>' +
                            '<td><input id="amount" type="text" class="form-control amount" name="amount[]" value="" readonly style="width: 90px !important; min-width: 90px; max-width: 90px;"></td>' +
                            '<td><a class="btn btn-sm btn-phoenix-info delete"><i class="fa fa-trash text-danger"></i></a></td> </tr>'
                        $('.addMoreProduct').append(tr);
                        $('addMoreProduct tr').last().find('td').first().focus();
                        totalAmount();
                        document.getElementById("set").disabled = false;
                        e.preventDefault();
                    })
                });
            } else {
                alert('Please select University');
                document.getElementById("university").focus();
                e.preventDefault();
            }
        });
        $('.addMoreProduct').delegate('.delete', 'click', function(e) {
            $(this).parent().parent().remove();
            totalAmount();
            e.preventDefault();
        });
        $('.addMoreProduct').delegate('.quantity', 'keyup', function() {
            var tr = $(this).parent().parent();
            var fee = tr.find('.fee').val() - 0;
            var rate = tr.find('.rate').val() - 0;
            var tot = (fee * rate / 100);
            tr.find('.amount').val(tot);
            totalAmount();
        });
        $('.addMoreProduct').delegate('.rate', 'keyup', function() {
            var tr = $(this).parent().parent();
            var fee = tr.find('.fee').val() - 0;
            var rate = tr.find('.rate').val() - 0;
            var tot = (fee * rate / 100);
            tr.find('.amount').val(tot);
            totalAmount();
        });
        $("#flag").on('change', function(e) {
            console.log(e);
            var id = e.target.value;
            if (id == 'C')
                document.getElementById("hide").hidden = false;
            else
                document.getElementById("hide").hidden = true;
        });

    });

    function totalAmount() {
        var tot = 0;
        $('.amount').each(function(i, e) {
            var amt = $(this).val() - 0;
            tot += amt;
        });
        document.getElementById("total").value = tot.toFixed(2);
    }

    function restartTable() {
        const tbody = document.getElementById("tblDetail").getElementsByTagName('tbody')[0];
        tbody.innerHTML = "";
    }

    function myFunction() {
        var fee = document.getElementsByClassName("fee");
        var com = document.getElementsByClassName("rate");
        var amt = document.getElementsByClassName("amount");
        var a = parseFloat(document.getElementById("setFee").value);
        var b = parseFloat(document.getElementById("setRate").value);
        for (var i = 0; i < fee.length; i++) {
            fee[i].value = a;
            com[i].value = b;
            amt[i].value = a * b / 100;

        }
        totalAmount();
    }
</script>
@endsection