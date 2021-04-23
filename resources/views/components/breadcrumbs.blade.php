@if(!empty($breadcrumbs))
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb px-0">
            <li class="breadcrumb-item">
                <a href="{{ request()->get('localeUrl') }}">
                    <i class="fas fa-home"></i>
                </a>
            </li>
            @foreach($breadcrumbs as $breadcrumb)
                @if($loop->last)
                    <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['name'] }}</li>
                @else
                    <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a></li>
                @endif
            @endforeach
        </ol>
    </nav>

@endif
