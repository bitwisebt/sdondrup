@extends('layouts.app')
@section('title', 'User Permission')
@section('page-name')
<h2 class="mb-2 lh-sm">User Permissions</h2>
@endsection
@section('content')
<div id="tableExample2">
    <div class="table-responsive">
      <table class="table table-striped table-sm fs--1 mb-0">
        <thead>
          <tr>
            <th class="sort border-top ps-3" data-sort="name">Permission Name</th>
            <th class="sort border-top" data-sort="email">User Roles Assigned with Permission</th>
            {{-- <th class="sort border-top" data-sort="age">Age</th>
            <th class="sort text-end align-middle pe-0 border-top" scope="col">ACTION</th> --}}
          </tr>
        </thead>
        <tbody class="list">
            @can('Permission access')
                @foreach($permissions as $permission)
                <tr>
                    <td class="align-middle ps-3 name">{{ $permission->name }}</td>
                    <td class="align-middle ps-3 name">
                        @forelse($permission->roles as $role)
                            <span class="badge badge-phoenix badge-phoenix-primary">{{ $role->name }}</span>
                        @empty
                            
                        @endforelse
                    </td>
                </tr>
                @endforeach
            @endcan
        </tbody>
      </table>
    </div>
   
  </div>
  @if($permissions->hasPages())
  <br>
  {{ $permissions->links('pagination::bootstrap-5') }}
  @endif
@endsection