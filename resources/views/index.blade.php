@php
    $pageSections = [
        ['section' => '#clusters', 'title' => 'clusters', 'active' => true],
        ['section' => '#data', 'title' => 'data'],
        ['section' => '#timeline', 'title' => 'timeline'],
        ['url' => 'corona-testing-per-day-india', 'title' => 'corona_testing'],
        ['section' => '#help_links', 'title' => 'help_links'],
    ];
@endphp

@extends('layouts.home_layout')

@section('content')
    @include('components.breadcrumbs')
    <div class="row" id="clusters">

        {{-- Last Update (Desktop Position 2) --}}
        <div class="col-12 col-lg-4 mb-3 order-lg-2">
            <div class="alert bg-danger-trans mb-0 mt-3 mt-lg-0">
                <strong>
                    {{ trans('corona.lastest_update_text', ['location' => $aggregateData['location'] ?? trans('corona.places.some_area'), 'time_ago' => $aggregateData['time_ago']]) }}
                </strong>
            </div>
        </div>

        {{-- Stats (Desktop Position 4)--}}
        <div class="col-lg-4 order-lg-4">
            <div class="row">
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
                <div class="col-12 d-none d-lg-block mt-4">
                    @include('partials.content', ['title' => trans('corona.page.home.h1', $aggregateData), 'body' => trans('corona.page.home.p1', $aggregateData)])
                </div>
            </div>
        </div>

        {{-- Maps (Desktop Position 3) --}}
        <div class="col-lg-8 order-lg-3">
            <div id="map"></div>
        </div>

        {{-- Map Note (Desktop Position 5) --}}
        <div class="col-12 col-lg-8 mb-3 order-lg-5">
            <div class="alert bg-info-trans">
                <ul class="mb-0 pl-2">
                    <li>
                        <strong>{{ trans('corona.map_notes.note1') }}</strong>
                    </li>
                    <li>
                        <strong>{{ trans('corona.map_notes.note2') }}</strong>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Advisory text (Desktop Position 1) --}}
        <div class="col-12 col-lg-8 mb-3 order-lg-1" id="data-advisory">
            <div class="alert bg-warning-trans m-0">
                @for($count = 1; $count <= config('corona.advisory_text_count'); $count++)
                    <strong>{{ trans('corona.advisory_text.text'.$count) }}</strong>
                @endfor
            </div>
        </div>

        {{-- SEO Content --}}
        <div class="col-12 mb-3 order-lg-6 d-lg-none">
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
                <li class="nav-item">
                    <a class="nav-link @if($templateType === 'city') active @endif" id="raw-data-tab" data-toggle="tab" href="#raw-data" role="tab"
                       aria-controls="raw data"
                       aria-selected="false">{{ trans('corona.raw_data') }}</a>
                </li>
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
                {{-- RAW DATA --}}
                <div class="tab-pane fade @if($templateType === 'city') show active @endif" id="raw-data" role="tabpanel"
                     aria-labelledby="raw-data-tab">
                    <div class="row">
                        <div class="col-xl-12">
                            <table id="raw-data-table" class="table table-striped table-bordered table-hover table-sm table-light">
                                <thead class="thead-light">
                                <tr>
                                    @foreach(config('corona.table.raw_data') as $dataHeader)
                                        <th scope="col">{{ trans('corona.'.$dataHeader) }}</th>
                                    @endforeach
                                </tr>
                                </thead>
                                @if($templateType !== 'country')
                                    <tbody>
                                    @foreach($rawData as $data)
                                        <tr>
                                            @foreach(config('corona.table.raw_data') as $dataHeader)
                                                @if($dataHeader === 'patientnumber')
                                                    <th scope="row">{{ $data->$dataHeader }}</th>
                                                @elseif($dataHeader === 'source1' || $dataHeader === 'source2' || $dataHeader === 'source3')
                                                    @if(!empty($data[$dataHeader]))
                                                        @php
                                                            $linkName = explode('/', $data[$dataHeader]);
                                                            if (isset($linkName[2])) {
                                                                $linkName = $linkName[2];
                                                            } else {
                                                                $linkName = $data[$dataHeader];
                                                            }
                                                        @endphp
                                                        <td data-order="{{ $linkName }}">
                                                            <a href="{{ $data[$dataHeader] }}">{{ $data[$dataHeader] }}</a>
                                                        </td>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                @elseif($dataHeader === 'detectedstate' || $dataHeader === 'detectedcity' || $dataHeader === 'detecteddistrict')
                                                    <td>{{ $data->$dataHeader }}</td>
                                                @else
                                                    <td>{{ $data->$dataHeader }}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
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
    <script src="{{ mix('js/corona.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            @if($templateType === 'country')
            $('#raw-data-table').DataTable({
                "pagingType": "full_numbers",
                "scrollY": '65vh',
                "scrollX": true,
                "scrollCollapse": true,
                "scroller": true,
                "order": [[0, "asc"]],
                "deferRender": true,
                "ajax": "api/raw_data",
                "columns": [
                    {'data': 'patientnumber'},
                    {'data': 'agebracket'},
                    {'data': 'contractedfromwhichpatientsuspected'},
                    {'data': 'currentstatus'},
                    {'data': 'statepatientnumber'},
                    {'data': 'statuschangedate'},
                    {'data': 'dateannounced'},
                    {'data': 'detectedcity'},
                    {'data': 'detecteddistrict'},
                    {'data': 'detectedstate'},
                    {'data': 'estimatedonsetdate'},
                    {'data': 'gender'},
                    {'data': 'nationality'},
                    {'data': 'notes'},
                    {'data': 'backupnotes'},
                    {'data': 'source1'},
                    {'data': 'source2'},
                    {'data': 'source3'}
                ]
            });
            $('#state-data-table').DataTable({
                "paging": false,
                "scrollY": '70vh',
                "scrollX": true,
                "scrollCollapse": true,
                "scroller": true,
                "dom": 't',
                "order": [[1, "desc"]]
            });
            @else
            $('#raw-data-table').DataTable({
                "pagingType": "full_numbers",
                "scrollY": '65vh',
                "scrollX": true,
                "scrollCollapse": true,
                "scroller": true,
                "order": [[0, "asc"]]
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

    <script type="text/javascript">


        function initMap() {

                @php
                    if (!empty($mapCenter)) {
                        $lat =  $mapCenter[0]['lat'];
                        $lng =  $mapCenter[0]['lng'];
                    } else {
                        $lat = 20.5937;
                        $lng = 78.9629;
                    }

                    switch ($templateType) {
                        case 'country': {$zoom = 4; break;}
                        case 'state': {$zoom = 8; break;}
                        case 'city': {$zoom = 12; break;}
                        default : {$zoom = 4; break;}
                    }
                @endphp

            const center = {lat: Number('{{ $lat }}'), lng: Number('{{ $lng }}')};

            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: Number('{{ $zoom }}'),
                center: center,
                zoomControl: false,
                mapTypeControl: false,
                scaleControl: false,
                streetViewControl: false,
                rotateControl: false,
                fullscreenControl: true,
                styles: [
                    {
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#1d2c4d"
                            }
                        ]
                    },
                    {
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#8ec3b9"
                            }
                        ]
                    },
                    {
                        "elementType": "labels.text.stroke",
                        "stylers": [
                            {
                                "color": "#1a3646"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.country",
                        "elementType": "geometry.stroke",
                        "stylers": [
                            {
                                "color": "#4b6878"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.land_parcel",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.land_parcel",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#64779e"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.neighborhood",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.province",
                        "elementType": "geometry.stroke",
                        "stylers": [
                            {
                                "color": "#4b6878"
                            }
                        ]
                    },
                    {
                        "featureType": "landscape.man_made",
                        "elementType": "geometry.stroke",
                        "stylers": [
                            {
                                "color": "#334e87"
                            }
                        ]
                    },
                    {
                        "featureType": "landscape.natural",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#023e58"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#283d6a"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#6f9ba5"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "labels.text.stroke",
                        "stylers": [
                            {
                                "color": "#1d2c4d"
                            }
                        ]
                    },
                    {
                        "featureType": "poi.business",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "poi.park",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "color": "#023e58"
                            }
                        ]
                    },
                    {
                        "featureType": "poi.park",
                        "elementType": "labels.text",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "poi.park",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#3C7680"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#304a7d"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "labels",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#98a5be"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "labels.text.stroke",
                        "stylers": [
                            {
                                "color": "#1d2c4d"
                            }
                        ]
                    },
                    {
                        "featureType": "road.arterial",
                        "elementType": "labels",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#2c6675"
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "geometry.stroke",
                        "stylers": [
                            {
                                "color": "#255763"
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "labels",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#b0d5ce"
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "labels.text.stroke",
                        "stylers": [
                            {
                                "color": "#023e58"
                            }
                        ]
                    },
                    {
                        "featureType": "road.local",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "transit",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#98a5be"
                            }
                        ]
                    },
                    {
                        "featureType": "transit",
                        "elementType": "labels.text.stroke",
                        "stylers": [
                            {
                                "color": "#1d2c4d"
                            }
                        ]
                    },
                    {
                        "featureType": "transit.line",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "color": "#283d6a"
                            }
                        ]
                    },
                    {
                        "featureType": "transit.station",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#3a4762"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#0e1626"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "labels.text",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#4e6d70"
                            }
                        ]
                    }
                ]
            });

            {{--map.data.loadGeoJson('{{ config('app.url').'api/geo_data' }}');--}}

            // Create an array of alphabetical characters used to label the markers.
            const labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

            // Add some markers to the map.
            // Note: The code uses the JavaScript Array.prototype.map() method to
            // create an array of markers based on a given "locations" array.
            // The map() method here has nothing to do with the Google Maps API.
            // var markers = locations.map(function (location, i) {
            //     return new google.maps.Marker({
            //         position: location,
            //         label: labels[i % labels.length],
            //         map: map
            //     });
            // });

            map.data.loadGeoJson('{{ config('app.url').'api/geo_data' }}', null, function (features) {
                // group items / cluster
                const markers = features.map(function (feature) {
                    const g = feature.getGeometry();
                    const p = feature.getProperties();

                    const marker = new google.maps.Marker({
                        position: g.get(0),
                        label: p.get('name'),
                        map: map
                    });
                    return marker;
                });

                // Add a marker clusterer to manage the markers.
                const markerCluster = new MarkerClusterer(map, markers, {
                    imagePath: '{{ asset('images/google/markers/tmmarker') }}',
                    imageSizes: [40, 60, 80, 100],
                    averageCenter: true,
                    enableRetinaIcons: true,
                    imageExtension: 'png',
                    minimumClusterSize: 1,
                    title: 'Patient',
                });

                // add event listener to the cluster
                // google.maps.event.addListener(markerCluster, 'clusterclick', function (cluster) {
                //     // handle clickevent
                // });
            });

            // Add a marker clusterer to manage the markers.
            const markerCluster = new MarkerClusterer(map, markers, {
                imagePath: '{{ asset('images/google/markers/tmmarker') }}',
                imageSizes: [40, 60, 80, 100],
                averageCenter: true,
                enableRetinaIcons: true,
                imageExtension: 'png',
                minimumClusterSize: 1,
                title: 'Patient',
            });
        }
    </script>
    <script src="{{ asset('js/markerclustererplus.min.js') }}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('corona.google_api_key') }}&callback=initMap"></script>

@endsection
