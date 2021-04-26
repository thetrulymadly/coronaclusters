<?php

namespace Api\Services\Otp\V1;

use Api\Services\Otp\OtpVerificationService;
use App\Models\PlasmaDonor;
use App\Models\PlasmaDonorVerification;
use GuzzleHttp\Client;

class OtpVerificationServiceImpl implements OtpVerificationService
{

    public function send(string $phoneNumber)
    {
        $donor = PlasmaDonor::where('phone_number', '=', $phoneNumber)
            ->where('mobile_verified', '=', '0')
            ->first();

        abort_unless($donor, 422, "Unable to find user");

        $otp = rand(1000, 9999);

        $gatewayResponse = $this->sendSms($phoneNumber, $otp);

        $data = [
            'donor_id' => $donor->id,
            'phone_number' => $phoneNumber,
            'otp' => $otp,
            'gateway_name' => "speqtra",
            'gateway_response' => $gatewayResponse->getBody()->read(1024),
            'verified_at' => null,
            'expires_at' => now()->addMinutes(10),
        ];

        $model = new PlasmaDonorVerification();
        $model->fill($data);
        $model->save();

        return $gatewayResponse->getStatusCode() == 200;

    }

    public function verify(string $phoneNumber, string $otp)
    {
        $donor = PlasmaDonorVerification::where('phone_number', '=', $phoneNumber)
            ->whereNull('verified_at')
            ->orderBy('created_at', 'desc')
            ->first();

        abort_unless($donor, 422, "No user found with this phone number");

        abort_if($donor->expires_at < now(), 422, "Expired OTP. Please request a new");

        abort_if($donor->otp != $otp, 422, "Incorrect OTP");

        $donor->verified_at = now();
        $donor->save();
        $donor->donorData()->update(['mobile_verified' => 1]);

        return true;
    }

    private function sendSms(string $phoneNumber, string $otp)
    {
        if (strlen($phoneNumber) > 10) {
            $phoneNumber = substr($phoneNumber, -10);
        }

        $smsProvider = config('sms.speqtra');

        $client = new Client();
        $response = $client->get($smsProvider["url"],
            [
                'query' => [
                    'api_key' => $smsProvider["api_key"],
                    'method' => "sms",
                    'sender' => $smsProvider["sender"],
                    'to' => $phoneNumber,
                    'message' => $this->getMessage($otp),
                ],
            ]);

        return $response;

    }

    private function getMessage(string $otp)
    {
        $message = config('sms.format.otp');
        $message = str_replace("{#var#}", $otp, $message);

        return $message;
    }
}