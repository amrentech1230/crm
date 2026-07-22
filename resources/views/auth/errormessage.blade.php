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
    
                        <h4 class="text-muted text-center font-size-18"><b>Please connect with the Cargoconvoy admin<br> to integrate the necessary extension for accessing the CRM portal.</b></h4>
    
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
