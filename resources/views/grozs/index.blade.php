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
            <p>{{$item->quantity}}</p>
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

@endsection