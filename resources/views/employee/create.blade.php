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
                        <h1>Employee Registration</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">New Registration</li>
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
                    <h3 class="card-title">New Employee</h3>
                </div>
                <div class="card-body p-0">
                    <br>
                    @if (session('error'))
                    <div class="col-sm-12">
                        <div class="alert  alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <form class="custom-form" id="contactForm" method="POST" role="form" action="{{route('employee.store')}}">
                                        @csrf
                                        <div class="tab-content">
                                            <!-----------Personal----------->
                                            <div class="tab tab-pane active border reg" id="personal">
                                                <div class="row ">
                                                    <div class="col-4">
                                                        <label class="fieldlabels">Employee ID: </label>
                                                        <input type="text" name="employee_id" id="employee_id" class="form-control" placeholder="Employee ID" autofocus />
                                                    </div>
                                                    <div class="col-5">
                                                        <label class="fieldlabels">Name: *</label>
                                                        <input type="text" name="name" id="name" class="form-control" placeholder="Full Name" required />
                                                    </div>
                                                    <div class="col-3">
                                                        <label class="fieldlabels">Gender: *</label>
                                                        <select class="form-control" name="gender" id="gender" required>
                                                            <option value="">Select</option>
                                                            <option value="M" {{old('gender')=='M'?'selected':''}}>Male</option>
                                                            <option value="F" {{old('gender')=='F'?'selected':''}}>Female</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <label class="fieldlabels">Date of Birth: *</label>
                                                        <input class="form-control" type="date" name="dob" id="dob" required />
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="fieldlabels">Identity Card No.: *</label>
                                                        <input type="text" class="form-control" name="cidno" id="cidno" placeholder="ID Card No." required />
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="fieldlabels">Contact No.: *</label>
                                                        <input class="form-control" type="text" name="contact_no" id="contact_no" placeholder="Contact No." required />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <label class="fieldlabels">Email: *</label>
                                                        <input class="form-control" type="email" name="email" id="email" placeholder="Valid Email" required />
                                                    </div>
                                                    <div class="col-8">
                                                        <label class="fieldlabels">Address: *</label>
                                                        <input class="form-control" type="text" name="address" id="address" placeholder="Present Residential Address" required />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">
                                                        <label class="fieldlabels">Appointment Date: *</label>
                                                        <input class="form-control" type="date" name="appointment_date" id="appointment_date" required />
                                                    </div>
                                                    <div class="col-3">
                                                        <label class="fieldlabels">Designation: *</label>
                                                        <select name="designation" id="designation" class="form-control" required>
                                                            <option value="">Select</option>
                                                            @foreach($designation as $desi)
                                                            <option value="{{$desi->id}}" {{old('designation')==$desi->id?'selected':''}}>{{$desi->designation}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-3">
                                                        <label class="fieldlabels">Department: *</label>
                                                        <select name="department" id="department" class="form-control" required>
                                                            <option value="">Select</option>
                                                            @foreach($department as $dept)
                                                            <option value="{{$dept->id}}" {{old('department')==$dept->id?'selected':''}}>{{$dept->department}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-3">
                                                        <label class="fieldlabels">Employee Type.: *</label>
                                                        <select name="employee_type" id="employee_type" class="form-control" required>
                                                            <option value="">Select</option>
                                                            @foreach($type as $emp)
                                                            <option value="{{$emp->id}}" {{old('employee_type')==$emp->id?'selected':''}}>{{$emp->type}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">
                                                        <label class="fieldlabels">Bank: *</label>
                                                        <select name="bank" id="bank" class="form-control" required>
                                                            <option value="">Select</option>
                                                            @foreach($bank as $bk)
                                                            <option value="{{$bk->id}}" {{old('bank')==$bk->id?'selected':''}}>{{$bk->bank}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-3">
                                                        <label class="fieldlabels">Account No.: *</label>
                                                        <input class="form-control" type="text" name="account_no" id="account_no" placeholder="Bank Account Number" required />
                                                    </div>
                                                    <div class="col-3">
                                                        <label class="fieldlabels">TPN/TFN No.: *</label>
                                                        <input class="form-control" type="text" name="tpn" id="tpn" placeholder="Tax File/Payment Number" required />
                                                    </div>
                                                    <div class="col-3">
                                                        <label class="fieldlabels">Basic Pay: *</label>
                                                        <input class="form-control" type="number" name="basic_pay" id="basic_pay" step="0.01" value="0" autocomplete="off" required />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">
                                                        <label class="fieldlabels">Allowances: *</label>
                                                        <input class="form-control" type="number" name="allowance" id="allowance" step="0.01" value="0" autocomplete="off" required />
                                                    </div>
                                                    <div class="col-3">
                                                        <label class="fieldlabels">Health Contribution: *</label>
                                                        <input class="form-control" type="number" name="health_contribution" id="health_contribution" step="0.01" value="0" autocomplete="off" required />
                                                    </div>
                                                    <div class="col-3">
                                                        <label class="fieldlabels">Provident Fund: *</label>
                                                        <input class="form-control" type="text" name="provident_fund" id="provident_fund" value="0" step="0.01" required />
                                                    </div>
                                                    <div class="col-3">
                                                        <label class="fieldlabels">Tax/TDS: *</label>
                                                        <input class="form-control" type="number" name="tds" id="tds" step="0.01" value="0" autocomplete="off" required />
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="form-group row mb-0">
                                                    <div class="col-md-8 offset-md-5">
                                                        <button type="submit" class="btn btn-success text-white">
                                                            {{ __('Save') }}
                                                        </button>
                                                    </div>
                                                </div>
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