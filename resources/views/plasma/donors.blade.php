@php
    $hideLocale = true;
    $requestActive = $donorType === \App\Dictionary\PlasmaDonorType::REQUESTER;
    $nav = [
        'current_page' => $requestActive ? 'plasma/requests' : 'plasma/donors',
    ];
    $cityQuery = request()->query('city');
    $selectedCity = $cityQuery ?? (!empty($loggedInDonor) ? $loggedInDonor->city : null);
@endphp
@extends('layouts.home_layout')

@section('styles')
    <link href="{{ mix_cdn('css/select2.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
@endsection

@section('content')
    @include('components.breadcrumbs')

    @include('components.plasma.manage_request_alert')

    <div class="row" id="plasma_donors">
        <div class="col-12">
            @if($requestActive)
                @include('components.plasma.donor_requester_list', ['donors' => $donors, 'requesters' => true, 'detailed' => true])
            @else
                @include('components.plasma.donor_requester_list', ['donors' => $donors, 'requesters' => false, 'detailed' => true])
            @endif
        </div>
    </div>
@endsection

@section('scrips')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @toastr_render

    <script src="{{ mix_cdn('js/select2.min.js') }}"></script>

    @include('partials.plasma.login_script')
    <script type="text/javascript">
        $(document).ready(function () {
            var select_city = $('#select_city_list');

            {{-- Fetch the preselected item, and add to the control --}}
            $.ajax({
                type: 'GET',
                url: "{{ config('app.url').'api/geo/city/search?with_state=1'. (!empty($selectedCity) & $selectedCity !== 'all' ? '&city_id='.$selectedCity : '') }}".replace("&amp;", "&"),
                dataType: 'json',
                success: function (data) {
                    {{-- create the option and append to Select2 --}}
                    var option = new Option(data.text, data.id, true, true);
                    select_city.append(option).trigger('change');
                }
            });

            select_city.select2({
                placeholder: 'Type to search',
                maximumInputLength: 20,
                allowClear: true,
                ajax: {
                    type: 'GET',
                    url: "{{ config('app.url').'api/geo/city/search?with_state=1' }}",
                    dataType: 'json',
                }
            }).on('select2:select', function (e) {
                window.location.href = "{{ config('app.url').'plasma/'.($requestActive ? 'requests' : 'donors').'?city=' }}" + e.params.data.id;
            }).on('select2:clear', function (e) {
                window.location.href = "{{ config('app.url').'plasma/'.($requestActive ? 'requests' : 'donors').'?city=all' }}";
            });

            $('#nearby_radius_select').select2({
                placeholder: 'Select',
                minimumResultsForSearch: Infinity,
            }).on('select2:select', function (e) {
                @if(!empty($cityQuery))
                var query = "{{ config('app.url').'plasma/'.($requestActive ? 'requests' : 'donors').'?city='.$cityQuery.'&nearby_radius=' }}" + e.params.data.id;
                window.location.href = query.replace("&amp;", "&");
                @else
                    window.location.href = "{{ config('app.url').'plasma/'.($requestActive ? 'requests' : 'donors').'?nearby_radius=' }}" + e.params.data.id;
                @endif
            });
        });
    </script>
@endsection
