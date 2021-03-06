@extends('layouts.app')

{{-- Title of the app or resource <title>App</title> --}}
@section('title', $siteName . ' - Izveidot Section <- kā būtu latviski?')

@section('content')

{{-- Main content of the document --}}
<main>
    <header>
        <h1>Izveidot Section</h1>
    </header>

    <form method="POST" action="{{ route('section.store') }}" enctype="multipart/form-data">
        {{-- cross site request forgery --}}
        @csrf

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
            value="{{old('slug')}}"
            >

            {{-- if error message --}}
            @error('slug')
            <p>{{$errors->first('slug')}}</p>
            @enderror
        </div>
        {{-- this is form input field with label --}}
        <div>
            <label for="name">Section title</label>
            <input 
            id="name"
            {{-- @error directive is fired and adds danger class whenever we get error --}}
            @error('name')
            class="danger"
            @enderror
            type="text"
            name="name"
            {{-- provide old input incase of error --}}
            value="{{old('name')}}"
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
            value="{{old('arrangement')}}">
    
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
            value="{{old('description')}}">
    
            {{-- if error message --}}
            @error('description')
            <p>{{$errors->first('description')}}</p>
            @enderror
        </div>
        {{-- this is form input field with label --}}
        <div>
            <label for="content">Saturs</label>
            <textarea   id="content"
                        @error('content')
                        class="danger"
                        @enderror
                        name="content"
                        cols="30"
                        rows="10">{{old('content') ?? ''}}</textarea>
    
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
            value="{{old('accent_color')}}">
    
            {{-- if error message --}}
            @error('accent_color')
            <p>{{$errors->first('accent_color')}}</p>
            @enderror
        </div>

        <button type="submit">Pievienot</button>
    </form>

    {{-- ASIDE --}}
    {{-- Pārtulkot latviski error fieldus php un html --}}
    
    {{-- side comments for category forms --}}
    {{-- remove category --}}
    {{-- if last add new category --}}
    {{-- ASIDE --}}
</main>

@endsection