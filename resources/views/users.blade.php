@extends ('adminLayout')
@section('title', 'Employees')
@section('content')
@include('create-user')
@include('edit-user')
@include('delete-user')
<style>
    /* CSS cho trường input */
.dataTables_filter input[type="search"] {
    border: 1px solid #000; /* Đặt màu và độ dày của border */
    border-radius: 4px; /* Tạo góc bo tròn cho border nếu cần */
    padding: 5px; /* Thêm khoảng cách bên trong trường input */
}

/* CSS cho khi trường input được focus */
.dataTables_filter input[type="search"]:focus {
    border-color: #007bff; /* Thay đổi màu border khi trường input được focus */
    outline: none; /* Loại bỏ outline mặc định khi trường input được focus */
}
/* CSS cho phần tử select */
.dataTables_length select {
    width: 70px;
    border: 1px solid #000; /* Đặt màu và độ dày của border */
    border-radius: 4px; /* Tạo góc bo tròn cho border */
    padding: 5px; /* Thêm khoảng cách bên trong phần tử select */
    background-color: #fff; /* Màu nền cho phần tử select */
    font-size: 16px; /* Kích thước font chữ */
}

/* CSS cho khi phần tử select được focus */
.dataTables_length select:focus {
    border-color: #007bff; /* Thay đổi màu border khi phần tử select được focus */
    outline: none; /* Loại bỏ outline mặc định khi phần tử select được focus */
    box-shadow: 0 0 0 1px #007bff; /* Thêm hiệu ứng bóng khi phần tử select được focus */
}

</style>

<table id="employeeTable" class="display">
    <thead>
        <tr>
            <th>Name</th>
            <th>Phone number</th>
            <th>Email</th>
            <th class="d-flex justify-center">Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>


<script>
    $(document).ready(function() {

        // Initialize DataTable
        var table = $('#employeeTable').DataTable();

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
                    table.row.add([
                        user.name, // Assuming the User model has 'name' field
                        user.phone_number, // Assuming the User model has 'phone_number' field
                        user.email, // Assuming the User model has 'email' field
                        '<div class="d-flex justify-content-center">' +
                        '<div class="form-check form-switch">' +
                        '<input class="form-check-input" type="checkbox" role="switch" id="switch' + index + '" ' + (user.status == 1 ? 'checked' : '') + '>' +
                        '<label class="form-check-label" for="switch' + index + '"></label>' +
                        '</div>' +
                        '</div>',

                        user.role == 'admin' ? '' : '<div class="text-center d-flex justify-content-center">' +
                        '<button type="button" ' +
                        'onclick="editModal(' + user.id + ', \'admin/user/id=' + user.id + '\', \'admin/edit-user/' + user.id + '\')" ' +
                        'title="Edit user" ' +
                        'class="btn btn-warning btn-lg mx-2 d-flex justify-content-center align-items-center" ' +
                        'data-toggle="modal" ' +
                        'data-target="#editModal">' +
                        '<i class="fa fa-edit fa-lg"></i>' +
                        '</button>' +
                        '<button type="button" ' +
                        'onclick="deleteModal(' + user.id + ', \'admin/delete-user/' + user.id + '\')" ' +
                        'title="Delete user" ' +
                        'class="btn btn-danger btn-lg d-flex justify-content-center align-items-center" ' +
                        'data-toggle="modal"' +
                        'data-id="' + user.id + '" ' +
                        'data-target="#deleteModal">' +
                        '<i class="fa fa-trash fa-lg"></i>' +
                        '</button>' +
                        '</div>'
                    ]).draw();
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
</script>
@endsection