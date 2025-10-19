<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon.png') }}">
    <title>LLM Assessment Grading System</title>
    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600%7CRoboto:400" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendors/material-icons/material-icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendors/mono-social-icons/monosocialiconsfont.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendors/feather-icons/feather.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/0.7.0/css/perfect-scrollbar.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <!-- Head Libs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
</head>

<body class="body-bg-full profile-page" style="background-image: url({{ asset('img/site-bg.jpg') }})">
    <div id="wrapper" class="row wrapper">
        <div class="container-min-full-height d-flex justify-content-center align-items-center">
            <div class="login-center">
                <div class="navbar-header text-center mt-2 mb-4">
                    <a href="#">
                        <img alt="" src="{{ asset('img/logo-dark.png') }}">
                    </a>
                </div>
                <h4 class="text-center mb-4">LLM Assessment Grading System</h4>
                <p class="text-center text-muted mb-4">Choose your login portal</p>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="material-icons text-primary" style="font-size: 3rem;">admin_panel_settings</i>
                                <h5 class="card-title mt-3">Staff Portal</h5>
                                <p class="text-muted">For lecturers and administrators</p>
                                <a href="{{ route('login') }}" class="btn btn-primary btn-block">
                                    Staff Login
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="material-icons text-success" style="font-size: 3rem;">school</i>
                                <h5 class="card-title mt-3">Student Portal</h5>
                                <p class="text-muted">For students to view their grades</p>
                                <a href="{{ route('student.login') }}" class="btn btn-success btn-block">
                                    Student Login
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.login-center -->
        </div>
        <!-- /.d-flex -->
    </div>
    <!-- /.body-container -->
    <!-- Scripts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/material-design.js') }}"></script>
</body>

</html>
