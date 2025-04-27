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
                </div>
                <div class="card-body">

                    <div id="tableExample"> 
                        <div class="table-responsive">
                            <table class="table table-sm fs--1 mb-0" id="myTable" width="100%">
                                <thead>
                                    <tr>
                                        <th class="sort border-top ps-3" data-sort="id">Sl#</th>
                                        <th class="sort border-top" data-sort="name">Leave</th>
                                        <th class="sort border-top" data-sort="name">Start</th>
                                        <th class="sort border-top" data-sort="name">End</th>
                                        <th class="sort border-top" data-sort="name">Days</th>
                                        <th class="sort border-top" data-sort="name">Purpose</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @can('Year Leave access')
                                    @forelse($leave as $data)
                                    <tr>
                                        <td class="align-middle ps-3 id">{{$loop->iteration}}</td>
                                        <td class="align-middle name">{{$data->Leave->leave}}</td>
                                        <td class="align-middle name">{{date('d-m-Y',strtotime($data->start))}}</td>
                                        <td class="align-middle name">{{date('d-m-Y',strtotime($data->end))}}</td>
                                        <td class="align-middle name">{{$data->days}}</td>
                                        <td class="align-middle name">{{$data->purpose}}</td>
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