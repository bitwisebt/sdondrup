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
                        <h1>Employee Entitlement</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">Entitlement</li>
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
                    <h3 class="card-title">Employee Entitlement</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <a class="btn btn-sm btn-phoenix-info me-1 fs--2 " href="{{url('report/entitlement')}}" target="_blank"><span class="fas fa-print text-primary"></span>Print</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm fs--1 mb-0" id="myTable" width="60%">
                        <thead>
                            <tr>
                                <th class="sort border-top ps-3" data-sort="id">Sl#</th>
                                <th class="sort border-top">ID</th>
                                <th class="sort border-top">Name</th>
                                <th class="sort border-top">Designation</th>
                                <th class="sort border-top">Department</th>
                                <th class="sort border-top">BPay</th>
                                <th class="sort border-top">Allw</th>
                                <th class="sort border-top">HC</th>
                                <th class="sort border-top">PF</th>
                                <th class="sort border-top">Tax</th>
                                <th class="sort text-center align-middle pe-0 border-top ps-1" scope="col">ACTION</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @can('Entitlement access')
                            @forelse($entitlement as $data)
                            <tr>
                                <td class="align-middle ps-3 id">{{$loop->iteration}}</td>
                                <td class="align-middle name">{{$data->employee_id}}</td>
                                <td class="align-middle name">{{$data->name}}</td>
                                <td class="align-middle name">{{$data->designation}}</td>
                                <td class="align-middle name">{{$data->department}}</td>
                                <td class="align-middle name">{{$data->basic_pay}}</td>
                                <td class="align-middle name">{{$data->allowance}}</td>
                                <td class="align-middle name">{{$data->health_contribution}}</td>
                                <td class="align-middle name">{{$data->provident_fund}}</td>
                                <td class="align-middle name">{{$data->tds}}</td>
                                <td class="align-middle white-space-nowrap text-center pe-0">
                                    @can('Entitlement edit')
                                    <button type="button" class="btn btn-sm btn-phoenix-info me-1 fs--2" data-toggle="modal" data-target="#remove{{$data->id}}"><i class="fa fa-plus" aria-hidden="true"></i> Add</button>
                                    <div class="modal fade" id="remove{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="removeTitle" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="removeTitle">New Entitlement</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <form method="POST" action="{{route('entitlement.update',$data->eid)}}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group row">
                                                            <label for="station" class="col-md-4 col-form-label text-md-right">Basic Pay</label>
                                                            <div class="col-md-8">
                                                                <input id="basic_pay" type="text" class="form-control" name="basic_pay" value="{{ $data->basic_pay }}" required autofocus />
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="station" class="col-md-4 col-form-label text-md-right">Allowance</label>
                                                            <div class="col-md-8">
                                                                <input id="allowance" type="text" class="form-control" name="allowance" value="{{ $data->allowance }}" required />
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="station" class="col-md-4 col-form-label text-md-right">Health Contribution</label>
                                                            <div class="col-md-8">
                                                                <input id="health_contribution" type="text" class="form-control" name="health_contribution" value="{{ $data->health_contribution }}" required />
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="station" class="col-md-4 col-form-label text-md-right">Provident Fund</label>
                                                            <div class="col-md-8">
                                                                <input id="provident_fund" type="text" class="form-control" name="provident_fund" value="{{ $data->provident_fund }}" required />
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="station" class="col-md-4 col-form-label text-md-right">Tax</label>
                                                            <div class="col-md-8">
                                                                <input id="tds" type="text" class="form-control" name="tds" value="{{ $data->tds }}" required />
                                                            </div>
                                                        </div>

                                                        <div class="form-group row mb-0">
                                                            <div class="col-md-8 offset-md-3">
                                                                <button type="submit" class="btn btn-info text-white">
                                                                    {{ __('Save') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endcan
                                    <a class="btn btn-sm btn-phoenix-info me-1 fs--2 " href="{{route('entitlement.show',$data->id)}}"><span class="fas fa-eye text-primary"></span>History</a>
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