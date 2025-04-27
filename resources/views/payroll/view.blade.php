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
                        <h1>Payroll Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/payroll">Payroll</a></li>
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
                    <h3 class="card-title">Employee Payroll Details</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm fs--1 mb-0" id="myTable" width="100%">
                            <thead>
                                <tr>
                                    <th class="sort border-top ps-3" data-sort="id">Sl#</th>
                                    <th class="sort border-top">ID</th>
                                    <th class="sort border-top">Name</th>
                                    <th class="sort border-top">Designation</th>
                                    <th class="sort border-top">BPay</th>
                                    <th class="sort border-top">Allw</th>
                                    <th class="sort border-top">Adjust.</th>
                                    <th class="sort border-top">HC</th>
                                    <th class="sort border-top">PF</th>
                                    <th class="sort border-top">Tax</th>
                                    <th class="sort border-top">Ded</th>
                                    <th class="sort border-top">Net Pay</th>
                                    <th class="sort text-center align-middle pe-0 border-top ps-1" scope="col">ACTION</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @can('Payroll access')
                                @forelse($payroll as $data)
                                <tr>
                                    <td class="align-middle ps-3 id">{{$loop->iteration}}</td>
                                    <td class="align-middle name">{{$data->Employee->employee_id}}</td>
                                    <td class="align-middle name">{{$data->Employee->name}}</td>
                                    <td class="align-middle name">{{$data->Employee->Designation->designation}}</td>
                                    <td align="right">{{number_format($data->basic_pay,2)}}</td>
                                    <td align="right">{{number_format($data->allowance,2)}}</td>
                                    <td align="right">{{number_format($data->adjustment,2)}}</td>
                                    <td align="right">{{number_format($data->health_contribution,2)}}</td>
                                    <td align="right">{{number_format($data->provident_fund,2)}}</td>
                                    <td align="right">{{number_format($data->tax,2)}}</td>
                                    <td align="right">{{number_format($data->deduction,2)}}</td>
                                    <td align="right">{{number_format($data->basic_pay+$data->allowance+$data->adjustment-($data->health_contribution+$data->provident_fund+$data->tax+$data->deduction),2)}}</td>
                                    <td class="align-middle white-space-nowrap text-center pe-0">
                                        <a class="btn btn-sm btn-phoenix-info me-1 fs--2 " href="{{route('payroll.payslip',$data->id)}}" target="_blank"><span class="fas fa-print text-primary"></span> </a>
                                    </td>

                                </tr>
                                @empty
                                @endforelse
                                @endcan
                            </tbody>
                        </table>
                    </div>
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