@extends ('adminLayout')
@section('title', '')
@section('content')
@include('create-user')
@include('delete-user')


<div id="table-container" class="pt-5">
    <p><b>USERS</b></p>
    <div style="overflow-x: auto;">
        <table id="employeeTable" class="display" style="width: 100%;">
            <thead>
                <tr style="border: 1px; border-radius: 30px; background: #0000ff; color: #fff;">
                    <th style="text-align:center">Name</th>
                    <th style="text-align:center">Phone number</th>
                    <th style="text-align:center">Email</th>
                    <th style="text-align:center">Status</th>
                    <th style="text-align:center">Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data rows will be added here -->
            </tbody>
        </table>
    </div>
</div>


<script>
var employeeTable

$(document).ready(function() {
    employeeTable = new DataTable('#employeeTable', {
        ajax: {
            url: '/admin/users',
            dataSrc: ''
        },
        order: [
            [4, 'desc'] // Ensure this index matches the position of 'created_at'
        ],
        columns: [{
                data: 'name'
            },
            {
                data: 'phone_number'
            },
            {
                data: 'email'
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    if (row.role === 'admin') {
                        return '';
                    } else {
                        return `
                <div class="d-flex justify-content-center">
                    <div class="form-check form-switch">
                        <input class="form-check-input status-toggle" type="checkbox" role="switch" id="switch${meta.row}" ${row.status == 1 ? 'checked' : ''} data-id="${row.id}">
                        <label class="form-check-label" for="switch${meta.row}"></label>
                    </div>
                </div>`;
                    }
                }
            },

            {
                data: 'id',
                render: function(data, type, row) {
                    var url = "{{ route('user-detail', 'id=:id') }}";
                    url = url.replace(':id', row.id);
                    return `<div class="text-center d-flex justify-content-center">
                            <button type="button" 
                                onclick="window.location.href='${url}'" 
                                title="Edit user" 
                                class="btn btn-warning btn-lg mx-2 d-flex justify-content-center align-items-center">
                                <i class="fa fa-edit fa-lg"></i>
                            </button>
                            ${row.role !== 'admin' ? `
                            <button type="button" 
                                onclick="deleteModal(${data}, 'admin/delete-user/${data}')" 
                                title="Delete user" 
                                class="btn btn-danger btn-lg d-flex justify-content-center align-items-center" 
                                data-toggle="modal" 
                                data-target="#deleteModal">
                                <i class="fa fa-trash fa-lg"></i>
                            </button>` : ''}
                        </div>`;
                }
            },
            {
                data: 'created_at',
                visible: false // Column will not be displayed but used for sorting
            }
        ],
        createdRow: function(row, data, dataIndex) {
            $(row).attr('data-id', data.id);
        }
    });
    // $('.modal').on('show.bs.modal', function() {
    //     $('.modal-backdrop').remove();
    // });


    $('#create-user-form').on('submit', function(event) {
        event.preventDefault(); // Ngăn chặn gửi form theo cách truyền thống
        $.ajax({
            url: $(this).attr('action'), // URL của controller
            type: 'POST',
            data: $(this).serialize(), // Dữ liệu từ form
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                    'content') // Thêm CSRF token vào tiêu đề
            },
            success: function(response) {

                if (response.success) {
                    employeeTable.ajax.reload();
                    toastr.success(response.success, 'Success', {
                        timeOut: 1000
                    });
                    $('#create-user').modal('hide');
                    $('#create-user-form')[0].reset();
                    $('.modal-backdrop').remove();
                    resetForm()
                } else if (response.errors) {
                    toastr.error(response.errors, "Error", {
                        timeOut: 1000
                    });
                }
            },
            error: function(xhr) {
                console.log('Error response:', xhr
                    .responseJSON); // Ghi lại phản hồi lỗi để kiểm tra

                // Kiểm tra nếu phản hồi chứa lỗi
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;

                    // Xóa lỗi cũ
                    $('.error').text('');

                    // Hiển thị lỗi mới
                    $.each(errors, function(key, value) {
                        console.log('Error for field:', key, 'Message:', value[
                            0]); // Ghi lại lỗi để kiểm tra
                        $('#' + key + '-error').text(value[
                            0]); // Hiển thị thông báo lỗi
                    });
                } else {
                    console.log('Unexpected error format:', xhr.responseText);
                }
            }
        });

    });

    function resetForm() {
        // Reset the form
        document.getElementById('create-user-form').reset();

        // Clear any error messages or error classes
        var formElements = document.querySelectorAll('#create-user-form .form-control');

        formElements.forEach(function(element) {
            // Remove error class if it exists
            element.classList.remove('is-invalid'); // Remove if used for error indication

            // Clear any error message
            var errorElement = document.getElementById(element.id + '-error'); // Specific error label
            if (errorElement) {
                errorElement.textContent = ''; // Clear the error message text
            }
        });
    }
});
</script>

<script>
// edit and delete user 
var root = "http://127.0.0.1:8000/";

function deleteModal(e, t) {
    $('#form_modal_delete').attr('action', root + t), $('#del_modal_id').val(e), $('#deleteModal').modal('show')
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