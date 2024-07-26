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
</style>
<div class="tab-pane" id="checkout_early">
    <div id="table-container">
        <table id="checkoutEarlyTable" class="display">
            <thead>
                <tr>
                    <th>Num</th>
                    <th>Date</th>
                    <th>Time checked out</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        var table = $('#checkoutEarlyTable').DataTable({
            createRow: function(row, data, dataIndex) {
                $(row).attr('data-id', date.id)
            }
        });

        $.ajax({
            type: "GET",
            url: "/report",
            dataType: 'json',
            success: function(data) {
                var absentData = data.filter(function(item) {
                    return item.status.includes('Early')
                });
                var checkin_late_total = 0;
                $.each(absentData, function(index, row) {
                    timeCheckout =  row.time_checkout.split(' ')[1].split(':').slice(0, 3).join(':');
                    table.row.add([
                        index + 1, 
                        row.date,
                        timeCheckout
                    ]).draw(); // Vẽ bảng lại với dữ liệu mới
                    checkin_late_total++
                    
                });
                document.getElementById('checkin_late_total').innerHTML = checkin_late_total
            }
        })
    })
</script>