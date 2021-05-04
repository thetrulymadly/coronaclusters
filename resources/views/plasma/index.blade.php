@php
    $hideLocale = true;
    $nav = [
        'current_page' => 'plasma',
    ];
@endphp
@extends('layouts.home_layout')

@section('content')
    @include('components.breadcrumbs')

    <div class="alert bg-success-trans mt-0">
        <strong class="text-base"><i class="fa fas fa-hand-holding-medical mr-1"></i>Your contribution may help save a life!</strong>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card bg-light mb-3 text-secondary">
                <div class="card-header px-2">{{ trans('plasma.plasma_requests') }}</div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
                        <div class="mb-3">
                            <h5 class="card-title mb-1 mb-md-0 mt-md-2">{{ $plasmaCount['requests'] }}</h5>
                            @if($plasmaCount['requests_delta'] !== 0)
                                <small>
                                    [ <i class="fas fa-arrow-up"></i> {{ $plasmaCount['requests_delta'] ?? 0 }} ]
                                </small>
                            @endif
                        </div>
                        <a href="{{ config('app.url').'plasma/requests' }}" class="btn btn-outline-secondary">
                            <small>{{ __('plasma.requests_list') }}</small><i class="fa fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card bg-light mb-3 text-primary">
                <div class="card-header px-2">{{ trans('plasma.plasma_donors') }}</div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
                        <div class="mb-3">
                            <h5 class="card-title mb-1 mb-md-0 mt-md-2">{{ $plasmaCount['donors'] }}</h5>
                            @if($plasmaCount['donors_delta'] !== 0)
                                <small>
                                    [ <i class="fas fa-arrow-up"></i> {{ $plasmaCount['donors_delta'] ?? 0 }} ]
                                </small>
                            @endif
                        </div>
                        <a href="{{ config('app.url').'plasma/donors' }}" class="btn btn-outline-primary">
                            <small>{{ __('plasma.donors_list') }}</small><i class="fa fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="plasma">
        <div class="col-12 col-lg-6" id="plasma-request-guidelines">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0 float-left">{{ __('plasma.request_plasma') }}</h5>

                    <div class="float-right d-none d-md-block">
                        <a href="{{ config('app.url').'plasma/request' }}" class="btn btn-sm btn-secondary mr-3">
                            {{ __('plasma.register_request') }}<i class="fa fas fa-ambulance ml-1"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <p><strong>You CAN request plasma if:</strong></p>
                    <ul>
                        <li>A patient positive for COVID-19 has been prescribed for Plasma by the attending doctor.</li>
                    </ul>
                    <a href="{{ config('app.url').'plasma/request' }}"
                       class="btn btn-sm btn-secondary d-md-none float-right">
                        {{ __('plasma.register_request') }}<i class="fa fas fa-ambulance ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6" id="plasma-donation-guidelines">
            <div class="card mt-3 mt-lg-0">
                <div class="card-header">
                    <h5 class="card-title mb-0 float-left">{{ __('plasma.plasma_donation') }}</h5>

                    <div class="float-right d-none d-md-block">
                        <a href="{{ config('app.url').'plasma/donate' }}" class="btn btn-sm btn-primary">
                            {{ __('plasma.donate') }}<i class="fa fas fa-heartbeat ml-1"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <p><strong>You CAN donate plasma if:</strong></p>
                    <ul>
                        <li>You were tested positive for COVID-19.</li>
                        <li>You are between 18-60 years old.</li>
                        <li>You have fully recovered.
                        <li>You are free of symptoms for <b>14 days.</b></li>
                        <li>You have tested positive before <b>28 days.</b></li>
                        <li>In case you have already donated plasma, you are still eligible to <b>donate again after
                                every 14 days</b> or as recommended by your doctor.
                        </li>
                    </ul>

                    <p><strong>You CANNOT donate plasma if:</strong></p>
                    <ul>
                        <li>Your weight is less than 50 kg.</li>
                        <li>You have ever been pregnant.</li>
                        <li>You are diabetic on insulin.</li>
                        <li>Your Blood Pressure is more than 140 and diastolic less than 60 or more than 90.</li>
                        <li>You have uncontrolled diabetes or hypertension with change in medication in last 28 days.</li>
                        <li>You are a Cancer Survivor.</li>
                        <li>You have chronic kidney/heart/lung or liver disease.</li>
                    </ul>

                    <a href="{{ config('app.url').'plasma/donate' }}"
                       class="btn btn-sm btn-primary d-md-none float-right">
                        {{ __('plasma.donate') }}<i class="fa fas fa-heartbeat ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
