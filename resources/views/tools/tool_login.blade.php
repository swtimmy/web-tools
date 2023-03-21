@extends("tools/tool_content")

@section("css")
    <style>
        html,
        body {
            height: 100%;
        }
        body {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            background-color: #f5f5f5;
        }
        .form-style {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }
        .form-style .checkbox {
            font-weight: 400;
        }
        .form-style .form-control {
            position: relative;
            box-sizing: border-box;
            height: auto;
            padding: 10px;
            font-size: 16px;
        }
        .form-style .form-control:focus {
            z-index: 2;
        }
        .form-style input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }
        .form-style input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
@append

@section("js")
    <script>
        if ($("#login-form").length > 0) {
            var loginForm = new ajaxForm("#login-form");
            loginForm.set_validate(
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
            loginForm.set_form('./login',null,null,true,true);
        }
    </script>
@append

@section("content")
    <div class="form-style">
        <form id="login-form" action="javascript:void(0)">
            <div class="text-center mb-4">
                <img style="margin-bottom:10px;margin-right:3px;" src="/image/tool/lego.png" alt="" width="72" height="72">
                <label><h3>SWTimmy</h3></label>
            </div>
            <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
            <label for="login_email" class="sr-only">Email address</label>
            <input type="email" name="email" id="login_email" class="form-control" placeholder="Email address" autofocus="">
            <label for="login_password" class="sr-only">Password</label>
            <input type="password" name="password" id="login_password" class="form-control" placeholder="Password">
            <div class="checkbox mb-1">
                <label>
                    <input type="checkbox" name="remember_me" value="remember-me"> Remember me
                </label>
            </div>
            <div class="alert alert-success d-none" id="msg_div">
                <span id="res_message"></span>
            </div>
            <button class="btn btn-lg btn-primary btn-block send-form" type="submit">Sign in</button>
            {{--<p class="mt-5 mb-3 text-muted">© 2017-2019</p>--}}
        </form>
        @include("tools/tool_register")
    </div>

@stop