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
                            <li class="breadcrumb-item active">New Role</li>
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
                    <h3 class="card-title">Create Role</h3>
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

                    <form action="{{ route('role.store') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="category_id" class="col-md-2 col-form-label text-md-right">User Role</label>

                            <div class="col-md-6">
                                <select name="name" id="name" class="form-control" required>
                                    <option value="">Select</option>
                                    @foreach($user as $data)
                                    <option value="{{$data->type}}">{{$data->type}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="button" onclick='selects();' value="Select All" class="form-control btn btn-primary" />
                                <input type="button" onclick='deSelect();' value="Deselect All" class="form-control btn btn-warning"  />
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            @foreach ($permission as $value)
                            <div class="col-3">
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="permission[]" id="permission" value="{{ $value->name }}" class="name">
                                        {{ $value->name }}</label>
                                    <br />
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <hr>
                        <div class="col-12 offset-md-5">
                            <button type="submit" class="btn btn-success text-white">
                                {{ __('Save') }}
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
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript">
    function selects() {
        var ele = document.getElementsByName('permission[]');
        for (var i = 0; i < ele.length; i++) {
            if (ele[i].type == 'checkbox')
                ele[i].checked = true;
        }
    }

    function deSelect() {
        var ele = document.getElementsByName('permission[]');
        for (var i = 0; i < ele.length; i++) {
            if (ele[i].type == 'checkbox')
                ele[i].checked = false;

        }
    }
</script>