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
    <section id="{{$category['slug']}}" class="bg-green vh100 green2">
        <header class="flexbox column stretchX maxWidth1024">
            <!-- Title of the section -->
            <h1 class="">{{$category['name']}}</h1>
            @if(!empty($category['description']))
            <p>
                {{$category['description']}}
            </p>
            @endif
            <ul class="flexbox">
                @forelse($category['products'] as $product)
                    <li><a href="#{{$product['slug']}}">{{$product['name']}}</a></li>    
                    

                    @empty
                    <li>Šajā kategorijā nav darinājumu</li>
                @endforelse
            </ul>
        </header>
        <!-- List of items -->
        <ul class="list maxWidth1024">
            @foreach($category['products'] as $product)
            <!-- Single item -->
            <li id="{{$product['slug']}}">
            
                @isset($product->image()->url)
                            
                <!-- Item media -->
                <figure>
                    <img class="border-px15 green box-shadow"
                        {{-- Please add check if we have image sizes --}}
                        srcset="/storage/uploads/images/480/{{$product->image()->url}} 480w,
                                /storage/uploads/images/768/{{$product->image()->url}} 768w"
                        sizes="(max-width: 580px) 480px,
                                768px"
                        {{-- this is default image--}}
                        src="/storage/uploads/images/{{$product->image()->url}}"

                        alt="{{$product->image()->description}}"
                        title="{{$product->image()->name}}"

                        class="border-px15 orange"
                    >
                </figure>
                @endisset
                <!-- Item title -->
                <div class="">
                    <h2 style="display:inline-block">{{$product['name']}}</h2>
                    <!-- Back to the top button -->
                    <a href="#sakne"><i class="material-icons">arrow_upward</i></a>
                </div>
                <p class="description">{{$product['description']}}</p>
                <!-- Item details -->
                <div class="flexbox row">
                    <p>{{$product['volume']}} ml</p>
                    <p>{{$product['price']}} €</p>
                </div>
                <!-- Item buttons -->
                <div>
                    @if($product['inCart'])
                        <form method="POST" action="{{route('grozs.delete', $product['slug'])}}" enctype="multipart/form-data">
                            {{-- method to use instead of POST --}}
                            @method('DELETE')
                            {{-- cross site request forgery --}}
                            @csrf
            
                            <button type="submit" class="button red">Izņemt no groza</button>
                        </form>
                        <a href="{{route('grozs.index')}}" class="button green align-right">Grozs</a>
                    @else
                        <a href="{{route('grozs.add', $product['slug'])}}" class="button green align-right">Ielikt grozā</a>
                    @endif
                </div>
            </li>
            @endforeach
        </ul>
    </section>
@endforeach
</main>

@endsection