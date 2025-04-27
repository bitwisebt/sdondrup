@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{asset('assets/dist/css/timeline_app.css')}}">
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
        <!-- Main content -->
        <section class="content">
            <br>
            <div class="row">

                <div class="col-md-12 col-lg-12">
                    <div id="tracking-pre"></div>
                    <div id="tracking">
                        <div class="text-center tracking-status-inforeceived">
                            <h3 class="text-white">Application Tracking/Processing</h3>
                        </div>
                        @foreach($student as $data)

                        <div class="tracking-list">
                            @if($data->status_id==1)
                            <div class="tracking-item">
                                <div class="tracking-icon status-inforeceived">
                                    <i class="fa fa-play text-success"></i>
                                    <!-- <i class="fas fa-circle"></i> -->
                                </div>
                                <div class="tracking-date"></span></div>
                                <div class="tracking-content">
                                    <h5>Start</h5>
                                </div>
                            </div>
                            @endif
                            <div class="tracking-item">
                                @if(is_null($data->status))
                                <div class="tracking-icon status-expired">
                                    <i class="fa fa-hourglass-start text-dark"></i>
                                </div>
                                @elseif($data->status=='Completed'||$data->status=='Granted'||$data->status=='Lodged'|| $data->status=='Offered' || $data->status=='Accepted' || $data->status=='Processed' || $data->status=='Submitted')
                                <div class="tracking-icon status-delivered">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                @elseif($data->status=='Refused'||$data->status=='Rejected'||$data->status=='Canceled')
                                <div class="tracking-icon status-exception">
                                    <i class="fa fa-times text-dark"></i>
                                </div>
                                @elseif($data->status=='Conditional Offered')
                                <div class="tracking-icon status-outfordelivery">
                                    <i class="fa fa-exclamation text-dark"></i>
                                </div>
                                @else
                                <div class="tracking-icon status-delivered">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                @endif
                                <div class="tracking-date">{{$data->date!=null?date('M d, Y',strtotime($data->date)):'No Action'}}</span></div>
                                <div class="tracking-content">
                                    <h5>{{$data->Status->status}}</h5><span>{{$data->status}}</span>
                                    @if($data->status_id==2)
                                    <a href="/admission-document/{{$data->student_id}}/edit/"><i class="fa fa-file text-info" aria-hidden="true"></i> Update</a>
                                    @elseif($data->status_id==6)
                                    <a href="/visa-document/{{$data->student_id}}/edit/"><i class="fa fa-file text-info" aria-hidden="true"></i> Update</a>
                                    @else
                                    @if($data->status_id>1) 
                                    <button type="button" class="btn btn-sm btn-phoenix-danger" data-toggle="modal" data-target="#remove{{$data->id}}"><i class="fa fa-edit text-primary" aria-hidden="true"></i> Update</button>
                                        <div class="modal fade" id="remove{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="removeTitle" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="removeTitle">Update Application</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <form method="POST" action="{{route('application.update',$data->id)}}" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group row">
                                                                <label for="station" class="col-md-4 col-form-label text-md-right">Status</label>
                                                                <div class="col-md-8">
                                                                    <select name="status" id="status" class="form-control" required>
                                                                        <option value="">Select</option>
                                                                        @if($data->status_id==3)
                                                                        <option value="Submitted">Submitted</option>
                                                                        @elseif($data->status_id==4)
                                                                        <option value="Offered">Offered</option>
                                                                        <option value="Conditional Offered">Conditional Offered</option>
                                                                        <option value="Refused">Refused</option>
                                                                        @elseif($data->status_id==5)
                                                                        <option value="Received">Received</option>
                                                                        <option value="Rejected">Rejected</option>
                                                                        @elseif($data->status_id==7)
                                                                        <option value="Lodged">Lodged</option>
                                                                        <option value="Granted">Granted</option>
                                                                        <option value="Refused">Refused</option>
                                                                        @elseif($data->status_id==8)
                                                                        <option value="Processed">Processed</option>
                                                                        @elseif($data->status_id==9)
                                                                        <option value="Completed">Completed</option>
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            @if($data->status_id==4 || $data->status_id==5 || $data->status_id==7 || $data->status_id==8)

                                                            <div class="form-group row">
                                                                <label for="gewog" class="col-md-4 col-form-label text-md-right">Document</label>
                                                                <div class="col-md-8">
                                                                    <input type="file" name="doc" id="doc" accept="application/pdf,image/*">
                                                                </div>
                                                            </div>
                                                            @endif

                                                            <div class="form-group row mb-0">
                                                                <div class="col-md-8 offset-md-4">
                                                                    <button type="submit" class="btn btn-info text-white">
                                                                        {{ __('Save') }}
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    <br><br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @endif
                                        <br>
                                        @if($data->path!=null)
                                        <a href="{{ URL::to('/public/') }}/{{ $data->path }}" target="_blank">
                                        <i class="fas fa-download"></i>Download</a>
                                    &nbsp;
                                        @endif
                                </div>
                            </div>
                            @if($data->status_id==9)
                            <div class="tracking-item">
                                <div class="tracking-icon status-inforeceived">
                                    <i class="fas fa-stop text-danger"></i>
                                </div>
                                <div class="tracking-date"></div>
                                <div class="tracking-content">
                                    <h5>End</h5>
                                </div>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    @include('layouts.footer')
</div>
@endsection