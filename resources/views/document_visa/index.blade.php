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
                        <h1>Documents</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">VISA Document</li>
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
                    <h3 class="card-title">List</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped projects" id="myTable">
                        <thead>
                            <tr>
                                <th style="width: 1%">
                                    #
                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    CID No.
                                </th>
                                <th class="text-center">
                                    Count
                                </th>
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
                                    {{$std->name}}
                                </td>
                                <td class="project_progress">
                                    {{$std->cid_number}}
                                </td>
                                <td class="project-state">
                                    {{$std->count}}
                                </td>
                                <td class="project-actions">
                                    @if($std->count>0)
                                    <a class="btn btn-primary btn-sm" href="{{url('/admission-document/'.$std->id.'/edit')}}">
                                        <i class="fas fa-eye">
                                        </i>
                                        View
                                    </a>
                                    @endif
                                    <!-- Add Document -->
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#remove{{$std->id}}"><i class="fa fa-plus" aria-hidden="true"></i> Add</button>
                                    <div class="modal fade" id="remove{{$std->id}}" tabindex="-1" role="dialog" aria-labelledby="removeTitle" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="removeTitle">New Document</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <form method="POST" action="{{route('admission-document.store')}}" enctype="multipart/form-data">
                                                        @csrf        
                                                        <input type="hidden" name="id" id="id" value="{{$std->id}}">                     
                                                        <div class="form-group row">
                                                            <label for="station" class="col-md-4 col-form-label text-md-right">Document Name</label>
                                                            <div class="col-md-8">
                                                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required placeholder="Document's Name">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="gewog" class="col-md-4 col-form-label text-md-right">Document</label>
                                                            <div class="col-md-8">
                                                            <input type="file" name="doc" id="doc" accept="application/pdf,image/*" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row mb-0">
                                                            <div class="col-md-8 offset-md-4">
                                                                <button type="submit" class="btn btn-info text-white">
                                                                    {{ __('Save') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>

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