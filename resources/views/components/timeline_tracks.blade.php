<div class="row mt-3" id="timeline">
    <div class="col-12 col-lg-8 offset-lg-2">
        <h3 class="mb-3">{{ trans('corona.timeline_title', ['location' => $location]) }}</h3>
        <ul class="accordion timeline-tracks" id="timelineDate">
            @foreach($timeline as $date => $history)
                <li>
                    {{-- DATE CARD --}}
                    <a id="dateHeading{{ $loop->index }}" type="button" data-toggle="collapse" data-target="#dateCollapse{{ $loop->index }}"
                       aria-expanded="true" aria-controls="dateCollapse{{ $loop->index }}" class="w-100">
                        <span class="d-flex justify-content-between">
                            <span>{{ $date }}</span>
                            <span>{{ $history->last() }}</span>
                        </span>
                    </a>
                    {{-- Body - Date Card --}}
                    <div id="dateCollapse{{ $loop->index }}" class="collapse @if($loop->first) show @endif"
                         aria-labelledby="dateHeading{{ $loop->index }}" data-parent="#timelineDate">
                        {{-- PLACE CARD --}}
                        <div class="accordion timeline-cards" id="timelinePlace">
                            @foreach($history as $place => $patients)
                                @if($loop->last)
                                    @break
                                @endif
                                <div class="card @if(!$loop->first) mt-3 @endif">
                                    @php
                                        $placeIdentifier = str_replace(' ', '-',strtolower($place));
                                    @endphp
                                    {{-- Header - Place Card --}}
                                    <div class="card-header p-0" id="{{ $placeIdentifier }}Heading{{ $loop->index }}">
                                        <button class="btn btn-link p-3 text-left w-100 d-flex justify-content-between" type="button"
                                                data-toggle="collapse"
                                                data-target="#{{ $placeIdentifier }}Collapse{{ $loop->index }}" aria-expanded="true"
                                                aria-controls="{{ $placeIdentifier }}Collapse{{ $loop->index }}">
                                            <span>{{ $place }}</span>
                                            <span>{{ $patients->last() }}</span>
                                        </button>
                                    </div>
                                    {{-- Header - Place Card --}}
                                    <div id="{{ $placeIdentifier }}Collapse{{ $loop->index }}"
                                         class="collapse @if($loop->first) show @endif"
                                         aria-labelledby="{{ $placeIdentifier }}Heading{{ $loop->index }}"
                                         data-parent="#timelinePlace">
                                        <div class="card-body">
                                            <ul class="row">
                                                @foreach($patients as $key => $patient)
                                                    @if($loop->last)
                                                        @break
                                                    @endif
                                                    <li class="col-12 col-lg-4 col-md-6 text-sm">
                                                        {{ trans('corona.patientnumber').' - ' . $patient->patientnumber}}
                                                        <br>
                                                        <a href="{{ $patient->source }}">{{ $patient->source }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
