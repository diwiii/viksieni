@extends('layouts.app')

{{-- Title of the app or resource <title>App</title> --}}
@section('title', $image->name)

@section('content')

{{-- Main content of the document --}}
<main>
    <header>
        <h1>{{$image->name}}</h1>
    </header>
    <img src="/storage/uploads/images/{{$image->url}}" alt="{{$image->description}}"> 
</main>

@endsection