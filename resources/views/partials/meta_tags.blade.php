<!-- COMMON TAGS -->
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="language" content="English">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no, user-scalable=no">
<meta name="title" content="{{ $meta_title }}">
<meta name="description" content="{{ $meta_description }}">
<meta name="image" content="{{ asset_cdn('images/logo-sm.png') }}">
<meta name="keywords" content="{{ $keywords }}">
<meta name="robots" content="index, follow">
<meta name="google-site-verification" content="KmEEPaWjgvNoHwoB3EOgb6kJDrSs1LWK8WsThhqpxY0">
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-45604694-10"></script>
<script type="text/javascript">
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'UA-45604694-10');
</script>

<!-- Schema.org for Google -->
<meta itemtype="name" content="{{ $meta_title }}">
<meta itemtype="description" content="{{ $meta_description }}">
<meta itemtype="image" content="{{ asset_cdn('images/logo-sm.png') }}">

<!-- Twitter -->
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="{{ $meta_title }}">
<meta name="twitter:description" content="{{ $meta_description }}">
<meta name="twitter:creator" content="@thetrulymadly">
<!-- Open Graph general (Facebook, Pinterest & Google+) -->
<meta property="og:title" content="{{ $meta_title }}">
<meta property="og:description" content="{{ $meta_description }}">
<meta property="og:url" content="{{ $page_url }}">
<meta property="og:site_name" content="TrulyMadly">
<meta property="fb:admins" content="642669439102365">
<meta property="fb:app_id" content="1442995922596983">
<meta property="og:type" content="website">

{{-- Favicons --}}
<meta name="msapplication-TileColor" content="#0086c9">
<meta name="msapplication-TileImage" content="{{ asset('mstile-144x144.png') }}">

<link rel="manifest" href="{{ asset('manifest.json') }}">
<meta name="theme-color" content="#0086c9">
