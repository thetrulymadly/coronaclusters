@if(\Illuminate\Support\Facades\Cookie::get('logged_in') === 'true')
    <button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#logout_modal">
        Logout<i class="fa fas fa-user ml-1"></i>
    </button>
    <!-- Modal -->
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
    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#login_modal">
        Login<i class="fa fas fa-user ml-1"></i>
    </button>
    <!-- Modal -->
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
                    <div class="alert bg-warning-trans mb-3">
                        <i class="fa fas fa-exclamation-triangle mr-1"></i> You can login only if you are either a donor or a requester for plasma
                    </div>
                    {!! Form::open(['id' => 'login_form']) !!}
                    {!! Form::label('phone_number_login', 'Enter your phone number to receive OTP') !!}
                    {!! Form::text('phone_number_login', '', ['class' => 'form-control text-center', 'required', 'placeholder' => 'Enter your 10-digit phone number', 'maxlength' => 10, 'onkeypress' => 'return isNumberKey(event)']) !!}

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