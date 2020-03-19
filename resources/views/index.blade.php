@extends('layouts.app')

{{-- <title>Title</title> of the app is set at layouts/app.blade.php --}}
{{-- But if you like you can set it here aswell, uncoment next line--}}
{{-- @section('title', 'Title') --}}

@section('content')

    {{-- This is nav in the header section of the body --}}
    @section('content-nav')
    @parent
        <ul>
        @foreach($categories as $category)
            <li>
                <a href="#{{$category['slug']}}">{{$category['name']}}</a>
                <ul>
                    @foreach($category['products'] as $product)
                        <li>
                            {{ $product['name'] }}
                        </li>
                    @endforeach
                </ul>
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