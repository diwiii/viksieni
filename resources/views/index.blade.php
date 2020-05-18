@extends('layouts.app')

{{-- <title>Title</title> of the app is set at layouts/app.blade.php --}}
{{-- But if you like you can set it here aswell, uncoment next line--}}
{{-- @section('title', 'Title') --}}

@section('content')
    @section('header')
        @include('layouts.parts.landing.header')
    @endsection

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
@foreach($sections as $section)
    <!-- Section of the main content -->
    <section class="bg-{{$section['accent_color'] ?? 'yellow'}} flip-flop">
        <!-- Media of the section -->
        @isset($section['image'])
        <figure class="media">
            <img
                
                {{--  If we have image sizes--}}
                @if(!empty($section['imageSize']))

                srcset="/storage/uploads/images/{{$section['imageSize'][480]}} 480w,
                        /storage/uploads/images/{{$section['imageSize'][768]}} 768w"
                sizes="(max-width: 580px) 480px,
                        768px"

                @endif
                {{-- this is default --}}
                src="/storage/uploads/images/{{$section['image']['url']}}"

                alt="Daudz, gatavas Smiltsērkšķu eļļas pudelītes."
                title="Smiltsērkšķu eļļa"

                class="border-px15 orange"
            >
        </figure>
        @endisset
        <div class="content">
            <!-- Header of the section -->
            <header>
                <!-- Title of the section -->
                <h1>{{$section['name']}}</h1>
                <p>{{$section['description']}}</p>
            </header>
            <p>
                {{$section['content']}}
            </p>
            
            @if(!empty($section['urls']))
                @foreach($section['urls'] as $url)
                <a href="{{route('root').$url['url']}}" class="button red align-right">{{$url['title']}}</a>
                @endforeach
            @endif
        </div>
    </section>
@endforeach

{{-- 
@foreach($categories as $category)
<!-- Section of the main content -->
<section class="bg-yellow flip-flop">
    <!-- Media of the section -->
    <figure class="media">
        <img
            srcset="img/zemenu-smilts-sirups-480w.jpeg 480w,
                    img/zemenu-smilts-sirups-768w.jpeg 768w"
            sizes="(max-width: 580px) 480px,
                    768px"
            src="img/zemenu-smilts-sirups-768w.jpeg"

            alt="Daudz, gatavas Smiltsērkšķu eļļas pudelītes."
            title="Smiltsērkšķu eļļa"

            class="border-px15 orange"
        >
    </figure>
    <div class="content">
        <!-- Header of the section -->
        <header>
            <!-- Title of the section -->
            <h1>{{$category['name']}}</h1>
        </header>
        <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Aspernatur laborum voluptatem fuga. Ipsum ducimus sequi dolores amet dolorum qui cumque? Reiciendis explicabo soluta reprehenderit rem. Dolorem ipsa beatae culpa quidem!
        </p>
    </div>
</section>
@endforeach --}}

{{-- Šis ir paraugs produktu listingam --}}
{{-- @foreach($products as $product)
    <section id="{{$product['slug']}}">
        <!-- Header of the section -->
        <header>
            <!-- Title of the section -->
            <h1>{{$product['name']}}</h1>
            <nav>
                <!-- List of navigation items -->
                <ul>
                    <li>
                        <a href="#!">To the top</a>
                    </li>
                </ul>
            </nav>
        </header>
        <p>{{$product['description']}}</p>
    </section>
@endforeach --}}
</main>

@endsection