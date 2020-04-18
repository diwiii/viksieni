@extends('layouts.app')

{{-- Title of the app or resource <title>App</title> --}}
@section('title', $siteName . ' - Rediģēt ' . $site['name'])

@section('content')

{{-- Main content of the document --}}
<main>
    <header>
        <h1>Rediģēt {{$site['name']}}</h1>
    </header>

    {{-- form to edit category instance --}}
    <form method="POST" action="{{ route('site.update', $site['id']) }}" enctype="multipart/form-data">
        {{-- method to use instead of POST --}}
        @method('PUT')
        {{-- cross site request forgery --}}
        @csrf
        {{-- the id --}}
        <input type="hidden" name="id" value="{{$site['id']}}">

        {{-- this is form input field with label --}}
        <div>
            <label for="name">Vietnes nosaukums</label>
            <input 
            id="name"
            {{-- @error directive is fired and adds danger class whenever we get error --}}
            @error('name')
            class="danger"
            @enderror
            type="text"
            name="name"
            {{-- provide old input incase of error --}}
            value="{{old('name') ?? $site['name']}}"
            required
            >

            {{-- if error message --}}
            @error('name')
            <p>{{$errors->first('name')}}</p>
            @enderror
        </div>
        {{-- this is form input field with label --}}
        <div>
            <label for="description">Vietnes Apraksts</label>
            <input 
            id="description"
            {{-- @error directive is fired and adds danger class whenever we get error --}}
            @error('description')
            class="danger"
            @enderror
            type="text"
            name="description"
            {{-- provide old input incase of error --}}
            value="{{old('description') ?? $site['description']}}"
            autofocus>
    
            {{-- if error message --}}
            @error('description')
            <p>{{$errors->first('description')}}</p>
            @enderror
        </div>
        {{-- this is form input field with label --}}
        <div>
            <label for="info_phone">Telefona nr</label>
            <input 
            id="info_phone"
            {{-- @error directive is fired and adds danger class whenever we get error --}}
            @error('info_phone')
            class="danger"
            @enderror
            type="text"
            name="info_phone"
            {{-- provide old input incase of error --}}
            value="{{old('info_phone') ?? $site['info_phone']}}">
    
            {{-- if error message --}}
            @error('info_phone')
            <p>{{$errors->first('info_phone')}}</p>
            @enderror
        </div>
        {{-- this is form input field with label --}}
        <div>
            <label for="info_email">Epasts</label>
            <input 
            id="info_email"
            {{-- @error directive is fired and adds danger class whenever we get error --}}
            @error('info_email')
            class="danger"
            @enderror
            type="text"
            name="info_email"
            {{-- provide old input incase of error --}}
            value="{{old('info_email') ?? $site['info_email']}}">
    
            {{-- if error message --}}
            @error('info_email')
            <p>{{$errors->first('info_email')}}</p>
            @enderror
        </div>
        {{-- this is form input field with label --}}
        <div>
            <label for="info_location">Atrašanās vieta</label>
            <input 
            id="info_location"
            {{-- @error directive is fired and adds danger class whenever we get error --}}
            @error('info_location')
            class="danger"
            @enderror
            type="text"
            name="info_location"
            {{-- provide old input incase of error --}}
            value="{{old('info_location') ?? $site['info_location']}}">
    
            {{-- if error message --}}
            @error('info_location')
            <p>{{$errors->first('info_location')}}</p>
            @enderror
        </div>
        {{-- this is form input field with label --}}
        <div>
            <label for="info_details">Rekvizīti?</label>
            <input 
            id="info_details"
            {{-- @error directive is fired and adds danger class whenever we get error --}}
            @error('info_details')
            class="danger"
            @enderror
            type="text"
            name="info_details"
            {{-- provide old input incase of error --}}
            value="{{old('info_details') ?? $site['info_details']}}">
    
            {{-- if error message --}}
            @error('info_details')
            <p>{{$errors->first('info_details')}}</p>
            @enderror
        </div>
        {{-- this is form input field with label --}}
        <div>
            <label for="logo_img">Vietnes logo</label>
            <input 
            id="logo_img"
            {{-- @error directive is fired and adds danger class whenever we get error --}}
            @error('logo_img')
            class="danger"
            @enderror
            type="file"
            name="logo_img"
            {{-- provide old input incase of error --}}
            {{-- we dont need old input for image --}}
            {{-- value="{{old('image')}}" --}}
            >

            {{-- if error message --}}
            @error('logo_img')
            <p>{{$errors->first('logo_img')}}</p>
            @enderror
        </div>
        {{-- this is form input field with label --}}
        <div>
            <label for="img_description">Bildes apraksts lūdzu:</label>
            <input 
            id="img_description"
            {{-- @error directive is fired and adds danger class whenever we get error --}}
            @error('img_description')
            class="danger"
            @enderror
            type="text"
            name="img_description"
            {{-- provide old input incase of error --}}
            value="{{old('img_description') ?? $site['img_description']}}">
    
            {{-- if error message --}}
            @error('img_description')
            <p>{{$errors->first('img_description')}}</p>
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
    
