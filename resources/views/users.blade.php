@extends ('adminLayout')
@section('title', '')
@section('content')
@include('create-user')
@include('edit-user')
@include('delete-user')
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

<div id="table-container">
    <table id="employeeTable" class="display">
        <h6><b>EMPLOYEES</b></h6>
        <thead>
            <tr style="border: 1px; border: radius 30px; background:#0000ff; color:#fff;">
                <th style="text-align:center">Name</th>
                <th style="text-align:center">Phone number</th>
                <th style="text-align:center">Email</th>
                <th style="text-align:center">Status</th>
                <th style="text-align:center">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>


<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#employeeTable').DataTable({
            createdRow: function(row, data, dataIndex) {
                $(row).attr('data-id', data.id);
            }
        });

        // Fetch data from the server
        $.ajax({
            type: "GET",
            url: "/admin/users",
            dataType: 'json',
            success: function(data) {
                // Clear the existing table data
                table.clear();

                // Loop through the data and add it to the table
                $.each(data, function(index, user) {
                    var userDetailUrlBase = "{{ route('user-detail', ['id' => 'PLACEHOLDER_ID']) }}";
                    table.row.add([
                        '<div class="clickable-cell" id="user-name-detail">' + user.name + '</div>',
                        '<div class="clickable-cell" id="user-phone-detail">' + user.phone_number + '</div>',
                        '<div class="clickable-cell" id="user-email-detail">' + user.email + '</div>',
                        user.role == 'admin' ? '' : '<div class="d-flex justify-content-center">' +
                        '<div class="form-check form-switch">' +
                        '<input class="form-check-input status-toggle" type="checkbox" role="switch" id="switch' + index + '" ' + (user.status == 1 ? 'checked' : '') + ' data-id="' + user.id + '">' +
                        '<label class="form-check-label" for="switch' + index + '"></label>' +
                        '</div>' +
                        '</div>',

                        '<div class="text-center d-flex justify-content-center">' +
                        '<button type="button" ' +
                        'onclick="window.location.href=\'' + userDetailUrlBase.replace('PLACEHOLDER_ID', user.id) + '\' " ' +
                        'title="Edit user" ' +
                        'class="btn btn-warning btn-lg mx-2 d-flex justify-content-center align-items-center">' +
                        '<i class="fa fa-edit fa-lg"></i>' +
                        '</button>' +
                        (user.role == 'admin' ? '' :
                            '<button type="button" ' +
                            'onclick="deleteModal(' + user.id + ', \'admin/delete-user/' + user.id + '\')" ' +
                            'title="Delete user" ' +
                            'class="btn btn-danger btn-lg d-flex justify-content-center align-items-center" ' +
                            'data-toggle="modal" ' +
                            'data-id="' + user.id + '" ' +
                            'data-target="#deleteModal">' +
                            '<i class="fa fa-trash fa-lg"></i>' +
                            '</button>') + 
                        '</div>'
                    ]).draw().node().setAttribute('data-id', user.id);
                });

            },
            error: function(xhr, status, error) {
                console.error("Error fetching data: ", status, error);
            }
        });
    });

    // edit and delete user 
    var root = "http://127.0.0.1:8000/";

    function deleteModal(e, t) {
        $('#form_modal_delete').attr('action', root + t), $('#del_modal_id').val(e), $('#deleteModal').modal('show')
    }

    function editModal(e, t, r) {
        $('#form_modal_edit').attr('action', root + r),
            $('#edit_modal_id').val(e),
            $('#editModal').modal('show')
        $.ajax({
            url: root + t,
            method: 'GET',

            dataType: 'json',
            success: function(res) {
                // Populate form fields with the response data
                $('#edit_name').val(res.name);
                $('#edit_phone_number').val(res.phone_number);
                $('#edit_email').val(res.email);
                $('#edit_password').val(''); // Assuming password is empty by default
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data: ", status, error);
            }
        })
    }
    // Toggle status of user
    $(document).on('change', '.status-toggle', function() {
        var checkbox = $(this)
        var userId = checkbox.data('id');
        var newStatus = checkbox.is(':checked') ? 1 : 0; // 1 is active status, 0 is unactive status

        $.ajax({
            url: '/admin/update-user-status',
            method: 'POST',
            data: {
                id: userId,
                status: newStatus,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.success, 'Success', {
                        timeOut: 1000
                    }); // Hiển thị thông báo thành công trong 5 giây
                    console.log("Success: " + response.success);
                } else if (response.errors) {
                    toastr.error(response.errors, "Error", {
                        timeOut: 1000
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Error updating status: ", status, error);
            }
        })

    })
</script>
@endsection