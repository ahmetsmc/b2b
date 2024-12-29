<!doctype html>
<html lang="{{ app()->getLocale() }}" data-layout="vertical" data-topbar="light" data-sidebar="dark"
      data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable"
      data-bs-theme="{{ auth()->user()->preference('theme', 'light') }}">

<head>
    <meta charset="utf-8"/>
    <title>Dashboard | Velzon - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="Themesbrand" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/dashboard/images/favicon.ico') }}">

    <!-- jsvectormap css -->
    <link href="{{ asset('assets/dashboard/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet" type="text/css"/>

    <!--Swiper slider css-->
    <link href="{{ asset('assets/dashboard/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css"/>

    <!-- Layout config Js -->
    <script src="{{ asset('assets/dashboard/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/dashboard/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Icons Css -->
    <link href="{{ asset('assets/dashboard/css/icons.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    <link href="{{ asset('assets/dashboard/css/app.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- custom Css-->
    <link href="{{ asset('assets/dashboard/css/custom.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- fancybox -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
    <!-- sweetalert -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/libs/sweetalert2/sweetalert2.min.css') }}"/>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('head')

</head>

<body class="loader">

<div id="layout-wrapper">

    <x-dashboard.layout.topbar/>

    <x-dashboard.layout.sidebar/>


    <div class="vertical-overlay"></div>

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
