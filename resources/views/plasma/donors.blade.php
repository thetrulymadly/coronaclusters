@php
    $hideLocale = true;
    $requestActive = $donorType === \App\Dictionary\PlasmaDonorType::REQUESTER;
    $nav = [
        'current_page' => $requestActive ? 'plasma/requests' : 'plasma/donors',
    ];
@endphp
@extends('layouts.home_layout')

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
@endsection

@section('content')
    @include('components.breadcrumbs')

    <div class="row" id="plasma_donors">
        <div class="col-12">
            @if($donorType === \App\Dictionary\PlasmaDonorType::DONOR)
                @include('components.plasma.donor_requester_list', ['donors' => $donors, 'requesters' => false, 'detailed' => true])
            @else
                @include('components.plasma.donor_requester_list', ['donors' => $donors, 'requesters' => true, 'detailed' => true])
            @endif
        </div>
    </div>
    @if(session('verify_otp') && !empty(session('phone_number')))
        <!-- Modal -->
        <div class="modal fade" id="otp_modal" tabindex="-1" role="dialog" aria-labelledby="Verify OTP"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Verify OTP</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-center">
                            {!! Form::open(['url' => 'plasma/donate', 'id' => 'otp_verify_form_new']) !!}
                            {!! Form::label('otp', 'Enter OTP sent on your phone number') !!}
                            {!! Form::text('otp', '', ['class' => 'form-control text-center', 'required', 'placeholder' => 'X X X X', 'maxlength' => 4, 'onkeypress' => 'return isNumberKey(event)']) !!}

                            {!! Form::token(); !!}
                            {!! Form::close() !!}

                            {{--                            <form method="post" id="otp_verify_form" class="digit-group" data-group-name="digits"--}}
                            {{--                                  data-autosubmit="false"--}}
                            {{--                                  autocomplete="off">--}}
                            {{--                                <input type="text" id="digit-1" name="digit-1" data-next="digit-2" autofocus/>--}}
                            {{--                                <input type="text" id="digit-2" name="digit-2" data-next="digit-3"--}}
                            {{--                                       data-previous="digit-1"/>--}}
                            {{--                                <input type="text" id="digit-3" name="digit-3" data-next="digit-4"--}}
                            {{--                                       data-previous="digit-2"/>--}}
                            {{--                                <input type="text" id="digit-4" name="digit-4" data-next="digit-5"--}}
                            {{--                                       data-previous="digit-3"/>--}}
                            {{--                            </form>--}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="verify_otp_btn">Verify</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('scrips')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @toastr_render

    @if(session('verify_otp') && !empty(session('phone_number')))
        <script type="text/javascript">
            function isNumberKey(evt) {
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                return !(charCode > 31 && (charCode < 48 || charCode > 57));

            }

            $('#otp_modal').modal('show');

            $('#otp_verify_form').find('input').each(function () {
                $(this).attr('maxlength', 1);
                $(this).on('keyup', function (e) {
                    var parent = $($(this).parent());

                    if (e.keyCode === 8 || e.keyCode === 37) {
                        var prev = parent.find('input#' + $(this).data('previous'));

                        if (prev.length) {
                            $(prev).select();
                        }
                    } else if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
                        var next = parent.find('input#' + $(this).data('next'));

                        if (next.length) {
                            $(next).select();
                        } else {
                            if (parent.data('autosubmit')) {

                            }
                        }
                    }
                });
            });

            $('#verify_otp_btn').click(function () {
                $('#otp_modal').modal('hide');
                $.ajax({
                    type: 'POST',
                    url: "{{ config('app.url').'api/otp/verify' }}",
                    dataType: 'json',
                    async: true,
                    data: {
                        phone_number: '{{ session('phone_number') }}',
                        // otp: $('#digit-1').val() + $('#digit-2').val() + $('#digit-3').val() + $('#digit-4').val()
                        otp: $('#otp').val()
                    },
                    success: function (data) {
                        console.log('otp verified');
                        toastr.success('', 'Verified!');
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('otp error');
                    }
                });
            });
        </script>
    @endif
@endsection
