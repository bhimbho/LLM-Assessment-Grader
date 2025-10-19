<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/pace.css') }}">
    <title>Student Portal - LLM Assessment Grading System</title>
    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600%7CRoboto:400" rel="stylesheet" type="text/css">
    <link href="{{asset('vendors/material-icons/material-icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('vendors/mono-social-icons/monosocialiconsfont.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('vendors/feather-icons/feather.css')}}" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/0.7.0/css/perfect-scrollbar.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick-theme.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.25/daterangepicker.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <!-- Head Libs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
    <script data-pace-options='{ "ajax": false, "selectors": [ "img" ]}' src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>
</head>

<body class="sidebar-dark sidebar-expand content-dark navbar-brand-dark right-sidebar-dark">
    <div id="wrapper" class="wrapper">
        <!-- HEADER & TOP NAVIGATION -->
        <nav class="navbar">
            <!-- Logo Area -->
            <div class="navbar-header">
                <a href="{{ route('student.dashboard') }}" class="navbar-brand">
                    <img class="logo-expand" alt="" src="{{ asset('img/logo-dark.png') }}">
                    <img class="logo-collapse" alt="" src="{{ asset('img/logo-collapse.png') }}">
                    <!-- <p>Student Portal</p> -->
                </a>
            </div>
            <!-- /.navbar-header -->
            <!-- Left Menu & Sidebar Toggle -->
            <ul class="nav navbar-nav">
                <li class="sidebar-toggle dropdown"><a href="javascript:void(0)" class="ripple"><i class="feather feather-menu list-icon fs-20"></i></a>
                </li>
            </ul>
            <!-- /.navbar-left -->
            
            <div class="spacer"></div>
            <!-- Right Menu -->
            <!-- /.navbar-right -->
            <!-- User Image with Dropdown -->
            <ul class="nav navbar-nav">
                <li class="dropdown"><a href="javascript:void(0);" class="dropdown-toggle dropdown-toggle-user ripple" data-toggle="dropdown"><span class="avatar thumb-xs2"><img src="{{ asset('img/default-avatar.png') }}" class="rounded-circle" alt=""> <i class="feather feather-chevron-down list-icon"></i></span></a>
                    <div class="dropdown-menu dropdown-left dropdown-card dropdown-card-dark dropdown-card-profile animated flipInY">
                        <div class="card">
                            <ul class="list-unstyled card-body">
                                <li><a href="{{ route('student.dashboard') }}"><span><span class="align-middle">Dashboard</span></span></a>
                                </li>
                                <li><a href="{{ route('student.assessments') }}"><span><span class="align-middle">My Assessments</span></span></a>
                                </li>
                                <li><a href="{{ route('student.logout') }}"><span><span class="align-middle">Sign Out</span></span></a>
                                </li>
                            </ul>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.dropdown-card-profile -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-nav -->
        </nav>
        <!-- /.navbar -->
        <div class="content-wrapper">
            <!-- SIDEBAR -->
            <aside class="site-sidebar scrollbar-enabled" data-suppress-scroll-x="true">
                <!-- User Details -->
                <div class="side-user d-none">
                    <div class="col-sm-12 text-center p-0 clearfix">
                        <div class="d-inline-block pos-relative mr-b-10">
                            <figure class="thumb-sm mr-b-0 user--online">
                                <img src="{{ asset('img/default-avatar.png') }}" class="rounded-circle" alt="">
                            </figure>
                        </div>
                        <!-- /.d-inline-block -->
                        <div class="lh-14 mr-t-5">
                            <a href="#" class="hide-menu mt-3 mb-0 side-user-heading fw-500">{{ auth('student')->user()->full_name }}</a>
                            <br><small class="hide-menu">Student</small>
                        </div>
                    </div>
                    <!-- /.col-sm-12 -->
                </div>
                <!-- /.side-user -->
                <!-- Call to Action -->
                <div class="side-content mr-t-30 mr-lr-15">
                    <a class="btn btn-block btn-success ripple fw-600" href="{{ route('student.assessments') }}">
                        <i class="fa fa-graduation-cap mr-1 mr-0-rtl ml-1-rtl"></i> View My Grades
                    </a>
                </div>
                <!-- Sidebar Menu -->
                @include('layouts.student-sidebar')
                <!-- /.sidebar-nav -->
            </aside>
            <!-- /.site-sidebar -->
        </div>
