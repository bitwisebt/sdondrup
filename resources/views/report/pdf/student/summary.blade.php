@extends('report.pdf.layout')
@section('title', 'Registration Summary')
@section('content')
<style>
    table,
    th,
    td {
        border: 1px solid;
        padding-left: 5px;
    }

    th {
        text-align: center;
    }
</style>
<table style="width: 100%;">
    <tr>
        <th>Sl#</th>
        <th>Reg.No.</th>
        <th>Name</th>
        <th>University</th>
        <th>Course Name</th>
        <th>Stage</th>
        <th>Status</th>
    </tr>
    @foreach($report as $data)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$data->registration_number}}</td>
        <td>{{$data->name}}</td>
        <td>{{$data->university}}</td>
        <td>{{$data->course_name}}</td>
        <td>{{$data->status}}</td>
        <td>{{$data->outcome}}</td>
    </tr>
    @endforeach

</table>


@endsection