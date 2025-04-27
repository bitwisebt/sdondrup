@extends('layouts.app')

@section('content')
@include('layouts.header')
@include('layouts.sidebar')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <div class="info-box-content">
                            <span class="info-box-text">Registration</span>
                            <span class="info-box-number">
                                Received
                                <small>{{$app}}</small>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                @foreach($adm as $adm1)
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <div class="info-box-content">
                            <span class="info-box-text">{{$adm1->status}}</span>
                            <span class="info-box-number">
                                {{$adm1->ST}}
                                <small>{{$adm1->count}}</small>
                                <button type="button" class="btn btn-sm btn-phoenix-danger fs--2 deleteBtn" data-toggle="modal" data-target="#remove" onclick="showDetails({{$adm1->id}},'{{$adm1->ST}}');"><i class="fa fa-eye text-primary" aria-hidden="true"></i></button>
                                    <!-- Remove Role -->
                                    <div class="modal fade" id="remove" tabindex="-1" role="dialog" aria-labelledby="removeTitle" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-center" id="removeTitle">List</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <table id="table" class="table table-bordered table-sm" style="font-size: 90.5%;">
                                                        <tr>
                                                            <th>Registration No.</th>
                                                            <th>Name</th>
                                                        </tr>
                                                        <tbody class="addMoreDeduct" id="DeductTable">
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                @endforeach
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!--/. container-fluid -->
    </section>
    <div class="content-header">
        <div class="container-fluid">
            @if(count($leave)>0)
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h3>Staff on Leave</h3>
                </div><!-- /.col -->
            </div>
            <div class="row mb-2">
                <table class="table table-striped">
                    <tr>
                        <th>Sl.</th>
                        <th width="20%">Name</th>
                        <th>From-To</th>
                        <th width="50%">Purpose</th>
                     </tr>
                     @foreach($leave as $le)
                     <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$le->name}}</td>
                        <td>{{date('d',strtotime($le->start)) .' to '. date('d-M-Y',strtotime($le->end))}}</td>
                        <td>{{$le->purpose}}</td>
                     </tr>
                     @endforeach
                </table>
            </div><!-- /.row -->
            @endif
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
@include('layouts.footer')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript">
function showDetails(a,b){
    var tableHeaderRowCount = 1;
    var table = document.getElementById('DeductTable');
    var rowCount = table.rows.length;
    for (var i = tableHeaderRowCount; i < rowCount; i++) {
        table.deleteRow(tableHeaderRowCount);
    }
    $.ajax({
                url: '/json-dashboard',
                type: "GET",
                data: {
                    id: a,
                    des:b
                },
                success: function(data) {
                    console.log(data);
                    
                    $.each(data, function(index, ageproductObj) {
                        var tr = '<tr>' +
                            '<td>' +ageproductObj.registration_number+'</td><td>' +
                            ageproductObj.name +
                            '</td></tr>'
                        $('.addMoreDeduct').append(tr);
                    })
                    
                }
            });
}
</script>
@endsection
