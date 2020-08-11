@extends('layouts.app')

{{-- Title of the app or resource <title>App</title> --}}
@section('title', $siteName . ' - Rediģēt ' . $section['name'])

@section('content')

{{-- Main content of the document --}}
<main>
    <header>
        <h1>Rediģēt {{$section['name']}}</h1>
        {{-- Lūdzu iespēju izvēlēties kategorijas --}}
        <ul>
            @foreach ($sections as $sectionItem)
            <li>{{$sectionItem['name']}}, id: {{$sectionItem['id']}}</li>
            @endforeach
        </ul>
    </header>

    {{-- form to edit section instance --}}
    <form method="POST" action="{{ route('section.update', $section['slug']) }}" enctype="multipart/form-data">
        {{-- method to use instead of POST --}}
        @method('PUT')
        {{-- cross site request forgery --}}
        @csrf
        {{-- the id --}}
        <input type="hidden" name="id" value="{{$section['id']}}">
        
        {{-- if we have selected image, pass selected image id --}}
        {{-- the id of the selected image --}}
        @isset($image)
        <input type="hidden" name="imageId" value="{{$image->id}}">
        @endisset

        {{-- this is form input field with label --}}
        <div>
            <label for="slug">url-vārds</label>
            <input 
            id="slug"
            {{-- @error directive is fired and adds danger class whenever we get error --}}
            @error('slug')
            class="danger"
            @enderror
            type="text"
            name="slug"
            {{-- provide old input incase of error --}}
            value="{{old('slug') ?? $section['slug']}}"
            >

            {{-- if error message --}}
            @error('slug')
            <p>{{$errors->first('slug')}}</p>
            @enderror
        </div>
        {{-- this is form input field with label --}}
        <div>
            <label for="name">Section nosaukums</label>
            <input 
            id="name"
            {{-- @error directive is fired and adds danger class whenever we get error --}}
            @error('name')
            class="danger"
            @enderror
            type="text"
            name="name"
            {{-- provide old input incase of error --}}
            value="{{old('name') ?? $section['name']}}"
            required
            autofocus>

            {{-- if error message --}}
            @error('name')
            <p>{{$errors->first('name')}}</p>
            @enderror
        </div>
        {{-- this is form input field with label --}}
        <div>
            <label for="arrangement">Section secība</label>
            <input 
            id="arrangement"
            {{-- @error directive is fired and adds danger class whenever we get error --}}
            @error('arrangement')
            class="danger"
            @enderror
            type="text"
            name="arrangement"
            {{-- provide old input incase of error --}}
            value="{{old('arrangement') ?? $section['arrangement']}}">

            {{-- if error message --}}
            @error('arrangement')
            <p>{{$errors->first('arrangement')}}</p>
            @enderror
        </div>
        {{-- this is form input field with label --}}
        <div>
            <label for="description">Apraksts</label>
            <input 
            id="description"
            {{-- @error directive is fired and adds danger class whenever we get error --}}
            @error('description')
            class="danger"
            @enderror
            type="text"
            name="description"
            {{-- provide old input incase of error --}}
            value="{{old('description') ?? $section['description']}}">
    
            {{-- if error message --}}
            @error('description')
            <p>{{$errors->first('description')}}</p>
            @enderror
        </div>
        {{-- this is form input field with label --}}
        <div>
            <label for="content">Saturs</label>
            <input 
            id="content"
            {{-- @error directive is fired and adds danger class whenever we get error --}}
            @error('content')
            class="danger"
            @enderror
            type="text"
            name="content"
            {{-- provide old input incase of error --}}
            value="{{old('content') ?? $section['content']}}">
    
            {{-- if error message --}}
            @error('content')
            <p>{{$errors->first('content')}}</p>
            @enderror
        </div>
        {{-- this is form input field with label --}}
        <div>
            <label for="accent_color">Krāsa</label>
            <input 
            id="accent_color"
            {{-- @error directive is fired and adds danger class whenever we get error --}}
            @error('accent_color')
            class="danger"
            @enderror
            type="text"
            name="accent_color"
            {{-- provide old input incase of error --}}
            value="{{old('accent_color') ?? $section['accent_color']}}">
    
            {{-- if error message --}}
            @error('accent_color')
            <p>{{$errors->first('accent_color')}}</p>
            @enderror
        </div>
        {{-- this is form input field with label --}}
        <div>
            <label for="image">Section bilde</label>
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

    {{-- Choose picture link--}}
    <a href="{{url(route('section.edit', $section->slug).'?select=image')}}">select image</a>

    {{-- Selected picture --}}
    @isset($image)
        <p>Izvēlētā bilde</p>
        <img src="{{url('/storage/uploads/images/480/'.$image->url)}}" alt="{{$image->description}}">
    @endisset

    {{-- Previous picture --}}
    @isset($section->image()->url)
        <p>Esošā bilde</p>
        <img src="{{url('/storage/uploads/images/480/'.$section->image()->url)}}" alt="{{$section->image()->description}}">
    @endisset
<main>
@endsection

{{-- side comments for category forms --}}
{{-- remove category --}}
{{-- if last add new category --}}
    
