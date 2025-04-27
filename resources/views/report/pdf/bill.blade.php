@extends('report.pdf.layout')
@section('title', 'Payment Statement')
@section('content')
<table style="width: 100%;">
    <tr>
        <td width="60%">
            <b>Billing Address:</b> <br>
            <div style="padding-left: 15px;">
                {{$bill->Vendor->name}} <br>
                {{$bill->Vendor->address}} <br>
                {{$bill->Vendor->phone}} <br>
                {{$bill->Vendor->email}} <br>
            </div>
        </td>
        <td align="right">
            <b>Bill No.:</b> {{$bill->bill_number}} <br>
            <b>Bill Date:</b> {{date('d M Y',strtotime($bill->bill_date))}} <br>
            <b>Due Date:</b> {{date('d M Y',strtotime($bill->due_date))}} <br>
            <b>Payment Status:</b> {{$bill->flag=='P'?'Pending':'Paid'}} <br>
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
                    <td align="right">{{number_format($bill->amount,2)}}</td>
                </tr>
                <tr>
                    <td colspan="4" align="right">Tax ({{$bill->tax}}%)</td>
                    <td align="right">{{number_format($bill->tax_amount,2)}}</td>
                </tr>
                <tr>
                    <td colspan="4" align="right"><b>Grand Total</b></td>
                    <td align="right"><b>{{number_format($bill->total,2)}}</b></td>
                </tr>
            </tfoot>
        </table>
        <b>Payment Description:</b> {{$bill->remarks}} <br> <br>

    </div>
</div>

@endsection