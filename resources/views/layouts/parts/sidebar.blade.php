<!-- Init of Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">

            <img src="{{ asset('/img/cmc_logo.png') }}" height="30">

        </div>
        <div class="sidebar-brand-text mx-3">Pilot</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item active">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{ __('Dashboard') }}</span></a>
    </li>

    @hasanyrole('TeleOperator|Searcher|SuperAdmin|It')
        <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSearcher"
                aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-fw fa-cog"></i>
                <span>{{ __('Order Search') }}</span>
            </a>
            <div id="collapseSearcher" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="/admin/searcher/main">{{ __('Search') }}</a>
                </div>
            </div>
        </li>
    @endhasanyrole

    @hasanyrole('Ticketing|SuperAdmin|It')
        <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTicketing"
                aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-fw fa-cog"></i>
                <span>{{ __('Support') }}</span>
            </a>
            <div id="collapseTicketing" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="/ticketing">{{ __('Tickets') }}</a>
                    
                        @role('Admin')
                            <a class="collapse-item" href="/ticketing/manage">{{ __('Manage') }}</a>
                        @endrole

                        @role('SuperAdmin')
                            <a class="collapse-item" href="/ticketing/dashboard-admin">{{ __('Admin Dashboard') }}</a>
                        @endrole
@php /*
                        @hasanyrole('AfterSales|SuperAdmin|It')
                            <a class="collapse-item" href="/ticketing/dashboard-after-sales">{{ __('After Sales Dashboard') }}</a>
                        @endhasanyrole

                        @hasanyrole('Logistics|SuperAdmin|It')
                            <a class="collapse-item" href="/ticketing/dashboard-logistics">{{ __('Logistics Dashboard') }}</a>
                        @endhasanyrole

                        @hasanyrole('Production|SuperAdmin|It')
                            <a class="collapse-item" href="/ticketing/dashboard-production">{{ __('Production Dashboard') }}</a>
                        @endhasanyrole

                        @hasanyrole('Accounting|SuperAdmin|It')
                            <a class="collapse-item" href="/ticketing/dashboard-accounting">{{ __('Accounting Dashboard') }}</a>
                        @endhasanyrole
*/ @endphp
                        @hasanyrole('Legal|SuperAdmin|It')
                            <a class="collapse-item" href="/ticketing/department-dashboard/Legal">{{ __('Legal Dashboard') }}</a>
                        @endhasanyrole

                        @hasanyrole('It|SuperAdmin')
                            <a class="collapse-item" href="/ticketing/department-dashboard/TI">{{ __('It Dashboard') }}</a>
                        @endhasanyrole

                        @hasanyrole('AfterSales|SuperAdmin|It')
                            <a class="collapse-item" href="/ticketing/department-dashboard/AfterSales">{{ __('After Sales Dashboard') }}</a>
                        @endhasanyrole

                        @hasanyrole('Logistics|SuperAdmin|It')
                            <a class="collapse-item" href="/ticketing/department-dashboard/Logistics">{{ __('Logistics Dashboard') }}</a>
                        @endhasanyrole

                        @hasanyrole('Production|SuperAdmin|It')
                            <a class="collapse-item" href="/ticketing/department-dashboard/Production">{{ __('Production Dashboard') }}</a>
                        @endhasanyrole

                        @hasanyrole('Litigation|SuperAdmin|It')
                            <a class="collapse-item" href="/ticketing/department-dashboard/Litigation">{{ __('Litigation Dashboard') }}</a>
                        @endhasanyrole

                        @hasanyrole('Accounting|SuperAdmin|It')
                            <a class="collapse-item" href="/ticketing/department-dashboard/Accounting">{{ __('Accounting Dashboard') }}</a>
                        @endhasanyrole
                </div>
            </div>
        </li>
    @endhasanyrole

    @hasanyrole('Documents|DocumentsActive|SuperAdmin|It|Admin')
        <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDocuments"
                aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-fw fa-cog"></i>
                <span>{{ __('Documents') }}</span>
            </a>
            <div id="collapseDocuments" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @hasanyrole('Documents|SuperAdmin|It')  
                        <a class="collapse-item" href="/documents">{{ __('Documents') }}</a>
                    @endhasanyrole
                    @hasanyrole('DocumentsActive|SuperAdmin|It')
                        <a class="collapse-item" href="/documents-active">{{ __('Documents Active') }}</a>
                    @endhasanyrole
                </div>
            </div>
        </li>
    @endhasanyrole

    @hasanyrole('Scores|SuperAdmin|It|Admin')
    <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseScore"
                aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-fw fa-cog"></i>
                <span>{{ __('Scoring') }}</span>
            </a>
            <div id="collapseScore" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="/scoring/pharmacies">{{ __('Pharmacies') }}</a>
                    @role('Admin')
                        <a class="collapse-item" href="/scoring/laboratories">{{ __('Laboratories') }}</a>
                    @endrole
                </div>
            </div>
        </li>
    @endhasanyrole

    @hasanyrole('Logistics|SuperAdmin|It|Admin')
    <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOut"
                aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-fw fa-cog"></i>
                <span>{{ __('Out of stock') }}</span>
            </a>
            <div id="collapseOut" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="/products-out-of-stock">{{ __('Products out of stock') }}</a>
                </div>
            </div>
        </li>
    @endhasanyrole

    @hasanyrole('Logistics|SuperAdmin|It|Admin')
    <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDispute"
                aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-fw fa-cog"></i>
                <span>{{ __('Order dispute') }}</span>
            </a>
            <div id="collapseDispute" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="/search-order-dispute/main">{{ __('Search order') }}</a>
                    <a class="collapse-item" href="/search-order-dispute/list-open">{{ __('List open disputes') }}</a>
                    <a class="collapse-item" href="/search-order-dispute/list-closed">{{ __('List closed disputes') }}</a>
                </div>
            </div>
        </li>
    @endhasanyrole

    @hasanyrole('SuperAdmin|It|Admin')
    <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSearch"
                aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-fw fa-cog"></i>
                <span>{{ __('Recordings') }}</span>
            </a>
            <div id="collapseSearch" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="/recording-search/main">{{ __('Recordings search') }}</a>
                </div>
            </div>
        </li>
    @endhasanyrole

    @hasanyrole('SuperAdmin|It|Admin|FileChecker')
        <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaphal"
                aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-fw fa-cog"></i>
                <span>{{ __('File check') }}</span>
            </a>
            <div id="collapseLaphal" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="/laphal/check-file">{{ __('Check Laphal file') }}</a>
                </div>
            </div>
        </li>
    @endhasanyrole

    @hasanyrole('SuperAdmin|It|Admin|Accounting')
        <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRecovery"
                aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-fw fa-cog"></i>
                <span>{{ __('Recovery') }}</span>
            </a>
            <div id="collapseRecovery" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="/recovery/blocked-customers">{{ __('Blocked customers') }}</a>
                </div>
            </div>
        </li>
    @endhasanyrole

    @hasanyrole('DataLoader|SuperAdmin|It|Admin')
        <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDataLoader"
                aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-fw fa-cog"></i>
                <span>{{ __('Data Load') }}</span>
            </a>
            <div id="collapseDataLoader" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="/admin/dataloader/gls">{{ __('Tracking from GLS') }}</a>
                    @php /* <a class="collapse-item" href="/admin/dataloader/proof-upload">{{ __('Upload Proof of delivery') }}</a>*/ @endphp
                    <a class="collapse-item" href="/admin/dataloader/proof-delete">{{ __('Delete Proof of delivery') }}</a>
                </div>
            </div>
        </li>
    @endhasanyrole

    @hasanyrole('Admin|SuperAdmin|It')
        <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdmin"
                aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-fw fa-cog"></i>
                <span>{{ __('Admin Panel') }}</span>
            </a>
            <div id="collapseAdmin" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="/admin/users">{{ __('Users') }}</a>
                    <a class="collapse-item" href="/admin/roles">{{ __('Roles') }}</a>
                    <a class="collapse-item" href="/admin/permissions">{{ __('Permissions') }}</a>
                    <a class="collapse-item" href="/admin/permissions-table">{{ __('New Permissions') }}</a>
                </div>
            </div>
        </li>
    @endhasanyrole

    @hasanyrole('FileGenerator|Admin|SuperAdmin|It')
    <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFile"
                aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-fw fa-cog"></i>
                <span>{{ __('File Generator') }}</span>
            </a>
            <div id="collapseFile" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="/file-generator/ecommerce-sage">{{ __('Sage File Generator') }}</a>
                </div>
            </div>
        </li>
    @endhasanyrole

    @hasanyrole('OrderController|Admin|SuperAdmin|It')
        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            Order Controller
        </div>

        <li class="nav-item">
            <a target="_blank" class="nav-link" href="{{env('CONTROLLER_PATH')}}/todos-report">
                <i class="fas fa-fw fa-calendar-check"></i>
                <span>{{ __('Todo Report') }}</span></a>
        </li>
    @endhasanyrole
    <hr class="sidebar-divider d-none d-md-block">
</ul>
<!-- End of Sidebar -->
