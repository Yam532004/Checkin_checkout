<style>
    @media (max-width: 768px) {
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


    .nav-pills .nav-link:not(.active) {
        background: none;

    }

    .nav-pills .nav-link:not(.active):hover {
        background: blue;
        color: white;
        /* Nếu bạn muốn thay đổi màu chữ khi hover */
    }

    .nav-pills .nav-link.active:hover {
        color: darkblue;
        background: #007bff
    }

    .toast-custom-position {
        position: absolute;
        background-color: rgba(0, 0, 0, 0.8);
        /* Màu nền đậm */
        color: white;
        /* Màu chữ trắng */
        padding: 20px;
        /* Thêm padding để toastr to hơn */
        border-radius: 5px;
        /* Bo góc cho toastr */
        z-index: 9999;

        /* Đảm bảo toastr nằm trên các phần tử khác */
    }

    [id^="dt-length-"] {
        width: 65px;
        margin-right: 5px;
    }

    #aside {
        position: fixed;
        /* This fixes the sidebar in place */
        top: 0;
        /* Positions the sidebar at the top of the screen */
        left: 0;
        /* Positions the sidebar on the left side of the screen */
        height: 100vh;
        /* Sets the sidebar height to 100% of the viewport height */
        overflow-y: scroll
    }

    .nav-item.active {
        background-color: #e2eaf7;
        /* color: black !important; */
    }

    .nav-item.active a p,
    .nav-item.active a i {
        color: black !important;
    }
</style>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4 " id="aside">
            <div
                class=" sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition">
                <div class="os-padding ">
                    <p href="#" class="brand-link">
                        <span class="brand-text font-weight-light">Check times</span>
                    </p>

                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            @if (Auth::user()->role == 'user')
                            <li class="nav-item">
                                <a href="/homepage" class="nav-link">
                                    <i class="nav-icon fas fa-home"></i>
                                    <p>
                                        Check in
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/user/profile?id={{Auth::user()->id}}" class="nav-link">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>
                                        Story
                                    </p>
                                </a>
                            </li>
                            @elseif (Auth::user()->role == 'admin')
                            <li class="nav-item">
                                <a href="/admin/dashboard" class="nav-link">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/employees" class="nav-link">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>
                                        Users
                                    </p>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </nav>

                </div>
            </div>
        </aside>
        <div class="content-wrapper" style="min-height: 698px;">
            <x-app-layout>
                <x-slot name="header">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        @yield('title')
                    </h2>
                    <section class="content">
                        <div class="container-fluid
                        ">
                            @yield('content')
                        </div>
                    </section>
                </x-slot>
            </x-app-layout>
        </div>
    </div>
</body>
<script>
    var currentPath = document.location.pathname
    console.log('currentPath: ' + currentPath)

    var navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
        const linkPath = link.getAttribute('href');
        console.log('linkPath: ' + linkPath)

        const linkItem = link.parentElement;
        console.log('linkItem: ' + linkItem)
        if (linkPath === currentPath) {
            linkItem.classList.add('active');
        }
    })
    $('.paginate_button.current').css({
        'background-color': '#0000ff',
        'border-color': '#0000ff',
        'color': '#fff'
    });
</script>