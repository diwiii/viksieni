@extends('layouts.app')

{{-- Title of the app or resource <title>App</title> --}}
@section('title', $siteName . ' - Pievienot jaunu preci')

@section('content')

{{-- Main content of the document --}}
<main>
    <header>
        <h1>Pievienot jaunu preci</h1>
        {{-- iespēja izvēlēties ēdienu kategorijas --}}
        <ul>
            @foreach ($categories as $category)
            <li>{{$category['name']}}, id: {{$category['id']}}</li>
            @endforeach
        </ul>
    </header>
    <form method="POST" action="/product" enctype="multipart/form-data">
        {{-- cross site request forgery --}}
        @csrf

        {{-- THE SLUG ERROR --}}
        @error('slug')
        <p>{{$errors->first('slug')}}</p>
        @enderror
        
        {{-- this is form input field with label --}}
        <div>
            <label for="category_id">Preces iedalījums?</label>
            <input 
            id="category_id"
            {{-- @error directive is fired and adds danger class whenever we get error --}}
            @error('category_id')
            class="danger"
            @enderror
            type="text"
            name="category_id"
            {{-- provide old input incase of error --}}
            value="{{old('category_id')}}"
            required
            autofocus>

            {{-- if error message --}}
            @error('category_id')
            <p>{{$errors->first('category_id')}}</p>
            @enderror
        </div>
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
            <label for="volume">Preces tilpums</label>
            <input 
            id="volume"
            {{-- @error directive is fired and adds danger class whenever we get error --}}
            @error('volume')
            class="danger"
            @enderror
            type="text"
            name="volume"
            {{-- provide old input incase of error --}}
            value="{{old('volume')}}">
    
            {{-- if error message --}}
            @error('volume')
            <p>{{$errors->first('volume')}}</p>
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