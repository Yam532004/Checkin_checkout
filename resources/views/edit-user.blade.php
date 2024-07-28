@include('layouts.header')

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header bg-warning">
                <h3 class="modal-title text-white"><b>EDIT USER</b></h3>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close" onclick="
                                        var backdrop = document.getElementsByClassName('modal-backdrop')[0]; 
                                        console.log(backdrop);
                                        if (backdrop) {
                                            backdrop.classList.remove('modal-backdrop');
                                        }
                                ">
                    <span class="float-right" aria-hidden="true">×</span>
                </button>
            </div>
            <form action="" id="form_modal_edit" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="card-body container">
                        <input type="hidden" name="id" id="edit_modal_id">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="edit_name">Name</label>
                                    <div class="input-group">
                                        <input type="text" name="edit_name" class="form-control" id="edit_name" placeholder="Enter your name">
                                    </div>
                                    <label style="float: left; font-size:12px; color: red;" id="edit_name-error" class="error"></label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="edit_phone_number">Phone Number</label>
                                    <div class="input-group">
                                        <input type="text" name="edit_phone_number" class="form-control" id="edit_phone_number" placeholder="Enter phone number" value="">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                        </div>
                                    </div>
                                    <label style="float: left; font-size:12px; color: red;" id="edit_phone_number-error" class="error"></label>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="edit_email">Email Address</label>
                                    <div class="input-group">
                                        <input type="email" name="edit_email" class="form-control" id="edit_email" placeholder="Enter email">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                    </div>
                                    <label style="float: left; font-size:12px; color: red;" id="edit_email-error" class="error"></label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="edit_password">Password</label>
                                    <div class="input-group">
                                        <input type="text" name="edit_password" class="form-control" id="edit_password" placeholder="Enter password" autocomplete="off">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-eye-slash" id="toggleEdit_password"></i></span>
                                        </div>
                                        <!-- <span class="error text-left"></span> -->
                                    </div>
                                    <label style="float: left; font-size:12px; color: red;" id="edit_password-error" class="error"></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="container">
                            <div class="row">
                                <div class="col-6">
                                </div>
                                <div class="col-6 pr-0">
                                    <button type="submit" style="width: fit-content;" class="saveEdit btn btn-warning btn-block float-right">Save Changes</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </form>
    </div>
</div>
</div>
<script>
    $(document).ready(function() {
        $('#form_modal_edit').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

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
                        console.log("Success: " + response.success);
                        
                    } else if (response.errors) {
                        toastr.error(response.errors, "Error", {
                            timeOut: 1000
                        });
                    }
                    $('#create-user').modal('hide'); // Ẩn modal

                    // Tải lại trang sau khi thông báo đã hiển thị
                    // Thời gian trùng khớp với timeOut của toastr
                    setTimeout(function() {
                        window.location.reload();
                    }, 500)

                },
                error: function(xhr) {
                    console.log('Error response:', xhr.responseJSON); // Log the error response for debugging

                    // Check if the response contains errors
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;

                        // Clear previous errors
                        $('.error').text('');

                        // Display new errors
                        $.each(errors, function(key, value) {
                            console.log('Error for field:', key, 'Message:', value[0]); // Log each error for debugging
                            $('#' + key + '-error').text(value[0]); // Show error message
                        });
                    } else {
                        console.log('Unexpected error format:', xhr.responseText);
                    }
                }
            });
        });
    });
</script>

<script>
    document.getElementById('edit_password').addEventListener('input', function() {
        if (this.getAttribute('type') !== 'password') {
            this.setAttribute('type', 'password');
        }
        const passwordIcon = document.getElementById('toggleEdit_password');
        passwordIcon.classList.remove('fa-eye');
        passwordIcon.classList.add('fa-eye-slash');
    });

    // Chức năng toggle mật khẩu khi nhấp vào icon mắt
    document.getElementById('toggleEdit_password').addEventListener('click', function() {
        const passwordInput = document.getElementById('edit_password');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
</script>