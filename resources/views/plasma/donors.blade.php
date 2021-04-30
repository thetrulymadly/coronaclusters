@php
    $hideLocale = true;
    $requestActive = $donorType === \App\Dictionary\PlasmaDonorType::REQUESTER;
    $nav = [
        'current_page' => $requestActive ? 'plasma/requests' : 'plasma/donors',
    ];
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
            @if($donorType === \App\Dictionary\PlasmaDonorType::DONOR)
                @include('components.plasma.donor_requester_list', ['donors' => $donors, 'requesters' => false, 'detailed' => true])
            @else
                @include('components.plasma.donor_requester_list', ['donors' => $donors, 'requesters' => true, 'detailed' => true])
            @endif
        </div>
    </div>
    @include('components.plasma.login_modal')
@endsection

@section('scrips')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @toastr_render

    <script src="{{ mix_cdn('js/select2.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {

            @if(!empty(request()->query('state', null)))
            $.ajax({
                type: 'GET',
                url: "{{ config('app.url').'api/geo/state/search' }}",
                dataType: 'json',
                success: function (data) {
                    // create the option and append to Select2

                    var option = new Option(data.text, data.id, false, false);
                    $('.select_state').append(option).trigger('change');
                }
            });
            @endif

            $('.select_state').select2({
                placeholder: 'Type to search your state',
                // minimumInputLength: 3,
                maximumInputLength: 20,
                ajax: {
                    type: 'GET',
                    url: "{{ config('app.url').'api/geo/state/search' }}",
                    dataType: 'json',
                }
            }).on('select2:select', function (e) {

                // setTimeout(location.reload.bind(location), 100);
                // similar behavior as an HTTP redirect
                // window.location.replace("http://stackoverflow.com");

                // similar behavior as clicking on a link
                window.location.href = "{{ config('app.url').'plasma/'.($donorType === \App\Dictionary\PlasmaDonorType::DONOR ? 'donors' : 'requests').'?state=' }}" + e.params.data.id;

                // clear selected city
                // $('.select_state').val(null).trigger('change');
                // Prefill cities of the selected state
                {{--$('.select_city').select2({--}}
                {{--    placeholder: 'Type to search your city',--}}
                {{--    ajax: {--}}
                {{--        type: 'GET',--}}
                {{--        url: "{{ config('app.url').'api/geo/city/search' }}",--}}
                {{--        dataType: 'json',--}}
                {{--        data: function (params) {--}}
                {{--            return query = {--}}
                {{--                term: params.term,--}}
                {{--                state_id: e.params.data.id--}}
                {{--            }--}}
                {{--        },--}}
                {{--        success: function (data) {--}}
                {{--            // setTimeout(location.reload.bind(location), 100);--}}
                {{--            // similar behavior as an HTTP redirect--}}
                {{--            // window.location.replace("http://stackoverflow.com");--}}

                {{--            // similar behavior as clicking on a link--}}
                {{--            window.location.href = "{{ config('app.url').'plasma/donors?state=' }}";--}}
                {{--        }--}}
                {{--    }--}}
                {{--});--}}
            });
            {{--$('.select_city').select2({--}}
            {{--    placeholder: 'Type to search your city',--}}
            {{--    minimumInputLength: 3,--}}
            {{--    maximumInputLength: 20,--}}
            {{--    ajax: {--}}
            {{--        type: 'GET',--}}
            {{--        url: "{{ config('app.url').'api/geo/city/search' }}",--}}
            {{--        dataType: 'json',--}}
            {{--        data: function (params) {--}}
            {{--            var state = $('.select_state').select2('data');--}}
            {{--            return query = {--}}
            {{--                term: params.term,--}}
            {{--                state_id: state.id--}}
            {{--            }--}}
            {{--        }--}}
            {{--    }--}}
            {{--});--}}
        });
    </script>

    @include('partials.plasma.login_script')
@endsection
