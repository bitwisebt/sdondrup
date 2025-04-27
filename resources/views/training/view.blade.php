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
                        <h1>Training History</h1>
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
                    <h3 class="card-title">Training History</h3>
                </div>
                <div class="card-body">

                    <div id="tableExample"> 
                        <div class="table-responsive">
                            <table class="table table-sm fs--1 mb-0" id="myTable" width="100%">
                                <thead>
                                    <tr>
                                        <th class="sort border-top ps-3" data-sort="id">Sl#</th>
                                        <th class="sort border-top" data-sort="name">Title</th>
                                        <th class="sort border-top" data-sort="name">Level</th>
                                        <th class="sort border-top" data-sort="name">Institute</th>
                                        <th class="sort border-top" data-sort="name">Date</th>
                                        <th class="sort border-top" data-sort="name">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @can('Training access')
                                    @forelse($training as $data)
                                    <tr>
                                        <td class="align-middle ps-3 id">{{$loop->iteration}}</td>
                                        <td class="align-middle name">{{$data->title}}</td>
                                        <td class="align-middle name">{{$data->level}}</td>
                                        <td class="align-middle name">{{$data->institute}}</td>
                                        <td class="align-middle name">{{date('d-m-Y',strtotime($data->start)).'-'.date('d-m-Y',strtotime($data->end))}}</td>
                                        <td>
                                        @can('Training delete')
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
                                                            <a class="btn btn-sm btn-danger text-white" href="{{route('training.destroy',$data->id)}}"> Yes </a>
                                                            <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" aria-label="Close">No</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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