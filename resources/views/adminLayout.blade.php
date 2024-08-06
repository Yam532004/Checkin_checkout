<style>
.dataTables_length select {
    border: 1px solid #808080;
}

/* CSS cho trường input */
.dataTables_filter input[type="search"] {
    border: 1px solid #808080;
    /* Đặt màu và độ dày của border */
    border-radius: 4px;
    /* Tạo góc bo tròn cho border nếu cần */
    padding: 5px;
    /* Thêm khoảng cách bên trong trường input */
}

/* CSS cho khi trường input được focus */
.dataTables_filter input[type="search"]:focus {
    border-color: #808080;
    /* Thay đổi màu border khi trường input được focus */
    outline: none;
    /* Loại bỏ outline mặc định khi trường input được focus */
}

.dataTables_length label,
.dataTables_filter label {
    color: #808080;
}

/* CSS cho phần tử select */
.dataTables_length select {
    width: 70px;
    border: 1px solid #808080;
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
    border-color: #808080;
    /* Thay đổi màu border khi phần tử select được focus */
    outline: none;
    /* Loại bỏ outline mặc định khi phần tử select được focus */
    box-shadow: 0 0 0 1px #808080;
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

.full-height {
    height: auto;
    overflow: auto;
    /* Đảm bảo phần tử có thể cuộn nếu cần */
}
</style>
@include('layouts.header')

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4 " id="aside">

            <div
                class=" sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition">
                <div class="os-padding ">
                    <p href="#" class="brand-link">
                        <img src="https://as2.ftcdn.net/v2/jpg/03/14/20/15/1000_F_314201503_drLthBSHdqSBwBOGo8AHreHIGnfLEUJi.jpg"
                            class="brand-image img-circle elevation-3" style="opacity: .8">
                        <span class="brand-text font-weight-light">Check times</span>
                    </p>

                    <nav class="mt-2">

                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            @if (Auth::user()->role == 'user')
                            <li class="nav-item">
                                <a href={{route('homepage')}} class="nav-link">
                                    <i class="nav-icon fas fa-home"></i>
                                    <p>
                                        Check in
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href={{route('profile.show', ['id' => Auth::user()->id])}} class="nav-link">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>
                                        Story
                                    </p>
                                </a>
                            </li>
                            @elseif (Auth::user()->role == 'admin')
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
        <div class="content-wrapper">
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
window.onload = function() {
    var aside = document.getElementById('aside');
    var content_aside = document.getElementById('content_aside');

    if (aside && content_aside) {
        console.log('Content aside height: ' + content_aside.offsetHeight);
        aside.style.height = content_aside.offsetHeight + 'px';
        console.log('Aside height set to: ' + aside.style.height);
    } else {
        if (!aside) console.log('Element with id "aside" not found');
        if (!content_aside) console.log('Element with id "content_aside" not found');
    }
}
</script>