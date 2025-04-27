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
                        <h1>Ledger</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">Ledger</li>
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
                    <h3 class="card-title">Ledger List</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <a class="btn btn-success btn-sm" href="{{route('ledger.create')}}"><i class="fa fa-plus"></i> Add</a>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
                        <li class="nav-item"><a class="nav-link active" href="/ledger">All Ledger <span class="text-700 fw-semi-bold">({{$ledger_all}})</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="/ledger?archive">View Archived Ledger <span class="text-700 fw-semi-bold">({{$ledger_count}})</span></a></li>
                    </ul>

                    <div id="tableExample"> 
                        <div class="table-responsive">
                            <table class="table table-sm fs--1 mb-0" id="myTable" width="100%">
                                <thead>
                                    <tr>
                                        <th class="sort border-top ps-3" data-sort="id">Sl#</th>
                                        <th class="sort border-top" data-sort="name">Account Type</th>
                                        <th class="sort border-top" data-sort="name">Ledger</th>
                                        <th class="sort border-top" data-sort="name">Balance</th>
                                        <th class="sort text-center align-middle pe-0 border-top ps-1" scope="col">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @can('Ledger access')
                                    @forelse($ledger as $data)
                                    <tr>
                                        <td class="align-middle ps-3 id">{{$loop->iteration}}</td>
                                        <td class="align-middle name">{{$data->AccountType->account_type}}</td>
                                        <td class="align-middle name">{{$data->account_name}}</td>
                                        <td class="align-middle name">{{number_format($data->balance,2)}}</td>
                                        <td class="align-middle white-space-nowrap text-center pe-0">
                                            @if($data->trashed())
                                            @can('Ledger restore')
                                            <form method="POST" action="{{route('ledger.restore',$data->id)}}">
                                                @csrf
                                                <button class="btn btn-sm btn-outline-secondary me-1 mb-1 fs--2" type="submit">Restore</button>
                                            </form>
                                            @endcan
                                            @can('Ledger delete forever')
                                            <form action="{{route('ledger.force_delete',$data->id)}}" method="POST">
                                                @csrf
                                                <button class="btn btn-sm btn-outline-danger me-1 mb-1 fs--2 show_confirm" type="submit">Delete Forever</button>
                                            </form>
                                            @endcan
                                            @else
                                            @can('Ledger edit')
                                            <a class="btn btn-sm btn-phoenix-info me-1 fs--2 " href="{{route('ledger.edit',$data)}}"><span class="fas fa-edit"></span></a>
                                            @endcan
                                            @can('Ledger delete')
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
                                                            <a class="btn btn-sm btn-danger text-white" href="{{route('ledger.destroy',$data->id)}}"> Yes </a>
                                                            <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" aria-label="Close">No</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endcan
                                            @endif
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