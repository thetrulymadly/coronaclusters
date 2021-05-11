@php
    $hideLocale = true;
    $nav = [
        'current_page' => '',
    ];
    $ageMin = 0;
    $ageMax = 100;
    if ($donor->donor_type === \App\Dictionary\PlasmaDonorType::DONOR) {
        $ageMin = 18;
        $ageMax = 60;
    }
@endphp
@extends('layouts.home_layout')

@section('styles')
    <link href="{{ mix_cdn('css/select2.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
@endsection

@section('content')
    @include('components.breadcrumbs')

    <div class="row">
        <div class="col-8">
            {{ __('plasma.plasma_request').'#'. $donor->uuid_hex }}
        </div>
        <div class="col-4 d-flex justify-content-end">
            @include('components.plasma.login_button', ['btn_sm' => true])
        </div>
    </div>
    <div class="alert bg-light text-center mt-3">
        <div class="d-flex justify-content-center align-content-center align-items-center">
            @if($donor->mobile_verified)
                <div>
                    <i class="fa fas fa-check-circle text-primary mr-1 verified-number-tooltip"
                       data-toggle="tooltip" title="Verified Number"></i>
                </div>
            @endif
            @if($donor->donor_type === \App\Dictionary\PlasmaDonorType::REQUESTER || \Illuminate\Support\Facades\Cookie::get('logged_in') === 'true')
                <a href="https://wa.me/{{ '91'.$donor->phone_number }}" class="text-base">
                    {{ $donor->phone_number }}
                    <i class="fab fa-whatsapp text-success ml-2 text-md"></i>
                </a>
            @else
                <a href="#" data-toggle="modal" data-target="#login_modal">
                    <u>{{ substr_replace($donor->phone_number, 'xxxxxx', 2, 6) }}</u>
                </a>
            @endif
        </div>
    </div>

    <div class="card">
        {!! Form::open(['url' =>'api/plasma/registration/'.$donor->uuid_hex, 'id' => 'registration_edit_form', 'files' => true]) !!}
        <div class="card-body">
            <div class="table-responsive-sm border">
                <table class="table table-striped table-hover table-sm table-light table-bordered mb-0">
                    <tbody>
                    {{-- Location --}}
                    <tr>
                        <th>{{ __('plasma.location') }}</th>
                        <td>{{ $donor->geoCity->name . ', ' . $donor->geoState->name }}</td>
                    </tr>
                    @if(\Illuminate\Support\Facades\Cookie::get('logged_in') === 'true')
                        <tr class="edit-form d-none">
                            <td>
                                {!! Form::select('state', [], $donor->geoState->state_id, ['class' => 'form-control form-control-sm select_state', 'placeholder' => 'Type to search your state']); !!}
                            </td>
                            <td>
                                {!! Form::select('city', [], $donor->geoCity->city_id, ['class' => 'form-control form-control-sm select_city', 'placeholder' => 'Type to search your city']); !!}
                            </td>
                        </tr>
                    @endif

                    {{-- Gender/Age --}}
                    <tr class="bg-light manage-view">
                        <th>{{ $donor->donor_type === \App\Dictionary\PlasmaDonorType::REQUESTER ? __('plasma.requester') : __('plasma.donor') }}</th>
                        <td>{{ ucfirst($donor->gender) }} / {{ $donor->age }}</td>
                    </tr>
                    @if(\Illuminate\Support\Facades\Cookie::get('logged_in') === 'true')
                        <tr class="edit-form d-none">
                            <td></td>
                            <td>
                                {!! Form::number('age', $donor->age, ['class' => 'form-control form-control-sm', 'placeholder' => 'Enter your Age', 'min'=> $ageMin, 'max' => $ageMax]); !!}
                            </td>
                        </tr>
                    @endif

                    {{-- Blood Group --}}
                    <tr>
                        <th>{{ __('plasma.blood_group') }}</th>
                        <td>{{ $donor->blood_group }}</td>
                    </tr>
                    @if(\Illuminate\Support\Facades\Cookie::get('logged_in') === 'true')
                        <tr class="edit-form d-none">
                            <td colspan="2">
                                <div class="form-group">
                                    @foreach(config('plasma_donor.blood_groups') as $bloodGroup)
                                        <label class="mr-2"><input type="radio" name="blood_group"
                                                                   value="{{ $bloodGroup }}" {{ $donor->blood_group === $bloodGroup ? 'checked' : ''}}>
                                            <span class="px-1">{{ $bloodGroup }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endif

                    {{-- Date of Positive --}}
                    <tr class="bg-light manage-view">
                        <th>{{ __('plasma.date_of_positive') }}</th>
                        <td>{{ $donor->date_of_positive }}</td>
                    </tr>
                    @if(\Illuminate\Support\Facades\Cookie::get('logged_in') === 'true')
                        <tr class="edit-form d-none">
                            <td></td>
                            <td>
                                {!! Form::date('date_of_positive', $donor->date_of_positive, ['class' => 'form-control form-control-sm', 'placeholder' => 'Enter Date of positive']); !!}
                            </td>
                        </tr>
                    @endif
                    {{-- Date of Negative --}}
                    <tr>
                        <th>{{ __('plasma.date_of_negative') }}</th>
                        <td>{{ $donor->date_of_negative }}</td>
                    </tr>
                    @if(\Illuminate\Support\Facades\Cookie::get('logged_in') === 'true')
                        <tr class="edit-form d-none">
                            <td></td>
                            <td>
                                {!! Form::date('date_of_negative', $donor->date_of_negative, ['class' => 'form-control form-control-sm', 'placeholder' => 'Enter Date of negative']); !!}
                            </td>
                        </tr>
                    @endif

                    {{-- Hospital --}}
                    @if($donor->donor_type === \App\Dictionary\PlasmaDonorType::REQUESTER)
                        <tr class="bg-light manage-view">
                            <th>{{ __('plasma.hospital') }}</th>
                            <td>{{ $donor->hospital }}</td>
                        </tr>
                        @if(\Illuminate\Support\Facades\Cookie::get('logged_in') === 'true')
                            <tr class="edit-form d-none">
                                <td colspan="2">
                                    {!! Form::textarea('hospital', $donor->hospital, ['class' => 'form-control form-control-sm', 'placeholder' => 'Enter the name and address of the hospital', 'rows' => 3]) !!}
                                </td>
                            </tr>
                        @endif

                        {{-- Date of Prescription --}}
                        <tr>
                            <th>{{ __('plasma.prescription') }}</th>
                            <td>
                                @if($donor->prescription_verified)
                                    <i class="fa fas fa-check-circle text-success text-base prescription-tooltip"
                                       data-toggle="tooltip" title="Prescription Verified"></i>
                                @elseif(!$donor->prescription_verified && !empty($donor->prescription_url))
                                    <i class="fa fas fa-exclamation-circle text-warning text-base prescription-tooltip"
                                       data-toggle="tooltip" title="Verification Pending"></i>
                                @elseif(\Illuminate\Support\Facades\Cookie::get('logged_in') === 'true' && empty($donor->prescription_url))
                                    <strong>Upload prescription to see donors list</strong><br>
                                @else
                                    <i class="fa fas fa-times-circle text-danger text-base prescription-tooltip"
                                       data-toggle="tooltip" title="Verified Number"></i>
                                @endif
                            </td>
                        </tr>
                        @if(\Illuminate\Support\Facades\Cookie::get('logged_in') === 'true' && empty($donor->prescription_url))
                            <tr class="edit-form d-none">
                                <td colspan="2">
                                    <strong>(Doctor's prescription stating that the patient requires plasma)</strong>
                                    <div class="custom-file">
                                        {!! Form::label('prescription', 'Please upload an image/file', ['class' => 'custom-file-label']) !!}
                                        {!! Form::file('prescription', ['class' => 'custom-file-input', 'placeholder' => 'Please upload an image/file']) !!}
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endif

                    {{-- Date of Registered On --}}
                    <tr class="{{ $donor->donor_type === \App\Dictionary\PlasmaDonorType::REQUESTER ? 'bg-light manage-view' : '' }}">
                        <th>{{ __('plasma.registered_on') }}</th>
                        <td>{{ $donor->created_at }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        @if(\Illuminate\Support\Facades\Cookie::get('logged_in') === 'true')
            <div
                class="card-footer d-flex justify-content-between justify-content-md-end align-content-center align-items-center">
                <span>{{ 'Manage Request' }}</span>
                <div class="d-flex justify-content-between align-content-center align-items-center ml-md-3">
                    <button class="btn btn-sm btn-outline-secondary manage-controls" id="delete_btn" type="button"
                            data-toggle="modal"
                            data-target="#delete_modal">
                        <i class="fa fas fa-sm fa-trash mr-1"></i>Delete
                    </button>
                    <button class="btn btn-sm btn-primary ml-2 manage-controls" id="edit_btn" type="button">
                        <i class="fa fas fa-sm fa-edit mr-1"></i>Edit
                    </button>

                    <button class="btn btn-sm btn-primary d-none edit-form" id="edit_save_btn" type="button">
                        <i class="fa fas fa-sm fa-save mr-1"></i>Save
                    </button>
                    <button class="btn btn-sm btn-secondary ml-2 d-none edit-form" id="edit_cancel_btn" type="button">
                        <i class="fa fas fa-sm fa-times mr-1"></i>Cancel
                    </button>
                    {{--                    <button class="btn btn-sm btn-primary ml-3" type="button">Edit Info</button>--}}
                </div>
            </div>
        @endif

        {!! Form::close() !!}
    </div>

    @if(\Illuminate\Support\Facades\Cookie::get('logged_in') === 'true')
        <!-- DELETE Modal -->
        <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="Delete"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('plasma.delete_modal_title') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="delete_confirm_content">{{ __('plasma.delete_confirm') }}</p>
                        <div class="delete_reason_content d-none">
                            <div class="form-group">
                                {!! Form::label('delete_reason', 'Please tell us why you want to delete your registration? *') !!}
                                {!! Form::select('delete_reason', [], null, ['class' => 'form-control', 'placeholder' => 'Select a reason', 'required']); !!}
                                <div class="alert bg-danger-trans mb-3 d-none" id="delete_reason_error">
                                    <i class="fa fas fa-exclamation mr-1"></i>
                                    Please select a reason *
                                </div>
                            </div>
                            <div class="form-group d-none delete_reason_other_content">
                                {!! Form::label('delete_reason_other', 'Other reason *') !!}
                                {!! Form::textarea('delete_reason_other', null, ['class' => 'form-control', 'placeholder' => 'Please type a reason', 'required']) !!}
                                <div class="alert bg-danger-trans mb-3 d-none" id="delete_reason_other_error">
                                    <i class="fa fas fa-exclamation mr-1"></i>
                                    Please type other reason *
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="delete_confirm_content">
                            <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">No
                            </button>
                            <button type="button" class="btn btn-primary" id="delete_confirm_btn">Yes</button>
                        </div>
                        <div class="delete_reason_content d-none">
                            <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal"
                                    id="delete_plasma_cancel_btn">Cancel
                            </button>
                            <button type="button" class="btn btn-primary" id="delete_plasma_btn" disabled>
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @include('components.plasma.login_modal')
@endsection

@section('scrips')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @toastr_render
    <script src="{{ mix_cdn('js/select2.min.js') }}"></script>
    @include('partials.plasma.login_script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.prescription-tooltip').click(function () {
                $(this).tooltip('toggle');
            });

            {{-- Script related to EDIT functionality --}}
            $('#edit_btn').click(function () {
                $('.edit-form').removeClass('d-none');
                $('.manage-controls').addClass('d-none');
                $('.manage-view').removeClass('bg-light');
            });
            $('#edit_cancel_btn').click(function () {
                $('.edit-form').addClass('d-none');
                $('.manage-controls').removeClass('d-none');
                $('.manage-view').addClass('bg-light');
            });

            $('#edit_save_btn').click(function () {
                $('#registration_edit_form').submit();
            });

            {{-- Script related to DELETE functionality --}}
            @if(!empty($deleteReasons))
            var deleteReasons = [
                    @foreach($deleteReasons as $reason)
                {
                    id: "{{ $reason['name'] }}", text: "{{ $reason['value'] }}"
                } {{ $loop->last ? '' : ',' }}
                    @endforeach
            ];
            {{-- When delete confirmed (Yes), show delete reason options --}}
            $('#delete_confirm_btn').click(function () {
                $('.delete_confirm_content').addClass('d-none');
                $('.delete_reason_content').removeClass('d-none');
            });

            {{-- Things to do when delete modal is closed (via any method) --}}
            $('#delete_modal').on('hidden.bs.modal', function (e) {
                $('.delete_confirm_content').removeClass('d-none');
                $('.delete_reason_content').addClass('d-none');
                $('.delete_reason_other_content').addClass('d-none');
                $('#delete_reason').val(null).trigger('change');
                $('#delete_reason_other').val(null);
                $('#delete_plasma_btn').attr('disabled', 'disabled');
            });

            {{-- Things to do when one of the DELETE REASONS is selected --}}
            $("#delete_reason").select2({
                data: deleteReasons,
                width: '50%'
            }).on('select2:select', function (e) {
                {{-- hide previous errors (if any) --}}
                $('#delete_reason_error').addClass('d-none');
                $('#delete_reason_other_error').addClass('d-none');

                {{-- enable submit (delete) button --}}
                $('#delete_plasma_btn').removeAttr('disabled');

                var other = $('.delete_reason_other_content');
                {{-- Show text area to type other reason --}}
                if ($(this).val() === 'other') {
                    other.removeClass('d-none');
                } else {
                    other.addClass('d-none');
                }
            });

            {{-- Things to do when DELETE called (with reason) --}}
            $('#delete_plasma_btn').click(function () {
                var reason = $('#delete_reason').val();
                {{-- Show error if no reason selected --}}
                if (reason.length === 0) {
                    $('#delete_reason_error').removeClass('d-none');
                } else if (reason === 'other') {
                    var otherReason = $('#delete_reason_other').val();
                    {{-- Show error if other reason is empty --}}
                    if (otherReason.length === 0) {
                        $('#delete_reason_other_error').removeClass('d-none');
                    } else {
                        {{-- submit via ajax with other reason --}}
                        deletePlasma(reason, otherReason);
                    }
                } else {
                    {{-- submit via ajax --}}
                    deletePlasma(reason);
                }
            });

            function deletePlasma(reason, otherReason = null) {
                $('#delete_reason_other_error').addClass('d-none');
                $('#delete_reason_error').addClass('d-none');
                $.ajax({
                    type: 'POST',
                    url: "{{ config('app.url').'api/plasma/delete' }}",
                    dataType: 'json',
                    async: true,
                    data: {
                        delete_reason: reason,
                        delete_reason_other: otherReason
                    },
                    success: function (data) {
                        console.log('deleted');
                        toastr.success('Your registration is now deleted from the list.', 'Deleted!');
                        $('#delete_modal').modal('hide');
                        setTimeout(function () {
                            window.location.replace("{{ config('app.url').'plasma' }}")
                        }, 5000);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('delete failed');
                        toastr.error('Could not delete at this moment. Please try later.', 'Failed!');
                        $('#delete_modal').modal('hide');
                    }
                });
            }

            @endif

            {{-- Script for state city edit --}}
            $('.select_state').select2({
                placeholder: 'Type to search your state',
                minimumInputLength: 3,
                maximumInputLength: 20,
                width: '100%',
                ajax: {
                    type: 'GET',
                    url: "{{ config('app.url').'api/geo/state/search' }}",
                    dataType: 'json',
                }
            }).on('select2:select', function (e) {
                // clear selected city
                // $('.select_state').val(null).trigger('change');
                // Prefill cities of the selected state
                $('.select_city').select2({
                    placeholder: 'Type to search your city',
                    ajax: {
                        type: 'GET',
                        url: "{{ config('app.url').'api/geo/city/search' }}",
                        dataType: 'json',
                        data: function (params) {
                            return query = {
                                term: params.term,
                                state_id: e.params.data.id
                            }
                        }
                    }
                });
            });
            $('.select_city').select2({
                placeholder: 'Type to search your city',
                minimumInputLength: 3,
                maximumInputLength: 20,
                ajax: {
                    type: 'GET',
                    url: "{{ config('app.url').'api/geo/city/search' }}",
                    dataType: 'json',
                    data: function (params) {
                        var state = $('.select_state').select2('data');
                        return query = {
                            term: params.term,
                            state_id: state.id
                        }
                    }
                }
            });
        });
    </script>
@endsection