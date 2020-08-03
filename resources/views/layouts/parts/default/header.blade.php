<!-- Head content of the site, includes main navigation -->
<header id="sakne" class="small-header bg-green">
    <!-- Logo -->
    <figure id="logo" class="">
        <a href="{{route('root')}}">
            <img class="item-center maxWidth512 width100 ieFIXgrowShrink0 ieFIXwidth" src="/storage/{{$siteLogo}}" alt="{{$siteLogoDescription}}" title="Viksieni">
        </a>
        <div class="">
            <!-- Title -->
            <h1 style="display: none;">{{ $siteName ?? config('app.name')}}</h1><!-- Because we have .svg logo title -->
            <!-- Description -->
            <p class="description">{{ $siteDescription ?? 'Do you need description?'}}</p>
        </div>
    </figure>
    <!-- Main Navigation -->
    <nav id="nav" class="">
        <ul class="main-nav">
                
            <li>
                <a href="tel:+37126437844" class="button green2" target="_blank" title="Zvanīt saimniecei" rel="noopener noreferrer"><i class="material-icons" style="vertical-align: middle;">phone_enabled</i></a>
            </li>
            <li>
                {{-- <a href="#pastilas" class="button green2" title="Rakstīt saimniecei"><i class="material-icons" style="vertical-align: middle;">mail</i></a> --}}
                <a href="mailto:viksieni@gmail.com" class="button green2" title="Rakstīt saimniecei">viksieni@gmail.com</a>
            </li>
            {{-- <li>
                <a href="#ellas" class="button green2">Pasūtīt</a>
            </li>
            <li>
                <a href="{{route('darinajumi.index')}}" class="button green2">Darinājumi</a>
            </li> --}}
        </ul>

        {{-- Content navigation pagaidām atliekam --}}
        {{-- Tagad šo izmantojam kā main navigation --}}
        {{-- Content navigation --}}
        @yield('content-nav')

        {{-- if we have login --}}
        @if(Auth::user())
            {{(Auth::user()->name)}}
            <a href="{{route('product.create')}}">Create product</a>
            <a href="{{route('category.create')}}">Create category</a>
            <a href="/logout">Logout</a>
        @endif
    </nav>
</header>