@php
    $hideLocale = true;
    $nav = [
        'current_page' => 'plasma',
    ];
@endphp
@extends('layouts.home_layout')

@section('content')
    @include('components.breadcrumbs')

    <div class="alert bg-success-trans mt-3 mt-lg-0">
        <strong>Your contribution may help save a life!</strong>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card bg-light mb-3 text-danger">
                <div class="card-header">{{ trans('corona.plasma_requests') }}</div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
                        <div>
                            <h5 class="card-title m-0">{{ $plasmaCount['requests'] }}</h5>
                            @if($plasmaCount['requests_delta'] !== 0)
                                <small>[ <i class="fas fa-arrow-up"></i> {{ $plasmaCount['requests_delta'] ?? 0 }}
                                    ]</small>
                            @endif
                        </div>
                        <a href="{{ config('app.url').'plasma/requests' }}" class="btn btn-outline-secondary">
                            <small>Request List</small>
                            <i class="fa fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card bg-light mb-3 text-danger">
                <div class="card-header">{{ trans('corona.plasma_donors') }}</div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
                        <div>
                            <h5 class="card-title m-0">{{ $plasmaCount['donors'] }}</h5>
                            @if($plasmaCount['donors_delta'] !== 0)
                                <small>[ <i class="fas fa-arrow-up"></i> {{ $plasmaCount['donors_delta'] ?? 0 }}
                                    ]</small>
                            @endif
                        </div>
                        <a href="{{ config('app.url').'plasma/donors' }}" class="btn btn-outline-primary">
                            <small>Donor List</small>
                            <i class="fa fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="plasma">
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0 float-left">Request Plasma</h5>

                    <div class="float-right d-none d-md-block">
                        <a href="{{ config('app.url').'plasma/request' }}" class="btn btn-sm btn-secondary mr-3">Register
                            Request <i class="fa fas fa-ambulance"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <p><strong>You CAN request plasma if:</strong></p>
                    <ul>
                        <li>A patient positive for COVID-19 has been prescribed for Plasma by the attending doctor,
                            patient may be of any age group
                        </li>
                        <li>You already have a replacement donor or not – if you have a donor then we will facilitate
                            their donation of Plasma
                        </li>
                    </ul>
                    <a href="{{ config('app.url').'plasma/request' }}"
                       class="btn btn-sm btn-secondary d-lg-none float-right">Register Request <i
                            class="fa fas fa-ambulance"></i></a>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card mt-3 mt-lg-0">
                <div class="card-header">
                    <h5 class="card-title mb-0 float-left">Plasma Donation</h5>

                    <div class="float-right d-none d-md-block">
                        <a href="{{ config('app.url').'plasma/donate' }}" class="btn btn-sm btn-primary">Donate <i
                                class="fa fas fa-heartbeat"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <p><strong>You CAN donate plasma if:</strong></p>
                    <ul>
                        <li>You were tested positive for COVID-19</li>
                        <li>You have fully recovered and are free of symptoms for 14 days</li>
                        <li>You are between 18-60 years old</li>
                    </ul>

                    <p><strong>You CANNOT donate plasma if:</strong></p>
                    <ul>
                        <li>Your weight is less than 50 kg</li>
                        <li>You have ever been pregnant</li>
                        <li>You are diabetic on insulin</li>
                        <li>Your Blood Pressure is more than 140 and diastolic less than 60 or more than 90</li>
                        <li>You have uncontrolled diabetes or hypertension with change in medication in last 28 days
                        </li>
                        <li>You are a Cancer Survivor</li>
                        <li>You have chronic kidney/heart/lung or liver disease.</li>
                    </ul>

                    <a href="{{ config('app.url').'plasma/donate' }}"
                       class="btn btn-sm btn-primary d-lg-none float-right">Donate <i
                            class="fa fas fa-heartbeat"></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection
