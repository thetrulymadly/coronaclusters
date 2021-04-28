
@section('styles')
    <link href="{{ mix_cdn('css/select2.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
@endsection

<!DOCTYPE html>
<html>
<head>
    <style>
        .gfg {
            margin: 3%;
            position: relative;
        }

        .first-txt {
            position: absolute;
            top: 45%;
            left: 4%;
            color: white;
        }

        .second-txt {
            position: absolute;
            bottom: 20px;
            left: 10px;
        }
        
    </style>
</head>

<body>
<div class="gfg">
    <img src="/storage/shareable_image.png" width="400" height="400">

    <h3 class="first-txt">
        {{$name}}
    </h3>

    <h3 class="second-txt">

    </h3>
</div>
</body>

</html>
