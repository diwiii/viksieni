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
@foreach($categories as $category)
    <!-- Section of the main content -->
    <section class="bg-green vh100 green2">
        <header class="flexbox column stretchX maxWidth1024">
            <!-- Title of the section -->
            <h1 class="">{{$category['name']}}</h1>
            @if(!empty($category['description']))
            <p>
                {{$category['description']}}
            </p>
            @endif
        </header>
        <!-- List of items -->
        <ul class="list maxWidth1024">
            @foreach($category['products'] as $product)
            <!-- Single item -->
            <li>
                {{-- {{dd($product['image']['url'])}} --}}
                @if(!empty($product['image']))
                {{-- {{dd($product)}} --}}
                <!-- Item media -->
                <figure>
                    <img class="border-px15 green box-shadow"
                        style="max-width:380px"  
                        {{--  If we have image sizes--}}
                        @if(!empty($product['imageSize']))

                        srcset="/storage/uploads/images/{{$product['imageSize'][480]}} 480w,
                                /storage/uploads/images/{{$product['imageSize'][768]}} 768w"
                        sizes="(max-width: 580px) 480px,
                                768px"

                        @endif
                        {{-- this is default --}}
                        src="/storage/uploads/images/{{$product['image']['url']}}"

                        alt="Daudz, gatavas Smiltsērkšķu eļļas pudelītes."
                        title="Smiltsērkšķu eļļa"

                        class="border-px15 orange"
                    >
                </figure>
                @endif
                <!-- Item title -->
                <h2>{{$product['name']}}</h2>
                <p class="description">{{$product['description']}}</p>
                <!-- Item details -->
                <div class="flexbox row">
                    <p>{{$product['quantity']}} ml</p>
                    <p>{{$product['price']}} €</p>
                    <a href="" class="button green align-right">Pasūtīt</a>
                </div>
            </li>
            @endforeach
        </ul>
    </section>
@endforeach
</main>

@endsection