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
                        <h1>Employee Payroll</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">Payroll</li>
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
                    <h3 class="card-title">Employee Payroll</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        @can('Payroll edit')
                        <button type="button" class="btn btn-sm btn-phoenix-info me-1 fs--2" data-toggle="modal" data-target="#remove"><i class="fa fa-gas-pump text-success" aria-hidden="true"></i> Generate</button>
                        <div class="modal fade" id="remove" tabindex="-1" role="dialog" aria-labelledby="removeTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="removeTitle">New Payroll</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <form method="POST" action="{{route('payroll.store')}}">
                                            @csrf
                                            <div class="form-group row">
                                                <label for="station" class="col-md-4 col-form-label text-md-right">Pay Period</label>
                                                <div class="col-md-8">
                                                    <input id="pay_period" type="month" class="form-control" name="pay_period" value="{{ date('Y-m') }}" required autofocus />
                                                </div>
                                            </div>

                                            <div class="form-group row mb-0">
                                                <div class="col-md-8 offset-md-5">
                                                    <button type="submit" class="btn btn-info text-white">
                                                        {{ __('Generate') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm fs--1 mb-0" id="myTable" width="90%">
                        <thead>
                            <tr>
                                <th class="sort border-top ps-3" data-sort="id">Sl#</th>
                                <th class="sort border-top">Pay Period</th>
                                <th class="sort border-top">Date</th>
                                <th class="sort border-top">Status</th>
                                <th class="sort text-center align-middle pe-0 border-top ps-1" scope="col">ACTION</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @can('Payroll access')
                            @forelse($payroll as $data)
                            <tr>
                                <td class="align-middle ps-3 id">{{$loop->iteration}}</td>
                                <td class="align-middle name">{{date('F Y',strtotime($data->pay_period))}}</td>
                                <td class="align-middle name">{{date('d-m-Y',strtotime($data->generate_date))}}</td>
                                <td class="align-middle name">
                                    @if($data->flag=='N')
                                    <span class="text-info">Generated</span>
                                    @elseif($data->flag=='A')
                                    <span class="text-primary">Confirmed</span>
                                    @elseif($data->flag=='C')
                                    <span class="text-success">Completed</span>
                                    @else
                                    <span class="text-danger">Error</span>
                                    @endif
                                </td>
                                <td class="align-middle white-space-nowrap text-center pe-0">

                                    &nbsp;
                                    @if($data->flag=='N')
                                    @can('Payroll delete')
                                    <button type="button" class="btn btn-sm btn-phoenix-danger fs--2 deleteBtn" data-toggle="modal" data-target="#confirm{{$data->id}}"><i class="fa fa-check text-primary" aria-hidden="true"></i>Confirm</button>
                                    <!-- Confirm Role -->
                                    <div class="modal fade" id="confirm{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="removeTitle" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title text-center" id="removeTitle">Confirmation</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to confirm the Payroll?
                                                </div>
                                                <div class="modal-footer">
                                                    <a class="btn btn-sm btn-danger text-white" href="{{url('/payroll/confirm',$data->id)}}"> Confirm </a>
                                                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" aria-label="Close">No</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    &nbsp;
                                    <button type="button" class="btn btn-sm btn-phoenix-danger fs--2 deleteBtn" data-toggle="modal" data-target="#remove{{$data->id}}"><i class="fa fa-trash text-danger" aria-hidden="true"></i></button>
                                    <!-- Remove Role -->
                                    <div class="modal fade" id="remove{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="removeTitle" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                    <h5 class="modal-title text-center" id="removeTitle">Confirmation</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete?
                                                </div>
                                                <div class="modal-footer">
                                                    <a class="btn btn-sm btn-danger text-white" href="{{url('/payroll/delete',$data->id)}}"> Yes </a>
                                                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" aria-label="Close">No</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endcan
                                    @else
                                    <a class="btn btn-sm btn-phoenix-info me-1 fs--2 " href="{{route('payroll.view',$data->id)}}"><span class="fas fa-eye text-primary"></span> Payslip</a>
                                    &nbsp;
                                    <a class="btn btn-sm btn-phoenix-info me-1 fs--2 " href="{{route('payroll.print',$data->id)}}" target="_blank"><span class="fas fa-print text-info"></span></a>
                                    @endif
                                </td>

                            </tr>
                            @empty
                            @endforelse
                            @endcan
                        </tbody>
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