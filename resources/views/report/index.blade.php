@extends('layouts.app')
@section('title', 'Generate Reports')
@section('content')
<div class="card">
    <h3 class="mt-3 text-center">Standard Report</h3>
    <form action="{{ route('report.generate') }}" method="GET">
    <div class="card-body">        
        <div class="row">
            <div class="col-md-2">
                <label for="">Technical Committee</label>
                <select name="tc_id" id="" class="form-control-sm form-control" required>
                    <option value=""></option>
                    @foreach($technical_committees as $technical_committee)
                    <option value="{{ $technical_committee->id }}">{{ $technical_committee->technical_committee }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="">Sub Committee</label>
                <select class="form-control" name="sc_id" id="sc_id">
                </select>
                {{-- <select name="sc_id" id="" class="form-control form-control-sm">
                    <option value=""></option>
                    @foreach($sub_committees as $sub_committee)
                        <option value="{{ $sub_committee->id }}">{{ $sub_committee->sub_committee }}</option>
                    @endforeach
                </select> --}}
            </div>
            <div class="col-md-2">
                <label for="">Standards</label>
                <select class="form-control" name="st_id" id="st_id">
                </select>
                {{-- <select name="st_id" id="" class="form-control form-control-sm">
                    <option value=""></option>
                    @foreach($standards as $standard)
                        <option value="{{ $standard->id }}">{{ $standard->standards }}</option>
                    @endforeach
                </select> --}}
            </div>
            <div class="col-md-2">
                <label for="">Report Format</label>
                <select name="format" id="" class="form-control form-control-sm" required>
                    <option value="excel">Microsoft Excel</option>
                    <option value="pdf">Pdf</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="">From Date</label>
                <input type="date" class="form-control form-control-sm datepicker" name="from" required>
            </div>
            <div class="col-md-2">
                <label for="">To Date</label>
                <input type="date" class="form-control form-control-sm datepicker" name="to" required>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Generate/Download</button>
    </div>
</form>
</div>

<br>
<br>
<div class="card">
    <h3 class="mt-3 text-center">Working Group Report</h3>
    <form action="{{ route('report.workinggroup.generate') }}" method="GET">
    <div class="card-body">        
        <div class="row">
            <div class="col-md-2">
                <label for="">Wroking Group</label>
                <select name="wg_id" id="wg_id" class="form-control-sm form-control" required>
                    <option value=""></option>
                    @foreach($workingGroups as $workingGroup)
                    <option value="{{ $workingGroup->id }}">{{ $workingGroup->working_group }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="">Report Format</label>
                <select name="format" id="" class="form-control form-control-sm" required>
                    <option value="excel">Microsoft Excel</option>
                    <option value="pdf">Pdf</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="">From Date</label>
                <input type="text" class="form-control form-control-sm date" name="from" required>
            </div>
            <div class="col-md-2">
                <label for="">To Date</label>
                <input type="date" class="form-control form-control-sm datepicker" name="to" required>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Generate/Download</button>
    </div>
</form>
</div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script>
<script>
    $('.date').datepicker({
        autoclose: true,
        dateFormat: "{{ config('panel.date_format_js') }}"
      })
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
  var technicalcommittee = @json($technical_committees);
  var subcommitteee = @json($sub_committees);
  $(document).ready(function () {
      $('select[name=tc_id]').change(function () {
                  
          let selectedServiceId = $(this).val();
              let selectedService = technicalcommittee.filter(function (item) {
                  return item.id == selectedServiceId;
              });
              selectedService = selectedService[0];
              if (!!selectedService && selectedService.subcommittee.length > 0) {
          
                  options = '<option></option>';
                  let subcommittees = selectedService.subcommittee;

                  $.each(subcommittees, function(index, subcommittee) {
                      options+= '<option value="' + subcommittee.id + '">' + subcommittee.sub_committee + ' : ' + subcommittee.code + '</option>';
                  });
              } else {
                  options = '<option></option>';
              }
              $('select[name=sc_id]').html(options);
              $('#sc_id').trigger('change');
      });


      $('#sc_id').change(function () {
       
            let options = '<option></option>';
            let scId = $(this).val();
           
            if (scId != '') {
                let sc = subcommitteee.filter(function (item) {
                    return item.id == scId;
                });
                sc = sc[0];
                $.each(sc.standard, function (i, standards) {
                    options += '<option value="' + standards.id + '">' + standards.standards + '</option>';
                })
            }
            $('#st_id').html(options);
        });
});
</script>
@endpush