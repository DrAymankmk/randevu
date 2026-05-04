<!DOCTYPE html>
<html lang="{{app()->getLocale()}}" class="body-full-height">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Takafol</title>
    <link href="{{ asset('media/logo/logo.png')}}" sizes="128x128" rel="shortcut icon" type="image/x-icon"/>
    <link href="{{ asset('media/logo/logo.png')}}" sizes="128x128" rel="shortcut icon"/>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/admin/css/fontawesome.css')}}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/admin/css/icofont.css')}}">

    <link rel="stylesheet" type="text/css" href="{{ asset('/admin/css/themify.css')}}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/admin/css/flag-icon.css')}}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/admin/css/feather-icon.css')}}">

    <link rel="stylesheet" href="{{ asset('admin/js/noty/noty.css') }}">
    <script src="{{ asset('admin/js/noty/noty.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('admin//css/bootstrap.css')}}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/style.css')}}">
    <link id="color" rel="stylesheet" href="{{ asset('admin/css/light-1.css')}}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/responsive.css')}}">
    <style>
        .authentication-main {
            background-image: url("{{ asset('media/logo/4.jpg') }}");
            background-repeat: no-repeat;
            background-size: cover;
        }

        .toggle-password {
            z-index: 9999;
            position: absolute;
            top: 70%;
            right: 40px;
        }
    </style>
</head>
<body>
<!-- Loader starts-->
<div class="loader-wrapper">
    <div class="loader bg-white">
        <div class="whirly-loader"></div>
    </div>
</div>
<!-- Loader ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper">
    <div class="container-fluid p-0">
        <!-- login page start-->
        <div class="authentication-main">
            <div class="row">
                <div class="col-md-12">
                    <div class="auth-innerright">

                        <div class="authentication-box">
                            @if ($message = \Illuminate\Support\Facades\Session::get('message'))
                                <div class="alert alert-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif
                            <div class="text-center">
                                <img src="{{ asset('media/logo/logo.png')}}" alt="" style="width: 180px;height: 140px">
                            </div>
                            <div class="card mt-4">
                                <div class="card-body">
                                    <div class="text-center">
                                        <h4>Admin Panel</h4>
                                        <h6 class="textshadow">Login To Takafol Dashboard</h6>
                                    </div>
                                    <form role="form" method="POST" action='{{url()->current()}}' class="theme-form">
                                        {{ csrf_field() }}
                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label class="col-form-label   pt-0">Email
                                            </label>
                                            <input type="email" class="form-control" name="email"
                                                   value="{{ old('email') }}" required
                                                   autofocus>
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong></span>
                                            @endif
                                        </div>

                                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <label for="validationCustom05" class="col-form-label">Password
                                            </label>
                                            <label for="password"></label>
                                            <input id="password-field" type="password" class="form-control"
                                                   name="password" required>
                                            <span toggle="#password-field"
                                                  class="fa fa-fw fa-eye field-icon toggle-password eye"> </span>
                                            <i class="flaticon-password "></i>
                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                  <strong>{{ $errors->first('password') }}</strong></span>
                                            @endif
                                        </div>

                                        <div class="form-group form-row mt-3 mb-0">
                                            <button class="btn btn-primary btn-block" type="submit">Login</button>
                                        </div>

                                        @if (Route::has('forget.password.get'))
                                            {{--<a class="btn btn-link" href="{{ route('password.request') }}">--}}
                                            {{--{{ __('Forgot Your Password?') }}--}}
                                            {{--</a>--}}
                                            <div class="form-group form-row mt-3 mb-0">
                                                <a href="{{ route('forget.password.get') }}"
                                                   class="btn btn-primary btn-block"
                                                   type="submit"> {{ __('Forgot Your Password?') }}</a>
                                            </div>
                                        @endif

                                    </form>
                                </div>
                            </div>
                            <div class="text-center">
                                <img style="width: 60px"
                                     src="{{ asset('media/logo/logo.png')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- login page end-->
    </div>
</div>
<!-- latest jquery-->
<script src="{{ asset('admin/js/jquery-3.2.1.min.js')}}"></script>
<!-- Bootstrap js-->
<script src="{{ asset('admin/js/bootstrap/popper.min.js')}}"></script>
<script src="{{ asset('admin/js/bootstrap/bootstrap.js')}}"></script>
<!-- feather icon js-->
{{--<script src="{{asset('admin/js/notify/bootstrap-notify.min.js')}}"></script>--}}

<script src="{{ asset('admin/js/icons/feather-icon/feather.min.js')}}"></script>
<script src="{{ asset('admin/js/icons/feather-icon/feather-icon.js')}}"></script>
<!-- Sidebar jquery-->
<script src="{{ asset('admin/js/sidebar-menu.js')}}"></script>
<script src="{{ asset('admin/js/config.js')}}"></script>
<!-- Plugins JS start-->
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{ asset('admin/js/script.js')}}"></script>
<!-- Plugin used-->
<script>
    $(".toggle-password").click(function () {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
</script>

@if (session('success'))

    <script>
        new Noty({
            type: 'success',
            'icon': 'check',
            layout: 'bottomRight',
            text: "{{ session('success') }}",
            timeout: 4000,
            killer: true
        }).show();
    </script>
@endif

@if (session('failed'))
    <script>
        $(document).ready(function () {
            new Noty({
                type: 'error',
                layout: 'bottomRight',
                text: "{{ session('failed') }}",
                timeout: 2000,
                killer: true
            }).show();
        });
    </script>

@endif
</body>
</html>
