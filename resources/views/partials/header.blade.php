<nav class="navbar navbar-light navbar-expand-lg bg-light mb-4 justify-content-between" id="covid-nav">
    <a href="{{ request()->localeUrl ?? config('app.url') }}" class="navbar-brand"><h3 class="header-title">{!! trans('corona.title') !!}</h3></a>

    <div class="nav nav-pills header-links">
        @if(!$hideLocale)
            <div class="nav-item dropdown locale-selector">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-1x fa-language"></i>
                </a>
                <div class="dropdown-menu">
                    @foreach(config('corona.locales') as $locale)
                        @if(request()->localePath == $locale)
                            <a class="dropdown-item active-locale" href="#">
                                {{ trans('corona.locales.'.$locale) }}
                            </a>
                        @else
                            <a class="dropdown-item" href="{{ config('app.url').$locale.'/'.request()->canonicalPath }}">
                                {{ trans('corona.locales.'.$locale) }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        @php
            if(count($pageSections) > 4) {
                $moreSections = array_splice($pageSections, 4);
            }
        @endphp
        @foreach($pageSections as $section)
            <a href="{{ $section['section'] ?? (request()->localeUrl ?? config('app.url')).$section['url'] }}"
               class="nav-item nav-link @if(isset($section['active']) && $section['active'] === true) active @endif @if(isset($section['color'])) {{ $section['color'] }} @endif ">
                @if(isset($section['icon']))
                    <i class="mr-1 fa fas {{ $section['icon'] }}"></i>
                @endif
                {{ trans('corona.'.$section['title']) }}
            </a>
        @endforeach

        @if(!empty($moreSections))
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-1x fa-question-circle-o"></i>
                </a>
                <div class="dropdown-menu">
                    @foreach($moreSections as $section)
                        <a class="dropdown-item" href="{{ $section['section'] ?? (request()->localeUrl ?? config('app.url')).$section['url'] }}">
                            {{ trans('corona.'.$section['title']) }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</nav>
