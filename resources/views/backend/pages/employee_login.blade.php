@extends('backend.employee.layout.emp_login_layout')

@section('section')

<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-5 login-signin-on d-flex flex-row-fluid" id="kt_login">
        <div class="d-flex flex-center bgi-size-cover bgi-no-repeat flex-row-fluid" style="background-image: url({{ asset('upload/company_image/bg.jpg') }})">
            <div class="login-form   p-7 position-relative overflow-hidden" style="color: black">
                <div class="d-flex flex-center">
                    <a href="#">
                        <img src="{{ asset('upload/company_image/logonew.png') }}"  alt="" />
                    </a>
                </div>
                <!--end::Login Header-->
                <!--begin::Login Sign in form-->
                <div class="login-signin" >
                    <div class="mb-10 text-center">
                        <h1 style="font-size: 1.5rem !important">My Login</h1>

                        <p class="">Enter your details to login to your account:</p>
                    </div>
                    <form class="form" id="employee-login-form" method="POST" action="auth-employee-login" novalidate="novalidate">
                        @csrf
                        <div class="form-group">
                            <input class="form-control form-control-solid  py-7 px-6" style="border-color: #3699ff" type="text" name="emp_email" placeholder="Please enter your register email" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-solid  py-7 px-6" style="border-color: #3699ff" type="password" name="emp_password" placeholder="Please enter your password" autocomplete="off">
                        </div>

                        <div class="form-group text-center mt-10">
                            <button id="kt_login_signin_submit" class="btn btn-primary btn-outline-black btn-block">Sign In</button>
                        </div>
                    </form>

                </div>
                <!--end::Login Sign in form-->

            </div>
        </div>
    </div>
    <!--end::Login-->
</div>
<!--end::Main-->

@endsection
