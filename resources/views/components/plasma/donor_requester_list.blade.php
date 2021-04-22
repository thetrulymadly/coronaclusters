<div class="card">
    <div class="card-header">
        <h4 class="card-title m-0 float-left">
            @if(isset($requesters) && $requesters === true)
                Plasma Requests
            @else
                Plasma Donors
            @endif
        </h4>
        <div class="float-right d-none d-md-block">
            <a href="{{ config('app.url').'request-plasma' }}" class="btn btn-secondary mr-3">Request <i class="fa fas fa-ambulance"></i></a>
            <a href="{{ config('app.url').'donate-plasma' }}" class="btn btn-primary">Donate <i class="fa fas fa-heartbeat"></i></a>
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
                        <td>{{ $donor->city ?? $donor->district ?? $donor->state }}</td>
                        <td>{{ ucfirst($donor->gender) }} / {{ $donor->age }}</td>
                        <td>{{ $donor->blood_group }}</td>

                        @if(isset($detailed) && $detailed === true)
                            <th>{{ $donor->phone_number }}</th>
                            <th>{{ $donor->date_of_postive }}</th>
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
