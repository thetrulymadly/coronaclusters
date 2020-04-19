<div class="row mt-3" id="timeline">
    <div class="col-12 col-lg-8 offset-lg-2">
        <h3>{{ trans('corona.timeline_title', ['location' => $location]) }}</h3>
        <div class="accordion" id="timelineDate">
            @foreach($timeline as $date => $history)
                {{-- DATE CARD --}}
                <div class="card @if(!$loop->first) mt-3 @endif">
                    {{-- Header - Date Card --}}
                    <div class="card-header bg-primary p-0" id="dateHeading{{ $loop->index }}">
                        <button class="btn btn-link p-3 text-light text-left w-100" type="button" data-toggle="collapse"
                                data-target="#dateCollapse{{ $loop->index }}" aria-expanded="true"
                                aria-controls="dateCollapse{{ $loop->index }}">
                            {{ $date }}
                        </button>
                    </div>
                    {{-- Body - Date Card --}}
                    <div id="dateCollapse{{ $loop->index }}" class="collapse @if($loop->first) show @endif"
                         aria-labelledby="dateHeading{{ $loop->index }}" data-parent="#timelineDate">
                        <div class="card-body">
                            {{-- PLACE CARD --}}
                            <div class="accordion" id="timelinePlace">
                                @foreach($history as $place => $patients)
                                    <div class="card @if(!$loop->first) mt-3 @endif">
                                        @php
                                            $placeIdentifier = str_replace(' ', '-',strtolower($place));
                                        @endphp
                                        {{-- Header - Place Card --}}
                                        <div class="card-header p-0" id="{{ $placeIdentifier }}Heading{{ $loop->index }}">
                                            <button class="btn btn-link p-3 text-left w-100" type="button" data-toggle="collapse"
                                                    data-target="#{{ $placeIdentifier }}Collapse{{ $loop->index }}" aria-expanded="true"
                                                    aria-controls="{{ $placeIdentifier }}Collapse{{ $loop->index }}">
                                                {{ $place }}
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
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
