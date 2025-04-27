<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div class="h-100 d-flex align-items-center justify-content-center">
    <a href="/company-select" class="btn btn-outline-warning text-center text-white">
    <i class="fa fa-cog fa-spin fa-1x fa-fw text-warning"></i> &nbsp;Change Company
    </a>
    </div>

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
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item menu-open">
                    <a href="/home" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @if(Auth::user()->employee_id)
                <li class="nav-item">
                    <a href="#" class="nav-link bg-white">
                        <i class="nav-icon fa fa-info"></i>
                        <p>
                            Personal
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/leave-application" class="nav-link">
                                <i class="fa fa-walking  text-warning"></i>
                                <p> Leave</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/payslip" class="nav-link" target="_blank">
                                <i class="fa fa-file  text-warning"></i>
                                <p> PaySlip</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                <li class="nav-item">
                    <a href="#" class="nav-link bg-danger">
                        <i class="nav-icon fa fa-desktop"></i>
                        <p>
                            Systems
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/leave-application" class="nav-link">
                                <i class="fa fa-users nav-icon"></i>
                                <p>Apply Leave</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/user" class="nav-link">
                                <i class="fa fa-users nav-icon"></i>
                                <p>User Management</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/role" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        <!--                         <li class="nav-item">
                            <a href="/permission" class="nav-link">
                                <i class="fa fa-check nav-icon"></i>
                                <p>Permission</p>
                            </a>
                        </li> -->
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link bg-info">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Master Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                    <li class="nav-item">
                            <a href="/companies" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Company</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/income" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Income Type</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/expense" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Expense Type</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/department" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Department</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/designation" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Designation</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/employee_type" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Employee Type</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/bank" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Bank</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/qualification" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Qualification</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/university" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>University</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/course" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Course</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/agent" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Agent</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/study" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Study Enrolment</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/test" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Proficiency Test</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/relation" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Relation</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/leave-config" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Leave Configuration</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/visa-type" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>VISA Type</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fa fa-graduation-cap"></i>
                        <p>
                            Client
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/new-application" class="nav-link">
                                <i class="fa fa-database nav-icon"></i>
                                <p>Registration</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/registration" class="nav-link">
                                <i class="fa fa-database nav-icon"></i>
                                <p>Application Processing</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/application" class="nav-link">
                                <i class="fa fa-signal nav-icon"></i>
                                <p>Application Status</p>
                            </a>
                        </li>
                        <!--<li class="nav-item">
                            <a href="/registration-complete" class="nav-link">
                                <i class="fa fa-list nav-icon"></i>
                                <p>Completed Application</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/visa-document" class="nav-link">
                                <i class="fa fa-file nav-icon"></i>
                                <p>VISA Documents</p>
                            </a>
                        </li> -->
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link bg-warning">
                        <i class="nav-icon fa fa-user-tie"></i>
                        <p>
                            HR-Admistration
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/employee" class="nav-link">
                                <i class="fa fa-users nav-icon"></i>
                                <p>Employee</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/entitlement" class="nav-link">
                                <i class="fa fa-money-bill nav-icon"></i>
                                <p>Entitlements</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <div class="bg-info">Leave Management</div>
                        </li>
                        <li class="nav-item">
                            <a href="/leave-generated" class="nav-link">
                                <i class="fa fa-download nav-icon"></i>
                                <p>Generate Yearly Leave
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/leave-approval" class="nav-link">
                                <i class="fa fa-check nav-icon"></i>
                                <p>Approval
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/generate-leave" class="nav-link">
                                <i class="fa fa-calendar nav-icon"></i>
                                <p>Leave Details
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <div class="bg-info"><hr></div>
                        </li>
                        <li class="nav-item">
                            <a href="/training" class="nav-link">
                                <i class="fa fa-list nav-icon"></i>
                                <p>Training
                                    <span class="badge badge-info right">History</span>
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link bg-success">
                        <i class="nav-icon fa fa-coins"></i>
                        <p>
                            Finance
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/payroll" class="nav-link">
                                <i class="fa fa-check nav-icon"></i>
                                <p>Payroll
                                    <span class="badge badge-info right">Generate</span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/finance-payroll" class="nav-link">
                                <i class="fa fa-users nav-icon"></i>
                                <p>Payroll
                                    <span class="badge badge-info right">Processing</span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/invoice" class="nav-link">
                                <i class="fa fa-file-invoice text-info nav-icon"></i>
                                <p>Receipt-General Invoice</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/billing" class="nav-link">
                                <i class="fa fa-money-bill text-warning nav-icon"></i>
                                <p>Payment-Bills</p>
                            </a>
                        </li>
                        <hr style="border: 1px solid #fff;">
                        <li class="nav-item">
                            <a href="/commission" class="nav-link">
                                <i class="fa fa-percentage text-success nav-icon"></i>
                                <p>Commission Receivable
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item bg-secondary">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Reports
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li><b>1. Student</b></li>
                        <li class="nav-item">
                            <a href="/student-registration-select" class="nav-link">
                                Registration Details
                            </a>
                            <a href="/student-registration-summary" class="nav-link">
                                Registration by Stage
                            </a>
                            <a href="/student-registration-status" class="nav-link">
                                Registration by Status
                            </a>
                        </li>
                        <li><b>2. Employee</b></li>
                        <li class="nav-item">
                            <a href="/employee-report" class="nav-link" target="_blank">
                                Employees Details
                            </a>
                            <a href="/employee-leave-summary" class="nav-link" target="_blank">
                                Leave Summary
                            </a>
                            <a href="/employee-leave-select" class="nav-link" target="_blank">
                                Leave Details
                            </a>
                        </li>
                        <li><b>3. Accounting</b></li>
                        <li class="nav-item">
                            <a href="/select-income" class="nav-link">
                                Income Statement
                            </a>
                            <a href="/select-expense" class="nav-link">
                                Expense Statement
                            </a>
                        </li>
                        <!--<li><b>4. Financial Transaction</b></li>
                        <li class="nav-item">
                            <a href="rpt-student-registration" class="nav-link">
                                Commission Summary
                            </a>
                            <a href="rpt-student-registration" class="nav-link">
                                Commission by Status
                            </a>
                            <a href="rpt-student-registration" class="nav-link">
                                Commission by Student
                            </a>
                            <br>
                            <br>
                        </li>-->
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<br>
<br>