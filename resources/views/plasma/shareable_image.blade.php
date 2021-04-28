<!DOCTYPE html>
<html>
<head>
    <link href="{{ mix_cdn('css/covid_'.config('corona.theme').'.css') }}" rel="stylesheet">
    <link rel="canonical" href="{{ request()->get('canonicalUrl') ?? $url }}"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
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
    <img id="shareableImage" src="/storage/shareable_image.png" width="400" height="400">

    <h6 class="first-txt">
        {{$name}}
    </h6>
</div>

<div id="canvasWrapper" class="outer">
    <p>Canvas-rendered (try right-click, save image as!)</p>
    <p>Or, <a id="downloadLink" download="cat.png">Click Here to Download!</a>
</div>

</body>

    <script type="module">
        window.onload = function () {
            html2canvas(document.getElementById("imagewrap"), {
                onrendered: function (canvas) {
                    canvas.className = "html2canvas";
                    document.getElementById("canvasWrapper").appendChild(canvas);
                    var image = canvas.toDataURL("image/png");
                    document.getElementById("downloadLink").href = image;
                },
                useCORS: false,
            });
        }
    </script>

</html>
