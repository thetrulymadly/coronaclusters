@php
    $hideLocale = true;
    $requestActive = $donorType === \App\Dictionary\PlasmaDonorType::REQUESTER;
    $ageMin = 0;
    $ageMax = 100;
    if (!$requestActive) {
        $ageMin = 18;
        $ageMax = 60;
    }
    $nav = [
        'current_page' => $requestActive ? 'plasma/request' : 'plasma/donate',
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

    <div class="row">
        {{-- Last Update & Stats (Desktop Position 2) --}}
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title m-0">
                        @if($donorType === \App\Dictionary\PlasmaDonorType::DONOR)
                            Donate Plasma
                        @else
                            Request Plasma
                        @endif
                    </h3>
                </div>
                <div class="card-body">

                    @if($donorType === \App\Dictionary\PlasmaDonorType::DONOR)
                        <div class="alert alert-info">
                            <a href="{{ config('app.url').'plasma#plasma-donation-guidelines' }}"
                               class="text-base d-flex flex-column">
                                <span>
                                    <i class="fa fas fa-info-circle mr-1"></i>
                                    {{ __('plasma.check_donate_guidelines_alert') }}
                                </span>
                                <span class="align-self-end text-sm"><u>{{ __('plasma.tap_to_view') }}</u></span>
                            </a>
                        </div>
                        {!! Form::open(['url' => 'plasma/donate', 'id' => 'plasma_donate_form']) !!}
                    @else
                        <div class="alert alert-info">
                            <a href="{{ config('app.url').'plasma#plasma-request-guidelines' }}"
                               class="text-base d-flex flex-column">
                                <span>
                                    <i class="fa fas fa-info-circle mr-1"></i>
                                    {{ __('plasma.check_request_guidelines_alert') }}
                                </span>
                                <span class="align-self-end text-sm"><u>{{ __('plasma.tap_to_view') }}</u></span>
                            </a>
                        </div>
                        {!! Form::open(['url' => 'plasma/request', 'id' => 'plasma_request_form', 'files' => true]) !!}
                    @endif
                    <div class="form-group">
                        {!! Form::label('name', 'Name'.' *') !!}
                        {!! Form::text('name', '', ['class' => 'form-control', 'required', 'placeholder' => 'Enter your full name']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('gender', 'Gender'.' *') !!}
                        <div class="form-group">
                            <label class="mr-2">
                                <input type="radio" name="gender" value="male">
                                <span class="px-1">Male</span>
                            </label>
                            <label class="mr-2">
                                <input type="radio" name="gender" value="female">
                                <span class="px-1">Female</span>
                            </label>
                            <label class="mr-2">
                                <input type="radio" name="gender" value="other">
                                <span class="px-1">Other</span>
                            </label>
                        </div>
                        {{--                    <label class="radio-inline">--}}
                        {{--                        Gender--}}
                        {{--                        {!! Form::radio('gender', 'male', true, ['class' => 'form-control', 'required']); !!} Male--}}
                        {{--                        {!! Form::radio('gender', 'female', true, ['class' => 'form-control', 'required']); !!} Female--}}
                        {{--                    </label>--}}
                    </div>
                    <div class="form-group">
                        {!! Form::label('age', 'Age'.' * ' . (!$requestActive ? '(Should be between 18 to 60)' : '')) !!}
                        {!! Form::number('age', 18, ['class' => 'form-control', 'required', 'placeholder' => 'Enter your Age', 'min'=> $ageMin, 'max' => $ageMax]); !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('blood_group', 'Blood Group'.' *') !!}
                        <div class="form-group">
                            @foreach(config('plasma_donor.blood_groups') as $bloodGroup)
                                <label class="mr-2"><input type="radio" name="blood_group"
                                                           value="{{ $bloodGroup }}"><span
                                        class="px-1">{{ $bloodGroup }}</span></label>
                            @endforeach
                        </div>
                    </div>
                    @php
                        $dateOfPositiveRequired = $donorType === \App\Dictionary\PlasmaDonorType::DONOR;
                    @endphp
                    <div class="form-group">
                        {!! Form::label('date_of_positive', 'Date of COVID-19 positive'. ($dateOfPositiveRequired ? ' *' : '')) !!}
                        {!! Form::date('date_of_positive', \Carbon\Carbon::now(), ['class' => 'form-control', $dateOfPositiveRequired ? 'required' : '', 'placeholder' => 'Enter Date of positive']); !!}
                    </div>

                    @if($donorType === \App\Dictionary\PlasmaDonorType::DONOR)
                        <div class="form-group">
                            {!! Form::label('date_of_negative', 'Date of COVID-19 negative'.' *') !!}
                            {!! Form::date('date_of_negative', \Carbon\Carbon::now(), ['class' => 'form-control', 'required', 'placeholder' => 'Enter Date of negative']); !!}
                        </div>
                    @endif
                    <div class="form-group form-inline">
                        {!! Form::label('state', 'State'.' *', ['class' => 'pr-3']) !!}
                        {!! Form::select('state', [], null, ['class' => 'form-control select_state', 'required', 'placeholder' => 'Type to search your state']); !!}
                    </div>
                    <div class="form-group form-inline">
                        {!! Form::label('city', 'City'.' *', ['class' => 'pr-3']) !!}
                        {!! Form::select('city', [], null, ['class' => 'form-control select_city', 'required' => 'required', 'placeholder' => 'Type to search your city']); !!}
                    </div>

                    @if($donorType === \App\Dictionary\PlasmaDonorType::REQUESTER)
                        <div class="form-group">
                            {!! Form::label('hospital', 'Hospital') !!}
                            {!! Form::textarea('hospital', '', ['class' => 'form-control', 'placeholder' => 'Enter the name and address of the hospital', 'rows' => 3]) !!}
                        </div>
                    @endif

                    <div class="form-group">
                        {!! Form::label('phone_number', 'Phone Number'.' *') !!}
                        {!! Form::tel('phone_number', '', ['class' => 'form-control', 'required', 'placeholder' => 'Enter your 10-digit phone number', 'maxlength' => 10, 'minlength' => 10, 'onkeypress' => 'return isNumberKey(event)']) !!}
                    </div>

                    @if($donorType === \App\Dictionary\PlasmaDonorType::REQUESTER)
                        <p class="mb-2">Doctor's prescription stating that the patient requires plasma *</p>
                        <div class="mb-3">
                            <div class="custom-file">
                                {!! Form::label('prescription', 'Please select an image', ['class' => 'custom-file-label text-truncate']) !!}
                                {!! Form::file('prescription', ['class' => 'custom-file-input', 'placeholder' => 'Please select an image']) !!}
                                <div class="alert alert-danger d-none" id="prescription_error">
                                    Please upload an image less than 5MB in size.
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($donorType === \App\Dictionary\PlasmaDonorType::DONOR)
                        {!! Form::submit('Register to Donate', ['class' => 'btn btn-lg btn-block btn-primary']); !!}
                    @else
                        {!! Form::submit('Register Plasma Request', ['class' => 'btn btn-lg btn-block btn-primary']); !!}
                    @endif

                    {!! Form::token(); !!}

                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            @if($donorType === \App\Dictionary\PlasmaDonorType::DONOR)
                @include('components.plasma.donor_requester_list', ['donors' => $donors, 'requesters' => true, 'detailed' => false])
            @else
                @include('components.plasma.donor_requester_list', ['donors' => $donors, 'requesters' => false, 'detailed' => false])
            @endif
        </div>
    </div>
    @include('components.plasma.login_modal')
@endsection

@section('scrips')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @toastr_render

    @include('partials.plasma.login_script')

    <script src="{{ mix_cdn('js/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            bsCustomFileInput.init();

            var prescription = $('#prescription');
            prescription.change(function () {
                validatePrescription();
            });
            $('#plasma_request_form').submit(function (e) {
                var valid = validatePrescription();
                if (!valid) {
                    e.preventDefault();
                }
            });

            function validatePrescription() {
                var fileExtension = ['jpeg', 'jpg', 'png'];
                if (prescription.val() === '') {
                    return true;
                } else if ($.inArray(prescription.val().split('.').pop().toLowerCase(), fileExtension) === -1 || prescription[0].files[0].size > 5120*1024) {
                    $('#prescription_error').removeClass('d-none');
                    return false;
                } else {
                    $('#prescription_error').addClass('d-none');
                    return true;
                }
            }

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
                // clear selected city
                // $('.select_state').val(null).trigger('change');
                // Prefill cities of the selected state
                $('.select_city').select2({
                    placeholder: 'Type to search your city',
                    ajax: {
                        type: 'GET',
                        url: "{{ config('app.url').'api/geo/city/search' }}",
                        dataType: 'json',
                        data: function (params) {
                            return query = {
                                term: params.term,
                                state_id: e.params.data.id
                            }
                        }
                    }
                });
            });
            $('.select_city').select2({
                placeholder: 'Type to search your city',
                minimumInputLength: 3,
                maximumInputLength: 20,
                ajax: {
                    type: 'GET',
                    url: "{{ config('app.url').'api/geo/city/search' }}",
                    dataType: 'json',
                    data: function (params) {
                        var state = $('.select_state').select2('data');
                        return query = {
                            term: params.term,
                            state_id: state.id
                        }
                    }
                }
            });

            $('#nearby_radius_select').select2({
                placeholder: 'Select',
                minimumResultsForSearch: Infinity,
            }).on('select2:select', function (e) {
                @if(!empty(request()->query('page')))
                var nearByQueryOperator = "&";
                @else
                var nearByQueryOperator = "?";
                @endif
                var url = "{{ request()->url() }}" + nearByQueryOperator + 'nearby_radius=' + e.params.data.id;
                window.location.href = url.replace("&amp;", "&");
            });
        });
    </script>
@endsection
