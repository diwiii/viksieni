@extends('layouts.app')

{{-- Title of the app or resource <title>App</title> --}}
@section('title', $siteName . ' - Rediģēt ' . $product['name'])

@section('content')

{{-- Main content of the document --}}
<main>
    <header>
        <h1>Rediģēt {{$product['name']}}</h1>
        {{-- Lūdzu iespēju izvēlēties kategorijas --}}
        <ul>
            @foreach ($categories as $category)
            <li>{{$category['name']}}, id: {{$category['id']}}</li>
            @endforeach
        </ul>
    </header>
    
    {{-- form to edit product instance --}}
    <form method="POST" action="{{route('product.update', $product['slug'])}}" enctype="multipart/form-data">
        {{-- method to use instead of POST --}}
        @method('PUT')
        {{-- cross site request forgery --}}
        @csrf
        {{-- the id --}}
        <input type="hidden" name="id" value="{{$product['id']}}">

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
            value="{{old('slug') ?? $product['slug']}}"
            >

            {{-- if error message --}}
            @error('slug')
            <p>{{$errors->first('slug')}}</p>
            @enderror
        </div>
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
            value="{{old('category_id') ?? $product['category_id']}}"
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
            value="{{old('name') ?? $product['name']}}"
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
            value="{{old('price') ?? $product['price']}}">
    
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
                        rows="10">{{old('description') ?? $product['description']}}</textarea>
    
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

    <img src="/storage/{{$product['image']}}" alt="">

    {{-- ASIDE --}}
    {{-- Pārtulkot latviski error fieldus php un html --}}
    
    {{-- side comments for category forms --}}
    {{-- remove category --}}
    {{-- if last add new category --}}
    {{-- ASIDE --}}
</main>

@endsection