<?php

namespace Api\Http\Controllers\Otp;

use Api\Helpers\ResponseHelper;
use Api\Http\Requests\Otp\SendOtpRequest;
use Api\Http\Requests\Otp\VerifyOtpRequest;
use Api\Services\Otp\OtpVerificationService;
use App\Http\Controllers\Controller;

class OtpVerificationController extends Controller
{

    private $service;

    function __construct(OtpVerificationService $service)
    {
        $this->service = $service;
    }

    public function send(SendOtpRequest $request)
    {
        $result = $this->service->send($request->phone_number);
        return ResponseHelper::response($result, $result ? "OTP sent successfully" : "Unable to send OTP");
    }

    public function verify(VerifyOtpRequest $request)
    {
        $result  = $this->service->verify($request->phone_number,$request->otp);
        return ResponseHelper::response($result,null)
            ->withCookie(\cookie()->make('logged_in', 'true', (int)config('app.cookie_expire_minutes'), '/', config('app.cookie_domain'), true, false, false, 'None'));
    }
}