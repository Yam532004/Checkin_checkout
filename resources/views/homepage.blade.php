@include('layouts.header')

<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden bg-cover bg-center text-center text-white" style="background-image: url('https://img.freepik.com/free-photo/flat-lay-workstation-with-copy-space-laptop_23-2148430879.jpg');">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="relative z-10 p-5">
                <h1 class="font-bold mb-5 animate-pulse font-autumn" style="font-size: 30px;">
                    <b>{{ __('WELCOME TO CHECK TIMES SYSTEM') }}</b>
                </h1>
            </div>
        </div>
    </x-slot>

    <!-- Default slot for main content -->
    <div class="relative overflow-hidden bg-cover bg-center text-center text-white" style="height: 500px;background-image: url('https://media.istockphoto.com/id/1534543100/photo/autumn-inspired-office-theme-top-view-of-laptop-steaming-mug-of-pumpkin-spice-latte-stylish.webp?b=1&s=170667a&w=0&k=20&c=5GHsCKL5vjlZeN-snMQytscvAByU_J6QoXnbE4Xeeuc=');">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative z-10 flex justify-center space-x-4 mt-10 pt-24">
            <button id="check-in-btn" type="button" class="btn btn-success btn-custom m-3"><b>CHECK-IN</b></button>
            <button id="check-out-btn" type="button" class="btn btn-primary btn-custom m-3" style="display: none;"><b>CHECK-OUT</b></button>
            <button id="story-checkin-btn" type="button" class="btn btn-warning btn-custom m-3" onclick="window.location.href = '{{ route('profile.show')}}'"><b>STORY CHECKIN</b></button>

        </div>
    </div>
</x-app-layout>
<script>
    $(document).ready(function() {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        $.ajax({
            url: '{{ route("check_status") }}',
            method: 'GET',
            success: function(response) {
                console.log(response.message); // Để kiểm tra thông báo từ server
                switch (response.status) {
                    case 'checked_in':
                        $('#check-in-btn').hide();
                        $('#check-out-btn').show();
                        $('#story-checkin-btn').show();
                        break;
                    case 'checked_out':
                        $('#check-in-btn').show();
                        $('#check-out-btn').hide();
                        $('#story-checkin-btn').show();
                        break;
                    case 'not_working':
                        $('#check-in-btn').show();
                        $('#check-out-btn').hide();
                        $('#story-checkin-btn').show();
                        break;
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });

        $('#check-in-btn').click(function() {
            $.ajax({
                url: '{{ route("checkin") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.status === 'success') {
                        toastr.success(response.message)
                        $('#check-in-btn').hide();
                        $('#check-out-btn').show();
                    } else {
                        toastr.error(response.message); // Hiển thị thông báo lỗi từ server
                    }
                },
                error: function(xhr) {
                    alert('Có lỗi xảy ra!');
                }
            });
        });

        $('#check-out-btn').click(function() {
            $.ajax({
                url: '{{ route("checkout") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.status === 'success') {
                        toastr.success(response.message)
                        $('#check-out-btn').hide();
                        $('#check-in-btn').show();
                    } else {
                        toastr.error(response.message) // Hiển thị thông báo lỗi từ server
                    }
                },
                error: function(xhr) {
                    alert('Có lỗi xảy ra!');
                }
            });
        });

        $('#story-checkin-btn').click(function() {
            $.ajax({
                url: '{{ route("report") }}',
                method: 'GET',
                success: function(response) {
                    console.log(response); // Xử lý phản hồi từ máy chủ
                },
                error: function(xhr) {
                    alert('Có lỗi xảy ra!');
                }
            });
        });
    });
</script>