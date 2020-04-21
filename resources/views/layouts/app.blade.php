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
    <header id="root" class="bg-green vh100 flexbox column stretchX">      
        <!-- Logo -->
        <figure id="logo" class="flexbox column stretchX">
            <a href="{{route('root')}}">
                <img class="item-center maxWidth512 width100 ieFIXgrowShrink0 ieFIXwidth" src="/storage/{{$siteLogo}}" alt="{{$siteLogoDescription}}" title="Viksieni">
            </a>
            <div class="flexbox row">
                <!-- Title of the document -->
                <h1 style="display: none;">{{ $siteName ?? config('app.name')}}</h1><!-- Because we have .svg logo title -->
                {{-- Document description --}}
                <p class="description">{{ $siteDescription ?? 'Do you need description?'}}</p>
            </div>
        </figure>

        {{-- Šis varētu būt komponents --}}
        {{-- Document content/navigation --}}    
        <nav id="nav">
            <ul class="main-nav">
                    
                <li>
                    <a href="tel:+37126437844" class="button green2" target="_blank" title="Zvanīt saimniecei" rel="noopener noreferrer"><i class="material-icons" style="vertical-align: middle;">phone_enabled</i></a>
                </li>
                <li>
                    <a href="#pastilas" class="button green2" title="Rakstīt saimniecei"><i class="material-icons" style="vertical-align: middle;">mail</i></a>
                </li>
                <li>
                    <a href="#ellas" class="button green2">Pasūtīt</a>
                </li>
                <li>
                    <a href="list.html" class="button green2">Darinājumi</a>
                </li>
            </ul>

            {{-- Content navigation pagaidām atliekam --}}
            {{-- Tagad šo izmantojam kā main navigation --}}
            {{-- Content navigation --}}
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
