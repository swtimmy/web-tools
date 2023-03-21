
<div class="mt-3 text-center">
    <a href="" data-toggle="modal" data-target="#modalRegisterForm">Sign up</a>
</div>
<div class="modal fade" id="modalRegisterForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="register-form" action="javascript:void(0)">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Create Account</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form mb-3">
                        <label for="register_email">Your email</label>
                        <input type="email" id="register_email" name="email" class="form-control validate">
                    </div>
                    <div class="md-form mb-1">
                        <label for="register_password">Your password</label>
                        <input type="password" id="register_password" name="password" class="form-control validate">
                    </div>
                    <div class="alert alert-success d-none" id="msg_div">
                        <span id="res_message"></span>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-deep-orange send-form">Sign up</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section("js")
    <script>
        if ($("#register-form").length > 0) {
            var registerForm = new ajaxForm("#register-form");
            registerForm.set_validate(
                {
                    email: {
                        required: true,
                        maxlength: 255,
                        email: true,
                    },
                    password: {
                        required: true,
                        minlength: 8,
                        maxlength: 50
                    }
                },
                {
                    email: {
                        required: "Please enter valid email",
                        email: "Please enter valid email",
                        maxlength: "The email name should less than or equal to 50 characters",
                    },
                    password: {
                        required: "Please enter password",
                        maxlength: "Your password maxlength should be 50 characters long."
                    }
                },
            );
            registerForm.set_form('./register');
        }
    </script>
@append