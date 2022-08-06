<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'sudip.me') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('admin-assets/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/datetimepicker/jquery.datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/fancybox-3.0/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/datatables/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/datatables/export/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/styles.css') }}">
    @yield('styles')
</head>
<body class="hold-transition skin-black sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <a href="{{ route('admin.dashboard') }}" class="logo">
                <span class="logo-mini">
                    <img src="{{ asset('admin-assets/images/icon.png') }}" alt="{{ config('app.name', 'Laravel') }}">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('admin-assets/images/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}" style="height: 40px;">
                </span>
            </a>

            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">&nbsp;</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <span class="project-name-header"></span>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ asset('admin-assets/images/avatar.png') }}" alt="avatar" class="user-image">
                            <span class="hidden-xs">
                                {{ Auth::user()->name }}
                            </span>
                        </a>

                        <ul class="dropdown-menu">

                            <li class="user-header">
                                <img src="{{ asset('admin-assets/images/avatar.png') }}" alt="avatar" class="img-circle">
                                <p>
                                    {{ Auth::user()->name }}
                                    <small>
                                        {{ Auth::user()->email }}<br>
                                        {{ Auth::user()->mobile }}
                                    </small>
                                </p>
                            </li>

                            <li class="user-footer">
                                <div class="pull-left">
                                    <a class="btn btn-custom btn-flat" href="{{route('admin.profile')}}">{{ __('lang.Profile') }}</a>
                                </div>
                                <div class="pull-right">
                                    <a class="btn btn-custom btn-flat" href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('lang.Logout') }}
                                    </a>

                                    <form id="logout-form" class="non-validate" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="main-sidebar">
            <section class="sidebar">
                <ul class="sidebar-menu">
                    <li class="{{ Request::routeIs('admin.dashboard') ? 'active' : ''}}">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fa fa-dashboard"></i>
                            <span>{{ __('lang.Dashboard') }}</span>
                        </a>
                    </li>
                    
                    <li class="{{ Request::routeIs('admin.category.*') ? 'active' : ''}}">
                        <a href="{{ route('admin.category.index') }}">
                            <i class="fa fa-dashboard"></i>
                            <span>{{ __('lang.Category') }}</span>
                        </a>
                    </li>
                    
                    <li class="{{ Request::routeIs('admin.post.*') ? 'active' : ''}}">
                        <a href="{{ route('admin.post.index') }}">
                            <i class="fa fa-dashboard"></i>
                            <span>{{ __('lang.Post') }}</span>
                        </a>
                    </li>
                    
                    <li class="{{ Request::routeIs('admin.page.*') ? 'active' : ''}}">
                        <a href="{{ route('admin.page.index') }}">
                            <i class="fa fa-dashboard"></i>
                            <span>{{ __('lang.Page') }}</span>
                        </a>
                    </li>
                    
                    <li class="{{ Request::routeIs('admin.menu.*') ? 'active' : ''}}">
                        <a href="{{ route('admin.menu.index') }}">
                            <i class="fa fa-dashboard"></i>
                            <span>{{ __('lang.Menu') }}</span>
                        </a>
                    </li>

                    <li class="treeview {{ (Request::routeIs('admin.staff.*') || Request::routeIs('admin.role.*')) ? 'active menu-open' : ''}}">
                        <a href="#">
                            <i class="fa fa-upload"></i>
                            <span>{{ __('lang.Staff Management') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ Request::routeIs('admin.staff.*') ? 'active' : ''}}">
                                <a href="{{ route('admin.staff.index') }}">{{ __('lang.Staff') }}</a>
                            </li>
                            <li class="{{ Request::routeIs('admin.role.*') ? 'active' : ''}}">
                                <a href="{{ route('admin.role.index') }}">{{ __('lang.Role') }}</a>
                            </li>
                        </ul>
                    </li>

                    <li class="treeview {{ Request::routeIs('admin.classified.*') ? 'active menu-open' : ''}}">
                        <a href="#">
                            <i class="fa fa-upload"></i>
                            <span>{{ __('lang.Classified') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ Request::routeIs('admin.classified.category.*') ? 'active' : ''}}">
                                <a href="{{ route('admin.classified.category.index') }}">{{ __('lang.Category') }}</a>
                            </li>
                            <li class="{{ Request::routeIs('admin.classified.post.*') ? 'active' : ''}}">
                                <a href="{{ route('admin.classified.post.index') }}">{{ __('lang.Post') }}</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </section>
        </aside>

        <div class="content-wrapper">
            @if (session('successMessage'))
            <section class="content-header">
                <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{ session('successMessage') }}
                </div>
            </section>
            @endif

            @if (session('errorMessage'))
            <section class="content-header">
                <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{ session('errorMessage') }}
                </div>
            </section>
            @endif

            @yield('content')
        </div>

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                Developed by <a href="https://oshnisoftware.com" target="_blank">OSHNI SOFTWARE</a>
            </div>
            <strong>
                Copyright &copy; {{ date('Y') }} {{ config('app.name', 'sudip.me') }}.
            </strong> All rights reserved.
        </footer>
    </div>

    <script> var base_url = "{{ url('') }}"; </script>
    <script src="{{ asset('admin-assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/jquery/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/datetimepicker/jquery.datetimepicker.full.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/fancybox-3.0/jquery.fancybox.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin-assets/js/app.min.js') }}"></script>
    @yield('scripts')
</body>
</html>
