

$(document).ready(function () {
    $.validator.methods.checkPhone = function (value, element) {
        return (
            this.optional(element) ||
            /([\+84|84|0]+(3|5|7|8|9|1[2|6|8|9]))+([0-9]{8})\b/.test(value)
        );
    };
    //Tạo phương thức validate email
    $.validator.methods.checkEmail = function (value, element) {
        return (
            this.optional(element) ||
            /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(
                value
            )
        );
    };
    $.validator.methods.checkPassword = function (value, element) {
        return (
            this.optional(element) ||
            /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{5,}$/.test(
                value
            )
        );
    };

    $("#create-user").validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
                maxlength: 11,
            },
            email: {
                required: true,
                checkEmail: true,
                remote: {
                    url: "/check-email",
                    type: "post",
                },
            },
            phone_number: {
                required: true,
                checkPhone: true,
            },
            password: {
                required: true,
                minlength: 5,
                checkPassword: true,
            },
            confirm_password: {
                required: true,
                equalTo: "#password",
                checkPassword: true,
            },
        },
        message: {
            name: {
                required: "Please fill in your username",
                minlength: "Please enter at least {0} characters",
                maxlength: "Please enter a maximum of {0} characters",
                alpha_numericRegex: "Enter only alphanumeric characters",
            },
            email: {
                required: "We need your email address to contact you",
                checkEmail:
                    "Please enter your email in the format yam532004@gmail.com",
                remote: "Email already in use!",
            },
            phone_number: {
                required: "Please provide your phone number",
                checkPhone: "Please enter a valid 10-digit phone number",
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long",
                checkPassword:
                    "Password must be at least 5 characters long, contain one uppercase letter, one lowercase letter, one number, and one special symbol",
            },
            confirm_password: {
                required: "Please confirm your password",
                equalTo: "Please enter the same password as above",
                checkPassword:
                    "Password must be at least 8 characters long, contain one uppercase letter, one lowercase letter, one number, and one special symbol",
            },
        },
        errorPlacement: function (error, element) {
            error.appendTo(element.siblings("span.error")); // Chèn thông báo lỗi vào span.error
        },
        highlight: function (element) {
            $(element).addClass("error"); // Thêm lớp 'error' vào phần tử không hợp lệ
        },
        unhighlight: function (element) {
            $(element).removeClass("error"); // Loại bỏ lớp 'error' từ phần tử hợp lệ
        },
        submitHandler: function (form) {
            grecaptcha.ready(function () {
                grecaptcha
                    .execute("6LeQIAEqAAAAAOmPO-298SpcJ4A_Drenp-SZDEbS", {
                        action: "register",
                    })
                    .then(function (token) {
                        document.getElementById("token").value = token;
                        console.log(token);
                        form.submit();
                    });
            });
        },
    });
});
