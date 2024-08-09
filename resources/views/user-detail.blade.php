@extends ('adminLayout')
@section('title', '')
@section('content')
<div class="container d-flex align-items-stretch" style="
display:flex; align-items: stretch">
    @include('user-sidebar')
    <div class="col-md-9">
        <div class="card h-100">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item "><a class="nav-link active" href="#infor_user" data-bs-toggle="tab"><b>INFOR</b></a></li>
                    <li class="nav-item-datapicker "><a class="nav-link" href="#absent" data-bs-toggle="tab"><b>ABSENT
                                CHECKIN</b>
                        </a></li>
                    <li class="nav-item-datapicker "><a class="nav-link" href="#checkin_late" data-bs-toggle="tab"><b>CHECKIN LATE</b></a></li>
                    <li class="nav-item-datapicker "><a class="nav-link" href="#checkout_early" data-bs-toggle="tab"><b>CHECKOUT EARLY</b></a></li>
                </ul>
            </div>

            <div class="row" id="row_title">
                <div class="col-md-6 text-center">
                    <h6><b id="title_table_btn"></b></h6>
                </div>

                <div class="col-md-6" id="form-datepicker" style="display:none">
                    <div class="input-group">
                        <input data-date-format="mm/yyyy" id="datepicker" class="form-control" />
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa-solid fa-calendar-days align-content-center fs-4"></i></span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="infor_user">
                        <form class="form-horizontal" id="user-form" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="user-name" class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="user-name" placeholder="Name" name="name_edit">
                                    <label style="float: left; font-size:12px; color: red;" id="name_edit-error" class="error"></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="user-email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="user-email" placeholder="Email" name="email_edit">
                                    <label style="float: left; font-size:12px; color: red;" id="email_edit-error" class="error"></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="user-phone-number" class="col-sm-3 col-form-label">Phone number</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="user-phone-number" placeholder="Phone number" name="phone_number_edit">
                                    <label style="float: left; font-size:12px; color: red;" id="phone_number_edit-error" class="error"></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="user-password" class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="user-password" placeholder="Password" name="password_edit">
                                    <label style="float: left; font-size:12px; color: red;" id="password_edit-error" class="error"></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-10 col-sm-2">
                                    <button type="submit" class="btn btn-danger">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @include('absent')
                    @include('checkin-late')
                    @include('checkout-early')
                </div>

            </div>
        </div>
    </div>
</div>


<script>
    $('.nav-item-datapicker a').on('click', function() {
        var tabText = $(this).text().trim();
        $('#title_table_btn').text(tabText);
        $('#row_title').css('background-color', '#e2eaf7').addClass('m-3 p-3');
    })
    $('.nav-item a').on('click', function() {
        $('#title_table_btn').text("");
        $('#row_title').removeClass('m-3 p-3');
        $('#row_title').css('background-color', '')
    })
    // $(document).ready(function() {
    $('.nav-item-datapicker').on('click', function() {
        $('#form-datepicker').show();
    });

    $('.nav-item').on('click', function() {
        $('#form-datepicker').hide();
    });

    var currentURL = window.location.href;
    var url = new URL(currentURL)
    var id = url.searchParams.get('id');
    console.log('id: ' + id)
    if (id) {
        $('#table-container').hide();
        $('#create-button').hide();
        $('#user-detail').show();

        $.ajax({
            type: "GET",
            url: "/user/id=" + id,
            dataType: 'json',
            success: function(user) {
                if (user.role == 'admin') {
                    $('.nav-item-datapicker').hide();
                }
                // Hiển thị thông tin người dùng
                $('#user-name').val(user.name);
                $('#user-name-avt').text(user.name);
                $('#user-phone-number').val(user.phone_number);
                $('#user-email').val(user.email);
                $('#user-status').val((user.status == 1 ? 'Active' : 'Inactive'));

                $('#user-name').on('blur', function() {
                    if ($(this).val().trim() === '') {
                        $('#name_edit-error').text('Name is required.');
                    } else {
                        $('#name_edit-error').text(''); // Xóa lỗi nếu có dữ liệu
                    }
                });

                $('#user-email').on('blur', function() {
                    if ($(this).val().trim() === '') {
                        $('#email_edit-error').text('Email is required.');
                    } else {
                        $('#email_edit-error').text(''); // Xóa lỗi nếu có dữ liệu
                    }
                });

                $('#user-phone-number').on('blur', function() {
                    if ($(this).val().trim() === '') {
                        $('#phone_number_edit-error').text('Phone number is required.');
                    } else {
                        $('#phone_number_edit-error').text(''); // Xóa lỗi nếu có dữ liệu
                    }
                });

                // Kiểm tra lỗi và gửi form
                $("#user-form").on('submit', function(event) {
                    event.preventDefault(); // Ngăn không cho gửi form ngay lập tức

                    var hasError = false;

                    // Kiểm tra lỗi
                    if ($('#user-name').val().trim() === '') {
                        $('#name_edit-error').text('Name is required.');
                        hasError = true;
                    }

                    if ($('#user-email').val().trim() === '') {
                        $('#email_edit-error').text('Email is required.');
                        hasError = true;
                    }

                    if ($('#user-phone-number').val().trim() === '') {
                        $('#phone_number_edit-error').text('Phone number is required.');
                        hasError = true;
                    }

                    // Nếu có lỗi, dừng việc gửi form
                    if (hasError) {
                        return; // Dừng lại nếu có lỗi
                    }

                    // Nếu không có lỗi, gửi form
                    var formData = $(this).serialize();
                    $.ajax({
                        type: "PUT",
                        url: "/edit-user/" + user.id,
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content') // Thêm CSRF token vào tiêu đề
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.success, 'Success', {
                                    timeOut: 1500
                                }); // Hiển thị thông báo thành công trong 1 giây
                                $('#user-name-avt').html(response.user.name);

                                console.log("Success: " + response.success);
                                $('#name_edit-error').text('');
                                $('#email_edit-error').text('');
                                $('#email_edit-error').text('');
                                $('#phone_number_edit-error').text('');

                            } else if (response.errors) {
                                toastr.error(response.errors, "Error", {
                                    timeOut: 1000
                                });
                            }
                            $('#create-user').modal('hide');
                        },
                        error: function(xhr) {
                            console.log('Error response:', xhr
                                .responseJSON); // Log the error response for debugging

                            // Check if the response contains errors
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                var errors = xhr.responseJSON.errors;

                                // Clear previous errors
                                $('.error').text('');

                                // Display new errors
                                $.each(errors, function(key, value) {
                                    console.log('Error for field:', key, 'Message:',
                                        value[0]); // Log each error for debugging
                                    $('#' + key + '-error').text(value[
                                        0]); // Show error message
                                });
                            } else {
                                console.log('Unexpected error format:', xhr.responseText);
                            }
                        }
                    });
                });
            },
            error: function(xhr, status, error) {
                console.error("Error fetching user detail: ", status, error);
            }
        });

        var now = new Date();
        var currentMonth = now.getMonth();
        var currentYear = now.getFullYear();

        if (!$.fn.dataTable.isDataTable('#absentTable')) {
            var table_absent = $('#absentTable').DataTable({
                createRow: function(row, data, dataIndex) {
                    $(row).attr('data-id', date.id);
                }
            });
        } else {
            var table_absent = $('#absentTable').DataTable();
        }

        if (!$.fn.dataTable.isDataTable('#checkinLateTable')) {
            var table_checkin_late = $('#checkinLateTable').DataTable({
                createRow: function(row, data, dataIndex) {
                    $(row).attr('data-id', date.id);
                }
            });
        } else {
            var table_checkin_late = $('#checkinLateTable').DataTable();
        }

        if (!$.fn.dataTable.isDataTable('#checkoutEarlyTable')) {
            var table_checkout_early = $('#checkoutEarlyTable').DataTable({
                createRow: function(row, data, dataIndex) {
                    $(row).attr('data-id', date.id);
                }
            });
        } else {
            var table_checkout_early = $('#checkoutEarlyTable').DataTable();
        }

        $('#datepicker').datepicker({
            format: "mm/yyyy",
            weekStart: 1,
            daysOfWeekHighlighted: "6,0",
            autoclose: true,
            todayHighlight: true,
            minViewMode: 1,
            startView: 1,
            maxViewMode: 2,
            endDate: new Date(currentYear, currentMonth, 1),
        }).on('changeDate', function(e) {
            console.log(e);
            if (e.date) {
                var selectedDate = new Date(e.date.getFullYear(), e.date.getMonth(), 1);
                $('#datepicker').datepicker('update', selectedDate);
                $('#datepicker').datepicker('hide');
                var date = new Date(e.date);
                var month = date.getMonth() + 1;
                var year = date.getFullYear();

                $.ajax({
                    type: "GET",
                    url: "/report",
                    data: {
                        id: id,
                        month: month,
                        year: year
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log("Dữ liệu nhận được: ", response);
                        if (response.user_role == 'admin') {
                            $('.list-group').hide();
                        }
                        var report = response.report;
                        var absentDays = response.absent_days;
                        var lateCheckIns = response.late_check_ins;
                        var earlyCheckOuts = response.early_check_outs;

                        table_absent.clear().draw();
                        table_checkin_late.clear().draw();
                        table_checkout_early.clear().draw();

                        var absent_total = 0;
                        var checkin_late_total = 0;
                        var checkout_early_total = 0;
                        var serialNumber = 1;
                        $.each(absentDays, function(index, date) {
                            table_absent.row.add([
                                serialNumber,
                                date
                            ]).draw();
                            serialNumber++;
                            absent_total++;
                        });
                        $('#absent_total').text(absent_total);

                        // Cập nhật bảng check-in trễ
                        $.each(lateCheckIns, function(index, row) {
                            var timeCheckin = row.time_checkin ? row.time_checkin.split(
                                ' ')[1].split(':').slice(0, 3).join(':') : '';
                            table_checkin_late.row.add([
                                index + 1,
                                row.date,
                                timeCheckin
                            ]).draw();
                            checkin_late_total++;
                        });
                        $('#checkin_late_total').text(checkin_late_total);

                        // Cập nhật bảng check-out sớm
                        $.each(earlyCheckOuts, function(index, row) {
                            var timeCheckout = row.time_checkout ? row.time_checkout
                                .split(' ')[1].split(':').slice(0, 3).join(':') : '';
                            table_checkout_early.row.add([
                                index + 1,
                                row.date,
                                timeCheckout
                            ]).draw();
                            checkout_early_total++;
                        });
                        $('#checkout_early_total').text(checkout_early_total);
                    }
                });
            }
        });

        var currentDate = new Date(currentYear, currentMonth, 1);
        console.log("Setting Date: ", currentDate);
        $('#datepicker').datepicker('setDate', currentDate);
    }
</script>
@endsection