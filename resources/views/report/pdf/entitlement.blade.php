@extends('report.pdf.layout')
@section('title', 'Employee Entitlement')
@section('content')
<div class="row">
    <div class="col-md-12 mt-2">
        <table class="table table-bordered table-sm">
            <thead class="thead-light">
                <tr>
                    <th><b>Sl#</b></th>
                    <th><b>Employee ID</b></th>
                    <th><b>Name</b></th>
                    <th><b>Designation</b></th>
                    <th><b>Department</b></th>
                    <th><b>Basic Pay</b></th>
                    <th><b>Allowance</b></th>
                    <th><b>Health Contribution</b></th>
                    <th><b>Provident Fund</b></th>
                    <th><b>Tax</b></th>
                </tr>
            </thead>
            <tbody>
                
                @foreach($report as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->employee_id }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->designation }}</td>
                    <td>{{ $data->department }}</td>
                    <td align="right">{{ number_format($data->basic_pay,2) }}</td>
                    <td align="right">{{ number_format($data->allowance,2) }}</td>
                    <td align="right">{{ number_format($data->health_contribution,2) }}</td>
                    <td align="right">{{ number_format($data->provident_fund,2)}}</td>
                    <td align="right">{{ number_format($data->tds,2)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
       
    </div>
</div>
@endsection