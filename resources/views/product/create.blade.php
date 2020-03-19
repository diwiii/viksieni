@extends('layouts.app')

{{-- Title of the app or resource <title>App</title> --}}
@section('title', 'Pievienot jaunu preci')

@section('content')

{{-- Main content of the document --}}
<main>
    <form method="POST" action="/product" enctype="multipart/form-data">
        {{-- cross site request forgery --}}
        @csrf

        {{-- this is form input field with label --}}
        <div>
            <label for="name">Preces nosaukums</label>
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
            required>
    
            {{-- if error message --}}
            @error('name')
            <p>{{$errors->first('name')}}</p>
            @enderror
        </div>
        {{-- this is form input field with label --}}
        <div>
            <label for="price">Preces cena</label>
            <input 
            id="price"
            {{-- @error directive is fired and adds danger class whenever we get error --}}
            @error('price')
            class="danger"
            @enderror
            type="text"
            name="price"
            {{-- provide old input incase of error --}}
            value="{{old('price')}}">
    
            {{-- if error message --}}
            @error('price')
            <p>{{$errors->first('price')}}</p>
            @enderror
        </div>
        {{-- this is form input field with label --}}
        <div>
            <label for="description">Preces apraksts</label>
            <textarea   id="description"
                        @error('description')
                        class="danger"
                        @enderror
                        name="description"
                        cols="30"
                        rows="10">{{old('description') ?? ''}}</textarea>
    
            {{-- if error message --}}
            @error('description')
            <p>{{$errors->first('description')}}</p>
            @enderror
        </div>
        {{-- this is form input field with label --}}
        <div>
            <label for="image">Preces bilde</label>
            <input 
            id="image"
            {{-- @error directive is fired and adds danger class whenever we get error --}}
            @error('image')
            class="danger"
            @enderror
            type="file"
            name="image"
            {{-- provide old input incase of error --}}
            value="{{old('image')}}">
    
            {{-- if error message --}}
            @error('image')
            <p>{{$errors->first('image')}}</p>
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