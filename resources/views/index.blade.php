@php
    $hideLocale = false;
    $pageSections = [
        ['url' => 'plasma/request', 'title' => 'plasma.request_plasma', 'icon' => 'fa-ambulance', 'color' => 'text-secondary'],
        ['url' => 'plasma/donate', 'title' => 'plasma.donate_plasma', 'icon' => 'fa-heartbeat'],
        //['section' => '#clusters', 'title' => 'clusters', 'active' => true],
        ['section' => '#data', 'title' => 'data'],
        ['url' => 'corona-testing-per-day-india', 'title' => 'corona_testing'],
        //['section' => '#timeline', 'title' => 'timeline'],
        ['section' => '#help_links', 'title' => 'help_links'],
    ];
@endphp

@extends('layouts.home_layout')

@section('content')
    @include('components.breadcrumbs')
    <div class="row" id="clusters">
        {{-- Stats (Desktop Position 4)--}}
        <div class="col-12 col-lg-6 order-lg-2">
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="alert bg-danger-trans mb-0 mt-3 mt-lg-0">
                        <strong>
                            {{ trans('corona.lastest_update_text', ['location' => $aggregateData['location'] ?? trans('corona.places.some_area'), 'time_ago' => $aggregateData['time_ago']]) }}
                        </strong>
                    </div>
                </div>
                <div class="col-12 card-stats">
                    <div class="card-deck">
                        @include('partials.stats', ['title' => 'confirmed', 'color' => 'danger', 'count' => $aggregateData['confirmed'], 'countDelta' => $aggregateData['delta_confirmed'] ?? 0])
                        @include('partials.stats', ['title' => 'active', 'color' => 'primary', 'count' => $aggregateData['active'], 'countDelta' => $aggregateData['delta_active'] ?? 0])
                    </div>
                    <div class="card-deck">
                        @include('partials.stats', ['title' => 'recovered','color' => 'success',  'count' => $aggregateData['recovered'], 'countDelta' => $aggregateData['delta_recovered'] ?? 0])
                        @include('partials.stats', ['title' => 'deaths','color' => 'dark',  'count' => $aggregateData['deaths'], 'countDelta' => $aggregateData['delta_deaths'] ?? 0])
                    </div>
                </div>
            </div>
        </div>

        {{-- SEO Content --}}
        <div class="col-12 col-lg-6 mb-3 order-lg-1">
            @include('partials.content', ['title' => trans('corona.page.home.h1', $aggregateData), 'body' => trans('corona.page.home.p1', $aggregateData)])
        </div>
    </div>

    <hr>

    <div class="row" id="data">
        <div class="col-12 mb-3">
            <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
                @if($templateType === 'state')
                    <li class="nav-item">
                        <a class="nav-link active" id="district-data-tab" data-toggle="tab" href="#district-data" role="tab"
                           aria-controls="district wise data" aria-selected="true">{{ trans('corona.district_wise_data') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="city-data-tab" data-toggle="tab" href="#city-data" role="tab" aria-controls="city wise data"
                           aria-selected="true">{{ trans('corona.city_wise_data') }}</a>
                    </li>
                @elseif($templateType === 'country')
                    <li class="nav-item">
                        <a class="nav-link active" id="state-data-tab" data-toggle="tab" href="#state-data" role="tab" aria-controls="state wise data"
                           aria-selected="true">{{ trans('corona.state_wise_data') }}</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="tab-content">
                {{-- GROUPED DATA --}}
                @includeWhen($templateType === 'state', 'partials.grouped_data', ['group' => 'district', 'groupData' => $districtData, 'active' => true, 'parentUrl' => $url])
                @includeWhen($templateType === 'state', 'partials.grouped_data', ['group' => 'city', 'groupData' => $cityData, 'active' => false, 'parentUrl' => $url])
                @includeWhen($templateType === 'country', 'partials.grouped_data', ['group' => 'state', 'groupData' => $stateData, 'active' => true, 'parentUrl' => $url])
            </div>
        </div>
    </div>

    @if(!empty($timeline))
        @include('components.timeline_tracks', ['timeline' => $timeline, 'location' => $aggregateData['location']])

        <div class="w-100 py-3 text-center">
            <a href="{{ request()->localeUrl ?? '' }}timeline"><i class="fas fa-1x fa-angle-double-right"></i> {{ trans('corona.timeline_link') }}</a>
        </div>
    @endif
@endsection

@section('scrips')
    <script src="{{ mix_cdn('js/corona.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            @if($templateType === 'country')
            $('#state-data-table').DataTable({
                "paging": false,
                "scrollY": '70vh',
                "scrollX": true,
                "scrollCollapse": true,
                "scroller": true,
                "dom": 't',
                "order": [[1, "desc"]]
            });
            @endif

            {{-- GROUPED DATA --}}
            @if($templateType === 'state')
            $('#city-data-table').DataTable({
                "paging": false,
                "scrollY": '70vh',
                "scrollX": true,
                "scrollCollapse": true,
                "scroller": true,
                "dom": 't',
                "order": [[1, "desc"]]
            });

            $('#district-data-table').DataTable({
                "paging": false,
                "scrollY": '70vh',
                "scrollX": true,
                "scrollCollapse": true,
                "scroller": true,
                "dom": 't',
                "order": [[1, "desc"]]
            });
            @endif

            $('.dataTables_wrapper').css('height', $(window).height() - 145);
            $(window).resize(function () {
                $('.dataTables_wrapper').css('height', $(window).height() - 145);
            });
        });
    </script>

@endsection
