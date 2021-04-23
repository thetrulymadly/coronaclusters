@php
    $baseUrl = request()->localeUrl ?? config('app.url');
    $plasmaActive = $nav['current_page'] === 'plasma'
    || $nav['current_page'] === 'plasma/request'
    || $nav['current_page'] === 'plasma/requests'
    || $nav['current_page'] === 'plasma/donate'
    || $nav['current_page'] === 'plasma/donors'
@endphp
<nav class="navbar navbar-light navbar-expand-lg bg-light mb-4 justify-content-between" id="covid-nav">
    <a href="{{ $baseUrl }}" class="navbar-brand">
        <h3 class="header-title">{!! __('corona.title') !!}</h3>
    </a>

    <div class="nav nav-pills header-links">
        @if(!$hideLocale)
            <div class="nav-item dropdown locale-selector">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    <i class="fas fa-1x fa-language"></i>
                </a>
                <div class="dropdown-menu">
                    @foreach(config('corona.locales') as $locale)
                        @if(request()->localePath == $locale)
                            <a class="dropdown-item active-locale" href="#">
                                {{ __('corona.locales.'.$locale) }}
                            </a>
                        @else
                            <a class="dropdown-item"
                               href="{{ config('app.url').$locale.'/'.request()->canonicalPath }}">
                                {{ __('corona.locales.'.$locale) }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Menu : Data --}}
        <a href="{{ $nav['current_page'] === 'data' ? '#data' : $baseUrl }}" class="nav-item nav-link
        @if($nav['current_page'] === 'data') active @endif
        @if(isset($nav['color'])) {{ 'text-'.$nav['color'] }} @endif"
        >
            <i class="mr-1 fa fas fa-chart-area d-none d-md-inline-block"></i>
            {{ __('corona.data') }}
        </a>

        {{-- Menu : Plasma --}}
        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle @if(!$plasmaActive) text-secondary @endif
            @if($plasmaActive) active @endif"
               data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
               aria-expanded="false">
                <i class="fa fas fa-ambulance d-none d-md-inline-block"></i>
                {{ __('plasma.plasma') }}
            </a>
            <div class="dropdown-menu">
                <a href="{{ $baseUrl.'plasma' }}" class="dropdown-item text-left
                @if($nav['current_page'] === 'plasma') active @endif">
                    {{ __('plasma.plasma_home') }}
                </a>

                <a href="{{ $baseUrl.'plasma/request' }}" class="dropdown-item text-left
                @if($nav['current_page'] === 'plasma/request') active @endif">
                    {{ __('plasma.request') }}
                </a>

                <a href="{{ $baseUrl.'plasma/donate' }}" class="dropdown-item text-left
                @if($nav['current_page'] === 'plasma/donate') active @endif">
                    {{ __('plasma.donate') }}
                </a>

                <a href="{{ $baseUrl.'plasma/requests' }}" class="dropdown-item text-left
                @if($nav['current_page'] === 'plasma/requests') active @endif">
                    {{ __('plasma.request_list') }}
                </a>

                <a href="{{ $baseUrl.'plasma/donors' }}" class="dropdown-item text-left
                @if($nav['current_page'] === 'plasma/donors') active @endif">
                    {{ __('plasma.donor_list') }}
                </a>
            </div>
        </div>

        {{-- Menu : Testing --}}
        <a href="{{ $nav['current_page'] === 'corona-testing-per-day-india' ? '#corona-testing-per-day-india' : $baseUrl.'corona-testing-per-day-india' }}"
           class="nav-item nav-link
        @if($nav['current_page'] === 'corona-testing-per-day-india') active @endif
           @if(isset($nav['color'])) {{ 'text-'.$nav['color'] }} @endif"
        >
            <i class="mr-1 fa fas fa-syringe d-none d-md-inline-block"></i>
            {{ __('corona.corona_testing') }}
        </a>

        {{-- Menu : Help Links --}}
        <a href="#help_links" class="nav-item nav-link
        @if(isset($nav['color'])) {{ 'text-'.$nav['color'] }} @endif"
        >
            <i class="mr-1 fa fas fa-hands-helping d-none d-md-inline-block"></i>
            {{ __('corona.help') }}
        </a>

        @if(!empty($navDropdown))
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    <i class="fas fa-1x fa-question-circle-o"></i>
                </a>
                <div class="dropdown-menu">
                    @foreach($navDropdown as $dropdown)
                        <a class="dropdown-item text-left"
                           href="{{ $baseUrl.$dropdown['url'] }}">
                            {{ $dropdown['title'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</nav>
