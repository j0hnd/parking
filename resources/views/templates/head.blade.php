<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>

    {{-- Tell the browser to be responsive to screen width --}}
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    {{-- token --}}
    <meta content="{{ csrf_token() }}" name="csrf-token"></meta>

    {{-- required styles --}}
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('css/admin-vendor.css') }}">
    <link rel="stylesheet" href="{{ mix('css/admin.css') }}">

    {{-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries --}}
    {{-- WARNING: Respond.js doesn't work if you view the page via file:// --}}
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('img/icons.ico/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('img/icons.ico/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('img/icons.ico/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/icons.ico/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('img/icons.ico/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('img/icons.ico/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('img/icons.ico/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('img/icons.ico/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/icons.ico/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('img/icons.ico/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/icons.ico/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('img/icons.ico/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/icons.ico/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('img/icons.ico/manifest.json') }}">

    <style media="screen">
        .ui-autocomplete { height: 300px; overflow-y: scroll; overflow-x: hidden; }
    </style>

    @yield('styles')
</head>
