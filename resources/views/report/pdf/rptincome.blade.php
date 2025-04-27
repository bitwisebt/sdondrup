@extends('report.pdf.layout')
@section('title', 'Income Statement')
@section('content')
<div class="row">
    <div class="col-md-12 mt-2">
        <table class="table table-sm noBorder" style="border: none;">
            <thead>
                <tr>
                    <th>Sl#</th>
                    <th>Date</th>
                    <th>Income Type</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                {{$tot=0;}}
                @foreach($expense as $data)
                
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{date('d-m-Y',strtotime($data->invoice_date))}}</td>
                    <td>{{$data->Income->income}}</td>
                    <td>{{$data->remarks}}</td>
                    <td align="right">{{number_format($data->total,2)}}</td>
                    {{$tot=$tot+$data->total;}}
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" align="right">Total</th>
                    <td align="right"><b>{{number_format($tot,2)}}</b></td>
                </tr>
            </tfoot>
        </table>

    </div>
</div>

@endsection