<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
  <title>@yield('title', 'Login')</title>
  <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/owl-carousel/owl.carousel.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/toastr/css/toastr.min.css') }}">
</head>

<body>
    <div class="main-wrapper">
        <div class="header d-none">
            <ul class="nav nav-tabs user-menu">
                <li class="nav-item">
                    <a href="#" id="dark-mode-toggle" class="dark-mode-toggle">
                        <i class="feather-sun light-mode"></i><i class="feather-moon dark-mode"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-6 login-bg">
                <div class="login-banner"></div>
            </div>
            <div class="col-md-6 login-wrap-bg">
                <div class="login-wrapper">
                    <div class="loginbox">
                        <div class="img-logo">
                            <img src="{{ asset('assets/img/logo.png') }}" class="img-fluid" alt="Logo">
                        </div>
                        <h3>Login</h3>
                        <p class="account-subtitle">login to your account to continue</p>
                        <form action="{{ route('doctor.login')}}" method="Post">
                          @csrf
                            <div class="form-group form-focus">
                                <input type="text" name="email" class="form-control floating" value="{{old('email')}}">
                                <label class="focus-label">Enter Email/Mobile number</label>
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group form-focus">
                                <input type="password" name="password" class="form-control floating">
                                <label class="focus-label">Enter Password</label>
                                @if ($errors->has('password'))
                                  <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="custom_check mr-2 mb-0 d-inline-flex"> Remember me
                                            <input type="checkbox" name="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    {{-- <div class="col-6 text-end">
                                        <a class="forgot-link" href="forgot-password.html">Forgot Password ?</a>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-primary" type="submit">Login</button>
                            </div>
                            {{-- <div class="dont-have">Don't have an account? <a href="register.html">Sign up</a></div> --}}
                            <div class="login-or d-none">
                                <span class="or-line"></span>
                                <p class="span-or">or login with </p>
                            </div>

                            <div class="social-login d-none">
                                <a href="#"><img src="{{ asset('assets/img/icon/google.png') }}" class="img-fluid" alt="Logo"></a>
                                <a href="#"><img src="{{ asset('assets/img/icon/facebook.png') }}" class="img-fluid" alt="Logo"></a>
                                <a href="#"><img src="{{ asset('assets/img/icon/twitter.png') }}" class="img-fluid" alt="Logo"></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/toastr/js/toastr.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        @if(session()->has('error'))
                toastr.error("", "{{ session()->get('error')}}", {
                            positionClass: "toast-top-right",timeOut: 5000,
                            closeButton: !0,debug: !1,newestOnTop: !0,
                            progressBar: !0,preventDuplicates: !0,onclick: null,
                            showDuration: "300",hideDuration: "1000",
                            extendedTimeOut: "1000",showEasing: "swing",
                            hideEasing: "linear",showMethod: "fadeIn",
                            hideMethod: "fadeOut",tapToDismiss: !1
                        })
            @endif
            @if(session()->has('success'))
                toastr.success("", "{{ session()->get('success')}}", {
                            timeOut: 5000,closeButton: !0,
                            debug: !1,newestOnTop: !0,
                            progressBar: !0,positionClass: "toast-top-right",
                            preventDuplicates: !0,onclick: null,
                            showDuration: "300",hideDuration: "1000",
                            extendedTimeOut: "1000",showEasing: "swing",
                            hideEasing: "linear",showMethod: "fadeIn",
                            hideMethod: "fadeOut",tapToDismiss: !1
                        })
            @endif
    </script>
</body>
</html>
