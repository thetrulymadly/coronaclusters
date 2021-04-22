@php
    $hideLocale = true;
    $requestActive = $donorType === \App\Dictionary\PlasmaDonorType::REQUESTER;
    $donorActive = $donorType === \App\Dictionary\PlasmaDonorType::DONOR;
    $pageSections = [
        ['url' => 'request-plasma', 'title' => 'plasma.request_plasma', 'icon' => 'fa-ambulance', 'active' => $requestActive, 'color' => $requestActive ? '' : 'text-secondary'],
        ['url' => 'donate-plasma', 'title' => 'plasma.donate_plasma', 'icon' => 'fa-heartbeat', 'active' => $donorActive],
        //['url' => '#clusters', 'title' => 'clusters'],
        ['url' => '#data', 'title' => 'data', 'icon' => 'fa-chart-area'],
        //['url' => 'timeline', 'title' => 'timeline'],
        ['section' => '#corona-testing-per-day-india', 'title' => 'corona_testing', 'icon' => 'fa-syringe'],
        ['section' => '#help_links', 'title' => 'help_links'],
    ];
@endphp
@extends('layouts.home_layout')

@section('content')
    @include('components.breadcrumbs')

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
                        {!! Form::open(['url' => 'donate-plasma']) !!}
                    @else
                        {!! Form::open(['url' => 'request-plasma']) !!}
                    @endif
                    <div class="form-group">
                        {!! Form::label('name', 'Name'.' *') !!}
                        {!! Form::text('name', '', ['class' => 'form-control', 'required', 'placeholder' => 'Enter your full name']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('gender', 'Gender'.' *') !!}
                        <div class="form-group">
                            <label class="mr-2"><input type="radio" name="gender" value="male"><span class="px-1">Male</span></label>
                            <label class="mr-2"><input type="radio" name="gender" value="female"><span class="px-1">Female</span></label>
                            <label class="mr-2"><input type="radio" name="gender" value="other"><span class="px-1">Other</span></label>
                        </div>
                        {{--                    <label class="radio-inline">--}}
                        {{--                        Gender--}}
                        {{--                        {!! Form::radio('gender', 'male', true, ['class' => 'form-control', 'required']); !!} Male--}}
                        {{--                        {!! Form::radio('gender', 'female', true, ['class' => 'form-control', 'required']); !!} Female--}}
                        {{--                    </label>--}}
                    </div>
                    <div class="form-group">
                        {!! Form::label('age', 'Age'.' *') !!}
                        {!! Form::number('age', 18, ['class' => 'form-control', 'required', 'placeholder' => 'Enter your Age', 'min'=> 18, 'max' => 60]); !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('blood_group', 'Blood Group'.' *') !!}
                        <div class="form-group">
                            @foreach(config('plasma_donor.blood_groups') as $bloodGroup)
                                <label class="mr-2"><input type="radio" name="blood_group" value="{{ $bloodGroup }}"><span
                                        class="px-1">{{ $bloodGroup }}</span></label>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('date_of_positive', 'Date of COVID-19 positive'.' *') !!}
                        {!! Form::date('date_of_positive', \Carbon\Carbon::now(), ['class' => 'form-control', 'required', 'placeholder' => 'Enter Date of positive']); !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('date_of_negative', 'Date of COVID-19 negative'.' *') !!}
                        {!! Form::date('date_of_negative', \Carbon\Carbon::now(), ['class' => 'form-control', 'required', 'placeholder' => 'Enter Date of negative']); !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('city', 'City'.' *', ['class' => 'pr-3']) !!}
                        {!! Form::select('city', ['1' => 'New Delhi', '2' => 'Gurugram'], ['class' => 'form-control', 'required', 'placeholder' => 'Select your city']); !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('district', 'District'.' *', ['class' => 'pr-3']) !!}
                        {!! Form::select('district', ['1' => 'South Delhi', '2' => 'Gurugram'], ['class' => 'form-control', 'required', 'placeholder' => 'Select your district']); !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('state', 'State'.' *', ['class' => 'pr-3']) !!}
                        {!! Form::select('state', ['1' => 'Delhi', '2' => 'Haryana'], ['class' => 'form-control', 'required', 'placeholder' => 'Select your state']); !!}
                    </div>

                    @if($donorType === \App\Dictionary\PlasmaDonorType::REQUESTER)
                        <div class="form-group">
                            {!! Form::label('hospital', 'Hospital') !!}
                            {!! Form::textarea('hospital', '', ['class' => 'form-control', 'required', 'placeholder' => 'Enter the name and address of the hospital']) !!}
                        </div>
                    @endif


                    <div class="form-group">
                        {!! Form::label('phone_number', 'Phone Number'.' *') !!}
                        {!! Form::text('phone_number', '', ['class' => 'form-control', 'required', 'placeholder' => 'Enter your phone number']) !!}
                    </div>

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
@endsection

@section('scrips')
    {{--    <script src="{{ mix_cdn('js/corona.js') }}"></script>--}}

    {{--    <script type="text/javascript">--}}

    {{--        $(document).ready(function () {--}}
    {{--            $('#testing-data-table').DataTable({--}}
    {{--                "paging": false,--}}
    {{--                "scrollY": '60vh',--}}
    {{--                "scrollX": true,--}}
    {{--                "scrollCollapse": true,--}}
    {{--                "scroller": true,--}}
    {{--                "dom": 't',--}}
    {{--                "order": [[1, "desc"]]--}}
    {{--            });--}}

    {{--            $('.dataTables_wrapper').css('height', $(window).height() - 145);--}}
    {{--            $(window).resize(function () {--}}
    {{--                $('.dataTables_wrapper').css('height', $(window).height() - 145);--}}
    {{--            });--}}
    {{--        });--}}
    {{--    </script>--}}
@endsection
