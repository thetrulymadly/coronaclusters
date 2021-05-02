@php
    $hideLocale = true;
    $nav = [
        'current_page' => '',
    ];
@endphp
@extends('layouts.home_layout')

@section('styles')
    <link href="{{ mix_cdn('css/select2.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
@endsection

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

        @if(\Illuminate\Support\Facades\Cookie::get('logged_in') === 'true')
            <div class="card-footer d-flex justify-content-between justify-content-md-end align-content-center align-items-center">
                <span>{{ __('plasma.manage_request') }}</span>
                <div class="d-flex justify-content-between align-content-center align-items-center ml-md-3">
                    <button class="btn btn-sm btn-outline-secondary" id="delete_btn" type="button" data-toggle="modal" data-target="#delete_modal">Delete</button>
{{--                    <button class="btn btn-sm btn-primary ml-3" type="button">Edit Info</button>--}}
                </div>
                <!-- DELETE Modal -->
                <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="Delete"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ __('plasma.delete_modal_title') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>{{ __('plasma.delete_confirm') }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                <button type="button" class="btn btn-primary" id="delete_plasma">Yes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @include('components.plasma.login_modal')
@endsection

@section('scrips')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @toastr_render
    <script src="{{ mix_cdn('js/select2.min.js') }}"></script>
    @include('partials.plasma.login_script')
@endsection