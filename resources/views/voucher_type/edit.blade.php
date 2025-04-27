@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card border border-success">
                <div class="card-header bg-success-lite">
                    <h5>{{ __('Update Ledger Group') }}</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('group.update',$group->id)}}">
                        @csrf
                        <div class="form-group row">
                            <label for="category" class="col-md-2 col-form-label text-md-right">{{ __('Group') }}</label>
                            <div class="col-md-10">
                                <input id="group" type="text" class="form-control @error('group') is-invalid @enderror" name="group" value="{{ $group->group}}" required placeholder="Ledger Group">
                                @error('group')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="category" class="col-md-2 col-form-label text-md-right">{{ __('Category') }}</label>
                            <div class="col-md-10">
                                <select name="category" id="category" class="form-control" required>
                                    <option value="">Select</option>
                                    @foreach($category as $data)
                                    <option value="{{$data->id}}" {{$group->category_id==$data->id?'selected':''}}>{{$data->category}}</option>
                                    @endforeach
                                </select>
                                @error('group')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <br>

                        {{Form::hidden('_method','PUT')}}
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-5">
                                <button type="submit" class="btn btn-success text-white">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


