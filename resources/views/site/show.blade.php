@extends('layouts.app')

{{-- Title of the app or resource <title>App</title> --}}
@section('title', $category['name'])

@section('content')

{{-- Main content of the document --}}
<main>
    <header>
        <h1>{{$category['name']}}</h1>
    </header>
    <ul>
        @foreach($category as $key => $value)
        <li>
            {{$key}}:{{$value}}
        </li>
        @endforeach
    </ul>
    @isset($category['image'])
    <img src="/storage/{{$category['image']}}" alt="">
    @endisset
</main>

@endsection