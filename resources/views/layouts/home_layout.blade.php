<!DOCTYPE html>
<html lang="en">
<head>
    <link href="{{ mix('css/vendor.css') }}" rel="stylesheet">
    <link href="{{ mix('css/covid_'.config('corona.theme').'.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sp-1.0.1/datatables.min.css"/>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="canonical" href="{{ request()->get('canonicalUrl') ?? $url }}"/>
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <meta name="robot" content="all">

    <title>{{ $title }}</title>

    @include('partials.meta_tags_covid', ['meta_title' => $title, 'meta_description' => $description, 'keywords' => $keywords, 'page_url' => $url ])
</head>
<body data-spy="scroll" data-target="#covid-nav" data-offset="200">

@include('partials.header')

<div class="container-fluid">
    @yield('content')
</div>

@include('partials.footer')

@include('partials.scripts')

@yield('scrips')

</body>
</html>
