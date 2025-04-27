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
                            <li class="breadcrumb-item"><a href="/employee">Employee</a></li>
                            <li class="breadcrumb-item active">View</li>
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
                    <h3 class="card-title">Employee Registration</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm fs--1 mb-0">
                        <tr>
                            <th width="30%">Designation</th>
                            <td>{{$employee->Designation->designation}}</td>
                        </tr>
                        <tr>
                            <th>Department</th>
                            <td>{{$employee->Department->department}}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{$employee->name}}</td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td>{{$employee->gender=='M'?'Male':'Female'}}</td>
                        </tr>
                        <tr>
                            <th>Date of Birth</th>
                            <td>{{date('d-m-Y',strtotime($employee->dob))}}</td>
                        </tr>
                        <tr>
                            <th>Contact Number</th>
                            <td>{{$employee->contact_number}}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{$employee->email}}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{$employee->address}}</td>
                        </tr>
                        <tr>
                            <th>Appoinment Date</th>
                            <td>{{date('d-m-Y',strtotime($employee->appointment_date))}}</td>
                        </tr>
                        <tr>
                            <th>Employement Type</th>
                            <td>{{$employee->EmployeeType->type}}</td>
                        </tr>
                        <tr>
                            <th>Basic Pay</th>
                            <td>{{$entitle->basic_pay}}</td>
                        </tr>
                        <tr>
                            <th>Bank Account No.</th>
                            <td>{{$employee->account_number.'('.$employee->Bank->bank.')'}}</td>
                        </tr>
                        <tr>
                            <th>Tax Number</th>
                            <td>{{$employee->tpn}}</td>
                        </tr>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    @include('layouts.footer')
</div>
@endsection