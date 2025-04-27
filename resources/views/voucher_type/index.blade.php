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
                        <h1>Account Types</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">Account</li>
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
                        Year:
                        <select id="year" class="form-control-sm" name="year">
                            {{ $year = date('Y') }}
                            <option value="{{ $year }}" selected>{{ $year }}</option>
                            <option value="{{ $year-1 }}">{{ $year-1 }}</option>
                        </select>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <a class="btn btn-success btn-sm" href="{{route('account-type.create')}}"><i class="fa fa-plus"></i> Add</a>
                    </div>
                </div>
                <div class="card-body">

                    <div id="tableExample"> 
                        <div class="table-responsive">
                            <table class="table table-sm fs--1 mb-0" id="myTable" width="95%">
                                <thead>
                                    <tr>
                                        <th class="sort border-top ps-3" data-sort="id">Sl#</th>
                                        <th class="sort border-top ps-3" data-sort="id">Year</th>
                                        <th class="sort border-top" data-sort="name">Group</th>
                                        <th class="sort border-top" data-sort="name">Acount Name</th>
                                        <th class="sort border-top" data-sort="name">Balance</th>
                                        <th class="sort border-top" data-sort="name">Created By</th>
                                        <th class="sort text-center align-middle pe-0 border-top ps-1" scope="col">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @forelse($data as $data1)
                                    <tr>
                                        <td class="align-middle ps-3 id">{{$loop->iteration}}</td>
                                        <td class="align-middle name">{{$data1->year}}</td>
                                        <td class="align-middle name">{{$data1->group}}</td>
                                        <td class="align-middle name">{{$data1->account_name}}</td>
                                        <td class="align-middle name">{{$data1->balance}}</td>
                                        <td class="align-middle name">{{$data1->created_by}}</td>
                                        <td class="align-middle white-space-nowrap text-center pe-0">

                                            <a class="btn btn-sm btn-phoenix-info me-1 fs--2 " href="{{route('account-type.edit',$data)}}"><span class="fas fa-edit"></span></a>
                                            <button type="button" class="btn btn-sm btn-phoenix-danger fs--2 deleteBtn" data-toggle="modal" data-target="#remove{{$data1->id}}"><i class="fa fa-trash text-danger" aria-hidden="true"></i></button>
                                            <!-- Remove Role -->
                                            <div class="modal fade" id="remove{{$data1->id}}" tabindex="-1" role="dialog" aria-labelledby="removeTitle" aria-hidden="true">
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
                                                            <a class="btn btn-sm btn-danger text-white" href="{{route('account-type.destroy',$data1->id)}}"> Yes </a>
                                                            <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" aria-label="Close">No</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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