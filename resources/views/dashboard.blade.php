@extends ('adminLayout')
@section('title', 'STATISTICAL')

@section('content')

@if (session('message'))
<script>
toastr.success("{{session('message')}}");
</script>
@endif
<style>
#report_chart {
    width: 100% !important;
    /* Đặt chiều rộng 100% hoặc giá trị cụ thể */
    height: 400px !important;
    /* Đặt chiều cao cố định */
}
</style>
<div class="container mt-5">
    <div class="row ">
        <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Members</span>
                    <span class="number_account">0</span>
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
                <span class="info-box-icon bg-info elevation-1"><i
                        class="fa-solid fa-magnifying-glass-minus"></i></span>
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
                                        <input data-date-format="dd/mm/yyyy" id="report_follow_startDate"
                                            class="form-control" />
                                        <div class="input-group-prepend">
                                            <span class="input-group-text " style="color: #4f4f4f"><i
                                                    class="fa-solid fa-calendar-days align-content-center fs-4"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12" id="report_chart_follow_endDate">
                                    <div class="input-group">
                                        <input data-date-format="dd/mm/yyyy" id="report_follow_endDate"
                                            class="form-control" />
                                        <div class="input-group-prepend">
                                            <span class="input-group-text " style="color: #4f4f4f"><i
                                                    class="fa-solid fa-calendar-days align-content-center fs-4"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <canvas id="report_chart">

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
                                                        <input data-date-format="dd/mm/yyyy" id="datepicker-dashboard"
                                                            class="form-control" />
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" style="color: #4f4f4f"><i
                                                                    class="fa-solid fa-calendar-days align-content-center fs-4"></i></span>
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
                                        <div class="col-md-6 d-flex justify-content-center align-items-center"
                                            style="height: 100%;">
                                            <h5 style="color: #4f4f4f"><b>CHECK IN LATE IN MONTH</b></h5>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12" id="picker_list_checkin_late_month">
                                                    <div class="input-group">
                                                        <input data-date-format="mm/yyyy" id="picker_list_checkin_late"
                                                            class="form-control" />
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text " style="color: #4f4f4f"><i
                                                                    class="fa-solid fa-calendar-days align-content-center fs-4"></i></span>
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
    <div class="modal fade" id="ask_for_send_email_warning" style="display: hidden; padding-right: 17px;"
        aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" class="form-horizontal" id="form_modal_send_email">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="user_id_send_email" id="user_id_send_email">
                        <input type="hidden" name="user_name_send_email" id="user_name_send_email">
                        <input type="hidden" name="count_send_email" id="count_send_email">
                        <input type="hidden" name="minutes_send_email" id="minutes_send_email">
                        <input type="hidden" name="month_send_email" id="month_send_email">
                        <p class="text-center">Do you want to send an email for warning more than total check in?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="send_email_warning">Send</button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>
<script>
$(document).ready(function() {
    const now = new Date();
    const currentDate = new Date(now.getFullYear(), now.getMonth(), now.getDate());

    const tableSelector = '#list_checkin_late_table';

    // Hàm khởi tạo DataTable nếu chưa có
    function initializeDataTable() {
        if (!$.fn.DataTable.isDataTable(tableSelector)) {
            $(tableSelector).DataTable({
                createdRow: (row, data) => $(row).attr('data-id', data.id)
            });
        }
    }

    // Khởi tạo DataTable khi trang được tải
    initializeDataTable();

    // Hàm cập nhật dữ liệu cho DataTable
    function updateTable(data) {
        const table = $(tableSelector).DataTable();

        table.clear();
        data.forEach((row, index) => {
            table.row.add([
                `<div class="text-center">${index + 1}</div>`,
                `<div class="text-center">${row.name}</div>`,
                `<div class="text-center">${row.date}</div>`,
                `<div class="text-center">${row.time_checkin}</div>`,
                `<div class="text-center">${row.minutes_late}</div>`
            ]);
        });
        table.draw();
    }

    $('#datepicker-dashboard').datepicker({
        format: "dd/mm/yyyy",
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
        endDate: currentDate,
        beforeShowDay: date => [!(date.getDay() === 0 || date.getDay() === 6 || date > currentDate), '']
    }).on('changeDate', function(e) {
        if (!e.date) return;

        const date = new Date(e.date);
        const day = date.getDate();
        const month = date.getMonth() + 1;
        const year = date.getFullYear();

        const fetchData = (url, data) => $.ajax({
            url,
            method: 'GET',
            data
        });

        Promise.all([
                fetchData('/admin/users'),
                fetchData('working-times/ontime', {
                    day,
                    month,
                    year
                })
            ])
            .then(([usersResponse, onTimeResponse]) => {
                const userCount = usersResponse.filter(user => user.role !== 'admin').length;
                $('.number_account').text(userCount);
                $('.total_user_on_time').text(onTimeResponse.count);

                const totalUserCount = parseInt($('.number_account').text(), 10) || 0;
                const totalUserOnTime = parseInt($('.total_user_on_time').text(), 10) || 0;
                $('.total_user_not_check_in').text(totalUserCount - totalUserOnTime);
            })
            .catch(error => console.error('Có lỗi xảy ra khi lấy dữ liệu:', error));

        const additionalRequests = [
            fetchData('working-times/not-yet-checkout', {
                day,
                month,
                year
            }).then(response => $('.total_user_not_check_out').text(response.count)),
            fetchData('working-times/checkout-early', {
                day,
                month,
                year
            }).then(response => $('.total_checkout_early').text(response.count)),
            fetchData('working-times/late', {
                day,
                month,
                year
            }).then(response => $('.total_user_late').text(response.count)),
            fetchData('working-times/list-checkin-late', {
                day,
                month,
                year
            })
            .then(response => {
                updateTable(response.list_checkin_late);
            })
        ];

        Promise.all(additionalRequests);
    });

    $('#datepicker-dashboard').datepicker('setDate', currentDate);
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
    $('#ask_for_send_email_warning').modal('show')
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

<!-- Chart  -->
<script>
var chart;
var startDate; // Biến toàn cục để lưu ngày bắt đầu

// Khởi tạo ngày hiện tại
var now = new Date();
var currentDay = now.getDate();
var currentMonth = now.getMonth();
var currentYear = now.getFullYear();
var currentDate = new Date(currentYear, currentMonth, currentDay);
// Khởi tạo datepicker cho ngày bắt đầu
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
        startDate = e.date; // Lưu ngày bắt đầu
        $('#report_follow_endDate').datepicker('setStartDate',
            startDate);
        updateChart();
    }
});

// Khởi tạo datepicker cho ngày kết thúc
$('#report_follow_endDate').datepicker({
    format: "dd/mm/yyyy",
    weekStart: 1,
    daysOfWeekHighlighted: "6,0",
    autoClose: true,
    todayHighlight: true,
    endDate: currentDate,
    startDate: startDate, // Thiết lập ngày bắt đầu cho ngày kết thúc
    beforeShowDay: function(date) {
        var day = date.getDay();
        var isWeekend = (day === 0 || day === 6);
        var isBeforeStartDate = startDate && date < startDate;
        return [!(isWeekend || isBeforeStartDate), ''];
    }
}).on('changeDate', function(e) {
    if (e.date && startDate && e.date <= startDate) {
        var newDate = new Date()
        toastr.error("End date cannot be less than start date");
        $(this).datepicker('setDate', newDate);
        // alert("Ngày kết thúc không thể nhỏ hơn ngày bắt đầu.");

    } else {
        updateChart();
    }
});


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
        updateChart();
    }
});
$('#report_follow_endDate').datepicker('setDate', currentDate);

// Hàm cập nhật biểu đồ
function updateChart() {
    var startDate = $('#report_follow_startDate').datepicker('getDate');
    var endDate = $('#report_follow_endDate').datepicker('getDate');

    if (startDate && endDate) {
        var startDateStr = moment(startDate).format('YYYY-MM-DD');
        var endDateStr = moment(endDate).format('YYYY-MM-DD');

        $.ajax({
            url: '/admin/chart',
            method: 'GET',
            data: {
                startDate: startDateStr,
                endDate: endDateStr
            },
            success: function(response) {
                updateChartWithData(response);
            },
            error: function() {
                console.error('Có lỗi xảy ra khi lấy dữ liệu.');
            }
        });
    }
}

// Hàm cập nhật biểu đồ với dữ liệu
function updateChartWithData(data) {
    if (chart) {
        var labels = data.labels || [];
        var checkInData = data.checkInData || [];
        var checkOutData = data.checkOutData || [];
        // Cập nhật dữ liệu cho biểu đồ
        chart.data.labels = labels;
        chart.data.datasets[0].data = checkInData; // Dữ liệu Check In
        chart.data.datasets[1].data = checkOutData; // Dữ liệu Check Out
        // Cập nhật biểu đồ
        chart.update();
    }
}
// Hàm khởi tạo biểu đồ
function initializeChart(labels, checkInData, checkOutData) {
    var ctx = document.getElementById('report_chart').getContext('2d');
    chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels || [],
            datasets: [{
                    label: 'Check In Late',
                    data: checkInData || [],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Check Out Early',
                    data: checkOutData || [],
                    borderColor: 'rgba(153, 102, 255, 1)',
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    fill: true,
                    tension: 0.4

                }
            ]
        },
        options: {
            scales: {
                x: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Day'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Total account'
                    },
                    // Alway integer 
                    ticks: {
                        stepSize: 1,
                        callback: function(value) {
                            if (Number.isInteger(value)) {
                                return value;
                            }
                        }
                    }
                }
            }
        }
    });
}

// Khởi tạo biểu đồ khi tài liệu sẵn sàng
document.addEventListener('DOMContentLoaded', function() {
    $.ajax({
        url: '/admin/get-first-day',
        method: 'GET',
        success: function(response) {
            $('#report_follow_startDate').datepicker('setDate', new Date(response.firstDay));
        }
    });
    initializeChart(0, 0, 0);
    updateChart()
});
</script>
@endsection