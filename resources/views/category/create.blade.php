@extends('layouts.app')
{{-- Title of the app or resource <title>App</title> --}}
@section('title', 'Pievienot jaunu kategoriju')

@section('content')

{{-- Main content of the document --}}
<main>
    <header>
        <h1>Pievienot jaunu kategoriju</h1>
    </header>
    <form method="POST" action="{{route('category.store')}}">
        {{-- cross site request forgery --}}
        @csrf

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
            value="{{old('name')}}"
            required>
    
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
            value="{{old('arrangement')}}">
    
            {{-- if error message --}}
            @error('arrangement')
            <p>{{$errors->first('arrangement')}}</p>
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