<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- do we need this tag? --}}
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Catamaran:400,900&display=swap" rel="stylesheet">
    <!-- google Material Icons -->
    <!-- https://material.io/resources/icons/?style=baseline -->
    <!-- https://google.github.io/material-design-icons/ -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    
    {{-- Title --}}
    <title>@yield('title', $siteName ?? config('app.name'))</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script> --}}

</head>
<body>
    @yield('header', View::make('layouts.parts.default.header'))

    {{-- This should be into parts --}}
    @if (session('added'))
    <div class="alert alert-success">
        {{ session('added') }}
    </div>
    @endif
    @if (session('removed'))
    <div class="alert alert-success">
        {{ session('removed') }}
    </div>
    @endif
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif

    @yield('content')
</body>
</html>
