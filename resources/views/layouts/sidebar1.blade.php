<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/home" class="brand-link">
        <center>
            <h1 class="brand-text font-weight-light">C<span class="text-warning">RM</span>S</h1>
        </center>

    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if(Auth::user()->image_path==null)
                <img src="{{asset('assets/dist/img/person.png')}}" class="img-circle elevation-2" alt="User Image">
                @else
                <img src="{{ URL::to('/') }}/{{ Auth::user()->image_path }}" class="img-circle" alt="User Image">
                @endif
            </div>
            <div class="info">
                <span class="text-warning">{{Auth::user()->name}}</span>
            </div>
        </div>

        <!-- Sidebar Menu -->
         <hr style="border-top: 1px solid #FF0000;">
        <h3 class="text-white"> ATTENTION!!!</h3>
        <p class="text-warning">To access this system it requires company selection, you need to identify and select your organization from a list.</p>

        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>