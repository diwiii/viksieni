@extends('layouts.app')

{{-- <title>Title</title> of the app is set at layouts/app.blade.php --}}
{{-- But if you like you can set it here aswell, uncoment next line--}}
{{-- @section('title', 'Title') --}}

@section('content')

    {{-- This is nav in the header section of the body --}}
    @section('content-nav')
    @parent

    {{-- Šis ir paraugs --}}
        {{-- <ul>
        @foreach($categories as $category)
            <li>
                <a href="#{{$category['slug']}}">{{$category['name']}}</a>
                <a href="/category/edit/{{$category['slug']}}">Edit</a>
                <a href=""></a>
                @component('delete')
                    @slot('route')
                    {{ route('category.destroy', $category['slug']) }}
                    @endslot
                @endcomponent
                <ul>
                    @foreach($category['products'] as $product)
                        <li>
                            {{ $product['name'] }} <a href="/product/edit/{{$product['slug']}}">Edit</a>
                            @component('delete')
                                @slot('route')
                                {{ route('product.destroy', $product['slug']) }}
                                @endslot
                            @endcomponent
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
        </ul> --}}
    @endsection

{{-- Main content of the document --}}
<main>
<table>
    <tr>
        @auth
        <th>edit</th>
        @endauth
        <th>id</th>
        <th>slug</th>
        <th>image</th>
        <th>name</th>
        <th>description</th>
        <th>content</th>
        <th>accent_color</th>
        <th>arrangement</th>
        <th>created_at</th>
        <th>updated_at</th>
        @auth
        <th>destroy</th>
        @endauth
    </tr>
@foreach ($sections as $section)
    <tr>
        @auth
        <td><a href="{{route('section.edit', $section->slug)}}">Rediģēt</a></td>
        @endauth
        <td>{{$section->id}}</td>
        <td>{{$section->slug}}</td>
        <td>
            <a href="{{url(route('section.edit', $section->slug).'?select=image')}}">select image</a>
        </td>
        <td>{{$section->name}}</td>
        <td>{{$section->description}}</td>
        <td>{{$section->content}}</td>
        <td>{{$section->accent_color}}</td>
        <td>{{$section->arrangement}}</td>
        <td>{{$section->created_at}}</td>
        <td>{{$section->updated_at}}</td>
        @auth
        <td>
            @component('delete')
                @slot('route')
                {{ route('section.destroy', $section->slug) }}
                @endslot
            @endcomponent
        </td>
        @endauth
    </tr>
@endforeach
</table>
</main>

@endsection