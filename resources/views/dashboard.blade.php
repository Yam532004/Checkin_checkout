@extends ('adminLayout')
@section('title', 'STATISTICAL')

@section('content')

<div class="container mt-5">

    <div class="row mb-3" id="form-datepicker-dashboard">
        <div class="input-group" style="width:fit-content; ">
            <input data-date-format="dd/mm/yyyy" id="datepicker-dashboard" class="form-control" />
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa-solid fa-calendar-days align-content-center fs-4"></i></span>
            </div>
        </div>
    </div>

    <div class="row ">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Members</span>
                    <span class="number_account"></span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fa-solid fa-square-check"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">On time</span>
                    <span class="total_user_on_time">0</span>
                </div>

            </div>

        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-clock"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Not yet</span>
                    <span class="total_user_not_check_in">
                        0
                    </span>
                </div>

            </div>

        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Late</span>
                    <span class="total_user_late">0</span>
                </div>

            </div>

        </div>
    </div>

    <div class="row mt-5 ">
        <div class="col-md-12 col-sm-12 fs-7" style="box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
    border-radius: .25rem;">
            <div class="tab-pane m-2" id="list_checkin_late">
                <div class="table-container ">
                    <table id="list_checkin_late_table" class="display">
                        <thead>
                            <tr>
                                <th>Num</th>
                                <th>Employee</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Minutes</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-9 col-sm-12 fs-7 " style="box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
    border-radius: .25rem;">
            <div class="tab-pane m-2" id="list_checkin_late_like_month">
                <div class="table-container ">
                    <table id="list_checkin_late_like_month_table" class="display">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Employee</th>
                                <th>Quantity</th>
                                <th>Minutes</th>
                                <th>Send email</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="row">
                <div class="col-md-12" id="picker_list_checkin_late_month">
                    <div class="input-group" style="width:fit-content; ">
                        <input data-date-format="mm/yyyy" id="picker_list_checkin_late" class="form-control" />
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa-solid fa-calendar-days align-content-center fs-4"></i></span>
                        </div>
                    </div>
                </div>
                <div class=" col-md-12 mt-3">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 id="month_list">0</h3>
                            <p id="year_list">0</p>
                        </div>
                        <div class="icon">
                            <i class="fa-regular fa-calendar"></i>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        var now = new Date();
        var currentDay = now.getDate();
        var currentMonth = now.getMonth(); // Tháng trong JavaScript bắt đầu từ 0 (0 = January, 1 = February, ...)
        var currentYear = now.getFullYear();
        var currentDate = new Date(currentYear, currentMonth, currentDay);

        $('#datepicker-dashboard').datepicker({
            format: "dd/mm/yyyy",
            weekStart: 1,
            daysOfWeekHighlighted: "6,0",
            autoclose: true,
            todayHighlight: true,
            endDate: currentDate, // Đặt ngày kết thúc là ngày hiện tại
            beforeShowDay: function(date) {
                var day = date.getDay();
                var isWeekend = (day === 0 || day === 6); // Chủ nhật (0) và thứ 7 (6)
                var isAfterEndDate = date > currentDate; // Ngày sau endDate

                // Trả về mảng [isSelectable, ''] với isSelectable là false nếu ngày là ngày cuối tuần hoặc sau ngày kết thúc
                return [!(isWeekend || isAfterEndDate), ''];
            }
        }).on('changeDate', function(e) {
            if (e.date) {
                var selectedDate = new Date(e.date.getFullYear(), e.date.getMonth(), 1);
                $('#datepicker').datepicker('update', selectedDate);
                $('#datepicker').datepicker('hide');
                var date = new Date(e.date);
                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();
                $.ajax({
                    url: '/admin/users',
                    method: 'GET',
                    success: function(response) {
                        console.log("res" + response.length);
                        $('.number_account').text(response.length);
                    }
                });
                $.ajax({
                    url: '/working-times/ontime',
                    method: 'GET',
                    data: {
                        day: day,
                        month: month,
                        year: year
                    },
                    success: function(response) {
                        $('.total_user_on_time').text(response.count);
                    }
                });
                $.ajax({
                    url: '/working-times/not-yet',
                    method: 'GET',
                    data: {
                        day: day,
                        month: month,
                        year: year
                    },
                    success: function(response) {
                        $('.total_user_not_check_in').text(response.count);
                    }
                });
                $.ajax({
                    url: '/working-times/late',
                    method: 'GET',
                    data: {
                        day: day,
                        month: month,
                        year: year
                    },
                    success: function(response) {
                        $('.total_user_late').text(response.count);
                    }
                });
                if (!$.fn.dataTable.isDataTable('#list_checkin_late_table')) {
                    var list_checkin_late_table = $('#list_checkin_late_table').DataTable({
                        createdRow: function(row, data, dataIndex) {
                            $(row).attr('data-id', data.id);
                        }
                    });
                } else {
                    var list_checkin_late_table = $('#list_checkin_late_table').DataTable();
                }

                $.ajax({
                    url: '/working-times/list-checkin-late',
                    method: 'GET',
                    data: {
                        day: day,
                        month: month,
                        year: year
                    },
                    success: function(response) {
                        // Giả sử phản hồi có định dạng { list_checkin_late: [...] }
                        console.log("Response:", response.list_checkin_late);

                        list_checkin_late_table.clear().draw();
                        $.each(response.list_checkin_late, function(index, row) {
                            list_checkin_late_table.row.add([index + 1, row.name, row.date, row.time_checkin, row.minutes_late]).draw();
                        })
                    },
                    error: function(xhr) {
                        console.log("Error:", xhr.responseText);
                    }
                })
            }
        });

        $('#datepicker-dashboard').datepicker('setDate', currentDate); // Đặt ngày mặc định là ngày hiện tại
    });
</script>
<script>
    var now = new Date();
    var currentMonth = now.getMonth();
    var currentYear = now.getFullYear();

    // Hiển thị tháng hiện tại
    $('#month_list').text(currentMonth + 1); // Tháng hiện tại bắt đầu từ 0, nên cần cộng thêm 1
    $('#year_list').text(currentYear);

    $('#picker_list_checkin_late').datepicker({
        format: "mm/yyyy",
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
        minViewMode: 1,
        startView: 2,
        maxViewMode: 2,
        endDate: new Date(currentYear, currentMonth, 1),
    }).on('changeDate', function(e) {
        if (e.date) {
            var selectedDate = new Date(e.date.getFullYear(), e.date.getMonth(), 1);
            $('#picker_list_checkin_late').datepicker('update', selectedDate);
            $('#picker_list_checkin_late').datepicker('hide');
            var month = e.date.getMonth() + 1;
            var year = e.date.getFullYear();

            $.ajax({
                url: 'working-times/list-checkin-late-in-month',
                method: 'GET',
                data: {
                    month: month,
                    year: year
                },
                success: function(data) {
                    $('#month_list').text(month);
                    $('#year_list').text(year);

                    var tableBody = $('#list_checkin_late_like_month_table tbody');
                    tableBody.empty();

                    data.forEach(function(item) {
                        // Tạo hàng cho bảng
                        var userRow = '<tr>' +
                            '<td>' +
                            '<div class="icheck-primary d-inline ml-2">' +
                            '<input disabled type="checkbox" value="" name="todo1" id="todoCheck' + item.user.replace(/\s+/g, '') + ' " >' + // Đảm bảo ID là duy nhất
                            '<label for="todoCheck' + item.user.replace(/\s+/g, '') + '"></label>' + 
                            '</div>' +
                            '</td>' +
                            '<td>' + item.user + '</td>' +
                            '<td>' + item.late_count + '</td>' +
                            '<td>' + item.total_late_minutes + '</td>' +
                            '<td ><button class=""><i class="fa-solid fa-envelope fa-xl"></i></button></td>' +
                            '</tr>';

                        // Thêm hàng vào bảng
                        tableBody.append(userRow);
                    });

                    // Initialize DataTables
                    if (!$.fn.DataTable.isDataTable('#list_checkin_late_like_month_table')) {
                        $('#list_checkin_late_like_month_table').DataTable();
                    }
                }
            });
        }
    });

    // Đặt ngày mặc định là ngày hiện tại
    var currentDate = new Date(currentYear, currentMonth, 1);
    $('#picker_list_checkin_late').datepicker('setDate', currentDate);
</script>

@endsection