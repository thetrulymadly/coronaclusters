<div class="card @if($detailed === false) mt-3 mt-lg-0 @endif">
    <div class="card-header">
        <h4 class="card-title m-0 float-left">
            @if($requesters === true)
                {{ __('plasma.plasma_requests') }}
            @else
                {{ __('plasma.plasma_donors') }}
            @endif
        </h4>
        @if($detailed === false)
            <div class="float-right d-md-none">
                <a href="{{ config('app.url'). ($requesters === true ? 'plasma/requests' : 'plasma/donors') }}">
                    {{ __('plasma.view_all') }}<i class="fa fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        @endif

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
    </div>
    <div class="card-body">
        @if($donors->isEmpty())
            @if($requesters === true)
                <p>There are no requests for plasma yet. We will update when someone requests</p>
            @else
                <p>There are no donors for plasma yet. We will update when someone is available to donate</p>
            @endif
        @else
            @if($detailed === true)
                <div class="form-group form-inline">
                    {!! Form::label('state', 'Search '. ($requesters === true ? __('plasma.requests') : __('plasma.donors')) .' in your State', ['class' => 'pr-3']) !!}
                    {!! Form::select('state', [], (string)request()->query('state'), ['class' => 'form-control select_state', 'placeholder' => 'Type to search your state']); !!}
                </div>
            @endif
            @if(!empty($loggedInDonor))
                <div class="alert alert-info">
                    <span class="text-base"><i class="fa fas fa-location-arrow mr-2"></i>Here is a list of {{ $requesters === true ? __('plasma.requests') : __('plasma.eligible_donors') }} NEAR YOU</span>
                </div>
            @endif
            {{--            <div class="form-group form-inline">--}}
            {{--                {!! Form::label('city', 'City'.' *', ['class' => 'pr-3']) !!}--}}
            {{--                {!! Form::select('city', [], null, ['class' => 'form-control select_city', 'required' => 'required', 'placeholder' => 'Type to search your city']); !!}--}}
            {{--            </div>--}}
            @if($requesters === false)
                <div class="alert bg-info-trans">
                    <span class="text-base">
                        <i class="fa fas fa-info-circle mr-1"></i>Showing donors strictly as per eligibility criteria mentioned here:
                        <a href="{{ config('app.url').'plasma#plasma-donation-guidelines' }}"
                           class="ml-1"><u>Donor eligibility</u></a>
                    </span>
                </div>
            @endif
            <div class="table-responsive-sm">
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
                                    @if($requesters === true || \Illuminate\Support\Facades\Cookie::get('logged_in') === 'true')
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
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if($detailed === true)
                    {{ !empty(request()->query('state')) ?  $donors->appends(['state' => request()->query('state')])->onEachSide(1)->links() : $donors->onEachSide(1)->links() }}
                @endif
            </div>
        @endif
    </div>
    <div class="card-footer overflow-auto">
        @if($detailed === false)
            <div class="float-right d-none d-md-block">
                <a href="{{ config('app.url'). ($requesters === true ? 'plasma/requests' : 'plasma/donors') }}">
                    {{ __('plasma.view_all_requests') }}<i class="fa fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        @endif
        <div class="btn-group btn-block d-md-none">
            <a href="{{ config('app.url').'plasma/request' }}" class="btn btn-secondary mr-3">{{ __('plasma.request') }}
                <i class="fa fas fa-ambulance ml-1"></i></a>
            <a href="{{ config('app.url').'plasma/donate' }}" class="btn btn-primary">{{ __('plasma.donate') }}
                <i class="fa fas fa-heartbeat ml-1"></i></a>
        </div>
    </div>
</div>