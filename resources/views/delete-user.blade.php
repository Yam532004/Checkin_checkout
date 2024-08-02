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
                                        var backdrop = document.getElementsByClassName('modal-backdrop')[0]; 
                                        console.log(backdrop);
                                        if (backdrop) {
                                            backdrop.classList.remove('modal-backdrop');
                                        }
                                ">
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
    $(document).ready(function() {
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
                        }); // Hiển thị thông báo thành công
                        console.log("Success: " + response.success);
                    } else if (response.errors) {
                        toastr.error(response.errors, 'Error', {
                            timeOut: 1000
                        }); // Hiển thị thông báo lỗi
                    }

                    $('.modal-backdrop').remove(); // Xóa backdrop
                    $('#deleteModal').modal('hide');
                    setTimeout(function() {
                        window.location.reload(); // Tải lại trang sau khi thông báo đã hiển thị
                    }, 1000); // Th��i gian trùng kh��p với timeOut của toastr
                    
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
    });
</script>