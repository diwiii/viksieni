@extends('layouts.app')

{{-- Title of the app or resource <title>App</title> --}}

@section('title', $site['name'] ?? config('app.name'))

@section('content')
    @section('content-nav')
    @parent
    <ul>
    @foreach($products as $product)
        <li>
            <a href="#{{$product['slug']}}">{{$product['name']}}</a>
        </li>
    @endforeach
    </ul>
    @endsection
{{-- Main content of the document --}}
<main>
@foreach($products as $product)
    <section id="{{$product['slug']}}">
        {{-- Header of the section --}}
        <header>
            {{-- Title of the section --}}
            <h1>{{$product['name']}}</h1>
            <nav>
                {{-- List of navigation items --}}
                <ul>
                    <li>
                        <a href="#!">To the top</a>
                    </li>
                </ul>
            </nav>
        </header>
        <p>{{$product['description']}}</p>
    </section>
@endforeach
</main>

@endsection