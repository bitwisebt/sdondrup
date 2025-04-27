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
                    <h3 class="card-title">Employee List</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <a class="btn btn-success btn-sm" href="{{route('employee.create')}}"><i class="fa fa-plus"></i> Add</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm fs--1 mb-0" id="myTable" width="100%">
                        <thead>
                            <tr>
                                <th class="sort border-top ps-3" data-sort="id">Sl#</th>
                                <th class="sort border-top">Employee ID</th>
                                <th class="sort border-top">Employee Name</th>
                                <th class="sort border-top">Designation</th>
                                <th class="sort border-top">Department</th>
                                <th class="sort border-top">Status</th>
                                <th class="sort text-center align-middle pe-0 border-top ps-1" scope="col">ACTION</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @can('Employee access')
                            @forelse($employee as $data)
                            <tr>
                                <td class="align-middle ps-3 id">{{$loop->iteration}}</td>
                                <td class="align-middle name">{{$data->employee_id}}</td>
                                <td class="align-middle name">{{$data->name}}</td>
                                <td class="align-middle name">{{$data->Designation->designation}}</td>
                                <td class="align-middle name">{{$data->Department->department}}</td>
                                <td class="align-middle name">{{$data->flag=='A'?'Active':'Deactivated'}}</td>
                                <td class="align-middle white-space-nowrap text-center pe-0">
                                @if($data->flag!='N')
                                <a class="btn btn-sm btn-phoenix-info me-1 fs--2 " href="{{route('employee.show',$data)}}"><span class="fas fa-eye"></span></a>
                                    @if($data->trashed())
                                    @can('Employee restore')
                                    <form method="POST" action="{{route('employee.restore',$data->id)}}">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-secondary me-1 mb-1 fs--2" type="submit">Restore</button>
                                    </form>
                                    @endcan
                                    @can('Employee delete forever')
                                    <form action="{{route('employee.force_delete',$data->id)}}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-danger me-1 mb-1 fs--2 show_confirm" type="submit">Delete Forever</button>
                                    </form>
                                    @endcan
                                    @else
                                    @can('Employee edit')
                                    <a class="btn btn-sm btn-phoenix-info me-1 fs--2 " href="{{route('employee.edit',$data)}}"><span class="fas fa-edit"></span></a>
                                    @endcan
                                    @can('Employee delete')
                                    <button type="button" class="btn btn-sm btn-phoenix-danger fs--2 deleteBtn" data-toggle="modal" data-target="#remove{{$data->id}}"><i class="fa fa-trash text-danger" aria-hidden="true"></i></button>
                                    <!-- Remove Role -->
                                    <div class="modal fade" id="remove{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="removeTitle" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-center" id="removeTitle">Confirmation</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete?
                                                </div>
                                                <div class="modal-footer">
                                                    <a class="btn btn-sm btn-danger text-white" href="{{route('employee.destroy',$data->id)}}"> Yes </a>
                                                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" aria-label="Close">No</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!---Deactivate--->
                                    <button type="button" class="btn btn-sm btn-phoenix-danger fs--2 deleteBtn" data-toggle="modal" data-target="#deactive{{$data->id}}"><i class="fa fa-times text-muted" aria-hidden="true"></i></button>
                                    <!-- Remove Role -->
                                    <div class="modal fade" id="deactive{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="removeTitle" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-center" id="removeTitle">Confirmation</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to deactivate?
                                                </div>
                                                <div class="modal-footer">
                                                    <a class="btn btn-sm btn-danger text-white" href="{{route('employee.deactivate',$data->id)}}"> Yes </a>
                                                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" aria-label="Close">No</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endcan
                                    @endif
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