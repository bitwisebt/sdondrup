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
                        <h1>Payroll Adjustment/Deduction</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/finance-payroll/view/{{$payroll->header_id}}">Payroll</a></li>
                            <li class="breadcrumb-item active">Payroll Adjustment/Deduction</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-body">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <div class="card">
                                    <div class="card-header p-3 mb-2 text-dark">
                                        <h3 class="card-title">Update Adjustment & Deduction</h3>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="{{route('finance-payroll.update',$payroll->id)}}">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group row">
                                                <a href="#" id="Qq" class=" btn btn-sm btn-primary float-right adjMore"><i class="fa fa-plus"></i> Add</a>
                                                &nbsp;
                                                <h5>(+)Adustments</h5>

                                                <table id="table" class="table table-bordered table-sm" style="font-size: 90.5%;">
                                                    <tr>
                                                        <th>Description</th>
                                                        <th>Amount</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    <tbody class="addMoreAdjust" id="AdjustTable">
                                                        @foreach($adjustment as $adj)
                                                        <tr>
                                                            <td>
                                                                <input class="form-control adjustment" type="text" name="adjustment[]" id="adjustment" value="{{$adj->remarks}}" required />
                                                            </td>
                                                            <td>
                                                                <input class="form-control adjust_amount" type="number" name="adjust_amount[]" id="adjust_amount" value="{{$adj->amount}}" required />
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <br>
                                            <div class="form-group row">
                                                <a href="#" id="enl" class=" btn btn-sm btn-primary float-right dedMore"><i class="fa fa-plus"></i> Add</a>&nbsp;
                                                <h5>(-)Deductions</h5>

                                                <table id="table" class="table table-bordered table-sm" style="font-size: 90.5%;">
                                                    <tr>
                                                        <th>Description</th>
                                                        <th>Amount</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    <tbody class="addMoreDeduct" id="DeductTable">
                                                        @foreach($deduct as $ded)
                                                        <tr>
                                                            <td>
                                                                <input class="form-control deduction" type="text" name="deduction[]" id="deduction" value="{{$ded->remarks}}" required />
                                                            </td>
                                                            <td>
                                                                <input class="form-control deduction_amount" type="number" name="deduction_amount[]" id="deduction_amount" value="{{$ded->amount}}" required />
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <hr>
                                            <div class="form-group row">
                                                <table class="table table-bordered table-sm" style="font-size: 90.5%;">
                                                    <tfoot>
                                                        <tr>
                                                            <td align="right"><small><b>Total Adjustments</b></small></td>
                                                            <td>
                                                                <input id="total_adjust"  type="number" readonly value="{{$payroll->adjustment}}" class="form-control-sm" step="0.01" name="total_adjust">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="right"><small><b>Total Deductions</b></small></td>
                                                            <td>
                                                                <input id="total_deduct" type="number" readonly value="{{$payroll->deductions}}" class="form-control-sm" step="0.01" name="total_deduct">
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-5">
                                            <button type="submit" class="btn btn-info text-white">
                                                {{ __('Update') }}
                                            </button>
                                        </div>
                                    </div>
                                    </form>
                                    <br>
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
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.adjMore').on('click', function() {
            var tr = '<tr><td>' +
                '<input class="form-control adjustment" type="text" name="adjustment[]" id="adjustment" value="" required />' +
                '</td><td>' +
                '<input class="form-control adjust_amount" type="number" name="adjust_amount[]" id="adjust_amount" value="" required />' +
                '</td><td>' +
                '<a class="btn btn-sm btn-phoenix-info delete"><i class="fa fa-trash text-danger"></i></a></td> </tr>'
            $('.addMoreAdjust').append(tr);
        });
        $('.addMoreAdjust').delegate('.delete', 'click', function() {
            $(this).parent().parent().remove();
            totalAmount();
        });

        $('.dedMore').on('click', function() {
            var tr = '<tr>' +
                '<td>' +
                '<input class="form-control deduction" type="text" name="deduction[]" id="deduction" value="" required />' +
                '</td><td>' +
                '<input class="form-control deduction_amount" type="number" name="deduction_amount[]" id="deduction_amount" value="" required />' +
                '</td><td>' +
                '<a class="btn btn-sm btn-phoenix-info delete"><i class="fa fa-trash text-danger"></i></a>' +
                '</td> </tr>'
            $('.addMoreDeduct').append(tr);
        });
        $('.addMoreDeduct').delegate('.delete', 'click', function() {
            $(this).parent().parent().remove();
            totalAmount();
        });
        $('.addMoreDeduct').delegate('.deduction_amount', 'keyup', function() {
            totalAmount();
        });
        $('.addMoreAdjust').delegate('.adjust_amount', 'keyup', function() {
            totalAmount();
        });
    });
    function totalAmount() {
        var atot = 0;
        var dtot = 0;
        $('.adjust_amount').each(function(i, e) {
            var amt = $(this).val() - 0;
            atot += amt;
        });
        $('.deduction_amount').each(function(i, e) {
            var amt = $(this).val() - 0;
            dtot += amt;
        });
        
        document.getElementById("total_adjust").value = atot.toFixed(2);
        document.getElementById("total_deduct").value = dtot.toFixed(2);
    }
</script>