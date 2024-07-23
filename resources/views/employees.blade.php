@extends ('adminLayout')
@section('title', 'Employees')
@section('content')
@include('create-user')

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
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<!-- Include DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
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
                        '<input class="form-check-input" type="checkbox" role="switch" id="switch' + index + '" checked>' +
                        '<label class="form-check-label" for="switch' + index + '"></label>' +
                        '</div>' +
                        '</div>',

                        user.role == 'admin' ? '' : '<div class="text-center d-flex justify-content-center">' +
                        '<button type="button" ' +
                        'onclick="editModal(' + user.id + ', \'api/get-user.php?id=' + user.id + '\', \'api/edit-user.php\')" ' +
                        'title="Edit user" ' +
                        'class="btn btn-warning btn-lg mx-2 d-flex justify-content-center align-items-center" ' +
                        'data-toggle="modal" ' +
                        'data-target="#editModal">' +
                        '<i class="fa fa-edit fa-lg"></i>' +
                        '</button>' +
                        '<button type="button" ' +
                        'onclick="deleteModal(' + user.id + ', \'api/delete-user.php\')" ' +
                        'title="Delete user" ' +
                        'class="btn btn-danger btn-lg d-flex justify-content-center align-items-center" ' +
                        'data-toggle="modal" ' +
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
</script>
@endsection