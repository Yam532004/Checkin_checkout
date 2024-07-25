@include('layouts.header')

<div class="row">
    <div class="col-md-3">
        <button id="back-button" class="btn btn-secondary mb-3">Back to Table</button>
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="https://fr.web.img6.acsta.net/pictures/15/06/10/14/56/066018.jpg" alt="User profile picture">
                </div>
                <h3 class="profile-username text-center" id="user-name-avt"></h3>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Followers</b> <a class="float-right">1,322</a>
                    </li>
                    <li class="list-group-item">
                        <b>Following</b> <a class="float-right">543</a>
                    </li>
                    <li class="list-group-item">
                        <b>Friends</b> <a class="float-right">13,287</a>
                    </li>
                </ul>
                <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
            </div>

        </div>




    </div>

    <div class="col-md-9">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Activity</a></li>
                    <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane" id="activity">

                        <div class="post">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
                                <span class="username">
                                    <a href="#">Jonathan Burke Jr.</a>
                                    <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                </span>
                                <span class="description">Shared publicly - 7:30 PM today</span>
                            </div>

                            <p>
                                Lorem ipsum represents a long-held tradition for designers,
                                typographers and the like. Some people hate it and argue for
                                its demise, but others ignore the hate as they create awesome
                                tools to help create filler text for everyone from bacon lovers
                                to Charlie Sheen fans.
                            </p>
                            <p>
                                <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                                <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                                <span class="float-right">
                                    <a href="#" class="link-black text-sm">
                                        <i class="far fa-comments mr-1"></i> Comments (5)
                                    </a>
                                </span>
                            </p>
                            <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                        </div>


                        <div class="post clearfix">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="../../dist/img/user7-128x128.jpg" alt="User Image">
                                <span class="username">
                                    <a href="#">Sarah Ross</a>
                                    <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                </span>
                                <span class="description">Sent you a message - 3 days ago</span>
                            </div>

                            <p>
                                Lorem ipsum represents a long-held tradition for designers,
                                typographers and the like. Some people hate it and argue for
                                its demise, but others ignore the hate as they create awesome
                                tools to help create filler text for everyone from bacon lovers
                                to Charlie Sheen fans.
                            </p>
                            <form class="form-horizontal">
                                <div class="input-group input-group-sm mb-0">
                                    <input class="form-control form-control-sm" placeholder="Response">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-danger">Send</button>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <div class="post">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="../../dist/img/user6-128x128.jpg" alt="User Image">
                                <span class="username">
                                    <a href="#">Adam Jones</a>
                                    <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                </span>
                                <span class="description">Posted 5 photos - 5 days ago</span>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <img class="img-fluid" src="../../dist/img/photo1.png" alt="Photo">
                                </div>

                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <img class="img-fluid mb-3" src="../../dist/img/photo2.png" alt="Photo">
                                            <img class="img-fluid" src="../../dist/img/photo3.jpg" alt="Photo">
                                        </div>

                                        <div class="col-sm-6">
                                            <img class="img-fluid mb-3" src="../../dist/img/photo4.jpg" alt="Photo">
                                            <img class="img-fluid" src="../../dist/img/photo1.png" alt="Photo">
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <p>
                                <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                                <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                                <span class="float-right">
                                    <a href="#" class="link-black text-sm">
                                        <i class="far fa-comments mr-1"></i> Comments (5)
                                    </a>
                                </span>
                            </p>
                            <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                        </div>

                    </div>

                    <div class="tab-pane" id="timeline">

                        <div class="timeline timeline-inverse">

                            <div class="time-label">
                                <span class="bg-danger">
                                    10 Feb. 2014
                                </span>
                            </div>


                            <div>
                                <i class="fas fa-envelope bg-primary"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="far fa-clock"></i> 12:05</span>
                                    <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>
                                    <div class="timeline-body">
                                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                        weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                        jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                        quora plaxo ideeli hulu weebly balihoo...
                                    </div>
                                    <div class="timeline-footer">
                                        <a href="#" class="btn btn-primary btn-sm">Read more</a>
                                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                    </div>
                                </div>
                            </div>


                            <div>
                                <i class="fas fa-user bg-info"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>
                                    <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                                    </h3>
                                </div>
                            </div>


                            <div>
                                <i class="fas fa-comments bg-warning"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>
                                    <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>
                                    <div class="timeline-body">
                                        Take me to your leader!
                                        Switzerland is small and neutral!
                                        We are more like Germany, ambitious and misunderstood!
                                    </div>
                                    <div class="timeline-footer">
                                        <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                                    </div>
                                </div>
                            </div>


                            <div class="time-label">
                                <span class="bg-success">
                                    3 Jan. 2014
                                </span>
                            </div>


                            <div>
                                <i class="fas fa-camera bg-purple"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="far fa-clock"></i> 2 days ago</span>
                                    <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>
                                    <div class="timeline-body">
                                        <img src="https://placehold.it/150x100" alt="...">
                                        <img src="https://placehold.it/150x100" alt="...">
                                        <img src="https://placehold.it/150x100" alt="...">
                                        <img src="https://placehold.it/150x100" alt="...">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <i class="far fa-clock bg-gray"></i>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane active" id="settings">
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
                                    <input type="text" class="form-control" id="user-password" placeholder="Password" name="password_edit">
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

                </div>

            </div>
        </div>

    </div>

</div>
<script>
    $(document).ready(function() {
        // Make the rows clickable
        $('#employeeTable tbody').on('click', 'tr td:nth-child(-n+3)', function() {
            var row = $(this).closest('tr'); // Get the closest row
            var id = row.data('id'); // Get the data-id attribute from the row
            if (id) {
                // Hide table and show user detail
                $('#table-container').hide();
                $('#create-button').hide();
                $('#user-detail').show();

                // Fetch user detail and populate the detail section
                $.ajax({
                    type: "GET",
                    url: "/admin/user/id=" + id,
                    dataType: 'json',
                    success: function(user) {
                        $('#user-name').val(user.name);
                        $('#user-name-avt').text(user.name);
                        $('#user-phone-number').val(user.phone_number);
                        $('#user-email').val(user.email);
                        $('#user-status').val((user.status == 1 ? 'Active' : 'Inactive'));
                        // Populate more fields as needed
                        // Set the form action attribute with the user ID
                        // $('#user-form').attr('action', '/admin/edit-user/' + user.id);
                        $("#user-form").on('submit', function(event) {
                            event.preventDefault();
                            var formData = $(this).serialize();
                            $.ajax({
                                type: "PUT",
                                url: "/admin/edit-user/" + user.id,
                                data: formData,
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
                                    // setTimeout(function() {
                                    //     window.location.reload();
                                    // }, 1000); 
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
            }
        });
    })
</script>