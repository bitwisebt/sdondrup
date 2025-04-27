@extends('report.pdf.layout')
@section('title', 'RECEIPT')
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
            <b>Payment Date:</b> {{date('d M Y',strtotime($invoice->payment_date))}} <br>
            <b>Payment Mode:</b> 
            @if($invoice->payment_mode=='C')
            Cash
            @elseif($invoice->payment_mode=='B')
            Bank
            @else
            Cheque
            @endif
            <br>
            <b>Payment Status:</b> {{$invoice->flag=='P'?'Pending':'Paid'}} <br>
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
                    <th>Rate</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($details as $data)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$data->description}}</td>
                    <td>{{number_format($data->rate,2)}}</td>
                    <td>{{$data->quantity}}</td>
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

    </div>
</div>

@endsection