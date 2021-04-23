@php
    $hideLocale = true;
    $requestActive = $donorType === \App\Dictionary\PlasmaDonorType::REQUESTER;
    $nav = [
        'current_page' => $requestActive ? 'plasma/requests' : 'plasma/donors',
    ];
@endphp
@extends('layouts.home_layout')

@section('content')
    @include('components.breadcrumbs')

    <div class="row" id="plasma_donors">
        <div class="col-12">
            @if($donorType === \App\Dictionary\PlasmaDonorType::DONOR)
                @include('components.plasma.donor_requester_list', ['donors' => $donors, 'requesters' => false, 'detailed' => true])
            @else
                @include('components.plasma.donor_requester_list', ['donors' => $donors, 'requesters' => true, 'detailed' => true])
            @endif
        </div>
    </div>
@endsection

@section('scrips')
    {{--    <script src="{{ mix_cdn('js/corona.js') }}"></script>--}}

    {{--    <script type="text/javascript">--}}

    {{--        $(document).ready(function () {--}}
    {{--            $('#testing-data-table').DataTable({--}}
    {{--                "paging": false,--}}
    {{--                "scrollY": '60vh',--}}
    {{--                "scrollX": true,--}}
    {{--                "scrollCollapse": true,--}}
    {{--                "scroller": true,--}}
    {{--                "dom": 't',--}}
    {{--                "order": [[1, "desc"]]--}}
    {{--            });--}}

    {{--            $('.dataTables_wrapper').css('height', $(window).height() - 145);--}}
    {{--            $(window).resize(function () {--}}
    {{--                $('.dataTables_wrapper').css('height', $(window).height() - 145);--}}
    {{--            });--}}
    {{--        });--}}
    {{--    </script>--}}
@endsection
