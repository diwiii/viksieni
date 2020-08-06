@extends('layouts.app')

{{-- Title of the app or resource <title>App</title> --}}
@section('title', $siteName . ' - Rediģēt bildi')

@section('content')

{{-- Main content of the document --}}
<main>
    <header>
        <h1>Rediģēt bildi ar id: {{$image->id}}</h1>
        <div>
            <a href="{{route('image.index')}}">Bilžu saraksts</a>
        </div>
    </header>
    <form method="POST" action="{{ route('image.update', $image->id) }}" enctype="multipart/form-data">
        {{-- method to use instead of POST --}}
        @method('PUT')
        {{-- cross site request forgery --}}
        @csrf
        {{-- the id --}}
        <input type="hidden" name="id" value="{{$image->id}}">

        {{-- THE SLUG ERROR --}}
        @error('slug')
        <p>{{$errors->first('slug')}}</p>
        @enderror
        <div>
            <img src="{{url('/storage/uploads/images/480/'.$image->url)}}" alt="{{$image->description}}">
        </div>
        {{-- this is form input field with label --}}
        <div>
            <label for="name">Bildes nosaukums</label>
            <input 
            id="name"
            {{-- @error directive is fired and adds danger class whenever we get error --}}
            @error('name')
            class="danger"
            @enderror
            type="text"
            name="name"
            {{-- provide old input incase of error --}}
            value="{{old('name') ?? $image->name}}"
            autofocus>
    
            {{-- if error message --}}
            @error('name')
            <p>{{$errors->first('name')}}</p>
            @enderror
        </div>
        {{-- this is form input field with label --}}
        <div>
            <label for="description">Bildes apraksts</label>
            <textarea   id="description"
                        @error('description')
                        class="danger"
                        @enderror
                        name="description"
                        cols="30"
                        rows="10">{{old('description') ?? $image->description}}</textarea>
    
            {{-- if error message --}}
            @error('description')
            <p>{{$errors->first('description')}}</p>
            @enderror
        </div>
        <button type="submit">Saglabāt izmaiņas</button>
    </form>

    @foreach($image->sizes as $size)
    <br>
    {{$size->width}} : <a href="{{(url('/storage/uploads/images/'.$size->url))}}">{{(url('/storage/uploads/images/'.$size->url))}}</a>
    @endforeach

    {{-- ASIDE --}}
    {{-- Pārtulkot latviski error fieldus php un html --}}
    
    {{-- side comments for category forms --}}
    {{-- remove category --}}
    {{-- if last add new category --}}
    {{-- ASIDE --}}
</main>

@endsection