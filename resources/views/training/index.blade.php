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
                        <h1>Training Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">Trainings</li>
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
                    <h3 class="card-title">Employee</h3>
                </div>
                <div class="card-body">
                    <div id="tableExample"> 
                        <div class="table-responsive">
                            <table class="table table-sm fs--1 mb-0" id="myTable" width="100%">
                                <thead>
                                    <tr>
                                        <th class="sort border-top ps-3" data-sort="id">Sl#</th>
                                        <th class="sort border-top" data-sort="name">Employee ID</th>
                                        <th class="sort border-top" data-sort="name">Employee</th>
                                        <th class="sort border-top" data-sort="name">Department</th>
                                        <th class="sort border-top" data-sort="name">Designation</th>
                                        <th class="sort text-center align-middle pe-0 border-top ps-1" scope="col">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @can('Training access')
                                    @forelse($employee as $data)
                                    <tr>
                                        <td class="align-middle ps-3 id">{{$loop->iteration}}</td>
                                        <td class="align-middle name">{{$data->employee_id}}</td>
                                        <td class="align-middle name">{{$data->name}}</td>
                                        <td class="align-middle name">{{$data->Department->department}}</td>
                                        <td class="align-middle name">{{$data->Designation->designation}}</td>
                                        <td class="align-middle white-space-nowrap text-center pe-0">
                                            @can('Training edit')
                                            <a class="btn btn-sm btn-phoenix-primary me-1 fs--2 " href="{{route('training.view',$data)}}">History</a>
                                            @endcan
                                            @can('Training create')
                                            <a class="btn btn-sm btn-phoenix-info me-1 fs--2 " href="{{route('training.edit',$data)}}"><i class="fa fa-plus"></i> Add</a>
                                            @endcan
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