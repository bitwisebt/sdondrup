@extends('report.pdf.layout')
@section('title', 'INVOICE')
@section('content')
<table style="width: 100%;">
    <tr>
        <td width="60%">
            <b>To:</b> <br>
            {{$invoice->Customer->name}} <br>
            {{$invoice->Customer->address}} <br>
            {{$invoice->Customer->phone}} <br>
            {{$invoice->Customer->email}} <br>
        </td>
        <td align="right">
            <b>Invoice No.:</b> INV-{{str_pad($invoice->id,4,'0', STR_PAD_LEFT)}} <br>
            <b>Invoice Date:</b> {{date('d M Y',strtotime($invoice->invoice_date))}} <br>
            <b>Due Date:</b> {{date('d M Y',strtotime($invoice->due_date))}} <br>
            <b>Payment Status:</b> {{$invoice->flag=='P'?'Pending':'Paid on '.date('d/m/Y',strtotime($invoice->payment_date))}} <br>
        </td>
    </tr>
</table>
<div class="row">
    <div class="col-md-12 mt-2">
        <table class="table table-sm noBorder" style="border: none;">
            <thead>
                <tr>
                    <th>Sl#</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <td align="right"><b>Amount</b></td>
                </tr>
            </thead>
            <tbody>
                @foreach($details as $data)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$data->description}}</td>
                    <td>{{$data->quantity}}</td>
                    <td>{{number_format($data->rate,2)}}</td>
                    <td align="right">{{number_format($data->amount,2)}}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td align="right" colspan="4">Total</td>
                    <td align="right">{{number_format($invoice->amount,2)}}</td>
                </tr>
                <tr>
                    <td colspan="4" align="right">Tax ({{$invoice->tax}}%)</td>
                    <td align="right">{{number_format($invoice->tax_amount,2)}}</td>
                </tr>
                <tr>
                    <td colspan="4" align="right"><b>Grand Total</b></td>
                    <td align="right"><b>{{number_format($invoice->total,2)}}</b></td>
                </tr>
            </tfoot>
        </table>
        <b>Note:</b> {{$invoice->remarks}} <br> <br>
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