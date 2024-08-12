@include('layouts.header')
@extends ('adminLayout')
@section('title', '')
@section('content')
<div class="relative overflow-hidden bg-cover bg-center text-center text-white"
    style="background-image: url('https://img.freepik.com/free-photo/flat-lay-workstation-with-copy-space-laptop_23-2148430879.jpg');">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative z-10 p-5">
        <h1 class="font-bold mb-3 animate-pulse font-autumn" style="font-size: 30px;">
            <b>{{ __('WELCOME TO CHECK TIMES SYSTEM') }}</b>
        </h1>
        <p>__Time now__</p>
        <p id="day_now"></p>
        <h1 id="time_now"></h1>
        <p id="information"></p>
    </div>
</div>
<div class="relative overflow-hidden bg-cover bg-center text-center text-white"
    style="height: 400px;background-image: url('https://media.istockphoto.com/id/1534543100/photo/autumn-inspired-office-theme-top-view-of-laptop-steaming-mug-of-pumpkin-spice-latte-stylish.webp?b=1&s=170667a&w=0&k=20&c=5GHsCKL5vjlZeN-snMQytscvAByU_J6QoXnbE4Xeeuc=');">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative z-10 flex justify-center space-x-4 mt-10 pt-20">
        <button id="check-in-btn" type="button" class="btn btn-success btn-custom m-3"><b>CHECK-IN</b></button>
        <button id="check-out-btn" type="button" class="btn btn-primary btn-custom m-3"
            style="display: none;"><b>CHECK-OUT</b></button>
    </div>
</div>
<script>
$(document).ready(function() {
    setInterval(myTimer, 1000);

    function myTimer() {
        const d = new Date();
        document.getElementById("time_now").innerHTML = d.toLocaleTimeString();
        document.getElementById("day_now").innerHTML = d.toLocaleDateString();
    }
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-custom-position", // Tùy chọn class tùy chỉnh
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "500",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        "onShown": function() {
            // Định vị toastr sau khi nó xuất hiện
            var toastrElement = document.querySelector('.toast-custom-position');
            var timeNowElement = document.getElementById('time_now');
            var rect = timeNowElement.getBoundingClientRect();

            toastrElement.style.position = 'absolute';
            toastrElement.style.top = (rect.top + (rect.height / 2) - (toastrElement.offsetHeight /
                2)) + 'px';
            toastrElement.style.left = (rect.left + (rect.width / 2) - (toastrElement.offsetWidth /
                2)) + 'px';
        }
    };
    $.ajax({
        url: '{{ route("check_status") }}',
        method: 'GET',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {

            console.log("check_status: " + response.status); // Để kiểm tra thông báo từ server
            switch (response.status) {
                case 'user_created_at':
                    $('#information').html(`
                    ${response.message}
                `)
                    $('#check-in-btn').hide();
                    $('#check-out-btn').hide();
                    break;
                case 'checked_in':
                    $('#information').html(`
                     ${response.message}
                    <br>Day: ${response.day}
                    <br>Time: ${response.time}
                    <br>Status: ${response.status_check_in}
                `);
                    $('#check-in-btn').hide();
                    $('#check-out-btn').show();
                    break;
                case 'checked_out':
                    $('#information').html(`
                     ${response.message}
                    <br>Day: ${response.day}
                    <br>Time: ${response.time}
                    <br>Status: ${response.status_check_in}
                `);
                    $('#check-in-btn').show();
                    $('#check-out-btn').hide();
                    break;
                case 'not_working':
                    $('#information').html(`
                     ${response.message}`)
                    $('#check-in-btn').show();
                    $('#check-out-btn').hide();
                    break;

            }
        },
        error: function(xhr, status, error) {
            console.log("Lỗi check_status: " + xhr.responseText);
        }
    });

    $('#check-in-btn').click(function() {
        $.ajax({
            type: "POST",
            url: '{{ route("checkin") }}',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("Status when check in: " + response.status);

                $('#information').html(`
                                                    $ {
                                                        response.message
                                                    } <
                                                    br > Day: $ {
                                                        response.day
                                                    } <
                                                    br > Time: $ {
                                                        response.time
                                                    } <
                                                    br > Status: $ {
                                                        response.status_check_in
                                                    }
                                                    `);
                if (response.status == 'success') {
                    toastr.success(
                        response.message + '<br>' +
                        'Day: ' + response.day + '<br>' +
                        'Time: ' + response.time + '<br>' +
                        'Status: ' + response.status_check_in
                    );

                    $('#check-in-btn').hide();
                    $('#check-out-btn').show();
                } else {
                    toastr.error(response.message); // Hiển thị thông báo lỗi từ server
                    $('#information').html(`
                                                    `);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error); // Log mọi lỗi liên quan đến AJAX
                toastr.error('An error occurred during check-in.');
            }
        });
    })




    $('#check-out-btn').click(function() {
        $.ajax({
            url: '{{ route("checkout") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                if (response.status === 'success') {
                    $('#information').html(`
                                                    $ {
                                                        response.message
                                                    } <
                                                    br > Day: $ {
                                                        response.day
                                                    } <
                                                    br > Time: $ {
                                                        response.time
                                                    } <
                                                    br > Status: $ {
                                                        response.status_check_out
                                                    }
                                                    `);
                    toastr.success(
                        response.message + '<br>' +
                        'Day: ' + response.day + '<br>' +
                        'Time: ' + response.time + '<br>' +
                        'Status: ' + response.status_check_out
                    );
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
                console.log("Lịch sử: " + response); // Xử lý phản hồi từ máy chủ
            },
            error: function(xhr) {
                alert('Có lỗi xảy ra!');
            }
        });
    });
});
</script>
@endsection