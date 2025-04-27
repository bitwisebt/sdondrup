@extends('report.pdf.layout')
@section('title', 'Registration Details')
@section('content')

<h5>Bio-data</h5>
<table style="width: 100%;">
    <tr>
        <td><b>Registration No.:</b> {{$details->registration_number}}</td>
        <td><b>Name:</b> {{$details->name}}</td>
        <td><b>Gender:</b> {{$details->gender=='M'?'Male':'Female'}}</td>
    </tr>
    <tr>
        <td><b>CID No.:</b> {{$details->cid_number}}</td>
        <td><b>Contact No.:</b> {{$details->contact_number}}</td>
        <td><b>Email:</b> {{$details->email}}</td>
    </tr>
    <tr>
        <td><b>Passport No.:</b> {{$details->passport_number}}</td>
        <td><b>Issue Date:</b> {{date('d M Y',strtotime($details->issue_date))}}</td>
        <td><b>Expiry Date:</b> {{date('d M Y',strtotime($details->expiry_date))}}</td>
    </tr>
    <tr>
        <td colspan="2"><b>Address:</b> {{$details->present_address}}</td>
        <td><b>Marital Status:</b> {{$details->marital_status=='M'?'Male':'Single'}}</td>
    </tr>
</table>
<hr>
<h5>English Proficiency ({{$proficiency->Test->sht_name}})</h5>
<table style="width: 100%;">
    <tr>
        <td><b>Score Band:</b> {{$proficiency->total}}</td>
        <td><b>Reading:</b> {{$proficiency->reading}}</td>
        <td><b>Writing:</b> {{$proficiency->writing}}</td>
        <td><b>Listening:</b> {{$proficiency->listening}}</td>
        <td><b>Speaking:</b> {{$proficiency->speaking}}</td>
    </tr>
</table>
<hr>
<h5>Qualification History</h5>
<table style="width: 100%;">
    <tr>
        <th>Sl#</th>
        <th>Qualification</th>
        <th>Institute</th>
        <th>Course/Field</th>
        <th>Year</th>
    </tr>
    @foreach($past as $quali)
    <tr>
        <td>{{$loop->iteration}}. </td>
        <td>{{$quali->Qualification->qualification}}</td>
        <td>{{$quali->school_name}}</td>
        <td>{{$quali->course_name}}</td>
        <td>{{$quali->completion_year}}</td>
    </tr>
    @endforeach
</table>
<hr>
<h5>Emergency Contact Details</h5>
<table style="width: 100%;">
    <tr>
        <th>Sl#</th>
        <th>Name</th>
        <th>Relation</th>
        <th>Contact No.</th>
        <th>Email</th>
    </tr>
    @foreach($emergency as $emr)
    <tr>
        <td>{{$loop->iteration}}. </td>
        <td>{{$emr->name}}</td>
        <td>{{$emr->Emergency->relation}}</td>
        <td>{{$emr->contact_number}}</td>
        <td>{{$emr->email}}</td>
    </tr>
    @endforeach
</table>
@if($details->study_id!=null)
<hr>
<h5>Enrolment Details</h5>
<table style="width: 100%;">
    <tr>
        <td><b>University:</b> {{$study->University->university}}</td>
        <td><b>Course:</b> {{$study->course_name}}</td>
        <td><b>Start Date:</b> {{date('d M Y',strtotime($study->start))}}</td>
    </tr>
</table>
@endif

@endsection