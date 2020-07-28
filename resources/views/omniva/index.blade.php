@extends('layouts.app')

{{-- <title>Title</title> of the app is set at layouts/app.blade.php --}}
{{-- But if you like you can set it here aswell, uncoment next line--}}
{{-- @section('title', 'Title') --}}

@section('content')

<h1>Izvēlieties Omniva pakomātu</h1>

<h2>Meklēt:</h2>
<p></p>

@isset($parcelMachines)
{{-- Take FIRST Parcel Machine and get out original City name from details --}}
<h2>Pilsēta: {{$parcelMachines[0]['A1_NAME'] ?? ''}}</h2>
<a href="{{route('omniva.index')}}">Izvēlēties pilsētu</a>
<table>
    <tr>
        <td><h2>Pakomāta nosaukums</h2></td>
        <td><h2>Pakomāta adrese</h2></td>
    </tr>
    @foreach($parcelMachines as $parcelMachine)
    <tr>
    {{-- {{dd($parcelMachine)}} --}}
    <td><a href="{{url()->full().'&zip='.$parcelMachine['ZIP']}}">{{$parcelMachine['NAME'] ?? ''}}</a></td>
    <td>{{$parcelMachine['A2_NAME'] ?? ''}}</td>
    </tr>
    @endforeach
</table>
@endisset

@isset($cities)
<h2>Pilsētas kurās ir Omniva pakomāti:</h2>
<ul>
@foreach($cities as $cityKey => $parcelMachines)
    <li>
        <a href="{{route('omniva.index')}}?pilseta={{$cityKey}}">
            {{-- Take FIRST Parcel Machine and get out original City name from details --}}
            {{$parcelMachines[0]['A1_NAME'] ?? ''}}
        </a>
    </li>
@endforeach
</ul>
@endisset

@endsection