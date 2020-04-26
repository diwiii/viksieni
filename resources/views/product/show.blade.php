@extends('layouts.app')

{{-- Title of the app or resource <title>App</title> --}}
@section('title', $product['name'])

@section('content')

{{-- Main content of the document --}}
<main>
    <header>
        <h1>{{$product['name']}}</h1>
    </header>
    {{-- {{-- <ul> --}}
        @foreach($product as $key => $value)
        <li>
            @if($key === 'image')
                @continue
            @endif
            {{$key}}:{{$value}}
            
        </li>
        @endforeach
    </ul>
    @isset($product['image'])
        <p>Please get image sizes</p>
    @endisset
</main>

@endsection