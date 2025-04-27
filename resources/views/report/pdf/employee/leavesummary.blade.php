@extends('report.pdf.layout')
@section('title', 'Employee Leave Summary')
@section('content')
<style>
    th {
        border: 1px solid;
    }

    th {
        text-align: center;
    }
    td {
        padding-left: 5px;
    }
</style>
<table style="width: 100%;">
    <tr>
        <th>Sl#</th>
        <th>Employee ID</th>
        <th>Name</th>
        <th>Gender</th>
        <th colspan="{{count($config)}}">Leave</th>

    </tr>
    @foreach($employee as $data)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$data->employee_id}}</td>
        <td>{{$data->name}}</td>
        <td>{{$data->gender=='M'?'Male':'Female'}}</td>
        @foreach($config as $fig)
        @foreach($ycfg as $f)
        @if($data->id==$f->employee_id)
        @if($fig->id==$f->leave_id)
        <td>{{$fig->leave.': '.$f->balance}}</td>
        @endif
        @endif
        @endforeach
        @endforeach

    </tr>
    @endforeach

</table>


@endsection