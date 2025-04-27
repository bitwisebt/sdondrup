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
                            <form class="custom-form" id="contactForm" method="POST" role="form" action="{{route('new-application.update',$student->id)}}">
                                @csrf
                                @method('PUT')
                                <div class="tab-content">
                                    <!-----------Personal----------->
                                    <div class="tab tab-pane active border reg" id="personal">
                                        <div class="row ">
                                            <div class="col-4">
                                                <label class="fieldlabels">Name: *</label>
                                                <input type="text" name="name" id="name" class="form-control" value="{{$student->name}}" required />
                                            </div>
                                            <div class="col-4">
                                                <label class="fieldlabels">Email: *</label>
                                                <input type="email" name="email" id="email" class="form-control" value="{{$student->email}}" required />
                                            </div>
                                            <div class="col-4">
                                                <label class="fieldlabels">Contact No.: *</label>
                                                <input type="text" name="contact_number" id="contact_number" class="form-control" value="{{$student->contact_number}}" placeholder="Phone/Mobile number" required />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3">
                                                <label class="fieldlabels">Highest Qualification: *</label>
                                                <select class="form-control" name="qualification" id="qualification" required>
                                                    <option value="">Select</option>
                                                    @foreach($qualification as $quli)
                                                    <option value="{{$quli->id}}" {{$student->qualification_id==$quli->id?'selected':''}}>{{$quli->qualification}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-3">
                                                <label class="fieldlabels">Completion Year: *</label>
                                                <input type="text" class="form-control" name="year" id="year" value="{{$student->education_year}}" placeholder="Year of Completion" required />
                                            </div>
                                            <div class="col-3">
                                                <label class="fieldlabels">English Test: *</label>
                                                <select class="form-control" name="test" id="test" required>
                                                    <option value="">Select</option>
                                                    <option value="Y" {{$student->english_test=='Y'?'selected':''}}>Yes</option>
                                                    <option value="N" {{$student->english_test=='N'?'selected':''}}>No</option>
                                                </select>
                                            </div>
                                            <div class="col-3">
                                                <label class="fieldlabels">Employement Status: *</label>
                                                <select class="form-control" name="employment" id="employment" required>
                                                    <option value="">Select</option>
                                                    <option value="Y" {{$student->employment_status=='Y'?'selected':''}}>Yes</option>
                                                    <option value="N" {{$student->employment_status=='N'?'selected':''}}>No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <button type="submit" class="form-control btn btn-primary">Update</button>
                                    </div>

                                </div>
                            </form>
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
    });

    function validate2() {
        var name = document.getElementById("name").value;
        var sex = document.getElementById("gender").value;
        var cid = document.getElementById("cidno").value;
        var no = document.getElementById("contact_no").value;
        var pass = document.getElementById("passport_no").value;
        var issue = document.getElementById("issue_date").value;
        var expiry = document.getElementById("expiry_date").value;
        var marital = document.getElementById("marital_status").value;
        if (name == '') {
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
        var name = document.getElementById("emergency_name").value;
        var relation = document.getElementById("relation").value;
        var no = document.getElementById("emergency_contact_no").value;
        if (name == '') {
            alert('Conatct person name must be filled.');
            document.getElementById("emergency_name").focus();
            check = false;
        } else if (relation == '') {
            alert('Relation of person must be selected.');
            document.getElementById("relation").focus();
            check = false;
        } else if (no == '') {
            alert('Contact number must be filled.');
            document.getElementById("emergency_contact_no").focus();
            check = false;
        } else {
            check = true;
        }
    }
</script>