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
                        <h1>Application Processing</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">Application Processing</li>
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
                    <h3 class="card-title">Student List</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <a class="btn btn-success btn-sm" href="{{route('registration.create')}}"><i class="fa fa-plus"></i> Add</a>
                    </div>

                </div>
                <div class="card-body p-0">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif
                    <table class="table table-striped projects small" id="myTable">
                        <thead>
                            <tr>
                                <th style="width: 1%">
                                    #
                                </th>
                                <th>Type</th>
                                <th>Ref.No.</th>
                                <th>
                                    Name
                                </th>
                                <th class="text-center">
                                    Contact No.
                                </th>
                                <th class="text-center">
                                    University
                                </th>
                                <th class="text-center">
                                    Course
                                </th>
                                <th>Assign To</th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($student as $std)
                            <tr>
                                <td>
                                    {{$loop->iteration}}
                                </td>
                                <td>
                                    {{$std->type}}
                                </td>
                                <td>
                                    {{$std->registration_number}}
                                </td>
                                <td>
                                    {{$std->name}}
                                </td>
                                <td class="project-state">
                                    {{$std->contact_number}}
                                </td>
                                <td class="project-state">
                                    {{$std->StudyPreferance->University->university??null}}
                                </td>
                                <td class="project-state">
                                    {{$std->StudyPreferance->course_name??null}}
                                </td>
                                <td class="project-state">
                                    {{$std->AssignTo->name}}
                                </td>
                                <td class="project-actions">
                                    <a class="btn btn-sm btn-phoenix-danger" href="#">
                                        <i class="fas fa-print">
                                        </i>
                                    </a>
                                    <a class="btn btn-sm btn-phoenix-danger" href="{{url('/registration/'.$std->id.'/edit')}}">
                                        <i class="fas fa-edit">
                                        </i>
                                    </a>
                                    &nbsp;
                                    <button type="button" class="btn btn-sm btn-phoenix-danger" data-toggle="modal" data-target="#remove{{$std->id}}"><i class="fa fa-trash text-danger" aria-hidden="true"></i></button>
                                    <!-- Remove Role -->
                                    <div class="modal fade" id="remove{{$std->id}}" tabindex="-1" role="dialog" aria-labelledby="removeTitle" aria-hidden="true">
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
                                                    <a class="btn btn-sm btn-danger text-white" href="{{url('/registration/delete/'.$std->id)}}"> Yes </a>
                                                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" aria-label="Close">No</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
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