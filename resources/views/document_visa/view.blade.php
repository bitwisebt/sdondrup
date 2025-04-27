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
                            <li class="breadcrumb-item"><a href="/registration-status/{{$id}}/edit/">Application</a></li>
                            <li class="breadcrumb-item active">VISA Documents</li>
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
                    
                        <button type="button" class="btn btn-sm btn-phoenix-danger" data-toggle="modal" data-target="#add{{$id}}"><i class="fa fa-plus" aria-hidden="true"></i> Add</button>
                        <div class="modal fade" id="add{{$id}}" tabindex="-1" role="dialog" aria-labelledby="addTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addTitle">New Document</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <form method="POST" action="{{route('visa-document.store')}}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" id="id" value="{{$id}}">
                                            <div class="form-group row">
                                                <label for="leave" class="col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>
                                                <div class="col-md-8">
                                                    <select name="category" id="category" class="form-control" required>
                                                        <option value="">Select</option>
                                                        @foreach($category as $cat)
                                                        <option value="{{$cat->id}}">{{$cat->category}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="leave" class="col-md-4 col-form-label text-md-right">{{ __('Sub Category') }}</label>
                                                <div class="col-md-8">
                                                    <select name="sub_category" id="sub_category" class="form-control" required>
                                                        <option value="">Select</option>
                                                        @foreach($subcategory as $sub)
                                                        <option value="{{$sub->id}}">{{$sub->sub_category}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
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
                        <a class="btn btn-sm btn-phoenix-danger " href="{{route('visa-document.complete',$id)}}"><i class="fa fa-save text-primary" aria-hidden="true"></i> Complete</a>
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
                                    Category
                                </th>
                                <th>
                                    Sub Category
                                </th>
                                <th>
                                    Document Name
                                </th>
                                <th>
                                    Uploaded by
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($document as $std)
                            <tr>
                                <td>
                                    {{$loop->iteration}}
                                </td>
                                <td>
                                    {{$std->Category->category}}
                                </td>
                                <td>
                                    {{$std->SubCategory->sub_category}}
                                </td>
                                <td>
                                    {{$std->name}}
                                </td>
                                <td>
                                    {{$std->uploaded_by}}
                                </td>
                                <td class="project-actions">
                                    <a href="{{ URL::to('/') }}/{{ $std->path }}" target="_blank">
                                        <i class="fas fa-download"></i>Download</a>
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
                                                    <a class="btn btn-sm btn-danger text-white" href="{{url('/visa-document/delete/'.$std->id.'/'.$std->student_id)}}"> Yes </a>
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