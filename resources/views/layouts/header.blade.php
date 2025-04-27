<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fa fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <img src="{{asset('assets/dist/img/main_logo.png')}}" alt="Company Logo" class="brand-image" style="opacity: .8" width="300px">
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <h5 class="text-white" style="padding-left: 20px; padding-top:20px;">{{session('CompanyName')??'No Company Selected'}}</h5>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <!--<a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>-->
        </li>

        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fa fa-gears"></i>
                <span class="badge badge-warning">Settings</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="/profile" class="dropdown-item">

                    <div class="media">
                        <img src="{{asset('assets/dist/img/profile.png')}}" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Update Profile
                                <span class="float-right text-sm text-success"><i class="fas fa-check"></i></span>
                            </h3>
                        </div>
                    </div>

                </a>
                <div class="dropdown-divider"></div>
                <a href="/change-password" class="dropdown-item">

                    <div class="media">
                    <img src="{{asset('assets/dist/img/password.jpeg')}}" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Change Password
                                <span class="float-right text-sm text-primary"><i class="fas fa-key"></i></span>
                            </h3>
                        </div>
                    </div>

                </a>
                <div class="dropdown-divider"></div>
                <a href="/logout" class="dropdown-item">

                    <div class="media">
                    <img src="{{asset('assets/dist/img/logout.jpg')}}" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Logout
                                <span class="float-right text-sm text-danger"><i class="fas fa-lock"></i></span>
                            </h3>
                        </div>
                    </div>

                </a>
            </div>
        </li>

        <!--<li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>-->
    </ul>
</nav>
<!-- /.navbar -->