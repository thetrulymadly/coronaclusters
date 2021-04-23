<div class="card @if($detailed === false) mt-3 mt-lg-0 @endif">
    <div class="card-header">
        <h4 class="card-title m-0 float-left">
            @if(isset($requesters) && $requesters === true)
                {{ __('plasma.plasma_requests') }}
            @else
                {{ __('plasma.plasma_donors') }}
            @endif
        </h4>
        <div class="float-right d-none d-md-block">
            <a href="{{ config('app.url').'plasma/request' }}" class="btn btn-secondary mr-3">{{ __('plasma.requests') }} <i class="fa fas fa-ambulance"></i></a>
            <a href="{{ config('app.url').'plasma/donate' }}" class="btn btn-primary">{{ __('plasma.donors') }} <i class="fa fas fa-heartbeat"></i></a>
        </div>
    </div>
    <div class="card-body">
        @if($donors->isEmpty())
            @if(isset($requesters) && $requesters === true)
                <p>There are no requests for plasma yet. We will update when someone requests</p>
            @else
                <p>There are no donors for plasma yet. We will update when someone is available to donate</p>
            @endif
        @else
            <table class="table table-striped table-hover table-sm">
                <thead>
                <tr>
                    <th>Location</th>
                    <th>Donor</th>
                    <th>Blood Group</th>
                    @if(isset($detailed) && $detailed === true)
                        <th>Phone number</th>
                        <th>Date of positive</th>
                        <th>Date of negative</th>
                    @endif
                    @if(isset($requesters) && $requesters === true)
                        <th>Hospital</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($donors as $donor)
                    <tr>
                        <td>{{ $donor->geoCity->name . ', ' . $donor->geoState->name }}</td>
                        <td>{{ ucfirst($donor->gender) }} / {{ $donor->age }}</td>
                        <td>{{ $donor->blood_group }}</td>

                        @if(isset($detailed) && $detailed === true)
                            <th>{{ $donor->phone_number }}</th>
                            <th>{{ $donor->date_of_positive }}</th>
                            <th>{{ $donor->date_of_negative }}</th>
                        @endif

                        @if(isset($requesters) && $requesters === true)
                            <th>{{ $donor->hospital }}</th>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
