@php
    $hideLocale = false;
    $pageSections = [
        ['url' => 'request-plasma', 'title' => 'plasma.request_plasma', 'icon' => 'fa-ambulance', 'color' => 'text-secondary'],
        ['url' => 'donate-plasma', 'title' => 'plasma.donate_plasma', 'icon' => 'fa-heartbeat'],
        //['url' => '#clusters', 'title' => 'clusters'],
        ['url' => '#data', 'title' => 'data'],
        ['section' => '#timeline', 'title' => 'timeline', 'active' => true],
        ['url' => 'corona-testing-per-day-india', 'title' => 'corona_testing'],
        ['section' => '#help_links', 'title' => 'help_links'],
    ];
@endphp

@extends('layouts.home_layout')

@section('content')
    @include('components.timeline_tracks', ['location' => $location])
@endsection
