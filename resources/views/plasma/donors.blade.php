@php
    $pageSections = [
        ['url' => '#clusters', 'title' => 'clusters'],
        ['url' => '#data', 'title' => 'data'],
        //['url' => 'timeline', 'title' => 'timeline'],
        ['section' => '#corona-testing-per-day-india', 'title' => 'corona_testing', 'active' => true],
        ['section' => '#help_links', 'title' => 'help_links'],
    ];
@endphp
@extends('layouts.home_layout')

@section('content')
    @include('components.breadcrumbs')

    <div class="row" id="plasma_donors">

        {{-- Last Update & Stats (Desktop Position 2) --}}
        <div class="col-12 col-lg-6 order-lg-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title m-0">Plasma Donors</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($donors as $donor)
                            <li class="list-group-item">
                                <span>{{ $donor->gender }}</span>
                                <span>{{ $donor->age }}</span>
                                <span>{{ $donor->blood_group }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
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
