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
                            <li class="breadcrumb-item active">Update User</li>
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
                    <h3 class="card-title">Update User</h3>
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
                    <form class="row" method="POST" action="{{route('user.update',$user)}}">
                        @csrf
                        @method('PUT')
                        <div class="col-6">
                            <label class="form-label" for="role">User Role</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="">Select</option>
                                @foreach($roles as $role)
                                <option value="{{$role->id}}" {{$user->role==$role->id?'selected':''}}>{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="role">Full Name</label>
                            <select name="employee_id" id="employee_id" class="form-control" required onchange="showPrice()" >
                                <option value="">Select</option>
                                @foreach($employee as $data)
                                <option data-price="{{$data->email}}" value="{{$data->id}}" {{$user->employee_id==$data->id?'selected':''}}>{{$data->name}}</option>
                                @endforeach
                            </select>
                            <input id="name" name="name" type="text" value="{{$user->name}}" hidden>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="role">Email</label>
                            <input class="form-control" id="email" name="email" type="email" value="{{ old('email',$user->email) }}" required autocomplete="off">
                        </div>
                    
                        <div class="col-6 offset-md-6">
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
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript">
    function showPrice() {
        var select = document.getElementById('employee_id');
        var selectedOption = select.options[select.selectedIndex];
        var email = selectedOption.getAttribute('data-price');

        if (email) {
            document.getElementById('email').value=email;
            document.getElementById('name').value=selectedOption.text;
        } else {
            document.getElementById('email').value= "";
            document.getElementById('name').value= "";
        }
    }
</script>
