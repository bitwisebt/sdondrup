@extends('layouts.app')

@section('content')
@include('layouts.header')
@include('layouts.sidebar')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Invoice - Income</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/home">Home</a></li>
                        <li class="breadcrumb-item active">Invoice</li>
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
                            {{ __('New Invoice') }}
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{route('invoice.store')}}">
                                @csrf
                                <div class="form-group row">
                                    <label for="group" class="col-md-1 col-form-label text-md-right">{{ __('Income') }}</label>
                                    <div class="col-md-4">
                                        <select name="income" id="income" class="select2 form-control" required autofocus>
                                            <option value="">Income Type</option>
                                            @foreach($income as $data)
                                            <option value="{{$data->id}}" {{old('income')?'selected':''}}>{{$data->income}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="group" class="col-md-2 col-form-label text-md-right">{{ __('Customer') }}</label>
                                    <div class="col-md-4">
                                        <select name="customer" id="customer" class="select2 form-control" required autofocus>
                                            <option value="">Customer List</option>
                                            @foreach($customer as $data)
                                            <option value="{{$data->id}}" {{old('customer')?'selected':''}}>{{$data->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <a class="btn btn-sm btn-phoenix-info me-1 fs--2 " href="{{route('customer.create')}}"><span class="fas fa-plus text-success"></span> New</a>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="group" class="col-md-1 col-form-label text-md-right">{{ __('Date') }}</label>
                                    <div class="col-md-4">
                                        <input value="{{old('invoice_date')}}" id="invoice_date" type="date" class="form-control" name="invoice_date" required>
                                    </div>
                                    <label for="group" class="col-md-2 col-form-label text-md-right">{{ __('Due Date') }}</label>
                                    <div class="col-md-4">
                                        <input value="{{old('due_date')}}" id="due_date" type="date" class="form-control" name="due_date" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-8">
                                        <textarea name="remarks" id="remarks" required class="form-control" placeholder="Descriptions in details"></textarea>
                                    </div>
                                    <label for="group" class="col-md-2 col-form-label text-md-right">{{ __('Payment Status') }}</label>
                                    <div class="col-md-2">
                                        <select name="flag" id="flag" class="form-control" required>
                                            <option value="">Select</option>
                                            <option value="P" {{old('flag')=='B'?'selected':''}}>Pending</option>
                                            <option value="C" {{old('flag')=='C'?'selected':''}}>Paid</option>
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
                                <legend>Details</legend>
                                <span>
                                    <a href="#" class=" btn btn-sm btn-success addMore"><i class="fa fa-plus"></i>Add
                                        Items</a>
                                </span>
                                <hr>
                                <div class="form-group row">
                                    <div class="table-responsive">
                                        <table class="table table-sm" width="100%" id="tblItem">
                                            <thead>
                                                <tr style="margin-left:15px">
                                                    <th>Sl.</th>
                                                    <th>Description</th>
                                                    <th>Rate</th>
                                                    <th>QTY</th>
                                                    <th>Amount</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody class="addMoreProduct">
                                                <tr>
                                                    <td>1</td>
                                                    <td>
                                                        <input id="description" type="text" required class="form-control description" name="description[]">
                                                    </td>

                                                    <td>
                                                        <input onClick="this.select();" id="rate" type="number" required step="0.01" class="form-control rate" name="rate[]" autocomplete="off" style="width: 160px !important; min-width: 160px; max-width: 160px;">
                                                    </td>
                                                    <td>
                                                        <input onClick="this.select();" id="quantity" type="number" value="1" required step="0.01" class="form-control quantity" name="quantity[]" autocomplete="off" style="width: 90px !important; min-width: 90px; max-width: 90px;">
                                                    </td>
                                                    <td>
                                                        <input id="amount" type="text" class="form-control amount" name="amount[]" readonly style="width: 160px !important; min-width: 160px; max-width: 160px;">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <hr>
                                    </div>
                                    <br><br>
                                    <div class="table-responsive col-md-5 offset-md-7">
                                        <table class="noBorder table-sm justify-content-md-center">
                                            <tbody class="foot">
                                                <tr>
                                                    <td align="right"><small><b>Tax Rate</b></small></td>
                                                    <td>
                                                        <input onClick="this.select();" id="tax" type="number" value="10" class="form-control" step="0.01" name="tax" onkeyup="totalAmount()">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="right"><small><b>Total</b></small></td>
                                                    <td>
                                                        <input id="total" type="number" readonly value="0" class="form-control" step="0.01" name="total">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="right"><small><b>Tax</b></small></td>
                                                    <td>
                                                        <input id="tax_total" type="number" readonly value="0" class="form-control" step="0.01" name="tax_total">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="right"><small><b>Grand Total</b></small></td>
                                                    <td>
                                                        <input id="grand_total" type="number" readonly value="0" class="form-control" step="0.01" name="grand_total">

                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>

                                    <hr>
                                    <div class="col-md-6 offset-md-5">
                                        <button type="submit" id="submit" class="btn btn-primary text-white">
                                            {{ __('Generate & Email') }}
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
        $('.addMore').on('click', function(e) {
            var noRows = ($('.addMoreProduct tr').length - 0) + 1;
            var tr = '<tr><td>' + noRows + '</td>' +
                '<td><input id="description" type="text" required class="form-control description" name="description[]"></td>' +
                '<td><input onClick="this.select();" id="rate" type="number" required step="0.01" class="form-control rate" name="rate[]" autocomplete="off" style="width: 160px !important; min-width: 160px; max-width: 160px;"></td>' +
                '<td><input onClick="this.select();" id="quantity" type="number" required step="0.01" value="1" class="form-control quantity" name="quantity[]" autocomplete="off" style="width: 90px !important; min-width: 90px; max-width: 90px;"></td>' +
                '<td><input id="amount" type="text" class="form-control amount" name="amount[]" readonly style="width: 160px !important; min-width: 160px; max-width: 160px;"></td>' +
                '<td><a class="btn btn-sm btn-phoenix-info delete"><i class="fa fa-trash text-danger"></i></a></td> </tr>'
            $('.addMoreProduct').append(tr);
            $('addMoreProduct tr').last().find('td').first().focus();
            e.preventDefault();
        });
        $('.addMoreProduct').delegate('.delete', 'click', function(e) {
            $(this).parent().parent().remove();
            e.preventDefault();
        });
        $('.addMoreProduct').delegate('.quantity', 'keyup', function() {
            var tr = $(this).parent().parent();
            var rate = tr.find('.rate').val() - 0;
            var qty = tr.find('.quantity').val() - 0;
            var tot = (qty * rate);
            tr.find('.amount').val(tot);
            totalAmount();
        });
        $('.addMoreProduct').delegate('.rate', 'keyup', function() {
            var tr = $(this).parent().parent();
            var rate = tr.find('.rate').val() - 0;
            var qty = tr.find('.quantity').val() - 0;
            var tot = (qty * rate);
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
        var atax = 0;
        var gtot = 0;
        var tax = document.getElementById("tax").value;
        $('.amount').each(function(i, e) {
            var amt = $(this).val() - 0;
            tot += amt;
        });
        atax = (tax / 100) * tot;
        gtot = tot + atax;
        document.getElementById("total").value = tot.toFixed(2);
        document.getElementById("tax_total").value = atax.toFixed(2);
        document.getElementById("grand_total").value = gtot.toFixed(2);
    }
</script>
@endsection