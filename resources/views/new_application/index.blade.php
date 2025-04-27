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
                        <h1>New Registration</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">Registration</li>
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
                        <a class="btn btn-success btn-sm" href="{{route('new-application.create')}}"><i class="fa fa-plus"></i> Add</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table" id="myTable" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>
                                    Name
                                </th>
                                <th class="text-center">
                                    Contact#
                                </th>
                                <th class="text-center">
                                    Email
                                </th>
                                <th>Quli</th>
                                <th>
                                    Year
                                </th>
                                <th>
                                    Eng. Test
                                </th>
                                <th>
                                    Employed?
                                </th>
                                <th>Flag</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($student as $std)
                            <tr>
                                <td>
                                    {{$loop->iteration}}
                                </td>
                                <td>
                                    {{$std->name}}
                                </td>
                                <td class="project-state">
                                    {{$std->contact_number}} 
                                </td>
                                <td class="project-state">
                                    {{$std->email}} 
                                </td>
                                <td class="project-state">
                                    {{$std->Qualification->qualification}}
                                </td>
                                <td class="project-state">
                                    {{$std->education_year}} 
                                </td>
                                <td class="project-state">
                                    {{$std->english_test=='Y'?'Yes':'No'}}
                                </td>
                                <td class="project-state">
                                {{$std->employment_status=='Y'?'Yes':'No'}}
                                </td>
                                <td class="project-state">
                                {{$std->flag=='N'?'New':'Processed'}}
                                </td>
                                <td class="project-actions text-right">
                                    <a class="btn btn-sm btn-phoenix-danger" href="{{url('/new-application/'.$std->id.'/edit')}}">
                                        <i class="fas fa-edit">
                                        </i>
                                    </a>
                                    @if($std->flag=='N')
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
                                                    <a class="btn btn-sm btn-danger text-white" href="{{url('/new-application/delete/'.$std->id)}}"> Yes </a>
                                                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" aria-label="Close">No</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if(Auth::user()->role==1 && $std->flag=='Y')
                                    <a class="btn btn-sm btn-phoenix-danger" href="{{url('/redo-application/'.$std->id)}}">
                                        <i class="fas fa-check text-primary"> Redo
                                        </i>
                                    </a>
                                    @endif
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