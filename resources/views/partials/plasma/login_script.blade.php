{{-- This modal will be visible only if the following session variables are set --}}
<script type="text/javascript">
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        return !(charCode > 31 && (charCode < 48 || charCode > 57));
    }

    $(document).ready(function () {

        @if(session('verify_otp') && !empty(session('phone_number')))

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
                    setTimeout(location.reload.bind(location), 100);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log('otp error');
                }
            });
        });
        @endif

        $('#verify_otp_btn').click(function () {
            $('#otp_modal').modal('hide');
            $.ajax({
                type: 'POST',
                url: "{{ config('app.url').'api/otp/verify' }}",
                dataType: 'json',
                async: true,
                data: {
                    phone_number: $('#phone_number_login').val(),
                    // otp: $('#digit-1').val() + $('#digit-2').val() + $('#digit-3').val() + $('#digit-4').val()
                    otp: $('#otp').val()
                },
                success: function (data) {
                    console.log('otp verified');
                    toastr.success('', 'Verified!');
                    setTimeout(location.reload.bind(location), 100);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log('otp error');
                }
            });
        });

        $('#get_otp_btn').click(function () {
            $.ajax({
                type: 'POST',
                url: "{{ config('app.url').'api/otp/send' }}",
                dataType: 'json',
                async: true,
                data: {
                    phone_number: $('#phone_number_login').val(),
                },
                success: function (data) {
                    console.log('otp sent');
                    $('#login_modal').modal('hide');
                    $('#otp_modal').modal('show');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log('otp not sent');
                    $('#login_modal').modal('hide');
                    if (xhr.status === 422) {
                        toastr.error(xhr.responseJson.message, 'Failed');
                    } else {
                        toastr.error('OTP could not be sent. Please try again!', 'Failed');
                    }
                }
            });
        });

        $('#logout_plasma').click(function () {
            $('#logout_modal').modal('hide');
            $.ajax({
                type: 'POST',
                url: "{{ config('app.url').'api/otp/logout' }}",
                dataType: 'json',
                async: true,
                success: function (data) {
                    console.log('logged out');
                    toastr.success('', 'Logged out!');
                    setTimeout(location.reload.bind(location), 100);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log('logout failed');
                    toastr.error('Could not logout at this moment. Try later', 'Failed');
                }
            });
        });
    });
</script>
