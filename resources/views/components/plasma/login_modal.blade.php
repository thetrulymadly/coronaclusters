@if(\Illuminate\Support\Facades\Cookie::get('logged_in') === 'true')
    <!-- LOGOUT Modal -->
    <div class="modal fade" id="logout_modal" tabindex="-1" role="dialog" aria-labelledby="Logout"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to logout?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" id="logout_plasma">Yes</button>
                </div>
            </div>
        </div>
    </div>
@else
    <!-- LOGIN Modal -->
    <div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="Login"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert bg-danger mb-3 text-light">
                        <i class="fa fas fa-exclamation-triangle mr-1"></i>
                        <span class="text-base">You can login only if you are either a donor or a requester for plasma</span>
                    </div>
                    {!! Form::open(['id' => 'login_form']) !!}
                    {!! Form::label('phone_number_login', 'Enter your phone number to receive OTP') !!}
                    {!! Form::tel('phone_number_login', '', ['class' => 'form-control text-center', 'required', 'placeholder' => 'Enter your 10-digit phone number', 'maxlength' => 10, 'minlength' => 10, 'onkeypress' => 'return isNumberKey(event)']) !!}
                    <div class="alert bg-danger-trans mb-3 d-none" id="phone_number_login_error">
                        <i class="fa fas fa-exclamation mr-1"></i>
                        Please enter 10-digit phone number
                    </div>

                    {!! Form::token(); !!}
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="get_otp_btn">Get OTP</button>
                </div>
            </div>
        </div>
    </div>
@endif
<!-- VERIFY OTP Modal -->
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
                    {!! Form::tel('otp', '', ['class' => 'form-control text-center', 'required', 'placeholder' => 'X X X X', 'maxlength' => 4, 'minlength' => 4, 'onkeypress' => 'return isNumberKey(event)']) !!}
                    <div class="alert bg-danger-trans mb-3 d-none" id="verify_otp_error">
                        <i class="fa fas fa-exclamation mr-1"></i>
                        Please enter 4-digit OTP
                    </div>

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
