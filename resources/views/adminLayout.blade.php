<style>
    /* CSS cho trường input */
    .dataTables_filter input[type="search"] {
        border: 1px solid #000;
        /* Đặt màu và độ dày của border */
        border-radius: 4px;
        /* Tạo góc bo tròn cho border nếu cần */
        padding: 5px;
        /* Thêm khoảng cách bên trong trường input */
    }

    /* CSS cho khi trường input được focus */
    .dataTables_filter input[type="search"]:focus {
        border-color: #007bff;
        /* Thay đổi màu border khi trường input được focus */
        outline: none;
        /* Loại bỏ outline mặc định khi trường input được focus */
    }

    /* CSS cho phần tử select */
    .dataTables_length select {
        width: 70px;
        border: 1px solid #000;
        /* Đặt màu và độ dày của border */
        border-radius: 4px;
        /* Tạo góc bo tròn cho border */
        padding: 5px;
        /* Thêm khoảng cách bên trong phần tử select */
        background-color: #fff;
        /* Màu nền cho phần tử select */
        font-size: 16px;
        /* Kích thước font chữ */
    }

    /* CSS cho khi phần tử select được focus */
    .dataTables_length select:focus {
        border-color: #007bff;
        /* Thay đổi màu border khi phần tử select được focus */
        outline: none;
        /* Loại bỏ outline mặc định khi phần tử select được focus */
        box-shadow: 0 0 0 1px #007bff;
        /* Thêm hiệu ứng bóng khi phần tử select được focus */
    }

    /* CSS cho pagination  */
    .paginate_button:hover {
        background-color: cornflowerblue;
    }

    @media (max-width: 576px) {
        #list_checkin_late_table {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }

        #list_checkin_late_table th,
        #list_checkin_late_table td {
            display: inline-block;
            width: auto;
        }
    }
    .dataTables_length{
        display: none;
    }
    .dataTables_filter{
        display: none;
    }





</style>
@include('layouts.header')

<body class="hold-transition sidebar-mini ">
    <div class="wrapper ">
        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4 ">
            <a href="index3.html" class="brand-link">
                <span class="brand-text font-weight-light">Check Time</span>
            </a>
            <div class=" sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition">
                <div class="os-padding">
                    <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
                        <div class="os-content h-100" style="padding: 0px 8px; width: 100%;">
                            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                                <div class="info">
                                    <a href="#" class="d-block">Melon Sophia</a>
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
                    <section class="content">
                        <div class="container-fluild mr-3">
                            @yield('content')

                        </div>
                    </section>
                </x-slot>
            </x-app-layout>
        </div>
    </div>
</body>