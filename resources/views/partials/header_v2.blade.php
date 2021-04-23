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
        <a href="{{ $nav['current_page'] === 'data' ? '#clusters' : $baseUrl }}" class="nav-item nav-link
        @if($nav['current_page'] === 'data') active @endif
        @if(isset($nav['color'])) {{ 'text-'.$nav['color'] }} @endif"
        >
            <i class="mr-1 fa fas fa-chart-area"></i>
            {{ __('corona.data') }}
        </a>

        {{-- Menu : Plasma --}}
        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle @if(!$plasmaActive) text-secondary @endif
            @if($plasmaActive) active @endif"
               data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
               aria-expanded="false">
                <i class="fa fas fa-ambulance"></i>
                {{ __('corona.plasma.title') }}
            </a>
            <div class="dropdown-menu">
                <a href="{{ $baseUrl.'plasma' }}" class="dropdown-item
                @if($nav['current_page'] === 'plasma') active @endif">
                    {{ __('corona.plasma.title') }}
                </a>

                <a href="{{ $baseUrl.'plasma/request' }}" class="dropdown-item
                @if($nav['current_page'] === 'plasma/request') active @endif">
                    {{ __('corona.plasma.request') }}
                </a>

                <a href="{{ $baseUrl.'plasma/donate' }}" class="dropdown-item
                @if($nav['current_page'] === 'plasma/donate') active @endif">
                    {{ __('corona.plasma.donate') }}
                </a>

                <a href="{{ $baseUrl.'plasma/requests' }}" class="dropdown-item
                @if($nav['current_page'] === 'plasma/requests') active @endif">
                    {{ __('corona.plasma.request_list') }}
                </a>

                <a href="{{ $baseUrl.'plasma/donors' }}" class="dropdown-item
                @if($nav['current_page'] === 'plasma/donors') active @endif">
                    {{ __('corona.plasma.donor_list') }}
                </a>
            </div>
        </div>

        {{-- Menu : Testing --}}
        <a href="{{ $nav['current_page'] === 'corona-testing-per-day-india' ? '#corona-testing-per-day-india' : $baseUrl.'corona-testing-per-day-india' }}" class="nav-item nav-link
        @if($nav['current_page'] === 'corona-testing-per-day-india') active @endif
        @if(isset($nav['color'])) {{ 'text-'.$nav['color'] }} @endif"
        >
            <i class="mr-1 fa fas fa-syringe"></i>
            {{ __('corona.corona_testing') }}
        </a>

        {{-- Menu : Help Links --}}
        <a href="#help_links" class="nav-item nav-link
        @if(isset($nav['color'])) {{ 'text-'.$nav['color'] }} @endif"
        >
            <i class="mr-1 fa fas fa-hands-helping"></i>
            {{ __('corona.help_links') }}
        </a>

        @if(!empty($navDropdown))
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    <i class="fas fa-1x fa-question-circle-o"></i>
                </a>
                <div class="dropdown-menu">
                    @foreach($navDropdown as $dropdown)
                        <a class="dropdown-item"
                           href="{{ $baseUrl.$dropdown['url'] }}">
                            {{ $dropdown['title'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</nav>