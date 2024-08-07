@extends ('adminLayout')
@section('title', 'STATISTICAL')

@section('content')

@if (session('message'))
<script>
    toastr.success("{{session('message')}}");
</script>
@endif
<div class="container mt-5">
    <div class="row ">
        <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Members</span>
                    <span class="number_account"></span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fa-solid fa-square-check"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Checked in</span>
                    <span class="total_user_on_time">0</span>
                </div>

            </div>

        </div>

        <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fa-regular fa-calendar-xmark"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Check in Late</span>
                    <span class="total_user_late">0</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-magnifying-glass-minus"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Not Check in</span>
                    <span class="total_user_not_check_in">
                        0
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-pink elevation-1"><i class="fa-solid fa-hourglass"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Ealry Check out</span>
                    <span class="total_checkout_early">0</span>
                </div>

            </div>

        </div>

        <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-secondary elevation-1"><i class="git fa-solid fa-clock"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Not Check out</span>
                    <span class="total_user_not_check_out">0</span>
                </div>

            </div>

        </div>
    </div>
    <div class="row mt-5 ">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="mb-3 p-3" style="background: #e2e8f0; width:100%">
                    <div class="row">
                        <div class="col-md-4 d-flex justify-content-center align-items-center" style="height: 100%;">
                            <h5 style="color: #4f4f4f"><b>REPORT</b></h5>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12" id="report_chart_follow_startDate">
                                    <div class="input-group">
                                        <input data-date-format="dd/mm/yyyy" id="report_follow_startDate" class="form-control" />
                                        <div class="input-group-prepend">
                                            <span class="input-group-text " style="color: #0000ff"><i class="fa-solid fa-calendar-days align-content-center fs-4"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12" id="report_chart_follow_endDate">
                                    <div class="input-group">
                                        <input data-date-format="dd/mm/yyyy" id="report_follow_endDate" class="form-control" />
                                        <div class="input-group-prepend">
                                            <span class="input-group-text " style="color: #0000ff"><i class="fa-solid fa-calendar-days align-content-center fs-4"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <canvas id="report_chart" width="400" height="20">

        </canvas>
    </div>

    <div class="row mt-5 ">
        <div class="col-md-12 col-sm-12 fs-7" style="box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
    border-radius: .25rem;">
            <div class="tab-pane m-2" id="list_checkin_late">
                <div class="table-container ">
                    <table id="list_checkin_late_table" class="display">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class=" mb-3 p-3" style="background:#e2e8f0; width:100%">
                                    <div class="row">
                                        <div class="col-md-6 d-flex justify-content-center align-items-center">
                                            <h5 style="color: #4f4f4f"><b>CHECK LATE IN DAY</b></h5>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12" id="form-datepicker-dashboard">
                                                    <div class="input-group">
                                                        <input data-date-format="dd/mm/yyyy" id="datepicker-dashboard" class="form-control" />
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" style="color: #0000ff"><i class="fa-solid fa-calendar-days align-content-center fs-4"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <thead style="border: 1px; border: radius 30px; background:#0000ff; color:#fff;">
                            <tr>
                                <th style="text-align:center">Num</th>
                                <th style="text-align:center">Employee</th>
                                <th style="text-align:center">Date</th>
                                <th style="text-align:center">Time</th>
                                <th style="text-align:center">Minutes late</th>
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
        <div class="col-md-12 col-sm-12 fs-7 " style="box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
    border-radius: .25rem;">
            <div class="tab-pane m-2" id="list_checkin_late_like_month">
                <div class="table-container ">
                    <table id="list_checkin_late_like_month_table" class="display">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="mb-3 p-3" style="background: #e2e8f0; width:100%">
                                    <div class="row">
                                        <div class="col-md-6 d-flex justify-content-center align-items-center" style="height: 100%;">
                                            <h5 style="color: #4f4f4f"><b>CHECK IN LATE IN MONTH</b></h5>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12" id="picker_list_checkin_late_month">
                                                    <div class="input-group">
                                                        <input data-date-format="mm/yyyy" id="picker_list_checkin_late" class="form-control" />
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text " style="color: #0000ff"><i class="fa-solid fa-calendar-days align-content-center fs-4"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <thead style="border: 1px; border: radius 30px; background:#0000ff; color:#fff;">
                            <tr>
                                <th style="text-align:center">Employee</th>
                                <th style="text-align:center">Total checkin late</th>
                                <th style="text-align:center">Total sent email</th>
                                <th style="text-align:center">Minutes late</th>
                                <th style="text-align:center">Send email</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ask_for_send_email_warning" style="display: hidden; padding-right: 17px;" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" class="form-horizontal" id="form_modal_send_email">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="user_id_send_email" id="user_id_send_email">
                        <input type="hidden" name="user_name_send_email" id="user_name_send_email">
                        <input type="hidden" name="count_send_email" id="count_send_email">
                        <input type="hidden" name="minutes_send_email" id="minutes_send_email">
                        <input type="hidden" name="month_send_email" id="month_send_email">
                        <p class="text-center">Do you want to send an email for wanring more than total check in? </p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn" id="send_email_warning " style="background-color:#0000ff; color:#fff">Send</button>
                    </div>
                </form>
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
                        var count = 0
                        response.forEach(user => {
                            if (user.role != 'admin') {
                                count++;
                            }
                        });
                        $('.number_account').text(count);
                    }
                });
                $.ajax({
                    url: 'working-times/ontime',
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
                    url: 'working-times/not-yet-checkin',
                    method: 'GET',
                    data: {
                        day: day,
                        month: month,
                        year: year
                    },
                    success: function(response) {
                        console.log("not-yet-checkin.count : " + response.count);
                        $('.total_user_not_check_in').text(response.count);
                    }
                });
                $.ajax({
                    url: 'working-times/not-yet-checkout',
                    method: 'GET',
                    data: {
                        day: day,
                        month: month,
                        year: year
                    },
                    success: function(response) {
                        console.log("not-yet-checkout.count : " + response.count);
                        $('.total_user_not_check_out').text(response.count);
                    }
                });
                $.ajax({
                    url: 'working-times/checkout-early',
                    method: 'GET',
                    data: {
                        day: day,
                        month: month,
                        year: year
                    },
                    success: function(response) {
                        console.log("response.count : " + response.count);
                        $('.total_checkout_early').text(response.count)
                    }
                })
                $.ajax({
                    url: 'working-times/late',
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
                    url: 'working-times/list-checkin-late',
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
                            list_checkin_late_table.row.add([
                                '<div class="text-center">' + (index + 1) +
                                '</div>',
                                '<div class="text-center">' + row.name +
                                '</div>',
                                '<div class="text-center">' + row.date +
                                '</div>',
                                '<div class="text-center">' + row.time_checkin +
                                '</div>',
                                '<div class="text-center">' + row.minutes_late +
                                '</div>'
                            ]).draw();
                        });

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
    var currentDay = now.getDay()
    var currentMonth = now.getMonth()
    var currentYear = now.getFullYear();
    var currentDate = new Date(currentYear, currentMonth, currentDay);
    $('#day').text(currentDay)
    $('#month').text(currentMonth + 1)
    $('#year').text(currentYear);

    $('#report_follow_startDate').datepicker({
        format: "dd/mm/yyyy",
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoClose: true,
        todayHighlight: true,
        endDate: currentDate,
        beforeShowDay: function(date) {
            var day = date.getDay();
            var isWeekend = (day === 0 || day === 6);
            var isAfterEndDate = date > currentDate;
            return [!(isWeekend || isAfterEndDate), ''];
        }
    }).on('changeDate', function(e) {
        if (e.date) {
            updateChart();
        }
    })
    $('#report_follow_endDate').datepicker({
        format: "dd/mm/yyyy",
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoClose: true,
        todayHighlight: true,
        endDate: currentDate,
        beforeShowDay: function(date) {
            var day = date.getDay();
            var isWeekend = (day === 0 || day === 6);
            var isAfterEndDate = date > currentDate;
            return [!(isWeekend || isAfterEndDate), ''];
        }
    }).on('changeDate', function(e) {
        if (e.date) {
            updateChart()
        }
    })

    function updateChart() {
        var startDate = $('#report_follow_startDate').datepicker('getDate')
        var endDate = $('#report_follow_endDate').datepicker('getDate')

        if (startDate && endDate) {
            var startDateStr = moment(startDate).format('dd/mm/yyyy')
            var endDateStr = moment(endDate).format('dd/mm/yyyy')

            $.ajax({
                url: '/admin/char',
                method: 'GET',
                data: {
                    startDate: startDateStr,
                    endDate: endDateStr
                },
                success: function(response) {
                    updateChartWithData(response.data);
                },
                error: function() {
                    console.log('Error retrieving chart data');
                }

            })
        }
    }

    function updateChartWithData(data) {
        if (chart) {
            var labels = data.labels;
            var checkInData = labels.map(function(date) {
                return data.checkInDate[date] || 0;
            })
            var checkOutData = labels.map(function(date) {
                return data.checkOutDate[date] || 0;
            })

            chart.data.labels = labels;
            chart.data.datasets = [{
                    label: 'Check In Đúng Giờ',
                    data: checkInData,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Check Out Trễ Giờ',
                    data: checkOutData,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ];
            // Cập nhật biểu đồ
            chart.update();
        }
    }

    var chart;

    function initializeChart() {
        var ctx = document.getElementById('report_chart').getContext('2d');
        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                        label: "Check in on time",
                        data: [],
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: "Check in late",
                        data: [],
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }

        })
    }

    $(document).ready(function() {
        initializeChart();
    })
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
        startView: 1,
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
                            '<td class="text-center">' + item.user + '</td>' +
                            '<td class="text-center">' + item.late_count + '</td>' +
                            '<td class="text-center">' + item.quantity_send_email + '</td>' +
                            '<td class="text-center">' + item.total_late_minutes + '</td>' +
                            '<td class="text-center">' +
                            '<button id="btn_send_email" onclick="send_email_modal(' + item
                            .user_id + ', \'' + item.user + '\', ' + item.late_count + ', ' +
                            item.total_late_minutes + ', \'' + month +
                            '\', \'admin/send-email\')" data-toggle="modal" data-target="#ask_for_send_email_warning" style="color:#E4A11B">' +
                            '<i class="fa-solid fa-envelope fa-xl"></i>' +
                            '</button>' +
                            '</td>' +
                            '</tr>';

                        // Add the row to the table
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
<script>
    // Dua vao day de gui theo thang 
    var root = "http://127.0.0.1:8000/";

    function send_email_modal(id, user_name, count, minutes, month, t) {
        $('#form_modal_send_email').attr('action', root + t),
            $('#user_id_send_email').val(id),
            console.log("id ni: " + $('#user_id_send_email').val())
        $('#user_name_send_email').val(user_name),
            $('#count_send_email').val(count),
            $('#minutes_send_email').val(minutes),
            $('#month_send_email').val(month)
        console.log("month: " + $('#month_send_email').val())
        // $('#ask_for_send_email_warning').modal('show')
    }
    $('#send_email_warning').on('submit', function(event) {
        console.log("send button")
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
    })
</script>


@endsection