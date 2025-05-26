<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> @yield('title')</title>
        
        <!-- General CSS Files -->
        <link rel="stylesheet" href="{{ asset('default/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('default/css/font-awesome.css') }}">

        <!-- Template CSS -->
        <link rel="stylesheet" href="{{ asset('default/css/dashboard.css') }}">
        <link rel="stylesheet" href="{{ asset('default/css/components.css') }}">
        <link rel="stylesheet"  href="{{ asset('default/css/datatables.bootstrap4.css') }}" >        
    </head>

    <body>
        <div id="app">

            <div class="main-wrapper main-wrapper-1">
                @if($auth == true)
                <div class="navbar-bg"></div>
                <nav class="navbar navbar-expand-lg main-navbar">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                    </ul>
                    <!-- <div class="cryptohopper-web-widget" data-id="2" data-text_color="#ffffff" data-background_color="#1c364b" data-realtime="on" data-changes="0"></div> -->
                </nav>


                <div class="main-sidebar sidebar-style-2">
                    <aside id="sidebar-wrapper">
                        <div class="sidebar-brand">
                            <a href="{{ route('admin.dashboard') }}">{{ config('app.name') }}</a>
                        </div>

                        <div class="sidebar-brand sidebar-brand-sm">
                            <a href="{{ route('admin.dashboard') }}">{{ config('app.name') }}</a>
                        </div>

                        <ul class="sidebar-menu">
                            <li class="menu-header"><i class="fas fa-meter"></i> Dashboard</li>
                            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> <span>Overview</span></a></li>
                            <li class="{{ request()->routeIs('admin.users') || request()->routeIs('admin.user') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.users') }}"><i class="fas fa-user"></i> <span>Users</span></a></li>
                            <li class="dropdown {{ request()->routeIs('admin.deposits', ['type' => 'pending']) || request()->routeIs('admin.deposits', ['type' => 'all']) ? 'active' : '' }}">
                                <a href="#" class="nav-link has-dropdown">
                                    <i class="fas fa-download"></i> <span>Deposits</span>
                                </a>
                                <ul class="dropdown-menu" style="">
                                    <li class=""><a class="nav-link beep beep-sidebar" href="{{ route('admin.deposits', ['param' => 'pending']) }}">Pending</a></li>
                                    <li class=""><a class="nav-link" href="{{ route('admin.deposits', ['param' => 'approved']) }}">Successful</a></li>
                                    <li class=""><a class="nav-link" href="{{ route('admin.deposits', ['param' => 'cancelled']) }}">Failed</a></li>

                                </ul>
                            </li>
                            <li class="dropdown {{ request()->routeIs('admin.deposits', ['type' => 'pending']) || request()->routeIs('admin.deposits', ['type' => 'all']) ? 'active' : '' }}">
                                <a href="#" class="nav-link has-dropdown">
                                    <i class="fas fa-chart-line"></i> <span>Investment Plans</span>
                                </a>
                                <ul class="dropdown-menu" style="">
                                    <li class=""><a class="nav-link beep beep-sidebar" href="{{ route('admin.add_plan') }}">Add Plans</a></li>
                                    <li class=""><a class="nav-link" href="{{ route('admin.plans') }}">View Plans</a></li>
                                </ul>
                            </li>
                            
                            <li class="dropdown {{ request()->routeIs('admin.investments', ['type' => 'pending']) || request()->routeIs('admin.investments', ['type' => 'all']) ? 'active' : '' }}">
                                <a href="#" class="nav-link has-dropdown">
                                    <i class="fas fa-file-alt"></i> <span>Investments</span>
                                </a>
                                <ul class="dropdown-menu" style="">
                                    <li class=""><a class="nav-link beep beep-sidebar" href="{{ route('admin.investments', ['param' => 'pending']) }}">Pending</a></li>
                                    <li class=""><a class="nav-link" href="{{ route('admin.investments', ['param' => 'approved']) }}">Approved</a></li>
                                    <li class=""><a class="nav-link" href="{{ route('admin.investments', ['param' => 'cancelled']) }}">Cancelled</a></li>
                                </ul>
                            </li>
                            <li class="dropdown {{ request()->routeIs('admin.wallet_withdrawals', ['type' => 'pending']) || request()->routeIs('admin.wallet_withdrawals', ['type' => 'all']) ? 'active' : '' }}">
                                <a href="#" class="nav-link has-dropdown">
                                    <i class="fas fa-th-large"></i> <span>Wallet Withdrawals</span>
                                </a>
                                <ul class="dropdown-menu" style="">
                                    <li class=""><a class="nav-link beep beep-sidebar" href="{{ route('admin.wallet_withdrawals', ['param' => 'pending']) }}">Pending</a></li>
                                    <li class=""><a class="nav-link" href="{{ route('admin.wallet_withdrawals', ['param' => 'approved']) }}">Approved</a></li>
                                    <li class=""><a class="nav-link" href="{{ route('admin.wallet_withdrawals', ['param' => 'cancelled']) }}">Cancelled</a></li>
                                </ul>
                            </li>
                            <!-- <li class=""><a class="nav-link" href=""><i class="fas fa-money-bill"></i> <span>Wallet Withdrawals</span></a></li> -->
                            <li class="dropdown {{ request()->routeIs('admin.bank_withdrawals', ['type' => 'pending']) || request()->routeIs('admin.bank_withdrawals', ['type' => 'all']) ? 'active' : '' }}">
                                <a href="#" class="nav-link has-dropdown">
                                    <i class="fas fa-university"></i> <span>Bank Withdrawals</span>
                                </a>
                                <ul class="dropdown-menu" style="">
                                    <li class=""><a class="nav-link beep beep-sidebar" href="{{ route('admin.bank_withdrawals', ['param' => 'pending']) }}">Pending</a></li>
                                    <li class=""><a class="nav-link" href="{{ route('admin.bank_withdrawals', ['param' => 'approved']) }}">Approved</a></li>
                                    <li class=""><a class="nav-link" href="{{ route('admin.bank_withdrawals', ['param' => 'cancelled']) }}">Cancelled</a></li>
                                </ul>
                            </li>
                            <li class="dropdown {{ request()->routeIs('admin.codes', ['param' => 'bank_codes']) || request()->routeIs('admin.codes', ['param' => 'bank_type']) ? 'active' : '' }}">
                                <a href="#" class="nav-link has-dropdown">
                                    <i class="fas fa-qrcode"></i> <span>Access Codes</span>
                                </a>
                                <ul class="dropdown-menu" style="">
                                    <!-- <li class=""><a class="nav-link beep beep-sidebar" href="{ route('admin.codes', ['param' => 'otp']) }">One-Time Codes</a></li> -->
                                    <li class=""><a class="nav-link" href="{{ route('admin.codes', ['param' => 'bank_types']) }}">Bank Authoriation Types</a></li>
                                    <li class=""><a class="nav-link" href="{{ route('admin.codes', ['param' => 'bank_codes']) }}">Bank Authoriation Codes</a></li>
                                </ul>
                            </li>
                            <li class="{ request()->routeIs('admin.messages') ? 'active' : '' }"><a class="nav-link" href="{{ route('admin.messages') }}"><i class="fas fa-envelope"></i> <span>Messages</span></a></li>
                            <!-- 
                            
                            <li class="{ request()->routeIs('admin.bankCodes') ? 'active' : '' }"><a class="nav-link" href="{ route('admin.bankCodes') }"><i class="fas fa-key"></i> <span>Bank Codes</span></a></li> -->



                            <li class="dropdown {{ request()->routeIs('admin.settings', ['type' => 'fees']) || request()->routeIs('admin.settings', ['type' => 'app']) || request()->routeIs('admin.settings', ['type' => 'theme']) ? 'active' : '' }}">
                                <a href="#" class="nav-link has-dropdown">
                                    <i class="fas fa-cog"></i> <span>Settings</span>
                                </a>
                                <ul class="dropdown-menu" style="">
                                    <!-- <li class=""><a class="nav-link" href="{{ route('admin.codes', ['param' => 'otp']) }}">Fees</a></li> -->
                                    <!-- <li class=""><a class="nav-link" href="{{ route('admin.codes', ['param' => 'types']) }}">Payment</a></li> -->
                                    <!-- <li class=""><a class="nav-link" href="{{ route('admin.codes', ['param' => 'bank']) }}">Theme</a></li> -->
                                    <li class=""><a class="nav-link" href="{{ route('admin.change_password') }}">Change Password</a></li>
                                </ul>

                            </li>
                            <li class="dropdown {{ request()->routeIs('admin.livechat') || request()->routeIs('admin.payment_gateway') ? 'active' : '' }}">
                                <a href="#" class="nav-link has-dropdown">
                                    <i class="fas fa-cloud"></i> <span>Integrations</span>
                                </a>
                                <ul class="dropdown-menu" style="">
                                    <li class=""><a class="nav-link" href="{{ route('admin.livechat') }}">Live Chat</a></li>
                                    <li class=""><a class="nav-link" href="{{ route('admin.payment_gateway') }}">Payment</a></li>
                                    <!-- <li class=""><a class="nav-link" href="{{ route('admin.codes', ['param' => 'bank']) }}">Theme</a></li> -->
                                </ul>
                            </li>
                            <li class=""><a class="nav-link" href="{{ route('admin.logout') }}"><i class="fas fa-power-off"></i> <span>Logout</span></a></li>

                        </ul>
                    </aside>
                </div>
                @endif

                <!-- Main Content -->
                <div class="main-content">
                    @yield('content')
                </div>

                <footer class="main-footer">
                    <div class="footer-left">
                        Copyright &copy; {{ date('Y') }} <div class="bullet"></div> {{ config('app.name') }}
                    </div>
                </footer>

            </div>

        </div>
        <!-- General JS Scripts -->
        <script src="{{ asset('default/js/jquery-2.2.4.min.js') }}"></script>
        <script src="{{ asset('default/js/popper.js') }}"></script>
        <script src="{{ asset('default/js/tooltip.js') }}"></script>
        <script src="{{ asset('default/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('default/js/jquery.nicescroll.min.js') }}"></script>
        <script src="{{ asset('default/js/moment.min.js') }}"></script>
        <script src="{{ asset('default/js/charts.min.js') }}"></script>
        <script src="{{ asset('default/js/sweetalert.min.js') }}"></script>
        <script src="{{ asset('default/js/stisla.js') }}"></script>
        <script src="{{ asset('default/js/datatables.js') }}"></script>
        <script src="{{ asset('default/js/datatables.bootstrap4.js') }}"></script>
        @if(session('success'))
        <script>
            $(function() {
                swal({
                title: 'Successful',
                text: "{{ session('success') }}",
                icon: 'success'
                })
            })
        </script>
        @endif

        @if(session('error'))
        <script>
            $(function() {
                swal({
                title: 'Error',
                text: "{{ session('error') }}",
                icon: 'warning'
                })
            })
        </script>
        @endif

        @yield('js')

         <!-- Template JS File -->
        <script src="{{ asset('default/js/scripts.js') }}"></script>
        <!-- <script src="//code.jivosite.com/widget/jAvEHXl0OI" async></script> -->
        <!-- <script src="https://www.cryptohopper.com/widgets/js/script"></script> -->
        <!-- <script src="{{ asset('default/js/custom.js') }}"></script> -->
    </body>
</html>