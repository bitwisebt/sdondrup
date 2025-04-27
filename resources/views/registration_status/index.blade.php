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
                        <h1>Application Status</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">Application Status</li>
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
                                    Gender
                                </th>
                                <th>
                                    CID No.
                                </th>
                                <th class="text-center">
                                    Status
                                </th>
                                <th class="text-center">
                                    Date
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="addMoreTravel" id="TravelTable">
                            @forelse($student as $std)
                            <tr>
                                <td>
                                    {{$loop->iteration}}
                                </td>
                                <td>
                                    {{$std->Registration->name}}
                                </td>
                                <td>
                                    @if($std->Registration->gender=='F')
                                    Female
                                    @else
                                    Male
                                    @endif
                                </td>
                                <td class="project_progress">
                                    {{$std->Registration->cid_number}}
                                </td>
                                <td class="project-state">

                                    @switch($std->Status->color_code)
                                    @case('Blue')
                                    <i class="fa fa-thumbs-up text-blue">&nbsp;{{$std->Status->status}}</i>
                                    @break
                                    @case('Orange')
                                    <i class="fa fa-exclamation text-warning">&nbsp;{{$std->Status->status}}</i>
                                    @break
                                    @case('Green')
                                    <i class="fa fa-check text-success">&nbsp;{{$std->Status->status}}</i>
                                    @break
                                    @case('Red')
                                    <i class="fa fa-skull-crossbones text-danger">&nbsp;{{$std->Status->status}}</i>
                                    @break
                                    @endswitch



                                </td>
                                <td>
                                    {{date('F d,Y',strtotime($std->date))}}
                                </td>
                                <td class="project-actions text-right">
                                    <!-- Add Document -->
                                    <button type="button" class="btn btn-primary btn-sm update" data-toggle="modal" data-target="#remove{{$std->id}}"><i class="fa fa-pen" aria-hidden="true"></i> Update</button>
                                    <div class="modal fade" id="remove{{$std->id}}" tabindex="-1" role="dialog" aria-labelledby="removeTitle" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="removeTitle">Update Status</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <form method="POST" action="{{route('registration-status.store')}}">
                                                        @csrf
                                                        <input class="id" type="hidden" name="id" id="id" value="{{$std->student_id}}">
                                                        <div class="form-group row">
                                                            <label for="station" class="col-md-4 col-form-label text-md-right">Status</label>
                                                            <div class="col-md-8">
                                                                <select name="status" id="status" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-md-8 offset-md-4">
                                                                <button type="submit" class="btn btn-info text-white">
                                                                    {{ __('Update') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    &nbsp;
                                    <a class="btn btn-info btn-sm" href="{{url('/registration-status/'.$std->student_id.'/edit')}}">
                                        <i class="fas fa-eye">
                                        </i>
                                        View
                                    </a>
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
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.addMoreTravel').delegate('.update', 'click', function() {
            var tr = $(this).parent().parent();
            var id = tr.find('.id').val();
            $.get('/json-status?id=' + id, function(data) {
                console.log(data);
                $('#status').empty();
                $('#status').append('<option value="">Select</option>');
                $.each(data, function(index, ageproductObj) {

                    $('#status').append('<option value="' + ageproductObj.id + '">' + ageproductObj.status + '</option>');
                })
            });
        });
    });
</script>