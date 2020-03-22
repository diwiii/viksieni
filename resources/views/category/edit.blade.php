@extends('layouts.app')

{{-- Title of the app or resource <title>App</title> --}}
@section('title', $siteName . ' - Rediģēt ' . $category['name'])

@section('content')

{{-- Main content of the document --}}
<main>
    <header>
        <h1>Rediģēt {{$category['name']}}</h1>
        {{-- Lūdzu iespēju izvēlēties kategorijas --}}
        <ul>
            @foreach ($categories as $categoryItem)
            <li>{{$categoryItem['name']}}, id: {{$categoryItem['id']}}</li>
            @endforeach
        </ul>
    </header>

    {{-- form to edit category instance --}}
    <form method="POST" action="{{ route('category.update', $category['slug']) }}" enctype="multipart/form-data">
        {{-- method to use instead of POST --}}
        @method('PUT')
        {{-- cross site request forgery --}}
        @csrf
        {{-- the id --}}
        <input type="hidden" name="id" value="{{$category['id']}}">

        {{-- this is form input field with label --}}
        <div>
            <label for="name">Kategorijas nosaukums</label>
            <input 
            id="name"
            {{-- @error directive is fired and adds danger class whenever we get error --}}
            @error('name')
            class="danger"
            @enderror
            type="text"
            name="name"
            {{-- provide old input incase of error --}}
            value="{{old('name') ?? $category['name']}}"
            required
            autofocus>

            {{-- if error message --}}
            @error('name')
            <p>{{$errors->first('name')}}</p>
            @enderror
        </div>
        {{-- this is form input field with label --}}
        <div>
            <label for="arrangement">Kategorijas secība</label>
            <input 
            id="arrangement"
            {{-- @error directive is fired and adds danger class whenever we get error --}}
            @error('arrangement')
            class="danger"
            @enderror
            type="text"
            name="arrangement"
            {{-- provide old input incase of error --}}
            value="{{old('arrangement') ?? $category['arrangement']}}">

            {{-- if error message --}}
            @error('arrangement')
            <p>{{$errors->first('arrangement')}}</p>
            @enderror
        </div>
        {{-- this is form input field with label --}}
        <div>
            <label for="image">Kategorijas bilde</label>
            <input 
            id="image"
            {{-- @error directive is fired and adds danger class whenever we get error --}}
            @error('image')
            class="danger"
            @enderror
            type="file"
            name="image"
            {{-- provide old input incase of error --}}
            {{-- we dont need old input for image --}}
            {{-- value="{{old('image')}}" --}}
            >

            {{-- if error message --}}
            @error('image')
            <p>{{$errors->first('image')}}</p>
            @enderror
        </div>

        <button type="submit">Saglabāt izmaiņas</button>
    </form>

    @isset($category['image'])
    <img src="/storage/{{$category['image']}}" alt="">
    @endisset
<main>
@endsection

{{-- side comments for category forms --}}
{{-- remove category --}}
{{-- if last add new category --}}
    
