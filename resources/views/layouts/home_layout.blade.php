<!DOCTYPE html>
<html lang="en">
<head>
    <link href="{{ mix_cdn('css/covid_'.config('corona.theme').'.css') }}" rel="stylesheet">
    <link rel="canonical" href="{{ request()->get('canonicalUrl') ?? $url }}"/>
    <meta name="robot" content="all">

    @yield('styles')

    <title>{{ $title }}</title>

    @include('partials.meta_tags', ['meta_title' => $title, 'meta_description' => $description, 'keywords' => $keywords, 'page_url' => $url ])
</head>
<body data-spy="scroll" data-target="#covid-nav" data-offset="200">

@include('partials.header_v2')

<div class="container-fluid">
    @yield('content')
</div>

@include('partials.footer')

@include('partials.scripts')

@yield('scrips')

</body>
</html>
