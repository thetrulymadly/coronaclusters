@php
    $pageSections = [
        ['url' => '#clusters', 'title' => 'clusters'],
        ['url' => '#data', 'title' => 'data'],
        //['url' => 'timeline', 'title' => 'timeline'],
        ['section' => '#corona-testing-per-day-india', 'title' => 'corona_testing', 'active' => true],
        ['section' => '#help_links', 'title' => 'help_links'],
    ];
@endphp
@extends('layouts.home_layout')

@section('content')
    @include('components.breadcrumbs')

    <div class="row" id="corona-testing-per-day-india">

        {{-- Last Update & Stats (Desktop Position 2) --}}
        <div class="col-12 col-lg-4 order-lg-2">
            <div class="row">
                <div class="col-12">
                    <div class="alert bg-danger-trans mb-0">
                        <strong>
                            {{ trans('corona.testing.latest_update_text', ['datetime' => $stats['last_testing_on']]) }}
                        </strong>
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <div class="row">
                        <div class="col-12 card-stats">
                            @include('partials.stats', ['title' => 'total_samples', 'color' => 'primary', 'count' => $stats['total_samples'], 'countDelta' => $stats['delta_total_samples'] ?? 0])
{{--                            <div class="card-deck">--}}
{{--                                @include('partials.stats', ['title' => 'total_tested', 'color' => 'primary', 'count' => $stats['total_tested'], 'countDelta' => $stats['delta_total_tested'] ?? 0])--}}
{{--                            </div>--}}
{{--                            <div class="card-deck">--}}
{{--                                @include('partials.stats', ['title' => 'total_positive', 'color' => 'danger', 'count' => $stats['total_positive'], 'countDelta' => $stats['delta_total_positive'] ?? 0])--}}
{{--                                @include('partials.stats', ['title' => 'total_positive_percent', 'color' => 'danger', 'count' => $stats['total_positive_percent'], 'countDelta' => 0])--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table (Desktop Position 1)--}}
        <div class="col-12 col-lg-8 order-lg-1">

            <div class="alert bg-primary text-light text-center mb-3">
                <strong>
                    {{ trans('corona.page.testing.h1') }}
                </strong>
            </div>

            <div class="row">
                <div class="col-12">
                    <table id="testing-data-table" class="table table-striped table-bordered table-hover table-sm table-light">
                        <thead class="thead-light">
                        <tr>
                            @foreach(config('corona.table.testing_data') as $dataHeader)
                                <th scope="col">{{ trans('corona.'.$dataHeader) }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dailyTests as $data)
                            <tr>
                                @foreach(config('corona.table.testing_data') as $dataHeader)
                                    @if($dataHeader === 'updatetimestamp')
                                        <th scope="row">{{ $data[$dataHeader] }}</th>
                                    @elseif($dataHeader === 'today_totalpositivecases')
                                        <td class="bg-danger-trans">{{ $data[$dataHeader] }}</td>
                                    @else
                                        <td data-order="{{ $data[$dataHeader] }}">{{ $data[$dataHeader] }}</td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scrips')
    <script src="{{ mix_cdn('js/corona.js') }}"></script>

    <script type="text/javascript">

        $(document).ready(function () {
            $('#testing-data-table').DataTable({
                "paging": false,
                "scrollY": '60vh',
                "scrollX": true,
                "scrollCollapse": true,
                "scroller": true,
                "dom": 't',
                "order": [[1, "desc"]]
            });

            $('.dataTables_wrapper').css('height', $(window).height() - 145);
            $(window).resize(function () {
                $('.dataTables_wrapper').css('height', $(window).height() - 145);
            });
        });
    </script>
@endsection
