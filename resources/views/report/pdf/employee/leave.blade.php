@extends('report.pdf.layout')
@section('title', 'Employee Leave Details')
@section('content')
<table style="width: 100%;">
    <tr>
        <td width="60%">
            <b>Employee Details:</b> <br>
            {{$head->employee_id}} <br>
            {{$head->name}} <br>
        </td>
    </tr>
</table>
<table class="table table-sm noBorder" style="border: none;">
    <tr>
        <th>Sl#</th>
        <th>Leave</th>
        <th>Purpose</th>
        <th>Start</th>
        <th>End</th>
        <th>Days</th>
    </tr>
    @foreach($employee as $data)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$data->Leave->leave}}</td>
        <td>{{$data->purpose}}</td>
        <td>{{date('d/m/Y',strtotime($data->start))}}</td>
        <td>{{date('d/m/Y',strtotime($data->end))}}</td>
        <td align="center">{{$data->days}}</td>
    </tr>
    @endforeach

</table>


@endsection