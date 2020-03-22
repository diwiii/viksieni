@extends('layouts.app')

{{-- Title of the app or resource <title>App</title> --}}
@section('title', $product['name'])

@section('content')

{{-- Main content of the document --}}
<main>
    <header>
        <h1>{{$product['name']}}</h1>
    </header>
    <ul>
        @foreach($product as $key => $value)
        <li>
            {{$key}}:{{$value}}
        </li>
        @endforeach
    </ul>
    @isset($product['image'])
    <img src="/storage/{{$product['image']}}" alt="">
    @endisset
</main>

@endsection