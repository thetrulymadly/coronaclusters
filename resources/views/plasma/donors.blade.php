@php
    $hideLocale = true;
    $requestActive = $donorType === \App\Dictionary\PlasmaDonorType::REQUESTER;
    $nav = [
        'current_page' => $requestActive ? 'plasma/requests' : 'plasma/donors',
    ];
@endphp
@extends('layouts.home_layout')

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <style type="text/css">
        /*@media screen and ( max-width: 768px ){*/

        /*    li.page-item {*/

        /*        display: none;*/
        /*    }*/

        /*    .page-item:first-child,*/
        /*    .page-item:nth-child( 2 ),*/
        /*    .page-item:nth-child( 3 ),*/
        /*    .page-item:nth-last-child( 2 ),*/
        /*    .page-item:nth-last-child( 3 ),*/
        /*    .page-item:last-child,*/
        /*    .page-item.active,*/
        /*    .page-item.disabled {*/

        /*        display: block;*/
        /*    }*/
        /*}*/
    </style>
@endsection

@section('content')
    @include('components.breadcrumbs')

    <div class="row" id="plasma_donors">
        <div class="col-12">
            @if($donorType === \App\Dictionary\PlasmaDonorType::DONOR)
                @include('components.plasma.donor_requester_list', ['donors' => $donors, 'requesters' => false, 'detailed' => true])
            @else
                @include('components.plasma.donor_requester_list', ['donors' => $donors, 'requesters' => true, 'detailed' => true])
            @endif
        </div>
    </div>
    @include('components.plasma.login_modal')
@endsection

@section('scrips')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @toastr_render

    @include('partials.plasma.login_script')
@endsection
