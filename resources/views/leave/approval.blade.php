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
                        <h1>Leave Applications</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">Leave Applications</li>
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
                    <h3 class="card-title">Employee Leave Applications</h3>
                </div>
                <div class="card-body">
                    <div id="tableExample">
                        <div class="table-responsive">
                            <table class="table table-sm fs--1 mb-0" id="myTable" width="100%">
                                <thead>
                                    <tr>
                                        <th class="sort border-top ps-3" data-sort="id">Sl#</th>
                                        <th class="sort border-top" data-sort="name">Employee</th>
                                        <th class="sort border-top" data-sort="name">Leave</th>
                                        <th class="sort border-top" data-sort="name">Date</th>
                                        <th class="sort border-top" data-sort="name">Days</th>
                                        <th class="sort text-center align-middle pe-0 border-top ps-1" scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @can('Year Leave access')
                                    @forelse($leave as $data)
                                    <tr>
                                        <td class="align-middle ps-3 id">{{$loop->iteration}}</td>
                                        <td class="align-middle name">{{$data->Employee->name}}</td>
                                        <td class="align-middle name">{{$data->Leave->leave}}</td>
                                        <td class="align-middle name">{{date('d-m',strtotime($data->start)).' to '.date('d-m-Y',strtotime($data->end))}}</td>
                                        <td class="align-middle name">{{$data->days}}</td>
                                        <td class="align-middle white-space-nowrap text-center pe-0">
                                            <button type="button" class="form-control btn-primary" data-toggle="modal" data-target="#remove"> Action</button>
                                            <div class="modal fade" id="remove" tabindex="-1" role="dialog" aria-labelledby="removeTitle" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary">
                                                            <h5 class="modal-title" id="removeTitle">Leave Action</h5>
                                                        </div>
                                                        <div class="modal-body">

                                                            <form method="POST" action="{{route('leave.action',$data->id)}}">
                                                                @csrf
                                                                <table class="table table-sm fs--1 mb-0" width="80%">
                                                                    <tr>
                                                                        <th>Date:</th>
                                                                        <td align="left">{{date('d-m',strtotime($data->start)).' to '.date('d-m-Y',strtotime($data->end))}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Days:</th>
                                                                        <td align="left">{{$data->days}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Purpose:</th>
                                                                        <td align="left">{{$data->purpose}}</td>
                                                                    </tr>
                                                                </table>
                                                                <div class="form-group row">
                                                                    <label for="station" class="col-md-3 col-form-label text-md-right">Remarks</label>
                                                                    <div class="col-md-9">
                                                                        <input class="form-control" type="text" id="remarks" name="remarks" placeholder="Remarks for action taken.">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row mb-0">
                                                                    <div class="col-md-8 offset-md-5">
                                                                        <button type="submit" id="submit" name="submit" value="submit" class="btn btn-primary text-white">
                                                                            {{ __('Approve') }}
                                                                        </button>
                                                                        &nbsp;
                                                                        <button type="submit" id="reject" name="submit" value="export" class="btn btn-danger">
                                                                            Reject
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                    @empty
                                    @endforelse
                                    @endcan
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