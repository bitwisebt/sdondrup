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
                        <h1>Commission Statement</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">Commission</li>
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
                    <h3 class="card-title">Commission List</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <a class="btn btn-success btn-sm" href="{{route('commission.create')}}"><i class="fa fa-plus"></i> Add</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if(count($commission)>0)
                        <table id="myTable" class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Sl.</th>
                                    <th>Date</th>
                                    <th>University Name</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($commission as $data)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{date('d M Y', strtotime($data->date))}}</td>
                                    <td>{{$data->University->university}}</td>
                                    <td>{{number_format($data->amount,2)}}</td>
                                    @if($data->flag=='P')
                                    <td><span class="text-danger">Pending</span></td>
                                    @elseif($data->flag=='C')
                                    <td><span class="text-success">Received</span></td>
                                    @else
                                    <td>Error</td>
                                    @endif
                                    <td>
                                        <a class="btn btn-sm btn-phoenix-info" href="{{route('commission.show',$data->id)}}" target="_blank">
                                            <i class="fa fa-print text-info" aria-hidden="true"> </i></a>
                                        <a class="btn btn-sm btn-phoenix-info" href="{{route('commission.edit',$data->id)}}">
                                            <i class="fa fa-edit text-primary" aria-hidden="true"> </i></a>
                                        @if($data->flag=='P')
                                        <button type="button" class="btn btn-sm btn-phoenix-danger" data-toggle="modal" data-target="#remove{{$data->id}}"><i class="fa fa-trash text-danger" aria-hidden="true"></i></button>
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
                                                        <a class="btn btn-sm btn-danger text-white" href="{{url('/commission/delete/'.$data->id)}}"> Yes </a>
                                                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" aria-label="Close">No</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p>No data to display.</p>
                        @endif
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