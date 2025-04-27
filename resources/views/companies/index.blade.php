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
                        <h1>Company</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">Company</li>
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
                    <h3 class="card-title">Company List</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <a class="btn btn-success btn-sm" href="{{route('companies.create')}}"><i class="fa fa-plus"></i> Add</a>
                    </div>
                </div>
                <div class="card-body">

                    <div id="tableExample">
                        <div class="table-responsive">
                            <table class="table table-sm fs--1 mb-0" id="myTable">
                                <thead>
                                    <tr>
                                        <th class="sort border-top ps-3" data-sort="id">Sl#</th>
                                        <th class="sort border-top" data-sort="name">Name</th>
                                        <th class="sort border-top" data-sort="name">Phone</th>
                                        <th class="sort border-top" data-sort="name">Address</th>
                                        <th class="sort text-center align-middle pe-0 border-top ps-1" scope="col">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @forelse($companies as $data)
                                    <tr>
                                        <td class="align-middle ps-3 id">{{$loop->iteration}}</td>
                                        <td class="align-middle name">{{$data->name}}</td>   
                                        <td class="align-middle name">{{$data->phone}}</td>
                                        <td class="align-middle name">{{$data->address}}</td>
                                        <td>
                                        <a class="btn btn-sm btn-phoenix-info me-1 fs--2 " href="{{route('companies.edit',$data)}}"><span class="fas fa-edit"></span></a>
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