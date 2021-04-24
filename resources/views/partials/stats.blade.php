<div class="card bg-light mb-3 {{ $color ? 'text-'.$color : 'text-dark' }}">
    <div class="card-header">{{ trans('corona.'.$title) }}</div>
    <div class="card-body">
        <div class="d-flex flex-lg-column justify-content-between align-items-lg-center">
            <h5 class="card-title text-md text-md-lg">{{ $count }}</h5>
            @if($countDelta !== 0)
                <small>[ <i class="fas fa-arrow-up"></i> {{ $countDelta ?? 0 }} ]</small>
            @endif
        </div>
    </div>
</div>
