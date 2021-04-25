<?php

namespace Api\Services\Otp;

interface OtpVerificationService
{
    public function send(string $phoneNumber);

    public function verify(string $phoneNumber, string $otp);
}