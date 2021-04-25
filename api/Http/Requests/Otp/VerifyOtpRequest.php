<?php

namespace Api\Http\Requests\Otp;

use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "phone_number" => "digits_between:7,13|required",
            "otp" => "digits:4|required",
        ];
    }

}