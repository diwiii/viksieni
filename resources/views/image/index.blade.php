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
        <th>thumbnail</th>
        <th>url</th>
        <th>name</th>
        <th>description</th>
        <th>created_at</th>
        <th>updated_at</th>
        @auth
        <th>destroy</th>
        @endauth
    </tr>
@foreach ($images as $image)
    <tr>
        @auth
        <td><a href="{{route('image.edit', $image->id)}}">Rediģēt</a></td>
        @endauth
        <td>{{$image->id}}</td>
        <td><img src="{{url('/storage/uploads/images/'.$image->url)}}" alt="{{$image->description}}" height="100"></td>
        <td><a href="{{url('/storage/uploads/images/'.$image->url)}}">{{url('/storage/uploads/images/'.$image->url)}}</a></td>
        <td>{{$image->name}}</td>
        <td>{{$image->description}}</td>
        <td>{{$image->created_at}}</td>
        <td>{{$image->updated_at}}</td>
        @auth
        <td>
            @component('delete')
                @slot('route')
                {{ route('image.destroy', $image->id) }}
                @endslot
            @endcomponent
        </td>
        @endauth
    </tr>
@endforeach
</table>
</main>

@endsection