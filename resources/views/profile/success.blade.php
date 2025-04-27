@extends('layouts.app')

@section('content')
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-success-lite">
            Success
        </div>
        <div class="modal-body">
                <center>
                    <h1><i class="fa fa-check text-success" aria-hidden="true"></i> Password Changed!</h1>
                    <p class="text-center">You must logoff and then logon again for the change to take effect. <br>
                    <small class="text-danger">Sharing your account email and password with unauthorized websites or to anyone can compromise the security of the system.</small></p>
                    <br>
                    <a href="/logout" class="btn btn-sm btn-primary">Logout</a>
                </center>

        </div>

    </div>
</div>
@endsection