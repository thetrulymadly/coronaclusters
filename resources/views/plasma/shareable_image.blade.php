<!DOCTYPE html>
<html>
<head>
    <link href="{{ mix_cdn('css/covid_'.config('corona.theme').'.css') }}" rel="stylesheet">
    <link rel="canonical" href="{{ request()->get('canonicalUrl') ?? $url }}"/>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.5/dist/html2canvas.min.js"></script>

    <meta name="robot" content="all">

    @yield('styles')
    <style>
        .gfg {
            margin: 3%;
            top: 60%;
            position: absolute;
        }

        .first-txt {
            position: absolute;
            top: 48%;
            left: 10%;
            color: white;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="gfg" id="imagewrap">
    <a id="downloadBanner" download>
        <img id="shareableImage" src="/storage/shareable_image.png" width="400" height="400">
    </a>
    <h6 class="first-txt">
        {{$name}}
    </h6>
</div>
</body>

<script type="module">

   let div =
       document.getElementById('imagewrap');

   html2canvas(div).then(
       function (canvas) {
           document.getElementById("downloadBanner").href = canvas.toDataURL();
       })

</script>

</html>
