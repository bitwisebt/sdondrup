@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{asset('assets/dist/css/timeline.css')}}">
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
                        <h1>Registration Status</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/registration-status">Registration Status</a></li>
                            <li class="breadcrumb-item active">Details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="section-spacing text-center" id="features">
         <div class="container">
            <header class="section-header">
               <h2>Application Timeline</h2>
            </header>
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-12">
                    <br>
                     <ul class="timeline">
                        @foreach($student as $std)
                        @if($loop->iteration % 2>0)
                        <li class="timeline wow bounceInUp">
                           <div class="timeline-badge"><i class="fa fa-bullseye"></i></div>
                           <div class="date-info">
                              <span class="day">{{date('d',strtotime($std->date))}}</span><span class="month"> {{date('M',strtotime($std->date))}}</span><span class="year"> {{date('Y',strtotime($std->date))}}</span>
                           </div>
                           <div class="timeline-panel">
                              <div class="timeline-heading">
                                 <h6 class="timeline-title">{{$std->description}}</h6>
                              </div>
                           </div>
                        </li>
                        @else
                        <li class="timeline-inverted wow bounceInUp">
                           <div class="timeline-badge1 danger"><i class="fa fa-crosshairs"></i></div>
                           <div class="date-info">
                           <span class="day">{{date('d',strtotime($std->date))}}</span><span class="month"> {{date('M',strtotime($std->date))}}</span><span class="year"> {{date('Y',strtotime($std->date))}}</span>
                           </div>
                           <div class="timeline-panel">
                              <div class="timeline-heading">
                                 <h6 class="timeline-title">{{$std->description}}</h6>
                              </div>
                           </div>
                        </li>
                        @endif
                        @endforeach
                     </ul>
                  </div>
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