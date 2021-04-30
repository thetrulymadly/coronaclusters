@php
    $hideLocale = true;
    $nav = [
        'current_page' => '',
    ];
@endphp
@extends('layouts.home_layout')

@section('content')
    @include('components.breadcrumbs')

    <div class="row">
        <div class="col-8">
            {{ __('plasma.plasma_request').'#'. $donor->uuid_hex }}
        </div>
        <div class="col-4 d-flex justify-content-end">
            @include('components.plasma.login_button', ['btn_sm' => true])
        </div>
    </div>
    <div class="alert bg-light text-center mt-3">
        <div class="d-flex justify-content-center align-content-center align-items-center">
            @if($donor->mobile_verified)
                <div>
                    <i class="fa fas fa-check-circle text-primary mr-1 verified-number-tooltip"
                       data-toggle="tooltip" title="Verified Number"></i>
                </div>
            @endif
            @if($donor->donor_type === \App\Dictionary\PlasmaDonorType::REQUESTER || \Illuminate\Support\Facades\Cookie::get('logged_in') === 'true')
                <a href="https://wa.me/{{ '91'.$donor->phone_number }}" class="text-base">
                    {{ $donor->phone_number }}
                    <i class="fab fa-whatsapp text-success ml-2 text-md"></i>
                </a>
            @else
                <a href="#" data-toggle="modal" data-target="#login_modal">
                    <u>{{ substr_replace($donor->phone_number, 'xxxxxx', 2, 6) }}</u>
                </a>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive-sm">
                <table class="table table-striped table-hover table-sm">
                    <tbody>
                    <tr>
                        <th>{{ __('plasma.location') }}</th>
                        <td>{{ $donor->geoCity->name . ', ' . $donor->geoState->name }}</td>
                    </tr>
                    <tr>
                        <th>{{ $donor->donor_type === \App\Dictionary\PlasmaDonorType::REQUESTER ? __('plasma.requester') : __('plasma.donor') }}</th>
                        <td>{{ ucfirst($donor->gender) }} / {{ $donor->age }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('plasma.blood_group') }}</th>
                        <td>{{ $donor->blood_group }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('plasma.date_of_positive') }}</th>
                        <td>{{ $donor->date_of_positive }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('plasma.date_of_negative') }}</th>
                        <td>{{ $donor->date_of_negative }}</td>
                    </tr>
                    @if($donor->donor_type === \App\Dictionary\PlasmaDonorType::REQUESTER)
                        <tr>
                            <th>{{ __('plasma.hospital') }}</th>
                            <td>{{ $donor->hospital }}</td>
                        </tr>
                    @endif

                    <tr>
                        <th>{{ __('plasma.registered_on') }}</th>
                        <td>{{ $donor->created_at }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

{{--    @if(\Illuminate\Support\Facades\Cookie::get('logged_in') === 'true')--}}
{{--        <div class="card-footer d-flex justify-content-between align-content-center align-items-center">--}}
{{--            {{ __('plasma.manage_request') }}--}}
{{--            <div class="dropdown">--}}
{{--                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="manage_btn"--}}
{{--                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                    {{ __('plasma.manage') }}--}}
{{--                </button>--}}
{{--                @php--}}
{{--                    $manageUrl = config('app.url').'plasma/'. ($donor->donor_type === \App\Dictionary\PlasmaDonorType::REQUESTER ? 'request/' : 'donor/'). '/'.$donor->uuid_hex;--}}
{{--                @endphp--}}
{{--                <div class="dropdown-menu" aria-labelledby="Manage">--}}
{{--                    <a class="dropdown-item" href="{{ $manageUrl.'/edit' }}">{{ __('plasma.edit') }}</a>--}}
{{--                    <a class="dropdown-item" href="{{ $manageUrl.'/delete' }}">{{ __('plasma.delete') }}</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}
    @include('components.plasma.login_modal')
@endsection

@section('scrips')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @toastr_render
    @include('partials.plasma.login_script')
@endsection