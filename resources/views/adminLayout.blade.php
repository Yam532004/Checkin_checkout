@include('layouts.header')

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="index3.html" class="brand-link">
                <span class="brand-text font-weight-light">AdminLTE 3</span>
            </a>
            <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition">
                <div class="os-padding">
                    <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
                        <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
                            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                                <div class="info">
                                    <a href="#" class="d-block">Alexander Pierce</a>
                                </div>
                            </div>

                            <div class="form-inline">
                                <div class="input-group" data-widget="sidebar-search">
                                    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                                    <div class="input-group-append">
                                        <button class="btn btn-sidebar">
                                            <i class="fas fa-search fa-fw"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="sidebar-search-results">
                                    <div class="list-group">
                                        <a href="#" class="list-group-item">
                                            <div class="search-title"><strong class="text-light">No element found!</strong></div>
                                            <div class="search-path"></div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <nav class="mt-2">

                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href={{route('dashboard')}} class="nav-link">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href={{route('employees')}} class="nav-link">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>
                                        Employees
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </aside>
        <div class="content-wrapper">
            <x-app-layout>
                <x-slot name="header">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        @yield('title')
                    </h2>
                    <section class="content mt-5">
                        <div class="container-fluild mr-3">
                            @yield('content')

                        </div>
                    </section>
                </x-slot>
            </x-app-layout>
        </div>
    </div>
</body>