@extends('report.pdf.layout')
@section('title', 'Employee Summary')
@section('content')

<table class="table table-sm noBorder" style="border: none;">
    <tr>
        <th>Sl#</th>
        <th>Employee ID</th>
        <th>Name</th>
        <th>Gender</th>
        <th>CID Number</th>
        <th>Contact No.</th>
        <th>Email</th>
        <th>Join Date</th>
        <th>Designation</th>
        <th>Department</th>
        <th>Status</th>
    </tr>
    @foreach($employee as $data)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$data->employee_id}}</td>
        <td>{{$data->name}}</td>
        <td>{{$data->gender=='M'?'Male':'Female'}}</td>
        <td>{{$data->cid_number}}</td>
        <td>{{$data->contact_number}}</td>
        <td>{{$data->email}}</td>
        <td>{{date('d/m/Y',strtotime($data->appointment_date))}}</td>
        <td>{{$data->Designation->designation}}</td>
        <td>{{$data->Department->department}}</td>
        <td>{{$data->flag=='A'?'Active':'Deactivated'}}</td>
    </tr>
    @endforeach

</table>


@endsection