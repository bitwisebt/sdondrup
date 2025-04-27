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
                        <h1>Entitlement History</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/entitlement">Entitlement</a></li>
                            <li class="breadcrumb-item active">History</li>
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
                    <h3 class="card-title">Employee Entitlement History</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm fs--1 mb-0" id="myTable" width="90%">
                        <thead>
                            <tr>
                                <th class="sort border-top ps-3" data-sort="id">Sl#</th>
                                <th class="sort border-top">Date</th>
                                <th class="sort border-top">Basic Pay</th>
                                <th class="sort border-top">Allowance</th>
                                <th class="sort border-top">Health Contribution</th>
                                <th class="sort border-top">Provident Fund</th>
                                <th class="sort border-top">Tax</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach($entitle as $data)
                            <tr>
                                <td class="align-middle ps-3 id">{{$loop->iteration}}</td>
                                <td class="align-middle name">{{date('d-M-Y',strtotime($data->date))}}</td>
                                <td class="align-middle name">{{$data->basic_pay}}</td>
                                <td class="align-middle name">{{$data->allowance}}</td>
                                <td class="align-middle name">{{$data->health_contribution}}</td>
                                <td class="align-middle name">{{$data->provident_fund}}</td>
                                <td class="align-middle name">{{$data->tds}}</td>
                                
                            </tr>
                            @endforeach
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