@php
    //  $notificationCount = auth()->user()->unreadNotifications->count();
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
    style="direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};">


<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Mr-Fix</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('assets/img/mr-fix.png') }}" type="image/x-icon" />
<style>
    .sidebar-wrapper.scrollbar.scrollbar-inner {
        padding-top: 10px;
    }
</style>

    <!-- Fonts and icons -->
    <script src="{{ asset('assets/admin/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('assets/admin/css/fonts.min.css') }}"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/css/kaiadmin.min.css') }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


    <style>
        .main-panel>.container {

            padding: 20px !important;
        }
        a.btn.btn-sm.btn-success {
    margin-right: 10px !important;
}
    </style>

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/demo.css') }}" />
    @if (app()->getLocale() == 'ar')
        <link rel="stylesheet" href="{{ asset('assets/css/rtl.css') }}">
    @endif
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a href="{{route('admin.dashboard')}}" class="logo">
                        <img src="{{ asset('assets/img/mrfix-whiten.png') }}" alt="navbar brand" class="navbar-brand"
                            height="120" />
                    </a>

                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
                <!-- End Logo Header -->
            </div>

           <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
        <ul class="nav nav-secondary">
   <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <a href="{{ route('admin.dashboard') }}">
        <i class="fas fa-home"></i>
        <p>{{ __('message.home') }}</p>
    </a>
</li>

<li class="nav-item {{ request()->routeIs('request.index') ? 'active' : '' }}">
    <a href="{{ route('request.index') }}">
        <i class="fas fa-clipboard-list"></i>
        <p>{{ __('message.orders') }}</p>
    </a>
</li>

<li class="nav-item {{ request()->routeIs('worker.index') ? 'active' : '' }}">
    <a href="{{ route('worker.index') }}">
        <i class="fas fa-user-cog"></i>
        <p>{{ __('message.technicians') }}</p>
    </a>
</li>

<li class="nav-item {{ request()->routeIs('admin.index') ? 'active' : '' }}">
    <a href="{{ route('admin.index') }}">
        <i class="fas fa-user-shield"></i>
        <p>{{ __('message.admins') }}</p>
    </a>
</li>

<li class="nav-item {{ request()->routeIs('kyc.index') ? 'active' : '' }}">
    <a href="{{ route('kyc.index') }}">
        <i class="fas fa-id-card"></i>
        <p>{{ __('message.kycs') }}</p>
    </a>
</li>

<li class="nav-item {{ request()->routeIs('user.index') ? 'active' : '' }}">
    <a href="{{ route('user.index') }}">
        <i class="fas fa-users"></i>
        <p>{{ __('message.clients') }}</p>
    </a>
</li>

<li class="nav-item {{ request()->routeIs('category.index') ? 'active' : '' }}">
    <a href="{{ route('category.index') }}">
        <i class="fas fa-layer-group"></i>
        <p>{{ __('message.categories') }}</p>
    </a>
</li>

<li class="nav-item {{ request()->routeIs('specialization.index') ? 'active' : '' }}">
    <a href="{{ route('specialization.index') }}">
<i class="fas fa-wrench"></i>
        <p>{{ __('message.services') }}</p>
    </a>
</li>


            <li class="nav-item {{ request()->routeIs('regions.index') ? 'active' : '' }}">
                <a href="">
                    <i class="fas fa-map-marker-alt"></i>
                    <p>{{ __('message.regions') }}</p>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('settings.index') ? 'active' : '' }}">
                <a href="}">
                    <i class="fas fa-cog"></i>
                    <p>{{ __('message.settings') }}</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <p>{{ __('message.logout') }}</p>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>

        </div>

        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="dark">
                        <a href="index.html" class="logo">
                            <img src="assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand"
                                height="20" />
                        </a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="gg-menu-right"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                        </div>
                        <button class="topbar-toggler more">
                            <i class="gg-more-vertical-alt"></i>
                        </button>
                    </div>
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <nav>

                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        @if (App::getLocale() == 'en')
                                            English
                                        @else
                                            العربية
                                        @endif
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item"
                                                href="{{ route('checkLanguage', ['locale' => 'en']) }}">English</a>
                                        </li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('checkLanguage', ['locale' => 'ar']) }}">العربية</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>

                        </nav>

                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                        


                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="{{ route('admin.dashboard') }}"
                                    aria-expanded="false">
                                    <div class="avatar-sm">
                                        <img src="{{ asset('assets/avatars/avatar2.jpg') }}" alt="..."
                                            class="avatar-img rounded-circle" />
                                        
                                    </div>
                                    <span class="profile-username">
                                        <span class="op-7">{{ Auth::user()->name }}</span>
                                    </span>
                                </a>
                              
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>
