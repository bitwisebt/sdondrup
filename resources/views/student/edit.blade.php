@extends('layouts.app')
@section('content')
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    @include('layouts.header')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    @include('layouts.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Student Registration</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">Registration</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Update Registration</h3>
                </div>
                <div class="card-body p-0">
                    <br>
                    @if ($errors->any())
                    @foreach ($errors->all() as $error)
                    <div class="text-danger">{{$error}}</div>
                    @endforeach
                    @endif
                    @if (session('success'))
                    <div class="col-sm-12">
                        <div class="alert  alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="row">
                                <div class="col-md-2" style="padding-left: 15px;">
                                    <ul class="nav nav-pills nav-pills-icons flex-column" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#personal" role="tab" data-toggle="tab">
                                                Personal
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#qualification" role="tab" data-toggle="tab">
                                                Qualification
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" {{$check==1?'':'hidden'}} id="enr" href="#enrolment" role="tab" data-toggle="tab">
                                                Enrolment
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#proficiency" role="tab" data-toggle="tab">
                                                Proficiency
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#emergency" role="tab" data-toggle="tab">
                                                Emergency
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#agent" role="tab" data-toggle="tab">
                                                Agent
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-10">
                                    <form class="custom-form" id="contactForm" method="POST" role="form" action="{{route('registration.update',$student->id)}}">
                                        @csrf
                                        @method('PUT')
                                        <div class="tab-content">
                                            <!-----------Personal----------->
                                            <div class="tab tab-pane active border reg" id="personal">
                                                <div class="row ">
                                                <div class="col-4">
                                                        <label class="fieldlabels">Type: *</label>
                                                        <select name="type" id="type" class="form-control" required>
                                                            <option value="">Select</option>
                                                            <option value="Onshore" {{$student->type=='Onshore'?'selected':''}}>Onshore</option>
                                                            <option value="Offshore" {{$student->type=='Offshore'?'selected':''}}>Offshore</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="fieldlabels">Registration Type: *</label>
                                                        <select name="registration_type" id="registration_type" class="form-control" required>
                                                            <option value="">Select</option>
                                                            <option value="EV" {{$student->registration_type=='EV'?'selected':''}}>Enrolment & VISA</option>
                                                            <option value="E" {{$student->registration_type=='E'?'selected':''}}>Enrolment Only</option>
                                                            <option value="V" {{$student->registration_type=='V'?'selected':''}}>VISA only</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="fieldlabels">VISA Type: *</label>
                                                        <select name="visa_type" id="visa_type" class="form-control" required>
                                                            <option value="">Select</option>
                                                            @foreach($visa as $vis)
                                                            <option value="{{$vis->id}}" {{$vis->id==$student->visa_type_id?'selected':''}}>{{$vis->visa_type}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row ">
                                                    <div class="col-8">
                                                        <label class="fieldlabels">Name: *</label>
                                                        <input type="text" name="name" id="name" class="form-control" value="{{$student->name}}" required />
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="fieldlabels">Gender: *</label>
                                                        <select class="form-control" name="gender" id="gender" required>
                                                            <option value="">Select</option>
                                                            <option value="M" {{$student->gender=='M'?'selected':''}}>Male</option>
                                                            <option value="F" {{$student->gender=='F'?'selected':''}}>Female</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <label class="fieldlabels">Identity Card No.: *</label>
                                                        <input type="text" class="form-control" name="cidno" id="cidno" value="{{$student->cid_number}}" required />
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="fieldlabels">Contact No.: *</label>
                                                        <input class="form-control" type="text" name="contact_no" id="contact_no" value="{{$student->contact_number}}" required />
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="fieldlabels">Marital Status: *</label>
                                                        <select class="form-control" name="marital_status" id="marital_status" required>
                                                            <option value="">Select</option>
                                                            <option value="M" {{$student->marital_status=='M'?'selected':''}}>Married</option>
                                                            <option value="S" {{$student->marital_status=='S'?'selected':''}}>Single</option>
                                                            <option value="D" {{$student->marital_status=='D'?'selected':''}}>Divorce</option>
                                                            <option value="W" {{$student->marital_status=='W'?'selected':''}}>Widow</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="fieldlabels">Passport No.: *</label>
                                                        <input class="form-control" type="text" name="passport_no" id="passport_no" value="{{$student->passport_number}}" required />
                                                    </div>
                                                    <div class="col-3">
                                                        <label class="fieldlabels">Issue Date: *</label>
                                                        <input class="form-control" type="date" name="issue_date" id="issue_date" value="{{$student->issue_date}}" required />
                                                    </div>
                                                    <div class="col-3">
                                                        <label class="fieldlabels">Expiry Date: *</label>
                                                        <input class="form-control" type="date" name="expiry_date" id="expiry_date" value="{{$student->expiry_date}}" required />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <label class="fieldlabels">Email: *</label>
                                                        <input class="form-control" type="email" name="email" id="email" value="{{$student->email}}" readonly />
                                                    </div>
                                                    <div class="col-8">
                                                        <label class="fieldlabels">Address: *</label>
                                                        <input class="form-control" type="text" name="address" id="address" value="{{$student->present_address}}" required />
                                                    </div>
                                                </div>
                                                <br>
                                                <button class="form-control btn btn-primary next-button" data-target="#qualification">Next</button>
                                            </div>
                                            <br>
                                            <!-----------Qualification----------->
                                            <div class="tab tab-pane reg" id="qualification">
                                                <a href="#" id="Qq" class=" btn btn-sm btn-primary float-right QqMore"><i class="fa fa-plus"></i> Add</a>
                                                <table id="table" class="table table-bordered table-sm" style="font-size: 90.5%;">
                                                    <tr>
                                                        <th>Qualification</th>
                                                        <th>College/school</th>
                                                        <th>Course Name</th>
                                                        <th>Completion Year</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    <tbody class="addMoreQualification" id="QualificationTable">
                                                        @foreach($past as $qul)
                                                        <tr>
                                                            <td>
                                                                <select class="form-control qualification" name="qualification[]" id="qualification" required autofocus>
                                                                    <option value="">Select</option>
                                                                    @foreach($qualification as $qui)
                                                                    <option value="{{$qui->id}}" {{$qul->qualification_id==$qui->id?'selected':''}}>{{$qui->qualification}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control school_name" type="text" name="school_name[]" id="school_name" value="{{$qul->school_name}}" required />
                                                            </td>
                                                            <td>
                                                                <input class="form-control course_name" type="text" name="course_name[]" id="course_name" value="{{$qul->course_name}}" required />
                                                            </td>
                                                            <td>
                                                                <input class="form-control completion_date" type="number" name="completion_date[]" id="completion_date" min="1990" value="{{$qul->completion_year}}" autocomplete="off" />
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <button class="form-control btn btn-primary next-button" id="h1" {{$check==0?'hidden':''}} data-target="#enrolment">Next</button>
                                                <button class="form-control btn btn-primary next-button" id="h2" {{$check==1?'hidden':''}} data-target="#proficiency">Next</button>
                                            </div>
                                            @if($check==1)
                                            <!-----------Enrolment----------->
                                            <div class="tab tab-pane reg" id="enrolment">

                                                <table id="table" class="table table-bordered table-sm" style="font-size: 90.5%;">
                                                    <tr>
                                                        <th>Study</th>
                                                        <th>University</th>
                                                        <th>Field of Study</th>
                                                        <th>Intake Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    <tbody class="addMoreEnrolment" id="EnrolmentTable">
                                                        <tr>
                                                            <td>
                                                                <select class="form-control" name="enrolment" id="enrolment" required>
                                                                    <option value="">Select</option>
                                                                    @foreach($enrol as $enr)
                                                                    <option value="{{$enr->id}}" {{$study->study_id==$enr->id?'selected':''}}>{{$enr->enrolment}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control" name="organization" id="organization" required>
                                                                    <option value="">Select</option>
                                                                    @foreach($university as $uni)
                                                                    <option value="{{$uni->id}}" {{$study->university_id==$uni->id?'selected':''}}>{{$uni->university}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="text" name="course" id="course" value="{{$study->course_name}}" required />
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="month" name="start" id="start" value="{{$study->start}}" required />
                                                            </td>
                                                            <td>
                                                                <input type="hidden" id="study_id" name="study_id" value="{{$study->id}}">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <button class="form-control btn btn-primary next-button" data-target="#proficiency">Next</button>
                                            </div>
                                            @endif
                                            <!-----------Proficiency----------->
                                            <div class="tab tab-pane reg" id="proficiency">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="fieldlabels">English Test: *</label>
                                                        <select class="form-control" name="test" id="test" required>
                                                            <option value="">Select</option>
                                                            @foreach($test as $tt)
                                                            <option value="{{$tt->id}}" {{$proficiency->test_id==$tt->id?'selected':''}}>{{$tt->sht_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="fieldlabels">Score Band: *</label>
                                                        <input class="form-control" type="number" step="0.01" name="total" id="total" value="{{$proficiency->total}}" required autocomplete="off" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                <div class="col-6">
                                                        <label class="fieldlabels">Listening: *</label>
                                                        <input class="form-control" type="number" step="0.01" name="listening" id="listening" value="{{$proficiency->listening}}" autocomplete="off" required />
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="fieldlabels">Reading: *</label>
                                                        <input class="form-control" type="number" step="0.01" name="reading" id="reading" value="{{$proficiency->reading}}" autocomplete="off" required />
                                                    </div>
                                                    
                                                    <div class="col-6">
                                                        <label class="fieldlabels">Speaking: *</label>
                                                        <input class="form-control" type="number" step="0.01" name="speaking" id="speaking" value="{{$proficiency->speaking}}" autocomplete="off" required />
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="fieldlabels">Writing: *</label>
                                                        <input class="form-control" type="number" step="0.01" name="writing" id="writing" value="{{$proficiency->writing}}" autocomplete="off" required />
                                                    </div>
                                                    <br>
                                                </div>
                                                <br>
                                                <button class="form-control btn btn-primary next-button" data-target="#emergency">Next</button>
                                            </div>
                                            <!-----------Emergency----------->
                                            <div class="tab tab-pane reg" id="emergency">
                                                <a href="#" id="add" class=" btn btn-sm btn-primary float-right addMore"><i class="fa fa-plus"></i> Add</a>
                                                <table id="table" class="table table-bordered table-sm">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Relation</th>
                                                        <th>Contact</th>
                                                        <th>Email</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    <tbody class="addMoreTravel" id="TravelTable">
                                                        @foreach($emergency as $emr)
                                                        <tr>
                                                            <td>
                                                                <input class="form-control emergency_name" type="text" name="emergency_name[]" id="emergency_name" value="{{$emr->name}}" required />
                                                            </td>
                                                            <td>
                                                                <select class="form-control relation" name="relation[]" id="relation" required>
                                                                    <option value="">Select</option>
                                                                    @foreach($relation as $rel)
                                                                    <option value="{{$rel->id}}" {{$emr->relation_id==$rel->id?'selected':''}}>{{$rel->relation}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control emergency_contact_no" type="text" name="emergency_contact_no[]" id="emergency_contact_no" value="{{$emr->contact_number}}" required />
                                                            </td>
                                                            <td>
                                                                <input class="form-control emergency_email" type="text" name="emergency_email[]" id="emergency_email" value="{{$emr->email}}" />
                                                            </td>
                                                            <td>
                                                                @if($loop->iteration>1)
                                                                <a class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-----------Emergency----------->
                                            <div class="tab tab-pane reg" id="agent">
                                                <table id="table" class="table table-bordered table-sm">
                                                    <tr>
                                                        <th>Super Agent</th>
                                                        <th>Sub Agent</th>
                                                        <th>Assign To</th>
                                                    </tr>
                                                    <tbody class="addMoreTravel" id="TravelTable">
                                                        <tr>
                                                            <td>
                                                                <select class="form-control" name="super_agent" id="super_agent" required>
                                                                    <option value="">Select</option>
                                                                    @foreach($agent as $sa)
                                                                    <option value="{{$sa->id}}" {{$sa->id==$student->super_agent_id?'selected':''}}>{{$sa->agent}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control" name="sub_agent" id="sub_agent" required>
                                                                    <option value="">Select</option>
                                                                    @foreach($agent as $sua)
                                                                    <option value="{{$sua->id}}" {{$sua->id==$student->sub_agent_id?'selected':''}}>{{$sua->agent}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control" name="user" id="user" required>
                                                                    <option value="">Select</option>
                                                                    @foreach($user as $use)
                                                                    <option value="{{$use->id}}" {{$use->id==$student->created_by?'selected':''}}>{{$use->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <div class="col-md-8 offset-md-5">
                                                <button type="submit" class="btn btn-success text-white">
                                                    {{ __('Update') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <!-- /.card-body -->
                </div>

                <br>
                <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    @include('layouts.footer')
</div>
@endsection
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        const nextButtons = document.querySelectorAll('.next-button');
        nextButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const currentTab = button.parentElement;
                const nextTabId = button.getAttribute('data-target');
                const nextTab = document.querySelector(nextTabId);
                switch (nextTabId) {
                    case '#qualification':
                        validate2();
                        break;
                    case '#enrolment':
                        validate3();
                        break;
                    case '#proficiency':
                        validate4();
                        break;
                    case '#emergency':
                        validate6();
                        break;
                    case '#agent':
                        validate5();
                        break;
                    default:
                        check == true;
                        break;
                }
                if (check == true) {
                    if (nextTab) {
                        // Hide current tab content
                        currentTab.classList.remove('active');
                        // Show next tab content
                        nextTab.classList.add('active');

                        // Update navigation link active state
                        const currentNavLink = document.querySelector('a[href="' + nextTabId + '"]');
                        const allNavLinks = document.querySelectorAll('.nav-link');
                        allNavLinks.forEach(link => {
                            link.classList.remove('active');
                        });
                        currentNavLink.classList.add('active');
                    }
                }
            });
        });
    });
    $(document).ready(function() {
        $('.addMore').on('click', function() {
            var traveltype = $('.relation').html();
            var tr = '<tr><td>' +
                '<input class = "form-control emergency_name" type="text" name="emergency_name[]" id="emergency_name" placeholder="Contact Person name" required /></td>' +
                '<td><select class="form-control relation" name="relation[]" id="relation">' + traveltype +
                '</select></td>' +
                '<td><input class="form-control emergency_contact_no" type="text" name="emergency_contact_no[]" id="emergency_contact_no" placeholder="Contact Number" required />' +
                '</td><td>' +
                '<input class="form-control emergency_email" type="text" name="emergency_email[]" id="emergency_email" placeholder="Email" /></td>' +
                '<td><a class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></a></td> </tr>'
            $('.addMoreTravel').append(tr);
        });
        $('.addMoreTravel').delegate('.delete', 'click', function() {
            $(this).parent().parent().remove();
        });

        $('.QqMore').on('click', function() {
            var qulification = $('.qualification').html();
            var tr = '<tr>' +
                '<td><select class="form-control qualification" name="qualification[]" id="qualification">' + qulification + '</select></td>' +
                '<td><input class="form-control school_name" type="text" name="school_name[]" id="school_name" placeholder="College/School Name" required /></td>' +
                '<td><input class="form-control course_name" type="text" name="course_name[]" id="course_name" placeholder="Name of course" required /></td>' +
                '<td><input class="form-control completion_date" type="number" name="completion_date[]" id="completion_date" min="1990" /></td>' +
                '<td><a class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></a></td> </tr>'
            $('.addMoreQualification').append(tr);
        });
        $('.addMoreQualification').delegate('.delete', 'click', function() {
            $(this).parent().parent().remove();
        });

        $('.enlMore').on('click', function() {
            var noRows = ($('.addMoreEnrolment tr').length - 0) + 1;
            var type = $('.type').html();
            var tr = '<tr><td>' + noRows + '</td>' +
                '<td><select class="form-control type" name="type[]" id="type">' + type + '</select></td>' +
                '<td><input class="form-control organization" type="text" name="organization[]" id="organization" placeholder="University/College Name" required /></td>' +
                '<td><input class="form-control course" type="text" name="course[]" id="course" placeholder="Name of course" required /></td> ' +
                '<td><input class="form-control start" type="month" name="start[]" id="start" required /></td>' +
                '<td><a class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></a></td> </tr>'
            $('.addMoreEnrolment').append(tr);
        });
        $('.addMoreEnrolment').delegate('.delete', 'click', function() {
            $(this).parent().parent().remove();
        });
        $("#registration_type").on('change', function(e) {
            console.log(e);
            var id = e.target.value;
            $.get('/json-visa?id=' + id, function(data) {
                console.log(data);
                $('#visa_type').empty();
                $('#visa_type').append('<option value="">Select VISA</option>');
                $.each(data, function(index, ageproductObj) {
                    $('#visa_type').append('<option value="' + ageproductObj.id + '">' + ageproductObj.visa_type + '</option>');
                })
            });
            var x = document.getElementById("enr");
            if (id == 'V') {
                x.style.display = "none";
                document.getElementById("h1").hidden = false;
                document.getElementById("h2").hidden = true;
            } else {
                x.style.display = "block";

                document.getElementById("h2").hidden = false;
                document.getElementById("h1").hidden = true;
            }


        });
        $("#name").on('change', function(e) {
            console.log(e);
            var id = $(this).find('option:selected').data('price');
            $.ajax({
                url: '/json-application',
                type: "GET",
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    if (data.length == 1) {
                        $("#sid").val(data[0]['id']);
                        $("#contact_no").val(data[0]['contact_number']);
                        $("#email").val(data[0]['email']);
                        var aa = data[0]['qualification_id'];
                        $('#qualification option[value="' + aa + '"]').attr("selected", "selected");
                        $("#completion_date").val(data[0]['education_year']);
                    }
                }
            });

        });
    });

    function pull() {

    }

    function validate2() {
        var visa_type = document.getElementById("visa_type").value;
        var name = document.getElementById("name").value;
        var sex = document.getElementById("gender").value;
        var cid = document.getElementById("cidno").value;
        var no = document.getElementById("contact_no").value;
        var pass = document.getElementById("passport_no").value;
        var issue = document.getElementById("issue_date").value;
        var expiry = document.getElementById("expiry_date").value;
        var marital = document.getElementById("marital_status").value;
        if (visa_type == '') {
            alert('Type of VISA must be selected.');
            document.getElementById("visa_type").focus();
            check = false;
        } else if (name == '') {
            alert('Name must be filled.');
            document.getElementById("name").focus();
            check = false;
        } else if (sex == '') {
            alert('Gender must be selected.');
            document.getElementById("gender").focus();
            check = false;
        } else if (cid == '') {
            alert('CID number must be filled.');
            document.getElementById("cidno").focus();
            check = false;
        } else if (no == '') {
            alert('Contact number must be filled.');
            document.getElementById("contact_no").focus();
            check = false;
        } else if (pass == '') {
            alert('Passport number must be filled.');
            document.getElementById("comment").focus();
            check = false;
        } else if (marital == '') {
            alert('Marital status must be slected.');
            document.getElementById("marital_status").focus();
            check = false;
        } else {
            check = true;
        }
    }

    function validate3() {
        var add = document.getElementById("qualification").value;
        var dzo = document.getElementById("school_name").value;
        var geo = document.getElementById("course_name").value;
        var vil = document.getElementById("completion_date").value;
        if (add == '') {
            alert('Qualification must be Selected.');
            document.getElementById("qualification").focus();
            check = false;
        } else if (dzo == '') {
            alert('School Name must be filled.');
            document.getElementById("school_name").focus();
            check = false;
        } else if (geo == '') {
            alert('Course Name must be filled.');
            document.getElementById("course_name").focus();
            check = false;
        } else if (completion_date == '') {
            alert('Completion year must be filled.');
            document.getElementById("completion_date").focus();
            check = false;
        } else {
            check = true;
        }
    }

    function validate4() {
        if (document.getElementById("registration_type").value != 'V') {
            var agent = document.getElementById("enrolment").value;
            var org = document.getElementById("organization").value;
            var course = document.getElementById("course").value;
            var start = document.getElementById("start").value;
            if (agent == '') {
                alert('Enrolment must be selected.');
                document.getElementById("agent").focus();
                check = false;
            } else if (org == '') {
                alert('University/college/institute must be entered.');
                document.getElementById("organization").focus();
                check = false;
            } else if (course == '') {
                alert('Course must be entered.');
                document.getElementById("course").focus();
                check = false;
            } else if (start == '') {
                alert('Start date must be filled.');
                document.getElementById("start").focus();
                check = false;
            } else {
                check = true;
            }
        }
    }

    function validate5() {
        var test = document.getElementById("test").value;
        var read = document.getElementById("reading").value;
        var write = document.getElementById("writing").value;
        var listen = document.getElementById("listening").value;
        var speak = document.getElementById("speaking").value;
        var total = document.getElementById("total").value;
        if (test == '') {
            alert('Test type must be selected.');
            document.getElementById("test").focus();
            check = false;
        } else if (read == '') {
            alert('Reading score must be filled.');
            document.getElementById("reading").focus();
            check = false;
        } else if (write == '') {
            alert('Writing score must be filled.');
            document.getElementById("writing").focus();
            check = false;
        } else if (listen == '') {
            alert('Listening score must be selected.');
            document.getElementById("listening").focus();
            check = false;
        } else if (speak == '') {
            alert('Speaking score must be filled.');
            document.getElementById("speaking").focus();
            check = false;
        } else if (total == '') {
            alert('Score Band must be filled.');
            document.getElementById("total").focus();
            check = false;
        } else {
            check = true;
        }
    }

    function validate6() {
        var sp = document.getElementById("super_agent").value;
        var sub = document.getElementById("sub_agent").value;
        if (sp == '') {
            alert('Super Agent must be selected.');
            document.getElementById("super_agent").focus();
            check = false;
        } else if (sub == '') {
            alert('Sub Agent must be selected.');
            document.getElementById("sub_agent").focus();
            check = false;
        } else {
            check = true;
        }
    }
</script>