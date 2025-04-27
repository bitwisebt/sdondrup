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
                        <h1>User Role</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">Update Role</li>
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
                    <h3 class="card-title">Update Role</h3>
                </div>
                <div class="card-body">
                    <br>
                    @if ($errors->any())
                    @foreach ($errors->all() as $error)
                    <div class="text-danger">{{$error}}</div>
                    @endforeach
                    @endif
                    @if (session('error'))
                    <div class="col-sm-12">
                        <div class="alert  alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    @endif
                    <form action="{{ route('role.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <strong>Permission for: </strong>{{ $role->name }}
                                    <input type="hidden" value="{{ $role->name }}" name="name" class="form-control" placeholder="Name" readonly>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            @foreach ($permission as $value)
                            <div class="col-3">
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" @if (in_array($value->id, $rolePermissions)) checked @endif name="permission[]"
                                        value="{{ $value->name }}" class="name">
                                        {{ $value->name }}</label>
                                    <br />
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <hr>
                        <div class="col-12 offset-md-5">
                            <button type="submit" class="btn btn-success text-white">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </form>
                    <br>
                    <!-- /.card-body -->
                </div>

                <br>
                <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    @include('layouts.footer')
</div>
@endsection