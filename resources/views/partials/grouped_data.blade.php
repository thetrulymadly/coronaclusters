<div class="tab-pane fade @if($active) show active @endif" id="{{ $group }}-data" role="tabpanel"
     aria-labelledby="{{ $group }}-data-tab">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <table id="{{ $group }}-data-table"
                   class="table table-striped table-bordered table-hover table-sm bg-white">
                <thead class="thead-light">
                <tr>
                    @foreach(config('corona.table.'.$group.'_data') as $dataHeader)
                        <th scope="col">{{ trans('corona.table_'.$dataHeader) }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($groupData as $data)
                    {{--Don't display total data--}}
                    @if($data[$group] === 'Total')
                        @continue
                    @endif
                    <tr>
                        @foreach(config('corona.table.'.$group.'_data') as $dataHeader)
                            @if($dataHeader === $group)
                                @if(!empty($data[$group]))
                                    <th scope="row" data-order="{{ $data[$group] }}">
                                        @if($data['confirmed'] !== 0)
                                            <a href="{{ config('app.url').\App\Http\Controllers\Helpers::sanitize($parentUrl.'/'.$data[$group]) }}">{{ $data[$group] }}</a>
                                        @else
                                            {{ $data[$group] }}
                                        @endif
                                    </th>
                                @else
                                    <th scope="row" data-order="">{{ trans('corona.unknown') }}</th>
                                @endif
                            @elseif($dataHeader === 'delta_confirmed')
                                @if($data['delta_confirmed'] > 0 || empty($data[$group]))
                                    <td class="bg-warning-trans font-weight-bold">
                                        {{ empty($data[$group]) ? $data['confirmed'] : $data['delta_confirmed'] }}
                                    </td>
                                @else
                                    <td>0</td>
                                @endif
                            @elseif($dataHeader === 'delta_deaths')
                                <td @if($data[$dataHeader] > 0) class="bg-danger-trans font-weight-bold" @endif>
                                    {{ $data[$dataHeader] > 0 ? $data[$dataHeader] : 0 }}
                                </td>
                            @elseif($dataHeader === 'state' || $dataHeader === 'city' || $dataHeader === 'district')
                                <td>{{ trans('places.'.$data->$dataHeader) }}</td>
                            @else
                                <td data-order="{{ $data[$dataHeader] }}">
                                    {{ $data[$dataHeader] }}
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
