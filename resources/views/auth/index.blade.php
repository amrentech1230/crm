<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Login | Upcube - Admin & Dashboard Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('public/assets/images/favicon.ico') }}">

        <!-- Bootstrap Css -->
        <link href="{{ asset('public/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('public/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('public/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body class="auth-body-bg" style="background-image: url('https://crmcargoconvoy.co/public/backg.jpg'); background-repeat: no-repeat; background-size: cover; width:100%;">
        <div class="bg-overlay"></div>
        <div class="wrapper-page">
            <div class="container-fluid p-0">
                <div class="card">
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                     
                        <div class="text-center mt-4">
                            <div class="mb-3">
                                <a href="/" class="auth-logo">
                                    <img src="https://stagingcci.in/public/Cargo-icon.png" height="100" class="logo-dark mx-auto" alt="">
                                    <img src="https://stagingcci.in/public/Cargo-icon.png" height="100" class="logo-light mx-auto" alt="">
                                </a>
                            </div>
                        </div>
    
                        <h4 class="text-muted text-center font-size-18"><b>Sign In</b></h4>
    
                        <div class="p-3">
                            <form class="form-horizontal mt-3" method="Post" action="{{route('loginuser')}}">
                               @csrf
                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <input class="form-control" type="text" name="email" placeholder="Email">
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
    
                                <div class="form-group mb-3 row">
                                    <div class="col-12 position-relative">
                                        <input id="password" class="form-control" type="password" name="password" placeholder="Password">
                                        <span class="position-absolute" style="right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer;" 
                                            onmousedown="showPassword()" onmouseup="hidePassword()" onmouseleave="hidePassword()">
                                            <i class="fa fa-eye" id="toggleIcon"></i>
                                        </span>
                                        @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>

    
                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label class="form-label ms-1" for="customCheck1">Remember me</label>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="form-group mb-3 text-center row mt-3 pt-1">
                                    <div class="col-12">
                                        <button class="btn btn-info w-100 waves-effect waves-light" type="submit">Log In</button>
                                    </div>
                                </div>
    
                                <div class="form-group mb-0 row mt-2">
                                    <div class="col-sm-7 mt-3">
                                        <a href="auth-recoverpw.html" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                                    </div>
                                   
                                </div>
                            </form>
                        </div>
                        <!-- end -->
                    </div>
                    <!-- end cardbody -->
                </div>
                <!-- end card -->
            </div>
            <!-- end container -->
        </div>
        <!-- end -->

        <!-- JAVASCRIPT -->
        <script src="{{ asset('public/assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('public/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('public/assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('public/assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('public/assets/libs/node-waves/waves.min.js') }}"></script>

        <script src="{{ asset('public/assets/js/app.js') }}"></script>
        <script>
    function showPassword() {
        document.getElementById('password').type = 'text';
    }

    function hidePassword() {
        document.getElementById('password').type = 'password';
    }
</script>

    </body>
</html>
