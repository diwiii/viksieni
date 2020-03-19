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

{{-- 
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script> --}}

</head>
<body>
    <header>
        {{-- Title of the document --}}
        <h1>{{ $siteName ?? config('app.name')}}</h1>
        {{-- Document description --}}
        <p>{{ $siteDescription ?? 'Do you need description?'}}</p>
        {{-- Šis varētu būt komponents --}}
        {{-- Document content/navigation --}}
    
        <nav>
            <a href="/">Galvenā</a>
            @yield('content-nav')

            {{-- if we have login --}}
            @if(Auth::user())
                {{(Auth::user()->name)}}
                <a href="{{route('product.create')}}">Create product</a>
                <a href="{{route('category.create')}}">Create category</a>
                <a href="/logout">Logout</a>
            @endif
        </nav>
    </header>
    
    @yield('content')
</body>
</html>
