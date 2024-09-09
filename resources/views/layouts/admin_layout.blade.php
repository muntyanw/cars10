<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="icon" type="image/x-icon" sizes="20x20"
        href="/storage/common/oovpKJMyh4leT8NYjk3JRxd1g5MRMn7C3texDBqP.png">
    <title>
        @yield('title')
    </title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/admin/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="/admin/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/admin/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/admin/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/admin/plugins/summernote/summernote-bs4.min.css">

    @yield('style')

    <style>
        .btn {
            margin:2px 2px;
        }
    </style>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="/storage/common/RpZqJOaoyYyaBBb4tyXS9gf9nYBjJ5UXOD5roamN.png"
                alt="YNLogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href={{ route('dashboard') }} class="nav-link">{{ __('Dashboard') }}</a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
        <div class="conntainer">
            <div class="row">
                <div class="col-lg-2">
                    <!-- Main Sidebar Container -->
                    <aside class="main-sidebar sidebar-dark-primary elevation-4">
                        <!-- Brand Logo -->
                        <a href="/admin_panel/" class="brand-link">
                            <img src="/storage/common/oovpKJMyh4leT8NYjk3JRxd1g5MRMn7C3texDBqP.png"
                                alt="YN Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                            <span class="brand-text font-weight-light" style="font-size: 1.4rem;">
                                {{ __('Admin panel') }} {{-- @yield('title') --}}
                            </span>
                        </a>

                        <!-- Sidebar -->
                        <div class="sidebar">
                            <!-- Sidebar user panel (optional) -->
                            {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                                <div class="image" style="text-align: center;">
                                    @if (Auth::user()->volunteer && Auth::user()->volunteer->photo)
                                        <img src="{{ Auth::user()->volunteer->photo }}"
                                            alt="User Photo" class="elevation-1"
                                            style="max-width: 150px;">
                                    @else
                                        <img src="{{ asset('/storage/common/02ulyUfj0IDpOJKrj550BDY9vwR2s9rJAGBmMvO9.jpg') }}"
                                            alt="Default Photo" class="img-circle elevation-2"
                                            style="max-width: 150px;">
                                    @endif 
                                    <a href="#"
                                        class="d-block">{{ Auth::user()->name }}<br />{{ Auth::user()->email }}</a>
                                    
                                </div>
                                <div class="info">

                                </div>
                            </div> --}}

                            <!-- SidebarSearch Form -->
                            {{-- <div class="form-inline">
                                <div class="input-group" data-widget="sidebar-search">
                                    <input class="form-control form-control-sidebar" type="search"
                                        placeholder="Search" aria-label="Search">
                                    <div class="input-group-append">
                                        <button class="btn btn-sidebar">
                                            <i class="fas fa-search fa-fw"></i>
                                        </button>
                                    </div>
                                </div>
                            </div> --}}

                            <nav class="mt-2">
                                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview"
                                    role="menu" data-accordion="false">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fas fa-user-alt"></i>
                                            <p style="margin-left: 12px;">
                                                {{ __('All Users') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="{{ route('admin_users_index') }}" class="nav-link">
                                                    <i class="fas fa-user-friends"></i>
                                                    <p class="ml-3">{{ __('List') }}</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('admin_users_create') }}" class="nav-link">
                                                    <i class="fas fa-user-plus"></i>
                                                    <p class="ml-3">
                                                        {{ __('Create') }}
                                                    </p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon far fa-grin-stars"></i>
                                            <p style="margin-left: 2px;">
                                                {{ __('Volunteers') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="{{ route('admin_volunteers_index') }}" class="nav-link">
                                                    <i class="fas fa-user-friends"></i>
                                                    <p class="ml-3">{{ __('List') }}</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('admin_users_index') }}" class="nav-link">
                                                    <i class="fas fa-user-plus"></i>
                                                    <p class="ml-3">
                                                        {{ __('Create') }}
                                                    </p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fab fa-readme"></i>
                                            <p style="margin-left: 12px;">
                                                {{ __('Reports') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="{{ route('admin_report_list') }}" class="nav-link">
                                                    <i class="fas fa-layer-group"></i>
                                                    <p class="ml-3">{{ __('List') }}</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('admin_report_create') }}" class="nav-link">
                                                    <i class="fas fa-plus"></i>
                                                    <p class="ml-3">
                                                        {{ __('Create') }}
                                                    </p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fas fa-cash-register"></i>
                                            <p style="margin-left: 8px;">
                                                {{ __('Financial statements') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="{{ route('admin_financial_reports_index') }}" class="nav-link">
                                                    <i class="fas fa-book"></i>
                                                    <p class="ml-3">{{ __('List') }}</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('admin_financial_reports_create') }}" class="nav-link">
                                                    <i class="fas fa-plus"></i>
                                                    <p class="ml-3">
                                                        {{ __('Create') }}
                                                    </p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fas fa-tools"></i>
                                            <p style="margin-left: 12px;">
                                                {{ __('Skills') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="{{ route('admin_skills_list') }}" class="nav-link">
                                                    <i class="fas fa-tasks"></i>
                                                    <p class="ml-3">{{ __('List') }}</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('admin_skill_create') }}" class="nav-link">
                                                    <i class="fas fa-plus"></i>
                                                    <p class="ml-3">
                                                        {{ __('Create') }}
                                                    </p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fas fa-bullhorn"></i>
                                            <p style="margin-left: 12px;">
                                                {{ __('Offers') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="{{ route('admin_offers_index') }}" class="nav-link">
                                                    <i class="fas fa-briefcase"></i>
                                                    <p class="ml-3">{{ __('List') }}</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('admin_offer_create') }}" class="nav-link">
                                                    <i class="fas fa-plus"></i>
                                                    <p class="ml-3">
                                                        {{ __('Create') }}
                                                    </p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fas fa-award"></i>
                                            <p style="margin-left: 12px;">
                                                {{ __('Tenders') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="{{ route('admin_tender_index') }}" class="nav-link">
                                                    <i class="fas fa-bars"></i>
                                                    <p class="ml-3">{{ __('List') }}</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('admin_tender_create') }}" class="nav-link">
                                                    <i class="fas fa-plus"></i>
                                                    <p class="ml-3">
                                                        {{ __('Create') }}
                                                    </p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fas fa-bahai"></i>
                                            <p style="margin-left: 8px;">
                                                {{ __('Tender Proposal') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="{{ route('admin_tender_proposals_index') }}"
                                                    class="nav-link">
                                                    <i class="fas fa-bars"></i>
                                                    <p class="ml-3">{{ __('List') }}</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('admin_tender_index') }}" class="nav-link">
                                                    <i class="fas fa-plus"></i>
                                                    <p class="ml-3">
                                                        {{ __('Create') }}
                                                    </p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="far fa-newspaper"></i>
                                            <p style="margin-left: 8px;">
                                                {{ __('News') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="{{ route('admin.news.index') }}" class="nav-link">
                                                    <i class="fas fa-bars"></i>
                                                    <p class="ml-3">{{ __('List') }}</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="far fa-file"></i>
                                            <p style="margin-left: 8px;">
                                                {{ __('Storage Files') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="{{ route('admin_storage_files_index') }}" class="nav-link">
                                                    <i class="fas fa-bars"></i>
                                                    <p class="ml-3">{{ __('List') }}</p>
                                                </a>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fab fa-adn"></i>
                                            <p style="margin-left: 8px;">
                                                {{ __('Add to pages') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="{{ route('adds_pages_index') }}" class="nav-link">
                                                    <i class="fas fa-bars"></i>
                                                    <p class="ml-3">{{ __('List') }}</p>
                                                </a>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </aside>
                </div>
                <div class="col-lg-9" style="margin-left: 3em;">
                    @yield('content')
                </div>
            </div>
        </div>

        <!-- /.content-wrapper -->
        {{-- <footer class="main-footer">
          
        </footer> --}}

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="/admin/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="/admin/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="/admin/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="/admin/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="/admin/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="/admin/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="/admin/plugins/moment/moment.min.js"></script>
    <script src="/admin/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="/admin/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/admin/dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/admin/dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="/admin/dist/js/pages/dashboard.js"></script>

    @yield('scripts')
</body>

</html>
