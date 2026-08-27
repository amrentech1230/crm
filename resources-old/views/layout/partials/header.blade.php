<header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <!-- <div class="navbar-brand-box">
                            <a href="{{ route('home') }}" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="https://stagingcci.in/public/images/only%20logo.png" alt=""  alt="logo-sm" height="50">
                                </span>
                                <span class="logo-lg">
                                    <img src="https://stagingcci.in/public/images/only%20logo.png" alt="logo-dark" height="50">
                                </span>
                            </a>

                            <a href="{{ route('home') }}" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{ asset(Auth::user()->profile_picture ?? 'default.jpg') }}" alt="logo-sm-light" height="50">
                                </span>
                                <span class="logo-lg">
                                    <img src="https://stagingcci.in/public/images/only%20logo.png" alt="logo-light" height="50">
                                </span>
                            </a>
                        </div> -->

                        <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                            <i class="ri-menu-2-line align-middle"></i>
                        </button>

                        

                        
                    </div>

                    <div class="d-flex">
                        <!-- App Search-->
                        <form class="app-search d-none d-lg-block">
                            <div class="position-relative">
                                <input type="text" class="form-control" name="query" placeholder="Search...">
                                <span class="ri-search-line"></span>
                            </div>
                        </form>

                        <div class="dropdown d-inline-block d-lg-none ms-2">
                            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ri-search-line"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-search-dropdown">
                    
                                <form class="p-3">
                                    <div class="mb-3 m-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search ...">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit"><i class="ri-search-line"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div class="dropdown d-none d-lg-inline-block ms-1">
                            <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                                <i class="ri-fullscreen-line"></i>
                            </button>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                                  data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-notification-3-line"></i>
                                <span class="noti-dot"></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-notifications-dropdown">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0"> Notifications </h6>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#!" class="small"> View All</a>
                                        </div>
                                    </div>
                                </div>
                                <div data-simplebar style="max-height: 230px;">
                                    <a href="" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                    <i class="ri-shopping-cart-line"></i>
                                                </span>
                                            </div>
                                            <div class="flex-1">
                                                <h6 class="mb-1">Your order is placed</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">If several languages coalesce the grammar</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <img src="{{ asset('assets/images/users/avatar-3.jpg') }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                            <div class="flex-1">
                                                <h6 class="mb-1">James Lemire</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">It will seem like simplified English.</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-success rounded-circle font-size-16">
                                                    <i class="ri-checkbox-circle-line"></i>
                                                </span>
                                            </div>
                                            <div class="flex-1">
                                                <h6 class="mb-1">Your item is shipped</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">If several languages coalesce the grammar</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                    <a href="" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <img src="{{ asset('assets/images/users/avatar-4.jpg') }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                            <div class="flex-1">
                                                <h6 class="mb-1">Salena Layfield</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">As a skeptical Cambridge friend of mine occidental.</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2 border-top">
                                    <div class="d-grid">
                                        <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                            <i class="mdi mdi-arrow-right-circle me-1"></i> View More..
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown d-inline-block user-dropdown">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="{{ asset(Auth::user()->profile_picture ?? 'default.jpg') }}"
                                    alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ms-1">{{ Auth::user()->name }}</span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="{{route('profile')}}"><i class="ri-user-line align-middle me-1"></i> Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
                            </div>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                                <i class="ri-settings-2-line"></i>
                            </button>
                        </div>
            
                    </div>
                </div>
            </header>


             <!-- ========== Left Sidebar Start ========== -->
             <div class="vertical-menu">

<div data-simplebar class="h-100">

    <!-- User details -->
    <div class="user-profile text-center mt-3">
        <div class="">
            <img src="{{ asset(Auth::user()->profile_picture ?? 'default.jpg') }}" alt="" width="100px" height="100px" class="rounded-circle">
        </div>
        <div class="mt-3">
            <h4 class="font-size-16 mb-1">{{ Auth::user()->name }}</h4>
            <span class="text-muted"> <span class="text-muted">{{ Auth::user()->role->name ?? 'No Role Assigned' }}</span>
            </span>
        </div>
    </div>

    <!--- Sidemenu -->
    <div id="sidebar-menu">
        <!-- Left Menu Start -->
         <!----------- Admin ------------->
        <ul class="metismenu list-unstyled" id="side-menu">
        
            @if(isset($userMenus) && in_array('Home', $userMenus))
            <li>
                <a href="{{route('admin_home')}}" class="waves-effect">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
            </li>
            @endif
            @if(isset($userMenus) && in_array('All Data', $userMenus))
            <li>
                <a href="{{route('all_data')}}" class=" waves-effect">
                    <i class="fas fa-clipboard-list"></i>
                    <span>All Data</span>
                </a>
            </li>
            @endif
            @if(isset($userMenus) && in_array('Add New user', $userMenus) || in_array('Broker Users List', $userMenus) || in_array('Department', $userMenus) || in_array('Manager', $userMenus) || in_array('Team leader', $userMenus) || in_array('Status Type', $userMenus) || in_array('Shipment Type', $userMenus) || in_array('Equipment Type', $userMenus) || in_array('Country', $userMenus) || in_array('State', $userMenus)) 
            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="fas fa-user-alt"></i>
                    <span>Admin</span>
                </a>
                <ul class="sub-menu" aria-expanded="fa lse">
                     @if(in_array('Add New user', $userMenus))
                        <li><a href="{{route('add_new_users')}}">Add New user</a></li>
                    @endif
                    @if(in_array('Broker Users List', $userMenus))
                        <li><a href="{{route('office')}}">Office</a></li>
                    @endif
                    @if(in_array('Department', $userMenus))
                        <li><a href="{{route('department')}}">Department</a></li>
                    @endif
                    @if(in_array('Manager', $userMenus))
                        <li><a href="{{route('manager')}}">Manager</a></li>
                    @endif
                    @if(in_array('Team leader', $userMenus))
                        <li><a href="{{route('team_leader')}}">Team leader</a></li>
                    @endif
                    @if(in_array('Status Type', $userMenus))
                        <li><a href="{{route('status_type')}}">Status Type</a></li>
                    @endif
                    @if(in_array('Shipment Type', $userMenus))
                        <li><a href="{{route('shipment_type')}}">Shipment Type</a></li>
                    @endif
                    @if(in_array('Equipment Type', $userMenus))
                        <li><a href="{{route('equipment_type')}}">Equipment Type</a></li>
                    @endif
                    @if(in_array('Country', $userMenus))
                        <li><a href="{{route('country')}}">Country</a></li>
                    @endif
                    @if(in_array('State', $userMenus))
                        <li><a href="{{route('state')}}">State</a></li>
                    @endif
                </ul>
            </li>
            @endif
            @if(isset($userMenus) && in_array('Broker users list', $userMenus) || in_array('Account users list', $userMenus) || in_array('Admin users list', $userMenus))
            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class=" fas fa-users-cog"></i>
                    <span>Users</span>
                </a>
                <ul class="sub-menu" aria-expanded="true">
                    @if(in_array('Broker users list', $userMenus))
                    <li><a href="{{route('broker_users')}}">Broker users list</a></li>
                    @endif
                    @if(in_array('Account users list', $userMenus))
                    <li><a href="{{route('account_users')}}">Account users list</a></li>
                     @endif
                    @if(in_array('Admin users list', $userMenus))
                    <li><a href="{{route('admin_users')}}">Admin users list</a></li>
                    @endif
                </ul>
            </li>
            <!-- <li>
                <a href="{{route('its_data')}}" class=" waves-effect">
                    <i class="fas fa-file-signature"></i>
                    <span>ITS Data</span>
                </a>
            </li> -->
            @endif
            @if(isset($userMenus) && in_array('Dashboard', $userMenus))
            <li>
                <a href="{{route('dashboard')}}" class=" waves-effect">
                    <i class="ri-dashboard-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            @endif
            @if(isset($userMenus) && in_array('Roles', $userMenus))
            <li>
                <a href="{{route('roles')}}" class=" waves-effect">
                    <i class="fas fa-user-shield"></i>
                    <span>Roles</span>
                </a>
            </li>
            @endif
            @if(isset($userMenus) && in_array('Permission', $userMenus))
            <li>
                <a href="{{route('permissions')}}" class=" waves-effect">
                    <i class="fas fa-hand-paper"></i>
                    <span>Permissions</span>
                </a>
            </li>
            @endif
            @if(isset($userMenus) && in_array('All Activity Logs', $userMenus))
            <li>
                <a href="{{route('activity_logs')}}" class=" waves-effect">
                    <i class="fas fa-history"></i>
                    <span>All Activity Logs</span>
                </a>
            </li>
            @endif

            <li>
                <a href="{{ route('ip.config.create') }}" class=" waves-effect">
                    <i class="fas fa-history"></i>
                    <span>IP Permission</span>
                </a>
            </li>


            <!----------- Accounts ------------->

            <!-- <li>
                <a href="{{route('account_manager')}}" class=" waves-effect">
                    <i class="fas fa-file-signature"></i>
                    <span>Account Manager</span>
                </a>
            </li> -->
            @if(isset($userMenus) && in_array('Accounting', $userMenus))
            <li>
                <a href="{{route('accounting')}}" class=" waves-effect">
                    <i class="fas fa-user-cog"></i>
                    <span>Accounting</span>
                </a>
            </li>
            @endif
            @if(isset($userMenus) && in_array('Reporting', $userMenus))
            <li>
                <a href="{{route('reporting')}}" class=" waves-effect">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Reporting</span>
                </a>
            </li>
            @endif
            @if(isset($userMenus) && in_array('Vendor System', $userMenus))
            <li>
                <a href="{{route('vendor_system')}}" class=" waves-effect">
                    <i class="fas fa-truck"></i>
                    <span>Vendor System</span>
                </a>
            </li>
            @endif
            @if(isset($userMenus) && in_array('Compliance', $userMenus))
            <li>
                <a href="{{route('compliance')}}" class=" waves-effect">
                    <i class="fas fa-network-wired"></i>
                    <span>Compliance</span>
                </a>
            </li>
            @endif
            
            <!----------- Brokers ------------->

            @if(isset($userMenus) && in_array('Home', $userMenus))
            <li>
                <a href="{{route('home')}}" class=" waves-effect">
                    <i class=" fas fa-home"></i>
                    <span>Home</span>
                </a>
            </li>
            @endif
            @if(isset($userMenus) && in_array('Customer', $userMenus))
            <li>
                <a href="{{route('customer')}}" class=" waves-effect">
                    <i class="ri-account-circle-line"></i>
                    <span>Customer</span>
                </a>
            </li>
            @endif
            @if(isset($userMenus) && in_array('Carrier', $userMenus))
            <li>
                <a href="{{route('carrier')}}" class=" waves-effect">
                    <i class=" fas fa-truck"></i>
                    <span>Carrier</span>
                </a>
            </li>
            @endif
            @if(isset($userMenus) && in_array('Shipper', $userMenus))
            <li>
                <a href="{{route('shipper')}}" class=" waves-effect">
                    <i class="fas fa-truck-moving"></i>
                    <span>Shipper</span>
                </a>
            </li>
            @endif
            @if(isset($userMenus) && in_array('Consignee', $userMenus))
            <li>
                <a href="{{route('Consignee')}}" class=" waves-effect">
                    <i class="fas fa-box-open"></i>
                    <span>Consignee</span>
                </a>
            </li>
            @endif
            @if(isset($userMenus) && in_array('Load Creation', $userMenus))
            <li>
                <a href="{{route('load')}}" class=" waves-effect">
                    <i class=" fas fa-truck-loading"></i>
                    <span>Load Creation</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
    <!-- Sidebar -->
</div>
</div>
<!-- Left Sidebar End -->
  <!-- ============================================================== -->
  <!-- Start right Content here -->
  <!-- ============================================================== -->
<div class="main-content">