@extends('report.pdf.layout')
@section('title', 'Payment Receipt')
@section('content')
<center><b>({{$invoice->Type->type}})</b></center>
<table style="width: 100%;">
    <tr>
        <td width="60%">
            <b>From:</b> <br>
            {{$invoice->University->university}} <br>
            {{$invoice->University->address}} <br>
            {{$invoice->University->phone}} <br>
            {{$invoice->University->email}} <br>
        </td>
        <td align="right">
            <b>Ref. No.:</b> COM-{{str_pad($invoice->id,4,'0', STR_PAD_LEFT)}} <br>
            <b>Date:</b> {{date('d M Y',strtotime($invoice->date))}} <br>
            <b>Payment Status:</b> {{$invoice->flag=='P'?'Pending':'Received on '.date('d/m/Y',strtotime($invoice->payment_date))}} <br>
        </td>
    </tr>
</table>
<div class="row">
    <div class="col-md-12 mt-2">
        <hr>
        <table class="table table-sm noBorder" style="border: none;">
            <thead>
                <tr>
                    <th>Sl#</th>
                    <th>Student Name</th>
                    <th>Fee</th>
                    <th>Commission</th>
                    <td align="right"><b>Amount</b></td>
                </tr>
            </thead>
            <tbody>
                @foreach($details as $data)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$data->Student->name}}</td>
                    <td>{{number_format($data->rate,2)}}</td>
                    <td>{{$data->percentage}}</td>
                    <td align="right">{{number_format($data->amount,2)}}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" align="right">Total</th>
                    <td align="right"><b>{{number_format($invoice->amount,2)}}</b></td>
                </tr>
            </tfoot>
        </table>
        <div>
            <b style="background-color: #000; color:#eee">Payment to be made on the due date to the following:</b> <br>
            <b>Account Name</b> {{session('CompanyAccountName')}} <br>
            <b>Account Number</b>: {{session('CompanyAccountNumber')}} <br>
            @if(session('CompanyBSBNumber'))
            <b>BSB Number</b>:{{session('CompanyBSBNumber')}}<br>
            @endif
            <b>Bank</b>: {{session('CompanyBankName')}}<br>
            <b>Branch Name</b>: {{session('CompanyBranchName')}}<br>
            @if(session('CompanyTaxNumber'))
            {{session('CompanyTaxNumber')}}<br>
            @endif
        </div>

    </div>
</div>

@endsection