@extends('layouts.app')

{{-- Title of the app or resource <title>App</title> --}}
@section('title', $section['name'])

@section('content')

{{-- Main content of the document --}}
<main>
    <header>
        <h1>{{$section['name']}}</h1>
    </header>
    <ul>
        @foreach($section as $key => $value)
        <li>
            {{$key}}:{{$value}}
        </li>
        @endforeach
    </ul>
    @isset($section['image'])
    <img src="/storage/{{$section['image']}}" alt="">
    @endisset
</main>

@endsection