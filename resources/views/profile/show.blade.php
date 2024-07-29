<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}

        </h2>
        <button id="back-button" class="btn btn-secondary mb-3 " href="{{ url()->previous() }}">
            Back to Table
        </button>
    </x-slot>

    <div class="container-fluild m-3">
        @include('layouts.header')
        <div class="row">

            @include('user-sidebar')

            <div class="col-md-9">
                <div class="card  h-100">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#infor_user" data-toggle="tab"><b>Information</b></a></li>
                            <li class="nav-item-datapicker"><a class="nav-link" href="#absent" data-toggle="tab"><b>Absent</b> </a></li>
                            <li class="nav-item-datapicker"><a class="nav-link" href="#checkin_late" data-toggle="tab"><b>Checkin late</b></a></li>
                            <li class="nav-item-datapicker"><a class="nav-link" href="#checkout_early" data-toggle="tab"><b>Checkout Early</b></a></li>
                        </ul>
                    </div>
                    <div class="row" id="form-datepicker" style="display:none">
                        <div class="input-group" style="width:fit-content; margin-left: 7px;">
                            <input data-date-format="mm/yyyy" id="datepicker" class="form-control" />
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa-solid fa-calendar-days align-content-center fs-4"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="infor_user">
                                <form class="form-horizontal" id="user-form" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group row">
                                        <label for="user-name" class="col-sm-3 col-form-label">Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="user-name" placeholder="Name" name="name_edit">
                                            <label style="float: left; font-size:12px; color: red;" id="name_edit-error" class="error"></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="user-email" class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" id="user-email" placeholder="Email" name="email_edit">
                                            <label style="float: left; font-size:12px; color: red;" id="email_edit-error" class="error"></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="user-phone-number" class="col-sm-3 col-form-label">Phone number</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="user-phone-number" placeholder="Phone number" name="phone_number_edit">
                                            <label style="float: left; font-size:12px; color: red;" id="phone_number_edit-error" class="error"></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="user-password" class="col-sm-3 col-form-label">Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" id="user-password" placeholder="Password" name="password_edit">
                                            <label style="float: left; font-size:12px; color: red;" id="password_edit-error" class="error"></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-10 col-sm-2">
                                            <button type="submit" class="btn btn-danger">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @include('absent')
                            @include('checkin-late')
                            @include('checkout-early')
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.nav-item-datapicker').on('click', function() {
                $('#form-datepicker').show();
            })
            $('.nav-item').on('click', function() {
                $('#form-datepicker').hide();
            })
            var id = $("#user_id").val();
            console.log("user_id: ", id);
            $.ajax({
                type: "GET",
                url: "/user/id=" + id,
                dataType: 'json',
                success: function(user) {
                    $('#user-name').val(user.name);
                    $('#user-name-avt').text(user.name);
                    $('#user-phone-number').val(user.phone_number);
                    $('#user-email').val(user.email);
                    $('#user-status').val((user.status == 1 ? 'Active' : 'Inactive'));
                    $("#user-form").on('submit', function(event) {
                        event.preventDefault();
                        var formData = $(this).serialize();
                        $.ajax({
                            type: "PUT",
                            url: "/edit-user/" + user.id,
                            data: formData,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Thêm CSRF token vào tiêu đề
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('.error').text('');
                                    toastr.success(response.success, 'Success', {
                                        timeOut: 1000
                                    }); // Hiển thị thông báo thành công trong 5 giây
                                    $('#user-name-avt').html(response.user.name);
                                    console.log("Success: " + response.success);
                                } else if (response.errors) {
                                    toastr.error(response.errors, "Error", {
                                        timeOut: 1000
                                    });
                                }
                                $('#create-user').modal('hide');
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
                    })
                },

                error: function(xhr, status, error) {
                    console.error("Error fetching user detail: ", status, error);
                }
            });
        })
    </script>
    <script>
        $(document).ready(function() {
            $('#back-button').on('click', function() {
                // Check the current URL
                var currentUrl = window.location.pathname;

                if (currentUrl === '/admin/employees') {
                    // Show the table and hide user details
                    $('#user-detail').hide();
                    $('#table-container').show();
                    $('#create-button').show();
                } else {
                    // Go back to the previous page
                    window.history.back();
                }
            });
        });
    </script>
</x-app-layout>