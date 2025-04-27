@extends('report.pdf.layout')
@section('title', 'Payroll Summary')
@section('content')
<div class="row">
    <div class="col-md-12 mt-2">
        Pay Date: {{date('d F Y',strtotime($date->generate_date))}} &nbsp;<strong>{{$date->flag=='C'?'(Final)':'(Tentative)'}}</strong>
        <table class="table table-sm fs--1 mb-0" id="myTable" width="100%">
            <thead>
                <tr>
                    <th class="sort border-top ps-3" data-sort="id">Sl#</th>
                    <th class="sort border-top">ID</th>
                    <th class="sort border-top">Name</th>
                    <th class="sort border-top">Designation</th>
                    <th class="sort border-top">Basic Pay</th>
                    <th class="sort border-top">Allowance</th>
                    <th class="sort border-top">Adjust.</th>
                    <th class="sort border-top">Gross Pay</th>
                    <th class="sort border-top">Health Cont.</th>
                    <th class="sort border-top">Provident Fund</th>
                    <th class="sort border-top">Tax</th>
                    <th class="sort border-top">Other Ded.</th>
                    <th class="sort border-top">Total Ded.</th>
                    <th class="sort border-top">Net Pay</th>
                </tr>
            </thead>
            <tbody class="list">
                @php $gross=0; $ded=0; $gt=0; $gd=0; @endphp
                @foreach($report as $data)
                @php 
                $gross=$gross+$data->basic_pay+$data->allowance+$data->adjustment;
                $ded=$ded+$data->health_contribution+$data->provident_fund+$data->tax+$data->deductions;
                @endphp
                <tr>
                    <td class="align-middle ps-3 id">{{$loop->iteration}}</td>
                    <td class="align-middle name">{{$data->Employee->employee_id}}</td>
                    <td class="align-middle name">{{$data->Employee->name}}</td>
                    <td class="align-middle name">{{$data->Employee->Designation->designation}}</td>
                    <td align="right">{{number_format($data->basic_pay,2)}}</td>
                    <td align="right">{{number_format($data->allowance,2)}}</td>
                    <td align="right">{{number_format($data->adjustment,2)}}</td>
                    <td align="right"><b>{{number_format($gross,2)}}</b></td>
                    <td align="right">{{number_format($data->health_contribution,2)}}</td>
                    <td align="right">{{number_format($data->provident_fund,2)}}</td>
                    <td align="right">{{number_format($data->tax,2)}}</td>
                    </td>
                    <td align="right">{{number_format($data->deductions,2)}}</td>
                    <td align="right"><b>{{number_format($data->provident_fund+$data->health_contribution+$data->tax+$data->deductions,2)}}</b>
                    <td align="right"><b>{{number_format($gross-$ded,2)}}</b></td>
                    @php $gt+=$gross; $gd+=$ded; $gross=0; $ded=0; @endphp
                </tr>
                @endforeach
            </tbody>
            <tr>
                <td colspan="7">Grand Total</td>
                <td align="right"><b>{{number_format($gt,2)}}</b></td>
                <td colspan="5"></td>
                <td align="right"><b>{{number_format($gt-$gd,2)}}</b></td>
            </tr>
        </table>

    </div>
</div>
@endsection