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
    @isset($product->image()->url)
        <p>Esošā bilde</p>
        <img src="{{url('/storage/uploads/images/480/'.$product->image()->url)}}" alt="{{$product->image()->description}}">
    @endisset
</main>

@endsection