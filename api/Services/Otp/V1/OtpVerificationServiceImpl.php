<?php

namespace Api\Services\Otp\V1;

use Api\Services\Otp\OtpVerificationService;
use App\Models\PlasmaDonor;
use App\Models\PlasmaDonorVerification;
use GuzzleHttp\Client;
use League\Flysystem\Config;

class OtpVerificationServiceImpl implements OtpVerificationService
{

    public function send(string $phoneNumber)
    {
        $donor = PlasmaDonor::where('phone_number', '=', $phoneNumber)->first();

        abort_unless($donor, "422", "Unable to find user");

        $otp = rand(1000, 9999);

        $gatewayResponse = $this->sendSms($phoneNumber, $otp);

        $data = [
            'donor_id' => $donor->id,
            'phone_number' => $phoneNumber,
            'otp' => $otp,
            'gateway_name' => "speqtra",
            'gateway_response' => $gatewayResponse,
            'verified_at' => null,
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

        abort_if($donor->otp != $otp, 422, "Incorrect OTP");

        $donor->verified_at = now();
        $donor->save();
        $donor->donorData()->update(['verified' => 1]);

        return true;
    }

    private function sendSms(string $phoneNumber, string $otp)
    {
        if (strlen($phoneNumber) > 10) {
            $phoneNumber = substr($phoneNumber, -10);
        }

        $smsProvider = Config::get('sms.speqtra');

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
        $message = Config::get('sms.format.otp');
        $message = $this->str_replace_first("{#var#}", "<#>", $message);
        $message = str_replace("{#var#}", $otp, $message);
        $message = str_replace("{{android_hash}}", Config::get('sms.android_hash'), $message);

        return $message;
    }
}