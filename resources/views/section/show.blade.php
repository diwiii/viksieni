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
        @auth
        <li><a href="{{route('section.edit', $section->slug)}}">Rediģēt</a></li>
        @endauth
        <li>id: {{$section->id}}</li>
        <li>slug: {{$section->slug}}</li>
        <li>
            <a href="{{url(route('section.edit', $section->slug).'?select=image')}}">select image</a>
        </li>
        <li>name: {{$section->name}}</li>
        <li>description: {{$section->description}}</li>
        <li>content: {{$section->content}}</li>
        <li>accent: {{$section->accent_color}}</li>
        <li>arrangement: {{$section->arrangement}}</li>
        <li>created_at: {{$section->created_at}}</li>
        <li>updated_at: {{$section->updated_at}}</li>
        @auth
        <li>
            @component('delete')
                @slot('route')
                {{ route('section.destroy', $section->slug) }}
                @endslot
            @endcomponent
        </li>
        @endauth
    </ul>

    @isset($section->image()->url)
        <p>Esošā bilde</p>
        <img src="{{url('/storage/uploads/images/480/'.$section->image()->url)}}" alt="{{$section->image()->description}}">
    @endisset
    {{-- @isset($section['image'])
    <img src="/storage/{{$section['image']}}" alt="">
    @endisset --}}
</main>

@endsection