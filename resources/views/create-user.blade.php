<!-- Button để mở modal -->
<button class="btn btn-sm btn-success float-right mt-2" data-bs-toggle="modal" data-bs-target="#create-user"
    id="create-button">
    <b>Create <i class="fa-solid fa-plus"></i>
    </b>
</button>

<!-- Modal -->
<div class="modal fade" id="create-user" tabindex="-1" aria-labelledby="exampleModalLabel3" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h3 class="modal-title"><b>CREATE</b></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="create-user-form" action="/admin/add-user" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="card-body container">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label style="float: left;" for="name">Name <span style="color:red">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="name" class="form-control" id="name"
                                            placeholder="Enter your name">
                                    </div>
                                    <label style="float: left; font-size:12px; color: red;" id="name-error"
                                        class="error"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label style="float: left;" for="email">Email address <span
                                            style="color:red">*</span></label>
                                    <div class="input-group">
                                        <input type="email" name="email" class="form-control" id="email"
                                            placeholder="Enter email">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                    </div>
                                    <label style="float: left; font-size:12px; color: red;" id="email-error"
                                        class="error"></label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label style="float: left;" for="phone_number">Phone number <span
                                            style="color:red">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="phone_number" class="form-control" id="phone_number"
                                            placeholder="Enter phone number">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                        </div>
                                    </div>
                                    <label style="float: left; font-size:12px; color: red;" id="phone_number-error"
                                        class="error"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label style="float: left;" for="password">Password <span
                                            style="color:red">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="password" id="password"
                                            autocomplete="off">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-eye-slash"
                                                    id="togglePassword"></i></span>
                                        </div>
                                    </div>
                                    <label style="float: left; font-size:12px; color: red;" id="password-error"
                                        class="error"></label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label style="float: left;" for="confirm_password">Confirm Password <span
                                            style="color:red">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="confirm_password"
                                            id="confirm_password" autocomplete="off">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-eye-slash"
                                                    id="toggleConfirm_Password"></i></span>
                                        </div>
                                    </div>
                                    <label style="float: left; font-size:12px; color: red;" id="confirm_password-error"
                                        class="error"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between float-right">
                    <button type="submit" style="width: fit-content;" class="btn btn-success">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
$('.modal').on('show.bs.modal', function() {
    $('.modal-backdrop').remove();
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
</script>
<script>
function loadUserList() {
    $.ajax({
        url: '/admin/users', // URL của API để lấy danh sách người dùng
        type: 'GET',
        dataType: 'json', // Đảm bảo trả về dữ liệu dưới dạng JSON
        success: function(data) {
            var table = $('#employeeTable').DataTable();

            table.clear();
            $.each(data, function(index, user) {
                var userDetailUrlBase =
                    "{{ route('user-detail', ['id' => 'PLACEHOLDER_ID']) }}";
                var userDetailUrl = userDetailUrlBase.replace('PLACEHOLDER_ID', user
                    .id);

                table.row.add([
                    '<div id="user-name-detail">' + user.name + '</div>',
                    '<div id="user-phone-detail">' + user.phone_number +
                    '</div>',
                    '<div id="user-email-detail">' + user.email + '</div>',
                    user.role == 'admin' ? '' :
                    '<div class="d-flex justify-content-center">' +
                    '<div class="form-check form-switch">' +
                    '<input class="form-check-input status-toggle" type="checkbox" role="switch" id="switch' +
                    index + '" ' + (user.status == 1 ? 'checked' : '') +
                    ' data-id="' + user.id + '">' +
                    '<label class="form-check-label" for="switch' + index +
                    '"></label>' +
                    '</div>' +
                    '</div>',
                    '<div class="text-center d-flex justify-content-center">' +
                    '<button type="button" ' +
                    'onclick="window.location.href=\'' + userDetailUrl +
                    '\' " ' +
                    'title="Edit user" ' +
                    'class="btn btn-warning btn-lg mx-2 d-flex justify-content-center align-items-center">' +
                    '<i class="fa fa-edit fa-lg"></i>' +
                    '</button>' +
                    (user.role == 'admin' ? '' :
                        '<button type="button" ' +
                        'onclick="deleteModal(' + user.id +
                        ', \'admin/delete-user/' + user.id + '\')" ' +
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
            toastr.error('An error occurred while loading the user list.', 'Error', {
                timeOut: 1000
            });
        }
    });
}
$('#create-user-form').on('submit', function(event) {
    event.preventDefault(); // Ngăn chặn gửi form theo cách truyền thống

    $.ajax({
        url: $(this).attr('action'), // URL của controller
        type: 'POST',
        data: $(this).serialize(), // Dữ liệu từ form
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Thêm CSRF token vào tiêu đề
        },
        success: function(response) {

            if (response.success) {
                toastr.success(response.success, 'Success', {
                    timeOut: 1000
                }); // Hiển thị thông báo thành công trong 5 giây
                $('#create-user').modal('hide');
                $('#create-user-form')[0].reset();

                // Đảm bảo không có nhiều lớp modal-backdrop
                setTimeout(function() {
                    $('.modal-backdrop').remove();
                }, 500);

                loadUserList()
            } else if (response.errors) {
                toastr.error(response.errors, "Error", {
                    timeOut: 1000
                });
            }
        },
        error: function(xhr) {
            console.log('Error response:', xhr.responseJSON); // Ghi lại phản hồi lỗi để kiểm tra

            // Kiểm tra nếu phản hồi chứa lỗi
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                var errors = xhr.responseJSON.errors;

                // Xóa lỗi cũ
                $('.error').text('');

                // Hiển thị lỗi mới
                $.each(errors, function(key, value) {
                    console.log('Error for field:', key, 'Message:', value[
                        0]); // Ghi lại lỗi để kiểm tra
                    $('#' + key + '-error').text(value[0]); // Hiển thị thông báo lỗi
                });
            } else {
                console.log('Unexpected error format:', xhr.responseText);
            }
        }
    });

});
</script>

<script>
document.getElementById('password').addEventListener('input', function(event) {
    if (this.getAttribute('type') !== 'password') {
        this.setAttribute('type', 'password');
    }
    const passwordIcon = document.getElementById('togglePassword');
    passwordIcon.classList.remove('fa-eye');
    passwordIcon.classList.add('fa-eye-slash');
})

document.getElementById('togglePassword').addEventListener('click', function(event) {
    const passwordInput = document.getElementById('password');
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
})

document.getElementById('confirm_password').addEventListener('input', function(event) {
    if (this.getAttribute('type') !== 'password') {
        this.setAttribute('type', 'password');
    }
    const confirmPasswordIcon = document.getElementById('toggleConfirm_Password');
    confirmPasswordIcon.classList.remove('fa-eye');
    confirmPasswordIcon.classList.add('fa-eye-slash');
})

document.getElementById('toggleConfirm_Password').addEventListener('click', function(event) {
    const confirmPasswordInput = document.getElementById('confirm_password');
    const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    confirmPasswordInput.setAttribute('type', type);
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
})
</script>
<style>
input[type="password"]::-ms-reveal,
input[type="password"]::-ms-clear {
    display: none;
}

input[type="password"]::-webkit-credentials-auto-fill-button,
input[type="password"]::-webkit-password-toggle-button,
input[type="password"]::-webkit-clear-button {
    display: none;
}
</style>