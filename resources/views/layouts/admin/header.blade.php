<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" theme-mode="light">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin portal - Futech solution @yield('title')</title>
    <base href="{{ env('APP_FULL_URL') }}/" />
    <!-- Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta NAME="distribution" CONTENT="Global" />
    <meta NAME="Robots" CONTENT="INDEX,FOLLOW" />
    <meta NAME="country" CONTENT="Australia" />
    <meta property="og:url" content="{{ \Request::url() }}" />
    <meta property="og:type" content="article" />
    <meta name="application-name" content="&nbsp;" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <link href="{{ asset('resources/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('resources/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('resources/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('resources/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <script src="https://kit.fontawesome.com/4198bd1e2e.js" crossorigin="anonymous"></script>

    <!-- Icon Font -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.2.95/css/materialdesignicons.min.css">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}

    <link rel="apple-touch-icon" sizes="76x76" href="{{ getFavIcon() }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ getFavIcon() }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ getFavIcon() }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif !important;
        }

        .v-main__wrap {
            background: #ffffff !important;
        }
    </style>
</head>
