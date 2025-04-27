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
                        <h1>User Management</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">User</li>
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
                    <h3 class="card-title">User List</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <a class="btn btn-success btn-sm" href="{{route('user.create')}}"><i class="fa fa-plus"></i> Add</a>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-links mb-3 mb-lg-2 mx-n3">
                        <li class="nav-item"><a class="nav-link active" href="/user">All Users <span class="text-700 fw-semi-bold">({{$user_all}})</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="/user?archive">View Archived Users <span class="text-700 fw-semi-bold">({{$users_trashed_count}})</span></a></li>
                    </ul>

                    <div id="tableExample">
                        <div class="table-responsive">
                            <table class="table table-sm fs--1 mb-0" id="myTable">
                                <thead>
                                    <tr>
                                        <th class="sort border-top ps-3" data-sort="id">ID</th>
                                        <th class="sort border-top" data-sort="name">Name</th>
                                        <th class="sort border-top" data-sort="email">Email</th>
                                        <th class="sort border-top" data-sort="datecreated">Date Created</th>
                                        <th class="sort border-top" data-sort="roles">Roles</th>
                                        <th class="sort text-center align-middle pe-0 border-top ps-1" scope="col">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @can('User access')
                                    @forelse($users as $user)
                                    <tr>
                                        <td class="align-middle ps-3 id">{{$loop->iteration}}</td>
                                        <td class="align-middle name">{{$user->name}}</td>
                                        <td class="align-middle email">{{$user->email }} </td>
                                        <td class="align-middle datecreated">{{$user->created_at}}</td>
                                        <td class="align-middle roles">
                                            @foreach($user->roles as $role)
                                            <span class="badge badge-phoenix badge-phoenix-primary">{{ $role->name }}</span></span>
                                            @endforeach
                                        </td>
                                        <td class="align-middle white-space-nowrap text-center pe-0">
                                            @if($user->trashed())
                                            @can('User restore')
                                            <form method="POST" action="{{route('user.restore',$user->id)}}">
                                                @csrf
                                                <button class="btn btn-sm btn-outline-secondary me-1 mb-1 fs--2" type="submit">Restore</button>
                                            </form>
                                            @endcan
                                            @can('User delete forever')
                                            <form action="{{route('user.force_delete',$user->id)}}" method="POST">
                                                @csrf
                                                <button class="btn btn-sm btn-outline-danger me-1 mb-1 fs--2 show_confirm" type="submit">Delete Forever</button>
                                            </form>
                                            @endcan
                                            @else
                                            @can('User edit')
                                            <a class="btn btn-sm btn-phoenix-info me-1 fs--2 " href="{{route('user.edit',$user)}}"><span class="fas fa-edit"></span></a>
                                            @endcan
                                            @if($user->role!=1)
                                            
                                            @can('User delete')
                                            <button type="button" class="btn btn-sm btn-phoenix-danger fs--2 deleteBtn" data-toggle="modal" data-target="#remove{{$user->id}}"><i class="fa fa-trash text-danger" aria-hidden="true"></i></button>
                                            <!-- Remove Role -->
                                            <div class="modal fade" id="remove{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="removeTitle" aria-hidden="true">
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
                                                            <a class="btn btn-sm btn-danger text-white" href="{{url('/user/'.$user->id.'/destroy')}}"> Yes </a>
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