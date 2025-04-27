@extends('layouts.app')

@section('content')
<style>
    input {
        position: relative;
        width: 150px;
        height: 30px;
    }

    input:before {
        position: absolute;
        top: 3px;
        left: 3px;
        content: attr(data-date);
        display: inline-block;
        color: black;
    }

    input::-webkit-datetime-edit,
    input::-webkit-inner-spin-button,
    input::-webkit-clear-button {
        display: none;
    }

    input::-webkit-calendar-picker-indicator {
        position: absolute;
        top: 3px;
        right: 0;
        color: black;
        opacity: 1;

    }

    .overlay {
        display: none;
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 999;
        background: rgba(255, 255, 255, 0.8) url("{{asset('img/ajax-loader.gif')}}") center no-repeat;
    }

    /* Turn off scrollbar when body element has the loading class */
    body.loading {
        overflow: hidden;
    }

    /* Make spinner image visible when body element has the loading class */
    body.loading .overlay {
        display: block;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border border-success">
                <div class="card-header bg-success-lite">
                    <h5>{{ __('Export Update') }}</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('export.update',$export->id)}}">
                        @csrf
                        <div class="form-group row">
                            <label for="group" class="col-md-2 col-form-label text-md-right">{{ __('Invoice  Number') }}</label>
                            <div class="col-md-4">
                                <input id="invoice_number" type="text" class="form-control @error('invoice_number') is-invalid @enderror" name="invoice_number" value="{{ $export->invoice_number }}" required readonly>
                            </div>
                            <label for="group" class="col-md-2 col-form-label text-md-right">{{ __('Date') }}</label>
                            <div class="col-md-4">
                                <input id="date" type="date" data-date-format="DD MMMM YYYY" class="form-control @error('date') is-invalid @enderror" name="date" required value="{{$export->date}}" min="{{session('MinDate')}}" max="{{session('MaxDate')}}">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="group" class="col-md-2 col-form-label text-md-right">{{ __('Party Name') }}</label>
                            <div class="col-md-4">
                                <select name="ledger" id="ledger" class="form-control select2" required autofocus>
                                    <option value="">Select</option>
                                    @foreach($party as $data)
                                    <option value="{{$data->id}}" {{$data->id==$export->ledger_id?'selected':''}}>{{$data->ledger}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="group" class="col-md-2 col-form-label text-md-right">{{ __('Certificate of Origin') }}</label>
                            <div class="col-md-4">
                                <input value="{{$export->challen_number}}" id="challen" type="text" class="form-control @error('challen') is-invalid @enderror" name="challen" placeholder="Certificate of Origin Number">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="group" class="col-md-2 col-form-label text-md-right">{{ __('Driver Name') }}</label>
                            <div class="col-md-4">
                                <input value="{{$export->driver_name}}" id="driver_name" type="text" class="form-control @error('driver_name') is-invalid @enderror" name="driver_name" placeholder="Name of Driver">
                            </div>
                            <label for="group" class="col-md-2 col-form-label text-md-right">{{ __('Nationality') }}</label>
                            <div class="col-md-4">
                                <select name="nationality" id="nationality" class="form-control select2" required autofocus>
                                    <option value="">Select</option>
                                    <option value="B" {{$export->nationality=='B'?'selected':''}}>Bhutanese</option>
                                    <option value="N" {{$export->nationality=='N'?'selected':''}}>Indian</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="group" class="col-md-2 col-form-label text-md-right">{{ __('Vehicle Number') }}</label>
                            <div class="col-md-4">
                                <input value="{{$export->vehicle_number}}" id="vehicle_number" type="text" class="form-control @error('vehicle_number') is-invalid @enderror" name="vehicle_number" placeholder="Vehicle Number">
                            </div>
                            <label for="group" class="col-md-2 col-form-label text-md-right">{{ __('Dirver License Number') }}</label>
                            <div class="col-md-4">
                                <input value="{{$export->license_number}}" id="license_number" type="text" class="form-control @error('license_number') is-invalid @enderror" name="license_number" placeholder="Vehicle Registration Number">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="group" class="col-md-2 col-form-label text-md-right">{{ __('Transit Route') }}</label>
                            <div class="col-md-4">
                                <select name="route_id" id="route_id" class="form-control select2" required>
                                    <option value="">Select</option>
                                    @foreach($route as $data)
                                    <option value="{{$data->id}}" {{$export->route_id==$data->id?'selected':''}}>{{$data->route.' - '.$data->exit_point}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="group" class="col-md-2 col-form-label text-md-right">{{ __('Party Bank') }}</label>
                            <div class="col-md-4">
                                <select name="bank_id" id="bank_id" class="form-control select2" required>
                                    <option value="">Select</option>
                                    @foreach($bank as $data)
                                    <option value="{{$data->id}}" {{$export->bank_id==$data->id?'selected':''}}>{{$data->bank}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <hr>
                        <legend>Details</legend>
                        <span>
                            <a href="#" class=" btn btn-sm btn-success addMore"><i class="fa fa-plus"></i>Add
                                Items</a>
                            <span style="float: right;">$1 = Nu <input type="text" id="dollar" name="dollar" class="form-control-sm" readonly value="{{$dollar->rate}}"></span>
                        </span>
                        <hr>
                        <div class="form-group row">
                            <div class="table-responsive">
                                <table class="table table-sm" width="100%" id="tblItem">
                                    <thead>
                                        <tr>
                                            <th>Sl.</th>
                                            <th>Item</th>
                                            <th>Unit</th>
                                            <th>Rate</th>
                                            <th>QTY</th>
                                            <th>$</th>
                                            <th>Nu</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="addMoreProduct">
                                        @foreach($details as $row)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>
                                                <input type="hidden" name="old_quantity[]" class="old_quantity" value="{{$row->under_quantity}}">
                                                <input type="hidden" name="old_id[]" class="old_id" value="{{$row->item_id}}">
                                                <select class="select2 item" name="item[]" required style="width: 340px !important; min-width: 340px; max-width: 340px;">
                                                    <option value="">Select</option>
                                                    @foreach ($item as $data)
                                                    <option data-price="{{$data->dollar_price}}" value=" {{ $data->id }}" {{$row->item_id==$data->id?'selected':''}}>
                                                        {{$data->item}}{{$data->description!=null?'-'.$data->description:''}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div hidden>
                                                    <select class="select2 item1" name="item1[]">
                                                        <option value="">Select</option>
                                                        @foreach ($item as $data)
                                                        <option data-price="{{$data->dollar_price}}" value=" {{ $data->id }}">
                                                            {{$data->item}}{{$data->description!=null?'-'.$data->description:''}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>

                                            <td>
                                                <select class="select2 unit" name="unit[]" required style="width: 70px !important; min-width: 70px; max-width: 70px;">
                                                    <option value=""></option>
                                                    @foreach ($unit as $data)
                                                    <option value=" {{ $data->id }}" {{$row->unit_id==$data->id?'selected':''}}>
                                                        {{$data->unit}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input value="{{$row->rate}}" onClick="this.select();" id="rate" type="number" required step="0.01" class="form-control-sm rate" name="rate[]" autocomplete="off" style="width: 70px !important; min-width: 70px; max-width: 70px;">
                                            </td>
                                            <td>
                                                <input value="{{$row->quantity}}" onClick="this.select();" id="quantity" type="number" required step="0.01" class="form-control-sm quantity" name="quantity[]" autocomplete="off" style="width: 70px !important; min-width: 70px; max-width: 70px;">
                                            </td>

                                            <td>
                                                <input value="{{$row->usd_total}}" id="usd_amount" type="text" class="form-control-sm usd_amount" name="usd_amount[]" readonly style="width: 70px !important; min-width: 70px; max-width: 70px;">
                                            </td>
                                            <td>
                                                <input value="{{$row->total}}" id="amount" type="text" class="form-control-sm amount" name="amount[]" readonly style="width: 90px !important; min-width: 90px; max-width: 90px;">
                                            </td>

                                            <td>
                                                @if($loop->iteration>1)
                                                <a class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <hr>
                            </div>
                            <br><br>
                            <div class="table-responsive col-md-7 offset-md-6">
                                <table class="noBorder table-sm justify-content-md-center">
                                    <tbody class="foot">
                                        <tr>
                                            <td align="right"><small><b>Total</b></small></td>
                                            <td>
                                                <input id="usd_total" type="number" readonly value="{{$export->usd_amount}}" class="form-control-sm" step="0.01" name="usd_total">
                                                <input id="total" type="number" readonly value="{{$export->amount}}" class="form-control-sm" step="0.01" name="total">

                                            </td>
                                        </tr>
                                        <!--
                                        <tr>
                                            <td align="right"><small><b>Discount(-) :</b></small></td>
                                            <td>
                                                <input onClick="this.select();" onkeyup="total_gross();" id="discount" type="number" required value="{{$export->discount}}" class="form-control-sm" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" name="discount">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right"><small>Taxes :</small></td>
                                            <td>
                                                <input onClick="this.select();" onkeyup="total_gross();" id="tax" type="number" required value="{{$export->tax}}" class="form-control-sm tax" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" name="tax">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><small>Transportation Charges :</small></td>
                                            <td>
                                                <input onClick="this.select();" onkeyup="total_gross();" id="freight" type="number" required value="{{$export->freight}}" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" class="form-control-sm" name="freight">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><small>Other Charges :</small></td>
                                            <td>
                                                <input onClick="this.select();" onkeyup="total_gross();" id="other_charges" type="number" required value="{{$export->other_charges}}" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" class="form-control-sm" name="other_charges">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right"><b><small>Grand Total :</small></b></td>
                                            <td>
                                                <input value="{{$export->usd_total}}" id="usd_gross" type="number" required readonly class="form-control-sm" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" name="usd_gross">
                                                <input value="{{$export->total}}" id="gross" type="number" required readonly class="form-control-sm" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" name="gross">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right"><b><small>Under Grand Total :</small></b></td>
                                            <td>
                                                <input id="ugross" type="number" required readonly class="form-control-sm" value="{{$export->under_total}}" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" name="ugross">
                                                <input id="usd_ugross" type="number" required readonly class="form-control-sm" value="{{$export->usd_under_total}}" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" name="usd_ugross">
                                            </td>
                                        </tr>
-->
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label for="group" class="col-md-2 col-form-label text-md-right">{{ __('Net Weight') }}</label>
                                <div class="col-md-2">
                                    <input type="text" id="net_weight" name="net_weight" class="form-control" value="{{$export->net_weight}}" step="0.01" pattern="^\d+(?:\.\d{1,2})?$">
                                </div>
                                <label for="group" class="col-md-2 col-form-label text-md-right">{{ __('Gross Weight') }}</label>
                                <div class="col-md-2">
                                    <input name="gross_weight" id="gross_weight" class="form-control" value="{{$export->gross_weight}}" step="0.01" pattern="^\d+(?:\.\d{1,2})?$">
                                </div>
                            </div>
                            <br>
                            <div class="form-group row">
                                <label for="group" class="col-md-2 col-form-label text-md-right">{{ __('Status') }}</label>
                                <div class="col-md-2">
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Select</option>
                                        <option value="N" {{$export->status=='N'?'selected':''}}>Not Complete</option>
                                        <option value="P" {{$export->status=='P'?'selected':''}}>Partial Transaction</option>
                                        <option value="C" {{$export->status=='C'?'selected':''}}>Complete</option>
                                    </select>
                                </div>
                                <label for="group" class="col-md-2 col-form-label text-md-right">{{ __('Remarks') }}</label>
                                <div class="col-md-6">
                                    <textarea name="remarks" id="remarks" class="form-control" cols="30" rows="2">{{$export->remarks}}</textarea>
                                </div>
                            </div>
                            <br>
                            <hr>
                            {{Form::hidden('_method','PUT')}}
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-5">
                                    <button id="submit" type="submit" class="btn btn-success text-white">
                                        {{ __('Update') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<br><br>
@endsection
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $("input").on("change", function() {
            this.setAttribute(
                "data-date",
                moment(this.value, "YYYY-MM-DD")
                .format(this.getAttribute("data-date-format"))
            )
        }).trigger("change")
        $('.select2').select2();
        $('.addMore').on('click', function() {
            if (document.getElementById("party") == '') {
                alert('Please select Party first.');
                return false;
            }
            var tr = $(this).parent().parent();
            var amt = tr.find('.amount').val();
            var unt = tr.find('.unit').val();
            if (amt == '' || amt < 0 || unt == '') {
                alert('Please complete all the fields first');
                return false;
            }
            var product = $('.item1').html();
            var unit = $('.unit').html();
            var noRows = ($('.addMoreProduct tr').length - 0) + 1;
            var tr = '<tr><td>' + noRows + '</td>' +
                '<td><select class="select2 item" required name="item[]" style="width: 340px !important; min-width: 340px; max-width: 340px;">' + product +
                '</select></td>' +
                '<td><select class="select2 unit" name="unit[]" required style="width: 70px !important; min-width: 70px; max-width: 70px;">' + unit +
                '</select></td>' +
                '<td><input onClick="this.select();" type="number" required step="0.01" class="form-control-sm rate" name="rate[]" autocomplete="off" style="width: 70px !important; min-width: 70px; max-width: 70px;"></td>' +
                '<td><input onClick="this.select();" type="number" required step="0.01" class="form-control-sm quantity" name="quantity[]" autocomplete="off" style="width: 70px !important; min-width: 70px; max-width: 70px;"></td>' +
                '<td><input value="0" id="usd_amount" type="text" class="form-control-sm usd_amount" name="usd_amount[]" readonly style="width: 70px !important; min-width: 70px; max-width: 70px;"></td>' +
                '<td><input id="amount" type="text" class="form-control-sm amount" name="amount[]" readonly style="width: 90px !important; min-width: 90px; max-width: 90px;"></td>' +

                '<td><a class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></a></td> </tr>'
            $('.addMoreProduct').append(tr);
            $('.select2').select2();
            event.preventDefault();
        });
        $('.addMoreProduct').delegate('.delete', 'click', function() {
            if (confirm("Are you sure you want to delete the record?") == true) {
                $(this).parent().parent().remove();
                totalAmount();
            } else {
                return false;
            }
        });
        $('.addMoreProduct').delegate('.quantity', 'keyup', function() {
            var tr = $(this).parent().parent();
            var item = tr.find('.item').val();
            var usd = document.getElementById("dollar").value;
            if (item == '') {
                alert('Select Item first');
                return false;
            }
            var qty = tr.find('.quantity').val() - 0;
            var tot = 0;
            var nutot = 0;
            var price = tr.find('.item option:selected').attr('data-price') - 0 ?? 0;
            tot = (qty * price);
            nutot = (qty * price * usd).toFixed(2);
            tr.find('.amount').val(nutot);
            tr.find('.usd_amount').val(tot);
            totalAmount();
            document.getElementById("submit").disabled = false;
        });
        $('.addMoreProduct').delegate('.rate', 'keyup', function() {
            var tr = $(this).parent().parent();
            var item = tr.find('.item').val();
            var usd = document.getElementById("dollar").value;
            if (item == '') {
                alert('Select Item first');
                return false;
            }
            var qty = tr.find('.quantity').val() - 0;
            var tot = 0;
            var nutot = 0;
            var price = tr.find('.rate').val() - 0;
            tot = (qty * price);
            nutot = (qty * price * usd).toFixed(2);
            tr.find('.amount').val(nutot);
            tr.find('.usd_amount').val(tot);
            totalAmount();
            document.getElementById("submit").disabled = false;
        });
        $('.addMoreProduct').delegate('.item', 'change', function() {
            var row_index = $(this).parent().index();
            var tr = $(this).parent().parent();
            var usd = document.getElementById("dollar").value;
            var price = tr.find('.item option:selected').attr('data-price') - 0;
            var id = tr.find('.item option:selected').val();
            tr.find('.rate').val(price);
            var qty = tr.find('.quantity').val() - 0;

            var amt = (qty * price * usd).toFixed(2);
            var usdamt = (qty * price).toFixed(2);
            tr.find('.amount').val(amt);
            tr.find('.usd_amount').val(usdamt);
            setTimeout(function() {
                tr.find('.unit').focus();
            }, 1);
            totalAmount();
        });
        $('.addMoreProduct').delegate('.unit', 'change', function() {
            var tr = $(this).parent().parent();
            setTimeout(function() {
                tr.find('.quantity').focus();
            }, 1);
        });
    });

    function totalAmount() {
        var tot = 0;
        var tot1 = 0;
        var qty = 0;
        var usdtot = 0;
        var usdtot1 = 0;
        $('.amount').each(function(i, e) {
            var amt = $(this).val() - 0;
            tot += amt;
        });
        $('.usd_amount').each(function(i, e) {
            var amt = $(this).val() - 0;
            usdtot += amt;
        });
        $('.quantity').each(function(i, e) {
            var amt1 = $(this).val() - 0;
            qty += amt1;
        });
        document.getElementById("total").value = tot;
        document.getElementById("usd_total").value = usdtot.toFixed(2);
        document.getElementById("net_weight").value = (qty * 27);
        document.getElementById("gross_weight").value = (qty * 32);
    }

    function total_gross() {
        var usd = document.getElementById("dollar").value - 0;
        var net = document.getElementById("total").value - 0;
        var freight = document.getElementById("freight").value - 0;
        var tax = document.getElementById("tax").value - 0;
        var discount = document.getElementById("discount").value - 0;
        var loading = document.getElementById("other_charges").value - 0;
        var total = ((net + freight + tax + loading) - discount) - 0;
        var usdtotal = (total / usd).toFixed(2);
        document.getElementById("gross").value = total;
        document.getElementById("usd_gross").value = usdtotal;
    }
</script>