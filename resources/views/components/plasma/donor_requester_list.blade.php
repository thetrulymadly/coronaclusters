<div class="card @if($detailed === false) mt-3 mt-lg-0 @endif">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title m-0" @if(isset($hide_controls) && $hide_controls === true) style="width: 70%" @endif>
            @if(!empty($loggedInDonor) && empty(request()->city))
                {{ $requesters ? __('plasma.matching_requests') : __('plasma.matching_donors') }}
            @else
                {{ $requesters ? __('plasma.plasma_requests') : __('plasma.plasma_donors') }}
            @endif
        </h5>
        @if($detailed === false)
            <div class="d-md-none">
                <a href="{{ config('app.url'). ($requesters === true ? 'plasma/requests' : 'plasma/donors') }}">
                    {{ __('plasma.view_all') }}<i class="fa fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        @endif

        @if(!isset($hide_controls) || $hide_controls === false)
            {{-- Login/Logout button--}}
            @if($detailed === true)
                <div class="float-right ml-3">
                    @include('components.plasma.login_button')
                </div>
            @endif

            <div class="float-right d-none d-md-block">
                <a href="{{ config('app.url').'plasma/request' }}" class="btn btn-secondary mr-3">
                    {{ __('plasma.request') }}<i class="fa fas fa-ambulance ml-1"></i>
                </a>
                <a href="{{ config('app.url').'plasma/donate' }}" class="btn btn-primary">
                    {{ __('plasma.donate') }}<i class="fa fas fa-heartbeat ml-1"></i>
                </a>
            </div>
        @else
            @php
                $disabled = (empty($loggedInDonor) && empty(request()->query('city'))) || request()->query('city') === 'all';
            @endphp
            <div style="width: 30%">
                {!! Form::select('nearby_radius', config('plasma_donor.nearby_radius_options'), $disabled ? null : (request()->query('nearby_radius') ?? config('plasma_donor.default_nearby_distance')), ['class' => 'form-control', 'id' => 'nearby_radius_select', 'placeholder' => 'Select distance', $disabled ? 'disabled' : '']); !!}
            </div>
        @endif
    </div>
    <div class="card-body">
        @if($detailed === true && (!isset($hide_controls) || $hide_controls === false))
            <div class="form-row mb-3">
                <div class="col-8">
                    {!! Form::label('city', 'Search City *', ['class' => 'pr-3']) !!}
                    {!! Form::select('city', [], request()->query('city'), ['class' => 'form-control', 'id' => 'select_city_list', 'placeholder' => 'Type to search']); !!}
                </div>
                <div class="col-4">
                    @php
                        $disabled = (empty($loggedInDonor) && empty(request()->query('city'))) || request()->query('city') === 'all';
                    @endphp
                    {!! Form::label('nearby_radius', 'Distance *', ['class' => 'pr-3']) !!}
                    {!! Form::select('nearby_radius', config('plasma_donor.nearby_radius_options'), $disabled ? null : (request()->query('nearby_radius') ?? config('plasma_donor.default_nearby_distance')), ['class' => 'form-control', 'id' => 'nearby_radius_select', 'placeholder' => 'Select distance', $disabled ? 'disabled' : '']); !!}
                </div>
            </div>
        @endif
        @if($donors->isEmpty())
            <p>There are no {{ $requesters === true ? __('plasma.plasma_requests') : __('plasma.plasma_donors') }}
                near your location
                {{ !empty($loggedInDonor) ? ': '.$loggedInDonor->geoCity->name.', '.$loggedInDonor->geoState->name : '' }}
                <br>Please select some other location or increase the distance.
            </p>
        @else
            @if(!empty($loggedInDonor) && empty(request()->city))
                <div class="alert alert-info">
                    <span class="text-base"><i class="fa fas fa-location-arrow mr-2"></i>Here is a list of <strong>COMPATIBLE {{ strtoupper($requesters === true ? __('plasma.requests') : __('plasma.donors')) }}</strong> near you</span>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover table-sm">
                    <thead>
                    <tr>
                        <th>Verified?</th>
                        <th>Location</th>
                        <th>Donor</th>
                        <th>Blood Group</th>
                        <th style="width: 100px">Phone number</th>

                        @if($requesters === false)
                            <th>Date of negative</th>
                        @endif

                        @if($detailed === true)
                            <th>Date of positive</th>

                            @if($requesters === true)
                                <th>Hospital</th>
                            @endif

                            @if($requesters === true)
                                <th>Requested On</th>
                            @else
                                <th>Registered On</th>
                            @endif
                        @endif
                        <th>Details</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($donors as $donor)
                        <tr>
                            <td class="align-middle text-center">
                                @if($donor->details_verified === \App\Dictionary\DetailsVerified::VERIFIED)
                                    <img src="{{ asset_cdn('images/details_verified.png') }}"
                                         class="verified-details-tooltip" alt="Verified" width="25"
                                         data-toggle="tooltip" title="Verified Details">
                                @endif
                            </td>
                            <td>{{ $donor->geoCity->name . ', ' . $donor->geoState->name }}</td>
                            <td>{{ ucfirst($donor->gender) }} / {{ $donor->age }}</td>
                            <td>{{ $donor->blood_group }}</td>
                            {{-- Show phone number for request list or if logged in then show donor phone number as well --}}
                            <td>
                                <div class="d-flex justify-content-start align-content-center">
                                    @if($donor->mobile_verified || $donor->details_verified === \App\Dictionary\DetailsVerified::VERIFIED)
                                        <div>
                                            <i class="fa fas fa-check-circle text-primary mr-1 verified-number-tooltip"
                                               data-toggle="tooltip" title="Verified Number"></i>
                                        </div>
                                    @else
                                        <div class="d-block" style="width: 15px"></div>
                                    @endif
                                    @if(\Illuminate\Support\Facades\Cookie::get('logged_in') === 'true')
                                        <a href="https://wa.me/{{ '91'.$donor->phone_number }}">
                                            {{ $donor->phone_number }}
                                        </a>
                                        <div>
                                            <i class="fab fa-whatsapp text-success ml-1 text-md"></i>
                                        </div>
                                    @else
                                        <a href="#" data-toggle="modal" data-target="#login_modal">
                                            <u>{{ substr_replace($donor->phone_number, 'xxxxxx', 2, 6) }}</u>
                                        </a>
                                    @endif
                                </div>
                            </td>

                            @if($requesters === false)
                                <td>{{ $donor->date_of_negative }}</td>
                            @endif

                            @if($detailed === true)
                                <td>{{ $donor->date_of_positive }}</td>

                                @if($requesters === true)
                                    <td>{{ $donor->hospital }}</td>
                                @endif

                                <td>{{ $donor->created_at }}</td>
                            @endif
                            <td>
                                <a href="{{ $donor->url }}">{{ $donor->uuid_hex }}</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if($detailed === true)
                    {{ $donors->appends(['city' => request()->query('city'), 'nearby_radius' => request()->query('nearby_radius')])->onEachSide(1)->links() }}
                @endif
            </div>
        @endif
    </div>
    @if(!isset($hide_controls) || $hide_controls === false)
        <div class="card-footer overflow-auto">
            @if($detailed === false)
                <div class="float-right d-none d-md-block">
                    <a href="{{ config('app.url'). ($requesters === true ? 'plasma/requests' : 'plasma/donors') }}">
                        {{ __('plasma.view_all_requests') }}<i class="fa fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            @endif
            <div class="btn-group btn-block d-md-none">
                <a href="{{ config('app.url').'plasma/request' }}"
                   class="btn btn-secondary mr-3">{{ __('plasma.request') }}
                    <i class="fa fas fa-ambulance ml-1"></i></a>
                <a href="{{ config('app.url').'plasma/donate' }}" class="btn btn-primary">{{ __('plasma.donate') }}
                    <i class="fa fas fa-heartbeat ml-1"></i></a>
            </div>
        </div>
    @endif
</div>

@if(!isset($include_login_modal) || $include_login_modal === true)
    @include('components.plasma.login_modal')
@endif
