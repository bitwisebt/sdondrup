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
                        <h1>Leave</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">Leave</li>
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
                    <h3 class="card-title">Leave Details</h3>
                    <div class="card-tools">
                        <a class="btn btn-success btn-sm" href="{{route('leave-application.create')}}"><i class="fa fa-plus"></i> Apply Leave</a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="tableExample"> 
                        <div class="table-responsive">
                            <table class="table table-sm fs--1 mb-0" id="myTable" width="100%">
                                <thead>
                                    <tr>
                                        <th class="sort border-top ps-3" data-sort="id">Sl#</th>
                                        <th class="sort border-top" data-sort="name">Date</th>
                                        <th class="sort border-top" data-sort="name">Leave</th>
                                        <th class="sort border-top" data-sort="name">From-To</th>
                                        <th class="sort border-top" data-sort="name">Days</th>
                                        <th class="sort border-top" data-sort="name">Status</th>
                                        <th class="sort text-center align-middle pe-0 border-top ps-1" scope="col">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @forelse($leave as $data)
                                    <tr>
                                        <td class="align-middle ps-3 id">{{$loop->iteration}}</td>
                                        <td class="align-middle name">{{date('d/m/Y',strtotime($data->date))}}</td>
                                        <td class="align-middle name">{{$data->Leave->leave}}</td>
                                        <td class="align-middle name">{{date('d/m',strtotime($data->start)).'-'.date('d/m/Y',strtotime($data->end))}}</td>
                                        <td class="align-middle name">{{$data->days}}</td>
                                        <td class="align-middle name">
                                            @if($data->flag=='N')
                                            <span class="text-info">New Application</span>
                                            @elseif($data->flag=='S')
                                            <span class="text-primary">Submitted for Approval</span>
                                            @elseif($data->flag=='A')
                                            <span class="text-success">Approved <small class="text-danger">{{$data->remarks}}</small></span>
                                            @elseif($data->flag=='R')
                                            <span class="text-danger">Rejected <small class="text-danger">{{$data->remarks}}</small></span>
                                            @endif
                                        </td>
                                        <td class="align-middle white-space-nowrap text-center pe-0">
                                        @if($data->flag=='N')
                                            <button type="button" class="btn btn-sm btn-phoenix-danger fs--2 deleteBtn" data-toggle="modal" data-target="#submit{{$data->id}}"><i class="fa fa-check text-primary" aria-hidden="true"></i> Submit</button>
                                            <!-- Remove Role -->
                                            <div class="modal fade" id="submit{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="removeTitle" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary">
                                                            <h5 class="modal-title text-center" id="removeTitle">Confirmation</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to submit?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a class="btn btn-sm btn-info text-white" href="{{'/leave-submit/'.$data->id}}"> Yes </a>
                                                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">No</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif 
                                            @if($data->flag=='N' || $data->flag=='S')
                                            <!---------submit---------> 
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
                                                            <a class="btn btn-sm btn-info text-white" href="{{route('leave-application.destroy',$data->id)}}"> Yes </a>
                                                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">No</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            @if($data->flag=='R')
                                            <small><span class="text-danger">{{$data->remarks}}</span></small>
                                            @endif
                                        </td>

                                    </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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