@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!

                </div>
            </div>
        </div>
    </div>
</div>

<div>
    <h1>Omniva json:</h1>
    <form method="POST" action="{{route('omniva.locations')}}">
        @csrf {{-- cross site request forgery --}}
        {{-- this is form input field with label --}}
        <div>
            <label for="url">json location:</label>
            <input 
            id="url"
            {{-- @error directive is fired and adds danger class whenever we get error --}}
            @error('url')
            class="danger"
            @enderror
            type="text"
            name="url"
            {{-- provide old input incase of error --}}
            value="{{old('url') ?? 'https://www.omniva.ee/locations.json'}}"
            >

            {{-- if error message --}}
            @error('url')
            <p>{{$errors->first('url')}}</p>
            @enderror
        </div>
        <button type="submit">Filtrēt LV pilsētas</button>
    </form>
</div>
@endsection
