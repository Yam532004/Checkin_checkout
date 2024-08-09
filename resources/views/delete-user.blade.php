@include('layouts.header')
<div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="POST" class="form-horizontal" id="form_modal_delete">
                @csrf

                <div class="modal-body">
                    <input type="hidden" name="id" id="del_modal_id" />
                    <h5 class="text-center">Are you sure you want to delete this item?</h5>
                </div>
                <div class="modal-footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-3"></div>
                            <div class="col-3 d-flex justify-content-center align-items-center">
                                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="
                                    setTimeout(function() {
                                        var backdrop = document.getElementsByClassName('modal-backdrop')[0]; 
                                        if (backdrop) {
                                            backdrop.parentNode.removeChild(backdrop);
                                        }
                                    }, 500); ">
                                    No
                                </button>
                            </div>
                            <div class="col-3 d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn btn-primary">Yes</button>
                            </div>
                            <div class="col-3"></div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
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
    $('#form_modal_delete').on('submit', function(event) {
        event.preventDefault(); // Ngăn chặn gửi form theo cách truyền thống

        $.ajax({
            url: $(this).attr('action'), // URL của controller
            type: 'DELETE', // Phương thức HTTP DELETE
            data: $(this).serialize(), // Dữ liệu từ form
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Thêm CSRF token vào tiêu đề
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.success, 'Success', {
                        timeOut: 1000
                    });
                    loadUserList()
                    // Hiển thị thông báo thành công
                    console.log("Success: " + response.success);
                } else if (response.errors) {
                    toastr.error(response.errors, 'Error', {
                        timeOut: 1000
                    }); // Hiển thị thông báo lỗi
                }
                $('#deleteModal').removeClass('show');
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');

            },
            error: function(xhr) {
                console.log('Error response:', xhr.responseJSON); // Ghi lại phản hồi lỗi để kiểm tra

                // Hiển thị thông báo lỗi chung nếu không có lỗi cụ thể
                toastr.error('An unexpected error occurred. Please try again later.', 'Error', {
                    timeOut: 1000
                });
            }
        });
    });
</script>