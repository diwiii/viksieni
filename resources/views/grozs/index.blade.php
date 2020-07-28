@extends('layouts.app')

{{-- <title>Title</title> of the app is set at layouts/app.blade.php --}}
{{-- But if you like you can set it here aswell, uncoment next line--}}
{{-- @section('title', 'Title') --}}

@section('content')
<table>

    <tr>
        <td>
            <h3>Nosaukums</h3>
        </td>
        <td>
            <h3>Tilpums (ml)</h3>
        </td>
        <td>
            <h3>Daudzums</h3>
        </td>
        <td>
            <h3>Cena</h3>
        </td>
    </tr>

@forelse($grozs as $item)

    <tr>
        <td>
            <p>{{$item->name}}</p>
        </td>
        <td>
            <p>{{$item->attributes->volume}}</p>
        </td>
        <td>
            <div class="flexbox">
            <form method="POST" action="{{route('grozs.update', $item->attributes->slug)}}" enctype="multipart/form-data">
                {{-- method to use instead of POST --}}
                @method('PUT')
                {{-- cross site request forgery --}}
                @csrf

                {{-- decrease value --}}
                <input type="hidden" name="do" value="decrease">

                <button type="submit">Mazāk</button>
            </form>

            <p>{{$item->quantity}}</p>

            <form method="POST" action="{{route('grozs.update', $item->attributes->slug)}}" enctype="multipart/form-data">
                {{-- method to use instead of POST --}}
                @method('PUT')
                {{-- cross site request forgery --}}
                @csrf

                {{-- increase value --}}
                <input type="hidden" name="do" value="increase">
                
                <button type="submit">Vairāk</button>
            </form>
            </div>
        </td>
        <td>
            <p>{{ number_format($item->price, 2, '.', '') }} €</p>
        </td>
        <td>
            <form method="POST" action="{{route('grozs.delete', $item->attributes->slug)}}" enctype="multipart/form-data">
                {{-- method to use instead of POST --}}
                @method('DELETE')
                {{-- cross site request forgery --}}
                @csrf

                <button type="submit">Izņemt no groza</button>
            </form>
        </td>
    </tr>

@empty
    <p>Grozs ir tukšs!</p>
@endforelse
{{-- Pārāk ilgi nočakarējies pie šī --}}
@if($total !== "0.00")
    <tr>
        <td colspan="2">Kopā:</td>
        <td >{{number_format($total, 2, '.', '')}} €</td>
    </tr>
@endif
</table>


    @if(session()->get('parcelMachine'))
    <h2>
        {{session()->get('parcelMachine')['NAME']}}
        {{session()->get('parcelMachine')['X_COORDINATE']}}
        {{session()->get('parcelMachine')['Y_COORDINATE']}}
    </h2>
    <a href="{{route('omniva.index')}}">Izvēlēties citu pakomātu</a>
    @else
        <a href="{{route('omniva.index')}}">Izvēlēties Omniva pakomātu</a>
    @endif


@endsection