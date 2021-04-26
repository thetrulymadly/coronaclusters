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
        <div class="float-right d-none d-md-block">
            <a href="{{ config('app.url').'plasma/request' }}" class="btn btn-secondary mr-3">{{ __('plasma.request') }}
                <i class="fa fas fa-ambulance ml-1"></i></a>
            <a href="{{ config('app.url').'plasma/donate' }}" class="btn btn-primary">{{ __('plasma.donate') }}
                <i class="fa fas fa-heartbeat ml-1"></i></a>
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
            <div class="table-responsive-sm">
                <table class="table table-striped table-hover table-sm">
                    <thead>
                    <tr>
                        <th>Location</th>
                        <th>Donor</th>
                        <th>Blood Group</th>
                        <th>Phone number</th>

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
                            <td>{{ $donor->geoCity->name . ', ' . $donor->geoState->name }}</td>
                            <td>{{ ucfirst($donor->gender) }} / {{ $donor->age }}</td>
                            <td>{{ $donor->blood_group }}</td>
                            <td>{{ $donor->phone_number }}</td>

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
            </div>
        @endif
    </div>
    <div class="card-footer">
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
