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