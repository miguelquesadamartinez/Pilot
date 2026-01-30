                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        @role('OrderController')

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                @if( isset($countTodosDb) )
                                    <span class="badge badge-danger badge-counter">{{ $countTodosDb }}+</span>
                                @endif
                            </a>

                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                {{ __('Errors detected') }}
                                </h6>
                                @if( isset($todosDB) )
                                    @foreach($todosDB as $todo)
                                        <a class="dropdown-item d-flex align-items-center" href="http://127.0.0.1:83/error-report-todo/{{ $todo->id }}" target="_blank">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-danger">
                                                    <i class="fas fa-file-alt text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                @php
                                                    $fecha = strftime('%A, %d-%m-%Y, %H:%M', strtotime($todo->created_at));
                                                @endphp

                                                <div class="small text-gray-500 font-weight-bold">{{ $fecha }}</div>
                                                <span class="font-weight-bold">{{ $todo->module }}</span>
                                            </div>
                                        </a>
                                    @endforeach
                                @endif
                                <a class="dropdown-item text-center small text-gray-500" target="_blank" href="http://127.0.0.1:83/todos-report">Show All Alerts</a>
                            </div>
                        </li>

                        @endrole

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->

                        <li class="nav-item">
                            <a href="{{ url('language/en') }}" class="nav-link"><img src="{{ asset('/img/en.png') }}" @if($locale == 'en') width="32" @else width="16" @endif alt="English"></a>
                        </li>
                        <li  class="nav-item">
                            <a href="{{ url('language/es') }}" class="nav-link"><img src="{{ asset('/img/es.png') }}" @if($locale == 'es') width="32" @else width="16" @endif alt="Spanish"></a>
                        </li>
                        <li  class="nav-item">
                            <a href="{{ url('language/fr') }}" class="nav-link"><img src="{{ asset('/img/fr.png') }}" @if($locale == 'fr') width="32" @else width="16" @endif alt="French"></a>
                        </li>
                        <!--
                        <li  class="nav-item">
                            <a href="{{ url('language/pt') }}" class="nav-link"><img src="{{ asset('/img/pt.png') }}" @if($locale == 'pt') width="32" @else width="16" @endif alt="Portuguese"></a>
                        </li>
                        -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                @php /* @endphp
                                <img class="img-profile rounded-circle"
                                    src="{{ asset('/img/undraw_profile.svg') }}">
                                @php */ @endphp
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="/profile">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
                