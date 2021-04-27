{{-- This modal will be visible only if the following session variables are set --}}
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
                    {!! Form::open(['id' => 'otp_verify_form_new']) !!}
                    {!! Form::label('otp', 'Enter OTP sent to: ' . session('phone_number')) !!}
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